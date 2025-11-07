# DreamCrowd Notification Implementation Plan

**Created:** 2025-11-07
**Status:** In Progress
**Total Notifications to Implement:** 40+
**Estimated Effort:** 118 hours (13-16 days)

---

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [Current System Analysis](#current-system-analysis)
3. [Implementation Phases](#implementation-phases)
4. [Phase 1: Critical Notifications](#phase-1-critical-notifications)
5. [Phase 2: High Priority Notifications](#phase-2-high-priority-notifications)
6. [Phase 3: Medium Priority Notifications](#phase-3-medium-priority-notifications)
7. [Phase 4: Low Priority Notifications](#phase-4-low-priority-notifications)
8. [Code Patterns & Standards](#code-patterns--standards)
9. [Testing Procedures](#testing-procedures)
10. [Risk Mitigation](#risk-mitigation)
11. [Progress Tracking](#progress-tracking)

---

## Executive Summary

This document provides a comprehensive implementation plan for adding 40+ missing notification scenarios to the DreamCrowd marketplace platform. The implementation is structured in 4 phases based on business priority:

- **Phase 1 (Critical):** 2 notifications - 8 hours
- **Phase 2 (High):** 12 notifications - 28 hours
- **Phase 3 (Medium):** 15 notifications - 45 hours
- **Phase 4 (Low):** 16 notifications - 37 hours

**Total:** 45 notifications, 118 hours

### Key Principles

1. **No Breaking Changes** - Only add code, never remove or modify existing functionality
2. **Follow Existing Patterns** - Use the same NotificationService patterns already in the codebase
3. **Test Thoroughly** - Each notification must be tested before moving to the next
4. **Document Everything** - Update this plan as notifications are implemented

---

## Current System Analysis

### Notification Architecture

#### Core Components

1. **NotificationService** (`app/Services/NotificationService.php`)
   - Main service for sending notifications
   - Methods: `send()`, `sendToMultipleUsers()`
   - Handles: Database storage, Pusher broadcast, Email sending

2. **Notification Model** (`app/Models/Notification.php`)
   - Database table: `notifications`
   - Fields: `user_id`, `type`, `title`, `message`, `data`, `is_read`, `read_at`

3. **Delivery Channels**
   - **Database:** All notifications stored for history
   - **Pusher:** Real-time notifications (user.{userId} channel)
   - **Email:** Optional via NotificationMail

4. **Frontend Integration**
   - JavaScript: `public/js/notifications.js`
   - Dashboard Views: User, Teacher, Admin notification pages
   - Real-time updates via Pusher client

### NotificationService Method Signatures

```php
// Single notification
public function send(
    $userId,           // User ID to notify
    $type,            // Notification type (order, payment, dispute, etc.)
    $title,           // Notification title
    $message,         // Notification message
    $data = [],       // Additional data (array) - stored as JSON
    $sendEmail = false // Whether to send email
)

// Multiple users
public function sendToMultipleUsers(
    array $userIds,   // Array of user IDs
    $type,
    $title,
    $message,
    $data = [],
    $sendEmail = false
)
```

### Notification Types Taxonomy

Use these standardized types for consistency:

| Type | Description | Example Use Cases |
|------|-------------|-------------------|
| `account` | Account-related | Registration, verification, role changes, suspension |
| `order` | Order lifecycle | Creation, updates, delivery, completion |
| `payment` | Payment events | Success, failure, refunds |
| `payout` | Payout events | Scheduled, completed, failed |
| `cancellation` | Order cancellations | Buyer, seller, auto cancellation |
| `dispute` | Dispute-related | Opened, resolved, counter-dispute |
| `reschedule` | Reschedule requests | Request, approval, rejection |
| `class` | Class/session events | Reminders, Zoom links, start times |
| `review` | Reviews and ratings | Received, replied, reminder |
| `message` | Chat/messaging | New message received |
| `gig` | Service/gig management | Creation, approval, status changes |
| `coupon` | Coupon-related | Usage, expiring, expired |
| `system` | System errors and admin alerts | Command failures, critical errors |
| `zoom` | Zoom integration events | Connected, disconnected, token issues |

### Controllers Currently Using NotificationService

1. **BookingController.php** - Order placement, trial bookings, coupon usage
2. **AdminController.php** - Application approvals/rejections, payouts
3. **OrderManagementController.php** - Order acceptance, disputes, cancellations
4. **StripeWebhookController.php** - Payment success/failure, payout events
5. **TeacherController.php** - Teacher dashboard operations
6. **MessagesController.php** - Chat messaging
7. **AuthController.php** - Authentication events

### Scheduled Commands

1. **UpdateTeacherGigStatus.php** - Every 5 minutes
2. **AutoCancelPendingOrders.php** - Every 10 minutes
3. **AutoMarkDelivered.php** - Hourly
4. **AutoMarkCompleted.php** - Every 6 hours
5. **AutoHandleDisputes.php** - Daily at 3:00 AM
6. **GenerateZoomMeetings.php** - Every 5 minutes
7. **RefreshZoomToken.php** - Hourly
8. **GenerateTrialMeetingLinks.php** - Every 5 minutes

---

## Implementation Phases

### Phase Overview

```
Phase 1 (Critical)    →  8 hours  →  Core business operations
Phase 2 (High)        → 28 hours  →  Important business features
Phase 3 (Medium)      → 45 hours  →  Enhanced user experience
Phase 4 (Low)         → 37 hours  →  Nice-to-have features
```

---

## Phase 1: Critical Notifications

**Priority:** 🔴 CRITICAL
**Estimated Effort:** 8 hours
**Business Impact:** Essential for core operations
**Must Complete:** Before any production deployment

### 1.1 Class Starting in 24 Hours Reminder

**Notification ID:** NOTIF-001
**Effort:** 5 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** Create new file `app/Console/Commands/SendClassReminders.php`

**Trigger:** Scheduled command runs daily at 10:00 AM

**Recipients:**
- Buyer (student)
- Seller (teacher)

**Logic:**
```php
// Query classes starting in 24 hours
$classesIn24Hours = ClassDate::whereBetween('class_date', [
    now()->addHours(23),
    now()->addHours(25)
])->with(['bookOrder.user', 'bookOrder.teacherGig.user'])->get();

foreach ($classesIn24Hours as $classDate) {
    $order = $classDate->bookOrder;
    $buyer = $order->user;
    $seller = $order->teacherGig->user;

    // Notify buyer
    $this->notificationService->send(
        userId: $buyer->id,
        type: 'class',
        title: 'Class Reminder: Starting Tomorrow',
        message: "Reminder: Your class '{$order->teacherGig->title}' with {$seller->first_name} starts tomorrow at " . $classDate->class_date->format('h:i A'),
        data: [
            'order_id' => $order->id,
            'class_date_id' => $classDate->id,
            'class_date' => $classDate->class_date->toISOString(),
            'zoom_link' => $classDate->zoom_link,
            'seller_name' => $seller->first_name . ' ' . $seller->last_name
        ],
        sendEmail: true
    );

    // Notify seller
    $this->notificationService->send(
        userId: $seller->id,
        type: 'class',
        title: 'Class Reminder: Starting Tomorrow',
        message: "Reminder: You have a class '{$order->teacherGig->title}' with {$buyer->first_name} tomorrow at " . $classDate->class_date->format('h:i A'),
        data: [
            'order_id' => $order->id,
            'class_date_id' => $classDate->id,
            'class_date' => $classDate->class_date->toISOString(),
            'zoom_link' => $classDate->zoom_link,
            'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name
        ],
        sendEmail: true
    );
}
```

**Schedule Registration** (in `app/Console/Kernel.php`):
```php
$schedule->command('reminders:send-class-reminders')
    ->dailyAt('10:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/class-reminders.log'));
```

**Testing Checklist:**
- [ ] Command runs successfully
- [ ] Classes in 24-hour window are found
- [ ] Buyer receives notification (database + Pusher + email)
- [ ] Seller receives notification (database + Pusher + email)
- [ ] Zoom link included in data
- [ ] No duplicate notifications sent
- [ ] Log file created with output

---

### 1.2 Class Starting in 1 Hour Reminder

**Notification ID:** NOTIF-002
**Effort:** 3 hours (included in SendClassReminders command)
**Status:** ⏳ Pending

#### Implementation Details

**File:** Add to `app/Console/Commands/SendClassReminders.php`

**Trigger:** Scheduled command runs hourly

**Recipients:**
- Buyer (student)
- Seller (teacher)

**Logic:**
```php
// Query classes starting in 1 hour
$classesIn1Hour = ClassDate::whereBetween('class_date', [
    now()->addMinutes(50),
    now()->addMinutes(70)
])->with(['bookOrder.user', 'bookOrder.teacherGig.user'])->get();

foreach ($classesIn1Hour as $classDate) {
    $order = $classDate->bookOrder;
    $buyer = $order->user;
    $seller = $order->teacherGig->user;

    // Notify buyer
    $this->notificationService->send(
        userId: $buyer->id,
        type: 'class',
        title: 'Class Starting Soon!',
        message: "Your class '{$order->teacherGig->title}' starts in 1 hour! Join here: {$classDate->zoom_link}",
        data: [
            'order_id' => $order->id,
            'class_date_id' => $classDate->id,
            'start_time' => $classDate->class_date->toISOString(),
            'zoom_link' => $classDate->zoom_link,
            'seller_name' => $seller->first_name . ' ' . $seller->last_name
        ],
        sendEmail: true
    );

    // Notify seller
    $this->notificationService->send(
        userId: $seller->id,
        type: 'class',
        title: 'Class Starting Soon!',
        message: "Your class '{$order->teacherGig->title}' with {$buyer->first_name} starts in 1 hour!",
        data: [
            'order_id' => $order->id,
            'class_date_id' => $classDate->id,
            'start_time' => $classDate->class_date->toISOString(),
            'zoom_link' => $classDate->zoom_link,
            'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name
        ],
        sendEmail: true
    );
}
```

**Schedule Registration** (update in `app/Console/Kernel.php`):
```php
$schedule->command('reminders:send-class-reminders')
    ->hourly()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/class-reminders.log'));
```

**Testing Checklist:**
- [ ] Command runs hourly
- [ ] Classes in 1-hour window are found
- [ ] Notifications sent to buyer and seller
- [ ] Zoom link prominently displayed
- [ ] Email sent successfully

---

### 1.3 Zoom Token Refresh Failed

**Notification ID:** NOTIF-003
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Services/ZoomMeetingService.php` (modify refreshToken method)

**Trigger:** Zoom OAuth token refresh fails

**Recipients:**
- Seller (whose token failed)
- All admins

**Location:** Find the `refreshToken()` method (around line 50-100)

**Logic to Add:**
```php
// In the catch block of refreshToken() method
catch (\Exception $e) {
    Log::error('Zoom token refresh failed', [
        'user_id' => $this->userId,
        'error' => $e->getMessage()
    ]);

    // Notify seller
    app(\App\Services\NotificationService::class)->send(
        userId: $this->userId,
        type: 'zoom',
        title: 'Zoom Connection Failed',
        message: 'Failed to refresh your Zoom connection. Please reconnect your Zoom account to continue hosting classes.',
        data: [
            'error' => $e->getMessage(),
            'reconnect_url' => route('teacher.zoom.connect')
        ],
        sendEmail: true
    );

    // Notify admins
    $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
    if (!empty($adminIds)) {
        app(\App\Services\NotificationService::class)->sendToMultipleUsers(
            userIds: $adminIds,
            type: 'system',
            title: 'Zoom Token Refresh Failed',
            message: "Zoom token refresh failed for seller #{$this->userId}. User may experience meeting creation issues.",
            data: [
                'seller_id' => $this->userId,
                'error' => $e->getMessage()
            ],
            sendEmail: true
        );
    }

    throw $e;
}
```

**Testing Checklist:**
- [ ] Trigger token refresh failure (manually expire token)
- [ ] Seller receives notification
- [ ] Admins receive notification
- [ ] Email sent to seller with reconnect instructions
- [ ] Error logged properly
- [ ] Existing functionality still works

---

## Phase 2: High Priority Notifications

**Priority:** 🟠 HIGH
**Estimated Effort:** 28 hours
**Business Impact:** Important for business operations

### 2.1 Commission Rate Updated for Seller

**Notification ID:** NOTIF-004
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php`

**Method:** Find the method that updates seller commission (likely in commission management section)

**Trigger:** Admin updates seller's custom commission rate

**Recipients:** Seller

**Logic to Add:**
```php
// After commission update is saved
$seller = User::find($sellerId);

$this->notificationService->send(
    userId: $sellerId,
    type: 'account',
    title: 'Commission Rate Updated',
    message: "Your commission rate has been updated to {$newRate}% by the admin team.",
    data: [
        'old_rate' => $oldRate,
        'new_rate' => $newRate,
        'updated_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

**Testing Checklist:**
- [ ] Find commission update method in AdminController
- [ ] Add notification after successful update
- [ ] Test with different commission rates
- [ ] Verify email sent to seller
- [ ] Check notification appears in seller dashboard

---

### 2.2 Commission Rate Updated for Specific Service

**Notification ID:** NOTIF-005
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php`

**Method:** Service commission update method

**Trigger:** Admin updates commission rate for specific service

**Recipients:** Seller (service owner)

**Logic to Add:**
```php
// After service commission update
$gig = TeacherGig::find($gigId);
$seller = $gig->user;

$this->notificationService->send(
    userId: $seller->id,
    type: 'gig',
    title: 'Service Commission Updated',
    message: "Commission rate for '{$gig->title}' has been updated to {$newRate}%.",
    data: [
        'gig_id' => $gigId,
        'gig_title' => $gig->title,
        'old_rate' => $oldRate,
        'new_rate' => $newRate,
        'updated_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

---

### 2.3 Bank Account Verification Success

**Notification ID:** NOTIF-006
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/StripeWebhookController.php` or account management controller

**Trigger:** Stripe webhook for bank account verification success

**Recipients:** Seller

**Logic to Add:**
```php
// In webhook handler or account controller
$this->notificationService->send(
    userId: $seller->id,
    type: 'account',
    title: 'Bank Account Verified',
    message: "Your bank account ending in {$last4} has been successfully verified. You can now receive payouts.",
    data: [
        'bank_last4' => $last4,
        'verified_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

---

### 2.4 Bank Account Verification Failed

**Notification ID:** NOTIF-007
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/StripeWebhookController.php`

**Trigger:** Stripe webhook for bank account verification failure

**Recipients:** Seller

**Logic to Add:**
```php
$this->notificationService->send(
    userId: $seller->id,
    type: 'account',
    title: 'Bank Account Verification Failed',
    message: "Bank account verification failed. Please check your details and try again. Reason: {$reason}",
    data: [
        'failure_reason' => $reason,
        'retry_url' => route('teacher.bank.setup')
    ],
    sendEmail: true
);
```

---

### 2.5 Seller Profile Update Request Approval

**Notification ID:** NOTIF-008
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php:681`

**Method:** Profile update approval method

**Trigger:** Admin approves seller profile update request

**Recipients:** Seller

**Logic to Add:**
```php
// After approval
$this->notificationService->send(
    userId: $seller->id,
    type: 'account',
    title: 'Profile Update Approved',
    message: 'Your profile update request has been approved by the admin team.',
    data: [
        'request_id' => $requestId,
        'approved_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

---

### 2.6 Seller Profile Update Request Rejection

**Notification ID:** NOTIF-009
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php:681`

**Method:** Profile update rejection method

**Trigger:** Admin rejects seller profile update request

**Recipients:** Seller

**Logic to Add:**
```php
// After rejection
$this->notificationService->send(
    userId: $seller->id,
    type: 'account',
    title: 'Profile Update Rejected',
    message: "Your profile update request has been rejected. Reason: {$reason}",
    data: [
        'request_id' => $requestId,
        'rejection_reason' => $reason,
        'rejected_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

---

### 2.7 Payment Processing Error (Order Creation)

**Notification ID:** NOTIF-010
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/BookingController.php` (around line 400-500)

**Trigger:** Payment succeeds but order creation fails

**Recipients:** Buyer, Admin

**Logic to Add:**
```php
// In catch block during order creation
catch (\Exception $e) {
    Log::error('Order creation failed after payment', [
        'transaction_id' => $transaction->id,
        'buyer_id' => $buyerId,
        'amount' => $amount,
        'error' => $e->getMessage()
    ]);

    // Notify buyer
    $this->notificationService->send(
        userId: $buyerId,
        type: 'payment',
        title: 'Payment Processing Error',
        message: "We received your payment but encountered an error creating your order. Our team has been notified and will resolve this shortly. Reference: {$transaction->stripe_transaction_id}",
        data: [
            'transaction_id' => $transaction->id,
            'amount' => $amount,
            'error' => 'Order creation failed',
            'reference' => $transaction->stripe_transaction_id
        ],
        sendEmail: true
    );

    // Notify admins
    $adminIds = User::where('role', 2)->pluck('id')->toArray();
    if (!empty($adminIds)) {
        $this->notificationService->sendToMultipleUsers(
            userIds: $adminIds,
            type: 'system',
            title: 'URGENT: Payment Received, Order Failed',
            message: "Payment of \${$amount} received but order creation failed. Transaction: {$transaction->stripe_transaction_id}",
            data: [
                'transaction_id' => $transaction->id,
                'buyer_id' => $buyerId,
                'amount' => $amount,
                'error' => $e->getMessage()
            ],
            sendEmail: true
        );
    }

    throw $e;
}
```

---

### 2.8 Order Status Manually Changed by Admin

**Notification ID:** NOTIF-011
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php` (order management section)

**Trigger:** Admin manually changes order status

**Recipients:** Buyer, Seller

**Logic to Add:**
```php
// After status update
$order = BookOrder::find($orderId);
$statusNames = [
    0 => 'Pending',
    1 => 'Active',
    2 => 'Delivered',
    3 => 'Completed',
    4 => 'Cancelled'
];

// Notify buyer
$this->notificationService->send(
    userId: $order->user_id,
    type: 'order',
    title: 'Order Status Updated',
    message: "Your order status for '{$order->teacherGig->title}' has been updated to: {$statusNames[$newStatus]}",
    data: [
        'order_id' => $orderId,
        'old_status' => $oldStatus,
        'new_status' => $newStatus,
        'reason' => $reason ?? 'Admin intervention'
    ],
    sendEmail: true
);

// Notify seller
$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'order',
    title: 'Order Status Updated by Admin',
    message: "Order #{$orderId} status has been changed to: {$statusNames[$newStatus]} by admin.",
    data: [
        'order_id' => $orderId,
        'old_status' => $oldStatus,
        'new_status' => $newStatus,
        'reason' => $reason ?? 'Admin intervention'
    ],
    sendEmail: true
);
```

---

### 2.9 Dispute Resolved by Admin (Manual Decision)

**Notification ID:** NOTIF-012
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php` (dispute management)

**Trigger:** Admin manually resolves dispute

**Recipients:** Buyer, Seller

**Logic to Add:**
```php
// After dispute resolution
$order = BookOrder::find($orderId);
$dispute = DisputeOrder::where('order_id', $orderId)->first();

// Notify buyer
$this->notificationService->send(
    userId: $order->user_id,
    type: 'dispute',
    title: 'Dispute Resolved',
    message: "Your dispute for order #{$orderId} has been resolved. Decision: {$decision}",
    data: [
        'order_id' => $orderId,
        'dispute_id' => $dispute->id,
        'decision' => $decision,
        'refund_amount' => $refundAmount ?? 0,
        'resolved_at' => now()->toISOString()
    ],
    sendEmail: true
);

// Notify seller
$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'dispute',
    title: 'Dispute Resolved by Admin',
    message: "Dispute for order #{$orderId} has been resolved by admin. Decision: {$decision}",
    data: [
        'order_id' => $orderId,
        'dispute_id' => $dispute->id,
        'decision' => $decision,
        'refund_amount' => $refundAmount ?? 0,
        'resolved_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

---

### 2.10 Manual Refund Issued by Admin

**Notification ID:** NOTIF-013
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php` (refund management)

**Trigger:** Admin manually issues refund outside dispute process

**Recipients:** Buyer, Seller, Admin (confirmation)

**Logic to Add:**
```php
// After refund is processed
$order = BookOrder::find($orderId);

// Notify buyer
$this->notificationService->send(
    userId: $order->user_id,
    type: 'payment',
    title: 'Refund Issued',
    message: "A refund of \${$amount} has been issued for order #{$orderId}. Reason: {$reason}",
    data: [
        'order_id' => $orderId,
        'refund_amount' => $amount,
        'reason' => $reason,
        'refunded_at' => now()->toISOString()
    ],
    sendEmail: true
);

// Notify seller
$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'payment',
    title: 'Refund Issued for Your Order',
    message: "A refund of \${$amount} has been issued for your order #{$orderId}. This will be deducted from your next payout.",
    data: [
        'order_id' => $orderId,
        'refund_amount' => $amount,
        'reason' => $reason,
        'refunded_at' => now()->toISOString()
    ],
    sendEmail: true
);
```

---

## Phase 3: Medium Priority Notifications

**Priority:** 🟡 MEDIUM
**Estimated Effort:** 45 hours
**Business Impact:** Enhances user experience

### 3.1 Coupon Expiring Soon (Buyer)

**Notification ID:** NOTIF-014
**Effort:** 6 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** Create new file `app/Console/Commands/NotifyCouponExpiring.php`

**Trigger:** Scheduled command runs daily, checks coupons expiring in 3 days

**Recipients:** Users who have access to the coupon

**Command Structure:**
```php
<?php

namespace App\Console\Commands;

use App\Models\Coupon;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotifyCouponExpiring extends Command
{
    protected $signature = 'coupons:notify-expiring {--dry-run : Run without sending notifications}';
    protected $description = 'Notify users about coupons expiring in 3 days';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        Log::info('Coupon expiring notification command started', [
            'timestamp' => now()->toDateTimeString(),
            'dry_run' => $isDryRun
        ]);

        // Find coupons expiring in 3 days
        $expiringCoupons = Coupon::where('status', 1) // Active coupons
            ->whereBetween('expiry_date', [
                now()->addDays(3)->startOfDay(),
                now()->addDays(3)->endOfDay()
            ])
            ->get();

        $notificationCount = 0;

        foreach ($expiringCoupons as $coupon) {
            // Get users who can use this coupon
            $userIds = [];

            if ($coupon->user_specific == 1 && $coupon->user_id) {
                // User-specific coupon
                $userIds = [$coupon->user_id];
            } else {
                // Public coupon - notify all buyers who haven't used it
                $userIds = User::where('role', 0) // Buyers only
                    ->whereDoesntHave('couponUsages', function($query) use ($coupon) {
                        $query->where('coupon_id', $coupon->id);
                    })
                    ->pluck('id')
                    ->toArray();
            }

            if (!empty($userIds) && !$isDryRun) {
                $this->notificationService->sendToMultipleUsers(
                    userIds: $userIds,
                    type: 'coupon',
                    title: 'Coupon Expiring Soon!',
                    message: "Your coupon '{$coupon->code}' expires in 3 days! Use it before " . $coupon->expiry_date->format('M d, Y'),
                    data: [
                        'coupon_id' => $coupon->id,
                        'coupon_code' => $coupon->code,
                        'discount' => $coupon->discount_type == 'fixed' ? "\${$coupon->discount}" : "{$coupon->discount}%",
                        'expiry_date' => $coupon->expiry_date->toISOString()
                    ],
                    sendEmail: true
                );

                $notificationCount += count($userIds);
            }

            $this->info("Coupon '{$coupon->code}': " . count($userIds) . " users notified");
        }

        Log::info('Coupon expiring notifications completed', [
            'coupons_checked' => $expiringCoupons->count(),
            'notifications_sent' => $notificationCount,
            'dry_run' => $isDryRun
        ]);

        $this->info("✓ Sent {$notificationCount} notifications for {$expiringCoupons->count()} expiring coupons");

        return 0;
    }
}
```

**Schedule Registration:**
```php
$schedule->command('coupons:notify-expiring')
    ->dailyAt('09:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/coupon-expiring.log'));
```

---

### 3.2 Service Edited by Seller

**Notification ID:** NOTIF-015
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/ClassManagementController.php` (update function)

**Trigger:** Seller updates existing published service

**Recipients:** Admins (for monitoring)

**Logic to Add:**
```php
// After service update
$adminIds = User::where('role', 2)->pluck('id')->toArray();

if (!empty($adminIds)) {
    $this->notificationService->sendToMultipleUsers(
        userIds: $adminIds,
        type: 'gig',
        title: 'Service Updated',
        message: "{$seller->first_name} {$seller->last_name} has updated their service '{$gig->title}'",
        data: [
            'gig_id' => $gig->id,
            'seller_id' => $seller->id,
            'updated_fields' => $changedFields ?? []
        ],
        sendEmail: false
    );
}
```

---

### 3.3 Zoom Account Disconnected

**Notification ID:** NOTIF-016
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/ZoomController.php` or account controller

**Trigger:** Seller manually disconnects Zoom integration

**Recipients:** Seller

**Logic to Add:**
```php
// After Zoom disconnect
$this->notificationService->send(
    userId: Auth::id(),
    type: 'zoom',
    title: 'Zoom Account Disconnected',
    message: 'Your Zoom account has been disconnected. You will need to reconnect it to host live classes.',
    data: [
        'disconnected_at' => now()->toISOString(),
        'reconnect_url' => route('teacher.zoom.connect')
    ],
    sendEmail: false
);
```

---

### 3.4 Zoom Meeting Creation Failed

**Notification ID:** NOTIF-017
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Console/Commands/GenerateZoomMeetings.php:148`

**Trigger:** Zoom API returns error when creating meeting

**Recipients:** Seller, Admin

**Logic to Add:**
```php
// In catch block when meeting creation fails
catch (\Exception $e) {
    Log::error('Zoom meeting creation failed', [
        'class_date_id' => $classDate->id,
        'seller_id' => $seller->id,
        'error' => $e->getMessage()
    ]);

    // Notify seller
    $this->notificationService->send(
        userId: $seller->id,
        type: 'zoom',
        title: 'Zoom Meeting Creation Failed',
        message: "Failed to create Zoom meeting for '{$gig->title}'. Please check your Zoom connection.",
        data: [
            'class_date_id' => $classDate->id,
            'error' => $e->getMessage(),
            'reconnect_url' => route('teacher.zoom.connect')
        ],
        sendEmail: true
    );

    // Notify admin
    $adminIds = User::where('role', 2)->pluck('id')->toArray();
    if (!empty($adminIds)) {
        $this->notificationService->sendToMultipleUsers(
            userIds: $adminIds,
            type: 'system',
            title: 'Zoom Meeting Creation Failed',
            message: "Zoom meeting creation failed for class #{$classDate->id}. Error: {$e->getMessage()}",
            data: [
                'class_date_id' => $classDate->id,
                'seller_id' => $seller->id,
                'error' => $e->getMessage()
            ],
            sendEmail: false
        );
    }
}
```

---

### 3.5 Class Ended - Request Review

**Notification ID:** NOTIF-018
**Effort:** 5 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** Create new file `app/Console/Commands/SendReviewReminders.php`

**Trigger:** 2 hours after class end time

**Recipients:** Buyer

**Command Structure:**
```php
<?php

namespace App\Console\Commands;

use App\Models\ClassDate;
use App\Models\ServiceReviews;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendReviewReminders extends Command
{
    protected $signature = 'reminders:send-review-reminders';
    protected $description = 'Send review reminders to buyers 2 hours after class ends';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        Log::info('Review reminder command started');

        // Find classes that ended 2 hours ago
        $endedClasses = ClassDate::whereBetween('class_date', [
            now()->subHours(3),
            now()->subHours(2)
        ])->with(['bookOrder.user', 'bookOrder.teacherGig.user'])->get();

        $remindersSent = 0;

        foreach ($endedClasses as $classDate) {
            $order = $classDate->bookOrder;

            // Check if buyer already reviewed
            $hasReviewed = ServiceReviews::where('order_id', $order->id)->exists();

            if (!$hasReviewed) {
                $seller = $order->teacherGig->user;

                $this->notificationService->send(
                    userId: $order->user_id,
                    type: 'review',
                    title: 'How Was Your Class?',
                    message: "How was your class with {$seller->first_name}? Please leave a review to help others.",
                    data: [
                        'order_id' => $order->id,
                        'gig_id' => $order->teacher_gig_id,
                        'review_url' => route('user.review', $order->id)
                    ],
                    sendEmail: false
                );

                $remindersSent++;
            }
        }

        Log::info('Review reminders sent', ['count' => $remindersSent]);
        $this->info("✓ Sent {$remindersSent} review reminders");

        return 0;
    }
}
```

**Schedule Registration:**
```php
$schedule->command('reminders:send-review-reminders')
    ->everyTwoHours()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/review-reminders.log'));
```

---

### 3.6 Recurring Class - Next Session Reminder

**Notification ID:** NOTIF-019
**Effort:** 4 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** Add to `app/Console/Commands/SendClassReminders.php`

**Trigger:** 3 days before next recurring session

**Recipients:** Buyer (subscription orders)

**Logic to Add:**
```php
// In the SendClassReminders command
$recurringClassesIn3Days = ClassDate::whereBetween('class_date', [
    now()->addDays(3)->startOfDay(),
    now()->addDays(3)->endOfDay()
])
->whereHas('bookOrder', function($query) {
    $query->where('subscription', 1); // Subscription orders only
})
->with(['bookOrder.user', 'bookOrder.teacherGig'])
->get();

foreach ($recurringClassesIn3Days as $classDate) {
    $order = $classDate->bookOrder;

    $this->notificationService->send(
        userId: $order->user_id,
        type: 'class',
        title: 'Next Session Reminder',
        message: "Your next session of '{$order->teacherGig->title}' is scheduled for " . $classDate->class_date->format('l, M d') . " at " . $classDate->class_date->format('h:i A'),
        data: [
            'order_id' => $order->id,
            'class_date_id' => $classDate->id,
            'next_class_date' => $classDate->class_date->toISOString()
        ],
        sendEmail: true
    );
}
```

---

### 3.7 Platform-Wide Commission Rate Change

**Notification ID:** NOTIF-020
**Effort:** 4 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php` (global settings)

**Trigger:** Admin updates default platform commission rate

**Recipients:** All active sellers

**Logic to Add:**
```php
// After updating TopSellerTag commission settings
$activeSellerIds = User::where('role', 1) // Sellers
    ->where('status', 1) // Active
    ->pluck('id')
    ->toArray();

if (!empty($activeSellerIds)) {
    $this->notificationService->sendToMultipleUsers(
        userIds: $activeSellerIds,
        type: 'account',
        title: 'Platform Commission Rate Updated',
        message: "Platform commission rate has been updated from {$oldRate}% to {$newRate}%. This affects all services without custom rates.",
        data: [
            'old_rate' => $oldRate,
            'new_rate' => $newRate,
            'effective_date' => now()->toISOString()
        ],
        sendEmail: true
    );
}

$this->info("Notified " . count($activeSellerIds) . " sellers");
```

---

### 3.8 Review Edited by Buyer

**Notification ID:** NOTIF-021
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/TeacherController.php` (if edit review feature exists)

**Trigger:** Buyer edits their existing review

**Recipients:** Seller

**Logic to Add:**
```php
// After review update
$review = ServiceReviews::find($reviewId);
$order = BookOrder::find($review->order_id);

$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'review',
    title: 'Review Updated',
    message: "{$buyer->first_name} has updated their review for '{$order->teacherGig->title}'.",
    data: [
        'review_id' => $reviewId,
        'order_id' => $order->id,
        'gig_id' => $order->teacher_gig_id,
        'rating' => $review->rating
    ],
    sendEmail: false
);
```

---

### 3.9 Seller Account Suspension

**Notification ID:** NOTIF-022
**Effort:** 3 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php` (if suspension feature exists)

**Trigger:** Admin suspends seller account

**Recipients:** Seller, Admin (confirmation)

**Logic to Add:**
```php
// After account suspension
$seller = User::find($sellerId);

// Notify seller
$this->notificationService->send(
    userId: $sellerId,
    type: 'account',
    title: 'Account Suspended',
    message: "Your account has been suspended due to: {$reason}. Please contact support for assistance.",
    data: [
        'suspension_reason' => $reason,
        'suspended_at' => now()->toISOString(),
        'duration' => $duration ?? null,
        'support_url' => route('contact')
    ],
    sendEmail: true
);

// Notify admin (confirmation)
$this->notificationService->send(
    userId: Auth::id(),
    type: 'system',
    title: 'Account Suspension Confirmed',
    message: "Seller account #{$sellerId} has been suspended successfully.",
    data: [
        'seller_id' => $sellerId,
        'suspension_reason' => $reason
    ],
    sendEmail: false
);
```

---

### 3.10 Scheduled Command Failure Notification

**Notification ID:** NOTIF-023
**Effort:** 4 hours (add to all commands)
**Status:** ⏳ Pending

#### Implementation Details

**Files:** All scheduled commands in `app/Console/Commands/`

**Trigger:** Scheduled command throws exception

**Recipients:** Admin

**Pattern to Add to All Commands:**
```php
public function handle()
{
    try {
        // Existing command logic

    } catch (\Exception $e) {
        Log::error("Command {$this->signature} failed", [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        // Notify admins
        $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();

        if (!empty($adminIds)) {
            app(\App\Services\NotificationService::class)->sendToMultipleUsers(
                userIds: $adminIds,
                type: 'system',
                title: 'Scheduled Command Failed',
                message: "Scheduled command '{$this->signature}' failed. Error: {$e->getMessage()}",
                data: [
                    'command' => $this->signature,
                    'error' => $e->getMessage(),
                    'timestamp' => now()->toISOString()
                ],
                sendEmail: true
            );
        }

        throw $e;
    }

    return 0;
}
```

**Commands to Update:**
- UpdateTeacherGigStatus.php
- AutoCancelPendingOrders.php
- AutoMarkDelivered.php
- AutoMarkCompleted.php
- AutoHandleDisputes.php
- GenerateZoomMeetings.php
- RefreshZoomToken.php
- GenerateTrialMeetingLinks.php

---

## Phase 4: Low Priority Notifications

**Priority:** 🟢 LOW
**Estimated Effort:** 37 hours
**Business Impact:** Nice-to-have enhancements

### 4.1 Email Verification Success

**Notification ID:** NOTIF-024
**Effort:** 1 hour
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AuthController.php` (verification callback)

**Trigger:** User successfully verifies email

**Recipients:** User

**Logic to Add:**
```php
// After email verification
$this->notificationService->send(
    userId: Auth::id(),
    type: 'account',
    title: 'Email Verified Successfully',
    message: 'Your email has been verified successfully. You now have full access to DreamCrowd.',
    data: [
        'verified_at' => now()->toISOString()
    ],
    sendEmail: false // Redundant since email was just verified
);
```

---

### 4.2 Email Verification Reminder

**Notification ID:** NOTIF-025
**Effort:** 5 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** Create new file `app/Console/Commands/SendEmailVerificationReminders.php`

**Trigger:** Scheduled task checks users with unverified emails after 24, 48, 72 hours

**Recipients:** Unverified users

**Command Structure:**
```php
<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendEmailVerificationReminders extends Command
{
    protected $signature = 'reminders:email-verification';
    protected $description = 'Send email verification reminders to unverified users';

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        Log::info('Email verification reminder command started');

        $intervals = [24, 48, 72]; // Hours after registration
        $remindersSent = 0;

        foreach ($intervals as $hours) {
            $users = User::whereNull('email_verified_at')
                ->whereBetween('created_at', [
                    now()->subHours($hours + 1),
                    now()->subHours($hours - 1)
                ])
                ->get();

            foreach ($users as $user) {
                $this->notificationService->send(
                    userId: $user->id,
                    type: 'account',
                    title: 'Please Verify Your Email',
                    message: "You haven't verified your email yet. Please verify to unlock all features.",
                    data: [
                        'registration_date' => $user->created_at->toISOString(),
                        'verification_link' => route('verification.notice')
                    ],
                    sendEmail: true
                );

                $remindersSent++;
            }
        }

        Log::info('Email verification reminders sent', ['count' => $remindersSent]);
        $this->info("✓ Sent {$remindersSent} verification reminders");

        return 0;
    }
}
```

**Schedule Registration:**
```php
$schedule->command('reminders:email-verification')
    ->dailyAt('11:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/email-verification-reminders.log'));
```

---

### 4.3 New Coupon Available

**Notification ID:** NOTIF-026
**Effort:** 5 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/CouponController.php` (when admin creates public coupon)

**Trigger:** Admin creates new public coupon

**Recipients:** All buyers or targeted user segment

**Logic to Add:**
```php
// After coupon creation
if ($coupon->user_specific == 0) { // Public coupon
    $targetUserIds = User::where('role', 0) // All buyers
        ->where('status', 1) // Active only
        ->pluck('id')
        ->toArray();

    if (!empty($targetUserIds)) {
        $discount = $coupon->discount_type == 'fixed'
            ? "\${$coupon->discount}"
            : "{$coupon->discount}%";

        $this->notificationService->sendToMultipleUsers(
            userIds: $targetUserIds,
            type: 'coupon',
            title: 'New Coupon Available!',
            message: "New coupon available! Use code '{$coupon->code}' for {$discount} off.",
            data: [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount' => $discount,
                'expiry_date' => $coupon->expiry_date ? $coupon->expiry_date->toISOString() : null
            ],
            sendEmail: true
        );

        $this->info("Notified " . count($targetUserIds) . " users");
    }
}
```

---

### 4.4 High Rating Received (Milestone)

**Notification ID:** NOTIF-027
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/TeacherController.php` (after review submission)

**Trigger:** Seller receives 5-star review

**Recipients:** Seller

**Logic to Add:**
```php
// After review is saved
if ($review->rating == 5) {
    $order = BookOrder::find($review->order_id);
    $buyer = User::find($review->user_id);

    $this->notificationService->send(
        userId: $order->teacher_id,
        type: 'review',
        title: 'Congratulations! 5-Star Review',
        message: "Congratulations! You received a 5-star review from {$buyer->first_name} for '{$order->teacherGig->title}'!",
        data: [
            'review_id' => $review->id,
            'order_id' => $order->id,
            'rating' => 5
        ],
        sendEmail: false
    );
}
```

---

### 4.5 Service Featured/Promoted by Admin

**Notification ID:** NOTIF-028
**Effort:** 2 hours
**Status:** ⏳ Pending

#### Implementation Details

**File:** `app/Http/Controllers/AdminController.php` (if featured/promotion feature exists)

**Trigger:** Admin marks service as featured or promoted

**Recipients:** Seller

**Logic to Add:**
```php
// After marking service as featured
$gig = TeacherGig::find($gigId);

$this->notificationService->send(
    userId: $gig->user_id,
    type: 'gig',
    title: 'Service Featured!',
    message: "Great news! Your service '{$gig->title}' has been featured on the homepage.",
    data: [
        'gig_id' => $gigId,
        'featured_at' => now()->toISOString(),
        'featured_until' => $featuredUntil ?? null
    ],
    sendEmail: true
);
```

---

### Additional Low Priority Notifications

The following notifications follow similar patterns to those above:

- **NOTIF-029:** Account Role Changed
- **NOTIF-030:** Account Deletion Request Confirmation
- **NOTIF-031:** Coupon Expired
- **NOTIF-032:** Service Deactivated by Seller
- **NOTIF-033:** Commission Override Removed
- **NOTIF-034:** Payout Schedule Changed
- **NOTIF-035:** Review Deleted by Admin
- **NOTIF-036:** Zoom Meeting Cancelled
- **NOTIF-037:** Large File Upload Failed

(Detailed implementation for each can be added as needed)

---

## Code Patterns & Standards

### Pattern 1: Controller Dependency Injection

```php
use App\Services\NotificationService;

class YourController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function yourMethod()
    {
        // Your logic...

        $this->notificationService->send(
            userId: $userId,
            type: 'notification_type',
            title: 'Title',
            message: 'Message',
            data: ['key' => 'value'],
            sendEmail: true
        );
    }
}
```

### Pattern 2: Using app() Helper (Quick Implementation)

```php
app(\App\Services\NotificationService::class)->send(
    userId: $userId,
    type: 'type',
    title: 'Title',
    message: 'Message',
    data: [],
    sendEmail: false
);
```

### Pattern 3: Multi-User Notifications

```php
$adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();

if (!empty($adminIds)) {
    $this->notificationService->sendToMultipleUsers(
        userIds: $adminIds,
        type: 'type',
        title: 'Title',
        message: 'Message',
        data: [],
        sendEmail: false
    );
}
```

### Pattern 4: Scheduled Command Structure

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class YourCommand extends Command
{
    protected $signature = 'your:command';
    protected $description = 'Command description';
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    public function handle()
    {
        try {
            // Your logic...

            $this->notificationService->send(
                userId: $userId,
                type: 'type',
                title: 'Title',
                message: 'Message',
                data: [],
                sendEmail: true
            );

            $this->info('Success message');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            \Log::error('Command failed: ' . $e->getMessage());

            // Notify admin of failure
            $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
            $this->notificationService->sendToMultipleUsers(
                userIds: $adminIds,
                type: 'system',
                title: 'Command Failed',
                message: 'Command failed: ' . $e->getMessage(),
                data: ['error' => $e->getMessage()],
                sendEmail: true
            );
        }

        return 0;
    }
}
```

### Pattern 5: Error Handling with Notifications

```php
try {
    // Business logic that might fail
    $result = $someService->processPayment();
} catch (\Exception $e) {
    \Log::error('Operation failed: ' . $e->getMessage());

    // Notify user
    app(\App\Services\NotificationService::class)->send(
        userId: $userId,
        type: 'payment',
        title: 'Error',
        message: 'We encountered an error. Our team has been notified.',
        data: ['error' => $e->getMessage()],
        sendEmail: true
    );

    // Notify admin
    $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
    app(\App\Services\NotificationService::class)->sendToMultipleUsers(
        userIds: $adminIds,
        type: 'system',
        title: 'Operation Failed',
        message: 'URGENT: Operation failed for user #' . $userId,
        data: ['user_id' => $userId, 'error' => $e->getMessage()],
        sendEmail: true
    );

    throw $e;
}
```

---

## Testing Procedures

### Per-Notification Testing Checklist

For each notification implemented, verify:

- [ ] **Database Record:** Notification appears in `notifications` table
- [ ] **Pusher Broadcast:** Real-time notification received (check browser console)
- [ ] **Email Sent:** If `sendEmail: true`, email is sent (check Mailtrap/logs)
- [ ] **Dashboard Display:** Notification appears in user/teacher/admin dashboard
- [ ] **Unread Count:** Badge count increments correctly
- [ ] **Data Payload:** All expected data fields are present and correct
- [ ] **No Errors:** No errors in Laravel logs (`storage/logs/laravel.log`)
- [ ] **Existing Functionality:** No existing features broken
- [ ] **User Targeting:** Correct users receive the notification
- [ ] **Message Content:** Message is clear and actionable

### Manual Testing Steps

1. **Trigger the Event:**
   - Perform the action that should trigger the notification
   - For scheduled commands, run manually: `php artisan your:command`

2. **Check Database:**
   ```bash
   php artisan db
   SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5;
   ```

3. **Check Pusher (Browser Console):**
   - Open dashboard page
   - Trigger notification
   - Check console for Pusher event

4. **Check Email:**
   - If using Mailtrap, check inbox
   - If using log driver, check `storage/logs/laravel.log`

5. **Check Dashboard:**
   - Navigate to notification page
   - Verify notification appears
   - Click notification to mark as read
   - Verify read status updates

### Automated Testing (Optional)

Create feature tests for critical notifications:

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_confirmation_notification_sent()
    {
        $seller = User::factory()->create(['role' => 1]);
        $buyer = User::factory()->create(['role' => 0]);

        // Trigger order creation
        $response = $this->actingAs($buyer)->post('/order/create', [
            // Order data
        ]);

        // Assert notifications created
        $this->assertDatabaseHas('notifications', [
            'user_id' => $seller->id,
            'type' => 'order',
            'title' => 'New Order Received'
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $buyer->id,
            'type' => 'order',
            'title' => 'Order Placed Successfully'
        ]);
    }
}
```

---

## Risk Mitigation

### Safety Measures

1. **No Code Deletion**
   - Only add new code, never remove or modify existing functionality
   - Keep all existing notification calls intact

2. **Dependency Injection**
   - Always use constructor dependency injection for NotificationService
   - Maintains consistency and testability

3. **Error Handling**
   - Wrap notification calls in try-catch where appropriate
   - Log all errors
   - Never let notification failures break main business logic

4. **Database Transactions**
   - Use database transactions for critical operations
   - Ensure data consistency

5. **Testing Before Deployment**
   - Test each notification thoroughly in development
   - Use --dry-run flag for scheduled commands
   - Verify email sending works correctly

6. **Logging**
   - Log all notification sends for debugging
   - Use descriptive log messages
   - Include relevant context (user_id, order_id, etc.)

7. **Rollback Plan**
   - Create git commit after each phase
   - Document changes in commit messages
   - Easy rollback if issues occur

### Error Handling Best Practices

```php
// Wrap in try-catch to prevent failures from breaking business logic
try {
    $this->notificationService->send(
        userId: $userId,
        type: 'order',
        title: 'Order Confirmed',
        message: 'Your order has been confirmed.',
        data: ['order_id' => $orderId],
        sendEmail: true
    );
} catch (\Exception $e) {
    // Log error but don't fail the main operation
    \Log::error('Notification failed', [
        'user_id' => $userId,
        'error' => $e->getMessage()
    ]);
    // Don't re-throw - continue with main business logic
}
```

### Git Commit Strategy

Create commits after each phase:

```bash
# Phase 1
git add .
git commit -m "feat: Implement Phase 1 critical notifications (class reminders, Zoom token failures)"

# Phase 2
git add .
git commit -m "feat: Implement Phase 2 high priority notifications (commission rates, bank verification, profile updates)"

# And so on...
```

---

## Progress Tracking

### Implementation Status

| Phase | Category | Notifications | Status | Completed | Remaining |
|-------|----------|---------------|--------|-----------|-----------|
| 1 | Critical | 2 | ⏳ Pending | 0 | 2 |
| 2 | High Priority | 12 | ⏳ Pending | 0 | 12 |
| 3 | Medium Priority | 15 | ⏳ Pending | 0 | 15 |
| 4 | Low Priority | 16 | ⏳ Pending | 0 | 16 |
| **Total** | | **45** | | **0** | **45** |

### Phase Completion Tracking

#### Phase 1: Critical (0/2 completed)

- [ ] NOTIF-001: Class Starting in 24 Hours
- [ ] NOTIF-002: Class Starting in 1 Hour
- [ ] NOTIF-003: Zoom Token Refresh Failed

#### Phase 2: High Priority (0/12 completed)

- [ ] NOTIF-004: Commission Rate Updated for Seller
- [ ] NOTIF-005: Commission Rate Updated for Service
- [ ] NOTIF-006: Bank Account Verification Success
- [ ] NOTIF-007: Bank Account Verification Failed
- [ ] NOTIF-008: Seller Profile Update Approved
- [ ] NOTIF-009: Seller Profile Update Rejected
- [ ] NOTIF-010: Payment Processing Error
- [ ] NOTIF-011: Order Status Manually Changed
- [ ] NOTIF-012: Dispute Resolved by Admin
- [ ] NOTIF-013: Manual Refund Issued

#### Phase 3: Medium Priority (0/15 completed)

- [ ] NOTIF-014: Coupon Expiring Soon
- [ ] NOTIF-015: Service Edited by Seller
- [ ] NOTIF-016: Zoom Account Disconnected
- [ ] NOTIF-017: Zoom Meeting Creation Failed
- [ ] NOTIF-018: Class Ended - Request Review
- [ ] NOTIF-019: Recurring Class Next Session
- [ ] NOTIF-020: Platform-Wide Commission Change
- [ ] NOTIF-021: Review Edited by Buyer
- [ ] NOTIF-022: Seller Account Suspension
- [ ] NOTIF-023: Scheduled Command Failures

#### Phase 4: Low Priority (0/16 completed)

- [ ] NOTIF-024: Email Verification Success
- [ ] NOTIF-025: Email Verification Reminder
- [ ] NOTIF-026: New Coupon Available
- [ ] NOTIF-027: High Rating Milestone
- [ ] NOTIF-028: Service Featured/Promoted
- [ ] Additional low priority notifications...

### Daily Progress Log

**Format:** YYYY-MM-DD - [Phase X] Notification Name - Status

```
2025-11-07 - Planning phase completed
2025-11-08 - [Phase 1] Implementation started
...
```

(Update this section daily as implementation progresses)

---

## Appendix A: File Locations Quick Reference

### Controllers
- **AdminController.php** - Admin actions, approvals, payouts, commissions
- **OrderManagementController.php** - Order lifecycle, disputes, reschedules
- **BookingController.php** - Order creation, payment processing
- **StripeWebhookController.php** - Payment and payout webhooks
- **TeacherController.php** - Teacher dashboard operations
- **ClassManagementController.php** - Service/gig management
- **MessagesController.php** - Chat messaging
- **AuthController.php** - Authentication events

### Scheduled Commands
- **AutoCancelPendingOrders.php** - Every 10 minutes
- **AutoMarkDelivered.php** - Hourly
- **AutoMarkCompleted.php** - Every 6 hours
- **AutoHandleDisputes.php** - Daily at 3:00 AM
- **GenerateZoomMeetings.php** - Every 5 minutes
- **UpdateTeacherGigStatus.php** - Every 5 minutes
- **RefreshZoomToken.php** - Hourly
- **GenerateTrialMeetingLinks.php** - Every 5 minutes

### New Commands to Create
- **SendClassReminders.php** - Hourly (24hr and 1hr reminders)
- **NotifyCouponExpiring.php** - Daily at 9:00 AM
- **SendReviewReminders.php** - Every 2 hours
- **SendEmailVerificationReminders.php** - Daily at 11:00 AM

### Service Classes
- **NotificationService.php** - `/app/Services/NotificationService.php`
- **ZoomMeetingService.php** - `/app/Services/ZoomMeetingService.php`

### Models
- **Notification.php** - `/app/Models/Notification.php`
- **User.php** - `/app/Models/User.php`
- **BookOrder.php** - `/app/Models/BookOrder.php`
- **TeacherGig.php** - `/app/Models/TeacherGig.php`
- **ClassDate.php** - `/app/Models/ClassDate.php`
- **Coupon.php** - `/app/Models/Coupon.php`

---

## Appendix B: Notification Types Reference

| Type | Use Cases | Send Email? |
|------|-----------|-------------|
| `account` | Registration, verification, role changes, suspension, approval | Yes |
| `order` | New order, updates, delivery, completion | Yes |
| `payment` | Success, failure, refunds | Yes |
| `payout` | Scheduled, completed, failed | Yes |
| `cancellation` | Order cancellations | Yes |
| `dispute` | Opened, resolved, counter-dispute | Yes |
| `reschedule` | Request, approval, rejection | Yes |
| `class` | Reminders, Zoom links, start times | Yes |
| `review` | Received, replied, reminder | No |
| `message` | New message received | No |
| `gig` | Creation, approval, status changes | Varies |
| `coupon` | Usage, expiring, expired | Varies |
| `system` | Errors, admin alerts | Yes (admin) |
| `zoom` | Connected, disconnected, token issues | Yes |

---

## Appendix C: Email Sending Guidelines

### Send Email = True When:
- Financial transactions (payments, refunds, payouts)
- Account status changes (approval, rejection, suspension)
- Security events (password change, bank verification)
- Time-sensitive reminders (class starting, coupon expiring)
- Error notifications to admins
- User-initiated actions requiring confirmation
- Disputes and cancellations

### Send Email = False When:
- Real-time messaging notifications (handled via push)
- Low-priority updates (service edited, review reply)
- Notifications already sent via email in same flow
- High-frequency events (clicks, views, impressions)
- System-generated status updates

---

## Document Maintenance

### How to Update This Document

1. **After implementing a notification:**
   - Update the status in Progress Tracking section
   - Mark checkbox as completed
   - Update completion count
   - Add any notes or learnings

2. **If encountering issues:**
   - Document the issue in the specific notification section
   - Add workaround or solution
   - Update testing checklist if needed

3. **When discovering new requirements:**
   - Add new notification to appropriate phase
   - Update total count
   - Adjust effort estimates

4. **Version control:**
   - Commit this document with changes
   - Use descriptive commit messages

---

## Contact & Support

For questions about notification implementation:
- Review existing implementations in controllers listed in Appendix A
- Check `NotificationService.php` for available methods
- Test notifications in development before production
- Monitor logs in `storage/logs/` for notification errors

---

**Document Version:** 1.0
**Last Updated:** 2025-11-07
**Status:** Ready for Implementation
**Next Action:** Begin Phase 1 - Critical Notifications

---

**End of Implementation Plan**
