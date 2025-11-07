# PRD: Gig Status Change Notifications

**Requirement ID:** REQ-013
**Feature Name:** Gig Status Change Notifications (Teacher)
**Priority:** MEDIUM
**Category:** Notifications - Gig Management
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

Notify teachers when their gig status changes automatically (Active → Paused → Closed by system command).

---

## Functional Requirements

### FR-1: Gig Status Change Email
**Recipient:** Teacher
**Trigger:** `UpdateTeacherGigStatus.php` command changes status

**Content:**
- "Your gig status has changed"
- Gig name and ID
- Old status → New status
- Reason for change:
  - "End date reached"
  - "Marked inactive due to no bookings in 90 days"
  - "Manually paused by you"
- Next steps (how to reactivate)
- [View Gig] CTA

---

## Technical Specifications

### Modify Command
**File:** `app/Console/Commands/UpdateTeacherGigStatus.php`

```php
// After status update
$gig->update(['status' => 'paused']);

// Send notification
Mail::to($gig->user->email)->queue(
    new GigStatusChangedTeacher($gig, $oldStatus, $reason)
);
```

### Files to Create
- `app/Mail/GigStatusChangedTeacher.php`
- `resources/views/emails/gig-status-changed.blade.php`

---

## Acceptance Criteria

- [ ] Email sent when status changes
- [ ] Reason clearly explained
- [ ] Reactivation instructions included
- [ ] Link to gig management works

---

## Implementation Plan

1. Create mail class (1 hour)
2. Design email template (1.5 hours)
3. Integrate into command (1 hour)
4. Testing (30 min)

**Total:** 4 hours

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
