# Custom Offer Feature - Quick Start Guide

**Last Updated:** November 19, 2025
**Status:** ✅ **Production Ready** (All critical bugs fixed)

## 🚨 Important Notice

**Critical routing bug has been fixed!** All seller-side custom offer modals are now in the **correct file** (`chat.blade.php`). The feature is fully functional.

---

## 🚀 Get Started in 5 Minutes

### Step 1: Run Migrations
```bash
php artisan migrate
```

### Step 2: Verify Scheduler
```bash
php artisan schedule:list | grep custom-offers
```
Should show: `custom-offers:expire` running hourly

### Step 3: Test the Feature

#### As a Seller:
1. Login to your seller account
2. Go to Messages
3. Open a conversation with a buyer
4. Click the "custom offer" button
5. Follow the wizard to create an offer

#### As a Buyer:
1. Login to your buyer account
2. Go to Messages
3. You'll see custom offer cards in the conversation
4. Click "View Details" to see full offer
5. Click "Accept & Pay" or "Reject"

### Step 4: Monitor Logs (Optional)
```bash
# View expiry command logs
tail -f storage/logs/custom-offers-expiry.log

# View Laravel logs
tail -f storage/logs/laravel.log
```

---

## 📋 Quick Command Reference

```bash
# Run migrations
php artisan migrate

# Test expiry command (dry run - no changes)
php artisan custom-offers:expire --dry-run

# Run expiry command for real
php artisan custom-offers:expire

# View scheduled tasks
php artisan schedule:list

# Clear caches (if needed)
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 🔍 Quick Troubleshooting

### Issue: "Custom offer button doesn't appear"
**Check:** Is the user in a valid conversation?
**Location:** `resources/views/Teacher-Dashboard/chat.blade.php` line 308 ✅ **CORRECTED**

### Issue: "Services not loading in modal"
**Check:** Does the seller have active gigs?
**Endpoint:** POST `/get-services-for-custom`

### Issue: "Offer not appearing in buyer messages"
**Check:** Is $otheruserId variable set correctly?
**Location:** `resources/views/User-Dashboard/messages.blade.php` line 238

### Issue: "Emails not sending"
**Check:** `.env` file mail configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@dreamcrowd.com
MAIL_FROM_NAME="DreamCrowd"
```

### Issue: "Stripe payment failing"
**Check:** `.env` file Stripe configuration
```env
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
```

---

## 📊 Database Quick Check

```sql
-- Check custom offers table
SELECT * FROM custom_offers LIMIT 5;

-- Check milestones
SELECT * FROM custom_offer_milestones LIMIT 5;

-- Check pending offers
SELECT id, seller_id, buyer_id, status, total_amount, expires_at
FROM custom_offers
WHERE status = 'pending';

-- Check expired offers that need processing
SELECT id, status, expires_at
FROM custom_offers
WHERE status = 'pending'
AND expires_at <= NOW();
```

---

## 🎯 Common Use Cases

### 1. Seller wants to send a class booking offer
- Select "Class Booking" → Choose service → "Online" or "In-person"
- If In-person: Must provide date, start time, end time
- Choose "Single Payment" or "Milestones"
- Set price (minimum $10)

### 2. Seller wants to send a freelance project offer
- Select "Freelance Booking" → Choose service
- Choose "Milestones" for phased delivery
- Add multiple milestones with delivery days and revisions
- Set expiry (recommended: 3-7 days)

### 3. Buyer wants to accept an offer
- View offer details in messages
- Click "Accept & Pay"
- Complete payment on Stripe
- Order automatically created

### 4. Buyer wants to reject an offer
- Click "Reject" on offer card
- Provide reason (optional but recommended)
- Seller receives notification and email

---

## 🔐 Security Checklist

- [x] CSRF protection enabled
- [x] Authorization checks on all endpoints
- [x] SQL injection protection via Eloquent
- [x] XSS protection in Blade templates
- [x] Stripe webhook validation (required for production)
- [x] Email validation before sending
- [x] Error logging enabled

---

## 📈 Monitoring & Analytics

### Key Metrics to Track:
1. **Offer Creation Rate**: How many offers are being sent?
2. **Acceptance Rate**: What % of offers are accepted?
3. **Rejection Reasons**: Why are offers being rejected?
4. **Expiry Rate**: How many offers expire without action?
5. **Average Offer Value**: What's the typical offer amount?
6. **Time to Acceptance**: How long before buyers accept?

### Database Queries for Analytics:
```sql
-- Acceptance rate
SELECT
    COUNT(CASE WHEN status = 'accepted' THEN 1 END) as accepted,
    COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected,
    COUNT(CASE WHEN status = 'expired' THEN 1 END) as expired,
    COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending,
    COUNT(*) as total
FROM custom_offers;

-- Average offer value
SELECT AVG(total_amount) as avg_offer_value
FROM custom_offers
WHERE status = 'accepted';

-- Top sellers by offer volume
SELECT seller_id, COUNT(*) as offer_count
FROM custom_offers
GROUP BY seller_id
ORDER BY offer_count DESC
LIMIT 10;
```

---

## 🎓 User Training Tips

### For Sellers:
- "Create clear, detailed offers to increase acceptance rates"
- "Include milestone descriptions so buyers know what to expect"
- "Set reasonable expiry times - too short creates pressure, too long loses urgency"
- "One pending offer per buyer per service - update or cancel old ones first"

### For Buyers:
- "Review milestones carefully before accepting"
- "Payment is immediate upon acceptance - ensure you're ready"
- "Provide rejection reasons to help sellers improve"
- "Expired offers can be requested again - just ask the seller"

---

## 🛠️ Customization Options

### Adjust Minimum Price
**File:** `public/assets/teacher/js/custom-offers.js`
**Line:** ~441, 455
**Change:** `if (!price || price < 10)`

### Change Expiry Options
**File:** `resources/views/Teacher-Dashboard/chat.blade.php` ✅ **CORRECTED**
**Lines:** 532-539 (milestone modal), 645-652 (single payment modal)
**Add/Remove:** `<option value="X">X days</option>`

### Modify Email Templates
**Location:** `resources/views/emails/custom-offer-*.blade.php`
**Customize:** Colors, text, layout, branding

### Adjust Scheduler Frequency
**File:** `app/Console/Kernel.php`
**Line:** 42
**Change:** `->hourly()` to `->everyThirtyMinutes()` or `->daily()`

---

## 📞 Support

If you encounter issues:
1. Check `storage/logs/laravel.log` for errors
2. Check `storage/logs/custom-offers-expiry.log` for expiry command issues
3. Verify database tables exist: `custom_offers`, `custom_offer_milestones`
4. Confirm all migrations have run: `php artisan migrate:status`
5. Clear caches and try again

---

## ✅ Pre-Production Checklist

Before going live:
- [ ] Run migrations in production
- [ ] Set up production Stripe keys
- [ ] Configure production email settings
- [ ] Set up cron job for scheduler: `* * * * * cd /path && php artisan schedule:run >> /dev/null 2>&1`
- [ ] Test complete workflow end-to-end
- [ ] Verify emails are being sent
- [ ] Check webhook signatures are validated
- [ ] Monitor error logs for 24 hours
- [ ] Train customer support team
- [ ] Update user documentation

---

## 🎉 You're Ready!

Everything is set up and ready to use. Start testing the feature and enjoy the new custom offer functionality!

For detailed information, see:
- `IMPLEMENTATION_COMPLETE.md` - Complete feature overview
- `CUSTOM_OFFER_IMPLEMENTATION_SUMMARY.md` - Technical details
- `BUYER_UI_INTEGRATION_GUIDE.md` - Buyer-side details
- `CUSTOM_OFFER_FRONTEND_COMPLETION_NOTES.md` - Frontend technical details
