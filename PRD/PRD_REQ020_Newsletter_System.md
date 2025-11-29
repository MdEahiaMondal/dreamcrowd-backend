# PRD: Newsletter/Promotional Email System

**Requirement ID:** REQ-020
**Feature Name:** Newsletter & Promotional Email System
**Priority:** LOW (Optional)
**Category:** Feature - Marketing
**Effort Estimate:** 10 hours
**Status:** Not Started

---

## Overview

Admin ability to send bulk promotional emails to users/sellers with template builder and audience segmentation.

---

## Functional Requirements

### FR-1: Newsletter Template Builder
- Rich text editor
- Image upload
- Pre-designed templates
- Preview before send

### FR-2: Audience Segmentation
- All users
- Buyers only
- Sellers only
- Active users (last 30 days)
- Inactive users
- Custom filters

### FR-3: Scheduling
- Send immediately
- Schedule for future date/time
- Recurring (weekly/monthly)

### FR-4: Analytics
- Open rate
- Click rate
- Unsubscribe rate
- Delivery rate

---

## Technical Specifications

### Database Tables

**newsletters table:**
```php
Schema::create('newsletters', function (Blueprint $table) {
    $table->id();
    $table->string('subject');
    $table->text('content'); // HTML content
    $table->string('audience_type'); // all, buyers, sellers, custom
    $table->json('audience_filters')->nullable();
    $table->enum('status', ['draft', 'scheduled', 'sent']);
    $table->timestamp('scheduled_at')->nullable();
    $table->timestamp('sent_at')->nullable();
    $table->integer('recipients_count')->default(0);
    $table->integer('opened_count')->default(0);
    $table->integer('clicked_count')->default(0);
    $table->foreignId('created_by')->constrained('users');
    $table->timestamps();
});
```

**newsletter_recipients table:**
```php
Schema::create('newsletter_recipients', function (Blueprint $table) {
    $table->id();
    $table->foreignId('newsletter_id')->constrained();
    $table->foreignId('user_id')->constrained();
    $table->timestamp('sent_at')->nullable();
    $table->timestamp('opened_at')->nullable();
    $table->timestamp('clicked_at')->nullable();
    $table->timestamps();
});
```

### Files to Create
- `app/Models/Newsletter.php`
- `app/Models/NewsletterRecipient.php`
- `app/Http/Controllers/Admin/NewsletterController.php`
- `app/Mail/NewsletterEmail.php`
- `app/Console/Commands/SendScheduledNewsletters.php`
- Admin views (5 files: index, create, edit, preview, analytics)

---

## Admin UI Features

### Newsletter Management Page
- List all newsletters (drafts, scheduled, sent)
- Create new newsletter button
- View analytics for sent newsletters

### Newsletter Composer
- Subject line input
- WYSIWYG editor (TinyMCE or Quill)
- Image upload
- Template selection
- Audience selector
- Schedule options
- Preview button
- Send test email button

### Analytics Dashboard
- Real-time stats
- Graphs (open rate over time)
- Top clicked links
- Unsubscribe reasons

---

## Acceptance Criteria

- [ ] Admin can create/edit newsletters
- [ ] Admin can select target audience
- [ ] Admin can schedule newsletters
- [ ] Newsletters sent via queue (async)
- [ ] Open tracking works (pixel)
- [ ] Click tracking works (link wrapping)
- [ ] Unsubscribe link included
- [ ] Analytics accurate

---

## Implementation Plan

1. Create database migrations and models (2 hours)
2. Build admin controller with CRUD (2 hours)
3. Design admin UI views (2 hours)
4. Implement WYSIWYG editor (1 hour)
5. Create mail class with tracking (1 hour)
6. Build analytics dashboard (1 hour)
7. Create scheduled send command (1 hour)
8. Testing (1 hour)

**Total:** 10 hours

---

## Optional Enhancements
- A/B testing (split test subject lines)
- Personalization tokens ({{first_name}}, {{class_count}})
- Campaign comparison
- Export analytics to CSV

---

**Document Status:** ✅ Ready for Implementation (Optional - Phase 2)
**Last Updated:** 2025-11-06
