# PRD: Reschedule Approved/Rejected Notifications

**Requirement ID:** REQ-009
**Feature Name:** Reschedule Approved/Rejected Notifications
**Priority:** HIGH
**Category:** Notifications - Scheduling
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

### Problem Statement
When teacher approves or rejects reschedule request, buyer doesn't receive notification of the decision, causing confusion about class schedule.

### Proposed Solution
Automatically notify buyer when teacher responds to their reschedule request (approved, rejected, or alternative suggested).

---

## User Stories

**As a** buyer who requested reschedule
**I want to** know if my request was approved or rejected
**So that** I know when my class is scheduled

---

## Functional Requirements

### FR-1: Reschedule Approved Email
**Content:**
- "Your reschedule request has been approved!"
- Order and class details
- **Updated schedule:**
  - New Date: [Date]
  - New Time: [Time]
  - Duration: [X] minutes
- Teacher's note (if provided)
- [Add to Calendar] button
- [View Class Details] CTA
- Note: "You'll receive a class reminder 24 hours before"

**Trigger:** Teacher approves reschedule (reschedule status updated)

---

### FR-2: Reschedule Rejected Email
**Content:**
- "About your reschedule request"
- Order and class details
- **Status:** Request not approved
- Teacher's reason (if provided)
- **Original schedule remains:**
  - Date: [Original Date]
  - Time: [Original Time]
- Options:
  - Keep original schedule
  - Submit new reschedule request for different date
  - Cancel class (refund policy applies)
- [Request Different Date] CTA
- [Keep Original Schedule] CTA

**Trigger:** Teacher rejects reschedule

---

### FR-3: Alternative Schedule Suggested Email
**Content:**
- "Teacher suggested an alternative time"
- Original and requested schedules
- **Teacher's suggested alternative:**
  - Date: [Alt Date]
  - Time: [Alt Time]
- Teacher's note
- [Accept Alternative] CTA
- [Decline & Request Another] CTA

**Trigger:** Teacher suggests alternative

---

## Technical Specifications

### Controller Modification
**File:** `app/Http/Controllers/TeacherController.php` (or reschedule handler)

```php
public function handleReschedule(Request $request, $rescheduleId)
{
    $reschedule = ClassReschedule::findOrFail($rescheduleId);
    $order = $reschedule->classDate->bookOrder;
    $buyer = $order->user;

    if ($request->action == 'approve') {
        // Update class date
        $reschedule->update(['status' => 'approved']);
        $reschedule->classDate->update([
            'class_date' => $request->new_date
        ]);

        // Notify buyer - approved
        Mail::to($buyer->email)->queue(
            new RescheduleApprovedBuyer($reschedule, $request->teacher_note)
        );

    } elseif ($request->action == 'reject') {
        $reschedule->update(['status' => 'rejected']);

        // Notify buyer - rejected
        Mail::to($buyer->email)->queue(
            new RescheduleRejectedBuyer($reschedule, $request->rejection_reason)
        );

    } elseif ($request->action == 'suggest_alternative') {
        $reschedule->update([
            'status' => 'alternative_suggested',
            'suggested_date' => $request->alternative_date
        ]);

        // Notify buyer - alternative suggested
        Mail::to($buyer->email)->queue(
            new RescheduleAlternativeSuggested($reschedule, $request->alternative_date, $request->note)
        );
    }

    return back()->with('success', 'Reschedule request processed');
}
```

### Files to Create
- `app/Mail/RescheduleApprovedBuyer.php`
- `app/Mail/RescheduleRejectedBuyer.php`
- `app/Mail/RescheduleAlternativeSuggested.php` (optional)
- `resources/views/emails/reschedule-approved.blade.php`
- `resources/views/emails/reschedule-rejected.blade.php`
- `resources/views/emails/reschedule-alternative-suggested.blade.php` (optional)

---

## Email Template (Approved)

```html
<!-- Header -->
✓ Reschedule Approved!

<!-- Content -->
Hi [Buyer Name],

Great news! Your teacher has approved your reschedule request.

[Updated Schedule Box - Green Border]
📅 Your New Class Schedule

Class: [Class Name]
Teacher: [Teacher Name]
New Date: Wednesday, January 17, 2025
New Time: 3:30 PM - 4:30 PM
Duration: 60 minutes

[Teacher's Note Box]
💬 From your teacher:
"[Teacher's note or default: 'See you at the new time!']"

[CTAs]
[Add to Calendar] [View Class Details]

Reminders:
• You'll receive a reminder 24 hours before class
• You'll get the Zoom link 30 minutes before class

Thank you for your flexibility!
```

---

## Email Template (Rejected)

```html
<!-- Header -->
About Your Reschedule Request

<!-- Content -->
Hi [Buyer Name],

Your teacher was unable to accommodate your reschedule request for the following class.

[Class Details]
Class: [Class Name]
Teacher: [Teacher Name]

[Original Schedule Remains - Blue Border]
📅 Your class is still scheduled for:
Date: Monday, January 15, 2025
Time: 2:00 PM - 3:00 PM

[Reason Box]
Teacher's Response:
"[Rejection reason or default: 'Unfortunately, I'm not available at the requested time.']"

[What You Can Do]
1. Keep your original schedule
2. Request a different date/time
3. Cancel the class (refund policy applies)

[CTAs]
[Request Different Date] [Keep Original Schedule]

Need help? Contact support@dreamcrowd.com
```

---

## Acceptance Criteria

- [ ] Buyer receives email within 5 minutes of teacher decision
- [ ] Email for approved shows new schedule clearly
- [ ] Email for rejected explains reason and options
- [ ] "Add to Calendar" works for approved reschedules
- [ ] All CTAs functional
- [ ] Teacher's notes included (if provided)

---

## Dependencies

- ✅ `ClassReschedule` model exists
- ✅ Teacher reschedule approval workflow exists
- 🔲 Buyer response UI (for alternative suggestions)
- 🔲 Calendar invite (.ics) generation

---

## Implementation Plan

1. Create 2-3 mail classes (1.5 hours)
2. Design email templates (1.5 hours)
3. Integrate into teacher approval controller (1 hour)
4. Testing all 3 scenarios (1 hour)

**Total:** 4 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
