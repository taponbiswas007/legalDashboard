<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalNoticePricing extends Model
{
    protected $fillable = [
        'client_id',
        'category_id',
        'price',
    ];

    /**
     * Get the client associated with this pricing
     */
    public function client()
    {
        return $this->belongsTo(Addclient::class, 'client_id');
    }

    /**
     * Get the category associated with this pricing
     */
    public function category()
    {
        return $this->belongsTo(LegalNoticeCategory::class, 'category_id');
    }
}
