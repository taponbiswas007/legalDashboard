<?php

namespace App\Exports;

use App\Models\Addcase;
use App\Models\AddClient;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Crypt;

class ClientCasesExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $clientId;
    protected $filters;
    protected $tab;

    public function __construct($clientId, $filters)
    {
        $this->clientId = $clientId;
        $this->filters = $filters;
        $this->tab = $filters['tab'] ?? 'running';
    }

    public function collection()
    {
        $query = Addcase::where('client_id', $this->clientId);

        // Apply filters
        foreach (['file_number','name_of_parties','court_name','case_number','section'] as $field) {
            if (!empty($this->filters[$field])) {
                $query->where($field, 'like', "%{$this->filters[$field]}%");
            }
        }

        foreach (['legal_notice_date','filing_or_received_date','previous_date','next_hearing_date'] as $dateField) {
            if (!empty($this->filters[$dateField])) {
                $query->whereDate($dateField, $this->filters[$dateField]);
            }
        }

        // Determine which cases to show
        if ($this->tab === 'disposal') {
            $query->where('status', 0);
        } else {
            $query->where('status', 1);
        }

        $cases = $query->get([
            'file_number',
            'name_of_parties',
            'court_name',
            'case_number',
            'section',
            'legal_notice_date',
            'filing_or_received_date',
            'previous_date',
            'next_hearing_date',
            'status',
        ]);

        // Format data
        return $cases->map(function ($case) {
            return [
                'File Number' => $case->file_number,
                'Name of Parties' => $case->name_of_parties,
                'Court Name' => $case->court_name,
                'Case Number' => $case->case_number,
                'Section' => $case->section,
                'Legal Notice Date' => optional($case->legal_notice_date)->format('d-M-Y'),
                'Filing/Received Date' => optional($case->filing_or_received_date)->format('d-M-Y'),
                'Previous Date' => optional($case->previous_date)->format('d-M-Y'),
                'Next Hearing Date' => optional($case->next_hearing_date)->format('d-M-Y'),
                'Status' => $case->status == 1 ? 'Running' : 'Disposal',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'File Number',
            'Name of Parties',
            'Court Name',
            'Case Number',
            'Section',
            'Legal Notice Date',
            'Filing/Received Date',
            'Previous Date',
            'Next Hearing Date',
            'Status',
        ];
    }

    public function title(): string
    {
        return ucfirst($this->tab) . ' Cases';
    }
}
