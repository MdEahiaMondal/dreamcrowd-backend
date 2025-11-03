<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialClassReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reminderData;

    /**
     * Create a new message instance.
     *
     * @param array $reminderData
     */
    public function __construct(array $reminderData)
    {
        $this->reminderData = $reminderData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏰ Your Trial Class Starts in 30 Minutes - ' . $this->reminderData['classTitle'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trial-class-reminder',
            with: [
                'userName' => $this->reminderData['userName'],
                'classTitle' => $this->reminderData['classTitle'],
                'teacherName' => $this->reminderData['teacherName'],
                'classDateTime' => $this->reminderData['classDateTime'],
                'duration' => $this->reminderData['duration'],
                'timezone' => $this->reminderData['timezone'],
                'meetingLink' => $this->reminderData['meetingLink'],
                'isFree' => $this->reminderData['isFree'],
            ],
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
