<?php

namespace App\Http\Controllers;

use App\Models\LegalNotice;
use App\Models\Addclient;
use App\Models\ClientBranch;
use App\Models\LegalNoticeCategory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\LegalNoticesImport;
use App\Exports\LegalNoticeExport; // Add this for Excel export
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LegalNoticeBill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class LegalNoticeController extends Controller
{
    /**
     * Auto-generate and download the latest bill PDF for a bill.
     */
    public function autoGenerateBillPdf($id)
    {
        $bill = LegalNoticeBill::with(['client', 'items.legalnotice', 'items.legalnotice.category', 'client.branch'])->findOrFail($id);

        // Gather all legal notices for this bill
        $legalnotices = collect();
        foreach ($bill->items as $item) {
            if ($item->legalnotice) {
                $notice = $item->legalnotice;
                $notice->bill_amount = $item->amount;
                $legalnotices->push($notice);
            }
        }

        // Custom fields for the PDF (jobTitle, address, subject)
        $customFields = is_array($bill->custom_fields)
            ? $bill->custom_fields
            : json_decode($bill->custom_fields, true) ?? [];

        $customFields['jobTitle'] = $customFields['jobTitle'] ?? $bill->job_title ?? '';
        $customFields['subject']  = $customFields['subject'] ?? $bill->subject ?? '';
        $customFields['address']  = $customFields['address'] ?? $bill->address ?? '';

        $pdf = PDF::loadView('backendPage.legalnotice.bill_pdf', [
            'legalnotices' => $legalnotices,
            'totalAmount' => $bill->total_amount,
            'filters' => $bill->filters ?? [],
            'customFields' => $customFields,
        ])->setPaper('a4', 'portrait');

        $fileName = 'legal-bill-' . $bill->id . '-' . now()->format('YmdHis') . '.pdf';

        return $pdf->download($fileName);
    }




    /**
     * Show the form for editing a bill.
     */
    public function editBill($id)
    {
        $bill = LegalNoticeBill::with(['client', 'items'])->findOrFail($id);
        // Only show legal notices for this client that are not already billed in this bill
        $billedNoticeIds = $bill->items->pluck('reference_id')->filter()->all();
        $availableLegalNotices = \App\Models\LegalNotice::where('client_id', $bill->client_id)
            ->whereNotIn('id', $billedNoticeIds)
            ->with('category')
            ->get();
        return view('backendPage.legalnotice.legal_bill_edit', compact('bill', 'availableLegalNotices'));
    }

    /**
     * Update the specified bill in storage.
     */
    public function updateBill(Request $request, $id)
    {
        $bill = LegalNoticeBill::with('items')->findOrFail($id);
        $request->validate([
            'bill_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'items' => 'array',
            'items.*.amount' => 'required|numeric',
        ]);


        $bill->bill_date = $request->bill_date;
        $bill->total_amount = $request->total_amount;

        // Custom fields update (force lower-case for jobTitle and subject, null for empty address)
        $customFields = [
            'jobTitle' => $request->job_title !== '' ? strtolower($request->job_title) : null,
            'address' => $request->address !== '' ? $request->address : null,
            'subject' => $request->subject !== '' ? strtolower($request->subject) : null,
        ];
        $bill->custom_fields = $customFields;

        $bill->save();

        // Update existing bill items
        $existingItemIds = [];
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $itemData) {
                $item = $bill->items->where('id', $itemId)->first();
                if ($item) {
                    $item->description = $itemData['description'] ?? $item->description;
                    $item->amount = $itemData['amount'];
                    $item->type = $itemData['type'] ?? null;
                    $item->notes = $itemData['notes'] ?? null;
                    $item->save();
                    $existingItemIds[] = $item->id;
                }
            }
        }

        // Delete removed items
        foreach ($bill->items as $item) {
            if (!in_array($item->id, $existingItemIds)) {
                $item->delete();
            }
        }

        // Add new items
        if ($request->has('new_items')) {
            foreach ($request->new_items as $newItem) {
                if (!empty($newItem['description']) && isset($newItem['amount'])) {
                    $bill->items()->create([
                        'description' => $newItem['description'],
                        'amount' => $newItem['amount'],
                        'type' => $newItem['type'] ?? null,
                        'notes' => $newItem['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('legalnotice.bills.index')->with('success', 'Bill updated successfully.');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LegalNotice::with(['client', 'category']);

        // Apply filters with specific logic
        if ($request->filled('client_id') && $request->filled('category_id')) {
            // When both client and category are selected, show records that match BOTH
            $query->where('client_id', $request->client_id)
                ->where('notice_category_id', $request->category_id);
        } elseif ($request->filled('client_id')) {
            // When only client is selected, show all records for that client
            $query->where('client_id', $request->client_id);
        } elseif ($request->filled('category_id')) {
            // When only category is selected, show all records for that category
            $query->where('notice_category_id', $request->category_id);
        }

        // ✅ NEW: Branch filter
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // ✅ NEW: Loan A/C / CIN filter
        if ($request->filled('loan_account_acquest_cin')) {
            $query->where('loan_account_acquest_cin', 'LIKE', '%' . $request->loan_account_acquest_cin . '%');
        }


        // Date range filter (AND with other filters)
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('legal_notice_date', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->where('legal_notice_date', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->where('legal_notice_date', '<=', $request->date_to);
        }

        // ✅ NEW: Branch filter
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // ✅ NEW: Loan A/C / CIN filter
        if ($request->filled('loan_account_acquest_cin')) {
            $query->where('loan_account_acquest_cin', 'LIKE', '%' . $request->loan_account_acquest_cin . '%');
        }

        // Status filter (AND with other filters)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $legalnotices = $query->latest()->paginate(20);

        $clients = Addclient::all();
        $categories = LegalNoticeCategory::all();
        $branches = ClientBranch::all();
        return view('backendPage.legalnotice.index', compact('legalnotices', 'clients', 'categories', 'branches'));
    }

    public function exportPdf(Request $request)
    {
        $query = LegalNotice::with(['client', 'category']);

        // Apply the same filter logic as index
        if ($request->filled('client_id') && $request->filled('category_id')) {
            $query->where('client_id', $request->client_id)
                ->where('notice_category_id', $request->category_id);
        } elseif ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        } elseif ($request->filled('category_id')) {
            $query->where('notice_category_id', $request->category_id);
        }

        // Date range filter
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('legal_notice_date', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->where('legal_notice_date', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->where('legal_notice_date', '<=', $request->date_to);
        }

        // ✅ NEW: Branch filter
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
        // ✅ NEW: Loan A/C / CIN filter
        if ($request->filled('loan_account_acquest_cin')) {
            $query->where('loan_account_acquest_cin', 'LIKE', '%' . $request->loan_account_acquest_cin . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $legalnotices = $query->latest()->get();

        // Get clients and categories for filter display
        $clients = AddClient::all();
        $categories = LegalNoticeCategory::all();

        $pdf = PDF::loadView('backendPage.legalnotice.pdf', compact('legalnotices', 'clients', 'categories'))->setPaper('a4', 'landscape');

        return $pdf->download('legal-notices-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LegalNoticeExport($request), 'legal-notices-' . date('Y-m-d') . '.xlsx');
    }

    /**export bill*/

    public function legalnoticebill(Request $request)
    {
        $query = LegalNotice::with(['client', 'category']);

        // Apply filters
        if ($request->filled('client_id') && $request->filled('category_id')) {
            $query->where('client_id', $request->client_id)
                ->where('notice_category_id', $request->category_id);
        } elseif ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        } elseif ($request->filled('category_id')) {
            $query->where('notice_category_id', $request->category_id);
        }

        // Date range filter
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('legal_notice_date', [$request->date_from, $request->date_to]);
        } elseif ($request->filled('date_from')) {
            $query->where('legal_notice_date', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->where('legal_notice_date', '<=', $request->date_to);
        }


        // Branch filter
        if ($request->filled('branch')) {
            $query->where('branch_id', $request->branch);
        }


        // ✅ NEW: Loan A/C / CIN filter
        if ($request->filled('loan_account_acquest_cin')) {
            $query->where('loan_account_acquest_cin', 'LIKE', '%' . $request->loan_account_acquest_cin . '%');
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $legalnotices = $query->latest()->get();

        $clients = AddClient::all();
        $categories = LegalNoticeCategory::all();
        $branches = ClientBranch::all();

        return view('backendPage.legalnotice.bill', compact('legalnotices', 'clients', 'categories', 'branches'));
    }
    // LegalNoticeController.php এ এই function যোগ করুন
    public static function numberToWords($number)
    {
        // Same English number to words function as in JavaScript
        // Copy the JavaScript function logic to PHP
        $units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        if ($number == 0) return 'Zero';

        $words = '';

        // Taka part
        $taka = floor($number);
        if ($taka > 0) {
            $words .= self::convertNumberToWords($taka) . ' Taka';
        }

        // Poisha part
        $poisha = round(($number - $taka) * 100);
        if ($poisha > 0) {
            if ($words != '') $words .= ' and ';
            $words .= self::convertNumberToWords($poisha) . ' Poisha';
        }

        return $words . ' Only';
    }

    private static function convertNumberToWords($number)
    {
        $units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
        $teens = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
        $tens = ['', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        if ($number == 0) return '';

        $output = '';

        if ($number >= 10000000) {
            $output .= self::convertNumberToWords(floor($number / 10000000)) . ' Crore ';
            $number %= 10000000;
        }

        if ($number >= 100000) {
            $output .= self::convertNumberToWords(floor($number / 100000)) . ' Lakh ';
            $number %= 100000;
        }

        if ($number >= 1000) {
            $output .= self::convertNumberToWords(floor($number / 1000)) . ' Thousand ';
            $number %= 1000;
        }

        if ($number >= 100) {
            $output .= self::convertNumberToWords(floor($number / 100)) . ' Hundred ';
            $number %= 100;
        }

        if ($number > 0) {
            if ($output != '') $output .= 'and ';

            if ($number < 10) {
                $output .= $units[$number];
            } else if ($number < 20) {
                $output .= $teens[$number - 10];
            } else {
                $output .= $tens[floor($number / 10)];
                if ($number % 10 > 0) {
                    $output .= ' ' . $units[$number % 10];
                }
            }
        }

        return trim($output);
    }


    public function generateBillPdf(Request $request)
    {
        try {

            $amounts = $request->amounts;
            $filters = $request->filters;
            $customFields = $request->customFields;

            $query = LegalNotice::with(['client', 'category']);

            if (!empty($filters['client_id'])) {
                $query->where('client_id', $filters['client_id']);
            }
            if (!empty($filters['category_id'])) {
                $query->where('notice_category_id', $filters['category_id']);
            }
            if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
                $query->whereBetween('legal_notice_date', [$filters['date_from'], $filters['date_to']]);
            }
            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            $legalnotices = $query->get();


            $totalAmount = 0;
            $billItems = [];
            foreach ($legalnotices as $notice) {
                $billAmount = $amounts[$notice->id] ?? 0;
                $notice->bill_amount = $billAmount;
                $totalAmount += $billAmount;
                // Prepare bill item for each notice
                $billItems[] = [
                    'type' => 'legal_notice',
                    'reference_id' => $notice->id,
                    'description' => $notice->name ?? ($notice->subject ?? 'Legal Notice'),
                    'amount' => $billAmount,
                    'notes' => null,
                ];
            }

            $pdf = PDF::loadView('backendPage.legalnotice.bill_pdf', [
                'legalnotices' => $legalnotices,
                'totalAmount' => $totalAmount,
                'filters' => $filters,
                'customFields' => $customFields
            ])->setPaper('a4', 'portrait');

            // 🔹 File path (client-wise + date-wise)
            $clientId = $filters['client_id'] ?? 'all';
            $date = now()->format('Y-m-d');

            // Check for existing bill (by client, date, total, and custom fields)
            $existingBill = LegalNoticeBill::where('client_id', $filters['client_id'])
                ->where('bill_date', $date)
                ->where('total_amount', $totalAmount)
                ->where('custom_fields', json_encode($customFields))
                ->first();

            if ($existingBill) {
                // চাইলে আগের bill-এর PDF ডাউনলোড করাতে পারেন
                return response()->download(storage_path("app/public/{$existingBill->pdf_path}"));
            }

            $fileName = "legal-bill-{$clientId}-{$date}-" . time() . ".pdf";
            $path = "legal-bills/{$clientId}/{$fileName}";

            // 🔹 Save PDF
            Storage::disk('public')->put($path, $pdf->output());

            // 🔹 Save to DB
            $bill = LegalNoticeBill::create([
                'client_id'    => $filters['client_id'],
                'bill_date'    => $date,
                'total_amount' => $totalAmount,
                'pdf_path'     => $path,
                'filters'      => $filters,
                'custom_fields' => $customFields,
            ]);

            // Save bill items
            foreach ($billItems as $item) {
                $bill->items()->create($item);
            }

            // চাইলে সাথে সাথে download
            return response()->download(storage_path("app/public/{$path}"));
        } catch (\Exception $e) {
            Log::error('PDF Generation Failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'PDF generate failed');
        }
    }
    public function billIndex(Request $request)
    {
        $bills = LegalNoticeBill::with('client')
            ->when($request->client_id, function ($q) use ($request) {
                $q->where('client_id', $request->client_id);
            })
            ->when($request->date_from && $request->date_to, function ($q) use ($request) {
                $q->whereBetween('bill_date', [$request->date_from, $request->date_to]);
            })
            ->latest()
            ->paginate(15);

        $clients = Addclient::orderBy('name')->get();

        return view('backendPage.legalnotice.bill_list', compact('bills', 'clients'));
    }
    public function downloadBill($id)
    {
        $bill = LegalNoticeBill::findOrFail($id);

        $filePath = storage_path('app/public/' . $bill->pdf_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'PDF file not found on server.');
        }

        return response()->download($filePath);
    }
    public function previewBill($id)
    {
        $bill = LegalNoticeBill::findOrFail($id);

        $filePath = storage_path('app/public/' . $bill->pdf_path);

        if (!file_exists($filePath)) {
            abort(404, 'PDF file not found');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="bill-preview.pdf"',
        ]);
    }
    public function deleteBill($id)
    {
        try {
            $bill = LegalNoticeBill::findOrFail($id);

            // 🔴 Delete PDF file
            if ($bill->pdf_path && Storage::disk('public')->exists($bill->pdf_path)) {
                Storage::disk('public')->delete($bill->pdf_path);
            }

            // 🔴 Delete DB record
            $bill->delete();

            return redirect()
                ->route('legalnotice.bills.index')
                ->with('success', 'Bill deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete bill');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Addclient::all();
        $categories = LegalNoticeCategory::all();
        $branches = ClientBranch::all();
        return view('backendPage.legalnotice.create', compact('clients', 'categories', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id'            => 'required|exists:addclients,id',
            'branch_id'                => 'nullable|exists:client_branches,id',
            'loan_account_acquest_cin' => 'nullable|string',
            'notice_category_id'   => 'required|exists:legal_notice_categories,id',
            'legal_notice_date'    => 'required|date',
            'name'                 => 'required|string|max:255',
            'dateline_for_filing'  => 'nullable|date',
            'comments'             => 'nullable|string',
            'status'               => 'required|in:Running,Done,Reject',
        ]);

        // Set default status to "Running" if not provided or empty
        $status = $request->status;
        if (empty($status)) {
            $status = 'Running';
        }

        LegalNotice::create([
            'client_id' => $request->client_id,
            'branch_id' => $request->branch_id,
            'loan_account_acquest_cin' => $request->loan_account_acquest_cin,
            'notice_category_id' => $request->notice_category_id,
            'legal_notice_date' => $request->legal_notice_date,
            'name' => $request->name,
            'dateline_for_filing' => $request->dateline_for_filing,
            'comments' => $request->comments,
            'status' => $status,
        ]);

        return redirect()->route('legalnotice.index')
            ->with('success', 'Legal notice created successfully.');
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        try {
            $notice = LegalNotice::with(['client', 'category'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'notice' => $notice
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ]);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $legalNotice = LegalNotice::findOrFail($id);

        $request->validate([
            'client_id'            => 'required|exists:addclients,id',
            'branch_id'                => 'nullable|exists:client_branches,id',
            'loan_account_acquest_cin' => 'nullable|string',
            'notice_category_id'   => 'required|exists:legal_notice_categories,id',
            'legal_notice_date'    => 'required|date',
            'name'                 => 'required|string|max:255',
            'dateline_for_filing'  => 'nullable|date',
            'comments'             => 'nullable|string',
            'status'               => 'required|in:Running,Done,Reject',
        ]);

        $legalNotice->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Legal notice updated successfully.'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $notice = LegalNotice::findOrFail($id);
            $oldStatus = $notice->status;
            $notice->status = $request->status;
            $notice->save();

            return response()->json([
                'success' => true,
                'oldStatus' => $oldStatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'oldStatus' => $oldStatus ?? 'Running'
            ]);
        }
    }

    public function edit($id)
    {
        try {
            $notice = LegalNotice::with(['client', 'category', 'clientbranch'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'notice' => $notice
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $legalNotice = LegalNotice::findOrFail($id);
            $legalNotice->delete();

            return response()->json([
                'success' => true,
                'message' => 'Legal notice deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete legal notice.'
            ], 500);
        }
    }

    public function downloadTemplate()
    {
        try {
            // Create template data matching your exact Excel format
            // Note: Client, Branch, and Category/Section are selected from modal, not in Excel
            $templateData = [
                ['Loan A/C, Acquest CIN', 'Name of Acquest', 'Notice Date', 'Dateline', 'Comments', 'Status']
            ];

            // Sample data with proper examples
            $sampleData = [
                ['LN-123456', 'John Doe vs ABC Corporation Ltd', '2024-01-15', '2024-02-15', 'Money recovery case', 'Running'],
                ['CIN-789012', 'Jane Smith vs XYZ Industries', '2024-01-20', '2024-02-20', 'Cheque dishonor case', 'Done'],
                ['ACQ-345678', 'Michael Brown vs DEF Company', '2024-01-25', '', 'No additional comments', 'Running']
            ];

            $templateData = array_merge($templateData, $sampleData);

            $fileName = 'legal_notice_import_template.xlsx';

            return Excel::download(new class($templateData) implements \Maatwebsite\Excel\Concerns\FromArray {
                private $data;

                public function __construct($data)
                {
                    $this->data = $data;
                }

                public function array(): array
                {
                    return $this->data;
                }
            }, $fileName);
        } catch (\Exception $e) {
            Log::error('Template download error: ' . $e->getMessage());
            return back()->with('error', 'Template download failed: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
            'client_id' => 'required|exists:addclients,id',
            'branch_id' => 'nullable|exists:client_branches,id',
            'notice_category_id' => 'required|exists:legal_notice_categories,id'
        ]);

        try {
            $import = new LegalNoticesImport(
                $request->client_id,
                $request->branch_id,
                $request->notice_category_id
            );

            Excel::import($import, $request->file('excel_file'));

            return response()->json([
                'success' => true,
                'message' => 'Data imported successfully',
                'total_records' => $import->getRowCount(),
                'imported_count' => $import->getImportedCount(),
                'skipped_count' => $import->getSkippedCount(),
                'errors' => $import->getErrors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
                'errors' => []
            ], 500);
        }
    }
}
