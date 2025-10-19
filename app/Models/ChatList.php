<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatList extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher',
        'user',
        'admin',
        'sms',
        'type',
        'block',  
        'block_by',  
    ];

    public function teacherlist()
    {
        return $this->belongsTo(User::class, 'teacher');
    }

    public function userlist()
    {
        return $this->belongsTo(User::class, 'user');
    }

}
