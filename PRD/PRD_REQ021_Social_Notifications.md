# PRD: Social Notifications

**Requirement ID:** REQ-021
**Feature Name:** Social Notifications (Follow, Like, Share)
**Priority:** LOW (Optional)
**Category:** Feature - Social
**Effort Estimate:** 8 hours
**Status:** Not Started

---

## Overview

Notify users when someone follows them, likes their gig, or shares content.

**Prerequisites:** Social features must exist in platform (follow system, likes, shares).

---

## Functional Requirements

### FR-1: New Follower Notification
**Trigger:** User A follows User B

**Content:**
- "[User A] is now following you!"
- User A's profile info
- [View Profile] CTA
- [Follow Back] CTA

---

### FR-2: Gig Liked Notification
**Trigger:** User likes a teacher's gig

**Content:**
- "[User] liked your class: [Class Name]"
- Total likes count
- [View Class] CTA

---

### FR-3: Content Shared Notification
**Trigger:** User shares gig

**Content:**
- "[User] shared your class"
- Share platform (Facebook, Twitter, etc.)
- [View Class] CTA

---

## Technical Specifications

### Database Tables (if don't exist)

**follows table:**
```php
Schema::create('follows', function (Blueprint $table) {
    $table->id();
    $table->foreignId('follower_id')->constrained('users');
    $table->foreignId('following_id')->constrained('users');
    $table->timestamps();
    $table->unique(['follower_id', 'following_id']);
});
```

**gig_likes table:**
```php
Schema::create('gig_likes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained();
    $table->foreignId('gig_id')->constrained('teacher_gigs');
    $table->timestamps();
    $table->unique(['user_id', 'gig_id']);
});
```

### Model Events

**File:** `app/Models/Follow.php`
```php
protected static function booted()
{
    static::created(function ($follow) {
        Mail::to($follow->following->email)->queue(
            new NewFollowerNotification($follow)
        );
    });
}
```

### Files to Create
- `app/Mail/NewFollowerNotification.php`
- `app/Mail/GigLikedNotification.php`
- `app/Mail/ContentSharedNotification.php`
- Email templates (3 files)

---

## Acceptance Criteria

- [ ] Email sent when user gets new follower
- [ ] Email sent when gig is liked
- [ ] Email sent when content is shared
- [ ] Users can disable social notifications in settings
- [ ] Batching option (digest: "You have 5 new followers")

---

## Implementation Plan

1. Verify social features exist (1 hour)
2. Create database tables if needed (1 hour)
3. Create 3 mail classes (2 hours)
4. Design 3 email templates (2 hours)
5. Add model events (1 hour)
6. Add notification preferences (1 hour)
7. Testing (1 hour)

**Total:** 8 hours

---

**Document Status:** ⏸️ Pending Social Features Implementation
**Last Updated:** 2025-11-06
