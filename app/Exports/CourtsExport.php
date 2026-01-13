<?php

namespace App\Exports;

use App\Models\Court;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CourtsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Court::select('id', 'court_type_id', 'name', 'created_at', 'updated_at')
                   ->with('courtType')
                   ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Court Type ID',
            'Court Name', 
            'Created At',
            'Updated At'
        ];
    }
}