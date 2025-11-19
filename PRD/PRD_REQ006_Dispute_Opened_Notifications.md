# PRD: Dispute Opened Notifications

**Requirement ID:** REQ-006
**Feature Name:** Dispute Opened Notifications
**Priority:** HIGH
**Category:** Notifications - Dispute Management
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

### Problem Statement
When buyer opens a dispute, neither teacher nor admin receives notification, causing:
- ❌ Delayed teacher response (misses 48-hour counter-dispute window)
- ❌ Admin unaware of disputes requiring intervention
- ❌ Poor resolution times

### Proposed Solution
Automatically notify teacher and admin immediately when dispute is opened.

---

## User Stories

**As a** teacher whose order is disputed
**I want to** receive immediate email notification
**So that** I can respond within 48 hours and avoid automatic refund

**As an** admin
**I want to** be notified of all new disputes
**So that** I can monitor and intervene if needed

---

## Functional Requirements

### FR-1: Teacher Dispute Notification
**Content:**
- Alert heading: "A buyer has opened a dispute"
- Order details
- **Dispute information:**
  - Dispute reason: [buyer's reason]
  - Dispute date/time
  - Order ID and class details
- **What happens next:**
  - You have 48 hours to respond
  - If no response, automatic refund occurs
  - How to respond/counter-dispute
- [View Dispute] CTA
- [Respond to Dispute] CTA

**Trigger:** `DisputeOrder` record created

---

### FR-2: Admin Dispute Alert
**Content:**
- New dispute alert
- Buyer name and order ID
- Dispute reason
- Teacher name
- Order value
- [View in Admin Panel] CTA

**Trigger:** Same as FR-1

---

## Technical Specifications

### Model Event
**File:** `app/Models/DisputeOrder.php`

```php
protected static function booted()
{
    static::created(function ($dispute) {
        $order = $dispute->bookOrder;

        // Notify teacher
        Mail::to($order->teacherGig->user->email)
            ->queue(new DisputeOpenedTeacher($dispute));

        // Notify admin
        Mail::to(config('mail.admin_email'))
            ->queue(new DisputeOpenedAdmin($dispute));

        \Log::info('Dispute opened', [
            'dispute_id' => $dispute->id,
            'order_id' => $order->id,
            'reason' => $dispute->user_dispute_msg
        ]);
    });
}
```

### Files to Create
- `app/Mail/DisputeOpenedTeacher.php`
- `app/Mail/DisputeOpenedAdmin.php`
- `resources/views/emails/dispute-opened-teacher.blade.php`
- `resources/views/emails/dispute-opened-admin.blade.php`

---

## Email Template (Teacher)

```html
<!-- Header -->
⚠️ Dispute Opened

<!-- Content -->
Hi [Teacher Name],

A buyer has opened a dispute for one of your orders.

[Dispute Details Box]
Order #: 12345
Class: [Class Name]
Buyer: [First Name]
Dispute Opened: [Date Time]

[Reason Box]
Buyer's Reason:
"[Dispute message from buyer]"

[Important Notice - Red Box]
⏰ ACTION REQUIRED: You have 48 hours to respond

If you don't respond within 48 hours, the buyer will automatically receive a full refund.

[What You Can Do]
1. Review the dispute details carefully
2. Provide your response with supporting evidence
3. Contact the buyer to resolve amicably (recommended)
4. Submit a counter-dispute if buyer's claim is invalid

[CTAs]
[View Dispute Details] [Respond Now]

Questions? Contact admin@dreamcrowd.com
```

---

## Acceptance Criteria

- [ ] Teacher receives email within 5 minutes of dispute
- [ ] Admin receives email within 5 minutes
- [ ] Email clearly states 48-hour deadline
- [ ] Dispute reason shown verbatim
- [ ] Links to dispute details work
- [ ] Logged for audit trail

---

## Dependencies

- ✅ `DisputeOrder` model exists
- ✅ Dispute workflow implemented
- 🔲 Teacher dispute response UI (for CTA link)

---

## Implementation Plan

1. Create mail classes (1 hour)
2. Design email templates (1.5 hours)
3. Add model event (30 min)
4. Testing (1 hour)

**Total:** 4 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
