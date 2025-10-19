<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'sender_role',
        'receiver_role',
        'sms',
        'files',
        'type',
        'status', 
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'reciver_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }
    
}
