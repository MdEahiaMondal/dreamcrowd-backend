<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use stdClass;

class EmailTestController extends Controller
{
    /**
     * Display list of all email templates for testing
     */
    public function index()
    {
        $emailTemplates = $this->getEmailTemplatesList();

        return view('email-test.index', compact('emailTemplates'));
    }

    /**
     * Preview a specific email template
     */
    public function preview($template)
    {
        $sampleData = $this->getSampleDataForTemplate($template);

        if (!View::exists("emails.{$template}")) {
            abort(404, "Email template '{$template}' not found");
        }

        return view("emails.{$template}", $sampleData);
    }

    /**
     * Get list of all email templates
     */
    private function getEmailTemplatesList()
    {
        return [
            [
                'name' => 'notification',
                'title' => 'General Notification',
                'description' => 'Generic notification email with privacy-protected names'
            ],
            [
                'name' => 'order-approved',
                'title' => 'Order Approved',
                'description' => 'Email sent when seller approves an order'
            ],
            [
                'name' => 'order-rejected',
                'title' => 'Order Rejected',
                'description' => 'Email sent when seller rejects an order'
            ],
            [
                'name' => 'order-delivered',
                'title' => 'Order Delivered',
                'description' => 'Email sent when order is marked as delivered'
            ],
            [
                'name' => 'reschedule-request-buyer',
                'title' => 'Reschedule Request (Buyer)',
                'description' => 'Email when buyer requests to reschedule'
            ],
            [
                'name' => 'reschedule-request-seller',
                'title' => 'Reschedule Request (Seller)',
                'description' => 'Email when seller requests to reschedule'
            ],
            [
                'name' => 'reschedule-approved',
                'title' => 'Reschedule Approved',
                'description' => 'Email when reschedule request is approved'
            ],
            [
                'name' => 'reschedule-rejected',
                'title' => 'Reschedule Rejected',
                'description' => 'Email when reschedule request is rejected'
            ],
            [
                'name' => 'verify-email',
                'title' => 'Email Verification',
                'description' => 'Email verification link for new users'
            ],
            [
                'name' => 'forgot-password',
                'title' => 'Password Reset',
                'description' => 'Password reset link email'
            ],
            [
                'name' => 'change-email',
                'title' => 'Email Change Confirmation',
                'description' => 'Email sent when user changes their email address'
            ],
            [
                'name' => 'trial-booking-confirmation',
                'title' => 'Trial Class Booking',
                'description' => 'Confirmation email for trial class booking'
            ],
            [
                'name' => 'trial-class-reminder',
                'title' => 'Trial Class Reminder',
                'description' => 'Reminder email before trial class'
            ],
            [
                'name' => 'class-start-reminder',
                'title' => 'Class Start Reminder',
                'description' => 'Reminder email before class starts'
            ],
            [
                'name' => 'custom-offer-sent',
                'title' => 'Custom Offer Sent',
                'description' => 'Email when seller sends custom offer'
            ],
            [
                'name' => 'custom-offer-accepted',
                'title' => 'Custom Offer Accepted',
                'description' => 'Email when buyer accepts custom offer'
            ],
            [
                'name' => 'custom-offer-rejected',
                'title' => 'Custom Offer Rejected',
                'description' => 'Email when buyer rejects custom offer'
            ],
            [
                'name' => 'custom-offer-expired',
                'title' => 'Custom Offer Expired',
                'description' => 'Email when custom offer expires'
            ],
            [
                'name' => 'guest-class-invitation',
                'title' => 'Guest Class Invitation',
                'description' => 'Invitation email for guest class'
            ],
            [
                'name' => 'contact-email',
                'title' => 'Contact Form Submission',
                'description' => 'Email from contact form'
            ],
            [
                'name' => 'daily-system-report',
                'title' => 'Daily System Report',
                'description' => 'Daily admin system report email'
            ],
        ];
    }

    /**
     * Get sample data for email templates
     */
    private function getSampleDataForTemplate($template)
    {
        // Common sample data
        $commonData = [
            'app_name' => config('app.name', 'DreamCrowd'),
            'app_url' => url('/'),
        ];

        // Create mock custom offer object
        $mockOffer = (object)[
            'id' => 12345,
            'offer_type' => 'Custom Project',
            'service_mode' => 'Online',
            'payment_type' => 'Milestone',
            'total_amount' => 499.00,
            'description' => 'I will create a professional website with modern design and full functionality.',
            'expires_at' => now()->addDays(7),
            'gig' => (object)[
                'title' => 'Professional Website Development'
            ],
            'milestones' => collect([
                (object)[
                    'title' => 'Design & Mockups',
                    'price' => 150.00,
                    'description' => 'Initial design concepts and mockups',
                    'date' => now()->addDays(7)->format('Y-m-d'),
                    'delivery_days' => 7,
                    'revisions' => 2
                ],
                (object)[
                    'title' => 'Development',
                    'price' => 249.00,
                    'description' => 'Full website development',
                    'date' => now()->addDays(21)->format('Y-m-d'),
                    'delivery_days' => 14,
                    'revisions' => 3
                ],
            ])
        ];

        // Template-specific sample data
        $templateData = [
            // New templates
            'notification' => [
                'notification' => [
                    'title' => 'Order Approved',
                    'message' => 'Gabriel A has accepted your order for "Web Development Service". Your order is now active and the seller will begin working on it.',
                    'data' => [
                        'order_id' => 12345,
                        'service_name' => 'Web Development Service',
                        'seller_name' => 'Gabriel A',
                        'buyer_name' => 'John D',
                        'amount' => '$299.00',
                        'delivery_date' => 'March 15, 2025',
                    ],
                    'is_emergency' => false,
                ]
            ],
            'order-approved' => [
                'sellerName' => 'Gabriel A',
                'serviceName' => 'Web Development Service',
                'orderId' => 12345,
                'amount' => 299.00,
                'deliveryDate' => 'March 15, 2025',
            ],
            'order-rejected' => [
                'sellerName' => 'Gabriel A',
                'serviceName' => 'Web Development Service',
                'orderId' => 12345,
                'reason' => 'Unfortunately, I am currently fully booked and cannot take on new projects at this time.',
            ],
            'order-delivered' => [
                'serviceName' => 'Web Development Service',
                'orderId' => 12345,
                'deliveryDate' => now()->format('F j, Y g:i A'),
                'disputeDeadline' => now()->addHours(48)->format('F j, Y g:i A'),
            ],
            'reschedule-request-buyer' => [
                'buyerName' => 'John D',
                'serviceName' => 'Python Tutoring',
                'orderId' => 12345,
                'rescheduleCount' => 2,
                'oldDate' => 'March 10, 2025',
                'newDate' => 'March 17, 2025',
            ],
            'reschedule-request-seller' => [
                'sellerName' => 'Gabriel A',
                'serviceName' => 'Python Tutoring',
                'orderId' => 12345,
                'rescheduleCount' => 2,
                'oldDate' => 'March 10, 2025',
                'newDate' => 'March 17, 2025',
            ],
            'reschedule-approved' => [
                'serviceName' => 'Python Tutoring',
                'orderId' => 12345,
                'newDate' => 'March 17, 2025',
            ],
            'reschedule-rejected' => [
                'serviceName' => 'Python Tutoring',
                'orderId' => 12345,
                'rejectorName' => 'Gabriel A',
            ],

            // Existing templates with $mailData
            'verify-email' => [
                'mailData' => [
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'token' => 'sample-verification-token-12345',
                    'url' => url('/verify-email/sample-verification-token-12345'),
                ]
            ],
            'forgot-password' => [
                'mailData' => [
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'token' => 'sample-reset-token-67890',
                    'url' => url('/forgot-password-verify/sample-reset-token-67890'),
                ]
            ],
            'change-email' => [
                'mailData' => [
                    'name' => 'John Doe',
                    'old_email' => 'john.old@example.com',
                    'new_email' => 'john.new@example.com',
                    'token' => 'sample-change-token-54321',
                    'url' => url('/verify-email-change/sample-change-token-54321'),
                    'randomNumber' => '9876543210',
                ]
            ],
            'trial-booking-confirmation' => [
                'mailData' => [
                    'student_name' => 'John D',
                    'teacher_name' => 'Gabriel A',
                    'class_name' => 'Python Programming Trial',
                    'class_date' => now()->addDays(3)->format('F j, Y'),
                    'class_time' => '2:00 PM - 3:00 PM',
                    'join_url' => url('/join-trial-class/12345'),
                    'order_id' => 12345,
                    'isFree' => true,
                    'randomNumber' => '1234567890',
                ],
                // Direct variables the template expects
                'isFree' => true,
                'userName' => 'John D',
                'classTitle' => 'Python Programming Trial',
                'teacherName' => 'Gabriel A',
                'classDateTime' => now()->addDays(3)->format('F j, Y \a\t g:i A'),
                'duration' => '60 minutes',
                'timezone' => 'UTC',
                'amount' => '49.99',
                'dashboardUrl' => url('/user-application'),
            ],
            'trial-class-reminder' => [
                'mailData' => [
                    'student_name' => 'John D',
                    'teacher_name' => 'Gabriel A',
                    'class_name' => 'Python Programming Trial',
                    'class_date' => now()->addHours(2)->format('F j, Y'),
                    'class_time' => now()->addHours(2)->format('g:i A'),
                    'join_url' => url('/join-trial-class/12345'),
                    'minutes_until_class' => 120,
                ],
                // Direct variables the template expects
                'userName' => 'John D',
                'teacherName' => 'Gabriel A',
                'classTitle' => 'Python Programming Trial',
                'classDateTime' => now()->addHours(2)->format('F j, Y \a\t g:i A'),
                'duration' => '60 minutes',
                'timezone' => 'UTC',
                'meetingLink' => url('/join-trial-class/12345'),
                'isFree' => false,
            ],
            'class-start-reminder' => [
                'mailData' => [
                    'student_name' => 'John D',
                    'teacher_name' => 'Gabriel A',
                    'class_name' => 'Advanced Python Programming',
                    'class_date' => now()->addHours(1)->format('F j, Y'),
                    'class_time' => now()->addHours(1)->format('g:i A'),
                    'join_url' => url('/join-class/12345'),
                    'meeting_id' => '123-456-789',
                    'minutes_until_class' => 60,
                ],
                'user' => (object)[
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john.doe@example.com',
                ],
                'order' => (object)[
                    'title' => 'Advanced Python Programming',
                ],
                // Direct variables the template expects
                'teacherName' => 'Gabriel A',
                'startTime' => now()->addHours(1)->format('F j, Y \a\t g:i A'),
                'duration' => '60 minutes',
                'timezone' => 'UTC',
                'joinUrl' => url('/join-class/12345'),
            ],
            'custom-offer-sent' => [
                'offer' => $mockOffer,
                'buyerName' => 'John D',
                'sellerName' => 'Gabriel A',
            ],
            'custom-offer-accepted' => [
                'offer' => $mockOffer,
                'buyerName' => 'John D',
                'sellerName' => 'Gabriel A',
            ],
            'custom-offer-rejected' => [
                'offer' => $mockOffer,
                'buyerName' => 'John D',
                'sellerName' => 'Gabriel A',
                'rejectionReason' => 'Thank you for the offer, but I have decided to go with a different approach for this project.',
            ],
            'custom-offer-expired' => [
                'offer' => $mockOffer,
                'buyerName' => 'John D',
                'sellerName' => 'Gabriel A',
                'recipientName' => 'John D',
                'isBuyer' => true,
                'otherPartyName' => 'Gabriel A',
            ],
            'guest-class-invitation' => [
                'mailData' => [
                    'guest_name' => 'Jane Smith',
                    'host_name' => 'Gabriel A',
                    'class_name' => 'Web Development Masterclass',
                    'class_date' => now()->addDays(5)->format('F j, Y'),
                    'class_time' => '3:00 PM - 4:30 PM',
                    'join_url' => url('/join-guest-class/guest-token-99999'),
                    'personal_message' => 'I think you would really enjoy this class!',
                    'first_name' => 'Jane',
                ],
                'buyerName' => 'Jane Smith',
                'order' => (object)[
                    'title' => 'Web Development Masterclass',
                ],
                'startTime' => now()->addDays(5)->format('F j, Y \a\t g:i A'),
                'duration' => '90 minutes',
                'timezone' => 'UTC',
                'teacherName' => 'Gabriel A',
                'joinUrl' => url('/join-guest-class/guest-token-99999'),
            ],
            'contact-email' => [
                'mailData' => [
                    'name' => 'Jane Smith',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'email' => 'jane.smith@example.com',
                    'subject' => 'Question about your services',
                    'message' => 'Hi, I am interested in learning more about your web development courses. Could you provide more information?',
                    'msg' => 'Hi, I am interested in learning more about your web development courses. Could you provide more information?',
                    'phone' => '+1 (555) 123-4567',
                ]
            ],
            'daily-system-report' => [
                'mailData' => [
                    'date' => now()->format('F j, Y'),
                    'total_users' => 1250,
                    'new_users_today' => 15,
                    'total_orders' => 458,
                    'new_orders_today' => 12,
                    'pending_orders' => 23,
                    'revenue_today' => 2499.00,
                ],
                'systemInfo' => [
                    'domain' => url('/'),
                    'hostname' => gethostname(),
                    'ip_address' => $_SERVER['SERVER_ADDR'] ?? '127.0.0.1',
                    'os' => PHP_OS,
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'environment' => config('app.env'),
                    'disk_free' => '45 GB',
                    'disk_total' => '100 GB',
                    'memory_limit' => ini_get('memory_limit'),
                    'server_time' => now()->format('F j, Y g:i A T'),
                    'total_users' => 1250,
                    'new_users_today' => 15,
                    'total_orders' => 458,
                    'new_orders_today' => 12,
                    'completed_orders' => 420,
                    'pending_orders' => 23,
                    'cancelled_orders' => 15,
                    'revenue_today' => 2499.00,
                    'revenue_month' => 45750.00,
                    'active_disputes' => 3,
                    'server_status' => 'healthy',
                    'database_size' => '2.5 GB',
                ],
            ],
        ];

        return array_merge(
            $commonData,
            $templateData[$template] ?? ['message' => 'Sample email content for ' . $template]
        );
    }
}
