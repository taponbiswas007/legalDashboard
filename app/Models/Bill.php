<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'client_id', 'branch_id', 'from_date', 'to_date',
        'total_amount', 'jobtitle', 'address', 'subject','invoice_number',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function steps()
    {
        return $this->hasMany(BillStep::class);
    }

    public function client()
    {
        // change Client::class to your actual client model namespace
        return $this->belongsTo(Addclient::class, 'client_id');
    }

    
    public function clientbranch()
    {
        return $this->belongsTo(ClientBranch::class, 'branch_id');
    }
    public function caseHistory()
    {
        return $this->belongsTo(AddcaseHistory::class, 'client_id');
    }
}
