<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalNoticeBill extends Model
{
    protected $fillable = [
        'client_id',
        'bill_date',
        'total_amount',
        'pdf_path',
        'filters',
        'custom_fields',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'filters' => 'array',
        'custom_fields' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Addclient::class);
    }

    public function items()
    {
        return $this->hasMany(LegalNoticeBillItem::class, 'legal_notice_bill_id');
    }
}
