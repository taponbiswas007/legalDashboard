<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientBranch extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'description',
    ];

    // ⬇ Relationship: ekta branch ek client er
    public function client()
    {
        return $this->belongsTo(Addclient::class, 'client_id');
    }
}
