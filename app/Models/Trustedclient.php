<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trustedclient extends Model
{

    protected $table = 'trustedclients';
    protected $fillable = ['image', 'status'];
}
