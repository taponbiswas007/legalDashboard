<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addcase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CasesExport;

class CaseExportController extends Controller
{
    // 🧾 Auto-Paginated PDF Export
    public function exportPdf(Request $request)
    {
        ini_set('memory_limit', '4096M');
        ini_set('max_execution_time', 600);

        $query = Addcase::query()->with('addclient');

        // Apply filters
        if ($request->filled('file_number')) {
        $query->where('file_number', 'like', '%' . $request->file_number . '%');
    }
     if ($request->filled('client_id')) {
        $query->where('client_id', $request->client_id);
    }
     if ($request->filled('branch_id')) {
        $query->where('branch_id', $request->branch_id);
    }
    if ($request->filled('name_of_parties')) {
        $query->where('name_of_parties', 'like', '%' . $request->name_of_parties . '%');
    }
    if ($request->filled('case_number')) {
        $query->where('case_number', 'like', '%' . $request->case_number . '%');
    }
     if ($request->filled('filing_or_received_date')) {
        $query->where('filing_or_received_date', 'like', '%' . $request->filing_or_received_date . '%');
    }
    
    if ($request->filled('court_id')) {
        $query->where('court_id', $request->court_id);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    if ($request->filled('legal_notice_date_from')) {
        $query->whereDate('legal_notice_date', '>=', $request->legal_notice_date_from);
    }
    if ($request->filled('legal_notice_date_to')) {
        $query->whereDate('legal_notice_date', '<=', $request->legal_notice_date_to);
    }
    if ($request->filled('next_hearing_date_from')) {
        $query->whereDate('next_hearing_date', '>=', $request->next_hearing_date_from);
    }
    if ($request->filled('next_hearing_date_to')) {
        $query->whereDate('next_hearing_date', '<=', $request->next_hearing_date_to);
    }

        $cases = $query->orderByRaw('CAST(file_number AS UNSIGNED) ASC')->get();

        // 🧩 Split the collection into chunks (e.g. 500 per page)
        $chunks = $cases->chunk(500);

        // 🧾 Load view with multiple chunks
        $pdf = Pdf::loadView('backendPage.addcase.export_pdf', compact('chunks'))
            ->setPaper('legal', 'landscape');

        return $pdf->download('cases_paginated.pdf');
    }

    // Excel Export (same as before)
    public function exportExcel(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new CasesExport($filters), 'cases.xlsx');
    }
}
