<?php

namespace App\Imports;

use App\Models\Addcase;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AddcaseUpdateImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        if (!isset($data['id']) || !isset($data['court_id'])) {
            return;
        }

        $case = Addcase::find($data['id']);

        if ($case) {
            $case->court_id = intval($data['court_id']);
            $case->save();
        }
    }
}
