# PRD: SMS Notifications (Optional)

**Requirement ID:** REQ-023
**Feature Name:** SMS Notifications for Critical Events
**Priority:** LOW (Optional Enhancement)
**Category:** Feature - Notifications
**Effort Estimate:** 12 hours
**Status:** Not Started

---

## Overview

Add SMS notifications for critical events (payment success, class starting soon, cancellations).

**Note:** Requires third-party service (Twilio recommended).

---

## Functional Requirements

### FR-1: SMS-Enabled Events
- Payment success confirmation
- Class starting in 30 minutes
- Class cancelled by teacher
- Reschedule approved
- High-value order confirmation (> $200)

### FR-2: User Preferences
- Users can opt-in to SMS notifications
- Users provide phone number
- Users can select which events trigger SMS
- Unsubscribe via SMS reply "STOP"

### FR-3: SMS Content (160 char limit)
**Example:**
```
DreamCrowd: Payment successful! $100 for [Class Name]. Order #12345.
View details: https://dc.co/o/12345
```

---

## Technical Specifications

### Database Migration
Add to `users` table:
```php
$table->string('phone_number')->nullable();
$table->boolean('sms_notifications_enabled')->default(false);
$table->json('sms_preferences')->nullable(); // Which events to SMS
```

### Twilio Integration
**Install:** `composer require twilio/sdk`

**Config:** `config/services.php`
```php
'twilio' => [
    'sid' => env('TWILIO_SID'),
    'token' => env('TWILIO_TOKEN'),
    'from' => env('TWILIO_PHONE_NUMBER'),
],
```

### SMS Service Wrapper
**File:** `app/Services/SmsService.php`

```php
<?php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function send($to, $message)
    {
        try {
            $this->client->messages->create($to, [
                'from' => config('services.twilio.from'),
                'body' => $message
            ]);

            \Log::info('SMS sent', ['to' => $to, 'message' => $message]);
            return true;

        } catch (\Exception $e) {
            \Log::error('SMS send failed', [
                'to' => $to,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function canSendSms($user, $eventType)
    {
        if (!$user->sms_notifications_enabled) {
            return false;
        }

        $preferences = $user->sms_preferences ?? [];
        return in_array($eventType, $preferences);
    }
}
```

### Usage Example
```php
// In BookingController after payment success
if (app(SmsService::class)->canSendSms($user, 'payment_success')) {
    app(SmsService::class)->send(
        $user->phone_number,
        "DreamCrowd: Payment successful! $$order->amount for $gig->gig_name. Order #$order->id"
    );
}
```

---

## User Settings Page

Add SMS preferences section:
- Phone number input
- Checkbox: Enable SMS notifications
- Checkboxes for event types:
  - [ ] Payment confirmations
  - [ ] Class reminders
  - [ ] Cancellations
  - [ ] Reschedule updates
- Save button

---

## Acceptance Criteria

- [ ] Users can opt-in to SMS
- [ ] Phone number validated (E.164 format)
- [ ] SMS sent for selected events
- [ ] SMS delivery tracked
- [ ] Users can unsubscribe via SMS
- [ ] Cost monitoring (Twilio charges per SMS)

---

## Cost Considerations

**Twilio Pricing (approximate):**
- $0.0075 per SMS (outbound)
- $1/month per phone number

**Example:**
- 1000 users × 10 SMS/month = 10,000 SMS
- Cost: 10,000 × $0.0075 = $75/month

---

## Implementation Plan

1. Install Twilio SDK (30 min)
2. Create SmsService wrapper (2 hours)
3. Add database migrations (1 hour)
4. Build user preferences UI (2 hours)
5. Integrate SMS triggers in 5 locations (3 hours)
6. Add phone number validation (1 hour)
7. Implement opt-out/unsubscribe (1.5 hours)
8. Testing (1 hour)

**Total:** 12 hours

---

## Alternative: Firebase Cloud Messaging (FCM)
For app-based notifications instead of SMS.

---

**Document Status:** ⏸️ Optional - Requires Client Approval & Budget
**Last Updated:** 2025-11-06
