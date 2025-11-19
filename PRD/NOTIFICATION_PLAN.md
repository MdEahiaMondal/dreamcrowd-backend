# 🔔 DreamCrowd Notification System - Complete Implementation Plan

## 📋 Table of Contents
1. [Executive Summary](#executive-summary)
2. [Current System Status](#current-system-status)
3. [Notification Events Specification](#notification-events-specification)
4. [Technical Architecture](#technical-architecture)
5. [Implementation Phases](#implementation-phases)
   - [Phase 0: UI Integration & Notification Pages (CRITICAL)](#phase-0-ui-integration--notification-pages-priority-critical)
   - [Phase 1: Core Order Flow Notifications (HIGH)](#phase-1-core-order-flow-notifications-priority-high)
   - [Phase 2: Class Experience Notifications (MEDIUM)](#phase-2-class-experience-notifications-priority-medium)
   - [Phase 3: Zoom & Advanced Notifications (LOW)](#phase-3-zoom--advanced-notifications-priority-low)
6. [Message Templates](#message-templates)
7. [Database Schema](#database-schema)
8. [Testing & Acceptance Criteria](#testing--acceptance-criteria)
9. [Deployment Checklist](#deployment-checklist)

---

## 📊 Executive Summary

### Project Overview
DreamCrowd is a Laravel-based multi-sided marketplace connecting service providers (teachers/sellers) with customers (buyers/users). This document outlines the comprehensive notification system implementation using Laravel Notifications, Pusher for real-time updates, database persistence, and email delivery.

### Current Implementation Status
- **Infrastructure**: ✅ Complete (100%)
  - Database table and migrations
  - Notification model with relationships
  - NotificationService with Pusher broadcasting
  - Frontend JavaScript with real-time updates
  - Email integration with templates

- **Notification Triggers**: 🟡 Partial (15.4%)
  - ✅ Booking creation (to buyer, seller, admin)
  - ✅ Order acceptance (to buyer)
  - ❌ 15 critical events missing

- **UI/Frontend Pages**: ❌ Broken (0%)
  - ❌ Sidebar links point to non-existent `notification.html`
  - ❌ Notification pages show static dummy data
  - ❌ No web routes for notification pages
  - ❌ No integration between pages and API

### Coverage Analysis
| Category | Events | Implemented | Missing | Coverage |
|----------|--------|-------------|---------|----------|
| Order Flow | 6 | 2 | 4 | 33.3% |
| Class Lifecycle | 5 | 0 | 5 | 0% |
| Zoom Integration | 4 | 0 | 4 | 0% |
| Reviews & Feedback | 2 | 0 | 2 | 0% |
| **TOTAL** | **17** | **2** | **15** | **11.8%** |

### Development Effort Estimate
- **Phase 0 (UI Integration - NEW)**: 4-6 hours
- Phase 1 (Core Order Flow): 8-12 hours
- Phase 2 (Class Experience): 6-8 hours
- Phase 3 (Zoom & Advanced): 4-6 hours
- **Total**: 22-32 hours

---

## 🔍 Current System Status

### Infrastructure Components

#### 1. Database
**Migration**: `database/migrations/2025_10_22_061519_create_notifications_table.php`

```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_user_read (user_id, is_read),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### 2. Backend Components
- **Model**: `app/Models/Notification.php`
  - Belongs to User
  - Has `markAsRead()` method
  - Casts: `is_read` (boolean), `data` (array), `read_at` (datetime)

- **Controller**: `app/Http/Controllers/NotificationController.php`
  - `index()` - Paginated notifications (20/page)
  - `unreadCount()` - Count unread notifications
  - `markAsRead($id)` - Mark single as read
  - `markAllAsRead()` - Mark all as read
  - `delete($id)` - Delete notification

- **Service**: `app/Services/NotificationService.php`
  - `send($userId, $type, $title, $message, $data, $sendEmail)`
  - `sendToMultipleUsers($userIds, ...)`
  - Creates DB record, broadcasts via Pusher, sends email

- **Event**: `app/Events/NotificationSent.php`
  - Implements `ShouldBroadcast`
  - Channel: `user.{userId}`
  - Event name: `notification`

- **Mail**: `app/Mail/NotificationMail.php`
  - Template: `resources/views/emails/notification.blade.php`

#### 3. Pusher Configuration
```env
PUSHER_APP_CLUSTER=ap2
PUSHER_APP_KEY=cf6b96e5efc265f6c172
BROADCAST_DRIVER=pusher
```

**Broadcasting Channels** (`routes/channels.php`):
```php
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('message.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
```

#### 4. Frontend Implementation
**File**: `public/js/notifications.js`

**NotificationManager Class Features**:
- Pusher connection with auto-reconnect
- Bell icon with unread badge
- Dropdown menu with notification list
- Toast notifications for new events
- Mark as read/delete functionality
- Browser notification support
- Real-time updates

**UI Components**:
- Bell icon (SVG) with badge counter
- Dropdown menu (recent 10 notifications)
- Toast notification popup
- Message icon with separate badge

#### 5. API Routes
```php
// routes/web.php (lines 32-36)
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete']);
});
```

### Existing Notification Triggers

#### ✅ Implemented (2 events)

**1. Booking Creation**
- **Location**: `app/Http/Controllers/BookingController.php` (lines 728-765)
- **Trigger**: When buyer completes payment and booking is created
- **Recipients**:
  - **Seller**: "New Order Received" + buyer name + service name
  - **Buyer**: "Order Placed Successfully" + awaiting confirmation message
  - **Admin**: "Order Placed Successfully" + buyer + service details
- **Channels**: Email + In-App
- **Status**: ✅ Working

**2. Order Acceptance**
- **Location**: `app/Http/Controllers/OrderManagementController.php` (lines 1203-1210)
- **Trigger**: When seller accepts the order
- **Recipients**:
  - **Buyer**: "Order Accepted" + seller name + service name + start date
- **Channels**: Email + In-App
- **Status**: ✅ Working

---

## 🎯 Notification Events Specification

### Event Categories

1. **Order Flow Events** (6 events)
2. **Class Lifecycle Events** (5 events)
3. **Zoom Integration Events** (4 events)
4. **Review & Feedback Events** (2 events)

---

### 📦 1. ORDER FLOW EVENTS

#### 1.1 Booking Created
**Status**: ✅ Implemented

**Trigger**: Buyer completes payment and booking is confirmed

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Order Placed Successfully | Your booking for "{service_name}" is confirmed! Awaiting seller approval. |
| Seller | Email + In-App | New Order Received | You have a new booking request from {buyer_name} for {service_name}. Amount: ${amount} |
| Admin | In-App | New Order Created | New order placed by {buyer_name} for {service_name}. Order ID: #{order_id} |

**Data Payload**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "buyer_id": 45,
  "buyer_name": "John Doe",
  "seller_id": 12,
  "seller_name": "Teacher Name",
  "amount": 50.00,
  "service_type": "trial/oneoff/subscription"
}
```

---

#### 1.2 Order Accepted
**Status**: ✅ Implemented

**Trigger**: Seller accepts the booking request

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Order Accepted | {seller_name} has accepted your booking for "{service_name}". Class starts on {start_date}. |
| Seller | In-App | Order Accepted | You accepted the booking for {service_name} with {buyer_name}. |

**Data Payload**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "seller_id": 12,
  "seller_name": "Teacher Name",
  "buyer_id": 45,
  "start_date": "2025-11-10 10:00 AM"
}
```

---

#### 1.3 Order Rejected / Cancelled (Pending)
**Status**: ❌ Not Implemented

**Trigger**: Seller rejects/cancels pending order OR buyer cancels order

**Implementation Location**: `app/Http/Controllers/OrderManagementController.php` - `CancelOrder()` method (line 1222+)

**Recipients**:
| Scenario | Role | Channels | Title | Message |
|----------|------|----------|-------|---------|
| Seller cancels | Buyer | Email + In-App | Order Cancelled | Your booking for "{service_name}" was cancelled by the seller. Refund initiated. |
| Seller cancels | Seller | In-App | Order Cancelled | You cancelled the booking for {service_name} with {buyer_name}. |
| Seller cancels | Admin | In-App | Order Cancelled | Seller {seller_name} cancelled order #{order_id}. |
| Buyer cancels | Seller | Email + In-App | Order Cancelled by Buyer | {buyer_name} cancelled the booking for {service_name}. |
| Buyer cancels | Buyer | In-App | Order Cancelled | Your booking for "{service_name}" has been cancelled. Refund initiated. |
| Buyer cancels | Admin | In-App | Order Cancelled | Buyer {buyer_name} cancelled order #{order_id}. |

**Data Payload**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "cancelled_by": "seller/buyer",
  "cancelled_by_name": "John Doe",
  "reason": "Optional cancellation reason",
  "refund_amount": 50.00,
  "refund_status": "initiated/completed"
}
```

**Code Integration**:
```php
// In OrderManagementController.php - CancelOrder() method
// After line 1222 (after order is cancelled)

$cancelledBy = auth()->user()->role; // 'teacher' or 'user'
$cancelledByName = auth()->user()->name;

if ($cancelledBy === 'teacher') {
    // Notify buyer
    $this->notificationService->send(
        userId: $order->user_id,
        type: 'order_cancelled',
        title: 'Order Cancelled',
        message: "Your booking for \"{$order->teacherGig->name}\" was cancelled by the seller. Refund initiated.",
        data: [
            'order_id' => $order->id,
            'service_name' => $order->teacherGig->name,
            'cancelled_by' => 'seller',
            'cancelled_by_name' => $cancelledByName,
            'refund_amount' => $order->amount
        ],
        sendEmail: true
    );

    // Notify admin
    $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
    $this->notificationService->sendToMultipleUsers(
        userIds: $adminIds,
        type: 'order_cancelled',
        title: 'Order Cancelled by Seller',
        message: "Seller {$cancelledByName} cancelled order #{$order->id}.",
        data: ['order_id' => $order->id, 'seller_id' => $order->teacher_id],
        sendEmail: false
    );
} else {
    // Notify seller
    $this->notificationService->send(
        userId: $order->teacher_id,
        type: 'order_cancelled',
        title: 'Order Cancelled by Buyer',
        message: "{$cancelledByName} cancelled the booking for {$order->teacherGig->name}.",
        data: [
            'order_id' => $order->id,
            'service_name' => $order->teacherGig->name,
            'cancelled_by' => 'buyer',
            'cancelled_by_name' => $cancelledByName
        ],
        sendEmail: true
    );
}
```

---

#### 1.4 Order Delivered
**Status**: ❌ Not Implemented

**Trigger**: Automated command marks order as delivered after last class date passes

**Implementation Location**: `app/Console/Commands/AutoMarkDelivered.php` (line 141)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Order Delivered | Your service "{service_name}" has been delivered. You have 48 hours to report any issues. |
| Seller | In-App | Order Delivered | Your service "{service_name}" for {buyer_name} has been marked as delivered. |

**Data Payload**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "delivered_at": "2025-11-10 14:30:00",
  "dispute_deadline": "2025-11-12 14:30:00"
}
```

**Code Integration**:
```php
// In AutoMarkDelivered.php - after line 141 (after $order->save())

$this->notificationService->send(
    userId: $order->user_id,
    type: 'order_delivered',
    title: 'Order Delivered',
    message: "Your service \"{$order->teacherGig->name}\" has been delivered. You have 48 hours to report any issues.",
    data: [
        'order_id' => $order->id,
        'service_name' => $order->teacherGig->name,
        'delivered_at' => now()->toDateTimeString(),
        'dispute_deadline' => now()->addHours(48)->toDateTimeString()
    ],
    sendEmail: true
);

$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'order_delivered',
    title: 'Order Delivered',
    message: "Your service \"{$order->teacherGig->name}\" for {$order->user->name} has been marked as delivered.",
    data: [
        'order_id' => $order->id,
        'service_name' => $order->teacherGig->name,
        'buyer_name' => $order->user->name
    ],
    sendEmail: false
);
```

---

#### 1.5 Order Completed
**Status**: ❌ Not Implemented

**Trigger**: Automated command marks order as completed 48 hours after delivery (no disputes)

**Implementation Location**: `app/Console/Commands/AutoMarkCompleted.php` (line 108)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Order Completed | Your order for "{service_name}" is now complete. Thank you for choosing DreamCrowd! |
| Seller | Email + In-App | Order Completed - Payment Released | Your order for "{service_name}" is complete. Payment will be released soon. |
| Admin | In-App | Order Completed | Order #{order_id} completed. Ready for payout. |

**Data Payload**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "completed_at": "2025-11-12 14:30:00",
  "seller_payout": 42.50,
  "buyer_name": "John Doe"
}
```

**Code Integration**:
```php
// In AutoMarkCompleted.php - after line 108 (after $order->save())

$this->notificationService->send(
    userId: $order->user_id,
    type: 'order_completed',
    title: 'Order Completed',
    message: "Your order for \"{$order->teacherGig->name}\" is now complete. Thank you for choosing DreamCrowd!",
    data: [
        'order_id' => $order->id,
        'service_name' => $order->teacherGig->name,
        'completed_at' => now()->toDateTimeString()
    ],
    sendEmail: true
);

$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'order_completed',
    title: 'Order Completed - Payment Released',
    message: "Your order for \"{$order->teacherGig->name}\" is complete. Payment will be released soon.",
    data: [
        'order_id' => $order->id,
        'service_name' => $order->teacherGig->name,
        'buyer_name' => $order->user->name,
        'completed_at' => now()->toDateTimeString()
    ],
    sendEmail: true
);

$adminIds = User::where('role', 'admin')->pluck('id')->toArray();
$this->notificationService->sendToMultipleUsers(
    userIds: $adminIds,
    type: 'order_completed',
    title: 'Order Completed',
    message: "Order #{$order->id} completed. Ready for payout.",
    data: ['order_id' => $order->id, 'seller_id' => $order->teacher_id],
    sendEmail: false
);
```

---

#### 1.6 Dispute Created & Resolved
**Status**: ❌ Not Implemented

**Trigger**: Buyer creates dispute OR dispute is auto-resolved after 48 hours

**Implementation Locations**:
- Dispute Creation: `app/Http/Controllers/OrderManagementController.php` - `DisputeOrder()` method (line 1612+)
- Dispute Resolution: `app/Console/Commands/AutoHandleDisputes.php` (line 169)

**Recipients (Dispute Created)**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | Email + In-App | Dispute Raised | {buyer_name} has raised a dispute for order #{order_id}. You have 48 hours to respond. |
| Buyer | In-App | Dispute Submitted | Your dispute for "{service_name}" has been submitted. You'll receive updates soon. |
| Admin | Email + In-App | New Dispute Created | Dispute created for order #{order_id} by {buyer_name}. Reason: {reason} |

**Recipients (Dispute Resolved - Refund Processed)**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Refund Processed | Your dispute was resolved. Refund of ${amount} has been processed. |
| Seller | Email + In-App | Dispute Resolved | Dispute for order #{order_id} resolved. Refund issued to buyer. |
| Admin | In-App | Dispute Resolved | Dispute #{dispute_id} resolved. Refund processed. |

**Data Payload**:
```json
{
  "dispute_id": 45,
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "reason": "Service not delivered as promised",
  "refund_amount": 50.00,
  "dispute_status": "pending/resolved",
  "created_at": "2025-11-10 10:00:00"
}
```

---

### 📚 2. CLASS LIFECYCLE EVENTS

#### 2.1 Class Reminder (2 Hours Before)
**Status**: ❌ Not Implemented

**Trigger**: Scheduled command runs every 5 minutes to check classes starting in 2 hours

**Implementation**: New scheduled command `app/Console/Commands/ClassReminder.php`

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Class Starting Soon | Your class "{service_name}" with {seller_name} starts in 2 hours at {start_time}. |
| Seller | Email + In-App | Class Reminder | Your class "{service_name}" with {buyer_name} starts in 2 hours at {start_time}. |
| Guest Users | Email | Class Invitation Reminder | The class you were invited to starts in 2 hours. Click here to join. |

**Data Payload**:
```json
{
  "order_id": 123,
  "class_date_id": 45,
  "service_name": "Spoken English Trial Class",
  "start_time": "2025-11-10 12:00:00",
  "seller_name": "Teacher Name",
  "buyer_name": "John Doe",
  "duration_minutes": 60
}
```

**Scheduled Command Code**:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassDate;
use App\Services\NotificationService;
use Carbon\Carbon;

class ClassReminder extends Command
{
    protected $signature = 'classes:send-reminders';
    protected $description = 'Send class reminders 2 hours before class start time';

    public function __construct(private NotificationService $notificationService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $twoHoursFromNow = Carbon::now()->addHours(2);
        $startWindow = $twoHoursFromNow->copy()->subMinutes(5);
        $endWindow = $twoHoursFromNow->copy()->addMinutes(5);

        $upcomingClasses = ClassDate::whereBetween('start_time', [$startWindow, $endWindow])
            ->where('reminder_sent', false)
            ->with(['bookOrder.user', 'bookOrder.teacher', 'bookOrder.teacherGig'])
            ->get();

        foreach ($upcomingClasses as $classDate) {
            $order = $classDate->bookOrder;

            // Notify buyer
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'class_reminder',
                title: 'Class Starting Soon',
                message: "Your class \"{$order->teacherGig->name}\" with {$order->teacher->name} starts in 2 hours at {$classDate->start_time->format('h:i A')}.",
                data: [
                    'order_id' => $order->id,
                    'class_date_id' => $classDate->id,
                    'service_name' => $order->teacherGig->name,
                    'start_time' => $classDate->start_time->toDateTimeString(),
                    'seller_name' => $order->teacher->name
                ],
                sendEmail: true
            );

            // Notify seller
            $this->notificationService->send(
                userId: $order->teacher_id,
                type: 'class_reminder',
                title: 'Class Reminder',
                message: "Your class \"{$order->teacherGig->name}\" with {$order->user->name} starts in 2 hours at {$classDate->start_time->format('h:i A')}.",
                data: [
                    'order_id' => $order->id,
                    'class_date_id' => $classDate->id,
                    'service_name' => $order->teacherGig->name,
                    'start_time' => $classDate->start_time->toDateTimeString(),
                    'buyer_name' => $order->user->name
                ],
                sendEmail: true
            );

            // Mark reminder as sent
            $classDate->reminder_sent = true;
            $classDate->save();

            $this->info("Reminder sent for class #{$classDate->id}");
        }

        $this->info("Processed {$upcomingClasses->count()} class reminders");
    }
}
```

**Note**: Requires adding `reminder_sent` boolean column to `class_dates` table.

---

#### 2.2 Class Started
**Status**: ❌ Not Implemented

**Trigger**: Zoom webhook `meeting.started` event received

**Implementation Location**: `app/Http/Controllers/ZoomWebhookController.php` - `handleMeetingStarted()` method (line 154)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Class Started | Your live class has started! Click here to join the session. |
| Guest Users | Email | Class Started | The live class has started! Click here to join now. |
| Seller | In-App | Meeting Started | Your Zoom meeting for "{service_name}" has started successfully. |
| Admin | In-App | Class Started | Class "{service_name}" started by {seller_name}. |

**Data Payload**:
```json
{
  "meeting_id": "98765432100",
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "join_url": "https://dreamcrowd.com/join/secure-token",
  "started_at": "2025-11-10 12:00:00"
}
```

**Code Integration**:
```php
// In ZoomWebhookController.php - handleMeetingStarted() method (after line 154)

$meeting = ZoomMeeting::where('meeting_id', $payload['object']['id'])->first();
if ($meeting && $meeting->book_order_id) {
    $order = BookOrder::with(['user', 'teacher', 'teacherGig'])->find($meeting->book_order_id);

    if ($order) {
        // Notify buyer
        $secureToken = ZoomSecureToken::where('book_order_id', $order->id)->first();
        $joinUrl = $secureToken ? route('zoom.join', ['token' => $secureToken->token]) : null;

        $this->notificationService->send(
            userId: $order->user_id,
            type: 'class_started',
            title: 'Class Started',
            message: "Your live class has started! Click here to join the session.",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'join_url' => $joinUrl,
                'started_at' => now()->toDateTimeString()
            ],
            sendEmail: true
        );

        // Notify seller
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'class_started',
            title: 'Meeting Started',
            message: "Your Zoom meeting for \"{$order->teacherGig->name}\" has started successfully.",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name
            ],
            sendEmail: false
        );
    }
}
```

---

#### 2.3 Class Ended
**Status**: ❌ Not Implemented

**Trigger**: Zoom webhook `meeting.ended` event received

**Implementation Location**: `app/Http/Controllers/ZoomWebhookController.php` - `handleMeetingEnded()` method (line 188)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Class Ended | Your class with {seller_name} has ended. Please rate your experience! |
| Seller | In-App | Class Completed | Your class "{service_name}" completed successfully. Duration: {duration} minutes. |
| Admin | In-App | Class Ended | Class "{service_name}" ended. Total participants: {count}. |

**Data Payload**:
```json
{
  "meeting_id": "98765432100",
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "ended_at": "2025-11-10 13:00:00",
  "duration_minutes": 60,
  "participant_count": 5
}
```

**Code Integration**:
```php
// In ZoomWebhookController.php - handleMeetingEnded() method (after line 188)

$meeting = ZoomMeeting::where('meeting_id', $payload['object']['id'])->first();
if ($meeting && $meeting->book_order_id) {
    $order = BookOrder::with(['user', 'teacher', 'teacherGig'])->find($meeting->book_order_id);

    if ($order) {
        $duration = $payload['object']['duration'] ?? 0;
        $participantCount = ZoomParticipant::where('meeting_id', $meeting->meeting_id)->distinct('user_name')->count();

        // Notify buyer
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'class_ended',
            title: 'Class Ended',
            message: "Your class with {$order->teacher->name} has ended. Please rate your experience!",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'ended_at' => now()->toDateTimeString(),
                'duration_minutes' => $duration
            ],
            sendEmail: true
        );

        // Notify seller
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'class_ended',
            title: 'Class Completed',
            message: "Your class \"{$order->teacherGig->name}\" completed successfully. Duration: {$duration} minutes.",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'duration_minutes' => $duration,
                'participant_count' => $participantCount
            ],
            sendEmail: false
        );
    }
}
```

---

#### 2.4 Participant Joined
**Status**: ❌ Not Implemented (Optional - Low Priority)

**Trigger**: Zoom webhook `participant.joined` event received

**Implementation Location**: `app/Http/Controllers/ZoomWebhookController.php` - `handleParticipantJoined()` method (line 257)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | In-App | Participant Joined | {participant_name} joined your live class. |
| Admin | In-App | Participant Activity | {participant_name} joined class "{service_name}". |

**Data Payload**:
```json
{
  "meeting_id": "98765432100",
  "participant_name": "John Doe",
  "joined_at": "2025-11-10 12:05:00",
  "participant_count": 3
}
```

---

#### 2.5 Participant Left
**Status**: ❌ Not Implemented (Optional - Low Priority)

**Trigger**: Zoom webhook `participant.left` event received

**Implementation Location**: `app/Http/Controllers/ZoomWebhookController.php` - `handleParticipantLeft()` method (line 312)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | In-App | Participant Left | {participant_name} left your live class. |

---

### 🎥 3. ZOOM INTEGRATION EVENTS

#### 3.1 Zoom Account Connected
**Status**: ❌ Not Implemented

**Trigger**: Teacher successfully completes Zoom OAuth flow

**Implementation Location**: `app/Http/Controllers/ZoomOAuthController.php` - `callback()` method (line 164)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | Email + In-App | Zoom Connected | Your Zoom account has been connected successfully! You can now host live classes. |

**Data Payload**:
```json
{
  "zoom_email": "teacher@example.com",
  "connected_at": "2025-11-10 10:00:00",
  "expires_at": "2025-12-10 10:00:00"
}
```

**Code Integration**:
```php
// In ZoomOAuthController.php - callback() method (after line 164, after successful token save)

$this->notificationService->send(
    userId: auth()->id(),
    type: 'zoom_connected',
    title: 'Zoom Connected',
    message: 'Your Zoom account has been connected successfully! You can now host live classes.',
    data: [
        'zoom_email' => $zoomUser->email ?? 'N/A',
        'connected_at' => now()->toDateTimeString(),
        'expires_at' => now()->addDays(30)->toDateTimeString()
    ],
    sendEmail: true
);
```

---

#### 3.2 Zoom Token Expired
**Status**: ❌ Not Implemented

**Trigger**: Zoom token refresh fails in scheduled command

**Implementation Location**: `app/Console/Commands/RefreshZoomToken.php` (line 109)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | Email + In-App | Zoom Connection Expired | Your Zoom connection has expired. Please reconnect from your settings to continue hosting live sessions. |
| Admin | Email | Zoom Token Expired | Teacher {teacher_name} (ID: {teacher_id}) Zoom token refresh failed. |

**Data Payload**:
```json
{
  "teacher_id": 12,
  "teacher_name": "Teacher Name",
  "expired_at": "2025-11-10 10:00:00",
  "reconnect_url": "https://dreamcrowd.com/teacher/zoom/settings"
}
```

**Code Integration**:
```php
// In RefreshZoomToken.php - after line 109 (when token refresh fails)

if ($user && $user->teacher_id) {
    $this->notificationService->send(
        userId: $user->id,
        type: 'zoom_token_expired',
        title: 'Zoom Connection Expired',
        message: 'Your Zoom connection has expired. Please reconnect from your settings to continue hosting live sessions.',
        data: [
            'expired_at' => now()->toDateTimeString(),
            'reconnect_url' => route('teacher.zoom.settings')
        ],
        sendEmail: true
    );

    // Notify admin
    $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
    $this->notificationService->sendToMultipleUsers(
        userIds: $adminIds,
        type: 'zoom_token_expired',
        title: 'Zoom Token Refresh Failed',
        message: "Teacher {$user->name} (ID: {$user->teacher_id}) Zoom token refresh failed.",
        data: ['teacher_id' => $user->teacher_id, 'teacher_name' => $user->name],
        sendEmail: true
    );
}
```

---

#### 3.3 Zoom Meeting Creation Failed
**Status**: ❌ Not Implemented

**Trigger**: Zoom API fails to create meeting

**Implementation Location**: `app/Services/ZoomMeetingService.php` - `createMeeting()` method (lines 88-97)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | Email + In-App | Meeting Creation Failed | We could not create your Zoom meeting. Please check your Zoom connection and try again. |
| Admin | Email | Zoom API Error | Failed to create Zoom meeting for order #{order_id}. Error: {error_message} |

**Data Payload**:
```json
{
  "order_id": 123,
  "error_message": "Invalid access token",
  "failed_at": "2025-11-10 10:00:00",
  "teacher_id": 12
}
```

**Code Integration**:
```php
// In ZoomMeetingService.php - createMeeting() method (in catch block around line 90-97)

catch (\Exception $e) {
    Log::error('Zoom meeting creation failed', [
        'order_id' => $orderId,
        'error' => $e->getMessage()
    ]);

    if ($order) {
        // Notify teacher
        app(NotificationService::class)->send(
            userId: $order->teacher_id,
            type: 'zoom_meeting_failed',
            title: 'Meeting Creation Failed',
            message: 'We could not create your Zoom meeting. Please check your Zoom connection and try again.',
            data: [
                'order_id' => $orderId,
                'error_message' => $e->getMessage(),
                'failed_at' => now()->toDateTimeString()
            ],
            sendEmail: true
        );

        // Notify admin
        $adminIds = User::where('role', 'admin')->pluck('id')->toArray();
        app(NotificationService::class)->sendToMultipleUsers(
            userIds: $adminIds,
            type: 'zoom_meeting_failed',
            title: 'Zoom Meeting Creation Failed',
            message: "Failed to create Zoom meeting for order #{$orderId}. Error: {$e->getMessage()}",
            data: ['order_id' => $orderId, 'teacher_id' => $order->teacher_id],
            sendEmail: true
        );
    }

    return null;
}
```

---

#### 3.4 Zoom Webhook Failure
**Status**: ❌ Not Implemented (Optional - Admin Only)

**Trigger**: Critical webhook processing failure

**Implementation Location**: `app/Http/Controllers/ZoomWebhookController.php` - various handler methods

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Admin | Email | Zoom Webhook Error | Webhook {event_type} failed to process. Error: {error_message} |

---

### ⭐ 4. REVIEW & FEEDBACK EVENTS

#### 4.1 Review Submitted
**Status**: ❌ Not Implemented

**Trigger**: Buyer submits review for completed order

**Implementation Location**: `app/Http/Controllers/OrderManagementController.php` - `submitReview()` method (line 2821+)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Seller | Email + In-App | New Review Received | {buyer_name} left a {star}-star review for "{service_name}". |
| Buyer | In-App | Review Submitted | Your review for "{service_name}" has been submitted successfully. |

**Data Payload**:
```json
{
  "review_id": 67,
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "rating": 5,
  "comment": "Great class! Very helpful.",
  "buyer_name": "John Doe"
}
```

**Code Integration**:
```php
// In OrderManagementController.php - submitReview() method (after review is saved)

$this->notificationService->send(
    userId: $order->teacher_id,
    type: 'review_received',
    title: 'New Review Received',
    message: "{$order->user->name} left a {$request->rating}-star review for \"{$order->teacherGig->name}\".",
    data: [
        'review_id' => $review->id,
        'order_id' => $order->id,
        'service_name' => $order->teacherGig->name,
        'rating' => $request->rating,
        'comment' => $request->comment,
        'buyer_name' => $order->user->name
    ],
    sendEmail: true
);
```

---

#### 4.2 Review Reminder
**Status**: ❌ Not Implemented

**Trigger**: Scheduled command sends reminder 24 hours after class ends (for orders without reviews)

**Implementation**: New scheduled command `app/Console/Commands/ReviewReminder.php`

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Leave a Review | How was your class with {seller_name}? Share your experience to help others! |

**Data Payload**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English Trial Class",
  "seller_name": "Teacher Name",
  "class_date": "2025-11-10"
}
```

**Scheduled Command Code**:
```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookOrder;
use App\Models\ServiceReviews;
use App\Services\NotificationService;
use Carbon\Carbon;

class ReviewReminder extends Command
{
    protected $signature = 'reviews:send-reminders';
    protected $description = 'Send review reminders for completed orders without reviews';

    public function __construct(private NotificationService $notificationService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $yesterday = Carbon::now()->subDay();

        // Find orders completed ~24 hours ago without reviews
        $ordersNeedingReview = BookOrder::where('status', 3) // Completed
            ->whereDate('updated_at', $yesterday->toDateString())
            ->whereDoesntHave('reviews')
            ->where('review_reminder_sent', false)
            ->with(['user', 'teacher', 'teacherGig'])
            ->get();

        foreach ($ordersNeedingReview as $order) {
            $this->notificationService->send(
                userId: $order->user_id,
                type: 'review_reminder',
                title: 'Leave a Review',
                message: "How was your class with {$order->teacher->name}? Share your experience to help others!",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $order->teacherGig->name,
                    'seller_name' => $order->teacher->name,
                    'review_url' => route('user.order.review', $order->id)
                ],
                sendEmail: true
            );

            // Mark reminder as sent
            $order->review_reminder_sent = true;
            $order->save();

            $this->info("Review reminder sent for order #{$order->id}");
        }

        $this->info("Processed {$ordersNeedingReview->count()} review reminders");
    }
}
```

**Note**: Requires adding `review_reminder_sent` boolean column to `book_orders` table.

---

### 📋 5. RESCHEDULE EVENTS

#### 5.1 Reschedule Request Accepted
**Status**: ❌ Not Implemented

**Trigger**: Seller accepts reschedule request from buyer

**Implementation Location**: `app/Http/Controllers/OrderManagementController.php` - `AcceptResheduleClass()` method (line 2696+)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Reschedule Accepted | Your reschedule request for "{service_name}" has been accepted. New date: {new_date} |

---

#### 5.2 Reschedule Request Rejected
**Status**: ❌ Not Implemented

**Trigger**: Seller rejects reschedule request from buyer

**Implementation Location**: `app/Http/Controllers/OrderManagementController.php` - `RejectResheduleClass()` method (line 2774+)

**Recipients**:
| Role | Channels | Title | Message |
|------|----------|-------|---------|
| Buyer | Email + In-App | Reschedule Rejected | Your reschedule request for "{service_name}" was declined by the seller. |

---

## 🏗️ Technical Architecture

### System Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                        Business Event                            │
│  (Booking, Class Start, Review, etc.)                           │
└───────────────────────────┬─────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────┐
│                   NotificationService                            │
│  • send($userId, $type, $title, $message, $data, $sendEmail)   │
│  • sendToMultipleUsers(...)                                     │
└───────┬───────────────────┬───────────────────┬─────────────────┘
        │                   │                   │
        ▼                   ▼                   ▼
┌──────────────┐   ┌──────────────┐   ┌──────────────────┐
│   Database   │   │    Pusher    │   │  Email Queue     │
│  Insert      │   │  Broadcast   │   │  (Optional)      │
│  Notification│   │  Event       │   │                  │
└──────────────┘   └──────┬───────┘   └────────┬─────────┘
                          │                    │
                          ▼                    ▼
                 ┌─────────────────┐   ┌──────────────┐
                 │  Frontend JS    │   │  Email Send  │
                 │  (Pusher Echo)  │   │  (SMTP/SES)  │
                 └────────┬────────┘   └──────────────┘
                          │
                          ▼
                 ┌─────────────────┐
                 │  User Interface │
                 │  • Bell Icon    │
                 │  • Badge Update │
                 │  • Toast Popup  │
                 │  • Dropdown     │
                 └─────────────────┘
```

### Component Responsibilities

#### Backend Components

**1. NotificationService** (`app/Services/NotificationService.php`)
- Primary notification dispatcher
- Handles database persistence
- Triggers Pusher broadcast
- Optionally sends email
- Validates user existence
- Formats notification data

**Methods**:
```php
public function send(
    int $userId,
    string $type,
    string $title,
    string $message,
    array $data = [],
    bool $sendEmail = false
): void

public function sendToMultipleUsers(
    array $userIds,
    string $type,
    string $title,
    string $message,
    array $data = [],
    bool $sendEmail = false
): void
```

**2. Notification Model** (`app/Models/Notification.php`)
- Database ORM model
- Relationships: belongsTo User
- Methods: `markAsRead()`
- Casts: `is_read` (bool), `data` (array), `read_at` (datetime)

**3. NotificationController** (`app/Http/Controllers/NotificationController.php`)
- REST API for frontend
- CRUD operations
- User-scoped queries (security)

**4. NotificationSent Event** (`app/Events/NotificationSent.php`)
- Implements `ShouldBroadcast`
- Broadcasts to `user.{userId}` private channel
- Event name: `notification`
- Payload: id, type, title, message, data, created_at

**5. NotificationMail** (`app/Mail/NotificationMail.php`)
- Mailable class for email notifications
- Template: `resources/views/emails/notification.blade.php`
- Supports queued sending

#### Frontend Components

**1. NotificationManager** (`public/js/notifications.js`)
- Singleton class managing all notification UI
- Pusher connection management
- Real-time event handling
- DOM manipulation
- Browser notification API

**Key Features**:
- Auto-connects to Pusher on page load
- Listens to `user.{userId}` channel
- Updates bell badge in real-time
- Shows toast notifications
- Loads recent notifications
- Mark as read/delete functionality
- Handles network reconnection

**2. UI Components**:
- **Bell Icon**: SVG icon with unread badge (top-right corner)
- **Dropdown Menu**: Shows recent 10 notifications
- **Toast Notification**: Temporary popup for new notifications
- **Message Icon**: Separate email icon with badge

#### Pusher Configuration

**Channel Strategy**:
- **Private Channels**: `user.{userId}` - One per user
- **Authorization**: Via `routes/channels.php` - ensures user owns channel
- **Event Name**: `notification` - consistent across all notification types

**Configuration** (`config/broadcasting.php`):
```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'cluster' => env('PUSHER_APP_CLUSTER', 'ap2'),
        'useTLS' => true,
    ],
],
```

**Environment Variables**:
```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=cf6b96e5efc265f6c172
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=ap2
```

---

## 📝 Message Templates

### Bengali Message Templates

#### Order Flow
```
Booking Created (Buyer):
আপনার বুকিং "{service_name}" সফলভাবে নিশ্চিত হয়েছে! বিক্রেতার অনুমোদনের অপেক্ষায় আছে।

Booking Created (Seller):
আপনি {buyer_name} থেকে একটি নতুন অর্ডার রিকোয়েস্ট পেয়েছেন "{service_name}" সার্ভিসের জন্য। মূল্য: ৳{amount}

Order Accepted (Buyer):
{seller_name} আপনার বুকিং "{service_name}" গ্রহণ করেছেন। ক্লাস শুরু হবে {start_date} তারিখে।

Order Cancelled (Buyer - by Seller):
আপনার বুকিং "{service_name}" বিক্রেতা বাতিল করেছেন। রিফান্ড প্রক্রিয়া শুরু হয়েছে।

Order Cancelled (Seller - by Buyer):
{buyer_name} "{service_name}" বুকিং বাতিল করেছেন।

Order Delivered (Buyer):
আপনার সার্ভিস "{service_name}" ডেলিভার হয়েছে। কোনো সমস্যা থাকলে ৪৮ ঘণ্টার মধ্যে জানান।

Order Completed (Buyer):
আপনার অর্ডার "{service_name}" সম্পন্ন হয়েছে। DreamCrowd বেছে নেওয়ার জন্য ধন্যবাদ!

Order Completed (Seller):
আপনার অর্ডার "{service_name}" সম্পন্ন হয়েছে। পেমেন্ট শীঘ্রই রিলিজ করা হবে।
```

#### Class Lifecycle
```
Class Reminder (2hr - Buyer):
আপনার ক্লাস "{service_name}" {seller_name} এর সাথে ২ ঘণ্টা পরে {start_time} এ শুরু হবে।

Class Reminder (2hr - Seller):
আপনার ক্লাস "{service_name}" {buyer_name} এর সাথে ২ ঘণ্টা পরে {start_time} এ শুরু হবে।

Class Started (Buyer):
আপনার লাইভ ক্লাস শুরু হয়েছে! জয়েন করতে এখানে ক্লিক করুন।

Class Ended (Buyer):
আপনার ক্লাস {seller_name} এর সাথে শেষ হয়েছে। আপনার অভিজ্ঞতা শেয়ার করুন!

Class Ended (Seller):
আপনার ক্লাস "{service_name}" সফলভাবে সম্পন্ন হয়েছে। সময়কাল: {duration} মিনিট।
```

#### Review & Feedback
```
Review Submitted (Seller):
{buyer_name} "{service_name}" এর জন্য {rating}-স্টার রিভিউ দিয়েছেন।

Review Reminder (Buyer):
{seller_name} এর সাথে আপনার ক্লাস কেমন ছিল? আপনার অভিজ্ঞতা শেয়ার করুন!
```

#### Zoom Integration
```
Zoom Connected (Seller):
আপনার Zoom অ্যাকাউন্ট সফলভাবে সংযুক্ত হয়েছে! এখন আপনি লাইভ ক্লাস হোস্ট করতে পারবেন।

Zoom Token Expired (Seller):
আপনার Zoom সংযোগ মেয়াদ শেষ হয়েছে। লাইভ সেশন চালিয়ে যেতে সেটিংস থেকে পুনরায় সংযুক্ত করুন।

Meeting Creation Failed (Seller):
আপনার Zoom মিটিং তৈরি করা যায়নি। আপনার Zoom সংযোগ চেক করে আবার চেষ্টা করুন।
```

#### Dispute
```
Dispute Created (Seller):
{buyer_name} অর্ডার #{order_id} এর জন্য ডিসপিউট করেছেন। আপনার ৪৮ ঘণ্টা সময় আছে উত্তর দেওয়ার।

Dispute Created (Buyer):
আপনার ডিসপিউট "{service_name}" এর জন্য জমা হয়েছে। শীঘ্রই আপডেট পাবেন।

Refund Processed (Buyer):
আপনার ডিসপিউট সমাধান হয়েছে। ৳{amount} রিফান্ড প্রসেস করা হয়েছে।
```

### English Message Templates

#### Order Flow
```
Booking Created (Buyer):
Your booking for "{service_name}" is confirmed! Awaiting seller approval.

Booking Created (Seller):
You have a new booking request from {buyer_name} for {service_name}. Amount: ${amount}

Order Accepted (Buyer):
{seller_name} has accepted your booking for "{service_name}". Class starts on {start_date}.

Order Cancelled (Buyer - by Seller):
Your booking for "{service_name}" was cancelled by the seller. Refund initiated.

Order Cancelled (Seller - by Buyer):
{buyer_name} cancelled the booking for {service_name}.

Order Delivered (Buyer):
Your service "{service_name}" has been delivered. You have 48 hours to report any issues.

Order Completed (Buyer):
Your order for "{service_name}" is now complete. Thank you for choosing DreamCrowd!

Order Completed (Seller):
Your order for "{service_name}" is complete. Payment will be released soon.
```

#### Class Lifecycle
```
Class Reminder (2hr - Buyer):
Your class "{service_name}" with {seller_name} starts in 2 hours at {start_time}.

Class Reminder (2hr - Seller):
Your class "{service_name}" with {buyer_name} starts in 2 hours at {start_time}.

Class Started (Buyer):
Your live class has started! Click here to join the session.

Class Ended (Buyer):
Your class with {seller_name} has ended. Please rate your experience!

Class Ended (Seller):
Your class "{service_name}" completed successfully. Duration: {duration} minutes.
```

#### Review & Feedback
```
Review Submitted (Seller):
{buyer_name} left a {rating}-star review for "{service_name}".

Review Reminder (Buyer):
How was your class with {seller_name}? Share your experience to help others!
```

#### Zoom Integration
```
Zoom Connected (Seller):
Your Zoom account has been connected successfully! You can now host live classes.

Zoom Token Expired (Seller):
Your Zoom connection has expired. Please reconnect from your settings to continue hosting live sessions.

Meeting Creation Failed (Seller):
We could not create your Zoom meeting. Please check your Zoom connection and try again.
```

#### Dispute
```
Dispute Created (Seller):
{buyer_name} has raised a dispute for order #{order_id}. You have 48 hours to respond.

Dispute Created (Buyer):
Your dispute for "{service_name}" has been submitted. You'll receive updates soon.

Refund Processed (Buyer):
Your dispute was resolved. Refund of ${amount} has been processed.
```

---

## 💾 Database Schema

### Notifications Table

**Table Name**: `notifications`

**Migration**: `database/migrations/2025_10_22_061519_create_notifications_table.php`

**Schema**:
```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    type VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSON NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    INDEX idx_user_read (user_id, is_read),
    INDEX idx_user_created (user_id, created_at),
    INDEX idx_type (type),

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Notification Types

**Standard Types** (use these consistently):

| Type | Description | Example Events |
|------|-------------|----------------|
| `order` | Order-related events | Created, Accepted, Cancelled |
| `order_delivered` | Order delivery notification | Auto-delivered |
| `order_completed` | Order completion notification | Auto-completed |
| `order_cancelled` | Order cancellation | Seller/Buyer cancels |
| `class_reminder` | Class reminder notifications | 2-hour reminder |
| `class_started` | Class start notification | Zoom meeting started |
| `class_ended` | Class end notification | Zoom meeting ended |
| `participant_joined` | Participant activity | Join/leave events |
| `review_received` | Review submitted | Buyer reviews seller |
| `review_reminder` | Review reminder | Post-class reminder |
| `dispute_created` | Dispute notification | Buyer disputes order |
| `dispute_resolved` | Dispute resolution | Refund processed |
| `zoom_connected` | Zoom auth success | OAuth completed |
| `zoom_token_expired` | Zoom token expiry | Token refresh failed |
| `zoom_meeting_failed` | Meeting creation error | API error |
| `reschedule_accepted` | Reschedule approved | Seller accepts |
| `reschedule_rejected` | Reschedule declined | Seller rejects |

### Data JSON Structure

**Standard Fields** (include in all notifications):
```json
{
  "order_id": 123,              // Always include if order-related
  "service_name": "Class Name",  // Always include if service-related
  "user_name": "Name",          // Relevant user name
  "timestamp": "2025-11-10 10:00:00"
}
```

**Additional Fields by Type**:

**Order Events**:
```json
{
  "order_id": 123,
  "service_name": "Spoken English",
  "buyer_id": 45,
  "buyer_name": "John Doe",
  "seller_id": 12,
  "seller_name": "Teacher",
  "amount": 50.00,
  "service_type": "trial",
  "start_date": "2025-11-10"
}
```

**Class Events**:
```json
{
  "meeting_id": "98765432100",
  "order_id": 123,
  "class_date_id": 45,
  "service_name": "English Class",
  "start_time": "2025-11-10 12:00:00",
  "duration_minutes": 60,
  "join_url": "https://dreamcrowd.com/join/token"
}
```

**Review Events**:
```json
{
  "review_id": 67,
  "order_id": 123,
  "service_name": "English Class",
  "rating": 5,
  "comment": "Great class!",
  "reviewer_name": "John Doe"
}
```

**Zoom Events**:
```json
{
  "zoom_email": "teacher@example.com",
  "connected_at": "2025-11-10 10:00:00",
  "expires_at": "2025-12-10 10:00:00",
  "error_message": "Invalid token",
  "reconnect_url": "https://dreamcrowd.com/zoom/settings"
}
```

### Required Database Migrations

**1. Add `reminder_sent` to `class_dates` table**:
```php
Schema::table('class_dates', function (Blueprint $table) {
    $table->boolean('reminder_sent')->default(false)->after('end_time');
    $table->index('reminder_sent');
});
```

**2. Add `review_reminder_sent` to `book_orders` table**:
```php
Schema::table('book_orders', function (Blueprint $table) {
    $table->boolean('review_reminder_sent')->default(false)->after('status');
    $table->index('review_reminder_sent');
});
```

---

## 🚀 Implementation Phases

### Phase 0: UI Integration & Notification Pages (Priority: CRITICAL)

**Estimated Time**: 4-6 hours

**Purpose**: Create functional notification viewing pages for all three user roles (Admin, Teacher, User) with proper sidebar navigation integration. This is the foundation for users to actually see and interact with notifications.

#### Current Issues to Fix

1. **Broken Navigation Links**
   - All sidebar links point to `notification.html` (non-functional static file)
   - No Laravel routes defined for notification pages
   - Users cannot access notification pages

2. **Static Content**
   - Existing notification pages show hardcoded dummy data
   - No integration with backend API
   - No real-time updates on pages

3. **Controller Mismatch**
   - NotificationController returns JSON (API-style)
   - No methods to return Blade views
   - Pages can't fetch data properly

4. **UI Issues**
   - User sidebar has duplicate notification menu items (lines 36 & 163)
   - Inconsistent icon usage across roles

#### Tasks

**1. Fix Sidebar Navigation (3 files)** - 30 minutes

**Admin Sidebar** (`resources/views/components/admin-sidebar.blade.php`):
```php
// Line 161 - Change from:
<a href="notification.html">

// To:
<a href="{{ route('admin.notifications') }}">
```

**Teacher Sidebar** (`resources/views/components/teacher-sidebar.blade.php`):
```php
// Line 37 - Change from:
<a href="notification.html">

// To:
<a href="{{ route('teacher.notifications') }}">
```

**User Sidebar** (`resources/views/components/user-sidebar.blade.php`):
```php
// Line 37 - Change from:
<a href="notification.html">

// To:
<a href="{{ route('user.notifications') }}">

// Line 163-173 - REMOVE duplicate notification menu item
```

**2. Add Web Routes** (`routes/web.php`) - 15 minutes

Add after line 37 (after existing notification API routes):

```php
// Notification Pages
Route::middleware('auth')->group(function () {
    // Admin notification page
    Route::get('/admin/notifications', [NotificationController::class, 'adminIndex'])
        ->middleware('role:admin')
        ->name('admin.notifications');

    // Teacher notification page
    Route::get('/teacher/notifications', [NotificationController::class, 'teacherIndex'])
        ->middleware('role:teacher')
        ->name('teacher.notifications');

    // User notification page
    Route::get('/user/notifications', [NotificationController::class, 'userIndex'])
        ->middleware('role:user')
        ->name('user.notifications');
});
```

**3. Update NotificationController** - 30 minutes

Add three new methods to return Blade views:

```php
/**
 * Admin notification page
 * Shows ALL notifications in the system
 */
public function adminIndex()
{
    if (auth()->user()->role !== 2) {
        abort(403, 'Unauthorized');
    }

    return view('Admin-Dashboard.notification');
}

/**
 * Teacher notification page
 * Shows only teacher's own notifications
 */
public function teacherIndex()
{
    if (auth()->user()->role !== 1) {
        abort(403, 'Unauthorized');
    }

    return view('Teacher-Dashboard.notification');
}

/**
 * User notification page
 * Shows only user's own notifications
 */
public function userIndex()
{
    if (auth()->user()->role !== 0) {
        abort(403, 'Unauthorized');
    }

    return view('User-Dashboard.notification');
}
```

**4. Update Admin Notification Page** - 60-90 minutes

File: `resources/views/Admin-Dashboard/notification.blade.php`

Features to implement:
- [ ] Fetch ALL notifications via AJAX (admin sees everything)
- [ ] Implement pagination (20 per page)
- [ ] Add "Mark as Read" button for each notification
- [ ] Add "Delete" button for each notification
- [ ] Add "Mark All as Read" button
- [ ] Show unread count
- [ ] Add notification type filtering (order, class, zoom, etc.)
- [ ] Add date range filtering
- [ ] Add user filtering (which user received notification)
- [ ] Keep "Send new notification" feature (admin-only)
- [ ] Add real-time updates via Pusher
- [ ] Show notification metadata (type, created_at, read_at)

JavaScript functionality:
```javascript
// Fetch notifications with pagination
function loadNotifications(page = 1) {
    $.ajax({
        url: '/notifications?page=' + page,
        method: 'GET',
        success: function(response) {

            renderNotifications(response.notifications.data);
            renderPagination(response.notifications);
        }
    });
}

// Mark as read
function markAsRead(notificationId) {
    $.ajax({
        url: '/notifications/' + notificationId + '/read',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            // Update UI
            updateUnreadCount();
        }
    });
}

// Delete notification
function deleteNotification(notificationId) {
    $.ajax({
        url: '/notifications/' + notificationId,
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            // Remove from UI
            $('#notification-' + notificationId).remove();
            updateUnreadCount();
        }
    });
}

// Mark all as read
function markAllAsRead() {
    $.ajax({
        url: '/notifications/mark-all-read',
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            // Update UI
            $('.notification-item').removeClass('unread');
            updateUnreadCount();
        }
    });
}

// Real-time updates via Pusher
Echo.private('user.' + userId)
    .listen('notification', (e) => {
        prependNotification(e.notification);
        updateUnreadCount();
        showToast(e.notification);
    });
```

**5. Update Teacher Notification Page** - 45-60 minutes

File: `resources/views/Teacher-Dashboard/notification.blade.php`

Features to implement:
- [ ] Fetch only teacher's notifications via AJAX
- [ ] Implement pagination (20 per page)
- [ ] Add "Mark as Read" button for each notification
- [ ] Add "Delete" button for each notification
- [ ] Add "Mark All as Read" button
- [ ] Show unread count
- [ ] Add notification type filtering
- [ ] Add date range filtering
- [ ] NO "Send notification" feature (teachers only receive)
- [ ] Add real-time updates via Pusher
- [ ] Group by type (order, class, review, zoom)

Same JavaScript structure as admin but:
- Filter to only show auth user's notifications
- Remove admin-specific features
- Simpler UI (no user filtering needed)

**6. Update User Notification Page** - 45-60 minutes

File: `resources/views/User-Dashboard/notification.blade.php`

Features to implement:
- [ ] Fetch only user's notifications via AJAX
- [ ] Implement pagination (20 per page)
- [ ] Add "Mark as Read" button for each notification
- [ ] Add "Delete" button for each notification
- [ ] Add "Mark All as Read" button
- [ ] Show unread count
- [ ] Add notification type filtering
- [ ] Add date range filtering
- [ ] NO "Send notification" feature (users only receive)
- [ ] Add real-time updates via Pusher
- [ ] Group by type (order, class, review)

Same JavaScript structure as teacher.

**7. Update API Controller Methods** - 30 minutes

Modify existing `index()` method in NotificationController:

```php
public function index(Request $request)
{
    $user = auth()->user();

    // Admin can see all notifications, others only see their own
    if ($user->role === 'admin') {
        $query = Notification::with('user')->orderBy('created_at', 'desc');
    } else {
        $query = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');
    }

    // Apply filters if provided
    if ($request->has('type')) {
        $query->where('type', $request->type);
    }

    if ($request->has('is_read')) {
        $query->where('is_read', $request->is_read);
    }

    if ($request->has('date_from')) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->has('date_to')) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }

    $notifications = $query->paginate(20);

    return response()->json($notifications);
}
```

**8. Testing & QA** - 30-60 minutes

- [ ] Test admin can access `/admin/notifications`
- [ ] Test teacher can access `/teacher/notifications`
- [ ] Test user can access `/user/notifications`
- [ ] Verify role-based access control (403 errors)
- [ ] Test sidebar links navigate correctly
- [ ] Test pagination works
- [ ] Test mark as read functionality
- [ ] Test delete functionality
- [ ] Test mark all as read
- [ ] Test filtering by type
- [ ] Test filtering by date
- [ ] Test real-time updates appear on page
- [ ] Test notifications persist after page refresh
- [ ] Verify admin sees ALL notifications
- [ ] Verify teacher/user see only their own

#### Deliverables

1. ✅ Fixed sidebar navigation for all 3 roles
2. ✅ 3 new web routes for notification pages
3. ✅ 3 new controller methods (adminIndex, teacherIndex, userIndex)
4. ✅ Dynamic admin notification page with all features
5. ✅ Dynamic teacher notification page
6. ✅ Dynamic user notification page
7. ✅ Working pagination
8. ✅ Mark as read/delete functionality
9. ✅ Real-time updates on pages
10. ✅ Role-based access control
11. ✅ Notification filtering capabilities

#### Success Criteria

**Functional Requirements**:
- [x] Users can navigate to notifications page from sidebar
- [x] Correct notifications display based on user role
- [x] Admin sees ALL notifications, others see only their own
- [x] Pagination works correctly
- [x] Mark as read updates database and UI
- [x] Delete removes notification
- [x] Mark all as read works
- [x] Real-time notifications appear without refresh
- [x] Filtering works correctly
- [x] No console errors

**Security Requirements**:
- [x] Role-based middleware prevents unauthorized access
- [x] Users cannot see other users' notifications
- [x] CSRF protection on all AJAX requests
- [x] Proper authorization checks in controller

**UX Requirements**:
- [x] Loading states during AJAX calls
- [x] Success/error messages for actions
- [x] Smooth animations for UI updates
- [x] Mobile-responsive design
- [x] Clear visual distinction between read/unread
- [x] Intuitive navigation and interactions

#### File Summary

**Files to Modify** (8 files):
1. `resources/views/components/admin-sidebar.blade.php` - Fix link (line 161)
2. `resources/views/components/teacher-sidebar.blade.php` - Fix link (line 37)
3. `resources/views/components/user-sidebar.blade.php` - Fix link + remove duplicate (lines 37, 163-173)
4. `routes/web.php` - Add 3 routes
5. `app/Http/Controllers/NotificationController.php` - Add 3 methods + update index()
6. `resources/views/Admin-Dashboard/notification.blade.php` - Make dynamic
7. `resources/views/Teacher-Dashboard/notification.blade.php` - Make dynamic
8. `resources/views/User-Dashboard/notification.blade.php` - Make dynamic

**No New Files Needed**: All files already exist, just need updates.

---

### Phase 1: Core Order Flow Notifications (Priority: HIGH)

**Estimated Time**: 8-12 hours

**Tasks**:

1. **Order Rejection/Cancellation Notifications** (2-3 hours)
   - [ ] Modify `OrderManagementController.php` - `CancelOrder()` method
   - [ ] Add notification logic based on who cancelled (buyer vs seller)
   - [ ] Notify opposite party + admin
   - [ ] Test with different cancellation scenarios

2. **Order Delivery Notifications** (1-2 hours)
   - [ ] Modify `AutoMarkDelivered.php` command
   - [ ] Add notification after order status update
   - [ ] Notify buyer and seller
   - [ ] Test with trial and subscription orders

3. **Order Completion Notifications** (1-2 hours)
   - [ ] Modify `AutoMarkCompleted.php` command
   - [ ] Add notification after completion
   - [ ] Notify buyer, seller, and admin
   - [ ] Test 48-hour window logic

4. **Dispute Notifications** (2-3 hours)
   - [ ] Modify `DisputeOrder()` method in `OrderManagementController.php`
   - [ ] Add notification when dispute created
   - [ ] Modify `AutoHandleDisputes.php` for refund notifications
   - [ ] Test dispute flow end-to-end

5. **Reschedule Notifications** (1-2 hours)
   - [ ] Modify `AcceptResheduleClass()` method
   - [ ] Modify `RejectResheduleClass()` method
   - [ ] Notify buyer when seller accepts/rejects
   - [ ] Test reschedule flow

6. **Testing & QA** (1-2 hours)
   - [ ] Test all notification types
   - [ ] Verify email delivery
   - [ ] Check Pusher real-time updates
   - [ ] Validate notification data accuracy

**Deliverables**:
- 6 event types implemented and tested
- Email notifications working
- Real-time push notifications working
- Database records correct

---

### Phase 2: Class Experience Notifications (Priority: MEDIUM)

**Estimated Time**: 6-8 hours

**Tasks**:

1. **2-Hour Class Reminder Command** (2-3 hours)
   - [ ] Create `ClassReminder.php` scheduled command
   - [ ] Add migration for `reminder_sent` column in `class_dates`
   - [ ] Implement logic to find classes starting in 2 hours
   - [ ] Send notifications to buyer, seller, and guests
   - [ ] Schedule in `Kernel.php` to run every 5 minutes
   - [ ] Test with various class times

2. **Class Started Notification** (1-2 hours)
   - [ ] Modify `ZoomWebhookController.php` - `handleMeetingStarted()`
   - [ ] Add notification logic after webhook processing
   - [ ] Notify buyer with join link
   - [ ] Notify seller with confirmation
   - [ ] Test with real Zoom webhook

3. **Class Ended Notification** (1-2 hours)
   - [ ] Modify `ZoomWebhookController.php` - `handleMeetingEnded()`
   - [ ] Add notification logic after webhook processing
   - [ ] Notify buyer with review prompt
   - [ ] Notify seller with class summary
   - [ ] Test with real Zoom webhook

4. **Review Reminder Command** (1-2 hours)
   - [ ] Create `ReviewReminder.php` scheduled command
   - [ ] Add migration for `review_reminder_sent` column in `book_orders`
   - [ ] Find completed orders without reviews
   - [ ] Send reminders 24 hours after completion
   - [ ] Schedule in `Kernel.php` to run daily
   - [ ] Test reminder logic

5. **Review Submitted Notification** (30-60 min)
   - [ ] Modify `submitReview()` method in `OrderManagementController.php`
   - [ ] Notify seller when buyer submits review
   - [ ] Include rating and comment excerpt
   - [ ] Test review submission flow

6. **Testing & QA** (1 hour)
   - [ ] Test all class lifecycle notifications
   - [ ] Verify webhook integration
   - [ ] Check scheduled command execution
   - [ ] Validate notification timing

**Deliverables**:
- 2 new scheduled commands
- 5 event types implemented
- Webhook integration complete
- Class lifecycle fully tracked

---

### Phase 3: Zoom & Advanced Notifications (Priority: LOW)

**Estimated Time**: 4-6 hours

**Tasks**:

1. **Participant Join/Leave Notifications** (1-2 hours) - OPTIONAL
   - [ ] Modify `handleParticipantJoined()` in `ZoomWebhookController.php`
   - [ ] Modify `handleParticipantLeft()` in `ZoomWebhookController.php`
   - [ ] Notify seller (in-app only)
   - [ ] Test with real participants

2. **Zoom OAuth Success Notification** (30-60 min)
   - [ ] Modify `ZoomOAuthController.php` - `callback()` method
   - [ ] Add notification after successful OAuth
   - [ ] Test OAuth flow

3. **Zoom Token Expiry Notification** (1-2 hours)
   - [ ] Modify `RefreshZoomToken.php` command
   - [ ] Add notification when refresh fails
   - [ ] Notify teacher and admin
   - [ ] Test token expiry scenario

4. **Meeting Creation Failure Notification** (1-2 hours)
   - [ ] Modify `ZoomMeetingService.php` - `createMeeting()` method
   - [ ] Add notification in catch block
   - [ ] Notify teacher and admin
   - [ ] Test API failure scenarios

5. **Admin Webhook Failure Alerts** (30-60 min) - OPTIONAL
   - [ ] Add admin notifications for critical webhook failures
   - [ ] Log and notify on repeated failures
   - [ ] Test error scenarios

6. **Testing & QA** (1 hour)
   - [ ] Test all Zoom-related notifications
   - [ ] Verify error handling
   - [ ] Check admin alerts
   - [ ] End-to-end testing

**Deliverables**:
- 4-6 Zoom event types implemented
- Error handling improved
- Admin monitoring enhanced
- Complete system testing

---

## ✅ Testing & Acceptance Criteria

### Unit Testing

**Test Cases for Each Notification Type**:

```php
// Example test structure
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\BookOrder;
use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_booking_created_notification()
    {
        $buyer = User::factory()->create(['role' => 'user']);
        $seller = User::factory()->create(['role' => 'teacher']);

        // Create booking
        $order = BookOrder::factory()->create([
            'user_id' => $buyer->id,
            'teacher_id' => $seller->id
        ]);

        // Assert notifications were created
        $this->assertDatabaseHas('notifications', [
            'user_id' => $buyer->id,
            'type' => 'order',
            'title' => 'Order Placed Successfully'
        ]);

        $this->assertDatabaseHas('notifications', [
            'user_id' => $seller->id,
            'type' => 'order',
            'title' => 'New Order Received'
        ]);
    }

    /** @test */
    public function it_sends_class_reminder_2_hours_before()
    {
        $this->travelTo(now()->subHours(2)->subMinutes(5));

        $classDate = ClassDate::factory()->create([
            'start_time' => now()->addHours(2)
        ]);

        $this->artisan('classes:send-reminders');

        $this->assertDatabaseHas('notifications', [
            'type' => 'class_reminder',
            'title' => 'Class Starting Soon'
        ]);

        $this->assertTrue($classDate->fresh()->reminder_sent);
    }

    /** @test */
    public function it_sends_zoom_token_expired_notification()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        // Simulate token refresh failure
        $this->artisan('zoom:refresh-tokens');

        $this->assertDatabaseHas('notifications', [
            'user_id' => $teacher->id,
            'type' => 'zoom_token_expired'
        ]);
    }
}
```

### Manual Testing Checklist

**Order Flow**:
- [ ] Create booking → Verify buyer, seller, admin receive notifications
- [ ] Accept order → Verify buyer receives notification
- [ ] Seller cancels order → Verify buyer and admin notified
- [ ] Buyer cancels order → Verify seller and admin notified
- [ ] Wait for auto-delivery → Verify notifications sent
- [ ] Wait 48 hours → Verify completion notifications
- [ ] Create dispute → Verify all parties notified
- [ ] Wait 48 hours → Verify refund notification

**Class Lifecycle**:
- [ ] Class 2 hours away → Verify reminder sent
- [ ] Start Zoom meeting → Verify class started notification
- [ ] End Zoom meeting → Verify class ended notification
- [ ] Wait 24 hours → Verify review reminder sent
- [ ] Submit review → Verify seller notified

**Zoom Integration**:
- [ ] Connect Zoom account → Verify success notification
- [ ] Trigger token expiry → Verify expiry notification
- [ ] Cause meeting creation failure → Verify error notification
- [ ] Join/leave meeting → Verify participant notifications

**Email Testing**:
- [ ] Verify all emails have correct subject lines
- [ ] Check email templates render properly
- [ ] Test email links work correctly
- [ ] Verify sender information is correct

**Real-Time Testing**:
- [ ] Open buyer dashboard → Create order from seller
- [ ] Verify bell icon badge updates instantly
- [ ] Verify toast notification appears
- [ ] Click notification → Verify dropdown shows it
- [ ] Mark as read → Verify badge decrements
- [ ] Test with multiple browser tabs open

### Acceptance Criteria

**Functional Requirements**:
1. ✅ All 17 notification events trigger correctly
2. ✅ Notifications saved to database with correct data
3. ✅ Real-time push notifications work via Pusher
4. ✅ Email notifications sent when specified
5. ✅ Notifications are user-specific (proper authorization)
6. ✅ Unread count updates in real-time
7. ✅ Mark as read functionality works
8. ✅ Delete notification functionality works
9. ✅ Scheduled commands run on schedule
10. ✅ Webhook integration triggers notifications

**Performance Requirements**:
1. ✅ Notification creation < 200ms
2. ✅ Pusher broadcast < 1 second
3. ✅ Email queued (not blocking)
4. ✅ Frontend updates < 500ms after event
5. ✅ Database queries optimized (use indexes)

**Security Requirements**:
1. ✅ Users can only see their own notifications
2. ✅ Private Pusher channels properly authorized
3. ✅ No sensitive data in notification messages
4. ✅ CSRF protection on all routes
5. ✅ Input validation on all endpoints

**UX Requirements**:
1. ✅ Clear, concise notification messages
2. ✅ Proper Bengali/English translations
3. ✅ Notification links navigate to correct pages
4. ✅ Toast notifications dismissible
5. ✅ Bell badge shows accurate count
6. ✅ Dropdown shows most recent notifications
7. ✅ "Mark all as read" works correctly

---

## 🚀 Deployment Checklist

### Pre-Deployment

**1. Environment Configuration**:
- [ ] Verify Pusher credentials in `.env`
- [ ] Configure email settings (SMTP/SES)
- [ ] Set `QUEUE_CONNECTION=database` or `redis`
- [ ] Verify `APP_URL` is correct

**2. Database**:
- [ ] Run migrations: `php artisan migrate`
- [ ] Add indexes if missing
- [ ] Verify foreign keys are correct

**3. Code Review**:
- [ ] All notification triggers implemented
- [ ] No hardcoded values (use config/env)
- [ ] Error handling in place
- [ ] Logging configured

**4. Testing**:
- [ ] Run unit tests: `php artisan test`
- [ ] Manual testing completed
- [ ] Email delivery tested
- [ ] Pusher connectivity tested

### Deployment Steps

**1. Deploy Code**:
```bash
git pull origin master
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**2. Run Migrations**:
```bash
php artisan migrate --force
```

**3. Restart Services**:
```bash
php artisan queue:restart
php artisan schedule:run
sudo supervisorctl restart all
```

**4. Verify Scheduled Commands**:
```bash
php artisan schedule:list

# Should show:
# - classes:send-reminders   Every 5 minutes
# - reviews:send-reminders   Daily at 9:00 AM
# - zoom:refresh-tokens      Hourly
# - orders:auto-deliver      Hourly
# - orders:auto-complete     Every 6 hours
# - disputes:process         Daily at 3:00 AM
```

**5. Test Production**:
- [ ] Create test booking
- [ ] Verify notification appears
- [ ] Check email received
- [ ] Verify Pusher real-time update

### Post-Deployment

**1. Monitoring**:
- [ ] Check Laravel logs: `tail -f storage/logs/laravel.log`
- [ ] Check queue workers: `php artisan queue:work --tries=3`
- [ ] Monitor Pusher dashboard for events
- [ ] Check email delivery rate

**2. Performance**:
- [ ] Monitor database query performance
- [ ] Check Pusher usage/limits
- [ ] Monitor email queue length
- [ ] Verify scheduled commands running

**3. User Feedback**:
- [ ] Monitor support tickets for notification issues
- [ ] Check user reports of missing notifications
- [ ] Gather feedback on notification wording

---

## 📚 Code Snippets & Examples

### Enhanced NotificationService

**Add helper methods to `app/Services/NotificationService.php`**:

```php
<?php

namespace App\Services;

use App\Models\Notification;
use App\Events\NotificationSent;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    // Existing methods...

    /**
     * Send order cancellation notification
     */
    public function sendOrderCancelled($order, $cancelledBy, $cancelledByName)
    {
        $isSeller = ($cancelledBy === 'teacher');

        if ($isSeller) {
            // Notify buyer
            $this->send(
                userId: $order->user_id,
                type: 'order_cancelled',
                title: 'Order Cancelled',
                message: "Your booking for \"{$order->teacherGig->name}\" was cancelled by the seller. Refund initiated.",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $order->teacherGig->name,
                    'cancelled_by' => 'seller',
                    'cancelled_by_name' => $cancelledByName,
                    'refund_amount' => $order->amount
                ],
                sendEmail: true
            );
        } else {
            // Notify seller
            $this->send(
                userId: $order->teacher_id,
                type: 'order_cancelled',
                title: 'Order Cancelled by Buyer',
                message: "{$cancelledByName} cancelled the booking for {$order->teacherGig->name}.",
                data: [
                    'order_id' => $order->id,
                    'service_name' => $order->teacherGig->name,
                    'cancelled_by' => 'buyer',
                    'cancelled_by_name' => $cancelledByName
                ],
                sendEmail: true
            );
        }
    }

    /**
     * Send class reminder notification
     */
    public function sendClassReminder($classDate, $order, $hoursBeforeClass = 2)
    {
        $startTime = $classDate->start_time->format('h:i A');

        // Notify buyer
        $this->send(
            userId: $order->user_id,
            type: 'class_reminder',
            title: 'Class Starting Soon',
            message: "Your class \"{$order->teacherGig->name}\" with {$order->teacher->name} starts in {$hoursBeforeClass} hours at {$startTime}.",
            data: [
                'order_id' => $order->id,
                'class_date_id' => $classDate->id,
                'service_name' => $order->teacherGig->name,
                'start_time' => $classDate->start_time->toDateTimeString(),
                'seller_name' => $order->teacher->name,
                'hours_before' => $hoursBeforeClass
            ],
            sendEmail: true
        );

        // Notify seller
        $this->send(
            userId: $order->teacher_id,
            type: 'class_reminder',
            title: 'Class Reminder',
            message: "Your class \"{$order->teacherGig->name}\" with {$order->user->name} starts in {$hoursBeforeClass} hours at {$startTime}.",
            data: [
                'order_id' => $order->id,
                'class_date_id' => $classDate->id,
                'service_name' => $order->teacherGig->name,
                'start_time' => $classDate->start_time->toDateTimeString(),
                'buyer_name' => $order->user->name,
                'hours_before' => $hoursBeforeClass
            ],
            sendEmail: true
        );
    }

    /**
     * Send class started notification
     */
    public function sendClassStarted($meeting, $order, $joinUrl = null)
    {
        // Notify buyer
        $this->send(
            userId: $order->user_id,
            type: 'class_started',
            title: 'Class Started',
            message: "Your live class has started! Click here to join the session.",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'join_url' => $joinUrl,
                'started_at' => now()->toDateTimeString()
            ],
            sendEmail: true
        );

        // Notify seller
        $this->send(
            userId: $order->teacher_id,
            type: 'class_started',
            title: 'Meeting Started',
            message: "Your Zoom meeting for \"{$order->teacherGig->name}\" has started successfully.",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name
            ],
            sendEmail: false
        );
    }

    /**
     * Send class ended notification
     */
    public function sendClassEnded($meeting, $order, $duration, $participantCount)
    {
        // Notify buyer
        $this->send(
            userId: $order->user_id,
            type: 'class_ended',
            title: 'Class Ended',
            message: "Your class with {$order->teacher->name} has ended. Please rate your experience!",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'ended_at' => now()->toDateTimeString(),
                'duration_minutes' => $duration,
                'review_url' => route('user.order.review', $order->id)
            ],
            sendEmail: true
        );

        // Notify seller
        $this->send(
            userId: $order->teacher_id,
            type: 'class_ended',
            title: 'Class Completed',
            message: "Your class \"{$order->teacherGig->name}\" completed successfully. Duration: {$duration} minutes.",
            data: [
                'meeting_id' => $meeting->meeting_id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'duration_minutes' => $duration,
                'participant_count' => $participantCount
            ],
            sendEmail: false
        );
    }

    /**
     * Send review notification
     */
    public function sendReviewSubmitted($review, $order)
    {
        $this->send(
            userId: $order->teacher_id,
            type: 'review_received',
            title: 'New Review Received',
            message: "{$order->user->name} left a {$review->rating}-star review for \"{$order->teacherGig->name}\".",
            data: [
                'review_id' => $review->id,
                'order_id' => $order->id,
                'service_name' => $order->teacherGig->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'buyer_name' => $order->user->name
            ],
            sendEmail: true
        );
    }

    /**
     * Send Zoom notification
     */
    public function sendZoomNotification($userId, $type, $title, $message, $data = [])
    {
        $this->send(
            userId: $userId,
            type: $type,
            title: $title,
            message: $message,
            data: $data,
            sendEmail: true
        );
    }
}
```

### Schedule Configuration

**Update `app/Console/Kernel.php`**:

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\ClassReminder::class,
        Commands\ReviewReminder::class,
        // ... existing commands
    ];

    protected function schedule(Schedule $schedule)
    {
        // Existing scheduled commands
        $schedule->command('zoom:refresh-tokens')->hourly();
        $schedule->command('zoom:generate-meetings')->everyThirtyMinutes();
        $schedule->command('orders:auto-deliver')->hourly();
        $schedule->command('orders:auto-complete')->everySixHours();
        $schedule->command('disputes:process')->dailyAt('03:00');

        // NEW: Class reminder (2 hours before)
        $schedule->command('classes:send-reminders')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/class-reminders.log'));

        // NEW: Review reminder (24 hours after completion)
        $schedule->command('reviews:send-reminders')
            ->dailyAt('09:00')
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/review-reminders.log'));
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
```

---

## 📊 Analytics & Monitoring

### Key Metrics to Track

**Notification Performance**:
- Total notifications sent per day
- Notification delivery success rate
- Average time from event to notification
- Email open rate
- Email click-through rate

**User Engagement**:
- Percentage of users with notifications enabled
- Average time to read notification
- Notification click rate
- Most popular notification types

**System Health**:
- Pusher connection success rate
- Queue processing time
- Failed notification attempts
- Scheduled command execution status

### Logging

**Add comprehensive logging**:

```php
// In NotificationService.php
Log::info('Notification sent', [
    'user_id' => $userId,
    'type' => $type,
    'title' => $title,
    'email_sent' => $sendEmail,
    'timestamp' => now()
]);

// In scheduled commands
$this->info("Processed {$count} notifications");
Log::info("Class reminders processed", ['count' => $count]);
```

---

## 🎓 Best Practices

### Notification Wording

**DO**:
- ✅ Use clear, action-oriented language
- ✅ Include relevant names and dates
- ✅ Keep messages concise (< 100 characters)
- ✅ Use proper localization
- ✅ Include call-to-action when appropriate

**DON'T**:
- ❌ Use technical jargon
- ❌ Include sensitive information (passwords, full payment details)
- ❌ Send redundant notifications
- ❌ Use ALL CAPS or excessive punctuation
- ❌ Make messages too long

### Error Handling

**Always wrap notification calls in try-catch**:

```php
try {
    $this->notificationService->send(...);
} catch (\Exception $e) {
    Log::error('Notification failed', [
        'error' => $e->getMessage(),
        'user_id' => $userId,
        'type' => $type
    ]);
    // Don't halt the main process
}
```

### Performance Optimization

**Use Queue for Emails**:
```php
// In NotificationService.php
if ($sendEmail) {
    Mail::to($user->email)->queue(new NotificationMail($title, $message));
}
```

**Batch Notifications**:
```php
// For multiple admins
$this->sendToMultipleUsers($adminIds, ...);
```

**Database Indexes**:
```php
// Add indexes for common queries
$table->index(['user_id', 'is_read']);
$table->index(['user_id', 'created_at']);
```

---

## 🔗 Related Documentation

- [Laravel Notifications Documentation](https://laravel.com/docs/10.x/notifications)
- [Pusher Laravel Broadcasting](https://laravel.com/docs/10.x/broadcasting)
- [Laravel Task Scheduling](https://laravel.com/docs/10.x/scheduling)
- [Zoom Webhook Events](https://developers.zoom.us/docs/api/rest/webhook-reference/)

---

## 📞 Support & Maintenance

### Troubleshooting

**Notifications not appearing in real-time**:
1. Check Pusher credentials in `.env`
2. Verify Pusher connection in browser console
3. Check `routes/channels.php` authorization
4. Verify JavaScript is loaded (`notifications.js`)

**Emails not sending**:
1. Check mail configuration in `.env`
2. Verify queue worker is running: `php artisan queue:work`
3. Check Laravel logs for SMTP errors
4. Test email delivery manually

**Scheduled commands not running**:
1. Verify cron is configured: `* * * * * cd /path && php artisan schedule:run >> /dev/null 2>&1`
2. Check command is registered in `Kernel.php`
3. View schedule: `php artisan schedule:list`
4. Run manually: `php artisan classes:send-reminders`

---

## ✅ Summary

This comprehensive notification plan provides:

1. **Complete Event Coverage**: All 17 business events documented
2. **Clear Implementation Path**: 3 phases with time estimates
3. **Code Examples**: Ready-to-use code snippets
4. **Testing Strategy**: Unit tests and manual testing checklists
5. **Deployment Guide**: Step-by-step deployment process
6. **Monitoring & Logging**: Analytics and troubleshooting

**Next Steps**:
1. Review and approve this plan
2. Begin Phase 1 implementation (Core Order Flow)
3. Test each phase thoroughly before moving to next
4. Deploy incrementally with monitoring
5. Gather user feedback and iterate

---

**Document Version**: 1.0
**Last Updated**: 2025-11-05
**Status**: Ready for Implementation

---
