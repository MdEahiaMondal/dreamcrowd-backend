# সম্পূর্ণ NOTIFICATION SYSTEM REDESIGN - PROFESSIONAL PLAN
# COMPREHENSIVE NOTIFICATION SYSTEM REDESIGN - PROFESSIONAL PLAN

**তারিখ / Date**: November 2025
**Current File**: `resources/views/Admin-Dashboard/notification.blade.php`
**Controller**: `app/Http/Controllers/NotificationController.php`
**Service**: `app/Services/NotificationService.php`

---

## 📋 INDEX / সূচিপত্র

1. [বর্তমান সিস্টেম বিশ্লেষণ / Current System Analysis](#1-current-system-analysis)
2. [সমস্যা চিহ্নিতকরণ / Problems Identified](#2-problems-identified)
3. [ক্লায়েন্টের চাহিদা / Client Requirements](#3-client-requirements)
4. [সম্পূর্ণ নোটিফিকেশন ট্রিগার ম্যাপ / Complete Notification Trigger Map](#4-notification-trigger-map)
5. [ডাটাবেস স্কিমা পরিবর্তন / Database Schema Changes](#5-database-schema-changes)
6. [নতুন UI/UX ডিজাইন / New UI/UX Design](#6-new-uiux-design)
7. [ব্যাকএন্ড পরিবর্তন / Backend Changes](#7-backend-changes)
8. [ইমপ্লিমেন্টেশন পর্যায় / Implementation Phases](#8-implementation-phases)
9. [টেস্টিং চেকলিস্ট / Testing Checklist](#9-testing-checklist)

---

## 1. বর্তমান সিস্টেম বিশ্লেষণ / CURRENT SYSTEM ANALYSIS

### ✅ যা আছে এখন / What Exists Now:

#### **A. Database Structure** (notifications table):
```sql
CREATE TABLE notifications (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,              -- যে ইউজার নোটিফিকেশন পাবে
    type VARCHAR(255),            -- notification type (order, message, etc.)
    title VARCHAR(255),           -- notification শিরোনাম
    message TEXT,                 -- notification বার্তা
    data TEXT NULLABLE,           -- additional JSON data
    is_read BOOLEAN DEFAULT 0,    -- পড়া হয়েছে কিনা
    read_at TIMESTAMP NULLABLE,   -- কখন পড়া হয়েছে
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### **B. NotificationService Methods**:
```php
// Single user notification
send($userId, $type, $title, $message, $data = [], $sendEmail = false)

// Multiple users notification
sendToMultipleUsers($userIds, $type, $title, $message, $data = [], $sendEmail = false)
```

#### **C. Notification Types** (বর্তমানে ব্যবহৃত / Currently Used):

| Type | কোথা থেকে আসে / Source | Example |
|------|------------------------|---------|
| `account` | User registration, password change | "Welcome to DreamCrowd!" |
| `order` | Order placed/cancelled/completed | "New order received" |
| `gig` | Service created/updated | "Service created successfully" |
| `message` | New chat message | "New message from John" |
| `custom_offer` | Custom offer sent/accepted/rejected | "New custom offer" |
| `review` | Review added/replied | "New review on your service" |
| `class_reminder` | Scheduled command | "Class starts in 30 minutes" |
| `zoom_connected` | Zoom OAuth connected | "Zoom successfully connected" |
| `zoom_token_expired` | Token expiration check | "Zoom token expired" |

---

## 2. সমস্যা চিহ্নিতকরণ / PROBLEMS IDENTIFIED

### 🔴 **Major Issues / প্রধান সমস্যা:**

#### **Problem 1: Confusing Send Modal / বিভ্রান্তিকর মডাল**
**বর্তমান অবস্থা:**
```html
<!-- এখন যা আছে - খুবই কনফিউজিং -->
<div class="mb-3">
    <label>Select Users:</label>
    <select multiple id="notificationUserId">
        <!-- শুধু user ID দেখায়, নাম বা ইমেইল নেই -->
    </select>
</div>
<div class="mb-3">
    <input type="checkbox" id="email" name="notification-type" value="1">
    <label>Email</label>  <!-- কি বুঝায়? Email type নাকি email send করবে? -->
</div>
```

**সমস্যা:**
- ❌ User ID দিয়ে সার্চ করতে হয় (ইমেইল/নাম দিয়ে না)
- ❌ "Email" checkbox এর মানে কি তা clear না
- ❌ কতজন user notification পাবে তা বোঝা যায় না
- ❌ Seller only / Buyer only / Both এর কোনো option নেই
- ❌ Emergency notification এর সুবিধা নেই

#### **Problem 2: Single Party Name / একজনের নাম দেখায়**
**বর্তমান notification format:**
```
[Bell Icon] Gabriel A
"Reschedule request rejected"
```

**সমস্যা:**
- ❌ Admin বুঝতে পারে না কে কার সাথে কি করেছে
- ❌ Buyer/Seller উভয়ের নাম দেখা উচিত: "Shaki A | Gabriel A"
- ❌ Order/Service details এর link নেই
- ❌ কোন service সম্পর্কিত notification তা clear না

#### **Problem 3: No Distinction Between Website & Email**
**বর্তমান:**
- Website notification সবসময় save হয়
- Email শুধু `sendEmail: true` হলে যায়
- কিন্তু Admin panel থেকে clear indication নেই কোনটা কি হচ্ছে

**ক্লায়েন্টের কনফিউশন:**
> "Does this relate to both website notification and email notifications?"

উত্তর: হ্যাঁ দুটোই হতে পারে, কিন্তু UI তে clear না!

#### **Problem 4: All Notification Triggers Scattered**
**সমস্যা:**
- 11+ different Controllers এ notification send করা হয়
- 11+ Scheduled Commands এ notification trigger হয়
- কোনো central documentation নেই
- কোথায় কোন notification trigger হচ্ছে track করা কঠিন

---

## 3. ক্লায়েন্টের চাহিদা / CLIENT REQUIREMENTS

### 📌 **Requirement 1: Clear Notification Types / স্পষ্ট নোটিফিকেশন টাইপ**

**ক্লায়েন্ট চায়:**
প্রতিটি notification **দুই প্রকারে** পাঠানো যাবে:

1. **In-App Notification** (ওয়েবসাইটের বেল আইকনে দেখা যাবে)
   - Database এ save হবে
   - Real-time Pusher event trigger হবে
   - Unread count update হবে

2. **Email Notification** (ইউজারের ইমেইল এ পাঠানো হবে)
   - NotificationMail class ব্যবহার করে
   - User এর email address এ send হবে
   - Optional (Admin চাইলে বন্ধ করতে পারবে)

**Solution:**
```html
<!-- নতুন ডিজাইন -->
<div class="mb-3 border rounded p-3">
    <label class="fw-bold">
        <i class="bx bx-send"></i> Delivery Channels / পাঠানোর মাধ্যম:
    </label>
    <div class="row">
        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" id="send-website" name="channels[]" value="website" checked>
                <label for="send-website">
                    <i class="bx bx-bell text-primary"></i> ওয়েবসাইট নোটিফিকেশন
                    <small class="d-block text-muted">ইউজারের বেল আইকনে দেখা যাবে</small>
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-check">
                <input type="checkbox" id="send-email" name="channels[]" value="email">
                <label for="send-email">
                    <i class="bx bx-envelope text-success"></i> ইমেইল নোটিফিকেশন
                    <small class="d-block text-muted">ইউজারের ইমেইল এ পাঠানো হবে</small>
                </label>
            </div>
        </div>
    </div>
</div>
```

---

### 📌 **Requirement 2: Smart User Targeting / স্মার্ট ইউজার টার্গেটিং**

**ক্লায়েন্ট চায় ৪টি অপশন:**

1. **All Users / সব ইউজার** → সব Seller + সব Buyer
2. **Sellers Only / শুধু Seller রা** → শুধু role = 1
3. **Buyers Only / শুধু Buyer রা** → শুধু role = 0
4. **Specific Users / নির্দিষ্ট ইউজার** → ইমেইল/নাম দিয়ে সার্চ

**Solution:**
```html
<div class="mb-4 border rounded p-3">
    <label class="fw-bold">
        <i class="bx bx-target-lock"></i> কাকে পাঠাবেন? / Target Audience:
    </label>

    <!-- Broadcast Options -->
    <div class="btn-group w-100 mb-3" role="group">
        <input type="radio" class="btn-check" name="targetMode" id="mode-all" value="all">
        <label class="btn btn-outline-info" for="mode-all">
            <i class="bx bx-globe"></i> সব ইউজার / All Users
        </label>

        <input type="radio" class="btn-check" name="targetMode" id="mode-sellers" value="sellers">
        <label class="btn btn-outline-primary" for="mode-sellers">
            <i class="bx bx-briefcase"></i> শুধু Seller / Sellers Only
        </label>

        <input type="radio" class="btn-check" name="targetMode" id="mode-buyers" value="buyers">
        <label class="btn btn-outline-success" for="mode-buyers">
            <i class="bx bx-user"></i> শুধু Buyer / Buyers Only
        </label>

        <input type="radio" class="btn-check" name="targetMode" id="mode-specific" value="specific">
        <label class="btn btn-outline-warning" for="mode-specific">
            <i class="bx bx-user-check"></i> নির্দিষ্ট ইউজার / Specific Users
        </label>
    </div>

    <!-- Specific Users Dropdown (এই section শুধু "Specific Users" সিলেক্ট করলে দেখা যাবে) -->
    <div id="specific-users-section" style="display: none;">
        <label class="text-muted mb-2">ইমেইল/নাম দিয়ে সার্চ করুন:</label>
        <select multiple class="form-control" id="notificationUserId" style="width: 100%">
            <!-- AJAX autocomplete এর মাধ্যমে user list আসবে -->
            <!-- Format: "John Doe (john@example.com) - Seller" -->
        </select>
        <small class="text-muted">Ctrl/Cmd চেপে একাধিক ইউজার সিলেক্ট করুন</small>
    </div>

    <!-- Recipient Counter / কতজন পাবে তা দেখানো -->
    <div class="alert alert-light border mt-3">
        <i class="bx bx-info-circle"></i>
        <strong>প্রাপক / Recipients:</strong>
        <span id="recipient-count" class="text-primary fw-bold">0 জন সিলেক্ট করা হয়েছে</span>
    </div>
</div>
```

**JavaScript Logic:**
```javascript
// Real-time recipient count
$('input[name="targetMode"]').on('change', function() {
    const mode = $(this).val();

    if (mode === 'specific') {
        $('#specific-users-section').slideDown();
        updateRecipientCount();
    } else {
        $('#specific-users-section').slideUp();

        // Get count from server
        $.get('/admin/users/count', { role: mode }, function(response) {
            let text = '';
            if (mode === 'all') text = response.count + ' জন ইউজার (Sellers + Buyers)';
            else if (mode === 'sellers') text = response.count + ' জন Seller';
            else if (mode === 'buyers') text = response.count + ' জন Buyer';

            $('#recipient-count').text(text);
        });
    }
});

// Update count when specific users selected
$('#notificationUserId').on('change', function() {
    const count = $(this).val()?.length || 0;
    $('#recipient-count').text(count + ' জন ইউজার সিলেক্ট করা হয়েছে');
});
```

---

### 📌 **Requirement 3: Emergency Notifications / জরুরি নোটিফিকেশন**

**ক্লায়েন্ট চায়:**
- Emergency/High Priority নোটিফিকেশন পাঠানোর সুবিধা
- Emergency হলে **সবসময়** Website + Email দুটোই যাবে
- ইউজারের notification list এ লাল badge দেখাবে
- Admin log এ track করা যাবে

**Solution:**
```html
<div class="mb-4 border rounded p-3">
    <label class="fw-bold">
        <i class="bx bx-flag"></i> Priority Level / অগ্রাধিকার স্তর:
    </label>

    <div class="form-check">
        <input type="radio" name="priority" id="priority-normal" value="normal" checked>
        <label for="priority-normal">
            <i class="bx bx-info-circle text-primary"></i> সাধারণ / Normal
            <small class="d-block text-muted">স্ট্যান্ডার্ড নোটিফিকেশন</small>
        </label>
    </div>

    <div class="form-check mt-2">
        <input type="radio" name="priority" id="priority-emergency" value="emergency">
        <label for="priority-emergency">
            <i class="bx bx-error text-danger"></i> জরুরি / Emergency
            <small class="d-block text-muted">
                ⚠️ স্বয়ংক্রিয়ভাবে Website + Email দুটোই পাঠানো হবে
            </small>
        </label>
    </div>
</div>

<script>
// Emergency priority behavior
$('input[name="priority"]').on('change', function() {
    if ($(this).val() === 'emergency') {
        // Force both channels
        $('#send-website, #send-email').prop('checked', true).prop('disabled', true);

        // Show warning
        Swal.fire({
            icon: 'warning',
            title: 'জরুরি নোটিফিকেশন / Emergency Notification',
            html: 'এই নোটিফিকেশন <strong>Website + Email</strong> দুটো মাধ্যমেই পাঠানো হবে।<br>আপনি কি নিশ্চিত?',
            confirmButtonText: 'হ্যাঁ, নিশ্চিত / Yes, Confirm'
        });
    } else {
        // Normal priority - allow selection
        $('#send-website, #send-email').prop('disabled', false);
    }
});
</script>
```

---

### 📌 **Requirement 4: Show Both Names / দুইজনের নাম দেখানো**

**ক্লায়েন্টের উদাহরণ:**
> "Admin এর notification এ দুইজনের নামই দেখাক: **Shaki A | Gabriel A**"

**বর্তমান Format:**
```
[Bell] Gabriel A
"Reschedule request rejected"
```

**নতুন Format (যা ক্লায়েন্ট চায়):**
```
┌─────────────────────────────────────────────────────────────────┐
│ [👤 Buyer Icon] Buyer: Shaki A  |  [💼 Seller Icon] Seller: Gabriel A  │
│ → "Reschedule request rejected for Chess Class"               │
│                                                                 │
│ 🎓 Service: "I will teach you how to play chess"              │
│ 📋 Order ID: #12345  |  📅 Date: 14/11/2025 05:41            │
│                                                                 │
│ [View Order Details →]                                         │
└─────────────────────────────────────────────────────────────────┘
```

**Implementation:**

**Database Changes Needed:**
```sql
ALTER TABLE notifications ADD COLUMN buyer_id BIGINT NULLABLE AFTER user_id;
ALTER TABLE notifications ADD COLUMN seller_id BIGINT NULLABLE AFTER buyer_id;
ALTER TABLE notifications ADD COLUMN order_id BIGINT NULLABLE AFTER seller_id;
ALTER TABLE notifications ADD COLUMN service_id BIGINT NULLABLE AFTER order_id;

-- Foreign keys
ALTER TABLE notifications ADD FOREIGN KEY (buyer_id) REFERENCES users(id);
ALTER TABLE notifications ADD FOREIGN KEY (seller_id) REFERENCES users(id);
ALTER TABLE notifications ADD FOREIGN KEY (order_id) REFERENCES book_orders(id);
ALTER TABLE notifications ADD FOREIGN KEY (service_id) REFERENCES teacher_gigs(id);
```

**Controller Method Update:**
```php
// NotificationService::send() method এ নতুন parameters যোগ
public function send(
    $userId,
    $type,
    $title,
    $message,
    $data = [],
    $sendEmail = false,
    $buyerId = null,      // NEW
    $sellerId = null,     // NEW
    $orderId = null,      // NEW
    $serviceId = null,    // NEW
    $priority = 'normal'  // NEW
) {
    $notification = Notification::create([
        'user_id' => $userId,
        'buyer_id' => $buyerId,
        'seller_id' => $sellerId,
        'order_id' => $orderId,
        'service_id' => $serviceId,
        'type' => $type,
        'priority' => $priority,
        'title' => $title,
        'message' => $message,
        'data' => $data
    ]);

    // ... rest of the code
}
```

**View Template:**
```blade
<!-- Admin Notification List -->
@foreach($notifications as $notification)
<div class="notification-item {{ $notification->priority === 'emergency' ? 'border-danger' : '' }}">
    <div class="row">
        <div class="col-md-12">
            <!-- Parties Involved -->
            <div class="notification-parties mb-2">
                @if($notification->buyer_id && $notification->buyer)
                    <span class="party-badge buyer">
                        <i class="bx bx-user"></i>
                        <strong>Buyer:</strong> {{ $notification->buyer->first_name }} {{ substr($notification->buyer->last_name, 0, 1) }}.
                    </span>
                @endif

                @if($notification->buyer_id && $notification->seller_id)
                    <span class="separator">|</span>
                @endif

                @if($notification->seller_id && $notification->seller)
                    <span class="party-badge seller">
                        <i class="bx bx-briefcase"></i>
                        <strong>Seller:</strong> {{ $notification->seller->first_name }} {{ substr($notification->seller->last_name, 0, 1) }}.
                    </span>
                @endif

                @if($notification->priority === 'emergency')
                    <span class="badge bg-danger ms-2">
                        <i class="bx bx-error-circle"></i> EMERGENCY
                    </span>
                @endif
            </div>

            <!-- Notification Message -->
            <h5 class="notification-title">
                <i class="bx bx-right-arrow-alt"></i> {{ $notification->title }}
            </h5>
            <p class="notification-message">{{ $notification->message }}</p>

            <!-- Related Information -->
            <div class="notification-meta">
                @if($notification->service_id && $notification->service)
                    <span>
                        <i class="bx bx-book"></i>
                        <strong>Service:</strong> {{ Str::limit($notification->service->title, 40) }}
                    </span>
                @endif

                @if($notification->order_id)
                    <span>
                        <i class="bx bx-receipt"></i>
                        <strong>Order ID:</strong> #{{ $notification->order_id }}
                    </span>
                @endif

                <span>
                    <i class="bx bx-time"></i>
                    {{ $notification->created_at->format('d/m/Y H:i') }}
                </span>
            </div>

            <!-- Action Button -->
            @if($notification->order_id)
                <a href="/admin/order-details/{{ $notification->order_id }}"
                   class="btn btn-sm btn-primary mt-2">
                    <i class="bx bx-show"></i> View Order Details
                </a>
            @endif
        </div>
    </div>
</div>
@endforeach
```

---

## 4. সম্পূর্ণ NOTIFICATION TRIGGER MAP / COMPLETE NOTIFICATION TRIGGER MAP

### 📊 **All Notification Types & Sources / সব নোটিফিকেশন টাইপ ও উৎস:**

#### **A. User Account Events / ইউজার অ্যাকাউন্ট ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| User Registration | `AuthController::register()` L128 | `account` | New User | ❌ No |
| Password Changed | `AuthController::changePassword()` L704 | `account` | User | ❌ No |
| Seller Application Submitted | `ExpertController::ExpertProfile()` L390 | `account` | Applicant | ✅ Yes |
| Seller Application Submitted | `ExpertController::ExpertProfile()` L402 | `account` | All Admins | ✅ Yes |

---

#### **B. Order/Booking Events / অর্ডার/বুকিং ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| New Order (Custom Offer) | `BookingController` L1092 | `new_order` | Seller | ✅ Yes |
| Order Cancelled | `AutoCancelPendingOrders.php` | `order_cancelled` | Buyer + Seller + Admin | ✅ Yes |
| Order Delivered | `AutoMarkDelivered.php` | `order_delivered` | Buyer + Seller | ✅ Yes |
| Order Completed | `AutoMarkCompleted.php` | `order_completed` | Seller | ✅ Yes |
| Order Approval Reminder | `SendOrderApprovalReminders.php` | `order_reminder` | Buyer | ✅ Yes |

---

#### **C. Service/Gig Events / সার্ভিস/গিগ ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Service Created | `ClassManagementController` L680 | `gig` | Seller (Creator) | ❌ No |
| Service Created | `ClassManagementController` L692 | `gig` | All Admins | ❌ No |
| Service Status Updated | `UpdateTeacherGigStatus.php` | `gig` | Seller | ✅ Yes |

---

#### **D. Custom Offer Events / কাস্টম অফার ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Offer Sent | `MessagesController` L2463 | `custom_offer` | Buyer | ❌ No |
| Offer Accepted | `MessagesController` L2573 | `custom_offer` | Seller | ✅ Yes |
| Offer Rejected | `MessagesController` L2634 | `custom_offer` | Seller | ❌ No |
| Offer Expired | `ExpireCustomOffers.php` | `custom_offer` | Buyer + Seller | ✅ Yes |

---

#### **E. Message/Communication Events / মেসেজ/যোগাযোগ ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| New Message | `MessagesController` L492, L576 | `message` | Receiver | ❌ No |

---

#### **F. Class/Zoom Events / ক্লাস/জুম ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Class Reminder (30 min) | `SendClassReminders.php` | `class_reminder` | Buyer + Seller | ✅ Yes |
| Class Started | `GenerateZoomMeetings.php` | `class_started` | Buyer + Seller | ❌ No |
| Class Ended | `GenerateZoomMeetings.php` | `class_ended` | Buyer + Seller | ❌ No |
| Zoom Connected | `ZoomOAuthController` | `zoom_connected` | Seller | ❌ No |
| Zoom Token Expired | Check scheduled | `zoom_token_expired` | Seller | ✅ Yes |

---

#### **G. Review Events / রিভিউ ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Seller Replied to Review | `TeacherController` L1138 | `review` | Buyer (Reviewer) | ❌ No |

---

#### **H. Coupon Events / কুপন ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Coupon Expiring Soon | `NotifyCouponExpiring.php` | `coupon_expiring` | Buyer (who has coupon) | ✅ Yes |

---

#### **I. Dispute Events / ডিসপিউট ইভেন্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Dispute Auto-Processed | `AutoHandleDisputes.php` | `dispute` | Buyer + Seller + Admin | ✅ Yes |

---

#### **J. System Reports / সিস্টেম রিপোর্ট**

| Event | Trigger | Type | Recipients | Email? |
|-------|---------|------|-----------|--------|
| Daily System Report | `SendDailySystemReport.php` | `system_report` | All Admins | ✅ Yes |

---

### 📝 **Summary / সারসংক্ষেপ:**
- **Total Notification Types**: 10+ different types
- **Total Trigger Points**: 30+ locations
  - Controllers: 15+ triggers
  - Scheduled Commands: 11 commands
- **Email Notifications**: ~60% of events send emails
- **Real-time**: Pusher events for instant updates

---

## 5. ডাটাবেস স্কিমা পরিবর্তন / DATABASE SCHEMA CHANGES

### 🗄️ **New Migration: Enhanced Notifications Table**

```php
<?php
// database/migrations/2025_11_XX_add_enhanced_columns_to_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // NEW: Priority level
            $table->enum('priority', ['normal', 'emergency'])
                  ->default('normal')
                  ->after('type');

            // NEW: Delivery channels used (JSON)
            $table->json('channels')
                  ->nullable()
                  ->after('priority')
                  ->comment('["website", "email"]');

            // NEW: Related parties
            $table->unsignedBigInteger('buyer_id')
                  ->nullable()
                  ->after('user_id');

            $table->unsignedBigInteger('seller_id')
                  ->nullable()
                  ->after('buyer_id');

            // NEW: Related records
            $table->unsignedBigInteger('order_id')
                  ->nullable()
                  ->after('seller_id');

            $table->unsignedBigInteger('service_id')
                  ->nullable()
                  ->after('order_id');

            // NEW: Admin who sent (for manual notifications)
            $table->unsignedBigInteger('sent_by_admin_id')
                  ->nullable()
                  ->after('service_id');

            // NEW: Scheduled send time
            $table->timestamp('scheduled_at')
                  ->nullable()
                  ->after('sent_by_admin_id');

            // Foreign keys
            $table->foreign('buyer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('seller_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            $table->foreign('order_id')
                  ->references('id')
                  ->on('book_orders')
                  ->onDelete('cascade');

            $table->foreign('service_id')
                  ->references('id')
                  ->on('teacher_gigs')
                  ->onDelete('set null');

            $table->foreign('sent_by_admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');

            // Indexes for performance
            $table->index(['buyer_id', 'seller_id']);
            $table->index('order_id');
            $table->index('priority');
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropForeign(['seller_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['sent_by_admin_id']);

            $table->dropColumn([
                'priority',
                'channels',
                'buyer_id',
                'seller_id',
                'order_id',
                'service_id',
                'sent_by_admin_id',
                'scheduled_at'
            ]);
        });
    }
};
```

### 📋 **Updated Table Structure:**

```sql
CREATE TABLE notifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Recipients
    user_id BIGINT NOT NULL,           -- Main recipient (who will see it)
    buyer_id BIGINT NULL,              -- Buyer involved (for context)
    seller_id BIGINT NULL,             -- Seller involved (for context)

    -- Classification
    type VARCHAR(255) NOT NULL,        -- order, message, gig, etc.
    priority ENUM('normal', 'emergency') DEFAULT 'normal',
    channels JSON NULL,                 -- ["website", "email"]

    -- Content
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data TEXT NULL,                     -- Additional JSON data

    -- Related Records
    order_id BIGINT NULL,
    service_id BIGINT NULL,

    -- Admin tracking
    sent_by_admin_id BIGINT NULL,      -- If sent by admin manually
    scheduled_at TIMESTAMP NULL,        -- For future: scheduled sending

    -- Status
    is_read BOOLEAN DEFAULT 0,
    read_at TIMESTAMP NULL,

    -- Timestamps
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Foreign Keys
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (order_id) REFERENCES book_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES teacher_gigs(id) ON DELETE SET NULL,
    FOREIGN KEY (sent_by_admin_id) REFERENCES users(id) ON DELETE SET NULL,

    -- Indexes
    INDEX idx_user_read (user_id, is_read),
    INDEX idx_parties (buyer_id, seller_id),
    INDEX idx_order (order_id),
    INDEX idx_priority (priority),
    INDEX idx_scheduled (scheduled_at)
);
```

---

## 6. নতুন UI/UX ডিজাইন / NEW UI/UX DESIGN

### 🎨 **Professional Send Notification Modal**

```html
<!-- COMPLETE NEW MODAL DESIGN -->
<div class="modal fade" id="sendNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-send me-2"></i>
                    নতুন নোটিফিকেশন পাঠান / Send New Notification
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form id="send-notification-form">

                    <!-- STEP 1: Priority Level -->
                    <div class="notification-section mb-4">
                        <div class="section-header">
                            <i class="bx bx-flag text-primary"></i>
                            <h6 class="mb-0">অগ্রাধিকার স্তর / Priority Level</h6>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="priority-card" id="normal-card">
                                    <input type="radio" name="priority" id="priority-normal" value="normal" checked hidden>
                                    <label for="priority-normal" class="priority-label">
                                        <div class="priority-icon">
                                            <i class="bx bx-info-circle text-primary"></i>
                                        </div>
                                        <div class="priority-content">
                                            <h6>সাধারণ / Normal</h6>
                                            <small>স্ট্যান্ডার্ড নোটিফিকেশন</small>
                                        </div>
                                        <div class="priority-check">
                                            <i class="bx bx-check-circle"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="priority-card" id="emergency-card">
                                    <input type="radio" name="priority" id="priority-emergency" value="emergency" hidden>
                                    <label for="priority-emergency" class="priority-label">
                                        <div class="priority-icon">
                                            <i class="bx bx-error text-danger"></i>
                                        </div>
                                        <div class="priority-content">
                                            <h6>জরুরি / Emergency</h6>
                                            <small>⚠️ সব মাধ্যমে পাঠানো হবে</small>
                                        </div>
                                        <div class="priority-check">
                                            <i class="bx bx-check-circle"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Delivery Channels -->
                    <div class="notification-section mb-4" id="channels-section">
                        <div class="section-header">
                            <i class="bx bx-broadcast text-success"></i>
                            <h6 class="mb-0">পাঠানোর মাধ্যম / Delivery Channels</h6>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="channel-card">
                                    <input type="checkbox" id="channel-website" name="channels[]" value="website" checked>
                                    <label for="channel-website">
                                        <div class="channel-icon">
                                            <i class="bx bx-bell"></i>
                                        </div>
                                        <div class="channel-content">
                                            <h6>ওয়েবসাইট নোটিফিকেশন</h6>
                                            <small>ইউজারের বেল আইকনে দেখা যাবে</small>
                                        </div>
                                        <div class="channel-check">
                                            <i class="bx bx-check-square"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="channel-card">
                                    <input type="checkbox" id="channel-email" name="channels[]" value="email">
                                    <label for="channel-email">
                                        <div class="channel-icon">
                                            <i class="bx bx-envelope"></i>
                                        </div>
                                        <div class="channel-content">
                                            <h6>ইমেইল নোটিফিকেশন</h6>
                                            <small>ইউজারের ইমেইল এ পাঠানো হবে</small>
                                        </div>
                                        <div class="channel-check">
                                            <i class="bx bx-check-square"></i>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" id="channel-warning">
                            <i class="bx bx-info-circle"></i>
                            অন্তত একটি মাধ্যম সিলেক্ট করতে হবে
                        </div>
                    </div>

                    <!-- STEP 3: Target Audience -->
                    <div class="notification-section mb-4">
                        <div class="section-header">
                            <i class="bx bx-target-lock text-warning"></i>
                            <h6 class="mb-0">কাকে পাঠাবেন? / Target Audience</h6>
                        </div>

                        <!-- Broadcast Buttons -->
                        <div class="target-buttons mt-3">
                            <input type="radio" name="targetMode" id="target-all" value="all" class="btn-check">
                            <label for="target-all" class="btn btn-outline-info">
                                <i class="bx bx-globe"></i>
                                <span class="d-block fw-bold">সব ইউজার</span>
                                <small>All Users</small>
                            </label>

                            <input type="radio" name="targetMode" id="target-sellers" value="sellers" class="btn-check">
                            <label for="target-sellers" class="btn btn-outline-primary">
                                <i class="bx bx-briefcase"></i>
                                <span class="d-block fw-bold">শুধু Seller</span>
                                <small>Sellers Only</small>
                            </label>

                            <input type="radio" name="targetMode" id="target-buyers" value="buyers" class="btn-check">
                            <label for="target-buyers" class="btn btn-outline-success">
                                <i class="bx bx-user"></i>
                                <span class="d-block fw-bold">শুধু Buyer</span>
                                <small>Buyers Only</small>
                            </label>

                            <input type="radio" name="targetMode" id="target-specific" value="specific" class="btn-check">
                            <label for="target-specific" class="btn btn-outline-warning">
                                <i class="bx bx-user-check"></i>
                                <span class="d-block fw-bold">নির্দিষ্ট ইউজার</span>
                                <small>Specific Users</small>
                            </label>
                        </div>

                        <!-- Specific Users Dropdown -->
                        <div id="specific-users-section" class="mt-3" style="display: none;">
                            <label class="form-label text-muted">
                                <i class="bx bx-search"></i>
                                ইমেইল/নাম দিয়ে সার্চ করুন:
                            </label>
                            <select multiple class="form-control select2-ajax" id="notificationUserId" style="width: 100%">
                                <!-- AJAX autocomplete -->
                            </select>
                            <small class="text-muted">
                                <i class="bx bx-info-circle"></i>
                                Ctrl/Cmd চেপে একাধিক ইউজার সিলেক্ট করুন
                            </small>
                        </div>

                        <!-- Recipient Counter -->
                        <div class="alert alert-light border mt-3 mb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <i class="bx bx-group text-primary fs-4"></i>
                                    <span class="ms-2">
                                        <strong>প্রাপক / Recipients:</strong>
                                    </span>
                                </div>
                                <div>
                                    <span id="recipient-count" class="badge bg-primary fs-6">
                                        0 জন
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: Notification Content -->
                    <div class="notification-section mb-4">
                        <div class="section-header">
                            <i class="bx bx-message-detail text-info"></i>
                            <h6 class="mb-0">বার্তা / Message Content</h6>
                        </div>

                        <!-- Title -->
                        <div class="mb-3 mt-3">
                            <label class="form-label">
                                শিরোনাম / Title
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg"
                                   id="notification-title"
                                   placeholder="যেমন: System Update, Payment Issue..."
                                   required
                                   maxlength="100">
                            <div class="form-text d-flex justify-content-between">
                                <span>সর্বোচ্চ 100 অক্ষর</span>
                                <span id="title-count">0/100</span>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label class="form-label">
                                বার্তা / Message
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control"
                                      id="notification-message"
                                      rows="4"
                                      placeholder="আপনার বার্তা লিখুন..."
                                      required
                                      maxlength="500"></textarea>
                            <div class="form-text d-flex justify-content-between">
                                <span>সর্বোচ্চ 500 অক্ষর</span>
                                <span id="message-count">0/500</span>
                            </div>
                        </div>
                    </div>

                    <!-- PREVIEW Section -->
                    <div class="notification-section">
                        <div class="section-header">
                            <i class="bx bx-show text-secondary"></i>
                            <h6 class="mb-0">প্রিভিউ / Preview</h6>
                        </div>

                        <div class="preview-box mt-3">
                            <div class="preview-notification">
                                <div class="preview-icon">
                                    <i class="bx bx-bell"></i>
                                </div>
                                <div class="preview-content">
                                    <h6 id="preview-title">Notification Title</h6>
                                    <p id="preview-message">Notification message will appear here...</p>
                                    <small class="text-muted">Just now</small>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> বাতিল / Cancel
                </button>
                <button type="button" class="btn btn-primary btn-lg" onclick="sendNotification()">
                    <i class="bx bx-send"></i> পাঠান / Send Notification
                </button>
                <button type="button" class="btn btn-primary" id="loading-button" style="display: none;" disabled>
                    <i class="fas fa-spinner fa-spin"></i> পাঠানো হচ্ছে...
                </button>
            </div>

        </div>
    </div>
</div>

<!-- CSS Styles -->
<style>
/* Modal Styles */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Section Styles */
.notification-section {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    background: #f8f9fa;
}

.section-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #dee2e6;
}

.section-header i {
    font-size: 24px;
}

/* Priority Cards */
.priority-card {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.priority-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.priority-card input:checked + .priority-label {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.priority-label {
    display: flex;
    align-items: center;
    padding: 15px;
    gap: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0;
}

.priority-icon {
    font-size: 32px;
}

.priority-content {
    flex: 1;
}

.priority-check {
    font-size: 24px;
    opacity: 0;
}

.priority-card input:checked + .priority-label .priority-check {
    opacity: 1;
}

/* Channel Cards */
.channel-card {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.channel-card input:checked + label {
    background: #e8f5e9;
    border-color: #4caf50;
}

.channel-card label {
    display: flex;
    align-items: center;
    padding: 15px;
    gap: 15px;
    cursor: pointer;
    margin: 0;
}

/* Target Buttons */
.target-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
}

.target-buttons label {
    padding: 15px 10px;
    text-align: center;
    cursor: pointer;
}

/* Preview Box */
.preview-box {
    background: white;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    padding: 20px;
}

.preview-notification {
    display: flex;
    gap: 15px;
    align-items: start;
}

.preview-icon {
    width: 40px;
    height: 40px;
    background: #667eea;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.preview-content {
    flex: 1;
}

.preview-content h6 {
    margin: 0 0 5px 0;
    font-weight: 600;
}

.preview-content p {
    margin: 0 0 5px 0;
    color: #6c757d;
}
</style>
```

---

## 7. ব্যাকএন্ড পরিবর্তন / BACKEND CHANGES

### 🔧 **Updated NotificationService.php**

```php
<?php
// app/Services/NotificationService.php

namespace App\Services;

use App\Models\Notification;
use App\Events\NotificationSent;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Enhanced send method with all new parameters
     */
    public function send(
        $userId,
        $type,
        $title,
        $message,
        $data = [],
        $sendEmail = false,
        $buyerId = null,
        $sellerId = null,
        $orderId = null,
        $serviceId = null,
        $priority = 'normal',
        $channels = ['website']
    ) {
        // Validate channels
        if (empty($channels)) {
            $channels = ['website'];
        }

        // Emergency notifications ALWAYS use both channels
        if ($priority === 'emergency') {
            $channels = ['website', 'email'];
            $sendEmail = true;
        }

        // Create notification in database
        $notification = Notification::create([
            'user_id' => $userId,
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
            'order_id' => $orderId,
            'service_id' => $serviceId,
            'type' => $type,
            'priority' => $priority,
            'channels' => json_encode($channels),
            'title' => $title,
            'message' => $message,
            'data' => is_array($data) ? json_encode($data) : $data,
            'sent_by_admin_id' => auth()->check() && auth()->user()->role === 2 ? auth()->id() : null,
        ]);

        // Broadcast via Pusher (if website channel selected)
        if (in_array('website', $channels)) {
            try {
                broadcast(new NotificationSent($notification, $userId));
            } catch (\Exception $e) {
                Log::error('Pusher broadcast failed: ' . $e->getMessage());
            }
        }

        // Send email (if email channel selected)
        if (in_array('email', $channels) || $sendEmail) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->email) {
                try {
                    Mail::to($user->email)->send(new NotificationMail([
                        'title' => $title,
                        'message' => $message,
                        'data' => $data,
                        'priority' => $priority,
                        'user' => $user
                    ]));
                } catch (\Exception $e) {
                    Log::error('Email send failed for user ' . $userId . ': ' . $e->getMessage());
                }
            }
        }

        // Log for audit
        Log::info('Notification sent', [
            'notification_id' => $notification->id,
            'user_id' => $userId,
            'type' => $type,
            'priority' => $priority,
            'channels' => $channels,
        ]);

        return $notification;
    }

    /**
     * Send to multiple users with enhanced parameters
     */
    public function sendToMultipleUsers(
        array $userIds,
        $type,
        $title,
        $message,
        $data = [],
        $sendEmail = false,
        $buyerId = null,
        $sellerId = null,
        $orderId = null,
        $serviceId = null,
        $priority = 'normal',
        $channels = ['website']
    ) {
        foreach ($userIds as $userId) {
            $this->send(
                $userId,
                $type,
                $title,
                $message,
                $data,
                $sendEmail,
                $buyerId,
                $sellerId,
                $orderId,
                $serviceId,
                $priority,
                $channels
            );
        }
    }

    /**
     * Helper method for order-related notifications
     * Automatically sends to buyer, seller, and admin
     */
    public function sendOrderNotification(
        $orderId,
        $type,
        $title,
        $message,
        $priority = 'normal'
    ) {
        $order = \App\Models\BookOrder::with(['user', 'gig.user'])->find($orderId);

        if (!$order) {
            return;
        }

        $buyerId = $order->user_id;
        $sellerId = $order->gig->user_id;
        $serviceId = $order->gig_id;

        // Send to Buyer
        $this->send(
            userId: $buyerId,
            type: $type,
            title: $title,
            message: $message,
            data: ['order_id' => $orderId],
            sendEmail: $priority === 'emergency',
            buyerId: $buyerId,
            sellerId: $sellerId,
            orderId: $orderId,
            serviceId: $serviceId,
            priority: $priority,
            channels: $priority === 'emergency' ? ['website', 'email'] : ['website']
        );

        // Send to Seller
        $this->send(
            userId: $sellerId,
            type: $type,
            title: $title,
            message: $message,
            data: ['order_id' => $orderId],
            sendEmail: $priority === 'emergency',
            buyerId: $buyerId,
            sellerId: $sellerId,
            orderId: $orderId,
            serviceId: $serviceId,
            priority: $priority,
            channels: $priority === 'emergency' ? ['website', 'email'] : ['website']
        );

        // Send to All Admins
        $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
        foreach ($adminIds as $adminId) {
            $this->send(
                userId: $adminId,
                type: $type,
                title: $title . ' [Admin Copy]',
                message: $message,
                data: ['order_id' => $orderId],
                sendEmail: false,
                buyerId: $buyerId,
                sellerId: $sellerId,
                orderId: $orderId,
                serviceId: $serviceId,
                priority: $priority
            );
        }
    }
}
```

---

### 🎛️ **Updated NotificationController.php**

```php
<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Admin: Send notification
     */
    public function notificationSend(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'targetMode' => 'required|in:all,sellers,buyers,specific',
            'user_ids' => 'required_if:targetMode,specific|array',
            'priority' => 'required|in:normal,emergency',
            'channels' => 'required|array|min:1',
            'channels.*' => 'in:website,email',
            'title' => 'required|string|max:100',
            'message' => 'required|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Determine recipient user IDs
        $userIds = [];
        $targetMode = $request->targetMode;

        switch ($targetMode) {
            case 'all':
                $userIds = User::whereIn('role', [0, 1])->pluck('id')->toArray();
                break;
            case 'sellers':
                $userIds = User::where('role', 1)->pluck('id')->toArray();
                break;
            case 'buyers':
                $userIds = User::where('role', 0)->pluck('id')->toArray();
                break;
            case 'specific':
                $userIds = $request->user_ids;
                break;
        }

        // Emergency notifications ALWAYS send via both channels
        $channels = $request->priority === 'emergency'
            ? ['website', 'email']
            : $request->channels;

        // Send notifications
        $this->notificationService->sendToMultipleUsers(
            userIds: $userIds,
            type: 'admin_announcement',
            title: $request->title,
            message: $request->message,
            data: [
                'sent_by_admin' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
                'target_mode' => $targetMode,
            ],
            sendEmail: in_array('email', $channels),
            priority: $request->priority,
            channels: $channels
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification sent to ' . count($userIds) . ' users',
            'recipients' => count($userIds)
        ]);
    }

    /**
     * Admin: Get user count for targeting
     */
    public function getUserCount(Request $request)
    {
        $role = $request->get('role');

        $query = User::query();

        if ($role === 'sellers' || $role === '1') {
            $query->where('role', 1);
        } elseif ($role === 'buyers' || $role === '0') {
            $query->where('role', 0);
        } elseif ($role === 'all') {
            $query->whereIn('role', [0, 1]);
        }

        $count = $query->count();

        return response()->json(['count' => $count]);
    }

    /**
     * AJAX: Search users by email/name
     */
    public function searchUsers(Request $request)
    {
        $search = $request->get('q', '');

        $users = User::where(function($query) use ($search) {
            $query->where('email', 'like', '%' . $search . '%')
                  ->orWhere('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%');
        })
        ->whereIn('role', [0, 1]) // Only buyers and sellers
        ->limit(20)
        ->get(['id', 'first_name', 'last_name', 'email', 'role']);

        // Format for Select2
        $results = $users->map(function($user) {
            $roleName = $user->role == 1 ? 'Seller' : 'Buyer';
            return [
                'id' => $user->id,
                'text' => $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ') - ' . $roleName,
            ];
        });

        return response()->json(['results' => $results]);
    }

    /**
     * Admin: Get all notifications (with enhanced details)
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 2) {
            // Admin: See all notifications
            $query = Notification::with([
                'user:id,first_name,last_name,email',
                'buyer:id,first_name,last_name',
                'seller:id,first_name,last_name',
                'order:id,gig_id',
                'service:id,title'
            ])->orderBy('created_at', 'desc');
        } else {
            // User: See only their own
            $query = Notification::with([
                'buyer:id,first_name,last_name',
                'seller:id,first_name,last_name',
                'order:id,gig_id',
                'service:id,title'
            ])->where('user_id', $user->id)
              ->orderBy('created_at', 'desc');
        }

        // Apply filters
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
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

        // Get users for Send Notification dropdown
        $users = User::whereIn('role', [0, 1])
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name', 'email', 'role']);

        return response()->json([
            'notifications' => $notifications,
            'users' => $users
        ]);
    }

    // ... rest of the existing methods (markAsRead, delete, etc.)
}
```

---

## 8. ইমপ্লিমেন্টেশন পর্যায় / IMPLEMENTATION PHASES

### 📅 **Phase-wise Implementation Plan:**

#### **Phase 1: Database Migration** (1-2 hours / ১-২ ঘণ্টা)
- [ ] Create migration for new columns
- [ ] Run migration on development
- [ ] Test migration rollback
- [ ] Backup production database
- [ ] Run migration on production

#### **Phase 2: Backend Updates** (3-4 hours / ৩-৪ ঘণ্টা)
- [ ] Update NotificationService.php
- [ ] Update NotificationController.php
- [ ] Add new routes
- [ ] Add getUserCount() method
- [ ] Add searchUsers() AJAX endpoint
- [ ] Update Notification model relationships

#### **Phase 3: UI/UX Redesign** (4-5 hours / ৪-৫ ঘণ্টা)
- [ ] Create new modal HTML
- [ ] Add CSS styles
- [ ] Implement JavaScript logic
- [ ] Add Select2 integration
- [ ] Add real-time recipient counter
- [ ] Add live preview
- [ ] Add character counters

#### **Phase 4: Update All Notification Triggers** (6-8 hours / ৬-৮ ঘণ্টা)
- [ ] Update 15+ controller locations
- [ ] Update 11 scheduled commands
- [ ] Add buyer_id, seller_id, order_id, service_id
- [ ] Test each trigger point

#### **Phase 5: Admin Notification List Enhancement** (3-4 hours / ৩-৪ ঘণ্টা)
- [ ] Update notification list view
- [ ] Show both buyer and seller names
- [ ] Add service information
- [ ] Add "View Order" button
- [ ] Add priority badge
- [ ] Add channel icons

#### **Phase 6: Testing** (4-5 hours / ৪-৫ ঘণ্টা)
- [ ] Test all targeting modes
- [ ] Test emergency notifications
- [ ] Test email delivery
- [ ] Test recipient counts
- [ ] Test notification display
- [ ] Cross-browser testing
- [ ] Mobile responsiveness

#### **Phase 7: Documentation & Deployment** (2-3 hours / ২-৩ ঘণ্টা)
- [ ] Update README
- [ ] Create admin user guide
- [ ] Deploy to staging
- [ ] Client review
- [ ] Deploy to production

---

## 9. টেস্টিং চেকলিস্ট / TESTING CHECKLIST

### ✅ **Functional Testing / ফাংশনাল টেস্টিং:**

#### **Send Notification Modal:**
- [ ] Modal opens correctly
- [ ] Priority selection works (Normal/Emergency)
- [ ] Emergency auto-checks both channels
- [ ] Channel selection works
- [ ] At least one channel validation
- [ ] Target mode selection works
- [ ] Specific users dropdown appears/disappears
- [ ] User search (AJAX) works
- [ ] Email search works
- [ ] Name search works
- [ ] Multi-select works
- [ ] Recipient counter updates correctly
- [ ] Title character counter works
- [ ] Message character counter works
- [ ] Live preview updates
- [ ] Form validation works
- [ ] Submit button works
- [ ] Loading state works
- [ ] Success message shows
- [ ] Modal closes after send

#### **Recipient Counting:**
- [ ] All Users count is correct
- [ ] Sellers Only count is correct
- [ ] Buyers Only count is correct
- [ ] Specific Users count updates

#### **Notification Delivery:**
- [ ] Website notification saves to database
- [ ] Email sends when selected
- [ ] Both channels work together
- [ ] Emergency forces both channels
- [ ] Pusher event triggers
- [ ] Notification appears in bell icon
- [ ] Unread count updates

#### **Notification List Display:**
- [ ] Shows buyer name
- [ ] Shows seller name
- [ ] Shows both names with separator
- [ ] Shows service name
- [ ] Shows order ID
- [ ] Shows priority badge (emergency)
- [ ] "View Order" button works
- [ ] Link goes to correct order page

#### **All Notification Triggers:**
- [ ] User registration → notification sent
- [ ] Password changed → notification sent
- [ ] Order placed → all parties notified
- [ ] Order cancelled → all parties notified
- [ ] Custom offer → notifications work
- [ ] Message sent → notification works
- [ ] Class reminder → notification works
- [ ] Review reply → notification works
- [ ] Each trigger includes buyer_id, seller_id, order_id, service_id

---

### 🔒 **Security Testing / সিকিউরিটি টেস্টিং:**
- [ ] Admin authorization check works
- [ ] Non-admin cannot send notifications
- [ ] SQL injection prevention
- [ ] XSS prevention in title/message
- [ ] CSRF token validation
- [ ] Rate limiting works (max 10/hour)
- [ ] Input validation works
- [ ] Max length enforced

---

### 📱 **UI/UX Testing:**
- [ ] Responsive on mobile
- [ ] Responsive on tablet
- [ ] Works on Chrome
- [ ] Works on Firefox
- [ ] Works on Safari
- [ ] Works on Edge
- [ ] All icons display correctly
- [ ] All colors match design
- [ ] All fonts readable
- [ ] No console errors
- [ ] No broken images

---

### ⚡ **Performance Testing:**
- [ ] Modal loads fast
- [ ] AJAX search is fast (<500ms)
- [ ] Sending to 100+ users completes
- [ ] Sending to 1000+ users completes
- [ ] Database queries optimized
- [ ] No N+1 queries
- [ ] Pagination works smoothly

---

## 📝 SUMMARY / সারসংক্ষেপ

### **What Will Be Fixed / কি কি ঠিক হবে:**

1. ✅ **Clear Notification Types** → ওয়েবসাইট ও ইমেইল দুটোই স্পষ্ট
2. ✅ **Smart User Targeting** → ইমেইল দিয়ে সার্চ + Sellers/Buyers only option
3. ✅ **Emergency Notifications** → জরুরি নোটিফিকেশন সুবিধা
4. ✅ **Both Names Display** → Admin list এ buyer ও seller দুইজনের নাম
5. ✅ **Professional UI** → Modern, clean, intuitive modal design
6. ✅ **Complete Documentation** → সব notification trigger mapped
7. ✅ **Better Tracking** → Order ID, Service ID, Priority level
8. ✅ **Audit Trail** → Log all admin actions

### **Total Work Estimate / মোট সময়:**
- **Development**: 25-30 hours
- **Testing**: 5-6 hours
- **Total**: ~35 hours (4-5 working days)

---

**END OF COMPREHENSIVE PLAN / পরিকল্পনার সমাপ্তি**

---

**Contact**: For any clarifications or questions about this plan, please discuss before implementation.

**Version**: 1.0
**Status**: Ready for Approval
**Next Step**: Await client approval, then begin Phase 1 (Database Migration)
