<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialBookingConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bookingData;

    /**
     * Create a new message instance.
     *
     * @param array $bookingData
     */
    public function __construct(array $bookingData)
    {
        $this->bookingData = $bookingData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->bookingData['isFree']
            ? 'Free Trial Class Confirmed - ' . $this->bookingData['classTitle']
            : 'Paid Trial Class Confirmed - ' . $this->bookingData['classTitle'];

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.trial-booking-confirmation',
            with: [
                'userName' => $this->bookingData['userName'],
                'classTitle' => $this->bookingData['classTitle'],
                'teacherName' => $this->bookingData['teacherName'],
                'classDateTime' => $this->bookingData['classDateTime'],
                'duration' => $this->bookingData['duration'],
                'timezone' => $this->bookingData['timezone'],
                'amount' => $this->bookingData['amount'] ?? 0,
                'isFree' => $this->bookingData['isFree'],
                'dashboardUrl' => url('/user-dashboard'),
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
