<?php

namespace App\Mail;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $withdrawal;
    public $status;

    /**
     * Create a new message instance.
     *
     * @param Withdrawal $withdrawal
     * @param string $status The new status (processing, completed, failed)
     */
    public function __construct(Withdrawal $withdrawal, string $status)
    {
        $this->withdrawal = $withdrawal;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->getSubject();

        return $this->subject($subject)
            ->view('emails.withdrawal-status')
            ->with([
                'withdrawal' => $this->withdrawal,
                'status' => $this->status,
                'sellerName' => $this->withdrawal->seller->first_name ?? 'Seller',
                'amount' => number_format($this->withdrawal->amount, 2),
                'netAmount' => number_format($this->withdrawal->net_amount, 2),
                'method' => $this->withdrawal->method_display_name,
                'statusMessage' => $this->getStatusMessage(),
                'dashboardUrl' => url('/seller/earnings'),
            ]);
    }

    /**
     * Get email subject based on status
     */
    private function getSubject(): string
    {
        return match ($this->status) {
            'processing' => 'Your Withdrawal Request is Being Processed',
            'completed' => 'Your Withdrawal Has Been Completed',
            'failed' => 'Your Withdrawal Request Was Declined',
            default => 'Withdrawal Status Update',
        };
    }

    /**
     * Get status message for email body
     */
    private function getStatusMessage(): string
    {
        return match ($this->status) {
            'processing' => 'Your withdrawal request is now being processed. We will notify you once the payment has been completed.',
            'completed' => 'Great news! Your withdrawal has been successfully processed and the funds have been sent to your account.',
            'failed' => 'Unfortunately, your withdrawal request could not be processed. Please review the details and try again or contact support.',
            default => 'Your withdrawal status has been updated.',
        };
    }
}
