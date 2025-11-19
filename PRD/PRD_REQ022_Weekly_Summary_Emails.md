# PRD: Weekly Summary Email Digests

**Requirement ID:** REQ-022
**Feature Name:** Weekly Summary Email Digests
**Priority:** LOW (Optional)
**Category:** Notifications - Engagement
**Effort Estimate:** 6 hours
**Status:** Not Started

---

## Overview

Weekly digest emails for users and sellers summarizing activity.

---

## Functional Requirements

### FR-1: Buyer Weekly Summary
**Sent:** Every Monday at 9:00 AM
**Content:**
- Upcoming classes this week
- Recommended new classes
- Platform updates/deals
- Review reminders
- Completed classes last week

---

### FR-2: Seller Weekly Summary
**Sent:** Every Monday at 9:00 AM
**Content:**
- **Weekly earnings:** $X.XX
- **New bookings:** X classes
- **Reviews received:** X reviews (avg rating)
- **Profile views:** X views
- **Upcoming classes:** List
- Tips for improvement

---

## Technical Specifications

### Scheduled Command
**File:** `app/Console/Commands/SendWeeklySummaries.php`

```php
protected $signature = 'summaries:send-weekly';

public function handle()
{
    // Send to buyers
    $activeUsers = User::where('account_type', 'user')
        ->where('last_login', '>=', now()->subDays(30))
        ->get();

    foreach ($activeUsers as $user) {
        $summary = $this->calculateUserSummary($user);
        Mail::to($user->email)->queue(
            new WeeklySummaryUser($user, $summary)
        );
    }

    // Send to sellers
    $activeSellers = User::where('account_type', 'teacher')
        ->whereHas('teacherGigs')
        ->get();

    foreach ($activeSellers as $seller) {
        $summary = $this->calculateSellerSummary($seller);
        Mail::to($seller->email)->queue(
            new WeeklySummarySeller($seller, $summary)
        );
    }
}

private function calculateUserSummary($user)
{
    return [
        'upcoming_classes' => $user->bookOrders()
            ->where('status', 1)
            ->whereBetween('created_at', [now(), now()->addWeek()])
            ->count(),
        'completed_last_week' => $user->bookOrders()
            ->where('status', 3)
            ->whereBetween('action_date', [now()->subWeek(), now()])
            ->count(),
        'recommended_classes' => TeacherGig::inRandomOrder()->limit(3)->get()
    ];
}

private function calculateSellerSummary($seller)
{
    $weekStart = now()->subWeek()->startOfWeek();
    $weekEnd = now()->subWeek()->endOfWeek();

    return [
        'earnings' => BookOrder::where('teacher_id', $seller->id)
            ->whereBetween('action_date', [$weekStart, $weekEnd])
            ->sum('seller_earnings'),
        'new_bookings' => BookOrder::where('teacher_id', $seller->id)
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count(),
        'reviews_received' => ServiceReviews::whereHas('bookOrder', function($q) use ($seller) {
                $q->where('teacher_id', $seller->id);
            })
            ->whereBetween('created_at', [$weekStart, $weekEnd])
            ->count(),
        'avg_rating' => ServiceReviews::whereHas('bookOrder', function($q) use ($seller) {
                $q->where('teacher_id', $seller->id);
            })->avg('stars')
    ];
}
```

### Register in Kernel
```php
$schedule->command('summaries:send-weekly')
         ->weekly()
         ->mondays()
         ->at('09:00');
```

### Files to Create
- `app/Console/Commands/SendWeeklySummaries.php`
- `app/Mail/WeeklySummaryUser.php`
- `app/Mail/WeeklySummarySeller.php`
- Email templates (2 files)

---

## Acceptance Criteria

- [ ] Sent every Monday at 9:00 AM
- [ ] Users get personalized summary
- [ ] Sellers get performance summary
- [ ] Users can opt-out in settings
- [ ] Unsubscribe link included

---

## Implementation Plan

1. Create command with calculation logic (2 hours)
2. Create 2 mail classes (1 hour)
3. Design 2 email templates (2 hours)
4. Register in scheduler (15 min)
5. Add opt-out preference (45 min)
6. Testing (1 hour)

**Total:** 6 hours

---

**Document Status:** ✅ Ready for Implementation (Optional - Phase 2)
**Last Updated:** 2025-11-06
