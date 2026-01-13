<?php

namespace App\Exports;

use App\Models\LegalNotice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LegalNoticeExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = LegalNotice::with(['client', 'category']);

        // Apply filters
        if ($this->request->filled('client_id') && $this->request->filled('category_id')) {
            $query->where('client_id', $this->request->client_id)
                  ->where('notice_category_id', $this->request->category_id);
        } elseif ($this->request->filled('client_id')) {
            $query->where('client_id', $this->request->client_id);
        } elseif ($this->request->filled('category_id')) {
            $query->where('notice_category_id', $this->request->category_id);
        }

        if ($this->request->filled('date_from') && $this->request->filled('date_to')) {
            $query->whereBetween('legal_notice_date', [$this->request->date_from, $this->request->date_to]);
        } elseif ($this->request->filled('date_from')) {
            $query->where('legal_notice_date', '>=', $this->request->date_from);
        } elseif ($this->request->filled('date_to')) {
            $query->where('legal_notice_date', '<=', $this->request->date_to);
        }

        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'SL',
            'Client Name',
            'Category',
            'Legal Notice Date',
            'Name',
            'Dateline for Filing',
            'Comments',
            'Status',
            'Created At'
        ];
    }

    public function map($notice): array
    {
        return [
            $notice->id,
            $notice->client->name ?? 'N/A',
            $notice->category->name ?? 'N/A',
            $notice->legal_notice_date,
            $notice->name,
            $notice->dateline_for_filing ?? 'N/A',
            $notice->comments ?? 'N/A',
            $notice->status,
            $notice->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Style the header row
            'A1:I1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FF2C3E50']
                ],
                'font' => [
                    'color' => ['argb' => 'FFFFFFFF']
                ]
            ]
        ];
    }
}