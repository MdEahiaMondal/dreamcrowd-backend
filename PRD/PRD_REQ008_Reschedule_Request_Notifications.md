# PRD: Reschedule Request Notifications

**Requirement ID:** REQ-008
**Feature Name:** Class Reschedule Request Notifications
**Priority:** HIGH
**Category:** Notifications - Scheduling
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

### Problem Statement
When buyer requests to reschedule a class, teacher doesn't receive notification, causing:
- ❌ Delayed teacher response
- ❌ Buyer waiting without status update
- ❌ Missed rescheduling opportunities

### Proposed Solution
Automatically notify teacher when buyer submits reschedule request.

---

## User Stories

**As a** teacher
**I want to** receive email when student requests reschedule
**So that** I can review and respond promptly

---

## Functional Requirements

### FR-1: Teacher Reschedule Request Email
**Content:**
- "Reschedule request from [Student Name]"
- Order and class details
- **Original schedule:**
  - Date: [Original Date]
  - Time: [Original Time]
- **Requested new schedule:**
  - Date: [Requested Date]
  - Time: [Requested Time]
- Student's reason (if provided)
- [Approve Request] CTA
- [Decline Request] CTA
- [Suggest Alternative] CTA
- Note: "Please respond within 24 hours"

**Trigger:** `ClassReschedule` record created

---

## Technical Specifications

### Model Event
**File:** `app/Models/ClassReschedule.php`

```php
protected static function booted()
{
    static::created(function ($reschedule) {
        $classDate = $reschedule->classDate;
        $order = $classDate->bookOrder;
        $teacher = $order->teacherGig->user;

        // Notify teacher
        Mail::to($teacher->email)
            ->queue(new RescheduleRequestTeacher($reschedule));

        \Log::info('Reschedule requested', [
            'reschedule_id' => $reschedule->id,
            'order_id' => $order->id,
            'teacher_id' => $teacher->id
        ]);
    });
}
```

### Files to Create
- `app/Mail/RescheduleRequestTeacher.php`
- `resources/views/emails/reschedule-request-teacher.blade.php`

---

## Email Template

```html
<!-- Header -->
📅 Reschedule Request

<!-- Content -->
Hi [Teacher Name],

[Student First Name] has requested to reschedule their class.

[Class Details]
Order #: 12345
Class: [Class Name]
Duration: 60 minutes

[Schedule Comparison]
Original Date/Time:
📅 Monday, Jan 15, 2025 at 2:00 PM

Requested New Date/Time:
📅 Wednesday, Jan 17, 2025 at 3:30 PM

[Student's Reason]
"[Reason provided by student, or 'No reason provided']"

[Action Required]
Please respond within 24 hours to confirm availability.

[CTAs - 3 Buttons]
[✓ Approve] [✗ Decline] [📝 Suggest Alternative]

Questions? Contact support@dreamcrowd.com
```

---

## Acceptance Criteria

- [ ] Teacher receives email within 5 minutes of request
- [ ] Email shows original and requested schedules side-by-side
- [ ] Student's reason included (if provided)
- [ ] All 3 action buttons work correctly
- [ ] Logged for tracking

---

## Dependencies

- ✅ `ClassReschedule` model exists
- ✅ Reschedule request workflow exists
- 🔲 Teacher reschedule approval/decline UI (for CTAs)

---

## Implementation Plan

1. Create mail class (1 hour)
2. Design email template with schedule comparison (1.5 hours)
3. Add model event (30 min)
4. Create/verify approval/decline routes (1 hour)
5. Testing (1 hour)

**Total:** 4 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
