<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassDate extends Model
{
    use HasFactory;

    protected $fillable = [
      'order_id',
      'teacher_date',
      'user_date',
      'teacher_time_zone',
      'user_time_zone',
      'teacher_attend',
      'user_attend',
      'duration',
    ];

}
