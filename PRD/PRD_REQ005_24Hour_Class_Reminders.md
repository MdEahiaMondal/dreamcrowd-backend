# PRD: 24-Hour Class Reminder Notifications

**Requirement ID:** REQ-005
**Feature Name:** 24-Hour Class Reminder Notifications
**Priority:** HIGH
**Category:** Notifications - Reminders
**Effort Estimate:** 5 hours
**Status:** Not Started

---

## Overview

### Problem Statement
Currently, buyers only receive Zoom link 30 minutes before class. A 24-hour advance reminder would:
- ✅ Reduce no-shows by 40%
- ✅ Give students time to prepare
- ✅ Improve class attendance rate

### Proposed Solution
Add scheduled command to send reminder emails 24 hours before class, in addition to existing 30-minute Zoom reminder.

---

## Functional Requirements

### FR-1: 24-Hour Reminder Email
**Content:**
- Friendly reminder heading
- Class details (name, teacher, topic)
- **Schedule:**
  - Date: Tomorrow, [Date]
  - Time: [Time] ([Timezone])
  - Duration: [X] minutes
- Preparation tips
- "What to expect" section
- Note: "You'll receive Zoom link 30 min before class"
- [Add to Calendar] button
- [View Class Details] CTA

**Trigger:** Scheduled command runs daily, checks classes starting in 24 hours

---

## Technical Specifications

### New Scheduled Command
**File:** `app/Console/Commands/SendClassReminders24Hours.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassDate;
use App\Models\BookOrder;
use App\Mail\ClassReminder24Hours;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendClassReminders24Hours extends Command
{
    protected $signature = 'classes:remind-24hours';
    protected $description = 'Send 24-hour class reminders to students';

    public function handle()
    {
        $tomorrow = Carbon::now()->addDay();
        $startTime = $tomorrow->copy()->startOfDay();
        $endTime = $tomorrow->copy()->endOfDay();

        // Get all classes scheduled for tomorrow
        $upcomingClasses = ClassDate::whereBetween('class_date', [$startTime, $endTime])
            ->whereHas('bookOrder', function($query) {
                $query->where('status', 1); // Active orders only
            })
            ->with(['bookOrder.user', 'bookOrder.teacherGig'])
            ->get();

        $sentCount = 0;

        foreach ($upcomingClasses as $classDate) {
            try {
                Mail::to($classDate->bookOrder->user->email)
                    ->queue(new ClassReminder24Hours($classDate));

                $sentCount++;

            } catch (\Exception $e) {
                \Log::error('Failed to send 24-hour reminder', [
                    'class_date_id' => $classDate->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Sent {$sentCount} 24-hour class reminders");

        \Log::info("24-hour class reminders sent", [
            'count' => $sentCount,
            'date' => $tomorrow->toDateString()
        ]);

        return 0;
    }
}
```

---

### Register Command in Kernel
**File:** `app/Console/Kernel.php`

```php
protected function schedule(Schedule $schedule)
{
    // ... existing schedules

    // Send 24-hour class reminders daily at 9:00 AM
    $schedule->command('classes:remind-24hours')
             ->dailyAt('09:00')
             ->withoutOverlapping()
             ->appendOutputTo(storage_path('logs/class-reminders-24h.log'));
}
```

---

### Mail Class
**File:** `app/Mail/ClassReminder24Hours.php`

```php
<?php

namespace App\Mail;

use App\Models\ClassDate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ClassReminder24Hours extends Mailable
{
    use Queueable, SerializesModels;

    public $classDate;
    public $order;
    public $gig;
    public $teacher;
    public $formattedDate;
    public $formattedTime;

    public function __construct(ClassDate $classDate)
    {
        $this->classDate = $classDate;
        $this->order = $classDate->bookOrder;
        $this->gig = $this->order->teacherGig;
        $this->teacher = $this->gig->user;

        // Format date and time
        $classDateTime = Carbon::parse($classDate->class_date);
        $this->formattedDate = $classDateTime->format('l, F j, Y'); // Monday, January 15, 2025
        $this->formattedTime = $classDateTime->format('g:i A'); // 2:30 PM
    }

    public function build()
    {
        return $this->subject('Reminder: Your class is tomorrow!')
                    ->view('emails.class-reminder-24hours');
    }
}
```

---

### Email Template
**File:** `resources/views/emails/class-reminder-24hours.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Reminder - Tomorrow!</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #6366F1; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; }
        .class-box { background: white; border-left: 4px solid #6366F1; padding: 20px; margin: 20px 0; border-radius: 4px; }
        .date-time { font-size: 20px; font-weight: bold; color: #6366F1; margin: 10px 0; }
        .button { display: inline-block; background: #6366F1; color: white; padding: 12px 30px;
                  text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .checklist { background: #EEF2FF; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Class Reminder</h1>
            <p>Your class is tomorrow!</p>
        </div>

        <div class="content">
            <p>Hi {{ $order->user->first_name }},</p>
            <p>This is a friendly reminder that you have a class scheduled for <strong>tomorrow</strong>.</p>

            <!-- Class Details -->
            <div class="class-box">
                <h2 style="margin-top: 0;">{{ $gig->gig_name }}</h2>
                <p><strong>Teacher:</strong> {{ $teacher->first_name }} {{ $teacher->last_name }}</p>

                <div class="date-time">
                    📆 {{ $formattedDate }}<br>
                    ⏰ {{ $formattedTime }}
                </div>

                <p><strong>Duration:</strong> {{ $order->duration }} minutes</p>
            </div>

            <!-- Preparation Checklist -->
            <div class="checklist">
                <h3>Preparation Checklist:</h3>
                <ul>
                    <li>✓ Review class materials (if provided)</li>
                    <li>✓ Prepare any questions you have</li>
                    <li>✓ Test your camera and microphone</li>
                    <li>✓ Find a quiet space for the class</li>
                    <li>✓ Have a notebook ready for notes</li>
                </ul>
            </div>

            <!-- What to Expect -->
            <div style="background: white; padding: 20px; border-radius: 4px; margin: 20px 0;">
                <h3>What to Expect:</h3>
                <p>{{ $gig->description ?? 'Your teacher will guide you through an engaging learning experience tailored to your goals.' }}</p>
            </div>

            <!-- Important Note -->
            <div style="background: #FEF3C7; border-left: 4px solid #F59E0B; padding: 15px; margin: 20px 0;">
                <strong>📧 Zoom Link Coming:</strong>
                <p style="margin: 5px 0;">You'll receive your Zoom meeting link 30 minutes before the class starts. Keep an eye on your inbox!</p>
            </div>

            <!-- CTAs -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/user/order-details/' . $order->id) }}" class="button">View Class Details</a>
                <a href="#" class="button" style="background: #10B981;">Add to Calendar</a>
            </div>

            <!-- Questions Section -->
            <div style="background: white; padding: 15px; border-radius: 4px; text-align: center; margin: 20px 0;">
                <p><strong>Need to reschedule?</strong></p>
                <p><a href="{{ url('/user/reschedule-request/' . $order->id) }}">Request a reschedule</a></p>
            </div>

            <p>We're excited for your class tomorrow!</p>
            <p>Best regards,<br>The DreamCrowd Team</p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; color: #6B7280; font-size: 12px; padding: 20px;">
            <p><a href="{{ url('/help') }}">Help Center</a> | <a href="{{ url('/contact') }}">Contact Support</a></p>
            <p>&copy; {{ date('Y') }} DreamCrowd. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
```

---

## Acceptance Criteria

- [ ] Command runs daily at 9:00 AM
- [ ] Only sends to classes exactly 24 hours away
- [ ] Only sends to active orders (status = 1)
- [ ] Email includes all class details
- [ ] Email includes preparation checklist
- [ ] Does NOT duplicate 30-minute Zoom reminder
- [ ] "Add to Calendar" button works (generates .ics file)
- [ ] Logged to `storage/logs/class-reminders-24h.log`

---

## Testing Requirements

### Unit Test
```php
/** @test */
public function command_sends_reminders_only_for_tomorrow_classes()
{
    Mail::fake();

    // Class tomorrow - should send
    $tomorrow = ClassDate::factory()->create([
        'class_date' => now()->addDay()
    ]);

    // Class today - should NOT send
    $today = ClassDate::factory()->create([
        'class_date' => now()
    ]);

    $this->artisan('classes:remind-24hours');

    Mail::assertQueued(ClassReminder24Hours::class, 1);
}
```

---

## Dependencies

- ✅ `ClassDate` model exists
- ✅ `BookOrder` model exists
- ✅ Cron job configured
- 🔲 Calendar invite (.ics) generation logic (optional)

---

## Implementation Plan

1. Create command class (1 hour)
2. Create mail class (30 min)
3. Design email template (1.5 hours)
4. Register in Kernel.php (15 min)
5. Add .ics calendar generation (optional) (1 hour)
6. Testing (1 hour)

**Total:** 5 hours

---

## Sign-off

**Developer:** _________________ **Date:** _______
**QA:** _________________ **Date:** _______
**Client:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Implementation
**Last Updated:** 2025-11-06
