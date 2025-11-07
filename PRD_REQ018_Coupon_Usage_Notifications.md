# PRD: Coupon Usage Notifications

**Requirement ID:** REQ-018
**Feature Name:** Coupon Usage Notifications
**Priority:** MEDIUM
**Category:** Notifications - Marketing
**Effort Estimate:** 3 hours
**Status:** Not Started

---

## Overview

Notify users when coupon is successfully applied or expires soon.

---

## Functional Requirements

### FR-1: Coupon Applied Confirmation
**Trigger:** Coupon successfully applied to order

**Content:**
- "Coupon applied successfully!"
- Coupon code
- Discount amount saved
- Order details
- [Complete Purchase] CTA

---

### FR-2: Coupon Expiring Soon
**Trigger:** Scheduled command finds coupons expiring in 3 days

**Content:**
- "Your coupon expires in 3 days!"
- Coupon code
- Discount percentage/amount
- Expiry date
- [Browse Classes] CTA

---

## Technical Specifications

### Coupon Application
**File:** `app/Models/CouponUsage.php`

```php
protected static function booted()
{
    static::created(function ($couponUsage) {
        Mail::to($couponUsage->user->email)->queue(
            new CouponAppliedNotification($couponUsage)
        );
    });
}
```

### Expiring Coupons Command
**File:** `app/Console/Commands/SendCouponExpiryReminders.php`

```php
protected $signature = 'coupons:send-expiry-reminders';

public function handle()
{
    $expiringCoupons = Coupon::where('expiry_date', '=', now()->addDays(3)->toDateString())
        ->where('status', 'active')
        ->get();

    foreach ($expiringCoupons as $coupon) {
        // Find users who have this coupon but haven't used it
        $eligibleUsers = User::whereDoesntHave('couponUsages', function($q) use ($coupon) {
            $q->where('coupon_id', $coupon->id);
        })->get();

        foreach ($eligibleUsers as $user) {
            Mail::to($user->email)->queue(
                new CouponExpiringNotification($coupon)
            );
        }
    }
}
```

### Files to Create
- `app/Mail/CouponAppliedNotification.php`
- `app/Mail/CouponExpiringNotification.php`
- Email templates (2 files)
- `app/Console/Commands/SendCouponExpiryReminders.php`

---

## Acceptance Criteria

- [ ] Confirmation sent when coupon applied
- [ ] Expiry reminder sent 3 days before
- [ ] Discount amount shown
- [ ] Only sent to eligible users
- [ ] Unsubscribe option included

---

## Implementation Plan

1. Create 2 mail classes (1 hour)
2. Design 2 email templates (1 hour)
3. Create expiry reminder command (45 min)
4. Testing (15 min)

**Total:** 3 hours

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
