<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillStep extends Model
{
    protected $fillable = [
        'bill_id', 
        'case_id', 
        'step_name', 
        'rate',
        'case_number',
        'hearing_date'
    ];

    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    
    // শুধু একটি relationship রাখুন
    public function caseDetails()
    {
        return $this->belongsTo(AddcaseHistory::class, 'case_id');
    }
      public function branch()
    {
        return $this->belongsTo(ClientBranch::class, 'branch_id');
    }
}