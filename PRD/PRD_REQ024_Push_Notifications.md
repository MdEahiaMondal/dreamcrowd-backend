# PRD: Browser Push Notifications (Optional)

**Requirement ID:** REQ-024
**Feature Name:** Browser Push Notifications
**Priority:** LOW (Optional Enhancement)
**Category:** Feature - Real-time Notifications
**Effort Estimate:** 8 hours
**Status:** Not Started

---

## Overview

Add browser push notifications for real-time alerts (new bookings, messages, class reminders).

---

## Functional Requirements

### FR-1: Push-Enabled Events
- New booking received (teacher)
- New message received
- Class starting in 30 minutes
- Payment received
- Review posted on your class

### FR-2: User Permission
- Request browser notification permission on first visit
- Users can enable/disable in settings
- Works even when browser is closed (if supported)

---

## Technical Specifications

### Implementation Options

**Option A: Laravel Echo + Pusher**
```bash
composer require pusher/pusher-php-server
npm install --save-dev laravel-echo pusher-js
```

**Option B: Firebase Cloud Messaging (FCM)** (Recommended)
```bash
composer require kreait/firebase-php
npm install firebase
```

**Option C: OneSignal** (Third-party service)
```bash
# No server-side code required
# Include OneSignal SDK via CDN
```

---

## Implementation (Option B - FCM)

### Setup FCM
1. Create Firebase project
2. Generate service account JSON
3. Add to `.env`:
```env
FIREBASE_CREDENTIALS=/path/to/firebase-credentials.json
```

### Backend Service
**File:** `app/Services/PushNotificationService.php`

```php
<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class PushNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $firebase = (new Factory)->withServiceAccount(env('FIREBASE_CREDENTIALS'));
        $this->messaging = $firebase->createMessaging();
    }

    public function send($fcmToken, $title, $body, $data = [])
    {
        $message = CloudMessage::withTarget('token', $fcmToken)
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ])
            ->withData($data);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            \Log::error('Push notification failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
```

### Frontend Integration
**File:** `public/firebase-messaging-sw.js` (Service Worker)

```javascript
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "YOUR_API_KEY",
    projectId: "YOUR_PROJECT_ID",
    messagingSenderId: "YOUR_SENDER_ID",
    appId: "YOUR_APP_ID"
});

const messaging = firebase.messaging();

messaging.onBackgroundMessage((payload) => {
    const title = payload.notification.title;
    const options = {
        body: payload.notification.body,
        icon: '/logo.png'
    };
    self.registration.showNotification(title, options);
});
```

**File:** `resources/views/layouts/app.blade.php`

```javascript
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js"></script>

<script>
const firebaseConfig = {
    apiKey: "YOUR_API_KEY",
    projectId: "YOUR_PROJECT_ID",
    messagingSenderId: "YOUR_SENDER_ID",
    appId: "YOUR_APP_ID"
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

// Request permission
function requestNotificationPermission() {
    Notification.requestPermission().then((permission) => {
        if (permission === 'granted') {
            messaging.getToken({vapidKey: 'YOUR_VAPID_KEY'})
                .then((token) => {
                    // Save token to backend
                    fetch('/api/save-fcm-token', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({token: token})
                    });
                });
        }
    });
}

// Foreground messages
messaging.onMessage((payload) => {
    new Notification(payload.notification.title, {
        body: payload.notification.body,
        icon: '/logo.png'
    });
});
</script>
```

### Database Addition
Add to `users` table:
```php
$table->string('fcm_token')->nullable();
$table->boolean('push_notifications_enabled')->default(false);
```

### Usage Example
```php
// In BookingController after new booking
if ($teacher->push_notifications_enabled) {
    app(PushNotificationService::class)->send(
        $teacher->fcm_token,
        'New Booking!',
        "$buyer->first_name booked your class: $gig->gig_name",
        ['order_id' => $order->id]
    );
}
```

---

## Acceptance Criteria

- [ ] Users can grant/deny notification permission
- [ ] Push notifications work in foreground
- [ ] Push notifications work in background
- [ ] Click notification opens relevant page
- [ ] Users can disable in settings
- [ ] Works on Chrome, Firefox, Edge

---

## Browser Support
- ✅ Chrome 42+
- ✅ Firefox 44+
- ✅ Edge 79+
- ✅ Safari 16+ (macOS only)
- ❌ iOS Safari (not supported)

---

## Implementation Plan

1. Set up Firebase project (1 hour)
2. Install FCM SDK (30 min)
3. Create PushNotificationService (1.5 hours)
4. Add service worker (1 hour)
5. Build frontend permission UI (1 hour)
6. Add database fields (30 min)
7. Integrate triggers in 5 locations (2 hours)
8. Testing across browsers (1 hour)

**Total:** 8 hours

---

**Document Status:** ⏸️ Optional - Requires Firebase Setup
**Last Updated:** 2025-11-06
