# PRD: Real-time Booking Notifications

**Requirement ID:** REQ-014
**Feature Name:** Real-time Booking Notifications (Teacher)
**Priority:** MEDIUM
**Category:** Notifications - Real-time
**Effort Estimate:** 5 hours
**Status:** Not Started

---

## Overview

Add browser/push notifications when teacher receives new booking (in addition to email from REQ-001).

---

## Functional Requirements

### FR-1: Browser Notification
**Technology Options:**
1. **Option A:** Simple AJAX polling (lightweight, no dependencies)
2. **Option B:** Laravel Echo + Pusher (real-time WebSocket)
3. **Option C:** Firebase Cloud Messaging (push notifications)

**Recommended:** Option A (AJAX polling every 30 seconds)

**Features:**
- Notification bell icon in teacher sidebar
- Badge count of unread bookings
- Toast notification when new booking received
- Click to view booking details

---

## Technical Specifications (Option A - AJAX Polling)

### Backend API Endpoint
**File:** `routes/web.php`
```php
Route::get('/teacher/unread-bookings-count', [TeacherController::class, 'unreadBookingsCount'])
     ->middleware('auth');
```

**File:** `app/Http/Controllers/TeacherController.php`
```php
public function unreadBookingsCount()
{
    $unreadCount = BookOrder::where('teacher_id', auth()->id())
        ->where('is_read_by_teacher', false)
        ->where('created_at', '>=', now()->subDays(7))
        ->count();

    return response()->json(['count' => $unreadCount]);
}
```

### Frontend Implementation
**File:** `resources/views/Teacher-Dashboard/includes/sidebar.blade.php`

```blade
<!-- Add notification bell icon -->
<div class="notification-bell" onclick="viewBookings()">
    <i class="bx bx-bell"></i>
    <span class="badge" id="booking-count" style="display: none;">0</span>
</div>

<script>
// Poll every 30 seconds
setInterval(function() {
    fetch('/teacher/unread-bookings-count')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('booking-count');
            if (data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-block';

                // Show toast notification (if increased from last check)
                if (data.count > previousCount) {
                    showToast('New booking received!');
                }
            } else {
                badge.style.display = 'none';
            }
            previousCount = data.count;
        });
}, 30000); // 30 seconds

function showToast(message) {
    // Simple toast notification
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
</script>

<style>
.notification-bell { position: relative; cursor: pointer; }
.notification-bell .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #EF4444;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 11px;
}
.toast-notification {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #10B981;
    color: white;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    z-index: 9999;
}
</style>
```

### Database Addition
Add column to `book_orders`:
```php
$table->boolean('is_read_by_teacher')->default(false);
```

Mark as read when teacher views:
```php
$order->update(['is_read_by_teacher' => true]);
```

---

## Acceptance Criteria

- [ ] Notification bell appears in teacher sidebar
- [ ] Badge shows unread booking count
- [ ] Polling checks every 30 seconds
- [ ] Toast notification shows for new bookings
- [ ] Click redirects to booking details
- [ ] Badge clears when bookings viewed

---

## Implementation Plan

1. Add database column (30 min)
2. Create API endpoint (1 hour)
3. Add notification bell UI (1 hour)
4. Implement AJAX polling (1 hour)
5. Add toast notifications (1 hour)
6. Testing (30 min)

**Total:** 5 hours

---

## Alternative: WebSocket Implementation (Optional Future Enhancement)

If real-time is required:

```bash
composer require pusher/pusher-php-server
npm install --save-dev laravel-echo pusher-js
```

Broadcasting event:
```php
event(new NewBookingReceived($order));
```

Frontend listener:
```javascript
Echo.private('teacher.' + teacherId)
    .listen('NewBookingReceived', (e) => {
        updateBookingCount();
        showToast('New booking from ' + e.order.buyer_name);
    });
```

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
