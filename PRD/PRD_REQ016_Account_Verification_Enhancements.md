# PRD: Account Verification Enhancements

**Requirement ID:** REQ-016
**Feature Name:** Account Verification Email Series
**Priority:** MEDIUM
**Category:** Notifications - Onboarding
**Effort Estimate:** 4 hours
**Status:** Not Started

---

## Overview

Enhanced onboarding email series: Welcome email, verification reminder, verification success.

---

## Functional Requirements

### FR-1: Welcome Email (New User Registration)
**Trigger:** User account created

**Content:**
- "Welcome to DreamCrowd!"
- Getting started guide
- Platform features overview
- [Verify Email] CTA
- [Browse Classes] CTA

---

### FR-2: Verification Reminder
**Trigger:** Account not verified after 24 hours

**Content:**
- "Please verify your email"
- Benefits of verification
- [Verify Now] CTA
- Resend verification link

---

### FR-3: Verification Success
**Trigger:** Email verified

**Content:**
- "Email verified successfully!"
- Next steps
- Platform tour
- Recommended classes

---

## Technical Specifications

### Registration Controller
**File:** `app/Http/Controllers/Auth/RegisterController.php`

```php
// After user creation
Mail::to($user->email)->queue(new WelcomeNewUser($user));
```

### Verification Reminder Command
**File:** `app/Console/Commands/SendVerificationReminders.php`

```php
protected $signature = 'users:send-verification-reminders';

public function handle()
{
    $unverifiedUsers = User::whereNull('email_verified_at')
        ->where('created_at', '<=', now()->subHours(24))
        ->where('created_at', '>=', now()->subDays(7))
        ->get();

    foreach ($unverifiedUsers as $user) {
        Mail::to($user->email)->queue(
            new EmailVerificationReminder($user)
        );
    }
}
```

### Files to Create
- `app/Mail/WelcomeNewUser.php`
- `app/Mail/EmailVerificationReminder.php`
- `app/Mail/EmailVerifiedSuccess.php`
- Email templates (3 files)
- `app/Console/Commands/SendVerificationReminders.php`

---

## Acceptance Criteria

- [ ] Welcome email sent on registration
- [ ] Reminder sent 24 hours later if not verified
- [ ] Success email sent on verification
- [ ] All emails mobile-responsive
- [ ] Verification links work correctly

---

## Implementation Plan

1. Create 3 mail classes (1.5 hours)
2. Design 3 email templates (1.5 hours)
3. Create reminder command (30 min)
4. Testing (30 min)

**Total:** 4 hours

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
