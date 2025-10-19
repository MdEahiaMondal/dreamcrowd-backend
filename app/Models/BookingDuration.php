<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDuration extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_online',
        'class_inperson',
        'class_oneday',
        'freelance_online_normal',
        'freelance_online_consultation',
        'freelance_inperson',
    ];
}
