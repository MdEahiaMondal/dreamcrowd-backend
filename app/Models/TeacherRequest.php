<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'request_type',
        'request_id',
        'request_date',
        'status', 
    ];
    public $timestamps = false;
}
