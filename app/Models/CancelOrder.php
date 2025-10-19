<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_role',
        'order_id',
        'reason',
        'refund', 
        'refund_type', 
        'amount', 
    ];

}
