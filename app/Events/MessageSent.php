<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $count;
    public $connection = 'sync';

    public function __construct($message, $userId, $count)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->count = $count;
    }

    public function broadcastOn()
    {
        return new Channel('message.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'message';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->userId,
            'count' => $this->count,
            'message' => $this->message,
            
        ];
    }
}