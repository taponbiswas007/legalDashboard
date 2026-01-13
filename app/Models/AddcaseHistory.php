<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddcaseHistory extends Model
{

    protected $table = 'addcase_history';

    protected $fillable = [
        'client_id',
        'file_number',
        'branch_id',
        'loan_account_acquest_cin', 
        'court_id',
        'previous_date',
        'previous_step',
        'case_number',
        'section',
        'name_of_parties',
        'next_hearing_date',
        'next_step',
        'legal_notice_date',
        'filing_or_received_date',
        'legal_notice',
        'plaints',
        'others_documents',
        'status',
         'is_final',

    ];
    public function addclient()
    {
        return $this->belongsTo(Addclient::class, 'client_id');
        
    }
     public function client()
    {
        return $this->belongsTo(Addclient::class, 'client_id');
    }
      public function court()
    {
        return $this->belongsTo(Court::class, 'court_id');
    }
      public function clientbranch()
    {
        return $this->belongsTo(ClientBranch::class, 'branch_id');
    }
}
