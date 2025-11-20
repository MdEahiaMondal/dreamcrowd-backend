# Custom Offer Feature - Implementation Plan
# কাস্টম অফার ফিচার - ইমপ্লিমেন্টেশন প্ল্যান

**Project:** DreamCrowd Marketplace Platform
**Feature:** Custom Offer System
**Date:** November 19, 2025
**Status:** ⚠️ **20-30% IMPLEMENTED** - Requires Significant Development Work

---

## 📋 Table of Contents

1. [Executive Summary](#executive-summary)
2. [Business Requirements Overview](#business-requirements-overview)
3. [Current Implementation Status](#current-implementation-status)
4. [What's Already Done](#whats-already-done)
5. [Critical Gaps & Missing Components](#critical-gaps--missing-components)
6. [Development Phases](#development-phases)
7. [Detailed Implementation Guide](#detailed-implementation-guide)
8. [Files to Create/Modify](#files-to-createmodify)
9. [Security & Quality Checklist](#security--quality-checklist)
10. [Testing Plan](#testing-plan)
11. [Timeline & Effort Estimation](#timeline--effort-estimation)
12. [Next Steps](#next-steps)

---

## Executive Summary

### Current Status: ⚠️ PARTIAL IMPLEMENTATION

The Custom Offer feature for DreamCrowd has **partial UI implementation** but is **functionally incomplete**. Approximately **20-30% of the required work is complete**.

### What Exists:
- ✅ Seller-side UI mockup (6-step modal workflow)
- ✅ Basic API endpoint to fetch seller services
- ✅ Initial AJAX flow for service selection
- ✅ 1 route registered

### What's Missing:
- ❌ Database structure (0 of 2 tables created)
- ❌ Models (0 of 2 models created)
- ❌ Backend logic (1 of 6 controller methods exist)
- ❌ Routes (1 of 5 routes exist)
- ❌ Buyer-side UI (0% complete)
- ❌ JavaScript completion (30% complete)
- ❌ Stripe payment integration (0% complete)
- ❌ Notifications & emails (0% complete)
- ❌ Business logic validations (0% complete)
- ❌ Automated tasks (0% complete)

### Effort Required:
- **Total Estimated Hours:** 64-87 hours
- **Recommended Timeline:** 2-3 weeks (1 full-time developer)
- **Priority:** 🔴 HIGH (client-requested feature)

---

## Business Requirements Overview

### Feature Description
Custom Offer allows sellers to create personalized service proposals for specific buyers through the chat interface, with flexible pricing, milestones, and payment options.

### Core Capabilities
1. **Offer Types:**
   - Class Booking (educational services)
   - Freelance Booking (professional services)

2. **Payment Methods:**
   - Single Payment (one-time charge)
   - Milestone Payment (pay per milestone/phase)

3. **Service Modes:**
   - Online (Zoom/Google Meet)
   - In-person (requires date/time/location)

4. **Key Features:**
   - Multi-step wizard (6 steps)
   - Add/remove milestones dynamically
   - Preview before sending
   - Buyer accept/reject workflow
   - Automatic order creation on payment
   - Offer expiry mechanism

### User Workflow

**Seller Side:**
```
1. Click "Custom Offer" button in chat
2. Select service type (Class/Freelance)
3. Select existing service
4. Choose payment method (Single/Milestone)
5. Fill milestone details (title, price, date, etc.)
6. Preview offer
7. Send to buyer
```

**Buyer Side:**
```
1. Receive notification
2. View offer card in chat
3. Click "View Details"
4. Review all milestones and pricing
5. Accept → Redirect to Stripe checkout
   OR
   Reject → Provide optional reason
6. After payment → Order created automatically
```

### Business Rules
- ✅ Minimum $10 per milestone
- ✅ In-person services require date/time
- ✅ Freelance services require revisions count
- ✅ Freelance single payment requires delivery days
- ✅ Offers can have expiry date (optional)
- ✅ Offers can request requirements from buyer
- ✅ Only one pending offer per service/buyer combination
- ✅ Auto-expire offers after configured days

---

## Current Implementation Status

### Overall Progress: 20-30%

| Component | Status | Progress | Priority |
|-----------|--------|----------|----------|
| **Database Schema** | ❌ Not Started | 0% | 🔴 CRITICAL |
| **Models** | ❌ Not Started | 0% | 🔴 CRITICAL |
| **Controllers** | ⚠️ Partial | 17% (1/6 methods) | 🔴 CRITICAL |
| **Routes** | ⚠️ Partial | 20% (1/5 routes) | 🔴 CRITICAL |
| **Seller UI** | ⚠️ Partial | 60% (mockup exists) | 🟡 HIGH |
| **Buyer UI** | ❌ Not Started | 0% | 🔴 CRITICAL |
| **JavaScript** | ⚠️ Partial | 30% (service fetch only) | 🔴 CRITICAL |
| **Stripe Integration** | ❌ Not Started | 0% | 🔴 CRITICAL |
| **Notifications** | ❌ Not Started | 0% | 🟡 HIGH |
| **Emails** | ❌ Not Started | 0% | 🟡 HIGH |
| **Validations** | ❌ Not Started | 0% | 🟡 HIGH |
| **Automated Tasks** | ❌ Not Started | 0% | 🟢 MEDIUM |
| **Testing** | ❌ Not Started | 0% | 🟡 HIGH |

---

## What's Already Done

### ✅ 1. Seller-Side UI Mockup

**Location:** `/resources/views/Teacher-Dashboard/chat.blade.php`

**Lines:** 308-682 (375 lines of code)

**What Exists:**

#### A. "Custom Offer" Button (Line 308)
```blade
<button type="button" class="btn btn-sm rounded text-white" data-bs-toggle="modal"
        data-bs-target="#myModal" style="background-color: #25AB75;">
    Custom Offer
</button>
```

#### B. Step 1: Service Type Selection (Lines 317-359)
```blade
<!-- Modal #myModal -->
<div class="modal fade" id="myModal">
    <div class="modal-body">
        <h4>Select the type of service</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="radioService" value="Class">
            <label>Class Booking</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="radioService" value="Freelance">
            <label>Freelance Booking</label>
        </div>
        <button class="btn-next" data-bs-target="#secondModal">Next</button>
    </div>
</div>
```

**Status:** ✅ Complete UI mockup

#### C. Step 2: Service Selection (Lines 361-405)
```blade
<!-- Modal #secondModal (for Class services) -->
<!-- Modal #thirdModal (for Freelance services) -->
<!-- Empty containers - populated via AJAX -->
```

**Status:** ⚠️ Partial - Structure exists but needs dynamic population logic

#### D. Step 3: Payment Method Selection (Lines 407-452)
```blade
<!-- Modal #fourmodal -->
<div class="form-check">
    <input type="radio" name="radioFruit" value="Single">
    <label>Single Payment</label>
</div>
<div class="form-check">
    <input type="radio" name="radioFruit" value="Milestones">
    <label>Milestones</label>
</div>
```

**Status:** ✅ Complete UI mockup

#### E. Step 4: Milestone Payment Form (Lines 453-566)
```blade
<!-- Modal #fiveModal -->
<form>
    <input type="text" placeholder="Milestone Name">
    <input type="number" placeholder="Revision">
    <input type="number" placeholder="Delivery Days">
    <input type="number" placeholder="Price">
    <textarea placeholder="Description"></textarea>

    <div class="form-check">
        <input type="checkbox" id="offerExpire">
        <label>Offer Expire (in days)</label>
        <input type="number" placeholder="Days">
    </div>

    <div class="form-check">
        <input type="checkbox" id="requestRequirements">
        <label>Request for Requirements</label>
    </div>

    <button class="btn-save">Save</button>
</form>
```

**Status:** ⚠️ UI exists but missing:
- Add/Remove milestone buttons
- Dynamic milestone list
- Total amount calculation
- Form data collection
- Validation logic

#### F. Step 5: Single Payment Form (Lines 568-680)
Similar structure to milestone form but for single payment.

**Status:** ⚠️ Same issues as Step 4

---

### ✅ 2. Backend API Endpoint

**Location:** `/app/Http/Controllers/MessagesController.php`

**Lines:** 2252-2270

**Method:** `GetServicesForCustom(Request $request)`

```php
public function GetServicesForCustom(Request $request)
{
    if (!Auth::user()) {
        return response()->json(['error' => 'Please LoginIn to Your Account!']);
    }

    $services = DB::table('teacher_gigs')
        ->join('teacher_gig_data', 'teacher_gigs.id', '=', 'teacher_gig_data.gig_id')
        ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
        ->where('teacher_gigs.user_id', Auth::user()->id)
        ->select('teacher_gigs.*', 'teacher_gig_data.*', 'teacher_gig_payments.*')
        ->get();

    return response()->json(['services' => $services]);
}
```

**What It Does:**
- Fetches all services owned by authenticated seller
- Joins gig data and payment information
- Returns JSON response

**Status:** ✅ Working, but could be improved:
- ⚠️ Missing authorization check (buyer vs seller)
- ⚠️ No filtering by service type (Class vs Freelance)
- ⚠️ Returns all fields (should use specific select)
- ⚠️ No error handling

---

### ✅ 3. Frontend JavaScript (Partial)

**Location:** `/resources/views/Teacher-Dashboard/chat.blade.php`

**Lines:** 2829-2923

**What Exists:**

```javascript
// Service Type Selection Handler
$('input[name="radioService"]').on('click', function() {
    var service = $(this).val(); // "Class" or "Freelance"

    $.ajax({
        url: '/get-services-for-custom',
        method: 'POST',
        data: {
            service: service,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            var gigs = response.services;
            $('.services_main').empty();

            // Loop through services
            for (let i = 0; i < gigs.length; i++) {
                // Calculate duration and rate
                var duration = /* calculation logic */;
                var rate = /* calculation logic */;

                // Generate service card HTML
                var html = `
                    <div class="service-card">
                        <h5>${gigs[i].title}</h5>
                        <p>Duration: ${duration} | Rate: $${rate}</p>
                        <button class="btn-select-service" data-gig-id="${gigs[i].id}">
                            Select
                        </button>
                    </div>
                `;

                $('.services_main').append(html);
            }
        },
        error: function(xhr) {
            console.error('Error fetching services');
        }
    });
});
```

**Status:** ⚠️ Partial implementation:
- ✅ AJAX call works
- ✅ Dynamic service list population
- ❌ Missing service selection handler
- ❌ Missing modal navigation logic
- ❌ Missing form data collection
- ❌ Missing validation
- ❌ Missing final "Send Offer" AJAX call

---

### ✅ 4. Route Registration

**Location:** `/routes/web.php`

**Line:** 590

```php
Route::post('/get-services-for-custom', 'GetServicesForCustom');
```

**Status:** ✅ Single route exists (4 more needed)

---

## Critical Gaps & Missing Components

### ❌ 1. Database Structure (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

**Impact:** Cannot store any custom offer data without these tables.

#### Required Table 1: `custom_offers`

**Purpose:** Store main custom offer records

**Required Fields:**
```sql
id                      BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
chat_id                 BIGINT UNSIGNED (FK → chats.id) ON DELETE CASCADE
seller_id               BIGINT UNSIGNED (FK → users.id) ON DELETE CASCADE
buyer_id                BIGINT UNSIGNED (FK → users.id) ON DELETE CASCADE
gig_id                  BIGINT UNSIGNED (FK → teacher_gigs.id) ON DELETE CASCADE
offer_type              ENUM('Class', 'Freelance')
payment_type            ENUM('Single', 'Milestone')
service_mode            ENUM('Online', 'In-person')
description             TEXT NULL
total_amount            DECIMAL(10, 2)
expire_days             INT NULL
request_requirements    BOOLEAN DEFAULT FALSE
status                  ENUM('pending', 'accepted', 'rejected', 'expired') DEFAULT 'pending'
accepted_at             TIMESTAMP NULL
rejected_at             TIMESTAMP NULL
rejection_reason        TEXT NULL
expires_at              TIMESTAMP NULL
created_at              TIMESTAMP
updated_at              TIMESTAMP
```

**Migration File:** `database/migrations/2025_xx_xx_create_custom_offers_table.php`

---

#### Required Table 2: `custom_offer_milestones`

**Purpose:** Store individual milestones for each offer

**Required Fields:**
```sql
id                  BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT
custom_offer_id     BIGINT UNSIGNED (FK → custom_offers.id) ON DELETE CASCADE
title               VARCHAR(255)
description         TEXT NULL
date                DATE NULL (required for in-person)
start_time          TIME NULL (required for in-person & live classes)
end_time            TIME NULL (required for in-person & live classes)
price               DECIMAL(10, 2)
revisions           INT DEFAULT 0 (for freelance only)
delivery_days       INT NULL (for freelance single payment)
order               INT DEFAULT 0 (milestone sequence)
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

**Migration File:** `database/migrations/2025_xx_xx_create_custom_offer_milestones_table.php`

---

### ❌ 2. Models (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

#### Required Model 1: `CustomOffer`

**File:** `app/Models/CustomOffer.php`

**Required Code:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomOffer extends Model
{
    protected $fillable = [
        'chat_id',
        'seller_id',
        'buyer_id',
        'gig_id',
        'offer_type',
        'payment_type',
        'service_mode',
        'description',
        'total_amount',
        'expire_days',
        'request_requirements',
        'status',
        'accepted_at',
        'rejected_at',
        'rejection_reason',
        'expires_at',
    ];

    protected $casts = [
        'request_requirements' => 'boolean',
        'total_amount' => 'decimal:2',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function gig()
    {
        return $this->belongsTo(TeacherGig::class, 'gig_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function milestones()
    {
        return $this->hasMany(CustomOfferMilestone::class)->orderBy('order');
    }

    // Business Logic Methods
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isPending()
    {
        return $this->status === 'pending' && !$this->isExpired();
    }

    public function canBeAccepted()
    {
        return $this->status === 'pending' && !$this->isExpired();
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }
}
```

---

#### Required Model 2: `CustomOfferMilestone`

**File:** `app/Models/CustomOfferMilestone.php`

**Required Code:**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomOfferMilestone extends Model
{
    protected $fillable = [
        'custom_offer_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'price',
        'revisions',
        'delivery_days',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function customOffer()
    {
        return $this->belongsTo(CustomOffer::class);
    }
}
```

---

### ❌ 3. Controller Methods (17% Complete - 1 of 6 methods)

**Status:** ⚠️ **PARTIALLY IMPLEMENTED**

**Location:** `/app/Http/Controllers/MessagesController.php`

#### Existing Method:
- ✅ `GetServicesForCustom()` (Lines 2252-2270)

#### Missing Methods (5 total):

---

#### Method 1: `sendCustomOffer()`

**Purpose:** Save and send custom offer to buyer

**Required Code:**
```php
public function sendCustomOffer(Request $request)
{
    // Validation
    $request->validate([
        'buyer_id' => 'required|exists:users,id',
        'gig_id' => 'required|exists:teacher_gigs,id',
        'offer_type' => 'required|in:Class,Freelance',
        'payment_type' => 'required|in:Single,Milestone',
        'service_mode' => 'required|in:Online,In-person',
        'description' => 'nullable|string|max:1000',
        'expire_days' => 'nullable|integer|min:1|max:30',
        'request_requirements' => 'nullable|boolean',
        'milestones' => 'required|array|min:1',
        'milestones.*.title' => 'required|string|max:255',
        'milestones.*.description' => 'nullable|string',
        'milestones.*.price' => 'required|numeric|min:10',
        'milestones.*.revisions' => 'nullable|integer|min:0',
        'milestones.*.delivery_days' => 'nullable|integer|min:1',
        'milestones.*.date' => 'nullable|date|after:today',
        'milestones.*.start_time' => 'nullable|date_format:H:i',
        'milestones.*.end_time' => 'nullable|date_format:H:i|after:milestones.*.start_time',
    ]);

    // Conditional validation for in-person
    if ($request->service_mode === 'In-person') {
        $request->validate([
            'milestones.*.date' => 'required|date|after:today',
            'milestones.*.start_time' => 'required|date_format:H:i',
            'milestones.*.end_time' => 'required|date_format:H:i',
        ]);
    }

    // Conditional validation for freelance
    if ($request->offer_type === 'Freelance') {
        $request->validate([
            'milestones.*.revisions' => 'required|integer|min:0',
        ]);

        if ($request->payment_type === 'Single') {
            $request->validate([
                'milestones.*.delivery_days' => 'required|integer|min:1',
            ]);
        }
    }

    // Check for duplicate pending offers
    $existingOffer = CustomOffer::where('seller_id', auth()->id())
        ->where('buyer_id', $request->buyer_id)
        ->where('gig_id', $request->gig_id)
        ->where('status', 'pending')
        ->first();

    if ($existingOffer) {
        return response()->json([
            'error' => 'You already have a pending offer for this service to this buyer.'
        ], 400);
    }

    // Calculate total amount
    $totalAmount = collect($request->milestones)->sum('price');

    // Get chat_id
    $chat = Chat::where(function($q) use ($request) {
        $q->where('sender_id', auth()->id())
          ->where('reciver_id', $request->buyer_id);
    })->orWhere(function($q) use ($request) {
        $q->where('sender_id', $request->buyer_id)
          ->where('reciver_id', auth()->id());
    })->first();

    if (!$chat) {
        return response()->json(['error' => 'No chat found with this buyer.'], 400);
    }

    // Create custom offer
    $offer = CustomOffer::create([
        'chat_id' => $chat->id,
        'seller_id' => auth()->id(),
        'buyer_id' => $request->buyer_id,
        'gig_id' => $request->gig_id,
        'offer_type' => $request->offer_type,
        'payment_type' => $request->payment_type,
        'service_mode' => $request->service_mode,
        'description' => $request->description,
        'total_amount' => $totalAmount,
        'expire_days' => $request->expire_days,
        'request_requirements' => $request->request_requirements ?? false,
        'status' => 'pending',
        'expires_at' => $request->expire_days ? now()->addDays($request->expire_days) : null,
    ]);

    // Create milestones
    foreach ($request->milestones as $index => $milestone) {
        CustomOfferMilestone::create([
            'custom_offer_id' => $offer->id,
            'title' => $milestone['title'],
            'description' => $milestone['description'] ?? null,
            'date' => $milestone['date'] ?? null,
            'start_time' => $milestone['start_time'] ?? null,
            'end_time' => $milestone['end_time'] ?? null,
            'price' => $milestone['price'],
            'revisions' => $milestone['revisions'] ?? 0,
            'delivery_days' => $milestone['delivery_days'] ?? null,
            'order' => $index,
        ]);
    }

    // Send message in chat with offer card
    $message = Message::create([
        'chat_id' => $chat->id,
        'sender_id' => auth()->id(),
        'reciver_id' => $request->buyer_id,
        'message' => 'Custom Offer: ' . $offer->gig->title,
        'custom_offer_id' => $offer->id,
    ]);

    // Send notification to buyer
    app(\App\Services\NotificationService::class)->send(
        userId: $request->buyer_id,
        type: 'custom_offer',
        title: 'New Custom Offer',
        message: auth()->user()->first_name . ' sent you a custom offer for ' . $offer->gig->title,
        data: [
            'offer_id' => $offer->id,
            'seller_name' => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            'service_name' => $offer->gig->title,
            'total_amount' => $totalAmount,
        ],
        sendEmail: true
    );

    return response()->json([
        'success' => true,
        'offer' => $offer->load('milestones'),
        'message' => 'Custom offer sent successfully!'
    ]);
}
```

**Estimated Time:** 4-6 hours (including testing)

---

#### Method 2: `viewCustomOffer()`

**Purpose:** Display offer details to buyer

**Required Code:**
```php
public function viewCustomOffer($id)
{
    $offer = CustomOffer::with(['milestones', 'seller', 'gig'])
        ->findOrFail($id);

    // Authorization check
    if ($offer->buyer_id !== auth()->id() && $offer->seller_id !== auth()->id()) {
        abort(403, 'Unauthorized access to this offer.');
    }

    return response()->json([
        'offer' => $offer,
        'can_accept' => $offer->canBeAccepted() && $offer->buyer_id === auth()->id(),
    ]);
}
```

**Estimated Time:** 1-2 hours

---

#### Method 3: `acceptCustomOffer()`

**Purpose:** Buyer accepts offer and initiates Stripe checkout

**Required Code:**
```php
public function acceptCustomOffer($id)
{
    $offer = CustomOffer::with('milestones')->findOrFail($id);

    // Authorization check
    if ($offer->buyer_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Check if offer can be accepted
    if (!$offer->canBeAccepted()) {
        $reason = $offer->isExpired() ? 'This offer has expired.' : 'This offer is no longer available.';
        return response()->json(['error' => $reason], 400);
    }

    // Calculate commission
    $commission = \App\Models\TopSellerTag::calculateCommission($offer->gig_id, $offer->seller_id);
    $totalAmount = $offer->total_amount + $commission['buyer_commission'];

    // Create Stripe checkout session
    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

    try {
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Custom Offer: ' . $offer->gig->title,
                        'description' => $offer->description ?? 'Custom service offer',
                    ],
                    'unit_amount' => $totalAmount * 100, // cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/custom-offer-success?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/messages'),
            'metadata' => [
                'custom_offer_id' => $offer->id,
                'buyer_id' => auth()->id(),
                'seller_id' => $offer->seller_id,
                'gig_id' => $offer->gig_id,
            ],
        ]);

        // Update offer status
        $offer->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);

        // Send notification to seller
        app(\App\Services\NotificationService::class)->send(
            userId: $offer->seller_id,
            type: 'custom_offer',
            title: 'Offer Accepted!',
            message: $offer->buyer->first_name . ' accepted your custom offer for ' . $offer->gig->title,
            data: ['offer_id' => $offer->id],
            sendEmail: true
        );

        return response()->json([
            'success' => true,
            'checkout_url' => $session->url
        ]);

    } catch (\Exception $e) {
        \Log::error('Stripe checkout creation failed: ' . $e->getMessage());
        return response()->json(['error' => 'Payment processing failed. Please try again.'], 500);
    }
}
```

**Estimated Time:** 4-6 hours (including Stripe testing)

---

#### Method 4: `rejectCustomOffer()`

**Purpose:** Buyer rejects offer

**Required Code:**
```php
public function rejectCustomOffer(Request $request, $id)
{
    $request->validate([
        'reason' => 'nullable|string|max:500',
    ]);

    $offer = CustomOffer::findOrFail($id);

    // Authorization check
    if ($offer->buyer_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Check if offer is still pending
    if ($offer->status !== 'pending') {
        return response()->json(['error' => 'This offer has already been processed.'], 400);
    }

    // Update offer status
    $offer->update([
        'status' => 'rejected',
        'rejected_at' => now(),
        'rejection_reason' => $request->reason,
    ]);

    // Send notification to seller
    app(\App\Services\NotificationService::class)->send(
        userId: $offer->seller_id,
        type: 'custom_offer',
        title: 'Offer Rejected',
        message: $offer->buyer->first_name . ' declined your custom offer for ' . $offer->gig->title,
        data: [
            'offer_id' => $offer->id,
            'reason' => $request->reason,
        ],
        sendEmail: true
    );

    return response()->json([
        'success' => true,
        'message' => 'Offer rejected successfully.'
    ]);
}
```

**Estimated Time:** 2-3 hours

---

#### Method 5: `handleCustomOfferPayment()`

**Purpose:** Handle successful payment and create order

**Location:** Add to `BookingController` or `StripeWebhookController`

**Required Code:**
```php
public function handleCustomOfferPayment($sessionId)
{
    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

    try {
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return redirect('/messages')->with('error', 'Payment not completed.');
        }

        $offerId = $session->metadata->custom_offer_id;
        $offer = CustomOffer::with('milestones')->findOrFail($offerId);

        // Check if order already created
        $existingOrder = BookOrder::where('custom_offer_id', $offerId)->first();
        if ($existingOrder) {
            return redirect('/user-dashboard')->with('success', 'Order already created.');
        }

        // Calculate commission
        $commission = \App\Models\TopSellerTag::calculateCommission($offer->gig_id, $offer->seller_id);

        // Create BookOrder
        $order = BookOrder::create([
            'user_id' => $offer->buyer_id,
            'teacher_id' => $offer->seller_id,
            'gig_id' => $offer->gig_id,
            'order_type' => $offer->offer_type,
            'payment_type' => $offer->payment_type,
            'service_mode' => $offer->service_mode,
            'total_price' => $offer->total_amount,
            'buyer_commission' => $commission['buyer_commission'],
            'seller_commission' => $commission['seller_commission'],
            'admin_commission' => $commission['admin_commission'],
            'status' => 0, // Pending (needs seller approval - as per existing system)
            'payment_status' => 'completed',
            'stripe_transaction_id' => $session->payment_intent,
            'custom_offer_id' => $offer->id,
        ]);

        // Create ClassDates for each milestone
        foreach ($offer->milestones as $milestone) {
            \App\Models\ClassDate::create([
                'order_id' => $order->id,
                'title' => $milestone->title,
                'description' => $milestone->description,
                'class_date' => $milestone->date,
                'start_time' => $milestone->start_time,
                'end_time' => $milestone->end_time,
                'price' => $milestone->price,
            ]);
        }

        // Create Transaction record
        \App\Models\Transaction::create([
            'buyer_id' => $offer->buyer_id,
            'seller_id' => $offer->seller_id,
            'total_amount' => $offer->total_amount,
            'buyer_commission' => $commission['buyer_commission'],
            'seller_commission' => $commission['seller_commission'],
            'admin_commission' => $commission['admin_commission'],
            'stripe_transaction_id' => $session->payment_intent,
            'status' => 'completed',
        ]);

        // Send notifications
        app(\App\Services\NotificationService::class)->send(
            userId: $offer->seller_id,
            type: 'new_order',
            title: 'New Order from Custom Offer',
            message: 'You have a new order from ' . $offer->buyer->first_name,
            data: ['order_id' => $order->id],
            sendEmail: true
        );

        return redirect('/user-dashboard')->with('success', 'Order created successfully!');

    } catch (\Exception $e) {
        \Log::error('Custom offer payment handling failed: ' . $e->getMessage());
        return redirect('/messages')->with('error', 'Order creation failed.');
    }
}
```

**Estimated Time:** 6-8 hours (complex integration)

---

### ❌ 4. Routes (20% Complete - 1 of 5 routes)

**Status:** ⚠️ **PARTIALLY IMPLEMENTED**

**Location:** `/routes/web.php`

**Existing Route:**
```php
Route::post('/get-services-for-custom', 'GetServicesForCustom'); // Line 590
```

**Required Routes (4 missing):**

```php
// Add to routes/web.php within authenticated routes group

Route::middleware('auth')->group(function() {

    // Custom Offer Routes
    Route::post('/custom-offers', [MessagesController::class, 'sendCustomOffer'])
        ->name('custom-offers.send');

    Route::get('/custom-offers/{id}', [MessagesController::class, 'viewCustomOffer'])
        ->name('custom-offers.view');

    Route::post('/custom-offers/{id}/accept', [MessagesController::class, 'acceptCustomOffer'])
        ->name('custom-offers.accept');

    Route::post('/custom-offers/{id}/reject', [MessagesController::class, 'rejectCustomOffer'])
        ->name('custom-offers.reject');

    // Payment success callback
    Route::get('/custom-offer-success', [BookingController::class, 'handleCustomOfferPayment'])
        ->name('custom-offers.payment-success');
});
```

**Estimated Time:** 30 minutes

---

### ❌ 5. Buyer-Side UI (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

**Impact:** Buyers cannot view, accept, or reject offers.

#### Required Components:

---

#### Component 1: Custom Offer Card (in Message Thread)

**Location:** Create new Blade component or add to `resources/views/User-Dashboard/messages.blade.php`

**File:** `resources/views/components/custom-offer-card.blade.php`

**Required Code:**
```blade
<div class="custom-offer-card border rounded p-3 mb-3 shadow-sm" data-offer-id="{{ $offer->id }}">
    <!-- Header with badges -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <span class="badge bg-primary">{{ $offer->offer_type }} Booking</span>
            <span class="badge bg-info">{{ $offer->payment_type }} Payment</span>
            <span class="badge bg-secondary">{{ $offer->service_mode }}</span>
        </div>
        <span class="badge
            @if($offer->status === 'pending') bg-warning
            @elseif($offer->status === 'accepted') bg-success
            @elseif($offer->status === 'rejected') bg-danger
            @else bg-secondary
            @endif">
            {{ ucfirst($offer->status) }}
        </span>
    </div>

    <!-- Offer Title & Description -->
    <h5 class="mb-2">
        <i class="bx bx-gift"></i> Custom Offer: {{ $offer->gig->title }}
    </h5>

    @if($offer->description)
        <p class="text-muted small mb-2">{{ Str::limit($offer->description, 100) }}</p>
    @endif

    <!-- Pricing Info -->
    <div class="offer-pricing mb-3">
        <div class="row">
            <div class="col-6">
                <strong class="text-success fs-4">${{ number_format($offer->total_amount, 2) }}</strong>
            </div>
            <div class="col-6 text-end">
                <span class="badge bg-light text-dark">
                    {{ $offer->milestones->count() }} Milestone{{ $offer->milestones->count() > 1 ? 's' : '' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Expiry Info -->
    @if($offer->expires_at)
        <div class="offer-expiry mb-2">
            <small class="text-muted">
                <i class="bx bx-time-five"></i>
                @if($offer->isExpired())
                    <span class="text-danger">Expired {{ $offer->expires_at->diffForHumans() }}</span>
                @else
                    Expires {{ $offer->expires_at->diffForHumans() }}
                @endif
            </small>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="offer-actions d-flex gap-2">
        <button type="button" class="btn btn-sm btn-outline-primary flex-fill"
                onclick="viewOfferDetails({{ $offer->id }})">
            <i class="bx bx-show"></i> View Details
        </button>

        @if($offer->status === 'pending' && !$offer->isExpired())
            <button type="button" class="btn btn-sm btn-success flex-fill"
                    onclick="acceptOffer({{ $offer->id }})">
                <i class="bx bx-check"></i> Accept
            </button>
            <button type="button" class="btn btn-sm btn-danger flex-fill"
                    onclick="rejectOffer({{ $offer->id }})">
                <i class="bx bx-x"></i> Reject
            </button>
        @endif
    </div>

    @if($offer->request_requirements)
        <div class="alert alert-info mt-2 mb-0 small">
            <i class="bx bx-info-circle"></i> Seller has requested requirements from you.
        </div>
    @endif
</div>
```

**Estimated Time:** 3-4 hours (including styling)

---

#### Component 2: Custom Offer Detail Modal

**File:** `resources/views/components/custom-offer-detail-modal.blade.php`

**Required Code:**
```blade
<div class="modal fade" id="customOfferDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Custom Offer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="offerDetailContent">
                <!-- Content populated via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer" id="offerDetailActions">
                <!-- Action buttons populated dynamically -->
            </div>
        </div>
    </div>
</div>
```

**JavaScript to Populate Modal:**
```javascript
function viewOfferDetails(offerId) {
    $('#offerDetailContent').html(`
        <div class="text-center py-5">
            <div class="spinner-border" role="status"></div>
        </div>
    `);

    $('#customOfferDetailModal').modal('show');

    $.ajax({
        url: `/custom-offers/${offerId}`,
        method: 'GET',
        success: function(response) {
            const offer = response.offer;

            let html = `
                <!-- Seller Info -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">From</h6>
                        <div class="d-flex align-items-center">
                            <img src="${offer.seller.profile || '/default-avatar.png'}"
                                 class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <strong>${offer.seller.first_name} ${offer.seller.last_name}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service Info -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-muted mb-2">Service</h6>
                        <h5>${offer.gig.title}</h5>
                        ${offer.description ? `<p class="text-muted">${offer.description}</p>` : ''}
                    </div>
                </div>

                <!-- Offer Details -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Offer Details</h6>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Type:</strong></div>
                            <div class="col-6">${offer.offer_type} Booking</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Payment:</strong></div>
                            <div class="col-6">${offer.payment_type} Payment</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><strong>Mode:</strong></div>
                            <div class="col-6">${offer.service_mode}</div>
                        </div>
                        ${offer.expires_at ? `
                        <div class="row mb-2">
                            <div class="col-6"><strong>Expires:</strong></div>
                            <div class="col-6">${new Date(offer.expires_at).toLocaleDateString()}</div>
                        </div>
                        ` : ''}
                    </div>
                </div>

                <!-- Milestones -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Milestones (${offer.milestones.length})</h6>
            `;

            offer.milestones.forEach((milestone, index) => {
                html += `
                    <div class="milestone-item border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">
                                    <span class="badge bg-primary me-2">${index + 1}</span>
                                    ${milestone.title}
                                </h6>
                                ${milestone.description ? `<p class="text-muted small mb-2">${milestone.description}</p>` : ''}

                                ${milestone.date ? `
                                <div class="small mb-1">
                                    <i class="bx bx-calendar"></i> ${new Date(milestone.date).toLocaleDateString()}
                                </div>
                                ` : ''}

                                ${milestone.start_time ? `
                                <div class="small mb-1">
                                    <i class="bx bx-time"></i> ${milestone.start_time} - ${milestone.end_time}
                                </div>
                                ` : ''}

                                ${milestone.revisions ? `
                                <div class="small mb-1">
                                    <i class="bx bx-revision"></i> ${milestone.revisions} Revisions
                                </div>
                                ` : ''}

                                ${milestone.delivery_days ? `
                                <div class="small mb-1">
                                    <i class="bx bx-package"></i> ${milestone.delivery_days} Days Delivery
                                </div>
                                ` : ''}
                            </div>
                            <div class="text-end">
                                <strong class="text-success">\$${parseFloat(milestone.price).toFixed(2)}</strong>
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Total Amount</h5>
                            <h4 class="mb-0 text-success">\$${parseFloat(offer.total_amount).toFixed(2)}</h4>
                        </div>
                    </div>
                </div>
            `;

            $('#offerDetailContent').html(html);

            // Update action buttons
            if (response.can_accept) {
                $('#offerDetailActions').html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="rejectOffer(${offer.id})">
                        <i class="bx bx-x"></i> Reject
                    </button>
                    <button type="button" class="btn btn-success" onclick="acceptOffer(${offer.id})">
                        <i class="bx bx-check"></i> Accept & Pay
                    </button>
                `);
            } else {
                $('#offerDetailActions').html(`
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                `);
            }
        },
        error: function(xhr) {
            $('#offerDetailContent').html(`
                <div class="alert alert-danger">
                    Failed to load offer details. Please try again.
                </div>
            `);
        }
    });
}
```

**Estimated Time:** 4-6 hours

---

### ❌ 6. JavaScript Completion (30% Complete)

**Status:** ⚠️ **PARTIALLY IMPLEMENTED**

**Current Progress:**
- ✅ Service selection AJAX (30%)
- ❌ Form data collection (0%)
- ❌ Send offer AJAX (0%)
- ❌ Accept offer handler (0%)
- ❌ Reject offer handler (0%)
- ❌ Add/Remove milestone (0%)
- ❌ Total calculation (0%)
- ❌ Validation logic (0%)

#### Required JavaScript Functions:

---

#### Function 1: Collect Form Data & Send Offer

**Location:** Add to `/resources/views/Teacher-Dashboard/chat.blade.php` or create `/public/js/custom-offers.js`

```javascript
// Global variables
let milestones = [];
let selectedGigId = null;
let selectedOfferType = null;
let selectedPaymentType = null;
let selectedServiceMode = null;

// Step 1: Service Type Selection (already exists - enhance)
$('input[name="radioService"]').on('click', function() {
    selectedOfferType = $(this).val();
    // Existing AJAX code...
});

// Step 2: Service Selection
$(document).on('click', '.btn-select-service', function() {
    selectedGigId = $(this).data('gig-id');
    $('#secondModal').modal('hide'); // or #thirdModal
    $('#fourmodal').modal('show'); // Payment method selection
});

// Step 3: Payment Method Selection
$('input[name="radioFruit"]').on('click', function() {
    selectedPaymentType = $(this).val();
});

// Service Mode Selection (add radio buttons to modal)
$('input[name="radioMode"]').on('click', function() {
    selectedServiceMode = $(this).val(); // "Online" or "In-person"

    // Show/hide date/time fields based on mode
    if (selectedServiceMode === 'In-person') {
        $('.milestone-date-time-fields').show().find('input').prop('required', true);
    } else {
        $('.milestone-date-time-fields').hide().find('input').prop('required', false);
    }
});

// Add Milestone Button
$('#addMilestoneBtn').on('click', function() {
    const milestoneHtml = `
        <div class="milestone-form border rounded p-3 mb-3" data-milestone-index="${milestones.length}">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6>Milestone ${milestones.length + 1}</h6>
                <button type="button" class="btn btn-sm btn-danger remove-milestone-btn">
                    <i class="bx bx-trash"></i> Remove
                </button>
            </div>

            <div class="row">
                <div class="col-md-12 mb-2">
                    <input type="text" class="form-control milestone-title" placeholder="Milestone Title *" required>
                </div>
                <div class="col-md-12 mb-2">
                    <textarea class="form-control milestone-description" rows="2" placeholder="Description (optional)"></textarea>
                </div>

                <!-- Date/Time Fields (shown only for in-person) -->
                <div class="col-md-4 mb-2 milestone-date-time-fields" style="display:none;">
                    <input type="date" class="form-control milestone-date" placeholder="Date">
                </div>
                <div class="col-md-4 mb-2 milestone-date-time-fields" style="display:none;">
                    <input type="time" class="form-control milestone-start-time" placeholder="Start Time">
                </div>
                <div class="col-md-4 mb-2 milestone-date-time-fields" style="display:none;">
                    <input type="time" class="form-control milestone-end-time" placeholder="End Time">
                </div>

                <div class="col-md-6 mb-2">
                    <input type="number" class="form-control milestone-price" placeholder="Price (USD) *" min="10" step="0.01" required>
                </div>

                <!-- Revisions (shown only for freelance) -->
                <div class="col-md-6 mb-2 freelance-only" style="display:none;">
                    <input type="number" class="form-control milestone-revisions" placeholder="Revisions *" min="0">
                </div>

                <!-- Delivery Days (shown only for freelance single payment) -->
                <div class="col-md-6 mb-2 freelance-single-only" style="display:none;">
                    <input type="number" class="form-control milestone-delivery-days" placeholder="Delivery Days *" min="1">
                </div>
            </div>
        </div>
    `;

    $('#milestonesContainer').append(milestoneHtml);
    updateFieldVisibility();
    updateTotalAmount();
});

// Remove Milestone Button
$(document).on('click', '.remove-milestone-btn', function() {
    $(this).closest('.milestone-form').remove();
    updateMilestoneNumbers();
    updateTotalAmount();
});

// Update milestone numbering
function updateMilestoneNumbers() {
    $('.milestone-form').each(function(index) {
        $(this).find('h6').text('Milestone ' + (index + 1));
        $(this).attr('data-milestone-index', index);
    });
}

// Show/hide fields based on offer type and payment type
function updateFieldVisibility() {
    if (selectedOfferType === 'Freelance') {
        $('.freelance-only').show().find('input').prop('required', true);

        if (selectedPaymentType === 'Single') {
            $('.freelance-single-only').show().find('input').prop('required', true);
        } else {
            $('.freelance-single-only').hide().find('input').prop('required', false);
        }
    } else {
        $('.freelance-only, .freelance-single-only').hide().find('input').prop('required', false);
    }

    if (selectedServiceMode === 'In-person') {
        $('.milestone-date-time-fields').show().find('input').prop('required', true);
    }
}

// Calculate and display total amount
function updateTotalAmount() {
    let total = 0;
    $('.milestone-price').each(function() {
        const price = parseFloat($(this).val()) || 0;
        total += price;
    });

    $('#totalAmountDisplay').text('$' + total.toFixed(2));
}

// Update total on price change
$(document).on('input', '.milestone-price', function() {
    updateTotalAmount();
});

// Collect all milestone data
function collectMilestones() {
    const milestones = [];

    $('.milestone-form').each(function() {
        const $form = $(this);

        const milestone = {
            title: $form.find('.milestone-title').val(),
            description: $form.find('.milestone-description').val(),
            price: parseFloat($form.find('.milestone-price').val()),
        };

        // Add date/time if in-person
        if (selectedServiceMode === 'In-person') {
            milestone.date = $form.find('.milestone-date').val();
            milestone.start_time = $form.find('.milestone-start-time').val();
            milestone.end_time = $form.find('.milestone-end-time').val();
        }

        // Add revisions if freelance
        if (selectedOfferType === 'Freelance') {
            milestone.revisions = parseInt($form.find('.milestone-revisions').val()) || 0;
        }

        // Add delivery days if freelance single payment
        if (selectedOfferType === 'Freelance' && selectedPaymentType === 'Single') {
            milestone.delivery_days = parseInt($form.find('.milestone-delivery-days').val()) || 0;
        }

        milestones.push(milestone);
    });

    return milestones;
}

// Validate and send custom offer
$('#sendCustomOfferBtn').on('click', function() {
    // Validation
    if (!selectedGigId) {
        toastr.error('Please select a service');
        return;
    }

    if (!selectedOfferType || !selectedPaymentType || !selectedServiceMode) {
        toastr.error('Please complete all required selections');
        return;
    }

    const milestones = collectMilestones();

    if (milestones.length === 0) {
        toastr.error('Please add at least one milestone');
        return;
    }

    // Validate each milestone
    for (let i = 0; i < milestones.length; i++) {
        const m = milestones[i];

        if (!m.title || !m.price || m.price < 10) {
            toastr.error(`Milestone ${i + 1}: Title and price (min $10) are required`);
            return;
        }

        if (selectedServiceMode === 'In-person' && (!m.date || !m.start_time || !m.end_time)) {
            toastr.error(`Milestone ${i + 1}: Date and time are required for in-person services`);
            return;
        }

        if (selectedOfferType === 'Freelance' && !m.revisions) {
            toastr.error(`Milestone ${i + 1}: Revisions are required for freelance services`);
            return;
        }
    }

    // Prepare offer data
    const offerData = {
        buyer_id: $('#teacher_reciver_id').val(), // Get buyer ID from chat
        gig_id: selectedGigId,
        offer_type: selectedOfferType,
        payment_type: selectedPaymentType,
        service_mode: selectedServiceMode,
        description: $('#offerDescription').val(),
        expire_days: $('#offerExpireDays').val() || null,
        request_requirements: $('#requestRequirements').is(':checked'),
        milestones: milestones,
        _token: '{{ csrf_token() }}'
    };

    // Show loading
    $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending...');

    // Send AJAX request
    $.ajax({
        url: '/custom-offers',
        method: 'POST',
        data: offerData,
        success: function(response) {
            toastr.success('Custom offer sent successfully!');

            // Close all modals
            $('.modal').modal('hide');

            // Reset form
            resetCustomOfferForm();

            // Optionally refresh chat to show offer card
            // location.reload(); // or use AJAX to append new message
        },
        error: function(xhr) {
            const errorMsg = xhr.responseJSON?.error || 'Failed to send custom offer';
            toastr.error(errorMsg);
        },
        complete: function() {
            $('#sendCustomOfferBtn').prop('disabled', false).html('Send Offer');
        }
    });
});

// Reset form after sending
function resetCustomOfferForm() {
    selectedGigId = null;
    selectedOfferType = null;
    selectedPaymentType = null;
    selectedServiceMode = null;
    $('#milestonesContainer').empty();
    $('#offerDescription').val('');
    $('#offerExpireDays').val('');
    $('#requestRequirements').prop('checked', false);
    $('input[type="radio"]').prop('checked', false);
}
```

**Estimated Time:** 8-10 hours

---

#### Function 2: Accept Offer (Buyer Side)

```javascript
function acceptOffer(offerId) {
    if (!confirm('Are you sure you want to accept this offer? You will be redirected to payment.')) {
        return;
    }

    $.ajax({
        url: `/custom-offers/${offerId}/accept`,
        method: 'POST',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if (response.checkout_url) {
                // Redirect to Stripe checkout
                window.location.href = response.checkout_url;
            } else {
                toastr.error('Payment URL not received');
            }
        },
        error: function(xhr) {
            const errorMsg = xhr.responseJSON?.error || 'Failed to accept offer';
            toastr.error(errorMsg);
        }
    });
}
```

**Estimated Time:** 1-2 hours

---

#### Function 3: Reject Offer (Buyer Side)

```javascript
function rejectOffer(offerId) {
    const reason = prompt('Why are you rejecting this offer? (Optional)');

    $.ajax({
        url: `/custom-offers/${offerId}/reject`,
        method: 'POST',
        data: {
            reason: reason,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            toastr.success('Offer rejected');

            // Close modal if open
            $('#customOfferDetailModal').modal('hide');

            // Update UI
            $(`.custom-offer-card[data-offer-id="${offerId}"]`)
                .find('.badge').removeClass('bg-warning').addClass('bg-danger').text('Rejected');
            $(`.custom-offer-card[data-offer-id="${offerId}"]`)
                .find('.offer-actions').html('<span class="text-muted">Offer rejected</span>');
        },
        error: function(xhr) {
            toastr.error('Failed to reject offer');
        }
    });
}
```

**Estimated Time:** 1-2 hours

---

### ❌ 7. Stripe Payment Integration (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

**Required Components:**

#### 1. Checkout Session Creation
- ✅ Covered in `acceptCustomOffer()` controller method

#### 2. Success Callback Handler
- ✅ Covered in `handleCustomOfferPayment()` method

#### 3. Webhook Handler (Optional but Recommended)

**Location:** `/app/Http/Controllers/StripeWebhookController.php`

**Add Method:**
```php
// In existing webhook handler
public function handleWebhook(Request $request)
{
    // Existing webhook handling...

    // Add custom offer handling
    if ($event->type === 'checkout.session.completed') {
        $session = $event->data->object;

        if (isset($session->metadata->custom_offer_id)) {
            $this->handleCustomOfferCheckout($session);
        }
    }
}

private function handleCustomOfferCheckout($session)
{
    $offerId = $session->metadata->custom_offer_id;
    $offer = CustomOffer::with('milestones')->find($offerId);

    if (!$offer) {
        \Log::error("Custom offer not found: {$offerId}");
        return;
    }

    // Check if order already exists
    $existingOrder = BookOrder::where('custom_offer_id', $offerId)->first();
    if ($existingOrder) {
        \Log::info("Order already exists for offer: {$offerId}");
        return;
    }

    // Create order (same logic as handleCustomOfferPayment)
    // ... (copy code from handleCustomOfferPayment method)
}
```

**Estimated Time:** 2-3 hours

---

### ❌ 8. Notifications & Emails (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

#### Required Email Templates (4 files):

---

#### Email 1: Custom Offer Sent (to Buyer)

**File:** `resources/views/emails/custom-offer-sent.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #25AB75; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .milestone { border-left: 3px solid #25AB75; padding-left: 15px; margin: 10px 0; }
        .total { background: #fff; padding: 15px; margin: 20px 0; font-size: 18px; }
        .btn { display: inline-block; padding: 12px 30px; background: #25AB75; color: white;
               text-decoration: none; border-radius: 5px; margin: 10px 5px; }
        .btn-secondary { background: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 You Have a New Custom Offer!</h1>
        </div>

        <div class="content">
            <p>Hi {{ $offer->buyer->first_name }},</p>

            <p><strong>{{ $offer->seller->first_name }} {{ $offer->seller->last_name }}</strong>
               sent you a custom offer for <strong>{{ $offer->gig->title }}</strong>.</p>

            @if($offer->description)
                <p><em>{{ $offer->description }}</em></p>
            @endif

            <h3>Offer Details:</h3>
            <ul>
                <li><strong>Type:</strong> {{ $offer->offer_type }} Booking</li>
                <li><strong>Payment:</strong> {{ $offer->payment_type }} Payment</li>
                <li><strong>Service Mode:</strong> {{ $offer->service_mode }}</li>
                <li><strong>Milestones:</strong> {{ $offer->milestones->count() }}</li>
            </ul>

            <h3>Milestones:</h3>
            @foreach($offer->milestones as $index => $milestone)
                <div class="milestone">
                    <strong>{{ $index + 1 }}. {{ $milestone->title }}</strong> - ${{ number_format($milestone->price, 2) }}
                    @if($milestone->description)
                        <p>{{ $milestone->description }}</p>
                    @endif
                </div>
            @endforeach

            <div class="total">
                <strong>Total Amount:</strong> <span style="color: #25AB75; font-size: 24px;">${{ number_format($offer->total_amount, 2) }}</span>
            </div>

            @if($offer->expires_at)
                <p><strong>⏰ This offer expires on {{ $offer->expires_at->format('F d, Y') }}</strong></p>
            @endif

            <p style="text-align: center;">
                <a href="{{ url('/custom-offers/' . $offer->id) }}" class="btn">View Offer</a>
            </p>
        </div>
    </div>
</body>
</html>
```

**Mail Class:** `app/Mail/CustomOfferSent.php`

```php
<?php

namespace App\Mail;

use App\Models\CustomOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomOfferSent extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    public function __construct(CustomOffer $offer)
    {
        $this->offer = $offer->load(['seller', 'buyer', 'gig', 'milestones']);
    }

    public function build()
    {
        return $this->subject('New Custom Offer from ' . $this->offer->seller->first_name)
                    ->view('emails.custom-offer-sent');
    }
}
```

**Usage in Controller:**
```php
// In sendCustomOffer() method, after creating offer:
\Mail::to($offer->buyer->email)->send(new \App\Mail\CustomOfferSent($offer));
```

---

#### Email 2: Offer Accepted (to Seller)

**File:** `resources/views/emails/custom-offer-accepted.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Same styles as above */
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="background: #28a745;">
            <h1>✅ Your Custom Offer Was Accepted!</h1>
        </div>

        <div class="content">
            <p>Hi {{ $offer->seller->first_name }},</p>

            <p>Great news! <strong>{{ $offer->buyer->first_name }} {{ $offer->buyer->last_name }}</strong>
               accepted your custom offer for <strong>{{ $offer->gig->title }}</strong>.</p>

            <div class="total">
                <strong>Order Amount:</strong> <span style="color: #28a745; font-size: 24px;">${{ number_format($offer->total_amount, 2) }}</span>
            </div>

            <p>The buyer has completed payment. You can now view the order details and start working on the project.</p>

            <p style="text-align: center;">
                <a href="{{ url('/teacher-dashboard') }}" class="btn">View Orders</a>
            </p>
        </div>
    </div>
</body>
</html>
```

**Mail Class:** `app/Mail/CustomOfferAccepted.php`

```php
<?php

namespace App\Mail;

use App\Models\CustomOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomOfferAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    public function __construct(CustomOffer $offer)
    {
        $this->offer = $offer->load(['seller', 'buyer', 'gig']);
    }

    public function build()
    {
        return $this->subject('Offer Accepted: ' . $this->offer->gig->title)
                    ->view('emails.custom-offer-accepted');
    }
}
```

---

#### Email 3: Offer Rejected (to Seller)

**File:** `resources/views/emails/custom-offer-rejected.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Same styles */
    </style>
</head>
<body>
    <div class="container">
        <div class="header" style="background: #dc3545;">
            <h1>❌ Custom Offer Declined</h1>
        </div>

        <div class="content">
            <p>Hi {{ $offer->seller->first_name }},</p>

            <p><strong>{{ $offer->buyer->first_name }} {{ $offer->buyer->last_name }}</strong>
               declined your custom offer for <strong>{{ $offer->gig->title }}</strong>.</p>

            @if($offer->rejection_reason)
                <div style="background: #fff; padding: 15px; margin: 20px 0; border-left: 3px solid #dc3545;">
                    <strong>Reason:</strong>
                    <p>{{ $offer->rejection_reason }}</p>
                </div>
            @endif

            <p>You can send a new customized offer or reach out to the buyer through messages.</p>

            <p style="text-align: center;">
                <a href="{{ url('/teacher-dashboard') }}" class="btn">Go to Dashboard</a>
            </p>
        </div>
    </div>
</body>
</html>
```

**Mail Class:** `app/Mail/CustomOfferRejected.php`

---

#### Email 4: Offer Expired (to Both Parties)

**File:** `resources/views/emails/custom-offer-expired.blade.php`

**Mail Class:** `app/Mail/CustomOfferExpired.php`

**Estimated Time for All Emails:** 6-8 hours

---

### ❌ 9. Automated Tasks (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

#### Required Console Command: Expire Custom Offers

**File:** `app/Console/Commands/ExpireCustomOffers.php`

```php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomOffer;
use Carbon\Carbon;

class ExpireCustomOffers extends Command
{
    protected $signature = 'custom-offers:expire';
    protected $description = 'Mark expired custom offers as expired and send notifications';

    public function handle()
    {
        $expiredOffers = CustomOffer::where('status', 'pending')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', Carbon::now())
            ->get();

        $count = 0;

        foreach ($expiredOffers as $offer) {
            $offer->markAsExpired();

            // Send notifications
            app(\App\Services\NotificationService::class)->send(
                userId: $offer->buyer_id,
                type: 'custom_offer',
                title: 'Custom Offer Expired',
                message: 'The custom offer from ' . $offer->seller->first_name . ' has expired.',
                data: ['offer_id' => $offer->id],
                sendEmail: true
            );

            app(\App\Services\NotificationService::class)->send(
                userId: $offer->seller_id,
                type: 'custom_offer',
                title: 'Custom Offer Expired',
                message: 'Your custom offer to ' . $offer->buyer->first_name . ' has expired.',
                data: ['offer_id' => $offer->id],
                sendEmail: true
            );

            $count++;
        }

        $this->info("Expired {$count} custom offers.");
        \Log::info("Custom Offers Expiry: {$count} offers marked as expired.");

        return 0;
    }
}
```

**Register in Scheduler:**

**File:** `app/Console/Kernel.php`

```php
protected function schedule(Schedule $schedule)
{
    // Existing scheduled commands...

    // Custom Offers Expiry (run hourly)
    $schedule->command('custom-offers:expire')
        ->hourly()
        ->withoutOverlapping()
        ->runInBackground()
        ->appendOutputTo(storage_path('logs/custom-offers-expire.log'));
}
```

**Estimated Time:** 2-3 hours

---

### ❌ 10. Business Logic Validations (0% Complete)

**Status:** 🔴 **COMPLETELY MISSING**

#### Required Validations (in Controller):

1. **In-person Date/Time Validation:**
   - ✅ Covered in `sendCustomOffer()` validation rules

2. **Freelance Revisions Validation:**
   - ✅ Covered in `sendCustomOffer()` validation rules

3. **Minimum $10 Per Milestone:**
   - ✅ Covered in validation rules (`min:10`)

4. **Duplicate Offer Prevention:**
   - ✅ Covered in `sendCustomOffer()` method

5. **Authorization Checks:**
   - ⚠️ Add to all methods (already shown in code examples)

6. **Expired Offer Checks:**
   - ✅ Covered in `acceptCustomOffer()` method

**Estimated Time:** Already included in controller methods (2-3 hours for testing)

---

## Development Phases

### Phase 1: Foundation (Week 1) - 🔴 CRITICAL PRIORITY

**Goal:** Build core infrastructure

**Tasks:**
1. ✅ Create database migrations (2-3 hours)
2. ✅ Create models with relationships (1-2 hours)
3. ✅ Implement 5 controller methods (12-16 hours)
4. ✅ Add 4 missing routes (30 minutes)
5. ✅ Complete seller-side JavaScript (8-10 hours)

**Deliverables:**
- Database tables created and migrated
- Models functional with relationships
- All controller methods working
- Routes registered
- Seller can create and send offers

**Total Estimated Time:** 24-32 hours

---

### Phase 2: Integration (Week 2) - 🔴 CRITICAL PRIORITY

**Goal:** Build buyer experience and payment flow

**Tasks:**
1. ✅ Build buyer-side UI components (6-8 hours)
2. ✅ Stripe payment integration (8-10 hours)
3. ✅ Automatic order creation (4-6 hours)
4. ✅ Notification system (4-6 hours)
5. ✅ Email templates and mail classes (6-8 hours)

**Deliverables:**
- Buyer can view, accept, reject offers
- Stripe checkout working
- Orders created automatically
- Notifications sent for all actions
- Emails sent for all events

**Total Estimated Time:** 28-38 hours

---

### Phase 3: Polish & Testing (Week 3) - 🟡 HIGH PRIORITY

**Goal:** Complete remaining features and test thoroughly

**Tasks:**
1. ✅ Preview page before sending offer (3-4 hours)
2. ✅ Auto-expiry console command (2-3 hours)
3. ✅ Business logic enhancements (4-6 hours)
4. ✅ Comprehensive testing (10-12 hours)
5. ✅ Bug fixes and refinements (4-6 hours)

**Deliverables:**
- Preview functionality working
- Auto-expiry automated
- All validations in place
- Tested on multiple browsers
- Mobile responsive

**Total Estimated Time:** 23-31 hours

---

## Detailed Implementation Guide

### Step-by-Step Implementation Order

#### Step 1: Database Setup (Day 1 - Morning)

**Time:** 2-3 hours

```bash
# Create migrations
php artisan make:migration create_custom_offers_table
php artisan make:migration create_custom_offer_milestones_table

# Edit migration files (copy code from section above)
# Run migrations
php artisan migrate

# Verify tables created
php artisan tinker
>>> Schema::hasTable('custom_offers');  // should return true
>>> Schema::hasTable('custom_offer_milestones');  // should return true
```

---

#### Step 2: Models (Day 1 - Afternoon)

**Time:** 1-2 hours

```bash
# Create models
php artisan make:model CustomOffer
php artisan make:model CustomOfferMilestone

# Copy model code from section above
# Test relationships
php artisan tinker
>>> $offer = App\Models\CustomOffer::with('milestones')->first();
>>> $offer->seller->name;
>>> $offer->milestones->count();
```

---

#### Step 3: Controller Methods (Day 1-2)

**Time:** 12-16 hours

**Priority Order:**
1. `sendCustomOffer()` - Most critical (4-6 hours)
2. `viewCustomOffer()` - Needed by buyer (1-2 hours)
3. `acceptCustomOffer()` - Payment flow (4-6 hours)
4. `rejectCustomOffer()` - Simple (2-3 hours)
5. `handleCustomOfferPayment()` - Complex (6-8 hours)

**Testing After Each Method:**
```bash
# Test with Postman or browser
# Send test request to each endpoint
# Verify database records created
# Check validation errors
```

---

#### Step 4: Routes (Day 2 - Morning)

**Time:** 30 minutes

```php
// Add to routes/web.php
// Copy route code from section above
// Test all routes exist:
php artisan route:list | grep custom-offers
```

---

#### Step 5: Seller-Side JavaScript (Day 2-3)

**Time:** 8-10 hours

**Files to Modify:**
- `/resources/views/Teacher-Dashboard/chat.blade.php`

**Tasks:**
1. Add milestone add/remove functionality (2 hours)
2. Implement form data collection (2 hours)
3. Add total amount calculation (1 hour)
4. Implement validation logic (2 hours)
5. Create send offer AJAX call (2 hours)
6. Testing and debugging (2 hours)

**Testing:**
- Click through entire flow
- Try adding/removing milestones
- Verify validation works
- Check console for errors
- Test AJAX call sends correct data

---

#### Step 6: Buyer-Side UI (Day 3-4)

**Time:** 6-8 hours

**Files to Create:**
- `resources/views/components/custom-offer-card.blade.php`
- `resources/views/components/custom-offer-detail-modal.blade.php`

**Files to Modify:**
- `resources/views/User-Dashboard/messages.blade.php` (integrate card)

**Tasks:**
1. Create offer card component (2 hours)
2. Create detail modal component (2 hours)
3. Add JavaScript for view/accept/reject (2 hours)
4. Style and responsive design (2 hours)

**Testing:**
- View offer in messages
- Click "View Details"
- Test accept button (should redirect to Stripe)
- Test reject button
- Check mobile view

---

#### Step 7: Stripe Integration (Day 4-5)

**Time:** 8-10 hours

**Tasks:**
1. Implement checkout session creation (3 hours)
2. Create success callback handler (3 hours)
3. Add webhook handler (optional, 2 hours)
4. Test payment flow end-to-end (3 hours)

**Testing:**
- Use Stripe test mode
- Test successful payment
- Test cancelled payment
- Verify order created correctly
- Check webhook logs

---

#### Step 8: Notifications (Day 5)

**Time:** 4-6 hours

**Files to Modify:**
- Controller methods (add notification calls)

**Tasks:**
1. Add in-app notifications (2 hours)
2. Integrate with NotificationService (2 hours)
3. Test all notification triggers (2 hours)

---

#### Step 9: Email Templates (Day 6)

**Time:** 6-8 hours

**Files to Create:**
- 4 email Blade templates
- 4 Mail classes

**Tasks:**
1. Create all email templates (4 hours)
2. Create all mail classes (2 hours)
3. Integrate with controllers (1 hour)
4. Send test emails (1 hour)

**Testing:**
- Use Mailtrap or similar service
- Send test offer (check buyer email)
- Accept offer (check seller email)
- Reject offer (check seller email)

---

#### Step 10: Automated Tasks (Day 7)

**Time:** 2-3 hours

**Files to Create:**
- `app/Console/Commands/ExpireCustomOffers.php`

**Files to Modify:**
- `app/Console/Kernel.php`

**Tasks:**
1. Create expire command (1 hour)
2. Register in scheduler (30 minutes)
3. Test manually (30 minutes)
4. Verify scheduler runs (30 minutes)

**Testing:**
```bash
# Run manually
php artisan custom-offers:expire

# Check scheduled tasks
php artisan schedule:list

# Run scheduler once
php artisan schedule:run

# Check logs
tail -f storage/logs/custom-offers-expire.log
```

---

#### Step 11: Preview Page (Day 7-8)

**Time:** 3-4 hours

**Files to Create:**
- New modal or page for preview

**Tasks:**
1. Design preview layout (1 hour)
2. Populate with form data (1 hour)
3. Add edit buttons (1 hour)
4. Final confirmation (1 hour)

---

#### Step 12: Comprehensive Testing (Day 9-10)

**Time:** 10-12 hours

**Test Scenarios:**
1. Seller creates Class offer (single payment)
2. Seller creates Class offer (milestone payment)
3. Seller creates Freelance offer (single payment)
4. Seller creates Freelance offer (milestone payment)
5. Buyer accepts offer → payment → order created
6. Buyer rejects offer
7. Offer expires automatically
8. In-person service with dates/times
9. Online service without dates/times
10. Edge cases (negative prices, invalid dates, etc.)

**Browsers to Test:**
- Chrome
- Firefox
- Edge
- Safari (if available)

**Devices:**
- Desktop (1920x1080)
- Tablet (iPad)
- Mobile (iPhone, Android)

---

## Files to Create/Modify

### Complete File List (22 files)

#### Migrations (2 files) - CREATE
1. `database/migrations/2025_xx_xx_create_custom_offers_table.php`
2. `database/migrations/2025_xx_xx_create_custom_offer_milestones_table.php`

#### Models (2 files) - CREATE
3. `app/Models/CustomOffer.php`
4. `app/Models/CustomOfferMilestone.php`

#### Controllers (2 files) - MODIFY
5. `app/Http/Controllers/MessagesController.php` (add 5 methods)
6. `app/Http/Controllers/BookingController.php` (add 1 method)

#### Routes (1 file) - MODIFY
7. `routes/web.php` (add 4 routes)

#### Views - Seller Side (1 file) - MODIFY
8. `resources/views/Teacher-Dashboard/chat.blade.php` (complete JavaScript)

#### Views - Buyer Side (2 files) - CREATE
9. `resources/views/components/custom-offer-card.blade.php`
10. `resources/views/components/custom-offer-detail-modal.blade.php`

#### JavaScript (1 file) - CREATE (optional - recommended)
11. `public/js/custom-offers.js` (extract from Blade file)

#### Email Templates (4 files) - CREATE
12. `resources/views/emails/custom-offer-sent.blade.php`
13. `resources/views/emails/custom-offer-accepted.blade.php`
14. `resources/views/emails/custom-offer-rejected.blade.php`
15. `resources/views/emails/custom-offer-expired.blade.php`

#### Mail Classes (4 files) - CREATE
16. `app/Mail/CustomOfferSent.php`
17. `app/Mail/CustomOfferAccepted.php`
18. `app/Mail/CustomOfferRejected.php`
19. `app/Mail/CustomOfferExpired.php`

#### Console Commands (1 file) - CREATE
20. `app/Console/Commands/ExpireCustomOffers.php`

#### Scheduler (1 file) - MODIFY
21. `app/Console/Kernel.php` (register expire command)

#### Database (1 file) - MODIFY
22. Update `messages` table to add `custom_offer_id` column (optional for linking messages to offers)

---

## Security & Quality Checklist

### Security Requirements

#### 1. Authorization Checks
- ✅ Verify seller owns the gig before sending offer
- ✅ Verify buyer is recipient before accepting/rejecting
- ✅ Prevent sending offer to self
- ✅ Verify user is authenticated for all actions

#### 2. Input Validation
- ✅ Validate all form inputs (Laravel validation)
- ✅ Sanitize user-provided descriptions
- ✅ Validate price is numeric and >= $10
- ✅ Validate dates are in future
- ✅ Validate times (start < end)

#### 3. CSRF Protection
- ✅ Include `@csrf` token in all forms
- ✅ Verify token in AJAX requests (`_token` field)

#### 4. SQL Injection Prevention
- ✅ Use Eloquent ORM (never raw queries)
- ✅ Use parameter binding if raw queries needed

#### 5. XSS Prevention
- ✅ Use `{{ }}` syntax in Blade (auto-escapes)
- ✅ Never use `{!! !!}` for user input
- ✅ Sanitize descriptions with `e()` helper if needed

#### 6. Payment Security
- ✅ Never store credit card data
- ✅ Use Stripe's secure checkout
- ✅ Verify payment status before creating order
- ✅ Validate Stripe webhook signatures (if using webhooks)

---

### Code Quality Requirements

#### 1. Error Handling
- ✅ Try-catch blocks for Stripe API calls
- ✅ Graceful error messages for users
- ✅ Log errors for debugging (`\Log::error()`)
- ✅ AJAX error handlers (`.fail()` or `.error()`)

#### 2. Validation Feedback
- ✅ Clear error messages for validation failures
- ✅ Highlight invalid fields
- ✅ Use `toastr` or similar for user notifications

#### 3. Code Organization
- ✅ Extract JavaScript to separate files (recommended)
- ✅ Use Blade components for reusable UI
- ✅ Follow Laravel naming conventions
- ✅ Add comments for complex logic

#### 4. Database Best Practices
- ✅ Use foreign key constraints
- ✅ Add indexes on frequently queried columns
- ✅ Use appropriate data types
- ✅ Set default values where applicable

#### 5. Performance
- ✅ Use eager loading (`.with()`) to prevent N+1 queries
- ✅ Paginate large result sets
- ✅ Cache expensive calculations (if needed)
- ✅ Optimize AJAX requests (debounce/throttle)

---

## Testing Plan

### Manual Testing Checklist

#### Seller Side Testing
- [ ] Click "Custom Offer" button in chat
- [ ] Select "Class Booking"
- [ ] Select existing class service
- [ ] Choose "Single Payment"
- [ ] Fill milestone form with all fields
- [ ] Verify total amount displays correctly
- [ ] Click "Send Offer"
- [ ] Verify success message
- [ ] Check database for custom_offers record
- [ ] Check buyer receives notification
- [ ] Check buyer receives email

**Repeat for:**
- [ ] Class Booking + Milestone Payment
- [ ] Freelance Booking + Single Payment
- [ ] Freelance Booking + Milestone Payment
- [ ] In-person service with dates/times
- [ ] Online service without dates/times

---

#### Buyer Side Testing
- [ ] Login as buyer
- [ ] View message thread with seller
- [ ] See custom offer card
- [ ] Click "View Details"
- [ ] Modal opens with full offer breakdown
- [ ] Click "Accept"
- [ ] Redirect to Stripe checkout
- [ ] Complete payment (use test card: 4242 4242 4242 4242)
- [ ] Redirect back to success page
- [ ] Check order created in database
- [ ] Check seller receives notification
- [ ] Check seller receives email

**Reject Testing:**
- [ ] Click "Reject" on offer
- [ ] Enter reason (optional)
- [ ] Verify offer status changes to "rejected"
- [ ] Check seller receives notification
- [ ] Check seller receives email with reason

---

#### Edge Cases Testing
- [ ] Try accepting expired offer → Should show error
- [ ] Try accepting already-accepted offer → Should show error
- [ ] Try creating offer with price < $10 → Should show validation error
- [ ] Try creating in-person offer without date → Should show validation error
- [ ] Try sending multiple pending offers for same service → Should prevent
- [ ] Try rejecting offer as wrong user → Should show unauthorized
- [ ] Test payment failure (use declined card: 4000 0000 0000 0002)
- [ ] Test offer expiry (create offer with 1-day expiry, wait 1 day)

---

#### Automated Task Testing
- [ ] Create offer with expiry date in past
- [ ] Run command: `php artisan custom-offers:expire`
- [ ] Verify offer marked as expired
- [ ] Check both parties receive notification
- [ ] Verify log file created: `storage/logs/custom-offers-expire.log`
- [ ] Add scheduler test: `php artisan schedule:run`
- [ ] Verify command runs hourly

---

#### Browser/Device Testing
- [ ] Chrome (desktop)
- [ ] Firefox (desktop)
- [ ] Edge (desktop)
- [ ] Safari (desktop - if available)
- [ ] Chrome (mobile - iPhone)
- [ ] Chrome (mobile - Android)
- [ ] iPad (tablet view)

---

#### Performance Testing
- [ ] Create offer with 10 milestones → Should load quickly
- [ ] View offer with 10 milestones → Should render smoothly
- [ ] Test AJAX requests complete in <2 seconds
- [ ] Test page load times <3 seconds
- [ ] Check database queries (use Laravel Debugbar)

---

### Unit Testing (Optional but Recommended)

**Create Tests:**

#### Model Tests
```bash
php artisan make:test CustomOfferTest --unit

# Test methods:
# - isExpired()
# - canBeAccepted()
# - markAsExpired()
# - Relationships (seller, buyer, gig, milestones)
```

#### Feature Tests
```bash
php artisan make:test CustomOfferFeatureTest

# Test routes:
# - POST /custom-offers (send offer)
# - GET /custom-offers/{id} (view offer)
# - POST /custom-offers/{id}/accept
# - POST /custom-offers/{id}/reject
```

**Estimated Testing Time:** 10-12 hours for comprehensive testing

---

## Timeline & Effort Estimation

### Detailed Hour Breakdown

| Task Category | Estimated Hours | Priority |
|---------------|----------------|----------|
| **Phase 1: Foundation** | | |
| Database migrations | 2-3 | 🔴 CRITICAL |
| Models & relationships | 1-2 | 🔴 CRITICAL |
| Controller: sendCustomOffer() | 4-6 | 🔴 CRITICAL |
| Controller: viewCustomOffer() | 1-2 | 🔴 CRITICAL |
| Controller: acceptCustomOffer() | 4-6 | 🔴 CRITICAL |
| Controller: rejectCustomOffer() | 2-3 | 🔴 CRITICAL |
| Controller: handleCustomOfferPayment() | 6-8 | 🔴 CRITICAL |
| Routes registration | 0.5 | 🔴 CRITICAL |
| Seller-side JavaScript completion | 8-10 | 🔴 CRITICAL |
| **Subtotal Phase 1** | **29-41 hours** | |
| | | |
| **Phase 2: Integration** | | |
| Buyer-side UI: Offer card | 3-4 | 🔴 CRITICAL |
| Buyer-side UI: Detail modal | 3-4 | 🔴 CRITICAL |
| Buyer-side JavaScript (accept/reject) | 2-3 | 🔴 CRITICAL |
| Stripe checkout integration | 4-6 | 🔴 CRITICAL |
| Order creation logic | 4-6 | 🔴 CRITICAL |
| Notification integration | 4-6 | 🟡 HIGH |
| Email templates (4 files) | 4-5 | 🟡 HIGH |
| Mail classes (4 files) | 2-3 | 🟡 HIGH |
| **Subtotal Phase 2** | **26-37 hours** | |
| | | |
| **Phase 3: Polish** | | |
| Preview page | 3-4 | 🟡 HIGH |
| Auto-expiry command | 2-3 | 🟢 MEDIUM |
| Business logic enhancements | 2-3 | 🟡 HIGH |
| Code refactoring & cleanup | 2-3 | 🟢 MEDIUM |
| **Subtotal Phase 3** | **9-13 hours** | |
| | | |
| **Testing & QA** | | |
| Manual testing (all scenarios) | 6-8 | 🟡 HIGH |
| Browser/device testing | 2-3 | 🟡 HIGH |
| Bug fixes from testing | 2-4 | 🟡 HIGH |
| **Subtotal Testing** | **10-15 hours** | |
| | | |
| **GRAND TOTAL** | **74-106 hours** | |

---

### Recommended Timeline (3-Week Sprint)

#### Week 1: Foundation
**Days:** Monday - Friday (40 hours)

- **Day 1 (8h):** Database + Models + Controller setup
- **Day 2 (8h):** Complete sendCustomOffer() method
- **Day 3 (8h):** acceptCustomOffer() + rejectCustomOffer()
- **Day 4 (8h):** handleCustomOfferPayment() + routes
- **Day 5 (8h):** Seller-side JavaScript completion + testing

**Deliverable:** Seller can create and send offers (backend functional)

---

#### Week 2: Integration
**Days:** Monday - Friday (40 hours)

- **Day 6 (8h):** Buyer-side UI components
- **Day 7 (8h):** Buyer-side JavaScript + Stripe integration (part 1)
- **Day 8 (8h):** Stripe integration (part 2) + order creation
- **Day 9 (8h):** Notifications + email templates
- **Day 10 (8h):** Email classes + integration testing

**Deliverable:** Full buyer workflow functional, payments working

---

#### Week 3: Polish & Testing
**Days:** Monday - Friday (26-36 hours)

- **Day 11 (6h):** Preview page + auto-expiry command
- **Day 12 (8h):** Comprehensive manual testing
- **Day 13 (6h):** Browser/device testing
- **Day 14 (6h):** Bug fixes and refinements
- **Day 15 (4h):** Final review + deployment preparation

**Deliverable:** Production-ready custom offer feature

---

### Resource Allocation

**Recommended Team:**
- 1 Full-Stack Developer (primary)
- 1 QA Tester (for Week 3)
- 1 Designer (optional - for UI/UX review)

**Alternative (Faster):**
- 2 Full-Stack Developers (can complete in 2 weeks)
  - Developer A: Backend (controllers, models, migrations)
  - Developer B: Frontend (UI, JavaScript, emails)

---

## Next Steps

### Immediate Actions (Today)

1. **Review this plan** with stakeholders
2. **Prioritize features** (if any should be cut for MVP)
3. **Set up development environment** (local Stripe test keys)
4. **Create feature branch** in Git

```bash
git checkout -b feature/custom-offers
```

5. **Start with Phase 1, Step 1** (database migrations)

---

### Before Starting Development

#### 1. Clarify Requirements (if needed)
Ask client/stakeholders:
- Should offers be editable after sending?
- Can buyers counter-offer?
- Should there be offer templates for frequent sellers?
- What happens to offers if service is deleted?
- Should admins be able to view/manage all offers?

#### 2. Set Up Environment
- Ensure Stripe test mode configured
- Set up email testing (Mailtrap, MailHog, etc.)
- Enable Laravel Debugbar for development
- Configure queue worker if using queued jobs

#### 3. Design Review (Optional)
- Review mockups with designer
- Confirm color scheme matches brand
- Verify mobile layouts
- Get approval on email templates

---

### Development Best Practices

1. **Commit frequently** with descriptive messages
2. **Test after each major component** (don't wait till end)
3. **Use feature flags** if deploying incrementally
4. **Document edge cases** as you find them
5. **Keep this plan updated** if scope changes

---

### Deployment Checklist

Before deploying to production:

- [ ] All tests passing
- [ ] Code reviewed (if working in team)
- [ ] Database migrations tested on staging
- [ ] Stripe live mode keys configured (`.env`)
- [ ] Email service configured for production
- [ ] Scheduler running (`cron` job configured)
- [ ] Error logging enabled
- [ ] Rollback plan prepared
- [ ] Stakeholder approval received

---

## Summary

The Custom Offer feature is currently **20-30% complete** with only basic UI mockup and one API endpoint. To reach production:

**Required Work:**
- ✅ 2 database tables
- ✅ 2 models
- ✅ 5 controller methods
- ✅ 4 routes
- ✅ Complete seller-side JavaScript
- ✅ Build entire buyer-side UI
- ✅ Stripe payment integration
- ✅ 4 email templates + mail classes
- ✅ Notifications
- ✅ Auto-expiry automation
- ✅ Comprehensive testing

**Total Effort:** 74-106 hours (2-3 weeks with 1 developer)

**Recommendation:** Allocate 3 weeks for thorough implementation and testing to ensure production-ready quality.

---

**Document Version:** 1.0
**Last Updated:** November 19, 2025
**Status:** ⚠️ Ready for Development

**Next Action:** Begin Phase 1, Step 1 - Create Database Migrations

---

**End of Implementation Plan**
