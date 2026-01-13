<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscribers';
    protected $fillable = ['email', 'read', 'read_at', 'ip_address', 'user_agent'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Scope to get unread subscribers
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope to get read subscribers
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Mark subscriber as read
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now(), 'read' => true]);
    }
}
