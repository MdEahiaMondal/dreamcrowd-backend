<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassReschedule extends Model
{
    use HasFactory;
    
    protected $fillable = [
      'order_id',
      'class_id',
      'user_id',
      'teacher_id',
      'teacher_date',
      'user_date',
      'status',  
    ];

}
