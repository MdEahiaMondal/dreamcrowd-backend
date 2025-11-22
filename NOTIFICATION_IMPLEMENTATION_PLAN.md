# NOTIFICATION SYSTEM - IMPLEMENTATION PLAN
## DreamCrowd Complete Notification Coverage

**Created:** 2025-11-22
**Status:** Planning Phase - Awaiting Approval
**Objective:** Ensure ALL order-related actions notify Buyer, Seller, AND Admin as per client requirements

---

## CLIENT REQUIREMENT SUMMARY

### Core Principle:
**Any action taken by Buyer or Seller should notify ALL THREE parties:**

| Party | Notification Methods |
|-------|---------------------|
| **Buyer** | Email + Website Notification |
| **Seller** | Email + Website Notification |
| **Admin** | Website Notification (No Email) |

### Example:
- **Buyer cancels class** →
  - Buyer: "You have cancelled the class" (Email + Web)
  - Seller: "Buyer has cancelled the class" (Email + Web)
  - Admin: "Buyer X cancelled class from Seller Y" (Web only)

---

## CURRENT SYSTEM STATUS

### ✅ Already Complete (8 Actions):
1. ✅ **Order Placement** - All parties notified correctly
2. ✅ **Order Auto-Approval** - All parties notified correctly
3. ✅ **Order Cancellation (Buyer/Seller)** - All parties notified correctly
4. ✅ **Order Auto-Cancellation** - All parties notified correctly
5. ✅ **Order Auto-Completion** - All parties notified correctly
6. ✅ **Dispute Filing (Buyer/Seller)** - All parties notified correctly
7. ✅ **Dispute Auto-Resolution** - All parties notified correctly
8. ✅ **Pending Order Reminders** - Both parties notified (Admin not involved)

### ❌ Needs Implementation (9 Actions):
1. ❌ **Order Approval (Manual)** - Admin notification missing
2. ❌ **Order Rejection** - Admin notification missing
3. ❌ **Order Manual Delivery** - Seller + Admin notifications missing, Buyer email missing
4. ❌ **Order Auto-Delivery** - Admin notification missing, Seller email missing
5. ❌ **Reschedule Request** - Admin notification missing
6. ❌ **Reschedule Acceptance** - Admin notification missing, Email notifications missing for both parties
7. ❌ **Reschedule Rejection** - Admin notification missing
8. ❌ **Dispute Manual Resolution** - Admin self-confirmation missing (optional)
9. ❌ **Trial Booking** - Admin notification missing (optional - low priority)

---

## DETAILED IMPLEMENTATION PLAN

### 1. ORDER APPROVAL (Manual) - PRIORITY: HIGH

**File:** `app/Http/Controllers/OrderManagementController.php`
**Method:** `ActiveOrder()` (around line 1214)

**Current Implementation:**
```php
// Only notifies Buyer
NotificationService::send(
    userId: $bookOrder->user_id,
    type: 'order_accepted',
    title: 'Order Accepted!',
    message: "Your order #{$bookOrder->id} for \"{$bookOrder->gigName}\" has been accepted...",
    sendEmail: true,
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**Required Changes:**

**Add after existing buyer notification:**
```php
// Notify Admin
NotificationService::send(
    userId: $this->getAdminUserIds(), // Helper method to get all admin IDs
    type: 'order_approved_admin',
    title: 'Order Approved by Seller',
    message: "Seller \"{$teacher->first_name} {$teacher->last_name}\" approved order #{$bookOrder->id} for \"{$bookOrder->gigName}\" from buyer \"{$buyer->first_name} {$buyer->last_name}\"",
    sendEmail: false, // Admin gets web notification only
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'seller_name' => $teacher->first_name . ' ' . $teacher->last_name,
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'gig_name' => $bookOrder->gigName,
        'amount' => $bookOrder->buyer_total,
    ]
);
```

**Helper Method to Add (in OrderManagementController):**
```php
/**
 * Get all admin user IDs
 * @return array
 */
private function getAdminUserIds(): array
{
    return \App\Models\User::where('role', 2)->pluck('id')->toArray();
}
```

---

### 2. ORDER REJECTION - PRIORITY: HIGH

**File:** `app/Http/Controllers/OrderManagementController.php`
**Method:** `RejectOrder()` (around line 1312)

**Current Implementation:**
```php
// Only notifies Buyer
NotificationService::send(
    userId: $bookOrder->user_id,
    type: 'order_rejected',
    title: 'Order Request Rejected',
    message: "Your order request #{$bookOrder->id} for \"{$bookOrder->gigName}\" has been rejected...",
    sendEmail: true,
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**Required Changes:**

**Add after existing buyer notification:**
```php
// Notify Admin
NotificationService::send(
    userId: $this->getAdminUserIds(),
    type: 'order_rejected_admin',
    title: 'Order Rejected by Seller',
    message: "Seller \"{$teacher->first_name} {$teacher->last_name}\" rejected order #{$bookOrder->id} for \"{$bookOrder->gigName}\" from buyer \"{$buyer->first_name} {$buyer->last_name}\". Refund processed: £{$refundAmount}",
    sendEmail: false,
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'seller_name' => $teacher->first_name . ' ' . $teacher->last_name,
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'gig_name' => $bookOrder->gigName,
        'refund_amount' => $refundAmount,
    ]
);
```

---

### 3. ORDER MANUAL DELIVERY - PRIORITY: HIGH

**File:** `app/Http/Controllers/OrderManagementController.php`
**Method:** `DeliverOrder()` (around line 1638)

**Current Implementation:**
```php
// Only notifies Buyer (web only)
NotificationService::send(
    userId: $bookOrder->user_id,
    type: 'order_delivered',
    title: 'Order Delivered',
    message: "Your order #{$bookOrder->id} for \"{$bookOrder->gigName}\" has been delivered...",
    sendEmail: false, // ⚠️ Should be true
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**Required Changes:**

**1. Update existing buyer notification (change sendEmail to true):**
```php
// Update Buyer notification to include email
NotificationService::send(
    userId: $bookOrder->user_id,
    type: 'order_delivered',
    title: 'Order Delivered',
    message: "Your order #{$bookOrder->id} for \"{$bookOrder->gigName}\" has been marked as delivered by the seller. You have 48 hours to raise any concerns or request a refund.",
    sendEmail: true, // ✅ Changed from false
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**2. Add Seller notification:**
```php
// Notify Seller
NotificationService::send(
    userId: $teacher->id,
    type: 'order_delivered_seller',
    title: 'Order Marked as Delivered',
    message: "You have successfully marked order #{$bookOrder->id} for \"{$bookOrder->gigName}\" as delivered. Buyer has 48 hours to review. Payment will be released after 48 hours if no disputes are raised.",
    sendEmail: true,
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**3. Add Admin notification:**
```php
// Notify Admin
NotificationService::send(
    userId: $this->getAdminUserIds(),
    type: 'order_delivered_admin',
    title: 'Order Delivered (Manual)',
    message: "Seller \"{$teacher->first_name} {$teacher->last_name}\" marked order #{$bookOrder->id} for \"{$bookOrder->gigName}\" as delivered. Buyer: \"{$buyer->first_name} {$buyer->last_name}\". 48-hour dispute window active.",
    sendEmail: false,
    actorUserId: $teacher->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'seller_name' => $teacher->first_name . ' ' . $teacher->last_name,
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'gig_name' => $bookOrder->gigName,
        'delivery_method' => 'manual',
    ]
);
```

---

### 4. ORDER AUTO-DELIVERY - PRIORITY: HIGH

**File:** `app/Console/Commands/AutoMarkDelivered.php`
**Method:** `handle()` (around lines 280-331)

**Current Implementation:**
```php
// Notifies Buyer with email
NotificationService::send(
    userId: $order->user_id,
    type: 'order_delivered',
    title: 'Order Delivered',
    message: "Your order #{$order->id} for \"{$order->gigName}\" has been delivered...",
    sendEmail: true,
    actorUserId: $order->teacher_id,
    targetUserId: $order->user_id,
    orderId: $order->id,
    serviceId: $order->gig_id
);

// Notifies Seller (web only)
NotificationService::send(
    userId: $order->teacher_id,
    type: 'order_delivered_seller',
    title: 'Order Delivered',
    message: "Order #{$order->id} for \"{$order->gigName}\" has been automatically marked as delivered...",
    sendEmail: false, // ⚠️ Should be true
    actorUserId: $order->teacher_id,
    targetUserId: $order->user_id,
    orderId: $order->id,
    serviceId: $order->gig_id
);
```

**Required Changes:**

**1. Update Seller notification to include email:**
```php
// Update Seller notification
NotificationService::send(
    userId: $order->teacher_id,
    type: 'order_delivered_seller',
    title: 'Order Auto-Delivered',
    message: "Order #{$order->id} for \"{$order->gigName}\" has been automatically marked as delivered. The buyer has 48 hours to review. Payment will be released after 48 hours if no disputes are raised.",
    sendEmail: true, // ✅ Changed from false
    actorUserId: $order->teacher_id,
    targetUserId: $order->user_id,
    orderId: $order->id,
    serviceId: $order->gig_id
);
```

**2. Add Admin notification (after seller notification):**
```php
// Notify Admin
$seller = User::find($order->teacher_id);
$buyer = User::find($order->user_id);

NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'order_delivered_admin',
    title: 'Order Auto-Delivered',
    message: "Order #{$order->id} for \"{$order->gigName}\" auto-delivered. Seller: \"{$seller->first_name} {$seller->last_name}\", Buyer: \"{$buyer->first_name} {$buyer->last_name}\". 48-hour dispute window active.",
    sendEmail: false,
    actorUserId: $order->teacher_id,
    targetUserId: $order->user_id,
    orderId: $order->id,
    serviceId: $order->gig_id,
    data: [
        'order_id' => $order->id,
        'seller_name' => $seller->first_name . ' ' . $seller->last_name,
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'gig_name' => $order->gigName,
        'delivery_method' => 'automatic',
        'service_type' => $order->service_type,
    ]
);
```

---

### 5. RESCHEDULE REQUEST - PRIORITY: HIGH

**File:** `app/Http/Controllers/OrderManagementController.php`
**Methods:** `UserResheduleClass()` (line ~2344) and `TeacherResheduleClass()` (line ~2477)

**Current Implementation (UserResheduleClass):**
```php
// Notifies buyer (requester)
NotificationService::send(
    userId: $bookOrder->user_id,
    type: 'reschedule_requested',
    title: 'Reschedule Request Submitted',
    message: "Your reschedule request for order #{$bookOrder->id}...",
    sendEmail: false, // Web only
    actorUserId: $bookOrder->user_id,
    targetUserId: $bookOrder->teacher_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);

// Notifies seller
NotificationService::send(
    userId: $bookOrder->teacher_id,
    type: 'reschedule_request_received',
    title: 'Reschedule Request Received',
    message: "You have received a reschedule request from {$buyer->first_name}...",
    sendEmail: true,
    actorUserId: $bookOrder->user_id,
    targetUserId: $bookOrder->teacher_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**Required Changes:**

**Add after existing notifications in BOTH methods (UserResheduleClass AND TeacherResheduleClass):**

**For UserResheduleClass (Buyer requests reschedule):**
```php
// Notify Admin
NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'reschedule_requested_admin',
    title: 'Reschedule Request - Buyer',
    message: "Buyer \"{$buyer->first_name} {$buyer->last_name}\" requested reschedule for order #{$bookOrder->id} (\"{$bookOrder->gigName}\"). Seller: \"{$teacher->first_name} {$teacher->last_name}\". Awaiting seller approval.",
    sendEmail: false,
    actorUserId: $bookOrder->user_id,
    targetUserId: $bookOrder->teacher_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'reschedule_id' => $reschedule->id,
        'requester' => 'buyer',
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'seller_name' => $teacher->first_name . ' ' . $teacher->last_name,
        'gig_name' => $bookOrder->gigName,
        'old_date' => $classDate->class_date,
        'new_date' => $request->class_date,
    ]
);
```

**For TeacherResheduleClass (Seller requests reschedule):**
```php
// Notify Admin
NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'reschedule_requested_admin',
    title: 'Reschedule Request - Seller',
    message: "Seller \"{$teacher->first_name} {$teacher->last_name}\" requested reschedule for order #{$bookOrder->id} (\"{$bookOrder->gigName}\"). Buyer: \"{$buyer->first_name} {$buyer->last_name}\". Awaiting buyer approval.",
    sendEmail: false,
    actorUserId: $bookOrder->teacher_id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'reschedule_id' => $reschedule->id,
        'requester' => 'seller',
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'seller_name' => $teacher->first_name . ' ' . $teacher->last_name,
        'gig_name' => $bookOrder->gigName,
        'old_date' => $classDate->class_date,
        'new_date' => $request->class_date,
    ]
);
```

---

### 6. RESCHEDULE ACCEPTANCE - PRIORITY: HIGH

**File:** `app/Http/Controllers/OrderManagementController.php`
**Method:** `AcceptReschedule()` (around line 2554)

**Current Implementation:**
```php
// Only notifies requester (web only)
NotificationService::send(
    userId: $reschedule->requested_by,
    type: 'reschedule_accepted',
    title: 'Reschedule Request Accepted',
    message: "Your reschedule request for order #{$bookOrder->id} has been accepted...",
    sendEmail: false, // ⚠️ Should be true
    actorUserId: $currentUserId,
    targetUserId: $reschedule->requested_by,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**Required Changes:**

**1. Update existing notification to include email:**
```php
// Update requester notification
NotificationService::send(
    userId: $reschedule->requested_by,
    type: 'reschedule_accepted',
    title: 'Reschedule Request Accepted',
    message: "Your reschedule request for order #{$bookOrder->id} (\"{$bookOrder->gigName}\") has been accepted. New class date: {$newDate}",
    sendEmail: true, // ✅ Changed from false
    actorUserId: $currentUserId,
    targetUserId: $reschedule->requested_by,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**2. Add notification to approver:**
```php
// Notify approver (the person who accepted the request)
$approverName = ($currentUserId == $bookOrder->user_id) ? 'buyer' : 'seller';
$requesterName = ($reschedule->requested_by == $bookOrder->user_id) ? 'buyer' : 'seller';

NotificationService::send(
    userId: $currentUserId,
    type: 'reschedule_accepted_confirmation',
    title: 'Reschedule Request Approved',
    message: "You have approved the reschedule request for order #{$bookOrder->id} (\"{$bookOrder->gigName}\"). New class date: {$newDate}",
    sendEmail: true,
    actorUserId: $currentUserId,
    targetUserId: $reschedule->requested_by,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**3. Add Admin notification:**
```php
// Notify Admin
$seller = User::find($bookOrder->teacher_id);
$buyer = User::find($bookOrder->user_id);

NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'reschedule_accepted_admin',
    title: 'Reschedule Request Accepted',
    message: "Reschedule accepted for order #{$bookOrder->id} (\"{$bookOrder->gigName}\"). Requested by {$requesterName}, approved by {$approverName}. Seller: \"{$seller->first_name} {$seller->last_name}\", Buyer: \"{$buyer->first_name} {$buyer->last_name}\". New date: {$newDate}",
    sendEmail: false,
    actorUserId: $currentUserId,
    targetUserId: $reschedule->requested_by,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'reschedule_id' => $reschedule->id,
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'seller_name' => $seller->first_name . ' ' . $seller->last_name,
        'gig_name' => $bookOrder->gigName,
        'old_date' => $reschedule->old_class_date,
        'new_date' => $newDate,
        'requester' => $requesterName,
        'approver' => $approverName,
    ]
);
```

---

### 7. RESCHEDULE REJECTION - PRIORITY: HIGH

**File:** `app/Http/Controllers/OrderManagementController.php`
**Method:** `RejectReschedule()` (around line 2630)

**Current Implementation:**
```php
// Only notifies requester
NotificationService::send(
    userId: $reschedule->requested_by,
    type: 'reschedule_rejected',
    title: 'Reschedule Request Rejected',
    message: "Your reschedule request for order #{$bookOrder->id} has been rejected...",
    sendEmail: true,
    actorUserId: $currentUserId,
    targetUserId: $reschedule->requested_by,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id
);
```

**Required Changes:**

**Add after existing notification:**
```php
// Notify Admin
$seller = User::find($bookOrder->teacher_id);
$buyer = User::find($bookOrder->user_id);
$rejectorName = ($currentUserId == $bookOrder->user_id) ? 'buyer' : 'seller';
$requesterName = ($reschedule->requested_by == $bookOrder->user_id) ? 'buyer' : 'seller';

NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'reschedule_rejected_admin',
    title: 'Reschedule Request Rejected',
    message: "Reschedule rejected for order #{$bookOrder->id} (\"{$bookOrder->gigName}\"). Requested by {$requesterName}, rejected by {$rejectorName}. Seller: \"{$seller->first_name} {$seller->last_name}\", Buyer: \"{$buyer->first_name} {$buyer->last_name}\".",
    sendEmail: false,
    actorUserId: $currentUserId,
    targetUserId: $reschedule->requested_by,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'reschedule_id' => $reschedule->id,
        'buyer_name' => $buyer->first_name . ' ' . $buyer->last_name,
        'seller_name' => $seller->first_name . ' ' . $seller->last_name,
        'gig_name' => $bookOrder->gigName,
        'requested_date' => $reschedule->new_class_date,
        'requester' => $requesterName,
        'rejector' => $rejectorName,
    ]
);
```

---

### 8. DISPUTE MANUAL RESOLUTION - PRIORITY: MEDIUM (Optional)

**File:** `app/Http/Controllers/OrderManagementController.php`
**Method:** `AcceptDisputedOrder()` (around line 1977)

**Current Implementation:**
```php
// Notifies Buyer and Seller, but not Admin
```

**Required Changes:**

**Add after existing notifications:**
```php
// Notify Admin (confirmation of their own action)
$adminUser = auth()->user();

NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'dispute_resolved_confirmation',
    title: 'Dispute Resolution Confirmed',
    message: "Dispute for order #{$bookOrder->id} has been resolved by admin \"{$adminUser->first_name} {$adminUser->last_name}\". {$decisionMessage}",
    sendEmail: false,
    actorUserId: $adminUser->id,
    targetUserId: $bookOrder->user_id,
    orderId: $bookOrder->id,
    serviceId: $bookOrder->gig_id,
    data: [
        'order_id' => $bookOrder->id,
        'admin_name' => $adminUser->first_name . ' ' . $adminUser->last_name,
        'decision' => $decisionMessage,
        'refund_amount' => $refundAmount ?? 0,
    ]
);
```

---

### 9. TRIAL BOOKING - PRIORITY: LOW (Optional)

**File:** `app/Http/Controllers/BookingController.php`
**Method:** `PlaceOrder()` (around line 850)

**Current Implementation:**
```php
// Only notifies Buyer and Seller (web only)
```

**Required Changes:**

**Add after existing trial booking notifications:**
```php
// Notify Admin
NotificationService::send(
    userId: User::where('role', 2)->pluck('id')->toArray(),
    type: 'trial_booking_admin',
    title: 'Trial Class Booked',
    message: "Trial class booked for \"{$teacherGig->service_name}\" by buyer \"{$user->first_name} {$user->last_name}\". Seller: \"{$teacher->first_name} {$teacher->last_name}\".",
    sendEmail: false,
    actorUserId: $user->id,
    targetUserId: $teacher->id,
    orderId: $bookOrder->id,
    serviceId: $teacherGig->id,
    data: [
        'order_id' => $bookOrder->id,
        'buyer_name' => $user->first_name . ' ' . $user->last_name,
        'seller_name' => $teacher->first_name . ' ' . $teacher->last_name,
        'gig_name' => $teacherGig->service_name,
        'is_trial' => true,
    ]
);
```

---

## CODE CHANGES SUMMARY

### Files to Modify:

| File | Methods to Update | Changes Required |
|------|------------------|------------------|
| `OrderManagementController.php` | `ActiveOrder()` | Add Admin notification |
| | `RejectOrder()` | Add Admin notification |
| | `DeliverOrder()` | Add Seller + Admin notifications, enable Buyer email |
| | `UserResheduleClass()` | Add Admin notification |
| | `TeacherResheduleClass()` | Add Admin notification |
| | `AcceptReschedule()` | Add Approver + Admin notifications, enable Requester email |
| | `RejectReschedule()` | Add Admin notification |
| | `AcceptDisputedOrder()` (optional) | Add Admin self-confirmation |
| `AutoMarkDelivered.php` | `handle()` | Add Admin notification, enable Seller email |
| `BookingController.php` (optional) | `PlaceOrder()` | Add Admin notification for trial bookings |

### Helper Method to Add:

**Location:** `app/Http/Controllers/OrderManagementController.php`
**Add at the end of the class:**

```php
/**
 * Get all admin user IDs
 *
 * @return array
 */
private function getAdminUserIds(): array
{
    return  \App\Models\User::where('role', 2)->pluck('id')->toArray();
}
```

---

## NOTIFICATION MESSAGE TEMPLATES

### Admin Notification Messages (Website Only):

| Action | Title | Message Template |
|--------|-------|-----------------|
| Order Approved | Order Approved by Seller | Seller "{seller_name}" approved order #{order_id} for "{gig_name}" from buyer "{buyer_name}" |
| Order Rejected | Order Rejected by Seller | Seller "{seller_name}" rejected order #{order_id} for "{gig_name}" from buyer "{buyer_name}". Refund processed: £{amount} |
| Manual Delivery | Order Delivered (Manual) | Seller "{seller_name}" marked order #{order_id} for "{gig_name}" as delivered. Buyer: "{buyer_name}". 48-hour dispute window active. |
| Auto Delivery | Order Auto-Delivered | Order #{order_id} for "{gig_name}" auto-delivered. Seller: "{seller_name}", Buyer: "{buyer_name}". 48-hour dispute window active. |
| Reschedule Request (Buyer) | Reschedule Request - Buyer | Buyer "{buyer_name}" requested reschedule for order #{order_id} ("{gig_name}"). Seller: "{seller_name}". Awaiting seller approval. |
| Reschedule Request (Seller) | Reschedule Request - Seller | Seller "{seller_name}" requested reschedule for order #{order_id} ("{gig_name}"). Buyer: "{buyer_name}". Awaiting buyer approval. |
| Reschedule Accepted | Reschedule Request Accepted | Reschedule accepted for order #{order_id} ("{gig_name}"). Requested by {requester}, approved by {approver}. Seller: "{seller_name}", Buyer: "{buyer_name}". New date: {new_date} |
| Reschedule Rejected | Reschedule Request Rejected | Reschedule rejected for order #{order_id} ("{gig_name}"). Requested by {requester}, rejected by {rejector}. Seller: "{seller_name}", Buyer: "{buyer_name}". |
| Trial Booking | Trial Class Booked | Trial class booked for "{gig_name}" by buyer "{buyer_name}". Seller: "{seller_name}". |

### Email Updates Required:

| Notification | Current | Required |
|-------------|---------|----------|
| Manual Delivery (Buyer) | Web only | ✅ Add Email |
| Manual Delivery (Seller) | ❌ Missing | ✅ Add Email + Web |
| Auto Delivery (Seller) | Web only | ✅ Add Email |
| Reschedule Acceptance (Both) | Web only | ✅ Add Email |

---

## DATABASE CHANGES

### No migration required!
The existing `notifications` table already has all necessary columns:
- `user_id`, `actor_user_id`, `target_user_id`
- `order_id`, `service_id`
- `type`, `title`, `message`
- `sent_email`, `is_read`, `data`
- `is_emergency`

All new notification types can use existing schema.

---

## TESTING CHECKLIST

### Manual Testing Steps:

**Test Environment Setup:**
- [ ] Create test accounts: Admin, Seller, Buyer
- [ ] Create test service/gig
- [ ] Enable email logging (`.env`: `MAIL_MAILER=log`)
- [ ] Clear notification tables

**1. Order Approval:**
- [ ] Buyer places order
- [ ] Seller approves order
- [ ] Verify: Buyer gets email + web notification
- [ ] Verify: Admin gets web notification (no email)
- [ ] Check notification content accuracy

**2. Order Rejection:**
- [ ] Buyer places order
- [ ] Seller rejects order
- [ ] Verify: Buyer gets email + web notification
- [ ] Verify: Admin gets web notification (no email)
- [ ] Check refund details in notifications

**3. Manual Delivery:**
- [ ] Seller marks order as delivered
- [ ] Verify: Buyer gets email + web notification
- [ ] Verify: Seller gets email + web notification (confirmation)
- [ ] Verify: Admin gets web notification (no email)
- [ ] Check 48-hour dispute message

**4. Auto Delivery:**
- [ ] Create order with class dates in past
- [ ] Run: `php artisan orders:auto-deliver`
- [ ] Verify: Buyer gets email + web notification
- [ ] Verify: Seller gets email + web notification
- [ ] Verify: Admin gets web notification (no email)

**5. Reschedule Request (Buyer):**
- [ ] Buyer requests reschedule
- [ ] Verify: Buyer gets web confirmation
- [ ] Verify: Seller gets email + web notification
- [ ] Verify: Admin gets web notification (no email)

**6. Reschedule Request (Seller):**
- [ ] Seller requests reschedule
- [ ] Verify: Seller gets web confirmation
- [ ] Verify: Buyer gets email + web notification
- [ ] Verify: Admin gets web notification (no email)

**7. Reschedule Acceptance:**
- [ ] Complete reschedule request
- [ ] Approver accepts
- [ ] Verify: Requester gets email + web notification
- [ ] Verify: Approver gets email + web notification (confirmation)
- [ ] Verify: Admin gets web notification (no email)

**8. Reschedule Rejection:**
- [ ] Complete reschedule request
- [ ] Approver rejects
- [ ] Verify: Requester gets email + web notification
- [ ] Verify: Admin gets web notification (no email)

**9. Trial Booking (if implemented):**
- [ ] Buyer books trial class
- [ ] Verify: Buyer gets web notification
- [ ] Verify: Seller gets web notification
- [ ] Verify: Admin gets web notification (no email)

**10. Edge Cases:**
- [ ] Test with multiple admins (all should receive notifications)
- [ ] Test notification real-time broadcasting
- [ ] Test email queue processing
- [ ] Test notification data JSON structure
- [ ] Test unread count updates

---

## IMPLEMENTATION PHASES

### Phase 1: Critical Order Actions (Week 1)
**Priority: HIGH**
1. Order Approval - Add Admin notification
2. Order Rejection - Add Admin notification
3. Manual Delivery - Add Seller + Admin notifications, enable Buyer email
4. Auto Delivery - Add Admin notification, enable Seller email

**Testing:** Complete all order lifecycle tests

### Phase 2: Reschedule Workflow (Week 2)
**Priority: HIGH**
5. Reschedule Request - Add Admin notifications (both methods)
6. Reschedule Acceptance - Add Approver + Admin notifications, enable emails
7. Reschedule Rejection - Add Admin notification

**Testing:** Complete all reschedule tests

### Phase 3: Optional Enhancements (Week 3)
**Priority: LOW**
8. Dispute Manual Resolution - Add Admin self-confirmation
9. Trial Booking - Add Admin notification

**Testing:** Complete optional feature tests

### Phase 4: Final Review & Documentation
**Priority: MEDIUM**
- [ ] Code review
- [ ] Update this document with implementation notes
- [ ] Create user-facing documentation
- [ ] Performance testing with high notification volume
- [ ] Production deployment plan

---

## ROLLBACK PLAN

If issues occur after deployment:

1. **Immediate Rollback:**
   ```bash
   git revert <commit-hash>
   php artisan cache:clear
   php artisan queue:restart
   ```

2. **Database Cleanup (if needed):**
   ```sql
   -- Remove new notification types if causing issues
   DELETE FROM notifications WHERE type IN (
       'order_approved_admin',
       'order_rejected_admin',
       'order_delivered_admin',
       'order_delivered_seller',
       'reschedule_requested_admin',
       'reschedule_accepted_admin',
       'reschedule_accepted_confirmation',
       'reschedule_rejected_admin',
       'dispute_resolved_confirmation',
       'trial_booking_admin'
   );
   ```

3. **Notification Service Monitoring:**
   - Check `storage/logs/laravel.log` for errors
   - Monitor email queue for failures
   - Check broadcast channel errors

---

## PERFORMANCE CONSIDERATIONS

### Current Impact:
- Each action currently sends 1-2 notifications
- With changes: Each action will send 2-4 notifications (adding Admin)

### Optimization Recommendations:

1. **Batch Admin Notifications:**
   ```php
   // Instead of real-time, batch admin notifications every 5 minutes
   // Add to scheduler in app/Console/Kernel.php
   $schedule->command('notifications:batch-send-admin')->everyFiveMinutes();
   ```

2. **Queue All Notifications:**
   - Already implemented via `SendNotificationEmailJob`
   - Ensure queue worker is running: `php artisan queue:work`

3. **Database Indexing:**
   ```sql
   -- Add index for admin notification queries (already exists in migration)
   CREATE INDEX idx_user_type ON users(user_type);
   CREATE INDEX idx_notifications_user_read ON notifications(user_id, is_read);
   ```

4. **Broadcast Optimization:**
   - Consider Redis for better broadcast performance
   - Implement notification aggregation for admins

---

## MONITORING & ALERTS

### Metrics to Track:

1. **Notification Delivery:**
   - Success rate of notifications sent
   - Email delivery rate (check bounce/spam)
   - Real-time broadcast success rate

2. **Performance:**
   - Notification send time (should be < 100ms)
   - Queue processing time
   - Database query performance

3. **User Engagement:**
   - Notification read rate
   - Time to read notifications
   - User preferences (if notification settings added later)

### Alert Conditions:

- [ ] Email send failure rate > 5%
- [ ] Notification queue backlog > 1000
- [ ] Broadcast failures > 10%
- [ ] Admin notification query time > 500ms

---

## FUTURE ENHANCEMENTS (Post-Implementation)

1. **Notification Preferences:**
   - Allow users to customize which notifications they receive
   - Email frequency preferences (instant, daily digest, weekly)

2. **Admin Notification Dashboard:**
   - Dedicated admin panel for high-priority notifications
   - Filters by order status, type, date range
   - Analytics on notification patterns

3. **Notification Templates:**
   - Move notification messages to database
   - Allow admin to customize notification text
   - Multi-language support

4. **Smart Notifications:**
   - Group related notifications (e.g., multiple reschedules)
   - Priority scoring for important notifications
   - Auto-mark notifications as read based on user actions

5. **Mobile Push Notifications:**
   - Integration with Firebase Cloud Messaging
   - Native app notification support

---

## APPROVAL CHECKLIST

Before proceeding with implementation, confirm:

- [ ] **Client has reviewed this plan**
- [ ] **All notification messages are approved**
- [ ] **Admin email policy confirmed** (web only, no emails)
- [ ] **Testing timeline agreed**
- [ ] **Deployment date scheduled**
- [ ] **Rollback plan understood**
- [ ] **Performance expectations set**
- [ ] **Budget for queue workers confirmed** (if scaling needed)

---

## NOTES & ASSUMPTIONS

1. **Admin User Identification:**
   - Assumes `users.role = ` identifies admin accounts
   - If different, update `getAdminUserIds()` helper method

2. **Notification Types:**
   - New notification types are strings, not enums
   - No database migration required for new types

3. **Email Policy:**
   - Admin receives ZERO emails (client requirement)
   - All admin notifications are website/dashboard only
   - Exception: Disputes currently send emails to admin (keeping this)

4. **Real-time Broadcasting:**
   - Assumes Laravel Echo + Pusher already configured
   - If not configured, real-time updates won't work (but emails and database notifications will)

5. **Email Queue:**
   - Assumes queue worker is running in production
   - If not, emails will be sent synchronously (slower)

---

## CONTACT & SUPPORT

**Implementation Lead:** [To be assigned]
**Review Date:** [To be scheduled after client approval]
**Target Completion:** [3 weeks from approval]

---

**Document Version:** 1.0
**Last Updated:** 2025-11-22
**Status:** AWAITING CLIENT APPROVAL

---

## APPENDIX A: Quick Reference - Admin Notifications

All admin notifications use:
- **Email:** `false` (no emails)
- **Type suffix:** `_admin`
- **User ID:** `\App\Models\User::where('role', 2)->pluck('id')->toArray();
`

Example:
```php
NotificationService::send(
    userId: \App\Models\User::where('role', 2)->pluck('id')->toArray();
,
    type: 'action_name_admin',
    title: 'Action Title',
    message: 'Detailed message with buyer/seller names...',
    sendEmail: false, // Always false for admin
    actorUserId: $actorId,
    targetUserId: $targetId,
    orderId: $orderId,
    serviceId: $serviceId,
    data: ['additional' => 'context']
);
```

---

## APPENDIX B: Testing Commands

```bash
# Clear all test notifications
php artisan tinker
>>> Notification::truncate();

# View recent notifications
>>> Notification::latest()->take(10)->get(['type', 'title', 'user_id', 'sent_email']);

# Check admin notifications
>>> Notification::whereHas('user', fn($q) => $q->where('role', 2))->count();

# Test auto-delivery
php artisan orders:auto-deliver --verbose

# Test auto-completion
php artisan orders:auto-complete --verbose

# Monitor queue
php artisan queue:work --verbose

# Check email logs
tail -f storage/logs/laravel.log | grep "NotificationMail"
```

---

**END OF IMPLEMENTATION PLAN**
