<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOfferMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'custom_offer_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'price',
        'revisions',
        'delivery_days',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function customOffer()
    {
        return $this->belongsTo(CustomOffer::class);
    }
}
