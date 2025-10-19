<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherReapetDays extends Model
{
    use HasFactory;
    protected $fillable = [
        'gig_id',
        'day',
        'start_time',
        'end_time', 
    ];
}
