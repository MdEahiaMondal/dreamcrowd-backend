<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherGigPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'gig_id',
        'payment_type',
        'rate',
        'earning',
        'public_rate',
        'public_earning',
        'public_group_size',
        'public_discount',
        'private_rate',
        'private_group_size',
        'private_discount',
        'private_earning',
        'duration',
        'minor_attend',
        'age_limit',
        'childs',
        'full_available',
        // 'group_size',
        // 'discount', 
        'positive_term',
        'delivery_time',
        'revision',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];
}
