# PRD: Dispute Resolved Notifications

**Requirement ID:** REQ-007
**Feature Name:** Dispute Resolved Notifications
**Priority:** HIGH
**Category:** Notifications - Dispute Management
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

### Problem Statement
When dispute is resolved (approved, rejected, or auto-processed), parties don't receive notification of outcome, causing confusion about refund status.

### Proposed Solution
Send automated notifications to buyer and seller when dispute is resolved, explaining the outcome and next steps.

---

## User Stories

**As a** buyer whose dispute was resolved
**I want to** know the outcome and refund status
**So that** I understand what happened and when I'll get my money

**As a** seller whose dispute was resolved
**I want to** know the outcome and earnings impact
**So that** I can understand the resolution

---

## Functional Requirements

### FR-1: Buyer - Dispute Approved (Refund Granted)
**Content:**
- "Your dispute has been resolved in your favor"
- Dispute ID and order details
- Resolution: Approved
- **Refund details:**
  - Amount: $X.XX
  - Method: Original payment
  - Timeline: 5-10 business days
  - Refund ID: ref_xxxxx
- Resolution reason (admin comment or auto-processed)
- [View Transaction] CTA

**Trigger:** Dispute status changes to approved OR auto-refund processed

---

### FR-2: Buyer - Dispute Rejected
**Content:**
- "Your dispute has been reviewed"
- Dispute ID and order details
- Resolution: Not approved
- Reason for rejection
- **What this means:**
  - No refund will be issued
  - Order stands as completed
  - Payment remains with seller
- Appeal process (if available)
- [Contact Support] CTA

---

### FR-3: Seller - Dispute Resolved (Buyer Won)
**Content:**
- "Dispute resolved - Refund issued"
- Order and dispute details
- **Impact:**
  - Refund amount: $X.XX
  - Your earnings: $0.00 (refunded)
  - Resolution reason
- What happened
- [View Details] CTA

---

### FR-4: Seller - Dispute Resolved (Seller Won)
**Content:**
- "Good news - Dispute rejected"
- Order and dispute details
- **Impact:**
  - Your earnings: $X.XX (protected)
  - Buyer's dispute was not approved
  - Payout remains on schedule
- [View Details] CTA

---

## Technical Specifications

### Files to Modify
**Modify:** `app/Console/Commands/AutoHandleDisputes.php`

```php
// After refund processed
$refund = \Stripe\Refund::create([...]);

// Notify buyer (approved)
Mail::to($order->user->email)->queue(
    new DisputeResolvedBuyer($dispute, 'approved', $refund)
);

// Notify seller (approved - buyer won)
Mail::to($order->teacherGig->user->email)->queue(
    new DisputeResolvedSeller($dispute, 'approved')
);
```

**Modify:** `app/Http/Controllers/AdminController.php` (manual dispute resolution)

```php
// When admin manually resolves dispute
if ($request->resolution == 'approved') {
    // Process refund
    // Send emails
    Mail::to($order->user->email)->queue(
        new DisputeResolvedBuyer($dispute, 'approved', $refund)
    );
    Mail::to($seller->email)->queue(
        new DisputeResolvedSeller($dispute, 'approved')
    );
} else {
    // Dispute rejected
    Mail::to($order->user->email)->queue(
        new DisputeResolvedBuyer($dispute, 'rejected', null, $request->reason)
    );
    Mail::to($seller->email)->queue(
        new DisputeResolvedSeller($dispute, 'rejected')
    );
}
```

### Files to Create
- `app/Mail/DisputeResolvedBuyer.php`
- `app/Mail/DisputeResolvedSeller.php`
- `resources/views/emails/dispute-resolved-buyer-approved.blade.php`
- `resources/views/emails/dispute-resolved-buyer-rejected.blade.php`
- `resources/views/emails/dispute-resolved-seller.blade.php`

---

## Mail Class Structure

```php
<?php

namespace App\Mail;

use App\Models\DisputeOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisputeResolvedBuyer extends Mailable
{
    use Queueable, SerializesModels;

    public $dispute;
    public $resolution; // 'approved' or 'rejected'
    public $refund; // Stripe refund object (if approved)
    public $reason; // Reason for rejection (if rejected)

    public function __construct(DisputeOrder $dispute, $resolution, $refund = null, $reason = null)
    {
        $this->dispute = $dispute;
        $this->resolution = $resolution;
        $this->refund = $refund;
        $this->reason = $reason;
    }

    public function build()
    {
        $subject = $this->resolution == 'approved'
            ? 'Your dispute has been approved - Refund processing'
            : 'Dispute resolution update';

        $view = $this->resolution == 'approved'
            ? 'emails.dispute-resolved-buyer-approved'
            : 'emails.dispute-resolved-buyer-rejected';

        return $this->subject($subject)->view($view);
    }
}
```

---

## Acceptance Criteria

- [ ] Buyer receives email when dispute approved (refund granted)
- [ ] Buyer receives email when dispute rejected
- [ ] Seller receives email for both outcomes
- [ ] Emails sent for automatic AND manual resolutions
- [ ] Refund details accurate (amount, ID, timeline)
- [ ] Email tone is empathetic for rejected disputes
- [ ] All emails logged for audit

---

## Dependencies

- ✅ `AutoHandleDisputes.php` command exists
- ✅ Admin dispute resolution controller exists
- ✅ Stripe refund API integrated
- 🔲 Appeal process defined (for rejected disputes)

---

## Implementation Plan

1. Create mail classes with resolution logic (1.5 hours)
2. Design 3 email templates (1.5 hours)
3. Integrate into AutoHandleDisputes (30 min)
4. Integrate into AdminController (30 min)
5. Testing both auto and manual flows (1 hour)

**Total:** 4 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
