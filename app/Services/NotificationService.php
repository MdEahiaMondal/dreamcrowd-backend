<?php

namespace App\Services;

use App\Models\Notification;
use App\Events\NotificationSent;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public function send($userId, $type, $title, $message, $data = [], $sendEmail = false)
    {
        // Save notification to database
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);


        // Broadcast via Pusher
        broadcast(new NotificationSent($notification, $userId));

        // Send email if requested
        if ($sendEmail) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->email) {
                Mail::to($user->email)->send(new NotificationMail([
                    'title' => $title,
                    'message' => $message,
                    'data' => $data
                ]));
            }
        }

        // return $notification;
    }

    public function sendToMultipleUsers(array $userIds, $type, $title, $message, $data = [], $sendEmail = false)
    {
        foreach ($userIds as $userId) {
            $this->send($userId, $type, $title, $message, $data, $sendEmail);
        }
    }
}