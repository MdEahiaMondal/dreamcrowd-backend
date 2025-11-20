<?php

namespace App\Mail;

use App\Models\CustomOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomOfferExpired extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $offer;
    public $recipientName;
    public $otherPartyName;
    public $isBuyer;

    /**
     * Create a new message instance.
     */
    public function __construct(CustomOffer $offer, bool $isBuyer = true)
    {
        $this->offer = $offer->load(['gig', 'seller', 'buyer', 'milestones']);
        $this->isBuyer = $isBuyer;

        if ($isBuyer) {
            $this->recipientName = $offer->buyer->first_name . ' ' . $offer->buyer->last_name;
            $this->otherPartyName = $offer->seller->first_name . ' ' . $offer->seller->last_name;
        } else {
            $this->recipientName = $offer->seller->first_name . ' ' . $offer->seller->last_name;
            $this->otherPartyName = $offer->buyer->first_name . ' ' . $offer->buyer->last_name;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Custom Offer Expired',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.custom-offer-expired',
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
