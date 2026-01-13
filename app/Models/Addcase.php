<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Addcase extends Model
{
    use HasFactory;

    protected $table = 'addcases';

    protected $fillable = [
        'client_id',
        'file_number',
        'branch_id',
        'loan_account_acquest_cin',
        'court_id',
        'previous_date',
        'previous_step',
        'court_name',
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
    ];

    protected $casts = [
        'status' => 'boolean',
        'filing_or_received_date' => 'date',
        'legal_notice_date' => 'date',
        'next_hearing_date' => 'date',
        'previous_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Eager load relations by default to prevent N+1 queries
     */
    protected $with = ['addclient', 'court', 'clientbranch'];

    /**
     * Relationships
     */
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

    public function history()
    {
        return $this->hasMany(AddcaseHistory::class, 'addcase_id');
    }

    /**
     * Scopes for common queries
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeForClient($query, $clientId)
    {
        return $query->where('client_id', $clientId);
    }

    public function scopeForCourt($query, $courtId)
    {
        return $query->where('court_id', $courtId);
    }

    public function scopeUpcomingHearing($query)
    {
        return $query->where('next_hearing_date', '>=', now())
            ->orderBy('next_hearing_date', 'asc');
    }

    /**
     * Accessors for formatted display
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->status ? 'Active' : 'Inactive',
        );
    }

    protected function caseInfo(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->file_number} - {$this->case_number}",
        );
    }
}
