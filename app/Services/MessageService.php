<?php

namespace App\Services;

use App\Events\MessageSent;


class MessageService
{
    public function send($userId, $count = 1, $message = null)
    {
        // Save to database

        // Broadcast via Pusher
        broadcast(new MessageSent($message, $userId, $count));

       
    }

    
}