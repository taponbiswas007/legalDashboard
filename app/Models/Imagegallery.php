<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagegallery extends Model
{
    protected $table = 'imagegalleries';
    protected $fillable = ['image', 'title',   'status'];
}
