# PRD: Class Cancellation Notifications

**Requirement ID:** REQ-003
**Feature Name:** Class Cancellation Notifications
**Priority:** HIGH
**Category:** Notifications - Transactional
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

### Problem Statement
When a class is cancelled (by teacher, buyer, or system), neither party receives email notification. This creates:
- ❌ Confusion about class status
- ❌ Buyers showing up for cancelled classes
- ❌ Lack of clarity on refund status
- ❌ Increased support tickets

### Proposed Solution
Implement automated cancellation notifications to:
1. **Buyer** - Informing of cancellation with refund details
2. **Seller** - Notifying of cancellation with impact on earnings
3. **Admin** - Alerting of cancellations for monitoring

### Expected Outcome
- ✅ Clear communication of cancellations
- ✅ Automatic refund status updates
- ✅ Reduced support inquiries
- ✅ Improved user satisfaction

---

## Business Justification

### Impact Analysis
| Metric | Current | Target |
|--------|---------|--------|
| Support tickets (cancellations) | 40/month | 15/month (-63%) |
| User satisfaction after cancellation | 3.5/5 | 4.3/5 |
| Refund processing time | 5 days | 2 days (due to clarity) |

---

## User Stories

### User Story 1: Buyer Notified of Cancellation
**As a** buyer whose class was cancelled
**I want to** receive immediate notification with refund details
**So that** I understand what happened and when I'll get my money back

**Acceptance Criteria:**
- Email within 5 minutes of cancellation
- Explains who cancelled (teacher/system)
- Shows refund amount and timeline
- Provides booking alternatives
- Includes support contact

---

### User Story 2: Seller Notified of Cancellation
**As a** seller whose class was cancelled
**I want to** know when and why a class was cancelled
**So that** I can manage my schedule and understand earnings impact

**Acceptance Criteria:**
- Email within 5 minutes
- Shows cancellation reason
- Explains impact on earnings
- Lists cancellation policy
- Provides rescheduling option (if buyer-initiated)

---

## Functional Requirements

### FR-1: Buyer Cancellation Email
**Content:**
- Cancellation notice with empathy
- Cancelled class details
- Cancellation reason
- **Refund information:**
  - Amount: $X.XX
  - Method: Original payment method
  - Timeline: 5-10 business days
  - Status: Processing/Completed
- Alternative class suggestions
- Rebooking CTA button
- Support contact

**Trigger:** `CancelOrder` record created OR `BookOrder` status set to 4 (cancelled)

---

### FR-2: Seller Cancellation Email
**Content:**
- Cancellation notice
- Cancelled class details
- Cancellation initiator (buyer/admin/system)
- Reason for cancellation
- **Earnings impact:**
  - Expected earnings: $X.XX
  - Cancellation fee (if applicable): $X.XX
  - Net impact: -$X.XX
- Cancellation policy reminder
- Option to contact buyer (if rescheduleable)

**Trigger:** Same as FR-1

---

### FR-3: Cancellation Reasons
Map technical reasons to user-friendly messages:
- `buyer_requested` → "You requested to cancel this class"
- `seller_requested` → "The teacher cancelled this class"
- `auto_cancelled` → "This class was automatically cancelled (no payment)"
- `dispute_refund` → "Class cancelled due to dispute resolution"
- `teacher_unavailable` → "Teacher is no longer available"

---

## Technical Specifications

### Files to Create

#### Mail Classes
- `app/Mail/ClassCancelledBuyer.php`
- `app/Mail/ClassCancelledSeller.php`

#### Email Templates
- `resources/views/emails/class-cancelled-buyer.blade.php`
- `resources/views/emails/class-cancelled-seller.blade.php`

#### Model Event (Add to `app/Models/CancelOrder.php`)
```php
protected static function booted()
{
    static::created(function ($cancelOrder) {
        $order = $cancelOrder->bookOrder;

        // Send to buyer
        Mail::to($order->user->email)
            ->queue(new ClassCancelledBuyer($cancelOrder));

        // Send to seller
        Mail::to($order->teacherGig->user->email)
            ->queue(new ClassCancelledSeller($cancelOrder));
    });
}
```

---

## Acceptance Criteria

- [ ] Buyer receives cancellation email within 5 minutes
- [ ] Seller receives cancellation email within 5 minutes
- [ ] Refund amount and timeline clearly stated
- [ ] Cancellation reason is user-friendly
- [ ] Alternative class suggestions included (buyer email)
- [ ] Earnings impact clearly shown (seller email)
- [ ] Support links work correctly
- [ ] Emails are mobile-responsive

---

## Dependencies

### Technical
- ✅ `CancelOrder` model exists
- ✅ `BookOrder` model with status field
- ✅ Refund processing logic (Stripe)

### Business
- 🔲 Cancellation policy defined
- 🔲 Refund timeline confirmed (5-10 days)
- 🔲 Email templates approved

---

## Implementation Plan

1. Create mail classes (1 hour)
2. Design email templates (1.5 hours)
3. Add model events (30 min)
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
