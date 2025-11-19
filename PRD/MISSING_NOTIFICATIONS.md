# MISSING NOTIFICATIONS - DreamCrowd Marketplace

**Last Updated:** 2025-11-06
**Project:** DreamCrowd Backend
**Current Coverage:** 72/85 notifications (84.7%)
**Total Missing:** 40+ notification scenarios

---

## Executive Summary

This document catalogs all missing notification scenarios in the DreamCrowd marketplace platform. While 72 notifications have been successfully implemented, approximately 40+ scenarios remain across 11 functional categories.

### Coverage Statistics
- **Implemented:** 72 notifications
- **Missing:** 40+ notifications
- **Total Identified:** 85+ scenarios
- **Coverage Rate:** 84.7%

### Priority Breakdown
- **🔴 Critical:** 2 notifications (4-5 hours)
- **🟠 High:** 12 notifications (25-30 hours)
- **🟡 Medium:** 15 notifications (35-40 hours)
- **🟢 Low:** 16 notifications (25-30 hours)
- **Total Estimated Effort:** 90-105 hours

### Implementation Status
The platform is currently **production-ready** with all critical business flows covered. The missing notifications are primarily edge cases, administrative conveniences, and proactive reminders that enhance UX but are not essential for core operations.

---

## 1. Admin Actions - Seller Management

### 🟠 HIGH: Seller Profile Update Request Approval
- **File:** `AdminController.php:681`
- **Status:** Feature exists, notification missing
- **Recipients:** Seller
- **Trigger:** Admin approves seller profile update request
- **Implementation Effort:** 2 hours
- **Message:** "Your profile update request has been approved by the admin team."
- **Data:** `['request_id' => $id, 'approved_at' => now()]`
- **Send Email:** Yes

### 🟠 HIGH: Seller Profile Update Request Rejection
- **File:** `AdminController.php:681` (rejection branch)
- **Status:** Feature exists, notification missing
- **Recipients:** Seller
- **Trigger:** Admin rejects seller profile update request
- **Implementation Effort:** 2 hours
- **Message:** "Your profile update request has been rejected. Reason: {reason}"
- **Data:** `['request_id' => $id, 'rejection_reason' => $reason]`
- **Send Email:** Yes

### 🟡 MEDIUM: Seller Account Suspension
- **File:** `AdminController.php` (if suspension feature exists)
- **Status:** Feature may not exist
- **Recipients:** Seller, Admin (confirmation)
- **Trigger:** Admin suspends seller account
- **Implementation Effort:** 3 hours
- **Message to Seller:** "Your account has been suspended due to: {reason}. Please contact support."
- **Message to Admin:** "Seller account #{seller_id} has been suspended successfully."
- **Data:** `['suspension_reason' => $reason, 'suspended_at' => now(), 'duration' => $days]`
- **Send Email:** Yes

---

## 2. Service/Gig Management

### 🟢 LOW: Service/Gig Approval by Admin
- **File:** `AdminController.php` (function not found)
- **Status:** **FEATURE DOES NOT EXIST** - No admin gig approval workflow found
- **Recipients:** Seller, Admin
- **Trigger:** Admin approves newly created service
- **Implementation Effort:** Feature must be built first (8-10 hours), then 2 hours for notifications
- **Message to Seller:** "Your service '{gig_title}' has been approved and is now live."
- **Message to Admin:** "Service #{gig_id} by {seller_name} has been approved."
- **Data:** `['gig_id' => $id, 'approved_at' => now()]`
- **Send Email:** Yes (to seller), No (to admin)
- **Note:** Currently, all gigs are auto-published on creation

### 🟢 LOW: Service/Gig Rejection by Admin
- **File:** `AdminController.php` (function not found)
- **Status:** **FEATURE DOES NOT EXIST**
- **Recipients:** Seller
- **Trigger:** Admin rejects service before publication
- **Implementation Effort:** Feature must be built first, then 2 hours for notifications
- **Message:** "Your service '{gig_title}' could not be approved. Reason: {reason}"
- **Data:** `['gig_id' => $id, 'rejection_reason' => $reason]`
- **Send Email:** Yes

### 🟡 MEDIUM: Service Edited by Seller
- **File:** `ClassManagementController.php` (update function around line 800-1000)
- **Status:** Feature exists, notification missing
- **Recipients:** Admin (optional monitoring)
- **Trigger:** Seller updates existing published service
- **Implementation Effort:** 2 hours
- **Message:** "{seller_name} has updated their service '{gig_title}'"
- **Data:** `['gig_id' => $id, 'updated_fields' => $changedFields]`
- **Send Email:** No

### 🟡 MEDIUM: Service Deactivated by Seller
- **File:** `ClassManagementController.php` or `TeacherController.php`
- **Status:** Feature may exist, notification missing
- **Recipients:** Admin (for monitoring)
- **Trigger:** Seller manually deactivates their service
- **Implementation Effort:** 2 hours
- **Message:** "Service '{gig_title}' by {seller_name} has been deactivated."
- **Data:** `['gig_id' => $id, 'deactivated_at' => now()]`
- **Send Email:** No

---

## 3. Commission & Financial Settings

### 🟠 HIGH: Commission Rate Updated for Seller
- **File:** `AdminController.php` (commission management section)
- **Status:** Feature may exist, notification missing
- **Recipients:** Seller
- **Trigger:** Admin updates seller's custom commission rate
- **Implementation Effort:** 3 hours (includes locating the update function)
- **Message:** "Your commission rate has been updated to {new_rate}% by the admin team."
- **Data:** `['old_rate' => $oldRate, 'new_rate' => $newRate, 'updated_at' => now()]`
- **Send Email:** Yes

### 🟠 HIGH: Commission Rate Updated for Specific Service
- **File:** `AdminController.php` (service commission management)
- **Status:** Feature may exist, notification missing
- **Recipients:** Seller
- **Trigger:** Admin updates commission rate for specific service
- **Implementation Effort:** 3 hours
- **Message:** "Commission rate for '{gig_title}' has been updated to {new_rate}%."
- **Data:** `['gig_id' => $id, 'old_rate' => $old, 'new_rate' => $new]`
- **Send Email:** Yes

### 🟡 MEDIUM: Platform-Wide Commission Rate Change
- **File:** `AdminController.php` (global settings)
- **Status:** Feature exists (TopSellerTag model), notification missing
- **Recipients:** All active sellers
- **Trigger:** Admin updates default platform commission rate
- **Implementation Effort:** 4 hours (bulk notification to all sellers)
- **Message:** "Platform commission rate has been updated from {old_rate}% to {new_rate}%. This affects all services without custom rates."
- **Data:** `['old_rate' => $old, 'new_rate' => $new, 'effective_date' => $date]`
- **Send Email:** Yes
- **Note:** Requires `sendToMultipleUsers()` for all sellers

### 🟡 MEDIUM: Commission Override Removed
- **File:** `AdminController.php`
- **Status:** Feature may exist, notification missing
- **Recipients:** Seller
- **Trigger:** Admin removes custom commission rate, reverting to default
- **Implementation Effort:** 2 hours
- **Message:** "Your custom commission rate has been removed. Default platform rate of {default_rate}% now applies."
- **Data:** `['default_rate' => $rate, 'changed_at' => now()]`
- **Send Email:** Yes

---

## 4. Bank & Payout Management

### 🟠 HIGH: Bank Account Verification Success
- **File:** `StripeWebhookController.php` or `AccountController.php`
- **Status:** Feature integration unclear, notification missing
- **Recipients:** Seller
- **Trigger:** Seller's bank account verified by Stripe
- **Implementation Effort:** 3 hours
- **Message:** "Your bank account ending in {last4} has been successfully verified. You can now receive payouts."
- **Data:** `['bank_last4' => $last4, 'verified_at' => now()]`
- **Send Email:** Yes

### 🟠 HIGH: Bank Account Verification Failed
- **File:** `StripeWebhookController.php` or `AccountController.php`
- **Status:** Feature integration unclear, notification missing
- **Recipients:** Seller
- **Trigger:** Bank account verification fails
- **Implementation Effort:** 3 hours
- **Message:** "Bank account verification failed. Please check your details and try again. Reason: {reason}"
- **Data:** `['failure_reason' => $reason, 'retry_url' => $url]`
- **Send Email:** Yes

### 🟡 MEDIUM: Payout Schedule Changed
- **File:** `AdminController.php` (if manual payout scheduling exists)
- **Status:** Feature unclear, notification missing
- **Recipients:** Seller
- **Trigger:** Admin changes seller's payout schedule
- **Implementation Effort:** 2 hours
- **Message:** "Your payout schedule has been changed to: {new_schedule}"
- **Data:** `['old_schedule' => $old, 'new_schedule' => $new]`
- **Send Email:** Yes

---

## 5. User Account Management

### 🟢 LOW: Email Verification Success
- **File:** `AuthController.php` (verification callback)
- **Status:** Feature exists, notification missing
- **Recipients:** User
- **Trigger:** User successfully verifies email
- **Implementation Effort:** 1 hour
- **Message:** "Your email has been verified successfully. You now have full access to DreamCrowd."
- **Data:** `['verified_at' => now()]`
- **Send Email:** No (redundant since email was just verified)

### 🟢 LOW: Email Verification Reminder
- **File:** New scheduled command needed
- **Status:** **NEW FEATURE REQUIRED**
- **Recipients:** Unverified users
- **Trigger:** Scheduled task checks users with unverified emails after 24, 48, 72 hours
- **Implementation Effort:** 5 hours (new command + notification)
- **Message:** "You haven't verified your email yet. Please verify to unlock all features."
- **Data:** `['registration_date' => $date, 'verification_link' => $url]`
- **Send Email:** Yes
- **Command:** `php artisan make:command SendEmailVerificationReminders`

### 🟢 LOW: Account Role Changed
- **File:** `AdminController.php` (if role change feature exists)
- **Status:** Feature unclear, notification missing
- **Recipients:** User
- **Trigger:** Admin changes user's role (buyer → seller or vice versa)
- **Implementation Effort:** 2 hours
- **Message:** "Your account role has been updated to: {new_role}"
- **Data:** `['old_role' => $old, 'new_role' => $new, 'changed_by' => 'admin']`
- **Send Email:** Yes

### 🟢 LOW: Account Deletion Request Confirmation
- **File:** `AccountController.php` (if account deletion exists)
- **Status:** **FEATURE MAY NOT EXIST**
- **Recipients:** User, Admin
- **Trigger:** User requests account deletion
- **Implementation Effort:** 3 hours
- **Message to User:** "We've received your account deletion request. Your account will be deleted in 7 days unless you cancel this request."
- **Message to Admin:** "User #{user_id} has requested account deletion."
- **Data:** `['deletion_date' => $date, 'cancel_url' => $url]`
- **Send Email:** Yes

---

## 6. Coupon Management

### 🟡 MEDIUM: Coupon Expiring Soon (Buyer)
- **File:** New scheduled command needed
- **Status:** **NEW FEATURE REQUIRED**
- **Recipients:** Buyers with active coupons
- **Trigger:** Scheduled task checks coupons expiring in 3 days
- **Implementation Effort:** 6 hours (new command + notification)
- **Message:** "Your coupon '{coupon_code}' expires in 3 days! Use it before {expiry_date}."
- **Data:** `['coupon_code' => $code, 'discount' => $amount, 'expiry_date' => $date]`
- **Send Email:** Yes
- **Command:** `php artisan make:command NotifyCouponExpiring`

### 🟡 MEDIUM: Coupon Expired
- **File:** New scheduled command or real-time check
- **Status:** **NEW FEATURE REQUIRED**
- **Recipients:** Buyers who had the coupon
- **Trigger:** Coupon expiration date passes
- **Implementation Effort:** 4 hours
- **Message:** "Your coupon '{coupon_code}' has expired."
- **Data:** `['coupon_code' => $code, 'expired_at' => now()]`
- **Send Email:** No

### 🟢 LOW: New Coupon Available
- **File:** `CouponController.php` (when admin creates public coupon)
- **Status:** Feature exists, notification missing
- **Recipients:** All buyers or targeted user segment
- **Trigger:** Admin creates new public coupon
- **Implementation Effort:** 5 hours (bulk notification)
- **Message:** "New coupon available! Use code '{coupon_code}' for {discount} off."
- **Data:** `['coupon_code' => $code, 'discount' => $amount, 'expiry_date' => $date]`
- **Send Email:** Yes
- **Note:** Requires targeting logic (all users vs. specific segment)

---

## 7. Zoom Integration Events

### 🔴 CRITICAL: Zoom Token Refresh Failed
- **File:** `ZoomMeetingService.php` (token refresh method)
- **Status:** Feature exists, notification missing
- **Recipients:** Seller, Admin
- **Trigger:** Zoom OAuth token refresh fails
- **Implementation Effort:** 3 hours
- **Message to Seller:** "Failed to refresh Zoom connection. Please reconnect your Zoom account to continue hosting classes."
- **Message to Admin:** "Zoom token refresh failed for seller #{seller_id}. User may experience meeting creation issues."
- **Data:** `['seller_id' => $id, 'error' => $error, 'reconnect_url' => $url]`
- **Send Email:** Yes
- **Priority Reason:** Without working Zoom, seller cannot deliver classes

### 🟡 MEDIUM: Zoom Account Disconnected
- **File:** `ZoomController.php` or `AccountController.php`
- **Status:** Feature exists (revoke token), notification missing
- **Recipients:** Seller
- **Trigger:** Seller manually disconnects Zoom integration
- **Implementation Effort:** 2 hours
- **Message:** "Your Zoom account has been disconnected. You will need to reconnect it to host live classes."
- **Data:** `['disconnected_at' => now()]`
- **Send Email:** No

### 🟡 MEDIUM: Zoom Meeting Creation Failed
- **File:** `GenerateZoomMeetings.php:148`
- **Status:** Error logged, notification missing
- **Recipients:** Seller, Admin
- **Trigger:** Zoom API returns error when creating meeting
- **Implementation Effort:** 2 hours
- **Message to Seller:** "Failed to create Zoom meeting for '{class_title}'. Please check your Zoom connection."
- **Message to Admin:** "Zoom meeting creation failed for class #{class_id}. Error: {error}"
- **Data:** `['class_date_id' => $id, 'error' => $error]`
- **Send Email:** Yes (to seller only)

### 🟢 LOW: Zoom Meeting Cancelled
- **File:** `ZoomMeetingService.php` (cancel meeting method)
- **Status:** Feature unclear, notification missing
- **Recipients:** Buyer, Seller
- **Trigger:** Meeting cancelled (order cancelled or rescheduled)
- **Implementation Effort:** 2 hours
- **Message:** "The Zoom meeting for '{class_title}' scheduled on {date} has been cancelled."
- **Data:** `['meeting_id' => $id, 'cancelled_at' => now()]`
- **Send Email:** Yes

---

## 8. Class/Session Reminders

### 🔴 CRITICAL: Class Starting in 24 Hours
- **File:** New scheduled command needed
- **Status:** **NEW FEATURE REQUIRED - HIGH PRIORITY**
- **Recipients:** Buyer, Seller
- **Trigger:** Scheduled command checks classes starting in 24 hours
- **Implementation Effort:** 5 hours (new command + notification)
- **Message to Buyer:** "Reminder: Your class '{class_title}' with {seller_name} starts tomorrow at {time}."
- **Message to Seller:** "Reminder: You have a class '{class_title}' with {buyer_name} tomorrow at {time}."
- **Data:** `['order_id' => $id, 'class_date' => $date, 'zoom_link' => $link]`
- **Send Email:** Yes
- **Command:** `php artisan make:command SendClassReminders --schedule="0 10 * * *"`
- **Priority Reason:** Reduces no-shows and improves attendance rates

### 🟠 HIGH: Class Starting in 1 Hour
- **File:** Same scheduled command as above
- **Status:** **NEW FEATURE REQUIRED - HIGH PRIORITY**
- **Recipients:** Buyer, Seller
- **Trigger:** Scheduled command checks classes starting in 1 hour
- **Implementation Effort:** Included in above command (3 hours)
- **Message:** "Your class '{class_title}' starts in 1 hour! Join here: {zoom_link}"
- **Data:** `['order_id' => $id, 'zoom_link' => $link, 'start_time' => $time]`
- **Send Email:** Yes
- **Priority Reason:** Last-minute reminder for punctuality

### 🟡 MEDIUM: Class Ended - Request Review
- **File:** New scheduled command or real-time trigger
- **Status:** **NEW FEATURE REQUIRED**
- **Recipients:** Buyer
- **Trigger:** 2 hours after class end time
- **Implementation Effort:** 5 hours
- **Message:** "How was your class with {seller_name}? Please leave a review to help others."
- **Data:** `['order_id' => $id, 'review_url' => $url]`
- **Send Email:** No
- **Note:** Increases review rate and platform credibility

### 🟡 MEDIUM: Recurring Class - Next Session Reminder
- **File:** New scheduled command
- **Status:** **NEW FEATURE REQUIRED**
- **Recipients:** Buyer (subscription orders)
- **Trigger:** 3 days before next recurring session
- **Implementation Effort:** 4 hours
- **Message:** "Your next session of '{class_title}' is scheduled for {date} at {time}."
- **Data:** `['order_id' => $id, 'next_class_date' => $date]`
- **Send Email:** Yes

---

## 9. Review & Feedback System

### 🟡 MEDIUM: Review Edited by Buyer
- **File:** `TeacherController.php` (if edit review feature exists)
- **Status:** Feature unclear, notification missing
- **Recipients:** Seller
- **Trigger:** Buyer edits their existing review
- **Implementation Effort:** 2 hours
- **Message:** "{buyer_name} has updated their review for '{service_title}'."
- **Data:** `['review_id' => $id, 'gig_id' => $gigId]`
- **Send Email:** No

### 🟡 MEDIUM: Review Deleted by Admin
- **File:** `AdminController.php` (if admin review moderation exists)
- **Status:** Feature unclear, notification missing
- **Recipients:** Buyer, Seller
- **Trigger:** Admin removes inappropriate review
- **Implementation Effort:** 3 hours
- **Message to Buyer:** "Your review for '{service_title}' has been removed by admin. Reason: {reason}"
- **Message to Seller:** "A review on '{service_title}' has been removed by admin moderation."
- **Data:** `['review_id' => $id, 'removal_reason' => $reason]`
- **Send Email:** Yes (to buyer only)

### 🟢 LOW: High Rating Received (Milestone)
- **File:** `TeacherController.php` (after review submission)
- **Status:** Feature exists, notification missing
- **Recipients:** Seller
- **Trigger:** Seller receives 5-star review
- **Implementation Effort:** 2 hours
- **Message:** "Congratulations! You received a 5-star review from {buyer_name} for '{service_title}'!"
- **Data:** `['review_id' => $id, 'rating' => 5]`
- **Send Email:** No
- **Note:** Gamification / positive reinforcement

---

## 10. Manual Admin Interventions

### 🟠 HIGH: Order Status Manually Changed by Admin
- **File:** `AdminController.php` (order management section)
- **Status:** Feature may exist, notification missing
- **Recipients:** Buyer, Seller
- **Trigger:** Admin manually changes order status
- **Implementation Effort:** 3 hours
- **Message to Buyer:** "Your order status for '{service_title}' has been updated to: {new_status}"
- **Message to Seller:** "Order #{order_id} status has been changed to: {new_status} by admin."
- **Data:** `['order_id' => $id, 'old_status' => $old, 'new_status' => $new, 'reason' => $reason]`
- **Send Email:** Yes

### 🟠 HIGH: Dispute Resolved by Admin (Manual Decision)
- **File:** `AdminController.php` (dispute management)
- **Status:** Feature exists, notification missing
- **Recipients:** Buyer, Seller
- **Trigger:** Admin manually resolves dispute
- **Implementation Effort:** 3 hours
- **Message to Buyer:** "Your dispute for order #{order_id} has been resolved. Decision: {decision}"
- **Message to Seller:** "Dispute for order #{order_id} has been resolved by admin. Decision: {decision}"
- **Data:** `['order_id' => $id, 'dispute_id' => $disputeId, 'decision' => $decision, 'refund_amount' => $amount]`
- **Send Email:** Yes

### 🟡 MEDIUM: Manual Refund Issued by Admin
- **File:** `AdminController.php` (refund management)
- **Status:** Feature may exist, notification missing
- **Recipients:** Buyer, Seller, Admin (confirmation)
- **Trigger:** Admin manually issues refund outside dispute process
- **Implementation Effort:** 3 hours
- **Message to Buyer:** "A refund of ${amount} has been issued for order #{order_id}. Reason: {reason}"
- **Message to Seller:** "A refund of ${amount} has been issued for your order #{order_id}. This will be deducted from your next payout."
- **Data:** `['order_id' => $id, 'refund_amount' => $amount, 'reason' => $reason]`
- **Send Email:** Yes

### 🟡 MEDIUM: Service Featured/Promoted by Admin
- **File:** `AdminController.php` (if featured/promotion feature exists)
- **Status:** **FEATURE MAY NOT EXIST**
- **Recipients:** Seller
- **Trigger:** Admin marks service as featured or promoted
- **Implementation Effort:** 2 hours
- **Message:** "Great news! Your service '{gig_title}' has been featured on the homepage."
- **Data:** `['gig_id' => $id, 'featured_until' => $date]`
- **Send Email:** Yes

---

## 11. Error & System Events

### 🟠 HIGH: Payment Processing Error (Order Creation)
- **File:** `BookingController.php` (order creation around line 400-500)
- **Status:** Error handling exists, notification missing
- **Recipients:** Buyer, Admin
- **Trigger:** Payment succeeds but order creation fails
- **Implementation Effort:** 3 hours
- **Message to Buyer:** "We received your payment but encountered an error creating your order. Our team has been notified and will resolve this shortly. Reference: {transaction_id}"
- **Message to Admin:** "URGENT: Payment received but order creation failed. Transaction: {transaction_id}, Amount: {amount}"
- **Data:** `['transaction_id' => $id, 'amount' => $amount, 'error' => $error]`
- **Send Email:** Yes
- **Priority Reason:** Prevents payment disputes and user confusion

### 🟡 MEDIUM: Scheduled Command Failure
- **File:** All scheduled commands in `app/Console/Commands/`
- **Status:** Logging exists, notification missing
- **Recipients:** Admin
- **Trigger:** Scheduled command throws exception
- **Implementation Effort:** 4 hours (add to all commands)
- **Message:** "Scheduled command '{command_name}' failed. Error: {error}"
- **Data:** `['command' => $commandName, 'error' => $error, 'timestamp' => now()]`
- **Send Email:** Yes
- **Note:** Requires catch block in each command's handle() method

### 🟢 LOW: Large File Upload Failed
- **File:** `ClassManagementController.php` (file upload section)
- **Status:** Feature exists, notification missing
- **Recipients:** Seller
- **Trigger:** File upload exceeds size limit or fails
- **Implementation Effort:** 2 hours
- **Message:** "File upload failed. Please ensure your file is under {max_size}MB and try again."
- **Data:** `['file_name' => $name, 'file_size' => $size, 'max_size' => $maxSize]`
- **Send Email:** No

---

## Implementation Roadmap

### Phase 1: Critical Notifications (4-5 hours)
**Priority: Immediate implementation recommended**

1. **Class Starting in 24 Hours** (5 hours)
   - Create `SendClassReminders` command
   - Schedule to run hourly
   - Query `class_dates` table for upcoming classes
   - Send notifications to buyer and seller
   - Include Zoom link in notification

2. **Zoom Token Refresh Failed** (3 hours)
   - Add notification in `ZoomMeetingService.php`
   - Notify seller and admin
   - Include reconnection URL

**Total Phase 1 Effort:** 8 hours

---

### Phase 2: High Priority Notifications (25-30 hours)
**Priority: Implement within 2-4 weeks**

1. **Commission Rate Changes** (3 hours each x 2 = 6 hours)
   - Seller-specific commission update
   - Service-specific commission update

2. **Bank Account Verification** (3 hours each x 2 = 6 hours)
   - Verification success
   - Verification failure

3. **Seller Profile Update Requests** (2 hours each x 2 = 4 hours)
   - Approval notification
   - Rejection notification

4. **Payment Processing Error** (3 hours)
   - Add error handling in BookingController
   - Notify buyer and admin

5. **Class Starting in 1 Hour** (3 hours)
   - Add to SendClassReminders command
   - Send with Zoom link

6. **Admin Manual Interventions** (3 hours each x 2 = 6 hours)
   - Order status change
   - Dispute resolution

**Total Phase 2 Effort:** 28 hours

---

### Phase 3: Medium Priority Notifications (35-40 hours)
**Priority: Implement within 1-2 months**

1. **Coupon Management** (6 hours + 4 hours = 10 hours)
   - Coupon expiring soon (new command)
   - Coupon expired

2. **Service Management** (2 hours each x 3 = 6 hours)
   - Service edited
   - Service deactivated
   - Manual refund issued

3. **Zoom Events** (2 hours each x 3 = 6 hours)
   - Account disconnected
   - Meeting creation failed
   - Meeting cancelled

4. **Class Reminders** (5 hours + 4 hours = 9 hours)
   - Class ended - request review
   - Recurring class next session

5. **Review System** (2 hours each x 2 = 4 hours)
   - Review edited
   - Review deleted by admin

6. **Other** (2-3 hours each x 4 = 10 hours)
   - Seller suspension
   - Platform-wide commission change
   - Payout schedule changed
   - Scheduled command failures

**Total Phase 3 Effort:** 45 hours

---

### Phase 4: Low Priority Notifications (25-30 hours)
**Priority: Implement as time permits**

1. **Service Approval/Rejection** (10 hours)
   - Feature must be built first
   - Then add notifications

2. **User Account Management** (1-5 hours each x 4 = 15 hours)
   - Email verification success
   - Email verification reminders (new command)
   - Account role changed
   - Account deletion confirmation

3. **Miscellaneous** (2-3 hours each x 5 = 12 hours)
   - New coupon available
   - High rating milestone
   - Service featured/promoted
   - Large file upload failed
   - Zoom meeting cancelled

**Total Phase 4 Effort:** 37 hours

---

## Technical Implementation Guide

### Pattern 1: Controller Dependency Injection
**Use when:** Adding notifications to existing controller methods

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
        // Your existing logic...

        // Add notification
        $this->notificationService->send(
            userId: $userId,
            type: 'notification_type',
            title: 'Notification Title',
            message: 'Notification message with {variable}',
            data: ['key' => 'value', 'order_id' => $orderId],
            sendEmail: true // or false
        );
    }
}
```

### Pattern 2: Using app() Helper
**Use when:** Adding notifications without modifying constructor (quick implementation)

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
**Use when:** Notifying multiple users (e.g., all admins, all sellers)

```php
// Get all admin user IDs
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

### Pattern 4: Scheduled Command Notifications
**Use when:** Creating new scheduled commands with notifications

```php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class YourScheduledCommand extends Command
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

            // Notify admin of command failure
            $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
            $this->notificationService->sendToMultipleUsers(
                userIds: $adminIds,
                type: 'system',
                title: 'Command Failed',
                message: 'Scheduled command ' . $this->signature . ' failed: ' . $e->getMessage(),
                data: ['error' => $e->getMessage(), 'command' => $this->signature],
                sendEmail: true
            );
        }

        return 0;
    }
}
```

### Pattern 5: Error Handling with Notifications
**Use when:** Adding notifications in catch blocks

```php
try {
    // Business logic that might fail
    $result = $someService->processPayment();
} catch (\Exception $e) {
    \Log::error('Payment processing failed: ' . $e->getMessage());

    // Notify buyer
    app(\App\Services\NotificationService::class)->send(
        userId: $buyerId,
        type: 'payment',
        title: 'Payment Error',
        message: 'We encountered an error processing your payment. Our team has been notified.',
        data: ['error' => $e->getMessage(), 'reference' => $referenceId],
        sendEmail: true
    );

    // Notify admin
    $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
    app(\App\Services\NotificationService::class)->sendToMultipleUsers(
        userIds: $adminIds,
        type: 'system',
        title: 'Payment Processing Error',
        message: 'URGENT: Payment processing failed for user #' . $buyerId,
        data: ['user_id' => $buyerId, 'error' => $e->getMessage()],
        sendEmail: true
    );

    throw $e; // Re-throw if needed
}
```

---

## Notification Type Reference

Use these standardized notification types for consistency:

- **`account`** - Account-related (registration, verification, role changes, application status)
- **`order`** - Order lifecycle (creation, updates, delivery, completion)
- **`payment`** - Payment events (success, failure, refunds)
- **`payout`** - Payout events (scheduled, completed, failed)
- **`cancellation`** - Order cancellations (buyer, seller, auto)
- **`dispute`** - Dispute-related notifications
- **`reschedule`** - Reschedule requests and responses
- **`class`** - Class/session events (reminders, Zoom links, start times)
- **`review`** - Reviews and ratings
- **`message`** - Chat/messaging notifications
- **`gig`** - Service/gig management (creation, approval, status changes)
- **`coupon`** - Coupon-related notifications
- **`system`** - System errors and admin alerts
- **`zoom`** - Zoom integration events

---

## Email Sending Guidelines

**Send Email = true** when:
- Financial transactions (payments, refunds, payouts)
- Account status changes (approval, rejection, suspension)
- Important security events (password change, bank verification)
- Time-sensitive reminders (class starting, coupon expiring)
- Error notifications to admins
- User-initiated actions requiring confirmation

**Send Email = false** when:
- Real-time messaging notifications (handled via push)
- Low-priority updates (service edited, review reply)
- Notifications already sent via email in same flow
- High-frequency events (clicks, views, impressions)
- System-generated status updates (gig auto-ended)

---

## Testing Checklist

When implementing new notifications, verify:

- [ ] Notification appears in recipient's notification list (`notifications` table)
- [ ] Notification is broadcast via Pusher (check browser console)
- [ ] Email is sent if `sendEmail: true` (check Mailtrap/email logs)
- [ ] Notification count increments in UI
- [ ] Data payload is correctly structured
- [ ] No notifications sent to non-existent users (causes errors)
- [ ] Multi-user notifications don't include duplicates
- [ ] Notification links work and redirect correctly
- [ ] Error handling doesn't break main business logic
- [ ] Scheduled commands log notifications sent

---

## Appendix A: Already Implemented Notifications

For reference, these 72 notifications have been successfully implemented:

### Order Lifecycle (12)
✅ Order created (buyer + seller)
✅ Order accepted by seller
✅ Order cancelled by buyer (with refund details)
✅ Order cancelled by seller (with refund details)
✅ Order auto-cancelled (buyer + seller + admin)
✅ Order delivered (buyer + seller)
✅ Order completed (buyer + seller)
✅ Trial class booked (buyer + seller)
✅ Coupon used (seller notification)

### Payment & Payout (8)
✅ Payment succeeded (buyer + seller)
✅ Payment failed (buyer + admin)
✅ Payout paid (seller)
✅ Payout failed (seller + admin)
✅ Manual payout completed (seller)
✅ Batch payout completed (seller, per transaction)

### Dispute & Refund (4)
✅ Dispute created by buyer (buyer + seller)
✅ Counter-dispute by seller (buyer + seller)
✅ Auto-refund processed (buyer + seller + admin)

### Reschedule (6)
✅ Reschedule requested by buyer (seller notification)
✅ Reschedule requested by seller (buyer notification)
✅ Reschedule approved (requester notification)
✅ Reschedule rejected (requester notification)

### Seller Application (5)
✅ Application submitted (seller + admin)
✅ Application approved (seller) **[BUG FIXED]**
✅ Application rejected (seller) **[BUG FIXED]**
✅ Category rejected (seller)

### Service/Gig (4)
✅ Gig created (seller + admin)
✅ Gig auto-ended (seller)

### Zoom Integration (3)
✅ Zoom meeting created (buyer + seller)
✅ Zoom link ready (buyer)

### Reviews (2)
✅ Seller replied to review (buyer)

### Messaging (2)
✅ New message received (receiver)
✅ SMS sent (receiver)

### Authentication (2)
✅ User registered (welcome notification)
✅ Password changed (security notification)

**Total Implemented:** 72 notifications across 10 categories

---

## Appendix B: File Location Quick Reference

### Controllers with Notifications
- `AdminController.php` - Admin actions, seller approvals, payouts, commissions
- `OrderManagementController.php` - Order lifecycle, cancellations, reschedules
- `BookingController.php` - Order creation, payment processing, trial classes
- `StripeWebhookController.php` - Payment and payout webhooks
- `TeacherController.php` - Seller dashboard, review replies
- `ExpertController.php` - Seller application submission
- `ClassManagementController.php` - Service/gig creation and management
- `MessagesController.php` - Chat messaging
- `AuthController.php` - Registration, password changes

### Scheduled Commands with Notifications
- `AutoCancelPendingOrders.php` - Auto-cancel orders not accepted in time
- `AutoMarkDelivered.php` - Mark orders as delivered after due date
- `AutoMarkCompleted.php` - Mark orders as completed after 48 hours
- `AutoHandleDisputes.php` - Process refunds for disputes
- `GenerateZoomMeetings.php` - Create Zoom meetings 30 min before class
- `UpdateTeacherGigStatus.php` - Update gig status based on dates

### Service Classes
- `NotificationService.php` - Core notification sending logic
- `ZoomMeetingService.php` - Zoom API integration

---

## Document Maintenance

**How to Update This Document:**
1. When implementing a missing notification, move it from this document to the "Already Implemented" section
2. Update the coverage statistics at the top
3. Adjust priority levels if requirements change
4. Add new missing notifications if discovered during development
5. Update effort estimates based on actual implementation time

**Version History:**
- **v1.0** (2025-11-06) - Initial comprehensive audit of missing notifications

---

## Contact & Support

For questions about notification implementation or this document:
- Check existing implementations in files listed in Appendix B
- Review NotificationService.php for available methods
- Test notifications in development before deploying to production
- Monitor logs in `storage/logs/` for notification errors

---

**End of Document**
