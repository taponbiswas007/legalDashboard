<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $table = 'courts';
     protected $fillable = [
        'court_type_id',
        'name',
    ];


    // Relationship with LegalNoticeCategory
    public function courtType()
    {
        return $this->belongsTo(CourtType::class, 'court_type_id');
    }
}
