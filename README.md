# DreamCrowd

A Laravel-based multi-sided marketplace platform connecting service providers (teachers/sellers) with customers (buyers/users).

---

## Table of Contents

- [Overview](#overview)
- [Business Model](#business-model)
- [User Roles](#user-roles)
- [Key Features](#key-features)
- [How It Works](#how-it-works)
- [Order Lifecycle](#order-lifecycle)
- [Commission System](#commission-system)
- [Payment Integration](#payment-integration)
- [Installation](#installation)
- [Development Commands](#development-commands)
- [Architecture](#architecture)
- [Tech Stack](#tech-stack)

---

## Overview

**DreamCrowd** is an online marketplace where service providers can create and sell their services (gigs), and buyers can browse, book, and pay for those services. The platform supports:

- Online and in-person service bookings
- Class scheduling with recurring dates
- Secure payment processing via Stripe
- Automated order lifecycle management
- Dispute resolution and refund system
- Commission-based revenue model

---

## Business Model

DreamCrowd operates as a **multi-sided marketplace** generating revenue through commissions:

```
┌─────────────────────────────────────────────────────────────────┐
│                        BUSINESS FLOW                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│   SELLER                    PLATFORM                   BUYER    │
│   (Teacher)                (DreamCrowd)                (User)   │
│                                                                 │
│   ┌─────────┐              ┌─────────┐              ┌─────────┐ │
│   │ Creates │              │ Takes   │              │ Pays    │ │
│   │ Service │─────────────►│Commission├─────────────│ Service │ │
│   │ (Gig)   │              │ (15%)   │              │ Price + │ │
│   └─────────┘              └─────────┘              │ Fees    │ │
│       │                         │                   └─────────┘ │
│       │                         │                        │      │
│       ▼                         ▼                        ▼      │
│   ┌─────────┐              ┌─────────┐              ┌─────────┐ │
│   │Receives │              │ Admin   │              │Receives │ │
│   │ Payout  │◄─────────────│Earnings │              │ Service │ │
│   │ (85%)   │              │ (15%+)  │              │         │ │
│   └─────────┘              └─────────┘              └─────────┘ │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### Revenue Streams

1. **Seller Commission**: Percentage deducted from each sale (default 15%)
2. **Buyer Commission**: Additional fee charged to buyers
3. **Service-specific Commissions**: Custom rates for specific services
4. **Seller-specific Commissions**: Custom rates for specific sellers

---

## User Roles

### 1. Teacher/Seller
- Create and manage service listings (gigs)
- Set pricing tiers for different service types
- Manage bookings and class schedules
- Deliver services (online/in-person)
- Respond to disputes
- Receive payouts after order completion
- View analytics (impressions, clicks, orders, reviews)

### 2. User/Buyer
- Browse and search services by category
- Book classes and make payments
- Track order status
- Submit reviews and ratings
- Request rescheduling
- Initiate disputes for unsatisfactory service
- Request refunds

### 3. Admin
- Manage categories and subcategories
- Manage seller accounts and verification
- Configure commission rates (global, per-seller, per-service)
- Manage coupons and promotions
- Process payouts
- Handle dispute escalations
- Manage site content and settings

---

## Key Features

### For Sellers
- **Gig Management**: Create, edit, delete service listings
- **Pricing Tiers**: Set different prices for subscription, one-off, courses
- **Class Scheduling**: Set available dates and times
- **Order Management**: Track and manage bookings
- **Analytics Dashboard**: View performance metrics
- **Payout Tracking**: Monitor earnings and payment status

### For Buyers
- **Service Discovery**: Browse by category, search, filter
- **Secure Booking**: Book services with Stripe payment
- **Order Tracking**: Real-time status updates
- **Review System**: Rate and review completed services
- **Reschedule Requests**: Request class time changes
- **Dispute System**: File complaints and request refunds

### For Admin
- **Dashboard**: Overview of platform metrics
- **User Management**: Manage sellers and buyers
- **Commission Settings**: Configure global and custom rates
- **Coupon Management**: Create discount codes
- **Content Management**: Edit site pages and settings
- **Financial Reports**: Track revenue and payouts

### Platform Features
- **Automated Order Lifecycle**: Auto-delivery, auto-completion
- **Dispute Resolution**: 48-hour dispute window with auto-refund
- **Email Notifications**: Transactional emails for all events
- **OAuth Authentication**: Google and Facebook login
- **PDF Invoices**: Downloadable transaction receipts
- **Multi-role Accounts**: Switch between buyer/seller roles

---

## How It Works

### Complete User Journey

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           COMPLETE USER JOURNEY                              │
└─────────────────────────────────────────────────────────────────────────────┘

SELLER FLOW:
┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐
│ Register │──►│ Create   │──►│ Set      │──►│ Publish  │──►│ Receive  │
│ Account  │   │ Profile  │   │ Services │   │ Gig      │   │ Bookings │
└──────────┘   └──────────┘   └──────────┘   └──────────┘   └──────────┘
                                                                  │
                                                                  ▼
┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐
│ Receive  │◄──│ Order    │◄──│ Wait 48  │◄──│ Mark     │◄──│ Deliver  │
│ Payout   │   │ Complete │   │ Hours    │   │ Delivered│   │ Service  │
└──────────┘   └──────────┘   └──────────┘   └──────────┘   └──────────┘


BUYER FLOW:
┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐   ┌──────────┐
│ Register │──►│ Browse   │──►│ Select   │──►│ Book &   │──►│ Attend   │
│ Account  │   │ Services │   │ Gig      │   │ Pay      │   │ Class    │
└──────────┘   └──────────┘   └──────────┘   └──────────┘   └──────────┘
                                                                  │
                                                                  ▼
                              ┌──────────┐   ┌──────────┐   ┌──────────┐
                              │ Review   │◄──│ Order    │◄──│ Receive  │
                              │ Service  │   │ Complete │   │ Service  │
                              └──────────┘   └──────────┘   └──────────┘
```

### Service Booking Process

1. **Browse**: User browses services by category or search
2. **Select**: User views gig details, pricing, reviews
3. **Choose Tier**: User selects subscription, one-off, or course
4. **Select Dates**: User picks class dates (for one-off/courses)
5. **Apply Coupon**: User can apply discount code (optional)
6. **Payment**: User pays via Stripe
7. **Confirmation**: Both parties receive confirmation email
8. **Service Delivery**: Seller delivers the service
9. **Completion**: Order auto-completes after 48-hour window
10. **Review**: Buyer can leave rating and review
11. **Payout**: Seller receives payment (minus commission)

---

## Order Lifecycle

### Status Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    ORDER STATUS LIFECYCLE                        │
└─────────────────────────────────────────────────────────────────┘

                         ┌─────────────┐
                         │   PENDING   │ (Status: 0)
                         │ Awaiting    │
                         │ Payment     │
                         └──────┬──────┘
                                │
                         Payment Completed
                                │
                                ▼
                         ┌─────────────┐
                         │   ACTIVE    │ (Status: 1)
                         │ Service in  │
                         │ Progress    │
                         └──────┬──────┘
                                │
              ┌─────────────────┼─────────────────┐
              │                 │                 │
     Due Date Passes    Manual Delivery    User Cancels
              │                 │                 │
              ▼                 ▼                 ▼
       ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
       │  DELIVERED  │   │  DELIVERED  │   │  CANCELLED  │
       │ Auto-marked │   │ Seller-     │   │ Refund      │
       │ by System   │   │ marked      │   │ Processed   │
       └──────┬──────┘   └──────┬──────┘   └─────────────┘
              │                 │           (Status: 4)
              └────────┬────────┘
                       │
                       ▼
                ┌─────────────┐
                │  DELIVERED  │ (Status: 2)
                │ 48-Hour     │
                │ Dispute     │
                │ Window      │
                └──────┬──────┘
                       │
         ┌─────────────┴─────────────┐
         │                           │
    No Dispute               User Files Dispute
         │                           │
         ▼                           ▼
  ┌─────────────┐            ┌─────────────┐
  │  COMPLETED  │            │  DISPUTED   │
  │ Ready for   │            │ Under       │
  │ Payout      │            │ Review      │
  └─────────────┘            └──────┬──────┘
   (Status: 3)                      │
                       ┌────────────┴────────────┐
                       │                         │
               Teacher Contests          No Teacher Response
                       │                  (48 hours)
                       ▼                         │
                ┌─────────────┐                  ▼
                │ ADMIN       │          ┌─────────────┐
                │ REVIEW      │          │ AUTO-REFUND │
                │             │          │ Cancelled   │
                └─────────────┘          └─────────────┘
                                          (Status: 4)
```

### Automated Tasks

| Task | Schedule | Description |
|------|----------|-------------|
| `orders:auto-cancel` | Hourly | Cancels pending orders near class start time |
| `orders:auto-deliver` | Hourly | Marks active orders as delivered after due date |
| `orders:auto-complete` | Every 6 hours | Completes delivered orders after 48-hour window |
| `disputes:process` | Daily 3:00 AM | Processes refunds for uncontested disputes |
| `update:teacher-gig-status` | Daily | Updates gig availability based on dates |

### Due Date Calculation

- **Subscription Services**: 1 month from order creation
- **One-Off Services**: Last class date
- **Courses**: Last class date in the curriculum

---

## Commission System

### How Commissions Work

```
┌─────────────────────────────────────────────────────────────────┐
│                    COMMISSION CALCULATION                        │
└─────────────────────────────────────────────────────────────────┘

Service Price: $100
Seller Commission Rate: 15%
Buyer Commission: $5

┌──────────────────────────────────────────────────────────────────┐
│                                                                  │
│  BUYER PAYS:                                                     │
│  ├── Service Price ─────────────────────── $100.00              │
│  ├── Buyer Commission Fee ──────────────── $5.00                │
│  ├── Tax (if applicable) ───────────────── $0.00                │
│  └── TOTAL ─────────────────────────────── $105.00              │
│                                                                  │
│  ADMIN RECEIVES:                                                 │
│  ├── Seller Commission (15% of $100) ───── $15.00               │
│  ├── Buyer Commission Fee ──────────────── $5.00                │
│  └── TOTAL ─────────────────────────────── $20.00               │
│                                                                  │
│  SELLER RECEIVES:                                                │
│  └── Service Price - Commission ────────── $85.00               │
│                                                                  │
└──────────────────────────────────────────────────────────────────┘
```

### Commission Priority (Highest to Lowest)

1. **Service-Specific Commission**: Custom rate set for a specific gig
2. **Seller-Specific Commission**: Custom rate set for a specific seller
3. **Global Default Commission**: Platform-wide default rate (typically 15%)

### Commission Configuration

| Level | Table | Description |
|-------|-------|-------------|
| Service | `service_commissions` | Override for specific services |
| Seller | `seller_commissions` | Override for specific sellers |
| Global | `top_seller_tags` | Default platform commission |

---

## Payment Integration

### Stripe Payment Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    STRIPE PAYMENT FLOW                           │
└─────────────────────────────────────────────────────────────────┘

┌──────────┐     ┌──────────┐     ┌──────────┐     ┌──────────┐
│  Buyer   │────►│DreamCrowd│────►│  Stripe  │────►│  Bank    │
│ Browser  │     │  Server  │     │   API    │     │ Network  │
└──────────┘     └──────────┘     └──────────┘     └──────────┘
     │                │                 │                │
     │  1. Checkout   │                 │                │
     │───────────────►│                 │                │
     │                │                 │                │
     │                │ 2. Create       │                │
     │                │ PaymentIntent   │                │
     │                │────────────────►│                │
     │                │                 │                │
     │                │ 3. Client       │                │
     │                │ Secret          │                │
     │                │◄────────────────│                │
     │                │                 │                │
     │ 4. Payment     │                 │                │
     │ Form           │                 │                │
     │◄───────────────│                 │                │
     │                │                 │                │
     │ 5. Card        │                 │                │
     │ Details        │                 │                │
     │────────────────────────────────►│                │
     │                │                 │                │
     │                │                 │ 6. Process    │
     │                │                 │ Payment       │
     │                │                 │───────────────►│
     │                │                 │                │
     │                │                 │ 7. Result     │
     │                │                 │◄───────────────│
     │                │                 │                │
     │                │ 8. Webhook      │                │
     │                │ Notification    │                │
     │                │◄────────────────│                │
     │                │                 │                │
     │ 9. Success     │                 │                │
     │ Redirect       │                 │                │
     │◄───────────────│                 │                │
     │                │                 │                │
```

### Refund Processing

- **Full Refund**: 100% of buyer payment returned
- **Partial Refund**: Percentage-based or fixed amount
- **Auto-Refund**: Triggered after 48 hours for uncontested disputes

---

## Installation

### Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- SQLite / MySQL / PostgreSQL

### Setup Steps

```bash
# Clone repository
git clone <repository-url>
cd dreamcrowd-backend

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database (for development)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Build frontend assets
npm run build

# Start development server
php artisan serve
```

### Environment Configuration

```env
# Application
APP_NAME=DreamCrowd
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=sqlite
# For MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=dreamcrowd
# DB_USERNAME=root
# DB_PASSWORD=

# Stripe
STRIPE_KEY=pk_test_...
STRIPE_SECRET=sk_test_...
STRIPE_WEBHOOK_SECRET=whsec_...

# OAuth (Google)
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=

# OAuth (Facebook)
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI=

# Mail
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
```

---

## Development Commands

### Server & Build

```bash
php artisan serve          # Start development server
npm run dev                # Start Vite dev server
npm run build              # Build for production
```

### Database

```bash
php artisan migrate              # Run migrations
php artisan migrate:rollback     # Rollback last migration
php artisan migrate:fresh        # Reset database
php artisan db:seed              # Seed database
```

### Testing

```bash
php artisan test                 # Run all tests
php artisan test --coverage      # With coverage report
```

### Code Quality

```bash
./vendor/bin/pint               # Format code with Laravel Pint
```

### Cache

```bash
php artisan cache:clear         # Clear cache
php artisan config:clear        # Clear config cache
php artisan route:clear         # Clear route cache
php artisan view:clear          # Clear view cache
php artisan optimize            # Optimize for production
```

### Scheduled Tasks (Manual)

```bash
php artisan orders:auto-cancel      # Cancel pending orders
php artisan orders:auto-deliver     # Mark orders delivered
php artisan orders:auto-complete    # Complete delivered orders
php artisan disputes:process        # Process disputes
php artisan schedule:list           # View scheduled tasks
```

---

## Architecture

### Directory Structure

```
dreamcrowd-backend/
├── app/
│   ├── Console/
│   │   ├── Commands/           # Artisan commands
│   │   │   ├── AutoMarkDelivered.php
│   │   │   ├── AutoMarkCompleted.php
│   │   │   └── AutoHandleDisputes.php
│   │   └── Kernel.php          # Task scheduler
│   ├── Http/
│   │   ├── Controllers/        # Request handlers
│   │   │   ├── BookingController.php
│   │   │   ├── TransactionController.php
│   │   │   └── AdminController.php
│   │   └── Middleware/         # Request filters
│   └── Models/                 # Eloquent models
│       ├── BookOrder.php
│       ├── Transaction.php
│       ├── TeacherGig.php
│       └── TopSellerTag.php
├── config/                     # Configuration files
├── database/
│   ├── migrations/             # Database schema
│   └── seeders/               # Test data
├── resources/
│   └── views/                  # Blade templates
│       ├── Public-site/        # Public pages
│       ├── Seller-listing/     # Service browsing
│       ├── Teacher-Dashboard/  # Seller dashboard
│       ├── User-Dashboard/     # Buyer dashboard
│       ├── Admin-Dashboard/    # Admin panel
│       └── emails/             # Email templates
├── routes/
│   └── web.php                 # Web routes
└── storage/
    └── logs/                   # Application logs
```

### Core Models

| Model | Description |
|-------|-------------|
| `BookOrder` | Service bookings with payment and status tracking |
| `Transaction` | Financial records for purchases |
| `TeacherGig` | Service listings with pricing and availability |
| `TeacherGigData` | Extended gig metadata (videos, resources) |
| `TeacherGigPayment` | Pricing tiers for services |
| `Coupon` | Discount codes with validation |
| `ServiceReviews` | Ratings and reviews |
| `DisputeOrder` | Dispute records and resolution |
| `ClassDate` | Scheduled class dates |
| `ClassReschedule` | Rescheduling requests |

### Key Controllers

| Controller | Responsibility |
|------------|----------------|
| `BookingController` | Service bookings, payments |
| `TransactionController` | Transaction history, invoices |
| `AdminController` | Admin dashboard, settings |
| `CouponController` | Coupon management |
| `StripeWebhookController` | Stripe event handling |

---

## Tech Stack

| Category | Technology |
|----------|------------|
| Backend | Laravel 11 (PHP 8.2+) |
| Frontend | Blade, Vite, TailwindCSS |
| Database | SQLite / MySQL / PostgreSQL |
| Payment | Stripe |
| Authentication | Laravel Sanctum, Socialite |
| PDF Generation | DomPDF |
| Excel Export | Maatwebsite Excel |
| Code Quality | Laravel Pint |

---

## License

This project is proprietary software. All rights reserved.

---

## Support

For questions or issues, please contact the development team.
