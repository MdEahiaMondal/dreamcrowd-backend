<?php

namespace App\Mail;

use App\Models\BookOrder;
use App\Models\ClassDate;
use App\Models\ZoomSecureToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassStartReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $classDate;
    public $user;
    public $secureToken;
    public $joinUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(BookOrder $order, ClassDate $classDate, $user)
    {
        $this->order = $order;
        $this->classDate = $classDate;
        $this->user = $user;

        // Generate secure token for this user
        $tokenRecord = $classDate->generateSecureToken($user->id, $user->email);

        // Build secure join URL with PLAIN token (not hashed)
        $this->joinUrl = url("/join/class/{$classDate->id}?token={$tokenRecord->plain_token}");
        $this->secureToken = $tokenRecord;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Class Starts Soon - ' . $this->order->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.class-start-reminder',
            with: [
                'order' => $this->order,
                'classDate' => $this->classDate,
                'user' => $this->user,
                'joinUrl' => $this->joinUrl,
                'teacherName' => $this->order->teacher->first_name . ' ' . $this->order->teacher->last_name,
                'startTime' => $this->classDate->teacher_date->format('M d, Y h:i A'),
                'duration' => $this->classDate->duration ?? '60 minutes',
                'timezone' => $this->classDate->teacher_time_zone ?? 'UTC',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
