# PRD: Order Status Change Notifications

**Requirement ID:** REQ-010
**Feature Name:** Order Status Change Notifications
**Priority:** MEDIUM
**Category:** Notifications - Order Lifecycle
**Effort Estimate:** 6 hours
**Status:** Not Started

---

## Overview

Notify both parties when orders transition through lifecycle: Active → Delivered → Completed.

### Business Value
- Transparency in order progress
- Clear communication of next steps
- Proactive updates reduce support tickets

---

## Functional Requirements

### FR-1: Order Marked as Delivered
**Recipients:** Buyer + Seller
**Trigger:** `AutoMarkDelivered.php` changes status to 2

**Buyer Email:**
- "Your class has been marked as delivered"
- Order details
- 48-hour dispute window notice
- Review request CTA

**Seller Email:**
- "Class marked as delivered"
- Payout timeline: "Available 48 hours after delivery (if no disputes)"
- Earnings summary

---

### FR-2: Order Marked as Completed
**Recipients:** Seller (primary)
**Trigger:** `AutoMarkCompleted.php` changes status to 3

**Seller Email:**
- "Congratulations! Order completed"
- Earnings now eligible for payout
- Payout processing info
- Thank you message

**Optional Buyer Email:**
- "Thanks for using DreamCrowd"
- Review reminder
- Browse more classes CTA

---

## Technical Specifications

### Modify Commands
**File:** `app/Console/Commands/AutoMarkDelivered.php`

```php
// After status update
$bookOrder->update(['status' => 2, 'action_date' => now()]);

// Send notifications
Mail::to($bookOrder->user->email)->queue(
    new OrderDeliveredNotification($bookOrder)
);
Mail::to($bookOrder->teacherGig->user->email)->queue(
    new OrderDeliveredNotificationSeller($bookOrder)
);
```

**File:** `app/Console/Commands/AutoMarkCompleted.php`

```php
// After status update
$bookOrder->update(['status' => 3]);

// Send notifications
Mail::to($bookOrder->teacherGig->user->email)->queue(
    new OrderCompletedNotification($bookOrder)
);
```

### Files to Create
- `app/Mail/OrderDeliveredNotification.php` (buyer)
- `app/Mail/OrderDeliveredNotificationSeller.php`
- `app/Mail/OrderCompletedNotification.php` (seller)
- Email templates (3 files)

---

## Acceptance Criteria

- [ ] Emails sent automatically when status changes
- [ ] 48-hour dispute window clearly explained
- [ ] Payout timeline communicated
- [ ] Review CTA included for buyers

---

## Implementation Plan

1. Create 3 mail classes (2 hours)
2. Design 3 email templates (2 hours)
3. Integrate into both commands (1 hour)
4. Testing (1 hour)

**Total:** 6 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
