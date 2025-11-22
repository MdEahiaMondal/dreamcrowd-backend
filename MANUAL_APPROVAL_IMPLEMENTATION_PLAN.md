# Manual Approval System - Implementation Plan

## Client Requirement Summary (Translated from Bangla)

### Current Problem
The client believes that when a Buyer sends a "Buyer Request" (custom order request), it automatically approves after 1 day and moves to Active Orders - **without the Seller's approval**. This is forcing orders onto Sellers without their consent.

> **Note**: After code analysis, **NO auto-approve logic was found**. The system currently requires manual approval via the "Accept Order" button in the Buyer Request tab. However, we will implement the requested features to give Sellers more control and improve the workflow.

### Client Requirements

1. **Manual Approval as Default (PRIORITY)**
   - Orders should NOT become Active without Seller's explicit approval
   - Seller must click "Approve" button in Buyer Request tab to activate order
   - NO automatic approval should occur

2. **Optional Auto-Approve Setting**
   - Sellers can enable auto-approve in their settings (optional feature)
   - OR when creating a Class/Freelance Service, offer choice:
     - **Instant Approval** (auto-approve)
     - **Manual Approval** (default - requires manual action)
   - Default must be **Manual Approval**

3. **Reminder System** (ALREADY IMPLEMENTED ✅)
   - ✅ Daily email reminders to Seller for pending orders
   - ✅ After 48 hours, email to Buyer explaining options
   - Current command: `SendOrderApprovalReminders` (runs daily at 10:00 AM)

### Expected Behavior
- System should work like Fiverr/Upwork Buyer Request system
- Seller has full control over which requests to accept
- Buyers are kept informed about pending status
- Auto-approve only if Seller explicitly enables it

---

## Code Analysis - Current State

### ✅ Already Implemented

1. **Manual Approval Functionality**
   - Location: `app/Http/Controllers/OrderManagementController.php:1121-1234`
   - Function: `AcceptOrder($id)`
   - Current behavior: Seller clicks "Accept" button → Order status changes from 0 (Pending) to 1 (Active)

2. **Buyer Request Tab (Seller Dashboard)**
   - View: `resources/views/Teacher-Dashboard/client-managment.blade.php:155`
   - Shows all pending orders (status = 0)
   - Displays order count badge

3. **Reminder System**
   - Command: `app/Console/Commands/SendOrderApprovalReminders.php`
   - Schedule: Daily at 10:00 AM (`app/Console/Kernel.php:112`)
   - Features:
     - Sends daily reminders to Sellers for orders pending > 24 hours
     - Sends notification to Buyers after 48 hours
     - Uses `pending_notification_sent` flag to avoid duplicate buyer notifications
     - Integrates with `NotificationService` for in-app + email notifications

4. **Auto-Cancel for Expired Pending Orders**
   - Command: `app/Console/Commands/AutoCancelPendingOrders.php`
   - Schedule: Every 10 minutes (`app/Console/Kernel.php:17-21`)
   - Behavior: Cancels pending orders if first class is about to start (within 30 minutes)
   - Includes Stripe refund processing

5. **Database Fields**
   - `book_orders.status` = 0 (Pending), 1 (Active), 2 (Delivered), 3 (Completed), 4 (Cancelled)
   - `book_orders.pending_notification_sent` = tracks if 48h buyer notification was sent
   - Migration: `database/migrations/2025_11_19_042716_add_pending_notification_sent_to_book_orders_table.php`

### ❌ NOT Found / Missing

1. **Auto-Approve Logic**
   - ❌ No command or scheduled job that auto-approves orders after X days
   - ❌ No background job that changes status from 0 → 1 automatically
   - **Conclusion**: Either the client is mistaken about current auto-approve behavior, OR it was removed recently

2. **Auto-Approve Settings**
   - ❌ No database field for seller-level auto-approve preference
   - ❌ No database field for service-level approval mode
   - ❌ No UI in Seller Settings for toggling auto-approve

3. **Approval Mode in Service Creation**
   - ❌ No "Instant Approval" vs "Manual Approval" option when creating TeacherGig
   - ❌ No `approval_mode` field in `teacher_gigs` table

---

## Implementation Plan

### Phase 1: Database Schema Updates

#### 1.1 Add `auto_approve_enabled` to Users Table
**Purpose**: Allow Sellers to enable/disable auto-approve globally for all their services

```php
// Migration: database/migrations/YYYY_MM_DD_add_auto_approve_to_users.php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('auto_approve_enabled')->default(false)
        ->after('role')
        ->comment('Enable automatic approval of buyer requests');
});
```

#### 1.2 Add `approval_mode` to TeacherGigs Table
**Purpose**: Per-service control over approval behavior

```php
// Migration: database/migrations/YYYY_MM_DD_add_approval_mode_to_teacher_gigs.php
Schema::table('teacher_gigs', function (Blueprint $table) {
    $table->enum('approval_mode', ['manual', 'instant'])
        ->default('manual')
        ->after('status')
        ->comment('Manual requires seller approval, Instant auto-approves');
});
```

#### 1.3 Update Model Fillable Arrays
- Add `auto_approve_enabled` to `User` model fillable
- Add `approval_mode` to `TeacherGig` model fillable

---

### Phase 2: Service Creation UI Updates

#### 2.1 Add Approval Mode Option to Service Creation Forms

**Files to Update**:
- `resources/views/Teacher-Dashboard/[service-creation-form].blade.php`

**UI Component** (after service type selection):
```html
<div class="form-group">
    <label>Order Approval Mode</label>
    <div class="radio-group">
        <label>
            <input type="radio" name="approval_mode" value="manual" checked>
            <strong>Manual Approval</strong> (Recommended)
            <small>You must approve each order before it becomes active</small>
        </label>
        <label>
            <input type="radio" name="approval_mode" value="instant">
            <strong>Instant Approval</strong>
            <small>Orders are automatically approved when buyers book</small>
        </label>
    </div>
</div>
```

#### 2.2 Update Service Creation Controller

**File**: `app/Http/Controllers/ClassManagementController.php` (or relevant controller)

**In service creation method**:
```php
$gig->approval_mode = $request->approval_mode ?? 'manual'; // Default to manual
$gig->save();
```

---

### Phase 3: Seller Settings UI

#### 3.1 Add Global Auto-Approve Toggle to Seller Settings

**File**: `resources/views/Teacher-Dashboard/settings.blade.php` (or equivalent)

```html
<div class="settings-section">
    <h4>Order Management Preferences</h4>

    <div class="form-group">
        <label class="switch-label">
            <input type="checkbox"
                   name="auto_approve_enabled"
                   value="1"
                   {{ Auth::user()->auto_approve_enabled ? 'checked' : '' }}>
            <span class="toggle-switch"></span>
            Enable Auto-Approve for All Services
        </label>
        <p class="help-text">
            When enabled, all incoming orders will be automatically approved.
            You can still set individual services to require manual approval.
        </p>
    </div>
</div>
```

#### 3.2 Update Settings Controller

**File**: `app/Http/Controllers/[Settings/Profile]Controller.php`

```php
public function updateSettings(Request $request) {
    $user = Auth::user();
    $user->auto_approve_enabled = $request->has('auto_approve_enabled');
    $user->save();

    return redirect()->back()->with('success', 'Settings updated successfully!');
}
```

---

### Phase 4: Order Creation Logic Updates

#### 4.1 Update BookingController Order Creation

**File**: `app/Http/Controllers/BookingController.php`

**Current behavior**: When order is created, status = 0 (Pending)

**New logic to add** (after order creation):
```php
// Determine if order should be auto-approved
$seller = User::find($order->teacher_id);
$service = TeacherGig::find($order->gig_id);

$shouldAutoApprove = false;

// Priority 1: Service-level setting
if ($service->approval_mode === 'instant') {
    $shouldAutoApprove = true;
}
// Priority 2: Seller-level setting (if service allows)
elseif ($seller->auto_approve_enabled && $service->approval_mode !== 'manual') {
    $shouldAutoApprove = true;
}

if ($shouldAutoApprove) {
    $order->status = 1; // Auto-approve to Active
    $order->action_date = now();
    $order->save();

    // Send "Order Auto-Approved" notification to both parties
    $this->notificationService->send(
        userId: $order->user_id,
        type: 'order',
        title: 'Order Automatically Approved',
        message: 'Your order has been automatically approved by the seller.',
        // ... other params
    );
} else {
    $order->status = 0; // Pending - requires manual approval
    $order->save();

    // Send "Pending Approval" notification to seller
    $this->notificationService->send(
        userId: $order->teacher_id,
        type: 'order',
        title: 'New Order Awaiting Approval',
        message: 'You have a new order request. Please review and approve.',
        // ... other params
    );
}
```

---

### Phase 5: Approval Workflow Enhancements

#### 5.1 Update Buyer Request Tab UI

**File**: `resources/views/Teacher-Dashboard/client-managment.blade.php`

**Add visual indicators**:
- Show how long order has been pending
- Add urgency colors (green < 24h, yellow 24-48h, red > 48h)
- Bulk approve/reject actions (optional)

#### 5.2 Add Reject/Decline Functionality

**File**: `app/Http/Controllers/OrderManagementController.php`

**New method**:
```php
public function RejectOrder($id) {
    $order = BookOrder::find($id);

    if (!$order || $order->status != 0) {
        return redirect()->back()->with('error', 'Invalid order');
    }

    // Cancel order with refund
    $order->status = 4; // Cancelled
    $order->refund = 1;
    // ... Stripe refund logic

    // Notify buyer
    $this->notificationService->send(/* ... */);

    return redirect()->back()->with('success', 'Order rejected and refunded');
}
```

---

### Phase 6: Testing & Validation

#### 6.1 Test Scenarios

1. **Manual Approval (Default)**
   - ✅ Create new service → approval_mode = 'manual'
   - ✅ Buyer books → order status = 0
   - ✅ Seller approves → order status = 1
   - ✅ Seller rejects → order cancelled + refund

2. **Instant Approval (Service-Level)**
   - ✅ Create service with approval_mode = 'instant'
   - ✅ Buyer books → order status = 1 (immediate)
   - ✅ Notifications sent correctly

3. **Auto-Approve (Seller-Level)**
   - ✅ Seller enables auto_approve_enabled = true
   - ✅ Buyer books service with approval_mode = 'manual' → auto-approved
   - ✅ Works across all seller's services

4. **Reminder System**
   - ✅ Pending order > 24h → Seller gets daily reminder
   - ✅ Pending order > 48h → Buyer gets notification
   - ✅ `pending_notification_sent` flag works correctly

5. **Auto-Cancel**
   - ✅ Pending order with class starting in 25 min → auto-cancelled + refunded
   - ✅ Notifications sent to buyer, seller, admin

#### 6.2 Database Migration Testing

```bash
# Run migrations
php artisan migrate

# Rollback test
php artisan migrate:rollback

# Fresh migration
php artisan migrate:fresh --seed
```

#### 6.3 Command Testing

```bash
# Test reminder command (dry-run)
php artisan orders:send-approval-reminders --dry-run

# Test auto-cancel (dry-run)
php artisan orders:auto-cancel --dry-run
```

---

### Phase 7: Documentation & User Communication

#### 7.1 Update Admin Documentation
- Add section explaining approval modes
- Document how sellers can manage settings
- Explain when orders auto-approve vs require manual action

#### 7.2 In-App Tooltips/Help Text
- Add explanatory tooltips next to approval mode options
- Help center article: "Understanding Order Approval Modes"

#### 7.3 Seller Onboarding Email
- Email existing sellers about new feature
- Explain default behavior (manual approval)
- Show how to enable auto-approve if desired

---

## File Change Summary

### New Migrations (2)
1. `database/migrations/YYYY_MM_DD_add_auto_approve_to_users.php`
2. `database/migrations/YYYY_MM_DD_add_approval_mode_to_teacher_gigs.php`

### Model Updates (2)
1. `app/Models/User.php` - Add `auto_approve_enabled` to fillable
2. `app/Models/TeacherGig.php` - Add `approval_mode` to fillable

### Controller Updates (3)
1. `app/Http/Controllers/BookingController.php` - Auto-approve logic in order creation
2. `app/Http/Controllers/ClassManagementController.php` - Save approval_mode when creating service
3. `app/Http/Controllers/OrderManagementController.php` - Add RejectOrder method (optional)

### View Updates (3)
1. `resources/views/Teacher-Dashboard/[service-creation-form].blade.php` - Add approval mode radio buttons
2. `resources/views/Teacher-Dashboard/settings.blade.php` - Add auto-approve toggle
3. `resources/views/Teacher-Dashboard/client-managment.blade.php` - Enhance Buyer Request tab UI (optional)

### No Changes Needed
- ✅ `app/Console/Commands/SendOrderApprovalReminders.php` (already perfect)
- ✅ `app/Console/Commands/AutoCancelPendingOrders.php` (already perfect)
- ✅ `app/Console/Kernel.php` (scheduling already configured)

---

## Important Notes

### Auto-Approve Logic - Current Status
**I could NOT find any existing auto-approve logic** in the codebase that automatically changes order status from 0 → 1 after 1 day. The client may be:
1. Mistaken about current behavior
2. Referring to a feature that was recently removed
3. Experiencing a bug that needs investigation

**Recommendation**: Confirm with client if auto-approve is actually happening, or if they want to prevent it "just in case" for the future.

### Priority Order for Auto-Approve Decision

When an order is placed, check in this order:
1. **Service-level**: If `teacher_gigs.approval_mode = 'instant'` → Auto-approve
2. **Seller-level**: If `users.auto_approve_enabled = true` AND service is not set to 'manual' → Auto-approve
3. **Default**: Manual approval required (status = 0)

### Backward Compatibility

- **Existing services**: Will default to `approval_mode = 'manual'` after migration
- **Existing sellers**: Will have `auto_approve_enabled = false` after migration
- **No existing orders affected**: Only new orders created after implementation

---

## Timeline Estimate

| Phase | Tasks | Estimated Time |
|-------|-------|----------------|
| Phase 1 | Database migrations | 1 hour |
| Phase 2 | Service creation UI + controller | 2 hours |
| Phase 3 | Seller settings UI + controller | 2 hours |
| Phase 4 | Order creation logic updates | 3 hours |
| Phase 5 | Approval workflow enhancements | 2 hours |
| Phase 6 | Testing & validation | 3 hours |
| Phase 7 | Documentation | 1 hour |
| **Total** | | **14 hours** |

---

## Risk Assessment

### Low Risk ✅
- Adding new database fields (non-breaking)
- UI additions (doesn't affect existing functionality)
- Default values maintain current behavior

### Medium Risk ⚠️
- Order creation logic changes (needs thorough testing)
- Notification logic (ensure no duplicate notifications)

### Mitigation Strategy
- Use feature flags/environment variables to toggle new logic
- Comprehensive testing before production deployment
- Gradual rollout (test with subset of sellers first)

---

## Success Criteria

✅ **Feature Complete When**:
1. Sellers can set global auto-approve preference in settings
2. Sellers can set per-service approval mode (manual vs instant)
3. Default behavior is manual approval for all new services
4. Orders respect approval mode settings correctly
5. Reminder system continues working (already implemented)
6. Auto-cancel for expired orders works (already implemented)
7. All notifications sent at correct times with correct messages
8. No regressions in existing order workflow
9. Sellers report feeling in control of their incoming orders
10. Buyer experience is clear (knows when order is pending vs approved)

---

## Next Steps - Awaiting Approval

**Before proceeding with implementation, please confirm**:

1. ✅ Is the plan aligned with client requirements?
2. ✅ Should we add "Reject Order" functionality or just "Approve"?
3. ✅ Do we need bulk approve/reject for multiple pending orders?
4. ✅ Should existing services default to manual or instant approval after migration?
5. ✅ Any additional UI/UX preferences for the approval mode selection?

**Once approved, I will proceed with implementation in the order of phases listed above.**

---

## Auto-Approve Investigation Needed ⚠️

**IMPORTANT**: The client claims orders auto-approve after 1 day, but I found **NO code** implementing this behavior.

**Recommended immediate action**:
```bash
# Check database for orders that changed from 0 → 1 without manual approval
SELECT id, user_id, teacher_id, status, created_at, updated_at, action_date
FROM book_orders
WHERE status = 1
  AND action_date IS NOT NULL
  AND created_at < updated_at
  AND TIMESTAMPDIFF(HOUR, created_at, updated_at) BETWEEN 20 AND 30
ORDER BY updated_at DESC
LIMIT 50;
```

This query will reveal if there are orders that mysteriously became active ~24 hours after creation, which would indicate a hidden auto-approve mechanism.

---

**Document Version**: 1.0
**Created**: 2025-11-22
**Author**: Claude Code Analysis
**Status**: ⏳ Awaiting Client Approval
