# PRD: Payout Processed Notifications

**Requirement ID:** REQ-015
**Feature Name:** Payout Processed Notifications (Seller)
**Priority:** MEDIUM
**Category:** Notifications - Financial
**Effort Estimate:** 5 hours
**Status:** Not Started

---

## Overview

Notify sellers when admin processes their payouts.

---

## Functional Requirements

### FR-1: Payout Confirmation Email
**Recipient:** Seller
**Trigger:** Admin marks payout as processed

**Content:**
- "Your payout has been processed!"
- Payout details:
  - Amount: $X.XX
  - Payout date
  - Transaction/Payout ID
  - Expected arrival: 2-5 business days
- Orders included in payout (list)
- Payment method: Bank account ending in XXXX
- [View Transaction History] CTA
- PDF invoice attachment (optional)

---

## Technical Specifications

### Admin Controller Modification
**File:** `app/Http/Controllers/AdminController.php` (payout processing method)

```php
public function processPayout(Request $request)
{
    $seller = User::findOrFail($request->seller_id);
    $orders = BookOrder::whereIn('id', $request->order_ids)->get();
    $totalAmount = $orders->sum('seller_earnings');

    // Create payout record
    $payout = Payout::create([
        'seller_id' => $seller->id,
        'amount' => $totalAmount,
        'status' => 'processed',
        'processed_by' => auth()->id(),
        'processed_at' => now(),
        'order_ids' => $request->order_ids
    ]);

    // Mark orders as paid out
    BookOrder::whereIn('id', $request->order_ids)
        ->update(['payout_status' => 'paid']);

    // Send confirmation email
    Mail::to($seller->email)->queue(
        new PayoutProcessedSeller($payout, $orders)
    );

    return back()->with('success', 'Payout processed successfully');
}
```

### Database Addition
Create `payouts` table if doesn't exist:
```php
Schema::create('payouts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('seller_id')->constrained('users');
    $table->decimal('amount', 10, 2);
    $table->string('status'); // processed, failed
    $table->json('order_ids');
    $table->foreignId('processed_by')->nullable()->constrained('users');
    $table->timestamp('processed_at')->nullable();
    $table->string('payout_method')->nullable();
    $table->string('transaction_reference')->nullable();
    $table->timestamps();
});
```

### Files to Create
- `app/Models/Payout.php`
- `app/Mail/PayoutProcessedSeller.php`
- `resources/views/emails/payout-processed.blade.php`
- Migration: `create_payouts_table.php`

---

## Email Template

```html
<!-- Header -->
💰 Payout Processed!

<!-- Content -->
Hi [Seller Name],

Great news! Your payout has been processed.

[Payout Details Box]
Amount: $X,XXX.XX
Payout Date: January 15, 2025
Payout ID: PAY-12345
Payment Method: Bank account ****6789

Expected Arrival: 2-5 business days

[Orders Included]
This payout includes earnings from:
• Order #123 - $XX.XX
• Order #124 - $XX.XX
• Order #125 - $XX.XX
Total: $X,XXX.XX

[CTAs]
[View Transaction History] [Download Invoice (PDF)]

Questions about your payout? Contact support@dreamcrowd.com
```

---

## Acceptance Criteria

- [ ] Email sent immediately after payout processing
- [ ] Payout amount accurate
- [ ] All orders included listed
- [ ] Expected arrival timeline stated
- [ ] PDF invoice attached (optional)
- [ ] Payout ID for reference included

---

## Implementation Plan

1. Create/verify Payout model and table (1 hour)
2. Create mail class (1 hour)
3. Design email template (1 hour)
4. Integrate into admin payout controller (1 hour)
5. Add PDF invoice generation (optional) (30 min)
6. Testing (30 min)

**Total:** 5 hours

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
