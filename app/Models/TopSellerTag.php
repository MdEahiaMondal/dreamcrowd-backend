<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopSellerTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'earning',
        'booking',
        'review',
        'sorting_impressions',
        'sorting_clicks',
        'sorting_orders',
        'sorting_reviews',
        'commission',
        'buyer_commission',
        'buyer_commission_rate',
    ];
}
