<?php

namespace App\Mail;

use App\Models\CustomOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomOfferCounterReceived extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $counterOffer;
    public $originalOffer;
    public $buyerName;
    public $sellerName;

    /**
     * Create a new message instance.
     */
    public function __construct(CustomOffer $counterOffer)
    {
        $this->counterOffer = $counterOffer->load(['gig', 'seller', 'buyer', 'milestones', 'parentOffer']);
        $this->originalOffer = $counterOffer->parentOffer;
        $this->buyerName = $counterOffer->buyer->first_name . ' ' . $counterOffer->buyer->last_name;
        $this->sellerName = $counterOffer->seller->first_name . ' ' . $counterOffer->seller->last_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Counter Offer Received from ' . $this->buyerName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.custom-offer-counter-received',
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
