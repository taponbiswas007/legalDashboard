<?php

namespace App\Http\Controllers;

use App\Models\AddcaseHistory;
use App\Models\Addclient;
use App\Helpers\InvoiceHelper;
use App\Models\ClientBranch;
use App\Models\Court;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CaseBillController extends Controller
{
    public function index(Request $request)
    {
        $query = AddcaseHistory::query();

        // Get clients and branches first
        $clients = Addclient::select('id', 'name')->orderBy('name')->get();
        $branches = ClientBranch::all();

        // Generate next invoice number (সবসময়)
        $nextInvoiceNo = \App\Helpers\InvoiceHelper::getNextInvoiceNumber();

        // Required: Must include date range - filter by previous_date only
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('previous_date', [
                $request->from_date,
                $request->to_date
            ])
                ->whereNotNull('previous_date')
                ->where('previous_date', '!=', '0000-00-00')
                ->where('previous_date', '!=', '');
        } else {
            // No date = No results
            return view('backendPage.case_history_bill.index', [
                'results' => collect(),
                'clients' => $clients,
                'branches' => $branches,
                'nextInvoiceNo' => $nextInvoiceNo
            ]);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        // Order by previous_date ascending (oldest first)
        $query->orderBy('previous_date', 'asc');

        // Load relations
        $results = $query->with(['client', 'court'])->get();

        // SAME file_no + SAME previous_date হলে শুধু একটিই result নেবে
        $results = $results->unique(function ($item) {
            return $item->file_number . '_' . $item->previous_date;
        });

        // Re-index the collection
        $results = $results->values();

        return view('backendPage.case_history_bill.index', compact('results', 'clients', 'branches', 'nextInvoiceNo'));
    }


    private function numberToWords($num)
    {
        $a = [
            '',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
            'eleven',
            'twelve',
            'thirteen',
            'fourteen',
            'fifteen',
            'sixteen',
            'seventeen',
            'eighteen',
            'nineteen'
        ];

        $b = [
            '',
            '',
            'twenty',
            'thirty',
            'forty',
            'fifty',
            'sixty',
            'seventy',
            'eighty',
            'ninety'
        ];

        if ($num == 0) {
            return "zero";
        }

        $str = "";

        // Crore
        if ($num >= 10000000) {
            $str .= $this->convert3Digit(intval($num / 10000000), $a, $b) . " crore ";
            $num %= 10000000;
        }

        // Lakh
        if ($num >= 100000) {
            $str .= $this->convert3Digit(intval($num / 100000), $a, $b) . " lakh ";
            $num %= 100000;
        }

        // Thousand
        if ($num >= 1000) {
            $str .= $this->convert3Digit(intval($num / 1000), $a, $b) . " thousand ";
            $num %= 1000;
        }

        // Hundreds / Tens / Ones
        if ($num > 0) {
            $str .= $this->convert3Digit($num, $a, $b);
        }

        return trim($str);
    }

    private function convert3Digit($num, $a, $b)
    {
        $num = (int)$num;
        $output = '';

        if ($num > 99) {
            $output .= $a[intval($num / 100)] . ' hundred ';
            $num = $num % 100;
        }

        if ($num > 19) {
            $output .= $b[intval($num / 10)] . ' ' . $a[$num % 10];
        } else {
            $output .= $a[$num];
        }

        return trim($output);
    }



    /**
     * Generate PDF for selected case-history bills.
     *
     * Expects:
     * - steps_data : JSON object where keys are case IDs and values are arrays of steps
     * - jobtitle_data, address_data, subject_data : strings (mapped to blade custom fields)
     */
    public function generatePDF(Request $request)
    {
        // Receive & decode steps
        $stepsJson = $request->input('steps_data', '{}');
        $steps = json_decode($stepsJson, true);

        if (!is_array($steps)) {
            return back()->with('error', 'Invalid step data.');
        }

        // Custom fields (keeping your names exactly as your blade expects)
        $customFields = [
            'jobtitle' => $request->input('jobtitle_data', ''),
            'address' => $request->input('address_data', ''),
            'subject' => $request->input('subject_data', ''),
        ];

        // Extract case IDs from steps
        $caseIds = array_map('intval', array_keys($steps));

        // Load AddcaseHistory with client & court
        $cases = AddcaseHistory::with(['client', 'court'])
            ->whereIn('id', $caseIds)
            ->get()
            ->keyBy('id');

        $totalAmount = 0;
        $finalData = [];

        // Process each case in exact order as user added
        foreach ($caseIds as $id) {

            if (!isset($cases[$id])) continue;

            $case = $cases[$id];
            $caseSteps = $steps[$id] ?? [];

            // Calculate amount for this case
            $sum = 0;
            foreach ($caseSteps as $row) {
                $sum += floatval($row['rate'] ?? 0);
            }

            $totalAmount += $sum;

            // Attach steps + amount per case so Blade can loop easily
            $finalData[] = [
                'case'       => $case,
                'steps'      => $caseSteps,
                'bill_total' => $sum,
            ];
        }

        // Total in words (your controller helper)
        $inWords = ucfirst($this->numberToWords(round($totalAmount))) . ' taka only';

        $data = [
            'items'        => $finalData,   // BEST FORMAT for blade looping
            'customFields' => $customFields,
            'totalAmount'  => $totalAmount,
            'inWords'      => $inWords,
        ];

        // Load your exact blade template (NO CHANGE)
        $pdf = Pdf::loadView('backendPage.case_history_bill.case-pdf-bill', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('case_bill_' . date('Ymd_His') . '.pdf');
    }
}
