<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceNumber extends Model
{
    protected $fillable = ['prefix', 'last_number'];
}

