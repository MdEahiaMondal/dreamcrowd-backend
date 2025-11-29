# PRD: Refund Processed Notifications

**Requirement ID:** REQ-004
**Feature Name:** Refund Processed Notifications
**Priority:** HIGH
**Category:** Notifications - Financial
**Effort Estimate:** 3 hours
**Status:** Not Started

---

## Overview

### Problem Statement
Users do not receive confirmation when refunds are processed, leading to:
- ❌ Uncertainty about refund status
- ❌ Support tickets asking "When will I get my money back?"
- ❌ Lack of trust in refund process

### Proposed Solution
Send automated email when Stripe refund is successfully processed, confirming:
- Refund amount
- Refund method (original payment source)
- Expected arrival timeline
- Transaction reference

---

## User Stories

**As a** buyer who received a refund
**I want to** receive email confirmation with refund details
**So that** I know the refund was processed and when to expect it

---

## Functional Requirements

### FR-1: Refund Confirmation Email
**Content:**
- Refund confirmation notice
- Original order details
- **Refund details:**
  - Amount refunded: $X.XX
  - Refund ID: ref_xxxxx
  - Original payment method: Visa ****1234
  - Expected arrival: 5-10 business days
- Reason for refund (cancellation/dispute/error)
- Support contact for questions

**Trigger:** After successful `\Stripe\Refund::create()` in `AutoHandleDisputes.php` or manual refund

---

## Technical Specifications

### Files to Modify/Create

**Modify:** `app/Console/Commands/AutoHandleDisputes.php`
```php
// After successful refund
$refund = \Stripe\Refund::create([
    'payment_intent' => $paymentIntentId,
    'amount' => $refundAmount
]);

// Send confirmation email
Mail::to($order->user->email)->queue(
    new RefundProcessed($order, $refund)
);
```

**Create:** `app/Mail/RefundProcessed.php`
**Create:** `resources/views/emails/refund-processed.blade.php`

---

## Email Template Structure

```html
<!-- Header -->
✓ Refund Processed

<!-- Content -->
Hi [First Name],

Good news! Your refund has been processed.

[Order Details Box]
Order #: 12345
Class: [Class Name]
Original Amount: $100.00

[Refund Details Box]
Refund Amount: $100.00
Refund ID: ref_abc123
Payment Method: Visa ****1234
Expected Arrival: 5-10 business days

[Reason Box]
Reason: Class cancellation

[CTA]
[View Transaction Details]

Questions? Contact support@dreamcrowd.com
```

---

## Acceptance Criteria

- [ ] Email sent immediately after Stripe refund success
- [ ] Email contains refund amount, ID, and timeline
- [ ] Email sent for both automatic and manual refunds
- [ ] Email includes link to transaction details
- [ ] Delivery rate > 98%

---

## Dependencies

- ✅ `AutoHandleDisputes.php` command exists
- ✅ Stripe refund API integrated
- ✅ `BookOrder` and `Transaction` models exist

---

## Implementation Plan

1. Create `RefundProcessed` mail class (45 min)
2. Design email template (45 min)
3. Add to `AutoHandleDisputes.php` (30 min)
4. Testing (45 min)

**Total:** 3 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
