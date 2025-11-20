<?php

namespace App\Mail;

use App\Models\CustomOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomOfferRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $offer;
    public $buyerName;
    public $sellerName;
    public $rejectionReason;

    /**
     * Create a new message instance.
     */
    public function __construct(CustomOffer $offer)
    {
        $this->offer = $offer->load(['gig', 'seller', 'buyer', 'milestones']);
        $this->buyerName = $offer->buyer->first_name . ' ' . $offer->buyer->last_name;
        $this->sellerName = $offer->seller->first_name . ' ' . $offer->seller->last_name;
        $this->rejectionReason = $offer->rejection_reason ?? 'No reason provided';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Custom Offer Rejected',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.custom-offer-rejected',
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
