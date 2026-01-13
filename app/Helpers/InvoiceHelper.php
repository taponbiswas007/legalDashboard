<?php

namespace App\Helpers;

use App\Models\InvoiceNumber;

class InvoiceHelper
{
    public static function getNextInvoiceNumber()
    {
        // Get or create invoice settings row
        $row = InvoiceNumber::first();

        if (!$row) {
            $row = InvoiceNumber::create([
                'prefix' => 'INV-',
                'last_number' => 0,
            ]);
        }

        // Prepare year & month
        $year  = date('Y');
        $month = date('m');

        // Next auto number
        $next = $row->last_number + 1;

        // Build invoice number: INV-2025-11-00001
        return $row->prefix
            . $year . '-' . $month . '-'
            . str_pad($next, 5, '0', STR_PAD_LEFT);
    }

    public static function incrementInvoiceNumber()
    {
        $row = InvoiceNumber::first();

        if ($row) {
            $row->last_number = $row->last_number + 1;
            $row->save();
        }
    }
}
