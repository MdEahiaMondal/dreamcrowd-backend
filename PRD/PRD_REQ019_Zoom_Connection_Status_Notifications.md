# PRD: Zoom Connection Status Notifications

**Requirement ID:** REQ-019
**Feature Name:** Zoom Connection Status Notifications (Teacher)
**Priority:** MEDIUM
**Category:** Notifications - System Status
**Effort Estimate:** 2 hours
**Status:** Not Started

---

## Overview

Notify teacher when Zoom connection fails or token expires.

---

## Functional Requirements

### FR-1: Zoom Connection Failed Email
**Trigger:** `RefreshZoomTokens.php` command fails to refresh token

**Content:**
- "Action Required: Zoom connection issue"
- Problem description
- Impact: "New classes won't have Zoom meetings"
- [Reconnect Zoom] CTA
- Support contact

---

### FR-2: Zoom Token Expiring Soon
**Trigger:** Token expires in 7 days

**Content:**
- "Your Zoom connection expires soon"
- Expiry date
- [Reconnect Now] CTA

---

## Technical Specifications

### Modify Refresh Command
**File:** `app/Console/Commands/RefreshZoomTokens.php`

```php
// After refresh attempt fails
if (!$refreshSuccessful) {
    Mail::to($teacher->email)->queue(
        new ZoomConnectionFailedTeacher($teacher, $errorMessage)
    );

    \Log::error('Zoom token refresh failed', [
        'teacher_id' => $teacher->id,
        'error' => $errorMessage
    ]);
}
```

### Files to Create
- `app/Mail/ZoomConnectionFailedTeacher.php`
- `resources/views/emails/zoom-connection-failed.blade.php`

---

## Acceptance Criteria

- [ ] Email sent when token refresh fails
- [ ] Teacher can reconnect via email link
- [ ] Impact clearly explained
- [ ] Support contact provided

---

## Implementation Plan

1. Create mail class (45 min)
2. Design email template (45 min)
3. Integrate into RefreshZoomTokens command (15 min)
4. Testing (15 min)

**Total:** 2 hours

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
