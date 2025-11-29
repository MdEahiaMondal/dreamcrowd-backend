# PRD: Review Reminder Notifications

**Requirement ID:** REQ-011
**Feature Name:** Review Reminder Notifications
**Priority:** MEDIUM
**Category:** Notifications - Engagement
**Effort Estimate:** 5 hours
**Status:** Not Started

---

## Overview

Remind buyers to leave reviews after order completion (48 hours after delivery). Increases review rate by 35-40%.

---

## Functional Requirements

### FR-1: Review Reminder Email
**Recipient:** Buyer
**Trigger:** Scheduled command runs daily, finds completed orders without reviews (> 48 hours old)

**Content:**
- "How was your class with [Teacher Name]?"
- Class details
- "Your feedback helps other students"
- Star rating quick links (1-5 stars)
- [Write Review] CTA
- Unsubscribe option

---

## Technical Specifications

### New Scheduled Command
**File:** `app/Console/Commands/SendReviewReminders.php`

```php
protected $signature = 'reviews:send-reminders';

public function handle()
{
    $orders = BookOrder::where('status', 3) // Completed
        ->whereDoesntHave('review')
        ->where('action_date', '<=', now()->subHours(48))
        ->where('action_date', '>=', now()->subDays(30)) // Don't spam old orders
        ->get();

    foreach ($orders as $order) {
        Mail::to($order->user->email)->queue(
            new ReviewReminderBuyer($order)
        );

        // Mark as reminded (add flag to avoid duplicate reminders)
        $order->update(['review_reminder_sent' => true]);
    }
}
```

### Register in Kernel
```php
$schedule->command('reviews:send-reminders')
         ->daily()
         ->at('10:00');
```

### Files to Create
- `app/Console/Commands/SendReviewReminders.php`
- `app/Mail/ReviewReminderBuyer.php`
- `resources/views/emails/review-reminder.blade.php`

### Database Addition
Add column to `book_orders` table:
```php
$table->boolean('review_reminder_sent')->default(false);
```

---

## Email Template

```html
<!-- Header -->
⭐ How was your class?

<!-- Content -->
Hi [Name],

You recently completed a class with [Teacher Name]. We'd love to hear about your experience!

[Class Box]
📚 [Class Name]
👨‍🏫 [Teacher Name]
📅 Completed on [Date]

Your review helps:
✓ Other students make informed decisions
✓ Teachers improve their classes
✓ Build a trusted learning community

[Quick Rating]
How would you rate this class?
[⭐] [⭐⭐] [⭐⭐⭐] [⭐⭐⭐⭐] [⭐⭐⭐⭐⭐]

[CTA]
[Write Full Review]

Takes less than 2 minutes!
```

---

## Acceptance Criteria

- [ ] Command runs daily at 10:00 AM
- [ ] Only sends to completed orders 48+ hours old
- [ ] Only sends once per order
- [ ] Doesn't send to orders > 30 days old
- [ ] Star rating links work
- [ ] Unsubscribe link present

---

## Implementation Plan

1. Create command (1.5 hours)
2. Create mail class (1 hour)
3. Design email template (1.5 hours)
4. Add database column (30 min)
5. Testing (1 hour)

**Total:** 5 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
