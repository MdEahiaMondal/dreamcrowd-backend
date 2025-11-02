# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Application Overview

**DreamCrowd** is a Laravel-based multi-sided marketplace platform connecting service providers (teachers/sellers) with customers (buyers/users). The platform facilitates online and in-person service bookings, class scheduling, payment processing via Stripe, and automated order lifecycle management including dispute resolution and refunds.

### User Roles
- **Teacher/Seller**: Create services/gigs, manage bookings, deliver classes, receive payouts
- **User/Buyer**: Browse services, book classes, make payments, submit reviews, initiate disputes
- **Admin**: Manage categories, sellers, payments, commissions, coupons, site content

## Development Commands

### Setup & Installation
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Create SQLite database (default)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database (if seeders exist)
php artisan db:seed
```

### Development Server
```bash
# Start Laravel development server
php artisan serve
# Access at http://localhost:8000

# Start Vite dev server (for frontend assets)
npm run dev

# Build frontend assets for production
npm run build
```

### Database Operations
```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations and re-run them
php artisan migrate:fresh

# Seed database
php artisan db:seed

# Start database CLI session
php artisan db
```

### Testing
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingTest.php

# Run tests with coverage
php artisan test --coverage
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Format specific files
./vendor/bin/pint app/Models/BookOrder.php
```

### Scheduled Commands
These commands run automatically via Laravel scheduler (configured in `app/Console/Kernel.php`):

```bash
# Manually run scheduled commands (for testing)
php artisan update:teacher-gig-status      # Updates gig status based on dates
php artisan orders:auto-cancel             # Cancels pending orders near class start time
php artisan orders:auto-deliver            # Marks orders as delivered after last class
php artisan orders:auto-complete           # Completes orders 48 hours after delivery
php artisan disputes:process               # Processes refunds for uncontested disputes

# Run the scheduler (in production via cron)
php artisan schedule:run

# View scheduled tasks
php artisan schedule:list
```

### Cache & Optimization
```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Optimize application (production)
php artisan optimize
```

## Architecture

### Core Business Models

**Transaction Flow Models:**
- `Transaction`: Financial records for each purchase. Tracks buyer/seller IDs, amounts, commissions (buyer, seller, admin), payout status, coupon discounts
- `BookOrder`: Service bookings linking users to gigs. Manages payment details, scheduling, reschedules, disputes, refunds, commission breakdowns

**Service Models:**
- `TeacherGig`: Service offerings (classes, freelance services, courses). Tracks impressions, clicks, orders, reviews, availability
- `TeacherGigData`: Detailed metadata (videos, resources, curriculum)
- `TeacherGigPayment`: Pricing tiers for different service types
- `Category` & `SubCategory`: Service classification

**Financial Models:**
- `Coupon` & `CouponUsage`: Discount codes with validation and analytics
- `SellerCommission`: Custom commission rates per seller
- `ServiceCommission`: Custom commission rates per service
- `TopSellerTag`: Global commission settings and multipliers

**Order Management:**
- `ServiceReviews`: Star ratings and comments with threaded teacher replies
- `DisputeOrder`: Dispute records with refund tracking
- `ClassDate`: Scheduling for subscription/recurring classes
- `ClassReschedule`: Rescheduling requests with approval workflow
- `CancelOrder`: Cancellation tracking

### Order Status Lifecycle

```
Pending (0)
    ↓ [Payment completed]
Active (1)
    ↓ [Due date passes / Manual action]
Delivered (2)
    ↓ [48 hours without dispute]
Completed (3) → Ready for payout
```

If disputed:
```
Active/Delivered
    ↓ [User initiates dispute]
Disputed (disputed flags set)
    ↓ [48 hours + no teacher counter-dispute]
Cancelled (4) → Automatic refund via Stripe
```

### Commission System

**Calculation Priority (in order):**
1. Service-specific commission (if enabled in `service_commissions` table)
2. Seller-specific commission (if enabled in `seller_commissions` table)
3. Default commission (configured in `top_seller_tags` table, typically 15%)

**Formula:**
```
Admin Earnings = (Service Price × Seller Commission %) + Buyer Commission Amount
Seller Payout = Service Price - (Service Price × Seller Commission %)
Buyer Total = Service Price + Buyer Commission + Tax
```

**Important:** Commission calculations are handled in `TopSellerTag::calculateCommission()` method.

### Automated Task Details

**AutoMarkDelivered** (`orders:auto-deliver`):
- Runs hourly
- Checks orders with status = 1 (Active)
- Calculates due date:
  - **Subscription**: 1 month from creation
  - **OneOff**: Last class date from `class_dates` table
- Updates to status = 2 (Delivered) when due date passes
- Logs to `storage/logs/auto-deliver.log`

**AutoMarkCompleted** (`orders:auto-complete`):
- Runs every 6 hours
- Checks orders with status = 2 (Delivered)
- Waits 48 hours after delivery (action_date)
- Updates to status = 3 (Completed)
- Makes transaction ready for payout
- Logs to `storage/logs/auto-complete.log`

**AutoHandleDisputes** (`disputes:process`):
- Runs daily at 3:00 AM
- Processes disputes where:
  - Order is cancelled (status = 4)
  - User disputed but teacher didn't
  - 48+ hours since cancellation
- Handles full and partial refunds via Stripe API
- Supports payment intent cancellation and refunds
- Logs to `storage/logs/disputes.log`

### Payment Integration (Stripe)

**Environment Variables:**
```
STRIPE_KEY=pk_test_...      # Public key (frontend)
STRIPE_SECRET=sk_test_...   # Secret key (backend)
```

**Transaction Flow:**
1. User pays via Stripe → `PaymentIntent` created
2. `Transaction` and `BookOrder` records created
3. Service delivered → Order marked as Delivered
4. 48-hour dispute window
5. No dispute → Auto-marked as Completed
6. Admin/automated payout → Funds released to seller

**Refund Processing:**
- Handled in `AutoHandleDisputes` command
- Uses Stripe API: `\Stripe\Refund::create()`
- Supports full and partial refunds
- Updates transaction amounts and status

### View Organization

```
resources/views/
├── Public-site/              # Public-facing homepage and marketing pages
├── Seller-listing/           # Service browsing, booking interfaces
├── Teacher-Dashboard/        # Seller/teacher management interface
├── User-Dashboard/           # Buyer interface (bookings, transactions)
├── Admin-Dashboard/          # Admin control panel
├── components/               # Reusable Blade components (sidebars, navigation)
├── shared/                   # Shared views across roles (transaction-details)
└── emails/                   # Email templates
```

### Key Controllers

- `BookingController`: Handles service bookings, payment processing, order management
- `TransactionController`: Transaction history, invoices, filters for buyers and sellers
- `StripeWebhookController`: Stripe webhook event handling
- `AdminController`: Admin dashboard, commission settings, seller management
- `CouponController`: Coupon creation, validation, usage tracking

## Database

**Default**: SQLite (`database/database.sqlite`)
**Production**: MySQL or PostgreSQL (configure via `.env`)

**Configuration:**
```
DB_CONNECTION=sqlite          # or mysql, pgsql
SESSION_DRIVER=database       # Sessions stored in database
QUEUE_CONNECTION=database     # Queue jobs stored in database
CACHE_STORE=database          # Cache stored in database
```

## Authentication

**Supported Methods:**
- Email/Password (standard Laravel auth)
- Google OAuth (`/google/redirect`, `/google/callback`)
- Facebook OAuth (`/facebook/redirect`, `/auth/facebook/callback`)
- Email verification with tokens
- Password recovery with tokens

**Account Switching:**
- Users can switch between roles via `/switch-account` route

## Important File Locations

**Core Business Logic:**
- `app/Models/TopSellerTag.php`: Commission calculation logic
- `app/Models/BookOrder.php`: Order lifecycle methods
- `app/Models/Transaction.php`: Payment and payout logic
- `app/Models/Coupon.php`: Coupon validation and application

**Scheduled Commands:**
- `app/Console/Commands/AutoMarkDelivered.php`
- `app/Console/Commands/AutoMarkCompleted.php`
- `app/Console/Commands/AutoHandleDisputes.php`
- `app/Console/Kernel.php`: Task scheduling configuration

**Controllers:**
- `app/Http/Controllers/BookingController.php`: Booking and payment
- `app/Http/Controllers/TransactionController.php`: Transaction management
- `app/Http/Controllers/StripeWebhookController.php`: Stripe webhooks

**Routes:**
- `routes/web.php`: All web routes

**Configuration:**
- `config/services.php`: OAuth provider settings
- `config/database.php`: Database connections
- `.env`: Environment-specific configuration

## Key Packages

- `stripe/stripe-php`: Payment processing
- `laravel/socialite`: OAuth authentication (Google, Facebook)
- `barryvdh/laravel-dompdf`: PDF invoice generation
- `maatwebsite/excel`: Excel export functionality
- `stevebauman/location`: Geolocation services

## Security Notes

- Stripe webhook signatures must be validated in production
- Payment intent verification before order creation
- Commission calculations are server-side only
- Refund processing requires proper authorization checks
- Scheduled commands use `withoutOverlapping()` to prevent concurrent execution
- All user inputs should be validated and sanitized

## Common Workflows

### Adding a New Service Type
1. Update `TeacherGig` model and migration
2. Modify `TeacherGigPayment` for pricing structure
3. Update booking flow in `BookingController`
4. Adjust due date calculation in `AutoMarkDelivered` command
5. Update views in `resources/views/Seller-listing/`

### Modifying Commission Structure
1. Update `TopSellerTag::calculateCommission()` method
2. Adjust database tables: `seller_commissions`, `service_commissions`, `top_seller_tags`
3. Update admin commission settings UI in `Admin-Dashboard/`
4. Test with various commission scenarios

### Adding New Scheduled Tasks
1. Create command: `php artisan make:command YourCommand`
2. Register in `app/Console/Kernel.php` schedule method
3. Add logging with `appendOutputTo(storage_path('logs/your-command.log'))`
4. Use `withoutOverlapping()` to prevent concurrent runs
5. Test manually before deploying

### Debugging Payment Issues
1. Check Stripe dashboard for payment intent status
2. Review `transactions` table for `payment_id` and `stripe_transaction_id`
3. Check `book_orders` table for order status and payment details
4. Review webhook logs in `StripeWebhookController`
5. Verify commission calculations in `TopSellerTag` model
