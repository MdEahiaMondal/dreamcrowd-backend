# PRD: New Message Notifications

**Requirement ID:** REQ-012
**Feature Name:** New Message Notifications
**Priority:** MEDIUM
**Category:** Notifications - Communication
**Effort Estimate:** 6 hours
**Status:** Not Started

---

## Overview

Email notifications when users receive new messages in platform messaging system.

**Prerequisites:** Verify messaging system exists. If not, this requirement may be deferred.

---

## Functional Requirements

### FR-1: New Message Email
**Trigger:** New message record created in `messages` table

**Content:**
- "You have a new message"
- Sender name
- Message preview (first 100 characters)
- [View Message] CTA
- [Reply] CTA
- Note: "Turn off email notifications in settings"

---

## Technical Specifications

### Model Event (if Message model exists)
**File:** `app/Models/Message.php`

```php
protected static function booted()
{
    static::created(function ($message) {
        if ($message->recipient_id) {
            Mail::to($message->recipient->email)->queue(
                new NewMessageNotification($message)
            );
        }
    });
}
```

### Files to Create
- `app/Mail/NewMessageNotification.php`
- `resources/views/emails/new-message.blade.php`

### Optional Enhancement
Add notification preferences:
- Users can toggle message email notifications
- Add `email_on_message` boolean to `users` table

---

## Acceptance Criteria

- [ ] Email sent within 5 minutes of new message
- [ ] Sender name shown
- [ ] Message preview included
- [ ] Link to inbox works
- [ ] Users can opt-out via settings

---

## Implementation Plan

1. Verify messaging system exists (30 min)
2. Create mail class (1 hour)
3. Design email template (1 hour)
4. Add model event (1 hour)
5. Add notification preferences UI (2 hours)
6. Testing (30 min)

**Total:** 6 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation (pending messaging system verification)
**Last Updated:** 2025-11-06
