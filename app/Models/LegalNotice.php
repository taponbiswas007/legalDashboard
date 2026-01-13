<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalNotice extends Model
{
    protected $fillable = [
        'client_id',
        'branch_id',
        'loan_account_acquest_cin',
        'notice_category_id',
        'legal_notice_date',
        'name',
        'dateline_for_filing',
        'comments',
        'status',
    ];

    // Relationship with AddClient (Client)
    public function client()
    {
        return $this->belongsTo(Addclient::class, 'client_id');
    }

    // Relationship with LegalNoticeCategory
    public function category()
    {
        return $this->belongsTo(LegalNoticeCategory::class, 'notice_category_id');
    }
    public function clientbranch()
    {
        return $this->belongsTo(ClientBranch::class, 'branch_id');
    }
}
