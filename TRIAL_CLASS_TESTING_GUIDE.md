# Trial Class Feature - Testing Guide

## 🎉 Implementation Status: COMPLETE!

**Great News!** After thorough code review, I discovered that the Trial Class feature UI was already partially implemented in your codebase. I've completed all the missing backend functionality, and the feature is now **100% ready for testing!**

---

## ✅ What Was Already Implemented (Frontend)

The following UI elements were already in place:

### Class Creation Form (`Learn-How.blade.php`)
- ✅ "Trial Class" option in recurring_type dropdown (line 393)
- ✅ Trial Type selector (Free/Paid) with auto show/hide (lines 397-405)
- ✅ JavaScript validation for trial classes (lines 1002-1018, 2397-2410)
- ✅ Trial type visibility logic (lines 2326-2330)
- ✅ Automatic payment_type restriction (trials can't be subscription)

### Payment Page (`payment.blade.php`)
- ✅ Trial alert messages for Free/Paid trials (lines 153-168)
- ✅ Price inputs hidden for Free Trial (lines 174-220, 225-271)
- ✅ Fixed 30-minute duration for Free Trial (lines 473-476)
- ✅ Flexible duration for Paid Trial (lines 478-531)
- ✅ Form validation for trial pricing (lines 610-750)

---

## ✅ What I Implemented (Backend)

### 1. **Free Trial Booking Flow**
- Modified `BookingController.php` to skip Stripe payment for free trials
- Free trials create orders with `amount = 0`, `payment_status = 'completed'`, `status = 1`
- All commissions set to zero for free trials
- Paid trials follow normal Stripe payment flow

### 2. **Zoom Meeting Link Generation**
- Created `GenerateTrialMeetingLinks` command (scheduled every 5 minutes)
- Generates Zoom links 30 minutes before class starts
- Stores links in `class_dates.zoom_link` and `book_orders.zoom_link`
- Sends reminder email with meeting link automatically

### 3. **Email Notifications**
- Created professional booking confirmation email template
- Created reminder email template (sent 30 min before class with Zoom link)
- Both emails are queued for background processing
- Emails differentiate between Free and Paid trials

### 4. **Database Schema**
- Added `zoom_link` column to `class_dates` table ✅ **Migration already run**
- All other trial-related fields were already in database

---

## 🧪 Complete Testing Checklist

### Prerequisites
1. **Ensure environment is configured:**
   ```bash
   # Check .env file has these values:
   ZOOM_CLIENT_ID=your_zoom_client_id
   ZOOM_CLIENT_SECRET=your_zoom_client_secret
   ZOOM_REDIRECT_URI=https://yourdomain.com/zoom/callback

   STRIPE_KEY=pk_test_...
   STRIPE_SECRET=sk_test_...

   # Email configured (use Mailtrap for testing)
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailtrap.io
   # ... rest of mail config
   ```

2. **Ensure cron job is running:**
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

3. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

---

### Test 1: Create Free Trial Class (Teacher)

**Objective:** Verify teacher can create a free trial class with correct restrictions.

**Steps:**
1. Log in as a teacher
2. Go to "Create New Class/Service"
3. Select:
   - Service Role: `Class`
   - Service Type: `Online`
   - Class Type: `Live` (must be Live)
   - Lesson Type: `One` or `Group`
   - Payment Type: `OneOff` (subscription should be prevented)
   - Recurring Type: `Trial Class`
4. **Trial Type selector should appear**
5. Select: `Free Trial (30 min)`
6. Click "Next" to payment page

**Expected Results:**
- ✅ Meeting Platform (Zoom) should be required
- ✅ If you try to select "Video" class, trial option should not allow it
- ✅ If you try to select "Subscription", trial should not allow it
- ✅ Validation messages should appear if restrictions violated

**Payment Page - Expected Results:**
- ✅ Green alert box appears: "This is a FREE TRIAL class. Pricing is automatically set to $0. Duration is fixed at 30 minutes."
- ✅ Price input fields are HIDDEN (not editable)
- ✅ Duration selector shows "00 Hours" and "30 Minutes" (disabled)
- ✅ Hidden inputs set: `public_rate=0`, `private_rate=0`, `duration=00:30`
- ✅ Can successfully publish the class

**Save and verify:**
- Check database `teacher_gigs` table:
  - `trial_type` = 'Free'
  - `meeting_platform` = 'Zoom'
  - `payment_type` = 'OneOff'
  - `class_type` = 'Live'
- Check `teacher_gig_payments` table:
  - `is_trial` = 1
  - `trial_type` = 'Free'
  - `duration` = '00:30'
  - `public_rate` = 0 (or `rate` = 0 for one-on-one)

---

### Test 2: Create Paid Trial Class (Teacher)

**Objective:** Verify teacher can create a paid trial with flexible pricing.

**Steps:**
1. Log in as a teacher
2. Create new class (same steps as Test 1)
3. Select `Paid Trial (Flexible)`
4. Go to payment page

**Expected Results:**
- ✅ Blue alert box: "This is a PAID TRIAL class. You can set your own price and duration."
- ✅ Price input fields are VISIBLE and editable
- ✅ Duration selector is EDITABLE (default 60 minutes)
- ✅ Can set custom price (e.g., $25)
- ✅ Can set custom duration (e.g., 1 hour 15 min)
- ✅ Can successfully publish

**Verify in database:**
- `trial_type` = 'Paid'
- `duration` = custom value (e.g., '01:15')
- `public_rate` or `rate` = custom price (e.g., 25.00)

---

### Test 3: Book Free Trial Class (Student)

**Objective:** Verify free trial booking creates order without payment.

**Prerequisites:**
- A published free trial class exists
- Teacher has connected Zoom account (or this will fail at meeting generation step)

**Steps:**
1. Log out (or use different browser)
2. Log in as a student/buyer
3. Browse classes and find the free trial class
4. Click "Book This Service"
5. Select class date/time
6. Fill in booking details (guests, emails if group class)
7. Click "Complete Booking"

**Expected Results:**
- ✅ No payment form should appear (no credit card input)
- ✅ Order created immediately with:
  - `amount` = 0
  - `finel_price` = 0
  - `payment_status` = 'completed'
  - `status` = 1 (Active)
  - `payment_id` = null
- ✅ Success message: "Free trial booked successfully!"
- ✅ **Confirmation email sent immediately** (check Mailtrap or email inbox)

**Verify Confirmation Email Contains:**
- ✅ "Free Trial Class Confirmed!" heading
- ✅ Class title, teacher name, date/time, timezone
- ✅ Duration: "30 minutes"
- ✅ Amount Paid: NOT shown (it's free)
- ✅ Message: "You'll receive another email with Zoom link 30 min before class"

**Verify in Database:**
- `book_orders` table:
  - Order exists with `price = 0`, `finel_price = 0`
  - `payment_status = 'completed'`
  - `status = 1`
- `transactions` table:
  - Transaction exists with `total_amount = 0`
  - `status = 'completed'`
  - `notes` contains "Free Trial"
- `class_dates` table:
  - Class date record exists
  - `zoom_link` = null (will be generated 30 min before)

---

### Test 4: Book Paid Trial Class (Student)

**Objective:** Verify paid trial goes through normal Stripe payment.

**Steps:**
1. Log in as student
2. Find and click on paid trial class ($25, 60 min)
3. Select date/time
4. Fill booking form
5. Click "Complete Booking"

**Expected Results:**
- ✅ Stripe payment form appears (credit card input)
- ✅ Amount shown: $25 (plus buyer commission if enabled)
- ✅ Use Stripe test card: `4242 4242 4242 4242`, any future exp date, any CVC
- ✅ Payment processes successfully
- ✅ Order created with:
  - `amount` = 25
  - `payment_status` = 'pending' → 'completed' (after webhook)
  - `payment_id` = Stripe Payment Intent ID
- ✅ **Confirmation email sent**

**Verify Email:**
- ✅ "Paid Trial Class Confirmed!" heading
- ✅ Shows "Amount Paid: $25.00"
- ✅ Duration: "1 hour" (or custom duration set)

**Verify Database:**
- Order has correct price and payment_id
- Transaction has Stripe transaction ID
- Commission calculations correct (not zero for paid trials)

---

### Test 5: Zoom Link Auto-Generation (30 Min Before Class)

**Objective:** Verify meeting link is generated and reminder email sent.

**This is the critical test!**

**Setup:**
1. Create a free trial class (as teacher)
2. **Teacher MUST connect Zoom:**
   - Go to teacher dashboard
   - Find "Connect Zoom" button
   - Authorize the app
   - Verify `users.zoom_access_token` is populated
3. Book the trial class (as student)
4. Set the class date/time to **35 minutes from now** (gives you 5 min buffer)

**Automated Test (Cron):**
- Wait for scheduled command to run (every 5 minutes)
- OR manually trigger: `php artisan trials:generate-meeting-links`

**Expected Results:**
- ✅ Command output shows: "Found X upcoming trial classes"
- ✅ Command output: "✓ Generated meeting link for Order #123"
- ✅ Check `class_dates` table: `zoom_link` populated with Zoom URL
- ✅ Check `book_orders` table: `zoom_link` also populated
- ✅ **Reminder email sent automatically** (check inbox)

**Verify Reminder Email:**
- ✅ Subject: "⏰ Your Trial Class Starts in 30 Minutes - [Class Title]"
- ✅ Shows countdown alert
- ✅ Prominent "🎥 Join Zoom Meeting" button
- ✅ Meeting link visible as plain text (for copy/paste)
- ✅ Quick tips section (test camera/mic, quiet place, join early)

**Verify Logs:**
- Check `storage/logs/trial-meetings.log`:
  ```
  [timestamp] Trial meeting link generation started
  [timestamp] Found X upcoming trial classes without meeting links
  [timestamp] Zoom meeting link generated successfully
  [timestamp] Trial reminder email sent successfully
  [timestamp] Links generated: 1, Errors: 0
  ```

**Manual Test:**
- Click the Zoom link in the email
- ✅ Should open Zoom meeting (or prompt to install Zoom)
- ✅ Meeting should be scheduled for correct time
- ✅ Meeting duration should match trial duration (30 min or custom)

---

### Test 6: Join Trial Class

**Objective:** Verify end-to-end user experience.

**Steps:**
1. As student, check email 30 min before class
2. Click "Join Zoom Meeting" button
3. Join the meeting

**Expected Results:**
- ✅ Meeting opens in Zoom (desktop app or web)
- ✅ Teacher can start meeting as host
- ✅ Student can join as participant
- ✅ Settings work correctly:
  - Join before host: YES
  - Waiting room: NO
  - Participant video: ON
  - Host video: ON
  - Mute on entry: YES

---

### Test 7: Error Handling

**Objective:** Verify system handles errors gracefully.

#### 7.1 Teacher Hasn't Connected Zoom
**Steps:**
1. Create trial class with teacher who hasn't connected Zoom
2. Book the class
3. Wait for 30 min before class time
4. Run: `php artisan trials:generate-meeting-links`

**Expected Results:**
- ✅ Command shows warning: "Teacher (ID: X) has not connected Zoom account"
- ✅ Logged to `storage/logs/trial-meetings.log`
- ✅ No email sent
- ✅ Order still exists but no zoom_link

#### 7.2 Invalid Zoom Token
**Steps:**
1. Manually corrupt `users.zoom_access_token` in database
2. Try to generate meeting link

**Expected Results:**
- ✅ Zoom API returns 401 error
- ✅ Logged as error
- ✅ No meeting link created
- ✅ System doesn't crash

#### 7.3 Email Sending Fails
**Steps:**
1. Temporarily break email config (wrong SMTP host)
2. Book trial class

**Expected Results:**
- ✅ Order still created successfully
- ✅ Error logged: "Failed to send trial confirmation email"
- ✅ Check `failed_jobs` table for queued email job

---

### Test 8: Business Logic Validations

**Objective:** Verify all PRD requirements are enforced.

#### 8.1 Trial Must Be Live
**Steps:**
1. Try to create trial with Class Type = "Video"

**Expected:**
- ✅ Error: "Trial class must be Live class!"

#### 8.2 Trial Cannot Be Subscription
**Steps:**
1. Try to create trial with Payment Type = "Subscription"

**Expected:**
- ✅ Error: "Trial class cannot be subscription!"

#### 8.3 Free Trial Fixed Duration
**Steps:**
1. Create free trial
2. Try to change duration on payment page

**Expected:**
- ✅ Duration inputs are disabled (00:30 fixed)

#### 8.4 Meeting Platform Required
**Steps:**
1. Create Live trial class
2. Don't select meeting platform

**Expected:**
- ✅ Error: "Please select Meeting Platform (Zoom or Google Meet)!"

---

### Test 9: Database Integrity

**Objective:** Verify data consistency across tables.

**Run these SQL queries:**

```sql
-- Check free trial class created correctly
SELECT id, title, class_type, payment_type, meeting_platform, trial_type
FROM teacher_gigs
WHERE id = [your_test_gig_id];
-- Expected: class_type='Live', payment_type='OneOff', meeting_platform='Zoom', trial_type='Free'

-- Check payment settings
SELECT gig_id, duration, is_trial, trial_type, public_rate, private_rate, rate
FROM teacher_gig_payments
WHERE gig_id = [your_test_gig_id];
-- For Free Trial: duration='00:30', is_trial=1, trial_type='Free', rates=0

-- Check free trial order
SELECT id, gig_id, user_id, price, finel_price, payment_status, status, payment_id
FROM book_orders
WHERE gig_id = [your_test_gig_id];
-- For Free Trial: price=0, finel_price=0, payment_status='completed', status=1, payment_id=null

-- Check transaction
SELECT id, buyer_id, seller_id, total_amount, stripe_transaction_id, status, notes
FROM transactions
WHERE service_id = [your_test_gig_id];
-- For Free Trial: total_amount=0, stripe_transaction_id=null, status='completed', notes contains 'Free Trial'

-- Check class date with zoom link
SELECT id, order_id, zoom_link, teacher_date, user_date, duration
FROM class_dates
WHERE order_id = [your_test_order_id];
-- zoom_link should be populated 30 min before class_date
```

---

### Test 10: Commission Calculations

**Objective:** Verify commissions are correct.

#### For Free Trial:
```sql
SELECT
    price,
    buyer_commission_amount,
    seller_commission_amount,
    total_admin_commission,
    seller_earnings,
    finel_price
FROM book_orders
WHERE id = [free_trial_order_id];
```
**Expected:**
- All values = 0

#### For Paid Trial:
```sql
SELECT
    price,
    buyer_commission_rate,
    buyer_commission_amount,
    seller_commission_rate,
    seller_commission_amount,
    total_admin_commission,
    seller_earnings,
    finel_price
FROM book_orders
WHERE id = [paid_trial_order_id];
```
**Expected:**
- Calculations follow normal commission rules
- If price = $25, commission 15%:
  - `seller_commission_amount` = 3.75
  - `seller_earnings` = 21.25
  - `buyer_commission_amount` = (depends on buyer commission setting)

---

## 🐛 Known Issues & Limitations

1. **Google Meet Integration:** Not implemented (Zoom only, as per requirements)
2. **Trial Booking Limits:** No restrictions on multiple free trials per user (as per requirements: "unlimited")
3. **Meeting Link Timing:** Fixed at 30 minutes before class (as per requirements)
4. **Token Refresh:** Basic implementation - may need enhancement for production

---

## 📊 Performance Checklist

- [ ] Email queue processing is fast (<2 sec per email)
- [ ] Booking response time <3 seconds (free trial)
- [ ] Zoom API calls complete within 5 seconds
- [ ] Scheduled command processes 100 upcoming classes in <1 minute

---

## 🔍 Debugging Tips

### Issue: Meeting link not generated
**Check:**
1. Teacher has connected Zoom: `SELECT zoom_access_token FROM users WHERE id = [teacher_id];`
2. Class date is in future and within 30-min window
3. Cron job is running: `tail -f storage/logs/trial-meetings.log`
4. Scheduled command runs: `php artisan schedule:list`

### Issue: Email not received
**Check:**
1. Queue is processing: `php artisan queue:work` or check QUEUE_CONNECTION=sync
2. Check `failed_jobs` table: `SELECT * FROM failed_jobs;`
3. Check email config: `php artisan tinker` → `Mail::to('test@example.com')->send(...)`
4. Check logs: `tail -f storage/logs/laravel.log`

### Issue: Booking fails for free trial
**Check:**
1. Browser console for JavaScript errors
2. Laravel logs: `tail -f storage/logs/laravel.log`
3. Check if `gigData->recurring_type == 'Trial'` and `trial_type == 'Free'`
4. Verify BookingController logic at line 425-476

---

## ✅ Final Acceptance Criteria (From PRD)

| # | Criterion | Status | Test Number |
|---|-----------|--------|-------------|
| 1 | Seller selects "Free Trial" → price auto 0, duration fixed 30m | ✅ | Test 1 |
| 2 | Seller selects "Paid Trial" → price editable, duration editable | ✅ | Test 2 |
| 3 | Trial cannot be subscription | ✅ | Test 8.2 |
| 4 | Free trial booking → order (amount=0), email sent | ✅ | Test 3 |
| 5 | Paid trial booking → Stripe payment, email sent | ✅ | Test 4 |
| 6 | Zoom link auto created 30 min before class | ✅ | Test 5 |
| 7 | Reminder email sent 30 min before start time | ✅ | Test 5 |
| 8 | Guest user permissions respected | ✅ | Existing code |

**Overall: 8/8 Criteria Ready for Testing** ✅

---

## 🚀 Production Deployment Checklist

Before deploying to production:

- [ ] Run migration: `php artisan migrate --force`
- [ ] Verify `.env` has correct Zoom credentials
- [ ] Verify `.env` has correct Stripe credentials
- [ ] Set up cron job on production server
- [ ] Configure queue worker: `supervisor` or `systemd`
- [ ] Test email delivery with production SMTP
- [ ] Monitor logs for first 24 hours
- [ ] Set up error alerting (Sentry, Bugsnag, etc.)
- [ ] Document for support team
- [ ] Create user guides (teacher & student)

---

## 📞 Support

If you encounter any issues during testing:
1. Check logs in `storage/logs/`
2. Review this guide
3. Check `TRIAL_CLASS_IMPLEMENTATION_SUMMARY.md`
4. Contact development team

---

**Testing Date:** [To be filled after testing]
**Tester Name:** [To be filled]
**Environment:** Development / Staging / Production
**Test Results:** Pass / Fail (with notes)

---

**Implementation Complete!** 🎉
Ready for thorough testing and deployment.
