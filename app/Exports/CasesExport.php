<?php

namespace App\Exports;

use App\Models\Addcase;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CasesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Addcase::query()->with(['addclient', 'court']);
        
        // Apply filters
        if (!empty($this->filters['file_number'])) {
            $query->where('file_number', 'like', '%' . $this->filters['file_number'] . '%');
        }
        
        if (!empty($this->filters['client_id'])) {
            $query->where('client_id', $this->filters['client_id']);
        }
        
        if (!empty($this->filters['branch_id'])) {
            $query->where('branch_id', $this->filters['branch_id']);
        }
        
        if (!empty($this->filters['name_of_parties'])) {
            $query->where('name_of_parties', 'like', '%' . $this->filters['name_of_parties'] . '%');
        }
        
        if (!empty($this->filters['case_number'])) {
            $query->where('case_number', 'like', '%' . $this->filters['case_number'] . '%');
        }
        
        if (!empty($this->filters['filing_or_received_date'])) {
            $query->where('filing_or_received_date', 'like', '%' . $this->filters['filing_or_received_date'] . '%');
        }
        
        if (!empty($this->filters['court_id'])) {
            $query->where('court_id', $this->filters['court_id']);
        }
        
        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            $query->where('status', $this->filters['status']);
        }
        
        if (!empty($this->filters['legal_notice_date_from'])) {
            $query->whereDate('legal_notice_date', '>=', $this->filters['legal_notice_date_from']);
        }
        
        if (!empty($this->filters['legal_notice_date_to'])) {
            $query->whereDate('legal_notice_date', '<=', $this->filters['legal_notice_date_to']);
        }
        
        if (!empty($this->filters['next_hearing_date_from'])) {
            $query->whereDate('next_hearing_date', '>=', $this->filters['next_hearing_date_from']);
        }
        
        if (!empty($this->filters['next_hearing_date_to'])) {
            $query->whereDate('next_hearing_date', '<=', $this->filters['next_hearing_date_to']);
        }
        
        return $query->orderByRaw('CAST(file_number AS UNSIGNED) ASC')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'File Number',
            'Client Name',
            'Client Mobile',
            'Branch',
            'Loan Account/Acquest CIN',
            'Parties Involved',
            'Court Name',
            'Case Number',
            'Section',
            'Legal Notice Date',
            'Filing/Received Date',
            'Previous Date',
            'Previous Step',
            'Next Hearing Date',
            'Next Step',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

    public function map($case): array
    {
        return [
            $case->id,
            $case->file_number,
            $case->addclient->name ?? 'N/A',
            $case->addclient->number ?? 'N/A',
            $case->branch,
            $case->loan_account_acquest_cin,
            $case->name_of_parties,
            $case->court->name ?? 'N/A',
            $case->case_number,
            $case->section,
            $case->legal_notice_date ? date('d-m-Y', strtotime($case->legal_notice_date)) : 'N/A',
            $case->filing_or_received_date ? date('d-m-Y', strtotime($case->filing_or_received_date)) : 'N/A',
            $case->previous_date ? date('d-m-Y', strtotime($case->previous_date)) : 'N/A',
            $case->previous_step,
            $case->next_hearing_date ? date('d-m-Y', strtotime($case->next_hearing_date)) : 'N/A',
            $case->next_step,
            $case->status == 1 ? 'Running' : 'Dismissed',
            $case->created_at ? date('d-m-Y H:i', strtotime($case->created_at)) : 'N/A',
            $case->updated_at ? date('d-m-Y H:i', strtotime($case->updated_at)) : 'N/A'
        ];
    }
}