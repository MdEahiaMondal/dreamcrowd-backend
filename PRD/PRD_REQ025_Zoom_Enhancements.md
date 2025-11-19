# PRD: Zoom UX Enhancements (Optional)

**Requirement ID:** REQ-025
**Feature Name:** Zoom UX Enhancements
**Priority:** LOW (Optional Enhancement)
**Category:** Feature - User Experience
**Effort Estimate:** 6 hours
**Status:** Not Started

---

## Overview

Optional UX improvements to Zoom integration (already 100% functional). These enhancements improve usability but are not required.

**Note:** Zoom core features are 100% complete. These are cosmetic/UX improvements only.

---

## Functional Requirements

### FR-1: "Start Meeting" Button on Teacher Dashboard
**Current:** Teachers have start_url in dashboard, but no visual button
**Enhancement:** Add prominent "Start Class" button

**Location:** `resources/views/Teacher-Dashboard/client-managment.blade.php`

**Implementation:**
```blade
@if($order->zoomMeeting && $order->zoomMeeting->status === 'scheduled')
    <div class="zoom-meeting-card">
        <h4>Live Class Ready</h4>
        <p>Meeting ID: {{ $order->zoomMeeting->zoom_meeting_id }}</p>
        <a href="{{ $order->zoomMeeting->start_url }}"
           target="_blank"
           class="btn btn-success btn-lg">
            <i class="bx bx-video"></i> Start Zoom Class
        </a>
        <small>Class starts: {{ $order->classDates->first()->class_date }}</small>
    </div>
@elseif($order->classDates->first()->class_date <= now()->addMinutes(30))
    <div class="alert alert-info">
        <p>⏰ Zoom link will be generated 30 minutes before class</p>
    </div>
@endif
```

**Effort:** 2 hours

---

### FR-2: WebSocket for Live Dashboard Updates
**Current:** Admin live classes page refreshes every 10 seconds via AJAX
**Enhancement:** Use WebSocket for instant updates

**Technology:** Laravel WebSockets (beyondcode/laravel-websockets)

**Installation:**
```bash
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider"
php artisan migrate
```

**Broadcasting Event:**
```php
// When participant joins/leaves
event(new ZoomParticipantUpdated($meeting));
```

**Frontend Listener:**
```javascript
Echo.channel('zoom-live-classes')
    .listen('ZoomParticipantUpdated', (e) => {
        updateParticipantList(e.meeting);
    });
```

**Effort:** 3 hours

---

### FR-3: Zoom Meeting Recording Notifications
**Current:** No notification when recording is ready
**Enhancement:** Email teacher when Zoom cloud recording is available

**Webhook Event:** `recording.completed`

**Implementation in ZoomWebhookController:**
```php
public function handleWebhook(Request $request)
{
    $event = $request->input('event');

    if ($event === 'recording.completed') {
        $recordingUrl = $request->input('payload.object.recording_files.0.download_url');
        $meetingId = $request->input('payload.object.id');

        $meeting = ZoomMeeting::where('zoom_meeting_id', $meetingId)->first();

        if ($meeting) {
            Mail::to($meeting->teacher->email)->queue(
                new ZoomRecordingReady($meeting, $recordingUrl)
            );
        }
    }

    // ... existing webhook handlers
}
```

**Effort:** 1 hour

---

## Acceptance Criteria

### FR-1 (Start Meeting Button)
- [ ] Button visible on teacher dashboard
- [ ] Only shown when meeting is scheduled
- [ ] Opens Zoom in new tab
- [ ] Mobile-responsive

### FR-2 (WebSocket Updates)
- [ ] Real-time participant updates
- [ ] No page refresh needed
- [ ] Fallback to AJAX if WebSocket unavailable

### FR-3 (Recording Notifications)
- [ ] Email sent when recording ready
- [ ] Includes download link
- [ ] Link expires in 7 days (Zoom default)

---

## Implementation Plan

1. Add "Start Meeting" button (2 hours)
2. Install and configure WebSockets (1 hour)
3. Implement WebSocket listeners (1.5 hours)
4. Add recording webhook handler (30 min)
5. Create recording notification email (30 min)
6. Testing (30 min)

**Total:** 6 hours

---

## Files to Modify/Create

### FR-1
- **Modify:** `resources/views/Teacher-Dashboard/client-managment.blade.php`
- **Add CSS:** `.zoom-meeting-card` styles

### FR-2
- **Install:** `beyondcode/laravel-websockets`
- **Create:** `app/Events/ZoomParticipantUpdated.php`
- **Modify:** `resources/views/Admin-Dashboard/live-classes.blade.php`
- **Add:** JavaScript Echo listeners

### FR-3
- **Modify:** `app/Http/Controllers/ZoomWebhookController.php`
- **Create:** `app/Mail/ZoomRecordingReady.php`
- **Create:** `resources/views/emails/zoom-recording-ready.blade.php`

---

## Benefits

- **FR-1:** Improved teacher UX - one-click class start
- **FR-2:** Better admin experience - instant updates
- **FR-3:** Teachers can share recordings with students

---

**Document Status:** ⏸️ Optional - Zoom Core is 100% Complete
**Last Updated:** 2025-11-06
