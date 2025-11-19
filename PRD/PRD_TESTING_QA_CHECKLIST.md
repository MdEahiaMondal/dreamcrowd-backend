# DreamCrowd Platform - Testing & QA Plan

**Document Type:** Testing & Quality Assurance Plan
**Version:** 1.0
**Date:** 2025-11-06
**Estimated Effort:** 20-30 hours

---

## Table of Contents

1. [Testing Strategy](#testing-strategy)
2. [Functional Testing](#functional-testing)
3. [Security Testing](#security-testing)
4. [Performance Testing](#performance-testing)
5. [Browser Compatibility](#browser-compatibility)
6. [Scheduled Commands Testing](#scheduled-commands-testing)
7. [Email Deliverability Testing](#email-deliverability-testing)
8. [Regression Testing](#regression-testing)
9. [User Acceptance Testing (UAT)](#user-acceptance-testing-uat)
10. [Sign-off](#sign-off)

---

## Testing Strategy

### Testing Levels
1. **Unit Testing** - Test individual components (mail classes, models)
2. **Integration Testing** - Test email sending workflows end-to-end
3. **System Testing** - Test entire order lifecycle with notifications
4. **User Acceptance Testing (UAT)** - Client tests on staging environment

### Testing Environments
- **Development:** Local environment for initial testing
- **Staging:** Production-like environment for UAT
- **Production:** Live environment (post-deployment monitoring)

### Tools
- **PHPUnit:** Unit and integration tests
- **Laravel Dusk:** Browser automation tests
- **Mail Trap/MailHog:** Email testing (development)
- **Postman:** API endpoint testing
- **Mail Tester:** Spam score checking

---

## Functional Testing

### 1. Admin Dashboard Testing (4 hours)

#### Statistics & Real-time Updates
- [ ] Verify all 60+ statistics load correctly
- [ ] Test real-time updates (user registrations, new orders)
- [ ] Verify chart rendering (Chart.js integration)
- [ ] Test data accuracy against database

#### Export Functionality
- [ ] Test CSV export (all data tables)
- [ ] Test Excel export (all data tables)
- [ ] Test PDF export (invoices, reports)
- [ ] Verify exported data accuracy

#### Filtering & Search
- [ ] Test date range filters
- [ ] Test search functionality
- [ ] Test pagination
- [ ] Test sorting (asc/desc)

#### Zoom Management
- [ ] Test Zoom settings CRUD operations
- [ ] Verify "Test Connection" button works
- [ ] Test live classes monitoring dashboard
- [ ] Verify real-time participant updates (10-second AJAX)

#### Commission Management
- [ ] Test commission calculation accuracy
- [ ] Verify seller-specific commission overrides
- [ ] Test service-specific commission overrides

---

### 2. User Dashboard Testing (3 hours)

#### Statistics Display
- [ ] Verify total orders count accuracy
- [ ] Test completed orders count
- [ ] Verify pending orders count
- [ ] Test chart rendering (pie charts, line charts)

#### Purchase History
- [ ] Test order list pagination
- [ ] Verify order filters work
- [ ] Test order details view
- [ ] Verify status badges display correctly

#### Wishlist Functionality
- [ ] Test add to wishlist
- [ ] Test remove from wishlist
- [ ] Verify wishlist persistence

#### Export Functionality
- [ ] Test transaction history export (CSV)
- [ ] Verify exported data matches displayed data

---

### 3. Teacher Dashboard Testing (3 hours)

#### Earnings Tracking
- [ ] Verify total earnings calculation
- [ ] Test pending earnings display
- [ ] Verify paid earnings display
- [ ] Test commission deductions accuracy

#### Client Management
- [ ] Test client list display
- [ ] Verify booking details accurate
- [ ] Test reschedule approval workflow
- [ ] Test dispute viewing

#### Performance Metrics
- [ ] Verify gig views count
- [ ] Test order count accuracy
- [ ] Verify average rating calculation
- [ ] Test review display

#### Zoom Integration
- [ ] Test Zoom OAuth connection flow
- [ ] Verify "Connect with Zoom" button works
- [ ] Test "Disconnect" functionality
- [ ] Verify connection status display

---

### 4. Trial Class Feature Testing (4 hours)

#### Free Trial Creation
- [ ] Test free trial creation (fixed $0, 30 min)
- [ ] Verify price cannot be changed
- [ ] Verify duration cannot be changed
- [ ] Test availability only for "Live" + "One-off Payment"

#### Paid Trial Creation
- [ ] Test paid trial creation (custom price)
- [ ] Verify custom duration input
- [ ] Test price validation (min/max)
- [ ] Test duration validation

#### Trial Booking Flow
- [ ] Test trial class booking end-to-end
- [ ] Verify Stripe payment intent creation ($0 for free)
- [ ] Test trial class scheduling
- [ ] Verify trial appears in buyer dashboard
- [ ] Verify trial appears in teacher dashboard

#### Trial Restrictions
- [ ] Verify trials NOT available for "Video" classes
- [ ] Verify trials NOT available for "Subscription" payment mode
- [ ] Test error messages for invalid combinations

---

### 5. Zoom Integration Testing (5 hours)

#### OAuth 2.0 Flow
- [ ] Test teacher Zoom account connection
- [ ] Verify OAuth redirect works
- [ ] Test callback handler
- [ ] Verify access token storage (encrypted)
- [ ] Test CSRF protection (state parameter)

#### Automatic Meeting Creation
- [ ] Verify meetings created 30 min before class
- [ ] Test `GenerateZoomMeetings` command manually
- [ ] Verify meeting details accuracy (topic, duration, start time)
- [ ] Test meeting creation for different class types

#### Secure Token System
- [ ] Test secure join token generation
- [ ] Verify tokens are SHA256 hashed
- [ ] Test single-use enforcement
- [ ] Verify token expiry (45 min after class start)
- [ ] Test token validation in `ZoomJoinController`

#### Webhook Integration
- [ ] Test webhook signature verification (HMAC-SHA256)
- [ ] Verify participant join event handling
- [ ] Verify participant leave event handling
- [ ] Test timestamp validation
- [ ] Test replay attack prevention

#### Email Reminders
- [ ] Verify 30-minute reminder emails sent
- [ ] Test secure redirect links in emails
- [ ] Verify link format correct
- [ ] Test redirect to Zoom meeting

#### Token Refresh
- [ ] Test automatic token refresh (hourly cron)
- [ ] Verify expired tokens are refreshed
- [ ] Test token refresh failure handling
- [ ] Verify invalid tokens are cleared

---

### 6. Payment System Testing (3 hours)

#### Payment Forms
- [ ] Test all payment forms with trial class support
- [ ] Verify Stripe payment intent creation
- [ ] Test payment success flow
- [ ] Test payment failure handling

#### Refund Processing
- [ ] Test full refund via Stripe API
- [ ] Test partial refund
- [ ] Verify refund amount accuracy
- [ ] Test refund status updates

#### Commission Calculations
- [ ] Test default commission (15%)
- [ ] Test seller-specific commission override
- [ ] Test service-specific commission override
- [ ] Verify admin earnings calculation
- [ ] Verify seller payout calculation

#### Coupon Application
- [ ] Test coupon code validation
- [ ] Verify discount calculation
- [ ] Test expiry date enforcement
- [ ] Test usage limit enforcement

---

### 7. Notification System Testing (3 hours)

#### Critical & High Priority Notifications
- [ ] REQ-001: Order confirmation (buyer + seller)
- [ ] REQ-002: Payment failure notification
- [ ] REQ-003: Class cancellation notifications
- [ ] REQ-004: Refund processed notifications
- [ ] REQ-005: 24-hour class reminders
- [ ] REQ-006: Dispute opened notifications
- [ ] REQ-007: Dispute resolved notifications
- [ ] REQ-008: Reschedule request notifications
- [ ] REQ-009: Reschedule approved/rejected notifications

#### Medium Priority Notifications
- [ ] REQ-010: Order status change notifications
- [ ] REQ-011: Review reminder notifications
- [ ] REQ-012: New message notifications (if applicable)
- [ ] REQ-013: Gig status change notifications
- [ ] REQ-014: Real-time booking notifications
- [ ] REQ-015: Payout processed notifications
- [ ] REQ-016: Account verification emails
- [ ] REQ-017: Admin alert notifications
- [ ] REQ-018: Coupon usage notifications
- [ ] REQ-019: Zoom connection status notifications

#### Email Verification
- [ ] Verify email queue processing
- [ ] Test notification preferences (if exists)
- [ ] Verify unsubscribe links work
- [ ] Test notification delivery to correct recipients
- [ ] Verify email open tracking (if implemented)

---

### 8. Order Lifecycle Testing (4 hours)

#### Order Creation
- [ ] Test order creation flow end-to-end
- [ ] Verify BookOrder record created
- [ ] Verify Transaction record created
- [ ] Test with different payment modes (one-off, subscription)
- [ ] Test with different class types (live, video)

#### Status Transitions
- [ ] Test Pending (0) → Active (1) transition
- [ ] Test Active (1) → Delivered (2) transition (AutoMarkDelivered)
- [ ] Test Delivered (2) → Completed (3) transition (AutoMarkCompleted)
- [ ] Verify 48-hour wait between Delivered and Completed

#### Cancellation Flow
- [ ] Test buyer-initiated cancellation
- [ ] Test teacher-initiated cancellation
- [ ] Test system auto-cancellation
- [ ] Verify CancelOrder record created
- [ ] Verify status changed to Cancelled (4)

#### Dispute Flow
- [ ] Test dispute creation by buyer
- [ ] Verify DisputeOrder record created
- [ ] Test 48-hour counter-dispute window
- [ ] Test automatic refund (no counter-dispute)
- [ ] Test manual admin resolution

#### Payout Eligibility
- [ ] Verify orders with status 3 are payout-eligible
- [ ] Test payout processing
- [ ] Verify seller earnings accurate

---

## Security Testing (5 hours)

### Authentication & Authorization
- [ ] Test unauthorized access to admin routes
- [ ] Test unauthorized access to teacher routes
- [ ] Test unauthorized access to user routes
- [ ] Verify role-based access control (RBAC)

### Data Encryption
- [ ] Verify Zoom credentials encrypted (AES-256)
- [ ] Verify Zoom access tokens encrypted
- [ ] Verify Zoom refresh tokens encrypted
- [ ] Verify webhook secret encrypted

### Zoom Security
- [ ] Test webhook signature verification
- [ ] Verify CSRF protection in OAuth flow
- [ ] Test single-use token enforcement
- [ ] Verify IP address logging
- [ ] Verify user agent logging

### Payment Security
- [ ] Verify Stripe API key security
- [ ] Test payment intent verification
- [ ] Verify refund authorization
- [ ] Test SQL injection prevention in payment forms

### General Security
- [ ] Test XSS prevention (cross-site scripting)
- [ ] Test CSRF protection on all forms
- [ ] Verify password hashing (bcrypt)
- [ ] Test session security
- [ ] Verify file upload security (if applicable)

---

## Performance Testing (3 hours)

### Dashboard Load Times
- [ ] Test admin dashboard load time (target: < 2 seconds)
- [ ] Test user dashboard load time
- [ ] Test teacher dashboard load time
- [ ] Test with large datasets (1000+ orders)

### AJAX Polling Performance
- [ ] Test live classes dashboard polling (10-second intervals)
- [ ] Verify no memory leaks over time
- [ ] Test with 10+ concurrent users

### Email Queue Performance
- [ ] Test email queue with 100+ jobs
- [ ] Verify queue worker processes emails efficiently
- [ ] Test queue depth monitoring

### Scheduled Command Execution Times
- [ ] Test `GenerateZoomMeetings` execution time
- [ ] Test `RefreshZoomTokens` execution time
- [ ] Test `AutoMarkDelivered` execution time
- [ ] Test `AutoMarkCompleted` execution time
- [ ] Test `AutoHandleDisputes` execution time

### Database Query Optimization
- [ ] Test N+1 query issues
- [ ] Verify proper indexing on large tables
- [ ] Test eager loading in models
- [ ] Verify caching effectiveness

---

## Browser Compatibility Testing (2 hours)

### Desktop Browsers
- [ ] Chrome (latest version)
- [ ] Firefox (latest version)
- [ ] Safari (latest version)
- [ ] Microsoft Edge (latest version)

### Mobile Devices
- [ ] iOS Safari (iPhone)
- [ ] Chrome (Android)
- [ ] Test responsive design
- [ ] Verify touch interactions

### JavaScript Functionality
- [ ] Test Chart.js rendering across browsers
- [ ] Verify AJAX calls work
- [ ] Test modal dialogs
- [ ] Verify form submissions

---

## Scheduled Commands Testing (3 hours)

### Command Execution
- [ ] `php artisan zoom:generate-meetings` (runs every 5 min)
- [ ] `php artisan zoom:refresh-tokens` (runs hourly)
- [ ] `php artisan update:teacher-gig-status` (daily)
- [ ] `php artisan orders:auto-cancel` (hourly)
- [ ] `php artisan orders:auto-deliver` (hourly)
- [ ] `php artisan orders:auto-complete` (every 6 hours)
- [ ] `php artisan disputes:process` (daily at 3 AM)

### Cron Job Configuration
- [ ] Verify cron job is configured on server
- [ ] Test `php artisan schedule:run` manually
- [ ] Verify `withoutOverlapping()` prevents concurrent runs
- [ ] Test command logging to files

### Command Output
- [ ] Verify log files created in `storage/logs/`
- [ ] Test success scenarios
- [ ] Test failure scenarios
- [ ] Verify error handling

---

## Email Deliverability Testing (3 hours)

### Spam Score Testing
- [ ] Test all email templates with [Mail Tester](https://www.mail-tester.com)
- [ ] Target spam score: 8+/10
- [ ] Fix any issues (missing SPF, DKIM, etc.)

### Email Client Testing
- [ ] Gmail (desktop & mobile)
- [ ] Outlook (desktop & mobile)
- [ ] Apple Mail (macOS & iOS)
- [ ] Yahoo Mail
- [ ] ProtonMail

### Email Content Verification
- [ ] Verify images load correctly
- [ ] Test links (all CTAs)
- [ ] Verify mobile responsiveness
- [ ] Test dark mode rendering (if supported)
- [ ] Verify unsubscribe links work

### Deliverability Metrics
- [ ] Monitor bounce rate (target: < 3%)
- [ ] Monitor spam complaint rate (target: < 0.1%)
- [ ] Monitor open rate (target: > 35%)
- [ ] Monitor click-through rate (target: > 15%)

---

## Regression Testing (2 hours)

### Existing Features Verification
After implementing new notifications, verify existing features still work:

- [ ] User registration and login
- [ ] Class creation by teachers
- [ ] Class booking by users
- [ ] Payment processing
- [ ] Order management
- [ ] Dashboard statistics
- [ ] Zoom integration (core features)
- [ ] Trial class creation
- [ ] Dispute workflow
- [ ] Refund processing

---

## User Acceptance Testing (UAT) (5 hours)

### UAT Preparation
1. Deploy to staging environment
2. Create test accounts:
   - Admin user
   - Teacher user (2-3)
   - Buyer user (5-10)
3. Seed test data (orders, classes, transactions)
4. Provide UAT guide to client

### UAT Scenarios

**Scenario 1: Complete Booking Flow**
1. Buyer registers account
2. Buyer browses classes
3. Buyer books a class
4. Verify order confirmation emails received
5. Verify Zoom meeting created 30 min before
6. Verify class reminders sent (24h, 30min)
7. Teacher joins Zoom meeting
8. Buyer joins Zoom meeting
9. Class completes
10. Order marked as delivered
11. Order marked as completed (48 hours)
12. Verify payout eligibility

**Scenario 2: Cancellation & Refund**
1. Buyer books a class
2. Buyer requests cancellation
3. Verify cancellation emails sent
4. Verify refund processed
5. Verify refund confirmation email

**Scenario 3: Dispute Resolution**
1. Buyer books a class
2. Class delivered
3. Buyer opens dispute
4. Verify dispute notifications (teacher + admin)
5. Teacher doesn't respond
6. Verify automatic refund after 48 hours
7. Verify refund processed email

**Scenario 4: Reschedule Flow**
1. Buyer books a class
2. Buyer requests reschedule
3. Verify teacher notification
4. Teacher approves reschedule
5. Verify buyer notification (approved)
6. Verify class date updated

### UAT Sign-off
- [ ] All scenarios passed
- [ ] Client approves functionality
- [ ] No critical bugs found
- [ ] Ready for production deployment

---

## Defect Management

### Bug Severity Levels
- **Critical:** System crash, data loss, security breach
- **High:** Major feature broken, no workaround
- **Medium:** Feature partially broken, workaround exists
- **Low:** Minor UI issue, typo, cosmetic

### Bug Tracking
Use GitHub Issues, Jira, or Trello to track:
- Bug ID
- Title
- Description
- Steps to reproduce
- Expected vs actual behavior
- Severity
- Assigned to
- Status (Open, In Progress, Fixed, Closed)

### Bug Fix Process
1. Developer fixes bug
2. Code review by senior developer
3. Re-test on staging
4. Deploy to production
5. Verify fix in production
6. Close bug ticket

---

## Test Data Requirements

### Users
- 5 admin users
- 10 teacher users (with Zoom connected)
- 50 buyer users

### Classes
- 20 live classes (one-off payment)
- 10 live classes (subscription)
- 5 video classes
- 5 trial classes (free)
- 5 trial classes (paid)

### Orders
- 50 active orders
- 30 delivered orders
- 20 completed orders
- 10 cancelled orders
- 5 disputed orders

### Transactions
- 100 successful transactions
- 10 failed transactions
- 20 refunded transactions

---

## Testing Deliverables

1. **Test Plan:** This document
2. **Test Cases:** Detailed test cases for each feature
3. **Test Results:** Pass/Fail results for each test
4. **Bug Reports:** List of all bugs found
5. **Test Summary Report:** Overall test results and recommendations

---

## Sign-off

### QA Engineer Sign-off
- [ ] All test scenarios executed
- [ ] Test results documented
- [ ] Critical and high-severity bugs resolved
- [ ] Regression testing passed
- [ ] Ready for UAT

**QA Engineer:** _________________ **Date:** _______

---

### Client UAT Sign-off
- [ ] UAT scenarios completed successfully
- [ ] Functionality meets requirements
- [ ] No critical bugs found
- [ ] Ready for production deployment

**Client Name:** _________________ **Date:** _______
**Client Signature:** _______________________________

---

### Project Manager Sign-off
- [ ] All testing complete
- [ ] All sign-offs received
- [ ] Documentation complete
- [ ] Ready for production release

**Project Manager:** _________________ **Date:** _______

---

**Document Status:** ✅ Ready for Testing Phase
**Last Updated:** 2025-11-06
**Next Review:** After testing complete
