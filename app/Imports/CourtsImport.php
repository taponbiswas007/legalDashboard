<?php

namespace App\Imports;

use App\Models\Court;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CourtsImport implements ToCollection, WithHeadingRow
{
    protected $courtTypeId;

    public function __construct($courtTypeId)
    {
        $this->courtTypeId = $courtTypeId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows
            if (empty($row['name'])) {
                continue;
            }

            // Check if court already exists for this type
            $existingCourt = Court::where('court_type_id', $this->courtTypeId)
                                ->where('name', $row['name'])
                                ->first();

            if (!$existingCourt) {
                Court::create([
                    'court_type_id' => $this->courtTypeId,
                    'name' => $row['name']
                ]);
            }
        }
    }
}