# সম্পূর্ণ NOTIFICATION SYSTEM REDESIGN - PROFESSIONAL PLAN V2
# COMPREHENSIVE NOTIFICATION SYSTEM REDESIGN - PROFESSIONAL PLAN V2

**Updated Date**: November 2025
**Version**: 2.0 (Refactored Structure)
**Current File**: `resources/views/Admin-Dashboard/notification.blade.php`
**Controller**: `app/Http/Controllers/NotificationController.php`
**Service**: `app/Services/NotificationService.php`

---

## 📋 INDEX / সূচিপত্র

1. [System Overview](#1-system-overview)
2. [Key Changes from V1](#2-key-changes-from-v1)
3. [Database Schema - NEW STRUCTURE](#3-database-schema---new-structure)
4. [Backend Changes](#4-backend-changes)
5. [Frontend Changes](#5-frontend-changes)
6. [Notification Types](#6-notification-types)
7. [Implementation Plan](#7-implementation-plan)
8. [Code Examples](#8-code-examples)
9. [Testing Checklist](#9-testing-checklist)

---

## 1. SYSTEM OVERVIEW

### ✅ Core Principles:

1. **Simpler is Better**: Boolean flags instead of complex enums/JSON
2. **Clear Semantics**: `actor` and `target` instead of `buyer` and `seller`
3. **Flexible**: Works for any user-to-user interaction
4. **Clean Code**: **Bengali ONLY in UI labels**, NOT in backend code/comments
5. **Three Dashboards**: Admin, Seller (Teacher), Buyer (User)

---

## 2. KEY CHANGES FROM V1

### 🔄 Database Changes:

| V1 (Old) | V2 (New) | Reason |
|----------|----------|---------|
| `buyer_id` | `actor_user_id` | More flexible - works for any action |
| `seller_id` | `target_user_id` | Not limited to buyer/seller roles |
| `priority` (enum) | `is_emergency` (boolean) | Simpler - just yes/no |
| `channels` (JSON) | `sent_email` (boolean) | Website always shown, email optional |

### 🎨 UI/UX Changes:

| V1 (Old) | V2 (New) |
|----------|----------|
| Priority radio buttons (Normal/Emergency) | Simple emergency checkbox |
| Channels checkboxes (Website/Email) | Single email checkbox |
| Display: "Buyer \| Seller" | Display: "Actor → Target" (with arrow) |
| Bengali in backend validation | Bengali ONLY in UI |

---

## 3. DATABASE SCHEMA - NEW STRUCTURE

### 🗄️ **Complete Table Structure:**

```sql
CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,

  -- RECIPIENTS (Who gets this notification)
  `user_id` bigint UNSIGNED NOT NULL,           -- Main recipient

  -- CONTEXT (Who did what to whom)
  `actor_user_id` bigint UNSIGNED NULL,         -- Who performed the action
  `target_user_id` bigint UNSIGNED NULL,        -- Who the action affects

  -- RELATED ENTITIES
  `order_id` bigint UNSIGNED NULL,              -- Related order/booking
  `service_id` bigint UNSIGNED NULL,            -- Related service/gig

  -- CLASSIFICATION
  `type` varchar(255) NOT NULL,                 -- Notification type
  `is_emergency` tinyint(1) DEFAULT 0,          -- Emergency flag (0/1)
  `sent_email` tinyint(1) DEFAULT 1,            -- Was email sent? (0/1)

  -- CONTENT
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `data` json NULL,                             -- Additional metadata

  -- ADMIN TRACKING
  `sent_by_admin_id` bigint UNSIGNED NULL,      -- Admin who sent (for manual)
  `scheduled_at` timestamp NULL DEFAULT NULL,    -- For future scheduling

  -- STATUS
  `is_read` tinyint(1) DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,

  -- TIMESTAMPS
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,

  -- FOREIGN KEYS
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`actor_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`target_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`order_id`) REFERENCES `book_orders` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`service_id`) REFERENCES `teacher_gigs` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`sent_by_admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,

  -- INDEXES
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_actor_user_id` (`actor_user_id`),
  INDEX `idx_target_user_id` (`target_user_id`),
  INDEX `idx_order_id` (`order_id`),
  INDEX `idx_service_id` (`service_id`),
  INDEX `idx_type` (`type`),
  INDEX `idx_is_emergency` (`is_emergency`),
  INDEX `idx_is_read` (`is_read`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 📝 **Column Descriptions:**

| Column | Type | Purpose | Example |
|--------|------|---------|---------|
| `user_id` | BIGINT | Who receives this notification | Seller ID when buyer cancels |
| `actor_user_id` | BIGINT | Who performed the action | Buyer ID who cancelled |
| `target_user_id` | BIGINT | Who is affected by action | Seller ID whose order was cancelled |
| `order_id` | BIGINT | Related order/booking | Order #12345 |
| `service_id` | BIGINT | Related service/gig | Service "Piano Lessons" |
| `type` | VARCHAR | Notification category | `order_cancelled_by_buyer` |
| `is_emergency` | BOOLEAN | Emergency notification? | `true` for critical alerts |
| `sent_email` | BOOLEAN | Was email sent? | `true` if email delivered |
| `sent_by_admin_id` | BIGINT | Which admin sent (manual) | Admin user ID |
| `scheduled_at` | TIMESTAMP | When to send (future) | `2025-12-01 10:00:00` |

### 🔍 **Why Actor/Target Instead of Buyer/Seller?**

**Problem with Buyer/Seller:**
- Only works for transactions
- Doesn't work for: reschedule requests, reviews, messages, admin actions

**Solution with Actor/Target:**
```php
// Buyer cancels order
actor_user_id = $buyerId      // Buyer performed cancellation
target_user_id = $sellerId    // Seller is affected

// Seller rejects reschedule
actor_user_id = $sellerId     // Seller performed rejection
target_user_id = $buyerId     // Buyer is affected

// Admin sends notification
actor_user_id = $adminId      // Admin performed action
target_user_id = NULL         // Broadcast to many
```

---

## 4. BACKEND CHANGES

### 🔧 **A. Notification Model** (`app/Models/Notification.php`)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'actor_user_id',        // NEW
        'target_user_id',       // NEW
        'order_id',
        'service_id',
        'type',
        'is_emergency',         // NEW (boolean)
        'sent_email',           // NEW (boolean)
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
        'sent_by_admin_id',
        'scheduled_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_emergency' => 'boolean',    // NEW
        'sent_email' => 'boolean',      // NEW
        'read_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the recipient user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the actor (who performed the action)
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    /**
     * Get the target (who is affected)
     */
    public function target()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    /**
     * Get the related order
     */
    public function order()
    {
        return $this->belongsTo(\App\Models\BookOrder::class, 'order_id');
    }

    /**
     * Get the related service
     */
    public function service()
    {
        return $this->belongsTo(\App\Models\TeacherGig::class, 'service_id');
    }

    /**
     * Get the admin who sent this
     */
    public function sentByAdmin()
    {
        return $this->belongsTo(User::class, 'sent_by_admin_id');
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    /**
     * Check if scheduled for future
     */
    public function isScheduled()
    {
        return $this->scheduled_at && $this->scheduled_at->isFuture();
    }
}
```

**IMPORTANT**: NO Bengali in model code!

---

### 🔧 **B. NotificationService** (`app/Services/NotificationService.php`)

```php
<?php

namespace App\Services;

use App\Models\Notification;
use App\Events\NotificationSent;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send notification
     *
     * @param int|array $userId Recipient user ID(s)
     * @param string $type Notification type
     * @param string $title Title
     * @param string $message Message
     * @param array $data Additional data
     * @param bool $sendEmail Send email?
     * @param int|null $actorUserId Who did the action
     * @param int|null $targetUserId Who is affected
     * @param int|null $orderId Related order
     * @param int|null $serviceId Related service
     * @param bool $isEmergency Emergency notification?
     * @param int|null $sentByAdminId Admin who sent
     * @param string|null $scheduledAt When to send
     * @return Notification|array|null
     */
    public function send(
        $userId,
        $type,
        $title,
        $message,
        $data = [],
        $sendEmail = true,
        $actorUserId = null,
        $targetUserId = null,
        $orderId = null,
        $serviceId = null,
        $isEmergency = false,
        $sentByAdminId = null,
        $scheduledAt = null
    ) {
        // Handle multiple users
        if (is_array($userId)) {
            $notifications = [];
            foreach ($userId as $singleUserId) {
                $notifications[] = $this->send(
                    $singleUserId,
                    $type,
                    $title,
                    $message,
                    $data,
                    $sendEmail,
                    $actorUserId,
                    $targetUserId,
                    $orderId,
                    $serviceId,
                    $isEmergency,
                    $sentByAdminId,
                    $scheduledAt
                );
            }
            return $notifications;
        }

        // Create notification
        $notification = Notification::create([
            'user_id' => $userId,
            'actor_user_id' => $actorUserId,
            'target_user_id' => $targetUserId,
            'order_id' => $orderId,
            'service_id' => $serviceId,
            'type' => $type,
            'is_emergency' => $isEmergency,
            'sent_email' => $sendEmail,
            'title' => $title,
            'message' => $message,
            'data' => is_array($data) ? json_encode($data) : $data,
            'sent_by_admin_id' => $sentByAdminId,
            'scheduled_at' => $scheduledAt
        ]);

        // If scheduled, don't send now
        if ($scheduledAt && strtotime($scheduledAt) > time()) {
            return $notification;
        }

        // Always broadcast to website
        broadcast(new NotificationSent($notification, $userId));

        // Send email if enabled
        if ($sendEmail) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->email) {
                try {
                    Mail::to($user->email)->send(new NotificationMail([
                        'title' => $title,
                        'message' => $message,
                        'data' => is_string($data) ? json_decode($data, true) : $data,
                        'is_emergency' => $isEmergency
                    ]));
                } catch (\Exception $e) {
                    \Log::error('Failed to send notification email: ' . $e->getMessage(), [
                        'notification_id' => $notification->id,
                        'user_id' => $userId,
                        'email' => $user->email
                    ]);
                }
            }
        }

        return $notification;
    }

    /**
     * Send to multiple users
     */
    public function sendToMultipleUsers(
        array $userIds,
        $type,
        $title,
        $message,
        $data = [],
        $sendEmail = true,
        $actorUserId = null,
        $targetUserId = null,
        $orderId = null,
        $serviceId = null,
        $isEmergency = false,
        $sentByAdminId = null
    ) {
        return $this->send(
            $userIds,
            $type,
            $title,
            $message,
            $data,
            $sendEmail,
            $actorUserId,
            $targetUserId,
            $orderId,
            $serviceId,
            $isEmergency,
            $sentByAdminId
        );
    }
}
```

**IMPORTANT**: NO Bengali in service code!

---

### 🔧 **C. NotificationController** (`app/Http/Controllers/NotificationController.php`)

**Key Changes:**

1. **Eager load actor and target** (not buyer/seller):
```php
'actor:id,first_name,last_name,email',
'target:id,first_name,last_name,email',
```

2. **Validation** (English only):
```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'message' => 'required|string',
    'targetUser' => 'required|in:all,seller,buyer,specific',
    'user_ids' => 'required_if:targetUser,specific|array',
    'is_emergency' => 'boolean',
    'send_email' => 'boolean',
], [
    'title.required' => 'Title is required',      // English only
    'message.required' => 'Message is required',  // English only
]);
```

3. **Send call**:
```php
$this->notificationService->sendToMultipleUsers(
    userIds: $userIds,
    type: 'admin_broadcast',
    title: $title,
    message: $message,
    data: [...],
    sendEmail: $sendEmail,            // boolean
    actorUserId: auth()->id(),        // admin
    targetUserId: null,
    orderId: null,
    serviceId: null,
    isEmergency: $isEmergency,        // boolean
    sentByAdminId: auth()->id()
);
```

---

## 5. FRONTEND CHANGES

### 🎨 **A. Admin Modal UI**

**File**: `resources/views/Admin-Dashboard/notification.blade.php`

#### Emergency Checkbox (Replace Priority Radio Buttons):

```html
<!-- Emergency Notification -->
<div class="mb-4" style="background: #fff3cd; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="is-emergency" name="is_emergency" value="1">
        <label class="form-check-label" for="is-emergency" style="cursor: pointer;">
            <strong style="color: #dc3545;">
                <i class="bx bx-error-circle"></i>
                Emergency Notification / জরুরি বিজ্ঞপ্তি
            </strong>
            <br>
            <small class="text-muted">
                Mark as high priority alert / উচ্চ অগ্রাধিকার সতর্কতা হিসাবে চিহ্নিত করুন
            </small>
        </label>
    </div>
</div>
```

#### Send Email Checkbox (Replace Channels Checkboxes):

```html
<!-- Send Email -->
<div class="mb-4" style="background: #d1ecf1; padding: 20px; border-radius: 8px; border-left: 4px solid #17a2b8;">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="send-email" name="send_email" value="1" checked>
        <label class="form-check-label" for="send-email" style="cursor: pointer;">
            <strong>
                <i class="bx bx-envelope"></i>
                Send Email Notification / ইমেইল বিজ্ঞপ্তি পাঠান
            </strong>
            <br>
            <small class="text-muted">
                Website notification always shown / ওয়েবসাইট বিজ্ঞপ্তি সর্বদা দেখানো হয়
            </small>
        </label>
    </div>
</div>
```

**Note**: Bengali in UI labels is OK!

---

### 🎨 **B. Notification List Display**

**Show Actor → Target with Arrow:**

```javascript
function renderNotifications(notifications) {
    notifications.forEach(function(notification) {
        // Build actor → target display
        let actorTargetDisplay = '';

        if (notification.actor && notification.target) {
            const actorName = (notification.actor.first_name + ' ' + notification.actor.last_name).trim();
            const targetName = (notification.target.first_name + ' ' + notification.target.last_name).trim();

            // Short format: "Shaki A → Gabriel A"
            const actorShort = actorName.split(' ')[0] + ' ' + (actorName.split(' ')[1]?.[0] || '');
            const targetShort = targetName.split(' ')[0] + ' ' + (targetName.split(' ')[1]?.[0] || '');

            actorTargetDisplay = `<span>
                <i class="bx bx-transfer"></i> ${actorShort} → ${targetShort}
            </span>`;
        } else if (notification.actor) {
            const actorName = (notification.actor.first_name + ' ' + notification.actor.last_name).trim();
            actorTargetDisplay = `<span><i class="bx bx-user"></i> ${actorName}</span>`;
        }

        // Emergency badge
        const emergencyBadge = notification.is_emergency ?
            '<span class="badge bg-danger"><i class="bx bx-error-circle"></i> EMERGENCY</span>' : '';

        // Email sent indicator
        const emailIcon = notification.sent_email ?
            '<i class="bx bx-envelope text-success" title="Email sent"></i>' :
            '<i class="bx bx-globe text-primary" title="Website only"></i>';

        // Build HTML
        const html = `
            <div class="notification-item">
                <h5>${notification.title} ${emergencyBadge}</h5>
                <p>${notification.message}</p>
                <div class="notification-meta">
                    <span class="notification-type">${notification.type}</span>
                    ${actorTargetDisplay}
                    ${emailIcon}
                    <span><i class="bx bx-time"></i> ${createdAt}</span>
                </div>
            </div>
        `;
    });
}
```

---

### 🎨 **C. JavaScript sendNotification()**

```javascript
function sendNotification() {
    $('#validation-errors').hide();

    // Get values
    const userIds = $('#notificationUserId').val() || [];
    const title = $('#notification-title').val().trim();
    const message = $('#notification-message').val().trim();
    const targetUser = $('input[name="targetUser"]:checked').val();
    const isEmergency = $('#is-emergency').is(':checked') ? 1 : 0;
    const sendEmail = $('#send-email').is(':checked') ? 1 : 0;

    // Validate (English only)
    const errors = [];
    if (!title) errors.push('Title is required');
    if (!message) errors.push('Message is required');
    if (!targetUser) errors.push('Please select target audience');
    if (targetUser === 'specific' && userIds.length === 0) {
        errors.push('Please select at least one user');
    }

    if (errors.length > 0) {
        $('#validation-errors').html('<ul>' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>').show();
        return;
    }

    // Send AJAX
    $.ajax({
        url: '/notifications/send',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            user_ids: userIds,
            title: title,
            message: message,
            targetUser: targetUser,
            is_emergency: isEmergency,
            send_email: sendEmail
        },
        success: function(response) {
            alert(response.message);
            location.reload();
        },
        error: function(xhr) {
            // Show error
            let errorMsg = 'Error sending notification';
            if (xhr.responseJSON?.message) {
                errorMsg = xhr.responseJSON.message;
            }
            $('#validation-errors').html(errorMsg).show();
        }
    });
}
```

---

## 6. NOTIFICATION TYPES

### 📌 **Complete Type List:**

```
Admin Notifications:
- manual_admin                    // Admin manually sent
- emergency_broadcast             // System-wide emergency

Order Lifecycle:
- order_created                   // New order placed
- order_approved                  // Seller approved order
- order_cancelled_by_buyer        // Buyer cancelled
- order_cancelled_by_seller       // Seller cancelled
- order_delivered                 // Marked as delivered
- order_completed                 // Completed after 48h

Class/Schedule:
- class_reminder                  // Upcoming class reminder
- class_started                   // Class has started
- class_ended                     // Class has ended
- reschedule_requested            // Reschedule request
- reschedule_approved             // Reschedule approved
- reschedule_rejected             // Reschedule rejected

Reviews:
- review_received                 // New review posted
- review_reply_received           // Reply to review

Payments:
- payment_received                // Payment confirmed
- refund_processed                // Refund completed

System:
- zoom_connected                  // Zoom connected
- zoom_token_expired              // Zoom token expired
- buyer_request_pending_reminder  // Pending request reminder
```

---

## 7. IMPLEMENTATION PLAN

### Phase 1: Database Migration (1 hour)

1. Rollback existing migration: `php artisan migrate:rollback --step=1`
2. Create new migration with correct structure
3. Run migration: `php artisan migrate`
4. Verify columns exist

### Phase 2: Backend Updates (2 hours)

1. Update `Notification` model
2. Update `NotificationService`
3. Update `NotificationController`
4. Clear caches

### Phase 3: Frontend Updates (3 hours)

1. Update Admin dashboard blade file
2. Update Teacher dashboard blade file
3. Update User dashboard blade file
4. Update JavaScript functions

### Phase 4: Testing (1 hour)

1. Test admin sending notifications
2. Test emergency flag
3. Test email toggle
4. Test actor → target display
5. Test all three dashboards

**Total Estimated Time: 7 hours**

---

## 8. CODE EXAMPLES

### Example 1: Buyer Cancels Order

```php
// In BookingController when buyer cancels
$notificationService->send(
    userId: $order->teacher_id,          // Seller receives notification
    type: 'order_cancelled_by_buyer',
    title: 'Order Cancelled',
    message: 'A buyer has cancelled their order',
    data: ['order_number' => $order->order_number],
    sendEmail: true,
    actorUserId: $order->user_id,        // Buyer who cancelled
    targetUserId: $order->teacher_id,    // Seller who is affected
    orderId: $order->id,
    serviceId: $order->gig_id,
    isEmergency: false
);

// Display in admin list: "John D → Sarah M"
```

### Example 2: Admin Emergency Broadcast

```php
// In NotificationController when admin sends emergency
$notificationService->sendToMultipleUsers(
    userIds: [all user IDs],
    type: 'emergency_broadcast',
    title: 'System Maintenance Alert',
    message: 'The system will be down for 1 hour',
    data: [],
    sendEmail: true,               // Send email to everyone
    actorUserId: auth()->id(),    // Admin who sent
    targetUserId: null,           // Broadcast to all
    orderId: null,
    serviceId: null,
    isEmergency: true,            // Emergency flag
    sentByAdminId: auth()->id()
);

// Display: Red EMERGENCY badge
```

### Example 3: Seller Rejects Reschedule

```php
// In ClassRescheduleController
$notificationService->send(
    userId: $reschedule->user_id,         // Buyer receives
    type: 'reschedule_rejected',
    title: 'Reschedule Request Rejected',
    message: 'Your reschedule request has been rejected',
    data: ['class_date' => $reschedule->new_date],
    sendEmail: true,
    actorUserId: $reschedule->teacher_id,  // Seller who rejected
    targetUserId: $reschedule->user_id,    // Buyer who requested
    orderId: $reschedule->order_id,
    serviceId: null,
    isEmergency: false
);

// Display: "Sarah M → John D"
```

---

## 9. TESTING CHECKLIST

### ✅ Database Tests:
- [ ] Migration runs successfully
- [ ] All columns exist with correct types
- [ ] Foreign keys work properly
- [ ] Indexes are created

### ✅ Backend Tests:
- [ ] NotificationService creates notifications correctly
- [ ] actor_user_id and target_user_id save properly
- [ ] is_emergency boolean works
- [ ] sent_email boolean works
- [ ] Email sends when send_email = true
- [ ] Email skips when send_email = false

### ✅ Frontend Tests (Admin):
- [ ] Emergency checkbox toggles correctly
- [ ] Send email checkbox toggles correctly
- [ ] Notification list shows "Actor → Target" with arrow
- [ ] Emergency badge displays in red
- [ ] Email icon displays correctly
- [ ] Validation errors show (English only)
- [ ] Success message shows after sending

### ✅ Frontend Tests (Seller):
- [ ] Notification list shows correctly
- [ ] Actor → Target display works
- [ ] Emergency badge shows
- [ ] Email indicator shows

### ✅ Frontend Tests (Buyer):
- [ ] Notification list shows correctly
- [ ] Actor → Target display works
- [ ] Emergency badge shows
- [ ] Email indicator shows

### ✅ Code Quality:
- [ ] NO Bengali in backend code/comments
- [ ] Bengali ONLY in UI labels
- [ ] All validation messages in English
- [ ] Code follows PSR-12 standards

---

## 🎯 IMPORTANT REMINDERS

1. **Bengali Language Rule:**
   - ✅ USE in: UI labels, placeholders, user-facing text
   - ❌ DO NOT USE in: Backend code, comments, validation, logs

2. **Display Format:**
   - Always use arrow (→) not pipe (|)
   - Format: "FirstName L → FirstName L"

3. **Boolean Simplicity:**
   - `is_emergency` → true/false (not enum)
   - `sent_email` → true/false (not JSON)

4. **Three Dashboards:**
   - Admin: Full features with send modal
   - Seller: View only, no send button
   - Buyer: View only, no send button

---

**END OF PLAN V2**
