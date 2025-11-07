# DreamCrowd Platform - Documentation Plan

**Document Type:** Documentation & User Guide Plan
**Version:** 1.0
**Date:** 2025-11-06
**Estimated Effort:** 10-15 hours

---

## Table of Contents

1. [Documentation Strategy](#documentation-strategy)
2. [API Documentation](#api-documentation)
3. [User Guides](#user-guides)
4. [Developer Documentation](#developer-documentation)
5. [Code Documentation](#code-documentation)
6. [Changelog & Release Notes](#changelog--release-notes)
7. [Sign-off](#sign-off)

---

## Documentation Strategy

### Objectives
1. **User-Facing Docs:** Help users understand and use the platform
2. **Developer Docs:** Enable future developers to maintain and extend the system
3. **API Docs:** Document all API endpoints for integrations
4. **Change Management:** Track all changes and updates

### Documentation Standards
- **Clear Language:** Simple, jargon-free explanations
- **Visual Aids:** Screenshots, diagrams, video tutorials
- **Examples:** Real-world usage examples
- **Searchable:** Organized with table of contents and search
- **Versioned:** Track documentation changes alongside code

### Tools
- **Markdown:** For technical documentation
- **Laravel Scribe:** For API documentation
- **Screen Recording:** Loom or similar for video tutorials
- **Diagram Tools:** Draw.io or Lucidchart for flowcharts

---

## API Documentation (4 hours)

### Priority: MEDIUM
### Status: Missing

### Objectives
Document all API endpoints for potential third-party integrations or mobile app development.

### Tool Recommendation: Laravel Scribe

**Installation:**
```bash
composer require --dev knuckleswtf/scribe
php artisan vendor:publish --tag=scribe-config
```

**Configuration:** `config/scribe.php`
```php
return [
    'routes' => [
        [
            'match' => [
                'domains' => ['*'],
                'prefixes' => ['api/*'],
                'versions' => ['v1'],
            ],
        ],
    ],
    'type' => 'laravel',
    'title' => 'DreamCrowd API Documentation',
    'description' => 'API documentation for DreamCrowd platform',
    'base_url' => env('APP_URL'),
];
```

**Generate Documentation:**
```bash
php artisan scribe:generate
```

### API Endpoints to Document

#### Authentication Endpoints
- `POST /api/register` - User registration
- `POST /api/login` - User login
- `POST /api/logout` - User logout
- `POST /api/password/reset` - Password reset

#### Classes/Gigs Endpoints
- `GET /api/classes` - List all classes
- `GET /api/classes/{id}` - Get class details
- `GET /api/classes/search` - Search classes
- `GET /api/categories` - List categories

#### Booking Endpoints
- `POST /api/bookings` - Create booking
- `GET /api/bookings/{id}` - Get booking details
- `PUT /api/bookings/{id}/cancel` - Cancel booking
- `POST /api/bookings/{id}/reschedule` - Request reschedule

#### User Endpoints
- `GET /api/user/profile` - Get user profile
- `PUT /api/user/profile` - Update profile
- `GET /api/user/orders` - Get user orders
- `GET /api/user/transactions` - Get transactions

#### Teacher Endpoints (if API exists)
- `GET /api/teacher/dashboard` - Dashboard stats
- `GET /api/teacher/bookings` - Teacher bookings
- `GET /api/teacher/earnings` - Earnings summary

### Documentation Requirements

For each endpoint, document:
- **Method:** GET, POST, PUT, DELETE
- **URL:** `/api/endpoint-path`
- **Authentication:** Required? (Bearer token)
- **Parameters:**
  - Path parameters
  - Query parameters
  - Body parameters
- **Request Example:** JSON payload
- **Response Example:** Success (200)
- **Error Responses:** 400, 401, 403, 404, 500
- **Rate Limiting:** If applicable

### Example API Documentation

```markdown
## Create Booking

Create a new class booking.

**Endpoint:** `POST /api/bookings`

**Authentication:** Required (Bearer token)

**Parameters:**

| Name | Type | Required | Description |
|------|------|----------|-------------|
| gig_id | integer | Yes | ID of the class to book |
| class_date | string | Yes | Date of class (YYYY-MM-DD) |
| payment_method_id | string | Yes | Stripe payment method ID |
| coupon_code | string | No | Discount coupon code |

**Request Example:**
```json
{
  "gig_id": 123,
  "class_date": "2025-01-15",
  "payment_method_id": "pm_1234567890",
  "coupon_code": "SAVE10"
}
```

**Success Response (201 Created):**
```json
{
  "success": true,
  "data": {
    "order_id": 456,
    "amount": 100.00,
    "status": "active",
    "class_date": "2025-01-15",
    "zoom_link": "https://zoom.us/j/..."
  }
}
```

**Error Responses:**

- **400 Bad Request:** Invalid parameters
- **401 Unauthorized:** Missing or invalid auth token
- **404 Not Found:** Class not found
- **422 Unprocessable Entity:** Validation errors
```

### Deliverables
- [ ] `docs/api/index.html` - Generated API documentation
- [ ] Postman collection (JSON export)
- [ ] API authentication guide
- [ ] Rate limiting documentation

---

## User Guides (3 hours)

### Priority: MEDIUM
### Status: Partial (Zoom docs exist)

### Guide 1: Buyer User Guide
**File:** `docs/user-guides/buyer-guide.md` or PDF

**Contents:**
1. **Getting Started**
   - Creating an account
   - Email verification
   - Profile setup
   - Account security (password, 2FA)

2. **Finding Classes**
   - Browse categories
   - Search and filters
   - View class details
   - Read reviews

3. **Booking a Class**
   - Select class and date
   - Apply coupon codes
   - Payment process
   - Booking confirmation

4. **Before Your Class**
   - Email reminders
   - How to join Zoom
   - Preparation tips
   - Rescheduling a class

5. **After Your Class**
   - Leave a review
   - Request a refund (if needed)
   - Book another class

6. **Account Management**
   - View order history
   - Download invoices
   - Update payment methods
   - Notification preferences

7. **FAQ**
   - How do I cancel a booking?
   - What is the refund policy?
   - How do I reschedule a class?
   - I didn't receive my Zoom link

---

### Guide 2: Seller/Teacher User Guide
**File:** `docs/user-guides/seller-guide.md` or PDF

**Contents:**
1. **Getting Started as a Teacher**
   - Switch to seller account
   - Profile setup
   - Verify identity
   - Connect Zoom account

2. **Creating Your First Class**
   - Class types (live, video, one-off, subscription)
   - Pricing and trial classes
   - Schedule and availability
   - Upload materials
   - Class description best practices

3. **Managing Bookings**
   - View upcoming classes
   - Manage client requests
   - Approve/decline reschedules
   - Handle cancellations

4. **Teaching Your Class**
   - Starting a Zoom meeting
   - Best practices for online teaching
   - Recording classes (if enabled)
   - Follow-up with students

5. **Earnings & Payouts**
   - Understanding commissions
   - Viewing earnings
   - Payout schedule
   - Tracking transactions

6. **Handling Disputes**
   - What is a dispute?
   - Responding to disputes
   - Providing evidence
   - Dispute resolution process

7. **Growing Your Business**
   - Getting more bookings
   - Improving your ratings
   - Promotional tips
   - Platform marketing tools

8. **FAQ**
   - How do commissions work?
   - When do I get paid?
   - What if my Zoom disconnects?
   - How do I respond to a dispute?

---

### Guide 3: Admin User Guide
**File:** `docs/user-guides/admin-guide.md` or PDF

**Contents:**
1. **Admin Dashboard Overview**
   - Statistics and analytics
   - Real-time updates
   - Filtering and exports

2. **User Management**
   - View all users
   - Manage user roles
   - Suspend/activate accounts
   - View user activity

3. **Class Management**
   - Review and approve classes
   - Manage categories
   - Monitor class performance

4. **Order & Transaction Management**
   - View all orders
   - Process refunds manually
   - Handle disputes
   - Generate financial reports

5. **Commission Management**
   - Set default commission rates
   - Seller-specific commissions
   - Service-specific commissions
   - Track commission revenue

6. **Zoom Integration Management**
   - Configure Zoom settings
   - Test Zoom connection
   - Monitor live classes
   - View Zoom audit logs

7. **Notifications & Communication**
   - Send newsletters (if implemented)
   - View email logs
   - Monitor deliverability
   - Manage notification templates

8. **Reports & Analytics**
   - Revenue reports
   - User growth reports
   - Class performance reports
   - Export data

9. **System Maintenance**
   - Scheduled commands monitoring
   - Queue management
   - Log viewing
   - Performance monitoring

---

### Deliverables
- [ ] Buyer guide (PDF + online version)
- [ ] Seller guide (PDF + online version)
- [ ] Admin guide (PDF + online version)
- [ ] Screenshots for each guide
- [ ] Video tutorials (optional, 5-10 min each)

---

## Developer Documentation (3 hours)

### Priority: LOW
### Status: Partial (CLAUDE.md exists)

### Document 1: Update CLAUDE.md
**File:** `CLAUDE.md` (already exists)

**Updates Needed:**
- [ ] Add notification system overview
- [ ] Document new scheduled commands
- [ ] Add trial class feature details
- [ ] Update Zoom integration section
- [ ] Add testing guidelines
- [ ] Document new database tables

---

### Document 2: Deployment Guide
**File:** `docs/deployment-guide.md`

**Contents:**
1. **Server Requirements**
   - PHP 8.1+
   - MySQL/PostgreSQL
   - Redis (optional)
   - Cron jobs
   - SSL certificate

2. **Environment Setup**
   - Clone repository
   - Configure `.env` file
   - Generate app key
   - Run migrations
   - Seed database (optional)

3. **Cron Jobs**
   ```bash
   * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
   ```

4. **Queue Workers**
   ```bash
   php artisan queue:work --sleep=3 --tries=3 --daemon
   ```

5. **Email Configuration**
   - SMTP settings
   - Mail service provider setup (SendGrid/Mailgun)
   - SPF, DKIM, DMARC records

6. **Zoom Configuration**
   - Create Zoom OAuth app
   - Configure redirect URLs
   - Set up webhooks
   - Add credentials to `.env`

7. **Stripe Configuration**
   - API keys
   - Webhook endpoints
   - Testing mode vs production

8. **SSL & Security**
   - Install SSL certificate
   - Force HTTPS
   - Configure firewall
   - Security headers

9. **Monitoring & Logging**
   - Laravel Horizon (optional)
   - Log rotation
   - Error tracking (Sentry, Bugsnag)

10. **Backup Strategy**
    - Database backups (daily)
    - File backups
    - Backup retention policy

---

### Document 3: Architecture Overview
**File:** `docs/architecture.md`

**Contents:**
1. **System Architecture Diagram**
   - Frontend (Blade templates)
   - Backend (Laravel)
   - Database (MySQL/PostgreSQL)
   - External Services (Stripe, Zoom, Email)

2. **Database Schema**
   - ERD (Entity Relationship Diagram)
   - Key tables and relationships
   - Indexing strategy

3. **Application Flow**
   - User registration → booking → payment → class → completion → payout
   - Flowcharts for each major process

4. **Security Architecture**
   - Authentication (Laravel Sanctum/Passport)
   - Authorization (roles, permissions)
   - Data encryption
   - API security

5. **Third-Party Integrations**
   - Stripe payment flow
   - Zoom OAuth and webhooks
   - Email service provider
   - Social login (Google, Facebook)

---

### Document 4: Troubleshooting Guide
**File:** `docs/troubleshooting.md`

**Contents:**

**Common Issues:**

1. **Emails Not Sending**
   - Check queue is running
   - Verify SMTP settings
   - Check failed_jobs table
   - Test with `php artisan tinker`

2. **Zoom Meetings Not Creating**
   - Check `GenerateZoomMeetings` command logs
   - Verify Zoom OAuth token is valid
   - Test Zoom API connection

3. **Payment Failures**
   - Check Stripe dashboard
   - Verify webhook configuration
   - Check Stripe API keys

4. **Cron Jobs Not Running**
   - Verify cron entry exists
   - Check cron logs
   - Test manually: `php artisan schedule:run`

5. **Dashboard Statistics Incorrect**
   - Clear cache: `php artisan cache:clear`
   - Re-run calculations
   - Check database queries

---

### Deliverables
- [ ] Updated CLAUDE.md
- [ ] Deployment guide
- [ ] Architecture documentation
- [ ] Troubleshooting guide

---

## Code Documentation (3 hours)

### Priority: LOW
### Status: Partial

### PHPDoc Blocks
Add comprehensive PHPDoc comments to all classes and methods.

**Controllers:**
```php
/**
 * Handle booking creation and payment processing
 *
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 * @throws \Stripe\Exception\CardException
 */
public function processBooking(Request $request)
{
    // ...
}
```

**Models:**
```php
/**
 * Get all active bookings for this user
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function activeBookings()
{
    return $this->hasMany(BookOrder::class)->where('status', 1);
}
```

**Commands:**
```php
/**
 * Generate Zoom meetings for classes starting in 30 minutes
 *
 * This command runs every 5 minutes via cron and creates Zoom meetings
 * for all classes scheduled to start in the next 30 minutes.
 *
 * @return int Command exit code
 */
public function handle()
{
    // ...
}
```

### Inline Comments
Add comments for complex logic:

```php
// Calculate seller commission based on priority:
// 1. Service-specific commission (highest priority)
// 2. Seller-specific commission
// 3. Default platform commission (15%)
$commission = $this->calculateCommission($order);
```

### Model Relationship Documentation
Document all relationships in models:

```php
/**
 * BookOrder Model
 *
 * Relationships:
 * - belongsTo: User (buyer)
 * - belongsTo: TeacherGig (service)
 * - belongsTo: Transaction (payment)
 * - hasMany: ClassDate (scheduled classes)
 * - hasMany: ClassReschedule (reschedule requests)
 * - hasOne: CancelOrder (if cancelled)
 * - hasOne: DisputeOrder (if disputed)
 * - hasOne: ServiceReviews (buyer review)
 */
```

### Deliverables
- [ ] PHPDoc blocks for all controllers
- [ ] PHPDoc blocks for all models
- [ ] PHPDoc blocks for all commands
- [ ] Inline comments for complex logic

---

## Changelog & Release Notes (2 hours)

### Priority: LOW
### Status: Missing

### Changelog Structure
**File:** `CHANGELOG.md`

Follow [Keep a Changelog](https://keepachangelog.com/) format:

```markdown
# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- REQ-001: Order confirmation notifications for buyers and sellers
- REQ-002: Payment failure notifications with retry links
- REQ-005: 24-hour class reminder emails

### Changed
- Improved email template designs for better mobile responsiveness

### Fixed
- Fixed dashboard infinite loop issue
- Resolved payment form validation errors

## [1.5.0] - 2025-01-10

### Added
- Zoom integration with OAuth 2.0 authentication
- Automatic meeting creation 30 minutes before class
- Secure join tokens with single-use enforcement
- Webhook integration for participant tracking
- Trial class feature (free and paid trials)

### Changed
- Updated commission calculation to support service-specific rates
- Improved dashboard performance with query optimization

### Fixed
- Fixed repeat days validation in class scheduling

## [1.4.0] - 2024-12-15

### Added
- Admin dashboard with 60+ real-time statistics
- User dashboard with charts and export functionality
- Teacher dashboard with earnings tracking

### Changed
- Redesigned dashboard UI for better UX

### Security
- Implemented AES-256 encryption for Zoom credentials
- Added CSRF protection to OAuth flows

## [1.3.0] - 2024-11-20

### Added
- Dispute management system
- Automatic refund processing

### Fixed
- Various bug fixes and performance improvements
```

---

### Release Notes Template
**File:** `docs/releases/v1.5.0.md`

```markdown
# DreamCrowd v1.5.0 - Release Notes

**Release Date:** January 10, 2025

## What's New

### 🎉 Zoom Integration
Complete Zoom integration allowing teachers to conduct live classes:
- Connect Zoom account via OAuth 2.0
- Automatic meeting creation 30 minutes before class
- Secure join links sent via email
- Real-time participant tracking

### 🎓 Trial Classes
Teachers can now offer trial classes to attract new students:
- Free trials (30 minutes, $0)
- Paid trials (custom duration and price)
- Only available for live, one-off payment classes

### 📧 Enhanced Notifications
9 new notification types added:
- Order confirmations
- Payment failure alerts
- Class reminders (24 hours before)
- Dispute notifications
- Reschedule confirmations

## Improvements
- Dashboard performance optimized
- Email templates redesigned for mobile
- Commission system supports service-specific rates

## Bug Fixes
- Fixed dashboard statistics infinite loop
- Resolved payment form validation errors
- Fixed repeat days selection

## Breaking Changes
None

## Upgrade Instructions
1. Pull latest code
2. Run migrations: `php artisan migrate`
3. Clear cache: `php artisan cache:clear`
4. Configure Zoom (if using): See Zoom setup guide

## Known Issues
- iOS Safari push notifications not supported

## Support
For issues, contact: support@dreamcrowd.com
Documentation: https://docs.dreamcrowd.com
```

---

### Deliverables
- [ ] CHANGELOG.md (complete history)
- [ ] Release notes for v1.5.0
- [ ] Migration guide (if breaking changes)
- [ ] Release notes template for future releases

---

## Documentation Maintenance Plan

### Regular Updates
- **Monthly:** Review and update user guides
- **Per Release:** Update changelog and release notes
- **Quarterly:** Review API documentation
- **Annually:** Full documentation audit

### Documentation Review Process
1. Developer writes/updates documentation
2. Technical writer reviews for clarity
3. Subject matter expert (SME) reviews for accuracy
4. Final approval by project manager
5. Publish to documentation site

---

## Sign-off

### Technical Writer Sign-off
- [ ] All user guides written
- [ ] API documentation generated
- [ ] Developer documentation updated
- [ ] Code comments added
- [ ] Changelog updated

**Technical Writer:** _________________ **Date:** _______

---

### Project Manager Sign-off
- [ ] Documentation reviewed and approved
- [ ] Published to documentation site
- [ ] Accessible to users
- [ ] Complete and accurate

**Project Manager:** _________________ **Date:** _______

---

### Client Sign-off
- [ ] User guides reviewed
- [ ] Documentation meets requirements
- [ ] Ready for end users

**Client Name:** _________________ **Date:** _______
**Client Signature:** _______________________________

---

**Document Status:** ✅ Ready for Documentation Phase
**Last Updated:** 2025-11-06
**Next Review:** After documentation complete
