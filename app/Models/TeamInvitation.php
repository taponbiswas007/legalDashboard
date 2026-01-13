<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
// ...existing code...

class TeamInvitation
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'role',
    ];

    /**
     * Get the team that the invitation belongs to.
     */
    // public function team(): BelongsTo
    // {
    //     // ...existing code...
    // }
}
