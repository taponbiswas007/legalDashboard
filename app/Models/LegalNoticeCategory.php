<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalNoticeCategory extends Model
{
    protected $fillable = [
        'name', 
        'description',
    ];
}
