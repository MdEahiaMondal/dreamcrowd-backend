<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCalender extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'notes',
        'color',
        'reminder',
        'date',
        'time',
    ];
}
