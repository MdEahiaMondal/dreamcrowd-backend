<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData , $subject , $name , $mail;
    /**
     * Create a new message instance.
     */
    public function __construct($mailData,$subject,$name, $mail)
    {
        $this->mailData = $mailData;
        $this->subject = $subject;
        $this->name = $name;
        $this->mail = $mail;
    }
  
    /**
     * Get the message envelope.
     */

    //  public function build()
    //  {
    //      return $this->from($this->mail, $this->name)
    //                  ->subject($this->subject)
    //                  ->view('emails.contact-email')
    //                  ->with(['mailData' => $this->mailData]);
                     
    //  }

    public function envelope(): Envelope
    {
        return new Envelope(

            from: new Address($this->mail, $this->name),
            replyTo: [
                new Address($this->mail, $this->name),
            ],

            // subject: 'Contact Mail',
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-email'
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
