<?php

namespace App\Exports;

use App\Models\Addcase;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NeedUpdateCasesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $timezone = 'Asia/Dhaka';
        $today = Carbon::now($timezone)->startOfDay();

        $query = Addcase::whereDate('next_hearing_date', '<=', $today)
            ->where('status', '!=', 0)
            ->where(function($q) {
                $q->where('next_step', 'not like', '%transfer%')
                  ->orWhereNull('next_step');
            })
            ->with('addclient');

        // Apply filters
            if ($this->request->filled('client_name')) {
                $query->whereHas('addclient', function($q) {
                    $q->where('name', 'like', '%' . $this->request->client_name . '%');
                });
            }

        if ($this->request->filled('file_number')) {
            $query->where('file_number', 'like', '%' . $this->request->file_number . '%');
        }

        if ($this->request->filled('case_number')) {
            $query->where('case_number', 'like', '%' . $this->request->case_number . '%');
        }

        if ($this->request->filled('court_name')) {
            $query->where('court_name', 'like', '%' . $this->request->court_name . '%');
        }

        if ($this->request->filled('section')) {
            $query->where('section', 'like', '%' . $this->request->section . '%');
        }

        if ($this->request->filled('from_date')) {
            $query->whereDate('next_hearing_date', '>=', $this->request->from_date);
        }

        if ($this->request->filled('to_date')) {
            $query->whereDate('next_hearing_date', '<=', $this->request->to_date);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        return $query->orderByRaw('CAST(SUBSTRING_INDEX(file_number, "-", -1) AS UNSIGNED)')->get();
    }

    public function headings(): array
    {
        return [
            'SL No',
            'File Number',
            'Client Name',
            'Mobile Number',
            'Parties Name',
            'Court Name',
            'Case Number',
            'Legal Notice Date',
            'Filing Date',
            'Previous Date',
            'Previous Step',
            'Next Hearing Date',
            'Next Step',
            'Status'
        ];
    }

    public function map($case): array
    {
        return [
            $case->id,
            $case->file_number,
            $case->addclient->name ?? 'N/A',
            $case->addclient->number ?? 'N/A',
            $case->name_of_parties,
            $case->court_name,
            $case->case_number,
            $case->legal_notice_date ? Carbon::parse($case->legal_notice_date)->format('d-M-Y') : 'N/A',
            $case->filing_or_received_date ? Carbon::parse($case->filing_or_received_date)->format('d-M-Y') : 'N/A',
            $case->previous_date ? Carbon::parse($case->previous_date)->format('d-M-Y') : 'N/A',
            $case->previous_step,
            $case->next_hearing_date ? Carbon::parse($case->next_hearing_date)->format('d-M-Y') : 'N/A',
            $case->next_step,
            $case->status == 1 ? 'Running' : 'Closed'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:Z' => ['alignment' => ['wrapText' => true]]
        ];
    }
}