<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpertFastPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'stripe_payment_intent_id',
        'name',
        'card_number',
        'cvv',
        'date',
        'return',
        'status',
    ];
}
