# DreamCrowd - Complete Implementation Guide & Gap Analysis

## 📋 Document Purpose
This document provides:
1. **Gap Analysis**: What exists vs what client requires
2. **Detailed Implementation Steps**: File-by-file action items
3. **Priority Roadmap**: What to build in what order
4. **Technical Specifications**: Exact code changes needed

---

# 🔍 CURRENT STATE ANALYSIS

## Existing Infrastructure (✅ What You Have)

### Controllers Present
- ✅ `BookingController.php` - Handles bookings (39,588 bytes - complex logic)
- ✅ `OrderManagementController.php` - Manages orders (131,236 bytes - very large)
- ✅ `MessagesController.php` - Messaging system (94,220 bytes - comprehensive)
- ✅ `AdminController.php` - Admin functions (52,914 bytes)
- ✅ `ClassManagementController.php` - Class management (58,479 bytes)
- ✅ `TeacherController.php` - Seller panel (36,454 bytes)
- ✅ `UserController.php` - Buyer panel (18,852 bytes)
- ✅ `StripeWebhookController.php` - Stripe webhooks (9,422 bytes)
- ✅ `ZoomController.php`, `ZoomOAuthController.php`, `ZoomJoinController.php`, `ZoomWebhookController.php` - Zoom integration
- ✅ `NotificationController.php` - Notification system (3,009 bytes)
- ✅ `TransactionController.php` - Transaction handling
- ✅ `DynamicManagementController.php` - Dynamic content (124,999 bytes - very large)

### Models Present
- ✅ `BookOrder.php` - Order model with relationships
- ✅ `TeacherGig.php` - Service/gig model
- ✅ `Transaction.php` - Payment transactions (12,981 bytes)
- ✅ `User.php` - User model (5,856 bytes)
- ✅ `TopSellerTag.php` - Commission calculations (4,978 bytes)
- ✅ `Coupon.php`, `CouponUsage.php` - Discount system
- ✅ `ClassDate.php`, `ClassReschedule.php` - Class scheduling
- ✅ `DisputeOrder.php` - Dispute handling
- ✅ `ServiceReviews.php` - Review system
- ✅ `Notification.php` - Notifications
- ✅ `ZoomMeeting.php`, `ZoomSetting.php`, `ZoomSecureToken.php` - Zoom integration
- ✅ `ServiceCommission.php`, `SellerCommission.php` - Custom commissions
- ✅ `WishList.php` - Wishlist functionality
- ✅ All category, subcategory, FAQ models

### Console Commands Present
- ✅ `AutoMarkDelivered.php` - Auto-deliver orders
- ✅ `AutoMarkCompleted.php` - Auto-complete orders
- ✅ `AutoHandleDisputes.php` - Process disputes
- ✅ `AutoCancelPendingOrders.php` - Cancel pending orders
- ✅ `UpdateTeacherGigStatus.php` - Update gig status
- ✅ `GenerateZoomMeetings.php` - Generate Zoom meetings
- ✅ `GenerateTrialMeetingLinks.php` - Generate trial meeting links
- ✅ `RefreshZoomToken.php` - Refresh Zoom OAuth token

### Services Present
- ✅ `NotificationService.php` - Notification management
- ✅ `ZoomMeetingService.php` - Zoom meeting creation
- ✅ `MessageService.php` - Message handling
- ✅ `AdminDashboardService.php` - Admin dashboard data
- ✅ `TeacherDashboardService.php` - Seller dashboard data
- ✅ `UserDashboardService.php` - Buyer dashboard data

### Mail Templates Present
- ✅ `ClassStartReminder.php` - Class reminders
- ✅ `TrialClassReminder.php` - Trial class reminders
- ✅ `TrialBookingConfirmation.php` - Trial booking confirmation
- ✅ `GuestClassInvitation.php` - Guest invitations
- ✅ `VerifyMail.php` - Email verification
- ✅ `ForgotPassword.php` - Password reset
- ✅ `NotificationMail.php` - General notifications
- ✅ `ContactMail.php`, `ChangeEmail.php` - Communication emails

### View Directories Present
- ✅ `Admin-Dashboard/` - Admin panel views
- ✅ `Teacher-Dashboard/` - Seller panel views
- ✅ `User-Dashboard/` - Buyer panel views
- ✅ `Seller-listing/` - Public service listings
- ✅ `Public-site/` - Homepage and marketing
- ✅ `emails/` - Email templates
- ✅ `components/` - Reusable components
- ✅ `shared/` - Shared views

---

# ❌ CRITICAL GAPS IDENTIFIED

## 1. Stripe Integration (CRITICAL GAP)

### Current State
```php
// In BookingController.php line 18-22
use Stripe;
use Stripe\PaymentIntent;

// Lines visible show:
'stripe_amount' => $finalPrice,
'stripe_currency' => $commissionSettings->stripe_currency ?? 'USD',
'stripe_transaction_id' => $paymentIntent ? $paymentIntent->id : null,
```

**ISSUE**: Stripe is imported but client says it's "just form submission"

### What's Missing
- ❌ Actual PaymentIntent creation and confirmation
- ❌ 3D Secure authentication handling
- ❌ Payment success/failure webhooks properly handled
- ❌ Refund automation via Stripe API
- ❌ Customer payment method management
- ❌ Seller payout via Stripe Connect

### Action Required
**File: `app/Http/Controllers/BookingController.php`**

**Current Issue**: Need to verify if PaymentIntent is actually created or just referenced

**Required Changes**:
1. Add complete Stripe payment flow
2. Create PaymentIntent on booking page load
3. Confirm payment on client side
4. Handle webhook events properly
5. Add error handling and retry logic

## 2. Real-Time Updates (CRITICAL GAP)

### Current State
- ✅ NotificationController exists (3,009 bytes - very small)
- ✅ NotificationService exists
- ✅ Routes for notifications exist
- ❓ Real-time broadcasting unclear

### What's Missing
- ❌ WebSocket/Pusher integration for real-time
- ❌ Live dashboard updates without refresh
- ❌ Live message updates
- ❌ Live notification popups
- ❌ Order status live updates

### Action Required
**Files to Modify**:
- `config/broadcasting.php` - Configure Pusher/Laravel Echo
- `app/Events/MessageSent.php` - Already exists, needs broadcasting
- `app/Events/NotificationSent.php` - Already exists, needs broadcasting
- All dashboard views - Add JavaScript for real-time updates

## 3. Video Course Access System (MAJOR GAP)

### Current State
- ✅ Course service view exists: `/course-service/{id}` route
- ✅ TeacherGig model handles different service types
- ❓ Video access and lock/unlock logic unclear

### What's Missing
- ❌ "My Learning" section for buyers
- ❌ Video player with progress tracking
- ❌ Content lock/unlock mechanism
- ❌ "Mark as Satisfactory/Unsatisfactory" functionality
- ❌ Video course specific refund flow

### Action Required
**New Files Needed**:
- `app/Http/Controllers/VideoCourseController.php` - New controller
- `resources/views/User-Dashboard/my-learning.blade.php` - New view
- `resources/views/User-Dashboard/video-player.blade.php` - New view
- Database migrations for video progress tracking

**Tables Needed**:
- `video_course_progress` - Track video viewing progress
- `video_course_access` - Manage content unlock logic

## 4. Custom Offers (MAJOR GAP)

### Current State
- ✅ MessagesController.php exists (94,220 bytes - large file)
- ❓ Custom offer functionality unclear

### What's Missing
- ❌ Custom offer creation flow (class booking)
- ❌ Custom offer creation flow (freelance service)
- ❌ Milestone payment options
- ❌ Buyer approval/rejection system
- ❌ Payment processing after approval

### Action Required
**File: `app/Http/Controllers/MessagesController.php`**
- Add custom offer methods:
  - `createCustomOffer()`
  - `sendCustomOffer()`
  - `approveCustomOffer()`
  - `rejectCustomOffer()`
  - `processCustomOfferPayment()`

**New Database Table Needed**:
- `custom_offers` table with fields:
  - offer_id, message_id, seller_id, buyer_id
  - offer_type (class/freelance)
  - payment_type (single/milestone)
  - offer_details (JSON)
  - status (pending/approved/rejected)
  - created_at, updated_at

## 5. Trial Classes (MAJOR GAP)

### Current State
- ✅ `GenerateTrialMeetingLinks.php` command exists
- ✅ `TrialClassReminder.php` mail exists
- ✅ `TrialBookingConfirmation.php` mail exists
- ❓ Trial class creation in service setup unclear

### What's Missing
- ❌ Trial class option in class creation form
- ❌ Free vs Paid trial differentiation
- ❌ Trial class filter on listing page
- ❌ Trial class validation (must be live, one-off)

### Action Required
**File: `app/Http/Controllers/ClassManagementController.php`**
- Add trial class creation logic
- Add validation: only for live classes + one-off payment
- Free trial: fixed 30 min, $0
- Paid trial: custom duration and price

**File: `resources/views/Teacher-Dashboard/create-service.blade.php`**
- Add "Trial Class" option (radio button)
- Show only when "Live" and "One-off Payment" selected
- Add free/paid selection
- Lock duration and price for free trial

**File: `app/Http/Controllers/SellerListingController.php`**
- Add trial class filter
- Default: show only "Ongoing Class"
- Filter options: Ongoing, One-Day, Free Trial, Paid Trial

---

# 🚀 PHASED IMPLEMENTATION ROADMAP

## PHASE 1: CRITICAL BUG FIXES (Week 1)
**Estimated Time**: 3-5 days

### Task 1.1: Fix Booking Button Visibility Bug
**Priority**: 🔴 CRITICAL
**File**: `resources/views/Seller-listing/booking-page.blade.php` (or similar)

**Current Issue**: Buttons not appearing consistently

**Steps**:
1. Find booking page view file:
```bash
find resources/views -name "*booking*.blade.php"
```

2. Locate button rendering code:
```html
<!-- Look for something like this -->
@if(auth()->check())
    <button>Contact</button>
    <button>Confirm Booking</button>
@endif
```

3. Fix to always show buttons:
```html
<!-- Replace with -->
<button onclick="handleContact()">Contact</button>
<button onclick="handleBooking()">Confirm Booking</button>

<script>
function handleContact() {
    @if(!auth()->check())
        $('#loginModal').modal('show');
    @else
        // Proceed with contact
        window.location.href = '/messages/...';
    @endif
}

function handleBooking() {
    @if(!auth()->check())
        $('#loginModal').modal('show');
    @else
        // Proceed with booking
        // existing booking logic
    @endif
}
</script>
```

4. Test with:
   - Logged out user
   - Normal registered user
   - Google login user
   - Facebook login user

### Task 1.2: Fix Message Internal Error
**Priority**: 🔴 CRITICAL
**File**: `app/Http/Controllers/MessagesController.php`

**Current Issue**: Internal error with normal registration, works with Google login

**Debugging Steps**:
1. Add logging to MessagesController:
```php
public function index() {
    \Log::info('Messages accessed', [
        'user_id' => auth()->id(),
        'auth_method' => auth()->user()->provider ?? 'email',
        'user_data' => auth()->user()
    ]);

    // existing code
}
```

2. Check logs after accessing with both methods:
```bash
tail -f storage/logs/laravel.log
```

3. Likely issues to check:
   - Missing user profile data for email registrations
   - Different user table fields between OAuth and email
   - Missing relationships (ExpertProfile, etc.)

**Probable Fix**:
```php
// In MessagesController
public function index() {
    $user = auth()->user();

    // Check if expert profile exists for sellers
    if ($user->user_role === 'expert') {
        $profile = ExpertProfile::firstOrCreate(
            ['user_id' => $user->id],
            ['status' => 1, /* other defaults */]
        );
    }

    // Rest of code
}
```

### Task 1.3: Fix Search Bar Errors
**Priority**: 🔴 CRITICAL
**File**: `app/Http/Controllers/SellerListingController.php`

**Method to check**: `SellerListingServiceSearch()` or `SellerListingSearch()`

**Steps**:
1. Test search functionality
2. Check error logs
3. Common issues:
   - SQL injection vulnerability (use prepared statements)
   - Missing validation on search input
   - Null pointer on empty search

**Example Fix**:
```php
public function SellerListingServiceSearch(Request $request) {
    $request->validate([
        'search' => 'nullable|string|max:255',
        'category' => 'nullable|exists:categories,id',
    ]);

    $search = $request->input('search', '');

    try {
        $gigs = TeacherGig::query()
            ->when($search, function($query, $search) {
                $query->where('title', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->where('status', 1)
            ->paginate(20);

        return view('Seller-listing.search-results', compact('gigs', 'search'));
    } catch (\Exception $e) {
        \Log::error('Search error: ' . $e->getMessage());
        return back()->with('error', 'Search failed. Please try again.');
    }
}
```

---

## PHASE 2: STRIPE COMPLETE INTEGRATION (Week 1-2)
**Estimated Time**: 5-7 days

### Task 2.1: Setup Stripe Properly
**Files**:
- `config/services.php`
- `.env`
- `composer.json`

**Steps**:

1. Ensure Stripe package installed:
```bash
composer require stripe/stripe-php
```

2. Add to `.env`:
```env
STRIPE_KEY=pk_test_your_publishable_key
STRIPE_SECRET=sk_test_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret
```

3. Add to `config/services.php`:
```php
'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
],
```

### Task 2.2: Implement PaymentIntent Flow
**File**: `app/Http/Controllers/BookingController.php`

**Current Code Analysis Needed**:
```bash
# Check what's actually implemented
grep -A 20 "PaymentIntent" app/Http/Controllers/BookingController.php
```

**Required Implementation**:

```php
// In BookingController.php

use Stripe\StripeClient;

public function createPaymentIntent(Request $request) {
    $stripe = new StripeClient(config('services.stripe.secret'));

    // Calculate amounts
    $gig = TeacherGig::findOrFail($request->gig_id);
    $commission = TopSellerTag::calculateCommission($gig->id, $gig->user_id);

    $servicePrice = $request->total_price;
    $buyerCommission = $commission['buyer_commission'];
    $totalAmount = $servicePrice + $buyerCommission;

    try {
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $totalAmount * 100, // Convert to cents
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'metadata' => [
                'gig_id' => $gig->id,
                'user_id' => auth()->id(),
                'seller_id' => $gig->user_id,
                'service_price' => $servicePrice,
                'buyer_commission' => $buyerCommission,
            ],
        ]);

        return response()->json([
            'clientSecret' => $paymentIntent->client_secret,
            'paymentIntentId' => $paymentIntent->id,
        ]);
    } catch (\Exception $e) {
        \Log::error('Stripe Payment Intent Error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function confirmPayment(Request $request) {
    $paymentIntentId = $request->payment_intent_id;

    $stripe = new StripeClient(config('services.stripe.secret'));

    try {
        $paymentIntent = $stripe->paymentIntents->retrieve($paymentIntentId);

        if ($paymentIntent->status === 'succeeded') {
            // Create order
            $order = $this->createOrder($paymentIntent);

            // Create transaction
            $this->createTransaction($paymentIntent, $order);

            // Send notifications
            $this->notificationService->sendOrderNotification($order);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
            ]);
        }

        return response()->json(['error' => 'Payment not completed'], 400);
    } catch (\Exception $e) {
        \Log::error('Payment Confirmation Error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
```

**Frontend Integration** (in booking page view):
```html
<!-- Add Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
const stripe = Stripe('{{ config('services.stripe.key') }}');
let elements, paymentElement;

// Initialize payment
async function initializePayment() {
    const response = await fetch('/create-payment-intent', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            gig_id: gigId,
            total_price: totalPrice,
            // other booking details
        })
    });

    const { clientSecret } = await response.json();

    elements = stripe.elements({ clientSecret });
    paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');
}

// Handle payment submission
async function handlePayment(e) {
    e.preventDefault();

    const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: {
            return_url: '{{ url('/booking-success') }}',
        },
    });

    if (error) {
        document.getElementById('error-message').textContent = error.message;
    }
}

initializePayment();
</script>
```

### Task 2.3: Implement Stripe Webhooks Properly
**File**: `app/Http/Controllers/StripeWebhookController.php`

**Current Size**: 9,422 bytes (exists but needs verification)

**Required Webhook Events**:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            \Log::error('Webhook signature verification failed: ' . $e->getMessage());
            return response('Webhook signature verification failed', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentFailed($event->data->object);
                break;

            case 'charge.refunded':
                $this->handleRefund($event->data->object);
                break;

            case 'customer.subscription.created':
                $this->handleSubscriptionCreated($event->data->object);
                break;

            case 'customer.subscription.deleted':
                $this->handleSubscriptionDeleted($event->data->object);
                break;

            default:
                \Log::info('Unhandled webhook event: ' . $event->type);
        }

        return response('Webhook handled', 200);
    }

    private function handlePaymentSucceeded($paymentIntent)
    {
        // Already handled in confirmPayment, but good for redundancy
        $order = BookOrder::where('stripe_transaction_id', $paymentIntent->id)->first();

        if ($order && $order->status == 0) {
            // Update to active if seller auto-approves, else keep pending
            \Log::info('Payment succeeded for order: ' . $order->id);
        }
    }

    private function handlePaymentFailed($paymentIntent)
    {
        $gigId = $paymentIntent->metadata->gig_id ?? null;
        $userId = $paymentIntent->metadata->user_id ?? null;

        \Log::error('Payment failed', [
            'payment_intent_id' => $paymentIntent->id,
            'user_id' => $userId,
            'gig_id' => $gigId,
            'failure_reason' => $paymentIntent->last_payment_error->message ?? 'Unknown'
        ]);

        // Send notification to user about failed payment
        if ($userId) {
            // Implement notification
        }
    }

    private function handleRefund($charge)
    {
        // Find transaction by charge ID
        $transaction = Transaction::where('stripe_transaction_id', $charge->payment_intent)->first();

        if ($transaction) {
            $transaction->update([
                'refund_status' => 'refunded',
                'refund_amount' => $charge->amount_refunded / 100,
                'refunded_at' => now(),
            ]);

            // Update related order
            $order = BookOrder::find($transaction->order_id);
            if ($order) {
                $order->update(['status' => 4]); // Cancelled
            }

            // Send notifications
            $this->notificationService->sendRefundNotification($transaction);
        }
    }
}
```

**Register Webhook Route**:
```php
// In routes/web.php (or routes/api.php)
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
    ->name('stripe.webhook')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
```

### Task 2.4: Implement Automatic Refunds
**File**: `app/Console/Commands/AutoHandleDisputes.php`

**Current Size**: 15,111 bytes (exists - needs enhancement)

**Enhancement Needed**:
```php
public function handle()
{
    $this->info('Starting automatic refund processing...');

    // Find orders that need automatic refund
    $ordersToRefund = BookOrder::where('status', 4) // Cancelled
        ->where('user_dispute', 1)
        ->where('teacher_dispute', 0)
        ->where(function($query) {
            $query->whereNull('dispute_deadline')
                  ->orWhere('dispute_deadline', '<=', now());
        })
        ->whereNull('refund_processed_at')
        ->get();

    foreach ($ordersToRefund as $order) {
        try {
            $this->processRefund($order);
        } catch (\Exception $e) {
            \Log::error('Auto refund failed for order ' . $order->id . ': ' . $e->getMessage());
        }
    }

    $this->info('Refund processing completed.');
}

private function processRefund($order)
{
    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

    $transaction = Transaction::where('order_id', $order->id)->first();

    if (!$transaction || !$transaction->stripe_transaction_id) {
        throw new \Exception('Transaction not found or no Stripe transaction ID');
    }

    // Calculate refund amount
    $refundAmount = $order->refund_amount ?? $transaction->total_amount;

    // Create refund in Stripe
    $refund = $stripe->refunds->create([
        'payment_intent' => $transaction->stripe_transaction_id,
        'amount' => $refundAmount * 100, // Convert to cents
        'reason' => 'requested_by_customer',
        'metadata' => [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'automatic_refund' => 'true',
        ],
    ]);

    // Update order
    $order->update([
        'refund_processed_at' => now(),
        'refund_status' => 'completed',
        'stripe_refund_id' => $refund->id,
    ]);

    // Update transaction
    $transaction->update([
        'refund_status' => 'refunded',
        'refund_amount' => $refundAmount,
        'refunded_at' => now(),
    ]);

    // Send notifications
    $this->notificationService->sendRefundCompletedNotification($order);

    $this->info("Refund processed for order {$order->id}: \${$refundAmount}");

    \Log::info('Automatic refund processed', [
        'order_id' => $order->id,
        'refund_id' => $refund->id,
        'amount' => $refundAmount,
    ]);
}
```

### Task 2.5: Buyer Card Management
**New File**: `app/Http/Controllers/PaymentMethodController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;

class PaymentMethodController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function index()
    {
        $user = auth()->user();

        // Get or create Stripe customer
        if (!$user->stripe_customer_id) {
            $customer = $this->stripe->customers->create([
                'email' => $user->email,
                'name' => $user->name,
                'metadata' => ['user_id' => $user->id],
            ]);

            $user->update(['stripe_customer_id' => $customer->id]);
        }

        // Retrieve payment methods
        $paymentMethods = $this->stripe->paymentMethods->all([
            'customer' => $user->stripe_customer_id,
            'type' => 'card',
        ]);

        return view('User-Dashboard.payment-methods', [
            'paymentMethods' => $paymentMethods->data
        ]);
    }

    public function setupIntent()
    {
        $user = auth()->user();

        if (!$user->stripe_customer_id) {
            $customer = $this->stripe->customers->create([
                'email' => $user->email,
                'name' => $user->name,
            ]);
            $user->update(['stripe_customer_id' => $customer->id]);
        }

        $setupIntent = $this->stripe->setupIntents->create([
            'customer' => $user->stripe_customer_id,
            'payment_method_types' => ['card'],
        ]);

        return response()->json([
            'clientSecret' => $setupIntent->client_secret
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $paymentMethod = $this->stripe->paymentMethods->attach(
            $request->payment_method_id,
            ['customer' => $user->stripe_customer_id]
        );

        // Set as default if it's the first card or explicitly requested
        if ($request->set_default) {
            $this->stripe->customers->update($user->stripe_customer_id, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod->id,
                ],
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy($paymentMethodId)
    {
        $this->stripe->paymentMethods->detach($paymentMethodId);

        return response()->json(['success' => true]);
    }

    public function setDefault(Request $request)
    {
        $user = auth()->user();

        $this->stripe->customers->update($user->stripe_customer_id, [
            'invoice_settings' => [
                'default_payment_method' => $request->payment_method_id,
            ],
        ]);

        return response()->json(['success' => true]);
    }
}
```

**Routes**:
```php
// Add to routes/web.php
Route::middleware('auth')->group(function() {
    Route::get('/payment-methods', [PaymentMethodController::class, 'index']);
    Route::post('/payment-methods/setup-intent', [PaymentMethodController::class, 'setupIntent']);
    Route::post('/payment-methods', [PaymentMethodController::class, 'store']);
    Route::delete('/payment-methods/{id}', [PaymentMethodController::class, 'destroy']);
    Route::post('/payment-methods/{id}/set-default', [PaymentMethodController::class, 'setDefault']);
});
```

**View**: `resources/views/User-Dashboard/payment-methods.blade.php`

```html
@extends('layouts.user-dashboard')

@section('content')
<div class="payment-methods-page">
    <h2>Payment Methods</h2>

    <div class="saved-cards">
        @forelse($paymentMethods as $pm)
            <div class="card-item">
                <div class="card-info">
                    <i class="fab fa-cc-{{ strtolower($pm->card->brand) }}"></i>
                    <span>•••• •••• •••• {{ $pm->card->last4 }}</span>
                    <span>Expires {{ $pm->card->exp_month }}/{{ $pm->card->exp_year }}</span>
                </div>
                <div class="card-actions">
                    <button onclick="setDefault('{{ $pm->id }}')">Set Default</button>
                    <button onclick="deleteCard('{{ $pm->id }}')">Delete</button>
                </div>
            </div>
        @empty
            <p>No saved payment methods</p>
        @endforelse
    </div>

    <button onclick="addNewCard()">+ Add New Card</button>

    <div id="add-card-modal" style="display:none;">
        <form id="payment-form">
            <div id="card-element"></div>
            <button type="submit">Save Card</button>
        </form>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{ config('services.stripe.key') }}');
let elements, cardElement;

async function addNewCard() {
    document.getElementById('add-card-modal').style.display = 'block';

    const response = await fetch('/payment-methods/setup-intent', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });

    const { clientSecret } = await response.json();

    elements = stripe.elements({ clientSecret });
    cardElement = elements.create('card');
    cardElement.mount('#card-element');
}

document.getElementById('payment-form').addEventListener('submit', async (e) => {
    e.preventDefault();

    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret,
        {
            payment_method: {
                card: cardElement,
            }
        }
    );

    if (error) {
        alert(error.message);
    } else {
        // Save payment method
        await fetch('/payment-methods', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                payment_method_id: setupIntent.payment_method,
                set_default: true
            })
        });

        location.reload();
    }
});

async function deleteCard(pmId) {
    if (confirm('Delete this card?')) {
        await fetch(`/payment-methods/${pmId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        location.reload();
    }
}

async function setDefault(pmId) {
    await fetch(`/payment-methods/${pmId}/set-default`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
    location.reload();
}
</script>
@endsection
```

### Task 2.6: Seller Payouts (Stripe Connect)
**New File**: `app/Http/Controllers/PayoutController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use App\Models\Transaction;

class PayoutController extends Controller
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function connectAccount()
    {
        $user = auth()->user();

        if (!$user->stripe_connect_id) {
            // Create Stripe Connect account
            $account = $this->stripe->accounts->create([
                'type' => 'express',
                'country' => 'US',
                'email' => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
            ]);

            $user->update(['stripe_connect_id' => $account->id]);
        }

        // Create account link for onboarding
        $accountLink = $this->stripe->accountLinks->create([
            'account' => $user->stripe_connect_id,
            'refresh_url' => route('payout.connect'),
            'return_url' => route('teacher.earnings'),
            'type' => 'account_onboarding',
        ]);

        return redirect($accountLink->url);
    }

    public function requestPayout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
        ]);

        $user = auth()->user();
        $amount = $request->amount;

        // Check available balance
        $availableBalance = $this->getAvailableBalance($user->id);

        if ($amount > $availableBalance) {
            return back()->with('error', 'Insufficient balance');
        }

        // Create transfer to connected account
        try {
            $transfer = $this->stripe->transfers->create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'destination' => $user->stripe_connect_id,
                'description' => 'Seller payout for ' . $user->name,
            ]);

            // Record payout
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'payout',
                'amount' => $amount,
                'status' => 'completed',
                'stripe_transfer_id' => $transfer->id,
                'created_at' => now(),
            ]);

            return back()->with('success', 'Payout processed successfully');
        } catch (\Exception $e) {
            \Log::error('Payout failed: ' . $e->getMessage());
            return back()->with('error', 'Payout failed: ' . $e->getMessage());
        }
    }

    private function getAvailableBalance($userId)
    {
        $earned = Transaction::where('seller_id', $userId)
            ->where('status', 'completed')
            ->sum('seller_amount');

        $withdrawn = Transaction::where('user_id', $userId)
            ->where('type', 'payout')
            ->sum('amount');

        return $earned - $withdrawn;
    }
}
```

---

## PHASE 3: REAL-TIME UPDATES (Week 2)
**Estimated Time**: 3-5 days

### Task 3.1: Setup Laravel Broadcasting
**Files**:
- `config/broadcasting.php`
- `.env`
- `composer.json`

**Steps**:

1. Install Pusher:
```bash
composer require pusher/pusher-php-server
npm install --save-dev laravel-echo pusher-js
```

2. Configure `.env`:
```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=mt1
```

3. Update `config/broadcasting.php`:
```php
'connections' => [
    'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true,
        ],
    ],
],
```

4. Enable broadcasting in `config/app.php`:
```php
'providers' => [
    // Uncomment this line
    App\Providers\BroadcastServiceProvider::class,
],
```

### Task 3.2: Update Event Classes
**File**: `app/Events/MessageSent.php`

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $recipient;

    public function __construct($message, $sender, $recipient)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->recipient = $recipient;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->recipient->id);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message->toArray(),
            'sender' => [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'avatar' => $this->sender->avatar,
            ],
        ];
    }
}
```

**File**: `app/Events/NotificationSent.php`

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $user;

    public function __construct($notification, $user)
    {
        $this->notification = $notification;
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastAs()
    {
        return 'notification.sent';
    }

    public function broadcastWith()
    {
        return [
            'notification' => $this->notification->toArray(),
        ];
    }
}
```

### Task 3.3: Trigger Events in Controllers
**File**: `app/Http/Controllers/MessagesController.php`

```php
use App\Events\MessageSent;

public function sendMessage(Request $request)
{
    // Existing validation and message creation

    $message = Message::create([
        // message data
    ]);

    // Broadcast event
    broadcast(new MessageSent(
        $message,
        auth()->user(),
        User::find($request->recipient_id)
    ))->toOthers();

    return response()->json(['success' => true, 'message' => $message]);
}
```

**File**: `app/Services/NotificationService.php`

```php
use App\Events\NotificationSent;

public function sendNotification($userId, $title, $message, $type = 'info')
{
    $notification = Notification::create([
        'user_id' => $userId,
        'title' => $title,
        'message' => $message,
        'type' => $type,
        'read_at' => null,
    ]);

    // Broadcast event
    broadcast(new NotificationSent(
        $notification,
        User::find($userId)
    ));

    return $notification;
}
```

### Task 3.4: Frontend Laravel Echo Setup
**File**: `resources/js/bootstrap.js`

```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }
});
```

### Task 3.5: Listen to Events in Views
**Add to**: All dashboard layouts

```html
<!-- In layout file (e.g., resources/views/layouts/user-dashboard.blade.php) -->
<script>
@auth
    // Listen for new messages
    Echo.private('user.{{ auth()->id() }}')
        .listen('.message.sent', (e) => {
            console.log('New message:', e.message);

            // Update message list
            updateMessageList(e.message);

            // Show notification
            showNotificationToast('New message from ' + e.sender.name);

            // Update unread count
            incrementUnreadCount();
        });

    // Listen for notifications
    Echo.private('user.{{ auth()->id() }}')
        .listen('.notification.sent', (e) => {
            console.log('New notification:', e.notification);

            // Update notification dropdown
            addNotificationToDropdown(e.notification);

            // Show toast
            showNotificationToast(e.notification.title);

            // Update notification badge
            incrementNotificationBadge();
        });

    // Listen for order status changes
    Echo.private('user.{{ auth()->id() }}')
        .listen('.order.status.changed', (e) => {
            console.log('Order status changed:', e.order);

            // Update order in list
            updateOrderStatus(e.order);

            // Show notification
            showNotificationToast('Order #' + e.order.id + ' status updated');
        });
@endauth

function updateMessageList(message) {
    // Prepend new message to list
    const messageList = document.getElementById('message-list');
    if (messageList) {
        const messageHtml = `
            <div class="message" data-id="${message.id}">
                <div class="message-sender">${message.sender.name}</div>
                <div class="message-content">${message.content}</div>
                <div class="message-time">${message.created_at}</div>
            </div>
        `;
        messageList.insertAdjacentHTML('afterbegin', messageHtml);
    }
}

function addNotificationToDropdown(notification) {
    const dropdown = document.getElementById('notifications-dropdown');
    if (dropdown) {
        const notifHtml = `
            <div class="notification-item unread" data-id="${notification.id}">
                <div class="notification-title">${notification.title}</div>
                <div class="notification-message">${notification.message}</div>
                <div class="notification-time">${notification.created_at}</div>
            </div>
        `;
        dropdown.insertAdjacentHTML('afterbegin', notifHtml);
    }
}

function incrementUnreadCount() {
    const badge = document.getElementById('unread-messages-badge');
    if (badge) {
        let count = parseInt(badge.textContent) || 0;
        badge.textContent = count + 1;
        badge.style.display = 'inline-block';
    }
}

function incrementNotificationBadge() {
    const badge = document.getElementById('notification-badge');
    if (badge) {
        let count = parseInt(badge.textContent) || 0;
        badge.textContent = count + 1;
        badge.style.display = 'inline-block';
    }
}

function showNotificationToast(message) {
    // Use your preferred toast library or custom implementation
    // Example with simple toast
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function updateOrderStatus(order) {
    const orderElement = document.querySelector(`[data-order-id="${order.id}"]`);
    if (orderElement) {
        const statusBadge = orderElement.querySelector('.order-status');
        if (statusBadge) {
            statusBadge.textContent = order.status_text;
            statusBadge.className = `order-status status-${order.status}`;
        }
    }
}
</script>
```

---

## PHASE 4: VIDEO COURSES (Week 3)
**Estimated Time**: 5-7 days

### Task 4.1: Create Video Course Tables

**Migration**: `database/migrations/xxxx_create_video_course_tables.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Video course sections (chapters)
        Schema::create('video_course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gig_id')->constrained('teacher_gigs')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Video course lessons
        Schema::create('video_course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('video_course_sections')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url'); // S3 or YouTube URL
            $table->integer('duration_minutes')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_free_preview')->default(false);
            $table->timestamps();
        });

        // User video progress
        Schema::create('video_course_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained('book_orders')->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained('video_course_lessons')->onDelete('cascade');
            $table->integer('watched_seconds')->default(0);
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });

        // Video course access
        Schema::create('video_course_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('gig_id')->constrained('teacher_gigs')->onDelete('cascade');
            $table->foreignId('order_id')->constrained('book_orders')->onDelete('cascade');
            $table->timestamp('access_granted_at');
            $table->timestamp('expires_at')->nullable(); // For time-limited access
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->timestamps();

            $table->unique(['user_id', 'gig_id', 'order_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('video_course_progress');
        Schema::dropIfExists('video_course_access');
        Schema::dropIfExists('video_course_lessons');
        Schema::dropIfExists('video_course_sections');
    }
};
```

Run migration:
```bash
php artisan migrate
```

### Task 4.2: Create Video Course Models

**File**: `app/Models/VideoCourseSection.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCourseSection extends Model
{
    protected $fillable = [
        'gig_id', 'title', 'description', 'order'
    ];

    public function gig()
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    public function lessons()
    {
        return $this->hasMany(VideoCourseLesson::class, 'section_id')->orderBy('order');
    }
}
```

**File**: `app/Models/VideoCourseLesson.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCourseLesson extends Model
{
    protected $fillable = [
        'section_id', 'title', 'description', 'video_url',
        'duration_minutes', 'order', 'is_free_preview'
    ];

    protected $casts = [
        'is_free_preview' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(VideoCourseSection::class, 'section_id');
    }

    public function progress()
    {
        return $this->hasMany(VideoCourseProgress::class, 'lesson_id');
    }

    public function userProgress($userId)
    {
        return $this->hasOne(VideoCourseProgress::class, 'lesson_id')
                    ->where('user_id', $userId);
    }
}
```

**File**: `app/Models/VideoCourseProgress.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCourseProgress extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'lesson_id',
        'watched_seconds', 'completed', 'completed_at'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(VideoCourseLesson::class, 'lesson_id');
    }

    public function order()
    {
        return $this->belongsTo(BookOrder::class, 'order_id');
    }
}
```

**File**: `app/Models/VideoCourseAccess.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoCourseAccess extends Model
{
    protected $fillable = [
        'user_id', 'gig_id', 'order_id',
        'access_granted_at', 'expires_at', 'status'
    ];

    protected $casts = [
        'access_granted_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gig()
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    public function order()
    {
        return $this->belongsTo(BookOrder::class, 'order_id');
    }

    public function hasAccess()
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            $this->update(['status' => 'expired']);
            return false;
        }

        return true;
    }
}
```

### Task 4.3: Create Video Course Controller

**File**: `app/Http/Controllers/VideoCourseController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeacherGig;
use App\Models\BookOrder;
use App\Models\VideoCourseSection;
use App\Models\VideoCourseLesson;
use App\Models\VideoCourseProgress;
use App\Models\VideoCourseAccess;

class VideoCourseController extends Controller
{
    public function myLearning()
    {
        $user = auth()->user();

        // Get all video courses user has access to
        $videoCourses = VideoCourseAccess::where('user_id', $user->id)
            ->where('status', 'active')
            ->with(['gig', 'order'])
            ->get()
            ->map(function($access) use ($user) {
                $gig = $access->gig;

                // Calculate progress
                $totalLessons = VideoCourseLesson::whereHas('section', function($q) use ($gig) {
                    $q->where('gig_id', $gig->id);
                })->count();

                $completedLessons = VideoCourseProgress::where('user_id', $user->id)
                    ->where('order_id', $access->order_id)
                    ->where('completed', true)
                    ->count();

                $progress = $totalLessons > 0 ? ($completedLessons / $totalLessons) * 100 : 0;

                return [
                    'gig' => $gig,
                    'order' => $access->order,
                    'progress' => round($progress),
                    'total_lessons' => $totalLessons,
                    'completed_lessons' => $completedLessons,
                ];
            });

        return view('User-Dashboard.my-learning', compact('videoCourses'));
    }

    public function accessCourse($orderId)
    {
        $user = auth()->user();
        $order = BookOrder::where('id', $orderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Check access
        $access = VideoCourseAccess::where('user_id', $user->id)
            ->where('order_id', $order->id)
            ->firstOrFail();

        if (!$access->hasAccess()) {
            return redirect()->route('user.my-learning')
                ->with('error', 'You no longer have access to this course');
        }

        $gig = $order->gig;

        // Get course content
        $sections = VideoCourseSection::where('gig_id', $gig->id)
            ->with(['lessons' => function($q) use ($user, $order) {
                $q->with(['userProgress' => function($q2) use ($user, $order) {
                    $q2->where('user_id', $user->id)
                       ->where('order_id', $order->id);
                }]);
            }])
            ->orderBy('order')
            ->get();

        return view('User-Dashboard.video-course-player', compact('gig', 'order', 'sections', 'access'));
    }

    public function updateProgress(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:video_course_lessons,id',
            'order_id' => 'required|exists:book_orders,id',
            'watched_seconds' => 'required|integer',
        ]);

        $user = auth()->user();
        $lesson = VideoCourseLesson::findOrFail($request->lesson_id);

        // Check access
        $access = VideoCourseAccess::where('user_id', $user->id)
            ->where('order_id', $request->order_id)
            ->firstOrFail();

        if (!$access->hasAccess()) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        // Update progress
        $progress = VideoCourseProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'order_id' => $request->order_id,
                'lesson_id' => $lesson->id,
            ],
            [
                'watched_seconds' => $request->watched_seconds,
                'completed' => $request->watched_seconds >= ($lesson->duration_minutes * 60 * 0.9), // 90% completion
            ]
        );

        if ($progress->completed && !$progress->completed_at) {
            $progress->update(['completed_at' => now()]);
        }

        return response()->json(['success' => true, 'progress' => $progress]);
    }

    public function markSatisfactory($orderId)
    {
        $user = auth()->user();
        $order = BookOrder::where('id', $orderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $order->update([
            'status' => 3, // Completed
            'satisfaction_status' => 'satisfied',
        ]);

        return redirect()->route('user.my-learning')
            ->with('success', 'Marked as satisfactory');
    }

    public function markUnsatisfactory($orderId)
    {
        $user = auth()->user();
        $order = BookOrder::where('id', $orderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $order->update([
            'satisfaction_status' => 'unsatisfied',
        ]);

        // Show options popup
        return view('User-Dashboard.unsatisfactory-options', compact('order'));
    }
}
```

**Routes**:
```php
// Add to routes/web.php
Route::middleware('auth')->prefix('user')->group(function() {
    Route::get('/my-learning', [VideoCourseController::class, 'myLearning'])->name('user.my-learning');
    Route::get('/video-course/{orderId}', [VideoCourseController::class, 'accessCourse'])->name('user.video-course');
    Route::post('/video-course/progress', [VideoCourseController::class, 'updateProgress']);
    Route::post('/video-course/{orderId}/satisfactory', [VideoCourseController::class, 'markSatisfactory']);
    Route::post('/video-course/{orderId}/unsatisfactory', [VideoCourseController::class, 'markUnsatisfactory']);
});
```

### Task 4.4: Create Video Player View

**File**: `resources/views/User-Dashboard/my-learning.blade.php`

```html
@extends('layouts.user-dashboard')

@section('content')
<div class="my-learning-page">
    <h2>My Learning</h2>

    <div class="video-courses-grid">
        @forelse($videoCourses as $course)
            <div class="course-card">
                <div class="course-thumbnail">
                    <img src="{{ $course['gig']->thumbnail }}" alt="{{ $course['gig']->title }}">
                    <div class="course-progress-overlay">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $course['progress'] }}%"></div>
                        </div>
                        <span class="progress-text">{{ $course['progress'] }}% Complete</span>
                    </div>
                </div>

                <div class="course-info">
                    <h3>{{ $course['gig']->title }}</h3>
                    <p class="course-meta">
                        {{ $course['completed_lessons'] }} / {{ $course['total_lessons'] }} lessons completed
                    </p>

                    <div class="course-actions">
                        <a href="{{ route('user.video-course', $course['order']->id) }}"
                           class="btn btn-primary">
                            Access Class
                        </a>

                        @if($course['order']->satisfaction_status === null)
                            <button onclick="markSatisfactory({{ $course['order']->id }})"
                                    class="btn btn-success">
                                Mark as Satisfactory
                            </button>
                            <button onclick="markUnsatisfactory({{ $course['order']->id }})"
                                    class="btn btn-warning">
                                Mark as Unsatisfactory
                            </button>
                        @endif

                        <a href="{{ route('user.review-order', $course['order']->id) }}"
                           class="btn btn-secondary">
                            Rate & Review
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p>No video courses yet</p>
                <a href="{{ url('/seller-listing') }}" class="btn btn-primary">
                    Browse Courses
                </a>
            </div>
        @endforelse
    </div>
</div>

<script>
function markSatisfactory(orderId) {
    if (confirm('Mark this course as satisfactory?')) {
        fetch(`/user/video-course/${orderId}/satisfactory`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    }
}

function markUnsatisfactory(orderId) {
    window.location.href = `/user/video-course/${orderId}/unsatisfactory`;
}
</script>
@endsection
```

**File**: `resources/views/User-Dashboard/video-course-player.blade.php`

```html
@extends('layouts.user-dashboard')

@section('content')
<div class="video-course-player">
    <div class="player-container">
        <div class="video-wrapper">
            <video id="course-video" controls>
                <source src="" type="video/mp4">
                Your browser does not support the video tag.
            </video>

            <div class="video-info">
                <h3 id="current-lesson-title"></h3>
                <p id="current-lesson-description"></p>
            </div>
        </div>

        <div class="course-sidebar">
            <h2>{{ $gig->title }}</h2>

            <div class="course-sections">
                @foreach($sections as $section)
                    <div class="section">
                        <h4>{{ $section->title }}</h4>

                        <ul class="lesson-list">
                            @foreach($section->lessons as $lesson)
                                <li class="lesson-item {{ $lesson->userProgress && $lesson->userProgress->completed ? 'completed' : '' }}"
                                    data-lesson-id="{{ $lesson->id }}"
                                    data-video-url="{{ $lesson->video_url }}"
                                    data-is-free="{{ $lesson->is_free_preview }}"
                                    onclick="playLesson(this)">

                                    <span class="lesson-icon">
                                        @if($lesson->userProgress && $lesson->userProgress->completed)
                                            ✓
                                        @elseif($lesson->is_free_preview)
                                            🔓
                                        @else
                                            🔒
                                        @endif
                                    </span>

                                    <span class="lesson-title">{{ $lesson->title }}</span>
                                    <span class="lesson-duration">{{ $lesson->duration_minutes }} min</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
const video = document.getElementById('course-video');
const orderId = {{ $order->id }};
let currentLessonId = null;
let progressInterval = null;

function playLesson(element) {
    const lessonId = element.dataset.lessonId;
    const videoUrl = element.dataset.videoUrl;
    const isFree = element.dataset.isFree === '1';

    // Check if locked
    if (!isFree) {
        const isCompleted = element.classList.contains('completed');
        // You can add logic to check if previous lessons are completed
    }

    currentLessonId = lessonId;
    video.src = videoUrl;
    video.play();

    // Update UI
    document.getElementById('current-lesson-title').textContent = element.querySelector('.lesson-title').textContent;

    // Highlight current lesson
    document.querySelectorAll('.lesson-item').forEach(item => {
        item.classList.remove('playing');
    });
    element.classList.add('playing');

    // Start progress tracking
    startProgressTracking();
}

function startProgressTracking() {
    if (progressInterval) {
        clearInterval(progressInterval);
    }

    progressInterval = setInterval(() => {
        if (!video.paused) {
            updateProgress(Math.floor(video.currentTime));
        }
    }, 5000); // Update every 5 seconds
}

async function updateProgress(watchedSeconds) {
    try {
        await fetch('/user/video-course/progress', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                lesson_id: currentLessonId,
                order_id: orderId,
                watched_seconds: watchedSeconds
            })
        });
    } catch (error) {
        console.error('Failed to update progress:', error);
    }
}

video.addEventListener('ended', () => {
    // Update progress one last time
    updateProgress(Math.floor(video.duration));

    // Play next lesson
    playNextLesson();
});
</script>
@endsection
```

---

## Continue in Next Document...

**THIS IS JUST THE FIRST PART OF THE IMPLEMENTATION GUIDE**

This document covers:
- ✅ Current state analysis
- ✅ Critical gaps identified
- ✅ Phase 1: Bug Fixes (detailed)
- ✅ Phase 2: Stripe Integration (detailed)
- ✅ Phase 3: Real-Time Updates (detailed)
- ✅ Phase 4: Video Courses (detailed)

**STILL NEEDED** (will create in separate sections):
- Phase 5: Custom Offers
- Phase 6: Trial Classes
- Phase 7: Email System
- Phase 8-23: Remaining features

**File Size**: This document is already very large. Should I:
1. Continue adding phases to this file?
2. Create separate implementation files for each phase?
3. Create a summary version with just high-level steps?

Please advise how you'd like me to proceed with the remaining phases!
