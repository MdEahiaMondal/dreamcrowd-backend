<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notification;
    public $notificationId;
    public $emailTemplate;

    /**
     * Create a new message instance.
     *
     * @param array $notification Notification data (title, message, data, etc.)
     * @param int|null $notificationId Notification ID for tracking
     * @param string|null $emailTemplate Custom template name (e.g., 'order-delivered')
     */
    public function __construct($notification, $notificationId = null, $emailTemplate = null)
    {
        $this->notification = $notification;
        $this->notificationId = $notificationId;
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Determine which template to use
        $template = 'emails.notification'; // Default generic template

        if ($this->emailTemplate) {
            $customTemplate = 'emails.' . $this->emailTemplate;

            // Check if custom template exists
            if (view()->exists($customTemplate)) {
                $template = $customTemplate;
                Log::info('Using custom email template', [
                    'template' => $customTemplate,
                    'notification_id' => $this->notificationId
                ]);
            } else {
                Log::warning('Custom email template not found, using default', [
                    'requested_template' => $customTemplate,
                    'notification_id' => $this->notificationId
                ]);
            }
        }

        // Prepare variables for custom templates
        $viewData = $this->prepareViewData();

        return $this->subject($this->notification['title'])
            ->view($template)
            ->with($viewData);
    }

    /**
     * Prepare view data for custom templates
     * Maps notification data to template-specific variables
     */
    private function prepareViewData()
    {
        $data = [
            'notification' => $this->notification,
            'notificationId' => $this->notificationId,
        ];

        // Get data array from notification
        $notificationData = $this->notification['data'] ?? [];

        // Map common variables for custom templates
        if (is_array($notificationData)) {
            // Order-related variables
            $data['orderId'] = $notificationData['order_id'] ?? null;
            $data['serviceName'] = $notificationData['service_name'] ?? null;
            $data['amount'] = $notificationData['amount'] ?? null;

            // User/name variables
            $data['buyerName'] = $notificationData['buyer_name'] ?? null;
            $data['sellerName'] = $notificationData['seller_name'] ?? null;
            $data['userName'] = $notificationData['user_name'] ?? null;
            $data['recipientName'] = $notificationData['recipient_name'] ?? null;

            // Date/time variables
            $data['deliveryDate'] = $notificationData['delivered_at'] ?? null;
            $data['disputeDeadline'] = $notificationData['dispute_deadline'] ?? null;
            $data['classDateTime'] = $notificationData['class_date_time'] ?? null;

            // Reschedule-related variables
            $data['rescheduleCount'] = $notificationData['reschedule_count'] ?? null;

            // Refund/cancellation variables
            $data['refundAmount'] = $notificationData['refund_amount'] ?? null;
            $data['cancellationReason'] = $notificationData['cancellation_reason'] ?? null;
            $data['rejectionReason'] = $notificationData['rejection_reason'] ?? null;
            $data['rejectedBy'] = $notificationData['rejected_by'] ?? null;

            // Dashboard/action URLs
            $data['dashboardUrl'] = url('/dashboard');
            $data['orderUrl'] = $data['orderId'] ? url('/order/' . $data['orderId']) : url('/dashboard');
        }

        return $data;
    }
}