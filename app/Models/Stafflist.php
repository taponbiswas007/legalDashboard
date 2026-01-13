<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stafflist extends Model
{

    protected $table = 'stafflists';
    protected $fillable = ['name', 'number', 'email', 'whatsapp', 'address', 'qualification', 'possition', 'image', 'status'];
}
