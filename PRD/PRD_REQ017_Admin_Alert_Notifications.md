# PRD: Admin Alert Notifications

**Requirement ID:** REQ-017
**Feature Name:** Admin Alert Notifications
**Priority:** MEDIUM
**Category:** Notifications - Admin Monitoring
**Effort Estimate:** 5 hours
**Status:** Not Started

---

## Overview

Critical alerts for admin: high-value orders, suspicious activity, system errors.

---

## Functional Requirements

### FR-1: High-Value Order Alert
**Trigger:** Order created with amount > $500

**Content:**
- "High-value order received"
- Order details (ID, amount, buyer, seller)
- [View Order] CTA

---

### FR-2: Suspicious Activity Alert
**Triggers:**
- User with 3+ disputes in 30 days
- Seller with refund rate > 30%
- Multiple failed payments same user

**Content:**
- Alert type
- User details
- Activity summary
- [Investigate] CTA

---

### FR-3: System Error Alert
**Triggers:**
- Failed Zoom meeting creation
- Failed email queue processing (> 100 jobs failed)
- Payment gateway errors

**Content:**
- Error type
- Error message
- Affected count
- [View Logs] CTA

---

## Technical Specifications

### Implementation Locations

**High-Value Orders:**
```php
// In BookingController.php after order creation
if ($order->amount > 500) {
    Mail::to(config('mail.admin_email'))->send(
        new AdminAlertHighValueOrder($order)
    );
}
```

**Suspicious Activity:**
```php
// Scheduled command or observer
$suspiciousUsers = User::withCount(['disputes' => function($q) {
    $q->where('created_at', '>=', now()->subDays(30));
}])->having('disputes_count', '>=', 3)->get();

foreach ($suspiciousUsers as $user) {
    Mail::to(config('mail.admin_email'))->send(
        new AdminAlertSuspiciousActivity($user, 'multiple_disputes')
    );
}
```

**System Errors:**
```php
// In exception handler or monitoring command
if ($failedJobsCount > 100) {
    Mail::to(config('mail.admin_email'))->send(
        new AdminAlertSystemError('queue_failures', $failedJobsCount)
    );
}
```

### Files to Create
- `app/Mail/AdminAlertHighValueOrder.php`
- `app/Mail/AdminAlertSuspiciousActivity.php`
- `app/Mail/AdminAlertSystemError.php`
- Email templates (3 files)

### Optional: Admin Dashboard Widget
Add alert counter to admin dashboard showing unresolved alerts.

---

## Acceptance Criteria

- [ ] High-value order alerts sent immediately
- [ ] Suspicious activity detected and reported
- [ ] System errors trigger admin notification
- [ ] All alerts include actionable info
- [ ] Admin can view alert history

---

## Implementation Plan

1. Create 3 mail classes (2 hours)
2. Design 3 email templates (1.5 hours)
3. Integrate triggers in various locations (1 hour)
4. Add dashboard widget (optional) (30 min)
5. Testing (1 hour)

**Total:** 5 hours

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
