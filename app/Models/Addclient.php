<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addclient extends Model
{
    use HasFactory;
    protected $table = 'addclients';
    protected $fillable = ['auth_id', 'name', 'email', 'number', 'address', 'status'];

    public function addclient()
    {
        return $this->hasMany(Addclient::class);
    }
    public function cases()
    {
        return $this->hasMany(Addcase::class, 'client_id');
    }
    // In Client model
    public function branches()
    {
        return $this->hasMany(ClientBranch::class, 'client_id');
    }

    // For single branch access (used in bill PDF and controller)
    public function branch()
    {
        return $this->hasOne(ClientBranch::class, 'client_id');
    }
}
