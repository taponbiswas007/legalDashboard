<?php
// d:/web_development/live_web_project/sk_sharif_project/app/Models/LegalNoticeBillItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalNoticeBillItem extends Model
{
    protected $fillable = [
        'legal_notice_bill_id',
        'type',
        'reference_id',
        'description',
        'amount',
        'notes',
    ];

    public function bill()
    {
        return $this->belongsTo(LegalNoticeBill::class, 'legal_notice_bill_id');
    }

    public function legalnotice()
    {
        return $this->belongsTo(\App\Models\LegalNotice::class, 'reference_id');
    }
}
