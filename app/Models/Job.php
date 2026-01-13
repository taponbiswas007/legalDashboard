<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'description',
        'job_type',
        'location',
        'salary_range',
        'deadline',
        'pdf_file',
        'is_published',
        'total_applications'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_published' => 'boolean',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('deadline', '>=', now());
    }
}
