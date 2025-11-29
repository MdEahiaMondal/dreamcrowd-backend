# Subscription Cancel Feature - Implementation Plan

## Overview

DreamCrowd-এ "Cancel Subscription" feature implement করতে হবে। Buyer যেন দুই জায়গা থেকে subscription cancel করতে পারে:
1. **Order Management → Active Orders** tab → Subscription order এর পাশে "Cancel Subscription" button
2. **Experts tab** → Teacher এর Action dropdown → "Cancel Subscription" option

---

## Client Requirements Summary

| Requirement | Details |
|-------------|---------|
| Cancel locations | Active Orders + Experts tab |
| What gets cancelled | All active & future classes |
| Refund eligibility | Classes > 12 hours away = full value refund |
| Non-refundable | Classes ≤ 12 hours away = no refund |
| Reason | Required from buyer |
| Notifications | Email + In-app to both Buyer & Seller |
| Visibility | "Cancel Subscription" শুধু Active Subscription (status=1, payment_type='Subscription') এ দেখাবে |

---

## Implementation Approach: Minimal Change

Existing patterns follow করে `OrderManagementController`-এ method add করা হবে।

---

## Files to Modify

### 1. Routes
**File:** `routes/web.php`

```php
// Add after line 568 (near /cancel-order route)
Route::post('/cancel-subscription', 'CancelSubscription');
Route::get('/cancel-subscription/preview/{orderId}', 'CancelSubscriptionPreview');
```

---

### 2. Controller - Add Methods
**File:** `app/Http/Controllers/OrderManagementController.php`

#### Method 1: CancelSubscriptionPreview (AJAX endpoint for modal)
Returns class breakdown for the cancel confirmation modal.

```php
public function CancelSubscriptionPreview($orderId)
{
    // 1. Auth check
    // 2. Validate order belongs to user, is subscription, and is active
    // 3. Get all class_dates for order
    // 4. Categorize classes:
    //    - Completed: user_date < now()
    //    - Non-refundable: now() < user_date <= now() + 12 hours
    //    - Refundable: user_date > now() + 12 hours
    // 5. Calculate refund: pricePerClass * refundableCount
    // 6. Return JSON with breakdown
}
```

#### Method 2: CancelSubscription (POST endpoint)
Executes the actual cancellation.

```php
public function CancelSubscription(Request $request)
{
    // 1. Validate: order_id, reason (required, min:10)
    // 2. Auth check
    // 3. Validate order: belongs to user, status=1, payment_type='Subscription'
    // 4. Calculate refund (same logic as preview)
    // 5. Process Stripe refund:
    //    - If full refund: PaymentIntent::cancel()
    //    - If partial: Refund::create(['amount' => cents])
    // 6. Update book_orders: status=4, refund=1
    // 7. Update transactions: status='refunded', adjust amounts
    // 8. Create cancel_orders record
    // 9. Send notifications (buyer + seller)
    // 10. Redirect with success message
}
```

#### Method 3: Update OrderManagement()
Add `$expertsWithOrders` query to pass to view.

```php
// Add to OrderManagement() method before return statement
$expertsWithOrders = DB::table('book_orders')
    ->join('expert_profiles', 'book_orders.teacher_id', '=', 'expert_profiles.user_id')
    ->select(
        'expert_profiles.user_id as teacher_id',
        'expert_profiles.first_name',
        'expert_profiles.last_name',
        'expert_profiles.profession',
        'expert_profiles.profile_image',
        DB::raw('SUM(CASE WHEN book_orders.status = 1 AND book_orders.payment_type = "Subscription" THEN 1 ELSE 0 END) as active_subscriptions'),
        DB::raw('COUNT(book_orders.id) as total_orders')
    )
    ->where('book_orders.user_id', Auth::user()->id)
    ->groupBy(...)
    ->having('total_orders', '>', 0)
    ->get();

// Add to compact(): 'expertsWithOrders'
```

---

### 3. View - class-management.blade.php
**File:** `resources/views/User-Dashboard/class-management.blade.php`

#### 3a. Add Cancel Subscription Modal (after line 2488)

```html
<!-- Subscription Cancel Modal -->
<div class="modal fade" id="subscription-cancel-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5>Cancel Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Loading Spinner -->
                <div id="subscription-cancel-loading" class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                    <p>Loading cancellation details...</p>
                </div>

                <!-- Content (hidden initially) -->
                <div id="subscription-cancel-content" style="display:none;">
                    <form action="/cancel-subscription" method="POST"> @csrf
                        <input type="hidden" name="order_id" id="sub_cancel_order_id">

                        <!-- Order Info -->
                        <div class="alert alert-light border">
                            <strong>Service:</strong> <span id="sub_cancel_service_name"></span><br>
                            <strong>Total Price:</strong> $<span id="sub_cancel_price"></span>
                        </div>

                        <!-- Classes Breakdown -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h3 id="refundable_count">0</h3>
                                        <small>Refundable Classes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning">
                                    <div class="card-body text-center">
                                        <h3 id="non_refundable_count">0</h3>
                                        <small>Non-Refundable (&lt;12h)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-secondary text-white">
                                    <div class="card-body text-center">
                                        <h3 id="completed_count">0</h3>
                                        <small>Completed</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Refund Amount -->
                        <div class="alert alert-success">
                            <h5>Estimated Refund: $<span id="refund_amount">0.00</span></h5>
                            <small class="text-muted">Classes less than 12 hours away are not eligible for refund.</small>
                        </div>

                        <!-- Class Lists (Collapsible) -->
                        <div class="accordion mb-3" id="classesAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#refundableList">
                                        Refundable Classes (>12 hours)
                                    </button>
                                </h2>
                                <div id="refundableList" class="accordion-collapse collapse">
                                    <ul class="list-group list-group-flush" id="refundable_classes_ul"></ul>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nonRefundableList">
                                        Non-Refundable Classes (&lt;12 hours)
                                    </button>
                                </h2>
                                <div id="nonRefundableList" class="accordion-collapse collapse">
                                    <ul class="list-group list-group-flush" id="non_refundable_classes_ul"></ul>
                                </div>
                            </div>
                        </div>

                        <!-- Reason (Required) -->
                        <div class="mb-3">
                            <label class="form-label">Cancellation Reason <span class="text-danger">*</span></label>
                            <textarea name="reason" class="form-control" rows="3" required
                                      minlength="10" placeholder="Please explain why you are cancelling..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Subscription</button>
                            <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

#### 3b. Add Cancel Subscription Button to Active Orders (around line 2195)

In the action modal for active orders, add conditional button:

```blade
<!-- Only show for subscription orders -->
@if($order->payment_type == 'Subscription')
<div class="col-md-12 services-buttons">
    <button type="button" class="btn btn-danger"
            onclick="openCancelSubscriptionModal({{ $order->order_id }}, '{{ $order->title }}', {{ $order->finel_price }})">
        Cancel Subscription
    </button>
</div>
@endif
```

#### 3c. Replace Static Experts Tab (lines 1614-1875)

Replace hardcoded content with dynamic:

```blade
<div id="tab6" data-tab-content>
    <section>
        <div class="tab__content">
            <!-- Search & Filter (keep existing) -->
        </div>
        <div class="class-management-sec">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            @forelse($expertsWithOrders as $expert)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="float-start profile-section">
                                                <img src="{{ asset('assets/profile/img/' . $expert->profile_image) }}" alt="">
                                                <p>{{ $expert->first_name }} {{ strtoupper(substr($expert->last_name, 0, 1)) }}.
                                                    <br><span>{{ $expert->profession }}</span>
                                                </p>
                                            </div>
                                            <div class="float-end expert-dropdown">
                                                <button class="btn action-btn" type="button" data-bs-toggle="dropdown">...</button>
                                                <ul class="dropdown-menu">
                                                    <a class="dropdown-item" href="/messages?user={{ $expert->teacher_id }}">
                                                        <li>Send Message</li>
                                                    </a>
                                                    <a class="dropdown-item" href="/professional-profile/{{ $expert->teacher_id }}">
                                                        <li>View Profile</li>
                                                    </a>
                                                    @if($expert->active_subscriptions > 0)
                                                    <a class="dropdown-item" href="#"
                                                       onclick="showExpertSubscriptions({{ $expert->teacher_id }})">
                                                        <li>Cancel Subscription ({{ $expert->active_subscriptions }})</li>
                                                    </a>
                                                    @endif
                                                    <a class="dropdown-item" href="#">
                                                        <li>Report Seller</li>
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center text-muted py-4">
                                    No experts found. Book a service to see your experts here.
                                </td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
```

#### 3d. Add JavaScript Functions (bottom of file)

```javascript
// Open Cancel Subscription Modal
function openCancelSubscriptionModal(orderId, serviceName, price) {
    $('#subscription-cancel-loading').show();
    $('#subscription-cancel-content').hide();
    $('#subscription-cancel-modal').modal('show');

    // Set basic info
    $('#sub_cancel_order_id').val(orderId);
    $('#sub_cancel_service_name').text(serviceName);
    $('#sub_cancel_price').text(price.toFixed(2));

    // Fetch preview data
    $.get('/cancel-subscription/preview/' + orderId, function(data) {
        if(data.success) {
            populateCancelModal(data);
            $('#subscription-cancel-loading').hide();
            $('#subscription-cancel-content').show();
        } else {
            toastr.error(data.message || 'Failed to load cancellation details');
            $('#subscription-cancel-modal').modal('hide');
        }
    }).fail(function() {
        toastr.error('Failed to load cancellation details');
        $('#subscription-cancel-modal').modal('hide');
    });
}

function populateCancelModal(data) {
    var breakdown = data.breakdown;

    // Update counts
    $('#refundable_count').text(breakdown.refundable_count);
    $('#non_refundable_count').text(breakdown.non_refundable_count);
    $('#completed_count').text(breakdown.completed_count);
    $('#refund_amount').text(breakdown.refund_amount.toFixed(2));

    // Populate refundable classes list
    var refundableHtml = '';
    breakdown.refundable_classes.forEach(function(c) {
        refundableHtml += '<li class="list-group-item text-success"><i class="fa fa-check"></i> ' +
            formatDateTime(c.user_date) + ' - $' + breakdown.price_per_class.toFixed(2) + ' (Refundable)</li>';
    });
    $('#refundable_classes_ul').html(refundableHtml || '<li class="list-group-item text-muted">No refundable classes</li>');

    // Populate non-refundable classes list
    var nonRefundableHtml = '';
    breakdown.non_refundable_classes.forEach(function(c) {
        nonRefundableHtml += '<li class="list-group-item text-danger"><i class="fa fa-times"></i> ' +
            formatDateTime(c.user_date) + ' - Not refundable (< 12 hours)</li>';
    });
    $('#non_refundable_classes_ul').html(nonRefundableHtml || '<li class="list-group-item text-muted">No non-refundable classes</li>');
}

function formatDateTime(dateStr) {
    return new Date(dateStr).toLocaleString('en-US', {
        month: 'long', day: 'numeric', year: 'numeric',
        hour: 'numeric', minute: '2-digit'
    });
}

// Show subscriptions for a specific expert (from Experts tab)
function showExpertSubscriptions(teacherId) {
    window.location.href = '/order-management#tab2?teacher=' + teacherId;
}
```

---

### 4. Email Templates

#### 4a. Buyer Email
**File:** `resources/views/emails/subscription-cancelled.blade.php`

```blade
@extends('emails.layouts.base')

@section('title', 'Subscription Cancelled')
@section('header_title', 'Subscription Cancelled')

@section('content')
<div class="success-box">
    <h2>Your subscription has been cancelled</h2>
</div>

<div class="info-box">
    <p><strong>Service:</strong> {{ $serviceName }}</p>
    <p><strong>Order ID:</strong> #{{ $orderId }}</p>
</div>

@if($refundAmount > 0)
<div class="success-box">
    <h3>Refund: ${{ number_format($refundAmount, 2) }}</h3>
    <p>Your refund has been initiated and will be processed within 5-10 business days.</p>
</div>
@endif

<div class="alert-box">
    <h4>Cancelled Classes:</h4>
    <ul>
        @foreach($cancelledClasses as $class)
        <li>{{ \Carbon\Carbon::parse($class)->format('F d, Y h:i A') }}</li>
        @endforeach
    </ul>
</div>

@if(count($nonRefundableClasses) > 0)
<div class="info-box">
    <h4>Non-Refundable Classes (< 12 hours notice):</h4>
    <ul>
        @foreach($nonRefundableClasses as $class)
        <li>{{ \Carbon\Carbon::parse($class)->format('F d, Y h:i A') }}</li>
        @endforeach
    </ul>
</div>
@endif

<a href="{{ url('/order-management') }}" class="button">View Order Management</a>
@endsection
```

#### 4b. Seller Email
**File:** `resources/views/emails/subscription-cancelled-seller.blade.php`

```blade
@extends('emails.layouts.base')

@section('title', 'Subscription Cancelled by Buyer')
@section('header_title', 'Subscription Cancelled')

@section('content')
<div class="alert-box">
    <h2>A buyer has cancelled their subscription</h2>
</div>

<div class="info-box">
    <p><strong>Buyer:</strong> {{ $buyerName }}</p>
    <p><strong>Service:</strong> {{ $serviceName }}</p>
    <p><strong>Order ID:</strong> #{{ $orderId }}</p>
    <p><strong>Refund Amount:</strong> ${{ number_format($refundAmount, 2) }}</p>
</div>

<div class="info-box">
    <h4>Cancellation Reason:</h4>
    <p>{{ $reason }}</p>
</div>

<div class="alert-box">
    <h4>Cancelled Classes:</h4>
    <ul>
        @foreach($cancelledClasses as $class)
        <li>{{ \Carbon\Carbon::parse($class)->format('F d, Y h:i A') }}</li>
        @endforeach
    </ul>
</div>

<a href="{{ url('/client-management') }}" class="button">View Client Management</a>
@endsection
```

---

## Refund Calculation Logic

```php
// Fixed Threshold Approach
$now = now();
$classes = ClassDate::where('order_id', $orderId)->get();

$completed = [];      // user_date < now
$nonRefundable = [];  // now < user_date <= now + 12 hours
$refundable = [];     // user_date > now + 12 hours

foreach ($classes as $class) {
    $classTime = Carbon::parse($class->user_date);
    $hoursUntil = $now->diffInHours($classTime, false);

    if ($hoursUntil <= 0) {
        $completed[] = $class;
    } elseif ($hoursUntil <= 12) {
        $nonRefundable[] = $class;
    } else {
        $refundable[] = $class;
    }
}

$totalClasses = count($classes);
$pricePerClass = $order->finel_price / $totalClasses;
$refundAmount = round($pricePerClass * count($refundable), 2);
```

---

## Stripe Refund Pattern

```php
use Stripe\Stripe;
use Stripe\Refund;
use Stripe\PaymentIntent;

Stripe::setApiKey(env('STRIPE_SECRET'));

try {
    $paymentIntent = PaymentIntent::retrieve($order->payment_id);

    if ($refundAmount >= $order->finel_price) {
        // Full refund
        if ($paymentIntent->status === 'requires_capture') {
            $paymentIntent->cancel();
        } else {
            Refund::create(['payment_intent' => $order->payment_id]);
        }
    } else {
        // Partial refund
        Refund::create([
            'payment_intent' => $order->payment_id,
            'amount' => round($refundAmount * 100) // Convert to cents
        ]);
    }
} catch (\Exception $e) {
    Log::error('Stripe refund failed: ' . $e->getMessage());
    return redirect()->back()->with('error', 'Refund failed. Please contact support.');
}
```

---

## Implementation Order

| Step | Task | Estimated Time |
|------|------|----------------|
| 1 | Add routes to `web.php` | 5 min |
| 2 | Add `CancelSubscriptionPreview()` method | 30 min |
| 3 | Add `CancelSubscription()` method | 1.5 hours |
| 4 | Add `$expertsWithOrders` query to `OrderManagement()` | 30 min |
| 5 | Create cancel subscription modal in view | 45 min |
| 6 | Add Cancel button to Active Orders | 15 min |
| 7 | Replace static Experts tab with dynamic | 45 min |
| 8 | Add JavaScript functions | 30 min |
| 9 | Create email templates (2 files) | 30 min |
| 10 | Testing (all scenarios) | 1 hour |

**Total Estimated Time: 6-7 hours**

---

## Critical Files Reference

| File | Purpose |
|------|---------|
| `app/Http/Controllers/OrderManagementController.php` | Main controller - add 3 methods |
| `resources/views/User-Dashboard/class-management.blade.php` | View - modal, buttons, Experts tab, JS |
| `routes/web.php` | Add 2 new routes |
| `resources/views/emails/subscription-cancelled.blade.php` | Buyer email (new) |
| `resources/views/emails/subscription-cancelled-seller.blade.php` | Seller email (new) |
| `app/Services/NotificationService.php` | Reference for notification pattern |
| `app/Console/Commands/AutoHandleDisputes.php` | Reference for Stripe refund pattern |

---

## Testing Checklist

- [ ] Cancel subscription from Active Orders tab (subscription order)
- [ ] Cancel subscription from Experts tab
- [ ] Verify refund calculation (12 hour threshold)
- [ ] Verify Stripe refund (full and partial)
- [ ] Verify buyer email received
- [ ] Verify seller email received
- [ ] Verify in-app notifications
- [ ] Verify order status changes to 4 (Cancelled)
- [ ] Verify transaction updated
- [ ] Verify cancel_orders record created
- [ ] Verify non-subscription orders don't show Cancel Subscription button
- [ ] Verify completed/inactive subscriptions don't show Cancel option
