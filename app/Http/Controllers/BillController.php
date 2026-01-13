<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillStep;
use App\Models\Addclient;
use App\Models\ClientBranch;
use App\Models\AddcaseHistory;
use App\Models\InvoiceNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class BillController extends Controller
{
    public function casebilllist()
    {
        $bills = Bill::with(['client', 'clientbranch'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backendPage.case_history_bill.case-bill-list', compact('bills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'steps_data' => 'required|string',
            'client_id' => 'nullable|integer|exists:addclients,id',
            'branch_id' => 'nullable|integer',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'jobtitle_data' => 'nullable|string|max:255',
            'address_data' => 'nullable|string|max:255',
            'subject_data' => 'nullable|string|max:255',
        ]);

        $stepsData = json_decode($request->steps_data, true);

        if (!is_array($stepsData) || empty($stepsData)) {
            return back()->with('error', 'Invalid or empty steps data.');
        }

        DB::beginTransaction();
        try {
            // ============================
            // 1. Calculate Total Amount
            // ============================
            $total = 0;
            foreach ($stepsData as $step) {
                $rate = isset($step['rate']) ? (float)str_replace(',', '', $step['rate']) : 0;
                $total += $rate;
            }

            // ============================
            // 2. Generate Invoice Number (WITH DUPLICATE CHECK)
            // ============================
            $year = date('Y');
            $month = date('m');

            // Get the last invoice number for this month
            $lastBill = Bill::where('invoice_number', 'like', "INV-{$year}-{$month}-%")
                ->orderBy('id', 'desc')
                ->first();

            if ($lastBill) {
                // Extract last number and increment
                $lastNumber = (int) substr($lastBill->invoice_number, -5);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $invoiceNumber = "INV-{$year}-{$month}-" . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Double check if invoice number exists
            $existingBill = Bill::where('invoice_number', $invoiceNumber)->first();
            if ($existingBill) {
                $nextNumber++;
                $invoiceNumber = "INV-{$year}-{$month}-" . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            }

            // ============================
            // 3. Create Bill
            // ============================
            $bill = Bill::create([
                'client_id' => $request->client_id,
                'branch_id' => $request->branch_id,
                'invoice_number' => $invoiceNumber,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'total_amount' => $total,
                'jobtitle' => $request->jobtitle_data,
                'address' => $request->address_data,
                'subject' => $request->subject_data,
            ]);

            // ============================
            // 4. Save Steps with Case Number
            // ============================
            // ============================
            // 4. Save Steps with Case Number (Array version)
            // ============================
            // BillController-এর store method-এ
            foreach ($stepsData as $step) {
                if (!isset($step['name']) || trim($step['name']) === '') {
                    continue;
                }

                // Find case by database ID
                $caseHistory = null;
                if (isset($step['case_db_id'])) {
                    $caseHistory = AddcaseHistory::find($step['case_db_id']);
                }

                BillStep::create([
                    'bill_id' => $bill->id,
                    'case_id' => $caseHistory ? $caseHistory->id : null,
                    'case_number' => $step['case_number'] ?? null,
                    'hearing_date' => $step['hearing_date'] ?? null, // hearing date সংরক্ষণ
                    'step_name' => $step['name'],
                    'rate' => (float)str_replace(',', '', $step['rate'] ?? 0),
                ]);
            }

            // ============================
            // 5. Update Invoice Number Counter (if using InvoiceNumber model)
            // ============================
            $invoiceRecord = InvoiceNumber::first();
            if ($invoiceRecord) {
                $invoiceRecord->last_number = $nextNumber;
                $invoiceRecord->save();
            }

            DB::commit();

            // ============================
            // 6. Redirect to Preview Page
            // ============================
            return redirect()->route('bill.preview', $bill->id)
                ->with('success', 'Bill generated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bill Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save bill: ' . $e->getMessage());
        }
    }

    // public function preview($billId)
    // {
    //     $bill = Bill::with(['client', 'steps'])->findOrFail($billId);
    //     return view('backendPage.case_history_bill.preview', compact('bill'));
    // }
    public function preview($billId)
    {
        $bill = Bill::with([
            'client',
            'clientbranch',
            'steps' => function ($query) {
                $query->join('addcase_history', 'bill_steps.case_id', '=', 'addcase_history.id')
                    ->orderBy('addcase_history.previous_date', 'asc')
                    ->select('bill_steps.*');
            },
            'steps.caseDetails',
            'steps.caseDetails.clientbranch',
            'steps.caseDetails.court',
        ])->findOrFail($billId);

        return view('backendPage.case_history_bill.preview', compact('bill'));
    }



    public function edit(Bill $bill)
    {
        try {
            // Bill এর সাথে সম্পর্কিত সব data load করুন
            $bill->load(['client', 'clientbranch', 'steps.caseDetails']);

            // Filter এর জন্য必要な data
            $clients = Addclient::all();
            $branches = ClientBranch::all();

            // Get unique case numbers from bill steps
            $caseNumbersFromBill = $bill->steps->pluck('case_number')->unique()->filter()->toArray();

            // Case histories for the cases that are actually in the bill
            $caseHistories = AddcaseHistory::whereIn('case_number', $caseNumbersFromBill)
                ->where('client_id', $bill->client_id)
                ->when($bill->branch_id, function ($query) use ($bill) {
                    return $query->where('branch_id', $bill->branch_id);
                })
                ->orderBy('previous_date', 'asc') // Order by previous_date ascending (oldest first)
                ->with(['client', 'court'])
                ->get();

            return view('backendPage.case_history_bill.edit', compact('bill', 'clients', 'branches', 'caseHistories'));
        } catch (\Exception $e) {
            Log::error('Bill Edit Error: ' . $e->getMessage());
            return redirect()->route('case_bill.list')
                ->with('error', 'Failed to load bill for editing: ' . $e->getMessage());
        }
    }
    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'steps_data' => 'required|string',
            'jobtitle_data' => 'nullable|string|max:255',
            'address_data' => 'nullable|string|max:255',
            'subject_data' => 'nullable|string|max:255',
        ]);

        $stepsData = json_decode($request->steps_data, true);

        if (!is_array($stepsData) || empty($stepsData)) {
            return back()->with('error', 'Invalid or empty steps data.');
        }

        DB::beginTransaction();
        try {
            // ============================
            // 1. Calculate Total Amount
            // ============================
            $total = 0;
            foreach ($stepsData as $step) {
                $rate = isset($step['rate']) ? (float)str_replace(',', '', $step['rate']) : 0;
                $total += $rate;
            }

            // ============================
            // 2. Update Bill
            // ============================
            $bill->update([
                'total_amount' => $total,
                'jobtitle' => $request->jobtitle_data,
                'address' => $request->address_data,
                'subject' => $request->subject_data,
            ]);

            // ============================
            // 3. Delete existing steps and create new ones
            // ============================
            BillStep::where('bill_id', $bill->id)->delete();

            foreach ($stepsData as $step) {
                if (!isset($step['name']) || trim($step['name']) === '') {
                    continue;
                }

                // Find case by database ID
                $caseHistory = null;
                if (isset($step['case_db_id'])) {
                    $caseHistory = AddcaseHistory::find($step['case_db_id']);
                }

                BillStep::create([
                    'bill_id' => $bill->id,
                    'case_id' => $caseHistory ? $caseHistory->id : null,
                    'case_number' => $step['case_number'] ?? null,
                    'hearing_date' => $step['hearing_date'] ?? null,
                    'step_name' => $step['name'],
                    'rate' => (float)str_replace(',', '', $step['rate'] ?? 0),
                ]);
            }

            DB::commit();

            return redirect()->route('bill.preview', $bill->id)
                ->with('success', 'Bill updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bill Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update bill: ' . $e->getMessage());
        }
    }

    public function destroy(Bill $bill)
    {
        DB::beginTransaction();
        try {
            // ============================
            // 1. Delete related bill steps first
            // ============================
            BillStep::where('bill_id', $bill->id)->delete();

            // ============================
            // 2. Delete the bill
            // ============================
            $invoiceNumber = $bill->invoice_number;
            $bill->delete();

            DB::commit();

            return redirect()->route('case_bill.list')
                ->with('success', "Bill {$invoiceNumber} has been deleted successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bill Deletion Error: ' . $e->getMessage());

            return redirect()->route('case_bill.list')
                ->with('error', 'Failed to delete bill: ' . $e->getMessage());
        }
    }

    public function downloadPdf($billId)
    {
        try {
            $bill = Bill::with([
                'client',
                'clientbranch',
                'steps' => function ($query) {
                    $query->join('addcase_history', 'bill_steps.case_id', '=', 'addcase_history.id')
                        ->orderBy('addcase_history.previous_date', 'asc')
                        ->select('bill_steps.*');
                },
                'steps.caseDetails.clientbranch',
                'steps.caseDetails.court'
            ])->findOrFail($billId);

            // Generate PDF
            $pdf = PDF::loadView('backendPage.case_history_bill.case-pdf-bill', compact('bill'));

            // Set paper size and orientation
            $pdf->setPaper('A4', 'portrait');

            $filename = 'bill_' . $bill->invoice_number . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('PDF Download Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    /**
     * View PDF in browser
     */
    public function viewPdf($billId)
    {
        try {
            $bill = Bill::with([
                'client',
                'clientbranch',
                'steps' => function ($query) {
                    $query->join('addcase_history', 'bill_steps.case_id', '=', 'addcase_history.id')
                        ->orderBy('addcase_history.previous_date', 'asc')
                        ->select('bill_steps.*');
                },
                'steps.caseDetails.clientbranch',
                'steps.caseDetails.court'
            ])->findOrFail($billId);

            $pdf = PDF::loadView('backendPage.case_history_bill.case-pdf-bill', compact('bill'));
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('bill_' . $bill->invoice_number . '.pdf');
        } catch (\Exception $e) {
            Log::error('PDF View Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
}
