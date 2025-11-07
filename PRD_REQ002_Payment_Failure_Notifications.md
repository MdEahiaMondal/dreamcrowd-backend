# PRD: Payment Failure Notifications

**Requirement ID:** REQ-002
**Feature Name:** Payment Failure Notifications
**Priority:** CRITICAL
**Category:** Notifications - Transactional
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Table of Contents
1. [Overview](#overview)
2. [Business Justification](#business-justification)
3. [User Stories](#user-stories)
4. [Functional Requirements](#functional-requirements)
5. [Technical Specifications](#technical-specifications)
6. [User Experience & Email Templates](#user-experience--email-templates)
7. [Acceptance Criteria](#acceptance-criteria)
8. [Testing Requirements](#testing-requirements)
9. [Dependencies](#dependencies)
10. [Implementation Plan](#implementation-plan)
11. [Sign-off](#sign-off)

---

## Overview

### Problem Statement
When a payment fails during the booking process (due to insufficient funds, declined card, network issues, etc.), users currently only see a generic error message on the screen. They do not receive any follow-up email with:
- Explanation of what went wrong
- Options to retry with the same or different payment method
- Support contact information
- Booking details they attempted to purchase

This leads to:
- ❌ Frustrated users who don't understand why payment failed
- ❌ Lost revenue from abandoned bookings
- ❌ Increased support tickets ("Why didn't my payment work?")
- ❌ No way to re-engage users who experienced payment failure

### Proposed Solution
Implement automated email notifications sent immediately after payment failure to:
1. **User** - Explaining the failure reason, providing a retry link, and offering support
2. **Admin** - Alerting of repeated payment failures (potential fraud or system issues)

### Expected Outcome
- ✅ Improved user experience during payment failures
- ✅ Increased payment retry rate (target: 25-30% of failed payments)
- ✅ Reduced support tickets related to payment issues
- ✅ Early detection of payment processing issues
- ✅ Better fraud detection (pattern recognition)

---

## Business Justification

### Business Goals
1. **Recover Lost Revenue** - 25-30% of users retry payment after receiving a helpful email
2. **Improve User Experience** - Clear communication during failure builds trust
3. **Reduce Support Load** - Proactive emails answer common questions
4. **Fraud Detection** - Admin alerts help identify suspicious payment patterns

### Impact Analysis
| Metric | Current State | Expected Impact |
|--------|---------------|-----------------|
| Failed Payment Recovery | 10% (manual retry only) | 30% (with email reminder) |
| Support Tickets (payment issues) | 60 tickets/month | 35 tickets/month (-42%) |
| Payment Success Rate | 85% | 88% (accounting for retries) |
| Average Time to Retry | 48 hours | 2 hours |

### ROI Calculation
**Assumptions:**
- Current failed payments: 150/month @ avg $75/booking = $11,250 lost revenue/month
- With email recovery: 30% × $11,250 = **$3,375 recovered/month**
- Annual recovered revenue: **$40,500**

**Cost:**
- Development: 4 hours @ $75/hour = $300
- Email service cost: ~$10/month = $120/year

**ROI:** ($40,500 - $420) / $420 = **9,543% first year** 🚀

---

## User Stories

### User Story 1: User Receives Payment Failure Email
**As a** user whose payment just failed
**I want to** receive an email explaining what went wrong and how to fix it
**So that** I can successfully complete my booking without frustration

**Acceptance Criteria:**
- Email arrives within 60 seconds of payment failure
- Email explains the failure reason in simple terms
- Email includes a "Try Again" button with pre-filled booking details
- Email offers alternative payment methods (if available)
- Email provides support contact information
- Email is empathetic and helpful in tone

---

### User Story 2: User Retries Payment from Email Link
**As a** user who received a payment failure email
**I want to** click a link that takes me directly to the payment page with my booking pre-filled
**So that** I don't have to re-enter all my information

**Acceptance Criteria:**
- Link includes secure token to pre-populate booking details
- Token expires after 24 hours (security)
- Link takes user directly to payment page
- All booking details (class, date, etc.) are pre-filled
- User only needs to re-enter payment information

---

### User Story 3: Admin Monitors Payment Failures
**As an** admin
**I want to** receive alerts when payment failures exceed normal thresholds
**So that** I can investigate potential system issues or fraud

**Acceptance Criteria:**
- Admin receives email if failure rate > 20% in 1 hour
- Admin receives alert for 3+ failures from same user/card (potential fraud)
- Admin dashboard shows payment failure statistics
- Alert email includes failure reasons and affected users

---

## Functional Requirements

### FR-1: User Payment Failure Email
**Description:** Send helpful email to user immediately after payment failure

**Trigger:** Payment exception caught in `BookingController` or Stripe webhook failure event

**Email Content Must Include:**
1. **Header:** Empathetic heading (e.g., "We couldn't complete your payment")
2. **Failure Summary:**
   - What happened: "Your payment was declined"
   - Why it happened: "Your card was declined by your bank" (user-friendly explanation)
   - When it happened: Timestamp
3. **Booking Details Attempted:**
   - Class name
   - Teacher name
   - Scheduled date/time
   - Amount attempted: $X.XX
4. **Reason Explanation:**
   - Common reasons for this type of failure
   - Suggested fixes
5. **Call-to-Action:**
   - **Primary:** "Try Again" button (secure link to retry)
   - **Secondary:** "Contact Support" link
6. **Alternative Options:**
   - Try a different payment method
   - Use a different card
   - Contact your bank
7. **Footer:**
   - Support email and phone
   - FAQ link about payments
   - Reassurance about data security

**Delivery Method:** Queued email (async processing)

---

### FR-2: Payment Failure Reason Mapping
**Description:** Translate technical Stripe error codes into user-friendly messages

**Stripe Error Codes → User-Friendly Messages:**

| Stripe Code | User-Friendly Message | Suggested Action |
|-------------|----------------------|------------------|
| `card_declined` | Your card was declined by your bank | Contact your bank or try a different card |
| `insufficient_funds` | Your card has insufficient funds | Add funds to your account or use a different card |
| `expired_card` | Your card has expired | Update your card expiration date or use a different card |
| `incorrect_cvc` | The security code (CVC) is incorrect | Check your card's CVC code and try again |
| `processing_error` | A temporary processing error occurred | Please try again in a few minutes |
| `card_not_supported` | This card type is not supported | Try a Visa, Mastercard, or American Express card |
| `rate_limit` | Too many payment attempts | Please wait 10 minutes and try again |

**Default Message:** "An unexpected error occurred. Please try again or contact support."

---

### FR-3: Retry Link Generation
**Description:** Generate secure, time-limited links for users to retry payment

**Requirements:**
- Generate unique token for each failed payment attempt
- Token includes encrypted booking details (gig_id, amount, user_id, date)
- Token expires after 24 hours
- Link format: `https://dreamcrowd.com/retry-payment/{token}`
- When clicked, pre-fills checkout form with booking details

**Security:**
- Use `encrypt()` function to encode booking data
- Store token in database with expiry timestamp
- Validate token hasn't been used before (single-use)

---

### FR-4: Admin Alert for High Failure Rates
**Description:** Notify admin when payment failures exceed threshold

**Trigger Conditions:**
1. **High Failure Rate:** > 20% of payments fail in 1 hour
2. **Repeated Failures:** Same user fails 3+ times in 24 hours
3. **Same Card Failures:** Same card (last 4 digits) fails 5+ times across different users

**Alert Content:**
- Failure rate percentage
- Number of affected transactions
- Time period
- List of failure reasons
- Link to admin payment analytics dashboard

**Delivery Method:** Immediate email to admin

---

## Technical Specifications

### Database Changes

#### New Table: `payment_retry_tokens`
**Migration:** `2025_11_06_000001_create_payment_retry_tokens_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRetryTokensTable extends Migration
{
    public function up()
    {
        Schema::create('payment_retry_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gig_id');
            $table->text('encrypted_data'); // Encrypted booking details
            $table->decimal('amount', 10, 2);
            $table->string('failure_reason')->nullable();
            $table->string('stripe_error_code')->nullable();
            $table->boolean('used')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gig_id')->references('id')->on('teacher_gigs')->onDelete('cascade');

            $table->index(['token', 'expires_at']);
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_retry_tokens');
    }
}
```

#### New Table: `payment_failure_logs`
**Migration:** `2025_11_06_000002_create_payment_failure_logs_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentFailureLogsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_failure_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gig_id');
            $table->decimal('amount', 10, 2);
            $table->string('stripe_error_code');
            $table->string('failure_reason');
            $table->string('card_last_four', 4)->nullable();
            $table->string('card_brand')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->boolean('retry_email_sent')->default(false);
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gig_id')->references('id')->on('teacher_gigs')->onDelete('cascade');

            $table->index(['user_id', 'created_at']);
            $table->index(['stripe_payment_intent_id']);
            $table->index(['created_at', 'stripe_error_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_failure_logs');
    }
}
```

---

### Files to Create

#### 1. Models

**File:** `app/Models/PaymentRetryToken.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentRetryToken extends Model
{
    protected $fillable = [
        'token',
        'user_id',
        'gig_id',
        'encrypted_data',
        'amount',
        'failure_reason',
        'stripe_error_code',
        'used',
        'expires_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'used' => 'boolean',
        'expires_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacherGig()
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    // Helper methods
    public static function generate($user, $gig, $bookingData, $failureReason, $stripeErrorCode)
    {
        return self::create([
            'token' => Str::random(64),
            'user_id' => $user->id,
            'gig_id' => $gig->id,
            'encrypted_data' => encrypt($bookingData),
            'amount' => $bookingData['amount'],
            'failure_reason' => $failureReason,
            'stripe_error_code' => $stripeErrorCode,
            'expires_at' => Carbon::now()->addHours(24)
        ]);
    }

    public function isValid()
    {
        return !$this->used && Carbon::now()->lt($this->expires_at);
    }

    public function markAsUsed()
    {
        $this->update(['used' => true]);
    }

    public function getBookingData()
    {
        return decrypt($this->encrypted_data);
    }
}
```

**File:** `app/Models/PaymentFailureLog.php`
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentFailureLog extends Model
{
    protected $fillable = [
        'user_id',
        'gig_id',
        'amount',
        'stripe_error_code',
        'failure_reason',
        'card_last_four',
        'card_brand',
        'stripe_payment_intent_id',
        'ip_address',
        'user_agent',
        'retry_email_sent',
        'email_sent_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'retry_email_sent' => 'boolean',
        'email_sent_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacherGig()
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    // Analytics
    public static function getFailureRateLastHour()
    {
        $oneHourAgo = now()->subHour();

        $failures = self::where('created_at', '>=', $oneHourAgo)->count();
        $total = \App\Models\Transaction::where('created_at', '>=', $oneHourAgo)->count() + $failures;

        return $total > 0 ? ($failures / $total) * 100 : 0;
    }

    public static function getUserFailureCount($userId, $hours = 24)
    {
        return self::where('user_id', $userId)
                   ->where('created_at', '>=', now()->subHours($hours))
                   ->count();
    }
}
```

---

#### 2. Mail Classes

**File:** `app/Mail/PaymentFailureNotification.php`
```php
<?php

namespace App\Mail;

use App\Models\User;
use App\Models\TeacherGig;
use App\Models\PaymentRetryToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailureNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $gig;
    public $amount;
    public $failureReason;
    public $suggestedAction;
    public $retryToken;
    public $bookingData;

    public function __construct(User $user, TeacherGig $gig, $bookingData, $failureReason, $stripeErrorCode)
    {
        $this->user = $user;
        $this->gig = $gig;
        $this->bookingData = $bookingData;
        $this->amount = $bookingData['amount'];
        $this->failureReason = $this->getUserFriendlyMessage($stripeErrorCode);
        $this->suggestedAction = $this->getSuggestedAction($stripeErrorCode);

        // Generate retry token
        $this->retryToken = PaymentRetryToken::generate(
            $user,
            $gig,
            $bookingData,
            $failureReason,
            $stripeErrorCode
        );
    }

    public function build()
    {
        return $this->subject('Payment Issue - ' . $this->gig->gig_name)
                    ->view('emails.payment-failure');
    }

    private function getUserFriendlyMessage($stripeErrorCode)
    {
        $messages = [
            'card_declined' => 'Your card was declined by your bank',
            'insufficient_funds' => 'Your card has insufficient funds',
            'expired_card' => 'Your card has expired',
            'incorrect_cvc' => 'The security code (CVC) is incorrect',
            'processing_error' => 'A temporary processing error occurred',
            'card_not_supported' => 'This card type is not supported',
            'rate_limit' => 'Too many payment attempts in a short time'
        ];

        return $messages[$stripeErrorCode] ?? 'An unexpected error occurred with your payment';
    }

    private function getSuggestedAction($stripeErrorCode)
    {
        $actions = [
            'card_declined' => 'Contact your bank or try a different card',
            'insufficient_funds' => 'Add funds to your account or use a different card',
            'expired_card' => 'Update your card expiration date or use a different card',
            'incorrect_cvc' => 'Check your card\'s security code and try again',
            'processing_error' => 'Please try again in a few minutes',
            'card_not_supported' => 'Try a Visa, Mastercard, or American Express card',
            'rate_limit' => 'Please wait 10 minutes and try again'
        ];

        return $actions[$stripeErrorCode] ?? 'Please try again or contact our support team';
    }
}
```

**File:** `app/Mail/AdminPaymentFailureAlert.php`
```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminPaymentFailureAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $alertType;
    public $failureRate;
    public $affectedCount;
    public $details;

    public function __construct($alertType, $data)
    {
        $this->alertType = $alertType;
        $this->failureRate = $data['failure_rate'] ?? null;
        $this->affectedCount = $data['affected_count'] ?? 0;
        $this->details = $data['details'] ?? [];
    }

    public function build()
    {
        return $this->subject('⚠️ Payment Failure Alert - ' . $this->alertType)
                    ->view('emails.admin-payment-failure-alert');
    }
}
```

---

#### 3. Blade Templates

**File:** `resources/views/emails/payment-failure.blade.php`
```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Issue</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #EF4444; color: white; padding: 30px; text-align: center; }
        .content { background: #f9fafb; padding: 30px; }
        .alert-box { background: #FEE2E2; border-left: 4px solid #EF4444; padding: 15px; margin: 20px 0; }
        .info-box { background: white; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .label { font-weight: bold; color: #6B7280; }
        .value { color: #111827; margin-bottom: 10px; }
        .button { display: inline-block; background: #10B981; color: white; padding: 15px 40px;
                  text-decoration: none; border-radius: 5px; margin: 20px 0; font-weight: bold; }
        .button-secondary { background: #6B7280; }
        .footer { text-align: center; color: #6B7280; font-size: 12px; padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Payment Issue</h1>
            <p>We couldn't complete your payment</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hi {{ $user->first_name }},</p>
            <p>We were unable to process your payment for the class you tried to book. Don't worry - this happens sometimes and is usually easy to fix!</p>

            <!-- Failure Alert -->
            <div class="alert-box">
                <h3 style="margin-top: 0;">What happened:</h3>
                <p style="font-size: 16px; font-weight: bold; margin: 10px 0;">{{ $failureReason }}</p>
                <p style="font-size: 14px;">{{ $suggestedAction }}</p>
            </div>

            <!-- Booking Details -->
            <div class="info-box">
                <h2>Booking Details You Attempted</h2>
                <p><span class="label">Class:</span> <span class="value">{{ $gig->gig_name }}</span></p>
                <p><span class="label">Teacher:</span> <span class="value">{{ $gig->user->first_name }} {{ $gig->user->last_name }}</span></p>
                <p><span class="label">Amount:</span> <span class="value" style="font-size: 18px; font-weight: bold;">${{ number_format($amount, 2) }}</span></p>
                @if(isset($bookingData['class_date']))
                    <p><span class="label">Scheduled Date:</span> <span class="value">{{ $bookingData['class_date'] }}</span></p>
                @endif
            </div>

            <!-- What to Do Next -->
            <div class="info-box">
                <h2>What You Can Do</h2>
                <ol>
                    <li><strong>Try Again:</strong> Click the button below to retry your payment. We've saved your booking details!</li>
                    <li><strong>Use a Different Card:</strong> If the issue persists, try using a different payment method.</li>
                    <li><strong>Contact Your Bank:</strong> Your bank can tell you why the payment was declined.</li>
                    <li><strong>Reach Out to Us:</strong> Our support team is here to help if you need assistance.</li>
                </ol>
            </div>

            <!-- CTA Buttons -->
            <div style="text-align: center;">
                <a href="{{ url('/retry-payment/' . $retryToken->token) }}" class="button">
                    Try Payment Again
                </a>
                <br>
                <a href="{{ url('/contact-support?ref=payment-failure') }}" class="button button-secondary">
                    Contact Support
                </a>
            </div>

            <!-- Common Reasons -->
            <div class="info-box">
                <h3>Common Reasons for Payment Failures:</h3>
                <ul style="font-size: 14px; color: #6B7280;">
                    <li>Insufficient funds in account</li>
                    <li>Card expired or not activated</li>
                    <li>Incorrect security code (CVC)</li>
                    <li>Bank security restrictions on online purchases</li>
                    <li>Daily spending limit reached</li>
                </ul>
            </div>

            <!-- Security Reassurance -->
            <div style="background: #DBEAFE; border-left: 4px solid #3B82F6; padding: 15px; margin: 20px 0;">
                <p style="margin: 0; font-size: 14px;">
                    <strong>🔒 Your Data is Secure:</strong> We use industry-standard encryption and never store your full card details. All payments are processed securely through Stripe.
                </p>
            </div>

            <p>This retry link will expire in 24 hours for your security.</p>

            <p>Best regards,<br>The DreamCrowd Team</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Need Help?</strong></p>
            <p>Email: support@dreamcrowd.com | Phone: (555) 123-4567</p>
            <p><a href="{{ url('/help/payments') }}">Payment FAQ</a> | <a href="{{ url('/terms') }}">Terms</a></p>
            <p>&copy; {{ date('Y') }} DreamCrowd. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
```

**File:** `resources/views/emails/admin-payment-failure-alert.blade.php`
```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Failure Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 700px; margin: 0 auto; padding: 20px; }
        .header { background: #DC2626; color: white; padding: 20px; }
        .alert-box { background: #FEE2E2; border: 2px solid #DC2626; padding: 20px; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Payment Failure Alert</h1>
            <p>{{ $alertType }}</p>
        </div>

        <div style="padding: 20px;">
            <div class="alert-box">
                <h2>Alert Summary</h2>
                @if($failureRate)
                    <p><strong>Failure Rate:</strong> {{ number_format($failureRate, 2) }}%</p>
                @endif
                <p><strong>Affected Transactions:</strong> {{ $affectedCount }}</p>
                <p><strong>Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
            </div>

            @if(count($details) > 0)
                <h3>Failure Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Reason</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $detail)
                            <tr>
                                <td>{{ $detail['user_email'] ?? 'N/A' }}</td>
                                <td>${{ number_format($detail['amount'] ?? 0, 2) }}</td>
                                <td>{{ $detail['failure_reason'] ?? 'Unknown' }}</td>
                                <td>{{ $detail['time'] ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <p><strong>Recommended Actions:</strong></p>
            <ul>
                <li>Check Stripe dashboard for additional details</li>
                <li>Review payment gateway status</li>
                <li>Investigate if this is a systemic issue</li>
                <li>Contact affected users if widespread issue</li>
            </ul>

            <p><a href="{{ url('/admin/payment-analytics') }}" style="display: inline-block; background: #DC2626; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">View Payment Analytics</a></p>
        </div>
    </div>
</body>
</html>
```

---

#### 4. Controller Modifications

**File:** `app/Http/Controllers/BookingController.php`

**Add to payment processing section:**

```php
use App\Mail\PaymentFailureNotification;
use App\Mail\AdminPaymentFailureAlert;
use App\Models\PaymentFailureLog;
use App\Models\PaymentRetryToken;
use Illuminate\Support\Facades\Mail;

// In payment processing method
try {
    // Stripe payment processing
    $paymentIntent = \Stripe\PaymentIntent::create([...]);

    // If successful, create order...

} catch (\Stripe\Exception\CardException $e) {
    // Log the failure
    $failureLog = PaymentFailureLog::create([
        'user_id' => $user->id,
        'gig_id' => $gig->id,
        'amount' => $amount,
        'stripe_error_code' => $e->getError()->code,
        'failure_reason' => $e->getError()->message,
        'card_last_four' => $e->getError()->decline_code ?? null,
        'stripe_payment_intent_id' => $e->getError()->payment_intent->id ?? null,
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);

    // Send failure email to user
    try {
        Mail::to($user->email)->queue(
            new PaymentFailureNotification(
                $user,
                $gig,
                $bookingData,
                $e->getError()->message,
                $e->getError()->code
            )
        );

        $failureLog->update([
            'retry_email_sent' => true,
            'email_sent_at' => now()
        ]);

    } catch (\Exception $mailException) {
        \Log::error('Failed to send payment failure email', [
            'user_id' => $user->id,
            'error' => $mailException->getMessage()
        ]);
    }

    // Check if admin alert needed
    $this->checkAdminAlertThresholds($user);

    return back()->with('error', 'Payment failed: ' . $e->getError()->message . ' Please check your email for instructions to retry.');

} catch (\Exception $e) {
    \Log::error('Payment processing error', [
        'user_id' => $user->id,
        'error' => $e->getMessage()
    ]);

    return back()->with('error', 'An unexpected error occurred. Please try again.');
}

// Add this method to BookingController
private function checkAdminAlertThresholds($user)
{
    // Check 1: High failure rate
    $failureRate = PaymentFailureLog::getFailureRateLastHour();
    if ($failureRate > 20) {
        $failures = PaymentFailureLog::where('created_at', '>=', now()->subHour())->get();
        $details = $failures->map(function($f) {
            return [
                'user_email' => $f->user->email,
                'amount' => $f->amount,
                'failure_reason' => $f->failure_reason,
                'time' => $f->created_at->format('H:i:s')
            ];
        })->toArray();

        Mail::to(config('mail.admin_email'))->send(
            new AdminPaymentFailureAlert('High Failure Rate Alert', [
                'failure_rate' => $failureRate,
                'affected_count' => $failures->count(),
                'details' => $details
            ])
        );
    }

    // Check 2: Repeated user failures
    $userFailures = PaymentFailureLog::getUserFailureCount($user->id, 24);
    if ($userFailures >= 3) {
        Mail::to(config('mail.admin_email'))->send(
            new AdminPaymentFailureAlert('Repeated User Failures', [
                'affected_count' => $userFailures,
                'details' => [
                    [
                        'user_email' => $user->email,
                        'amount' => 'Multiple',
                        'failure_reason' => '3+ failures in 24 hours',
                        'time' => now()->format('H:i:s')
                    ]
                ]
            ])
        );
    }
}
```

---

#### 5. Retry Payment Route & Controller

**File:** `routes/web.php`
```php
// Payment retry route
Route::get('/retry-payment/{token}', [BookingController::class, 'retryPayment'])->name('payment.retry');
```

**File:** `app/Http/Controllers/BookingController.php` (add method)
```php
public function retryPayment($token)
{
    $retryToken = PaymentRetryToken::where('token', $token)->first();

    if (!$retryToken || !$retryToken->isValid()) {
        return redirect('/')->with('error', 'This payment retry link has expired or is invalid.');
    }

    // Mark token as used
    $retryToken->markAsUsed();

    // Decrypt booking data
    $bookingData = $retryToken->getBookingData();

    // Redirect to payment page with pre-filled data
    return view('Seller-listing.payment-1', [
        'gig' => $retryToken->teacherGig,
        'prefill_data' => $bookingData,
        'retry_attempt' => true
    ]);
}
```

---

### Configuration Requirements

**File:** `.env`
```env
# Admin alert email
ADMIN_EMAIL=admin@dreamcrowd.com

# Payment failure thresholds
PAYMENT_FAILURE_RATE_THRESHOLD=20  # percent
PAYMENT_RETRY_EXPIRY_HOURS=24
```

**File:** `config/mail.php`
```php
'admin_email' => env('ADMIN_EMAIL', 'admin@dreamcrowd.com'),
```

---

## Acceptance Criteria

### Must-Have (Blocking)
- [ ] User receives payment failure email within 60 seconds of failure
- [ ] Email explains failure reason in user-friendly language
- [ ] Email includes working "Try Again" button with secure retry link
- [ ] Retry link pre-fills all booking details (user only re-enters payment info)
- [ ] Retry link expires after 24 hours
- [ ] Retry link can only be used once (security)
- [ ] All payment failures logged in `payment_failure_logs` table
- [ ] Admin receives alert when failure rate > 20% in 1 hour
- [ ] Admin receives alert for 3+ failures from same user in 24 hours

### Should-Have (Important)
- [ ] Email delivery rate > 98%
- [ ] 25%+ of users retry payment after receiving email
- [ ] Retry links work correctly 100% of time
- [ ] Admin dashboard shows payment failure analytics
- [ ] Email template is mobile-responsive

### Nice-to-Have (Optional)
- [ ] Track which failure reasons are most common
- [ ] A/B test different email copy for recovery rate
- [ ] SMS notification for high-value failed payments (> $200)
- [ ] Integration with fraud detection service

---

## Testing Requirements

### Unit Tests

**Test File:** `tests/Unit/PaymentFailureTest.php`

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\PaymentRetryToken;
use App\Models\PaymentFailureLog;
use App\Models\User;
use App\Models\TeacherGig;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentFailureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function retry_token_is_generated_correctly()
    {
        $user = User::factory()->create();
        $gig = TeacherGig::factory()->create();
        $bookingData = ['amount' => 100, 'duration' => 60];

        $token = PaymentRetryToken::generate($user, $gig, $bookingData, 'Card declined', 'card_declined');

        $this->assertNotNull($token->token);
        $this->assertEquals(64, strlen($token->token));
        $this->assertFalse($token->used);
        $this->assertTrue($token->expires_at->gt(now()));
    }

    /** @test */
    public function retry_token_can_be_validated()
    {
        $token = PaymentRetryToken::factory()->create([
            'expires_at' => now()->addHours(24),
            'used' => false
        ]);

        $this->assertTrue($token->isValid());
    }

    /** @test */
    public function expired_token_is_invalid()
    {
        $token = PaymentRetryToken::factory()->create([
            'expires_at' => now()->subHour(),
            'used' => false
        ]);

        $this->assertFalse($token->isValid());
    }

    /** @test */
    public function used_token_is_invalid()
    {
        $token = PaymentRetryToken::factory()->create([
            'expires_at' => now()->addHours(24),
            'used' => true
        ]);

        $this->assertFalse($token->isValid());
    }

    /** @test */
    public function failure_rate_calculation_is_accurate()
    {
        // Create 5 failures and 15 successes in last hour
        PaymentFailureLog::factory()->count(5)->create([
            'created_at' => now()->subMinutes(30)
        ]);

        Transaction::factory()->count(15)->create([
            'created_at' => now()->subMinutes(30)
        ]);

        $rate = PaymentFailureLog::getFailureRateLastHour();

        $this->assertEquals(25.0, $rate);  // 5 / 20 = 25%
    }
}
```

---

### Integration Tests

**Test File:** `tests/Feature/PaymentFailureEmailTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TeacherGig;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentFailureNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentFailureEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function payment_failure_sends_email_to_user()
    {
        Mail::fake();

        $user = User::factory()->create();
        $gig = TeacherGig::factory()->create();

        // Simulate payment failure
        $this->actingAs($user)
             ->post('/process-payment', [
                 'gig_id' => $gig->id,
                 'card_number' => '4000000000000002',  // Test card that always fails
                 'amount' => 100
             ]);

        Mail::assertQueued(PaymentFailureNotification::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    public function retry_link_redirects_to_payment_page_with_prefilled_data()
    {
        $user = User::factory()->create();
        $token = PaymentRetryToken::factory()->create([
            'user_id' => $user->id,
            'used' => false,
            'expires_at' => now()->addHours(24)
        ]);

        $response = $this->get('/retry-payment/' . $token->token);

        $response->assertStatus(200);
        $response->assertViewHas('prefill_data');
        $response->assertViewHas('retry_attempt', true);

        // Token should be marked as used
        $this->assertTrue($token->fresh()->used);
    }

    /** @test */
    public function expired_retry_link_redirects_with_error()
    {
        $token = PaymentRetryToken::factory()->create([
            'expires_at' => now()->subHour()
        ]);

        $response = $this->get('/retry-payment/' . $token->token);

        $response->assertRedirect('/');
        $response->assertSessionHas('error');
    }

    /** @test */
    public function admin_receives_alert_for_high_failure_rate()
    {
        Mail::fake();

        // Create 25 failures in last hour (> 20% threshold)
        PaymentFailureLog::factory()->count(25)->create([
            'created_at' => now()->subMinutes(30)
        ]);

        // Trigger failure check
        $user = User::factory()->create();
        $controller = new BookingController();
        $controller->checkAdminAlertThresholds($user);

        Mail::assertSent(AdminPaymentFailureAlert::class);
    }
}
```

---

### Manual Testing Checklist

#### User Flow Testing
- [ ] Trigger payment failure with test card: `4000000000000002`
- [ ] Verify email arrives within 60 seconds
- [ ] Check failure reason is user-friendly
- [ ] Click "Try Again" button - should redirect to payment page
- [ ] Verify all booking details are pre-filled
- [ ] Successfully complete payment on retry
- [ ] Attempt to use retry link again - should show error (single-use)
- [ ] Wait 24 hours and try retry link - should show expired error

#### Edge Cases
- [ ] Test with all Stripe error codes (card_declined, insufficient_funds, expired_card, etc.)
- [ ] Test with invalid email address - should fail gracefully
- [ ] Test when email queue is down - should log error
- [ ] Test with 5 rapid failures - admin should receive alert
- [ ] Test failure rate > 20% - admin should receive alert

#### Email Client Testing
- [ ] Gmail (desktop & mobile)
- [ ] Outlook (desktop & mobile)
- [ ] Apple Mail (iOS)
- [ ] Yahoo Mail

#### Admin Alert Testing
- [ ] Trigger high failure rate alert (> 20%)
- [ ] Trigger repeated user failure alert (3+ failures)
- [ ] Verify admin dashboard shows failure analytics
- [ ] Verify admin can view failure logs

---

## Dependencies

### Technical Dependencies
- ✅ Laravel Mail system configured
- ✅ Stripe PHP SDK installed
- ✅ Queue driver configured
- ✅ BookingController exists with payment processing
- ✅ User, TeacherGig models exist
- 🔲 Two new database tables created (migrations)
- 🔲 Email templates approved

### Business Dependencies
- 🔲 Email service provider ready to handle failure emails
- 🔲 Support team prepared for increased retry traffic
- 🔲 Admin email configured for alerts

### Cross-Feature Dependencies
**None** - This is a standalone feature

---

## Implementation Plan

### Phase 1: Database & Models (1 hour)
1. Create migrations for `payment_retry_tokens` and `payment_failure_logs` (20 min)
2. Run migrations (5 min)
3. Create `PaymentRetryToken` model (15 min)
4. Create `PaymentFailureLog` model (15 min)
5. Write model unit tests (15 min)

### Phase 2: Mail Classes & Templates (1.5 hours)
1. Create `PaymentFailureNotification` mail class (30 min)
2. Create `AdminPaymentFailureAlert` mail class (20 min)
3. Design user email template (30 min)
4. Design admin alert template (20 min)
5. Test email rendering (10 min)

### Phase 3: Controller Logic (1 hour)
1. Add payment failure handling to BookingController (30 min)
2. Create retry payment route and method (20 min)
3. Add admin alert threshold checking (20 min)
4. Test failure handling (10 min)

### Phase 4: Testing & QA (30 min)
1. Write integration tests (15 min)
2. Manual testing with test cards (10 min)
3. Test retry flow end-to-end (10 min)
4. Fix any bugs (variable)

**Total Time:** 4 hours

---

### Task Breakdown

| Task | Assigned To | Estimate | Status |
|------|-------------|----------|--------|
| Create database migrations | Backend Dev | 20 min | Not Started |
| Create model classes | Backend Dev | 30 min | Not Started |
| Create mail classes | Backend Dev | 50 min | Not Started |
| Design user email template | Frontend Dev | 30 min | Not Started |
| Design admin email template | Frontend Dev | 20 min | Not Started |
| Update BookingController | Backend Dev | 50 min | Not Started |
| Create retry payment route | Backend Dev | 20 min | Not Started |
| Write unit tests | Backend Dev | 30 min | Not Started |
| Write integration tests | Backend Dev | 15 min | Not Started |
| Manual testing | QA | 20 min | Not Started |
| Code review | Senior Dev | 15 min | Not Started |

---

## Risks & Mitigation

### Risk 1: Token Security Vulnerability (MEDIUM)
**Impact:** Malicious users could generate fake retry tokens
**Mitigation:**
- Use `encrypt()` function for all booking data
- Generate cryptographically secure random tokens (64 chars)
- Single-use tokens only
- 24-hour expiry
- Rate limit retry attempts (max 5 per hour per user)

### Risk 2: Email Spam Classification (LOW)
**Impact:** Failure emails classified as spam
**Mitigation:**
- Use clear subject lines (not ALL CAPS)
- Include sender authentication (SPF/DKIM)
- Add unsubscribe link
- Monitor spam complaint rate
- Use reputable email service (SendGrid/Mailgun)

### Risk 3: Admin Alert Fatigue (LOW)
**Impact:** Too many admin alerts desensitize admin team
**Mitigation:**
- Only alert for genuine issues (> 20% failure rate)
- Batch alerts (max 1 per hour)
- Include actionable information in alerts
- Allow admin to adjust alert thresholds

---

## Sign-off

### Development Sign-off
- [ ] Database migrations created and tested
- [ ] Models implemented with helper methods
- [ ] Mail classes created
- [ ] Email templates designed and tested
- [ ] Controller logic implemented
- [ ] Unit tests passing
- [ ] Integration tests passing
- [ ] Code reviewed

**Developer:** _________________ **Date:** _______

---

### QA Sign-off
- [ ] Manual testing complete
- [ ] All test cards trigger correct emails
- [ ] Retry links work correctly
- [ ] Admin alerts trigger appropriately
- [ ] Email deliverability verified
- [ ] No critical bugs found

**QA Engineer:** _________________ **Date:** _______

---

### Client Sign-off
- [ ] Email templates approved
- [ ] Failure messages reviewed
- [ ] Admin alert system tested
- [ ] Ready for production

**Client Name:** _________________ **Date:** _______

**Client Signature:** _______________________________

---

## Appendix

### Related Documents
- [MASTER_IMPLEMENTATION_PLAN.md](./MASTER_IMPLEMENTATION_PLAN.md)
- [PRD_REQ001_Order_Confirmation_Notifications.md](./PRD_REQ001_Order_Confirmation_Notifications.md)

### Stripe Test Cards
| Card Number | Result |
|-------------|--------|
| 4000000000000002 | Card declined |
| 4000000000009995 | Insufficient funds |
| 4000000000000069 | Expired card |
| 4000000000000127 | Incorrect CVC |

### Email Preview
(Attach screenshots after design)

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
**Next Review:** After implementation complete
