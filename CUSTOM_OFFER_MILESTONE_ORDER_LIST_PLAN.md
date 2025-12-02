# Custom Offer Milestone Display in Order Lists - Implementation Plan

**Date:** December 1, 2025
**Feature:** Display Custom Offer Milestones in Buyer & Seller Order Lists

---

## Summary

When a buyer accepts a custom offer and completes payment, the order should display milestone tracking for both the buyer and seller:

- **Buyer's Order List:** Shows the list of milestones with their completion status
- **Seller's Order List:** Shows the same milestones with actions to mark them as completed

---

## Current State Analysis

### What Already Exists:
1. **CustomOffer Model** (`app/Models/CustomOffer.php`) - Complete with relationships
2. **CustomOfferMilestone Model** (`app/Models/CustomOfferMilestone.php`) - Has status tracking (pending, in_progress, delivered, completed, released)
3. **BookOrder Model** - Has `custom_offer_id` foreign key
4. **Migration for milestone status** - Adds `status`, `started_at`, `delivered_at`, `completed_at`, `released_at`, `delivery_note`, `revision_note`, `revisions_used`
5. **Buyer-side JavaScript** (`public/assets/user/js/custom-offers-buyer.js`) - Handles viewing/accepting/rejecting offers

### What Needs to be Built:
1. **Order Details View Updates** - Show milestones in order details for both buyer and seller
2. **Seller Milestone Actions** - Mark milestones as started, delivered, completed
3. **Buyer Milestone Actions** - Request revisions, approve milestones
4. **Order List Indicators** - Show milestone progress in order list cards

---

## Implementation Plan

### Phase 1: Database & Model Verification

**1.1 Verify Migrations Are Run**
```bash
php artisan migrate
```

Ensure these migrations have been applied:
- `2025_12_01_121632_add_custom_offer_id_to_book_orders_table.php`
- `2025_12_01_125726_add_status_to_custom_offer_milestones_table.php`

---

### Phase 2: Backend API Endpoints

**2.1 Create Controller: `CustomOfferMilestoneController`**

Location: `app/Http/Controllers/CustomOfferMilestoneController.php`

Methods needed:
```php
class CustomOfferMilestoneController extends Controller
{
    // Get milestones for an order (buyer & seller)
    public function getMilestones($orderId);

    // Seller: Mark milestone as started
    public function startMilestone($milestoneId);

    // Seller: Deliver milestone with note
    public function deliverMilestone(Request $request, $milestoneId);

    // Buyer: Approve/complete milestone
    public function approveMilestone($milestoneId);

    // Buyer: Request revision
    public function requestRevision(Request $request, $milestoneId);
}
```

**2.2 Add Routes**

Location: `routes/web.php`

```php
// Custom Offer Milestone Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    // Get milestones for an order
    Route::get('/orders/{orderId}/milestones', [CustomOfferMilestoneController::class, 'getMilestones']);

    // Seller actions
    Route::post('/milestones/{id}/start', [CustomOfferMilestoneController::class, 'startMilestone']);
    Route::post('/milestones/{id}/deliver', [CustomOfferMilestoneController::class, 'deliverMilestone']);

    // Buyer actions
    Route::post('/milestones/{id}/approve', [CustomOfferMilestoneController::class, 'approveMilestone']);
    Route::post('/milestones/{id}/revision', [CustomOfferMilestoneController::class, 'requestRevision']);
});
```

---

### Phase 3: Buyer-Side UI Changes

**3.1 Update Order Details View**

File: `resources/views/User-Dashboard/order-details.blade.php`

Add a new section to display milestones when the order has `custom_offer_id`:

```blade
@if($order->custom_offer_id && $order->customOffer)
    {{-- Milestones Progress Section --}}
    <div class="info-card">
        <div class="info-card-header">
            <i class="bx bx-list-check"></i>
            <h3>Order Milestones</h3>
        </div>

        <div class="milestone-progress-bar">
            <div class="progress">
                <div class="progress-bar"
                     style="width: {{ $milestoneProgress }}%">
                    {{ $completedMilestones }}/{{ $totalMilestones }} Completed
                </div>
            </div>
        </div>

        @foreach($order->customOffer->milestones as $index => $milestone)
            <div class="milestone-card {{ $milestone->status }}">
                <div class="milestone-header">
                    <span class="milestone-number">#{{ $index + 1 }}</span>
                    <h4>{{ $milestone->title }}</h4>
                    <span class="badge status-{{ $milestone->status }}">
                        {{ ucfirst($milestone->status) }}
                    </span>
                </div>

                <p>{{ $milestone->description }}</p>

                @if($milestone->date)
                    <div class="milestone-date">
                        <i class="bx bx-calendar"></i>
                        {{ $milestone->date->format('M d, Y') }}
                        @if($milestone->start_time && $milestone->end_time)
                            | {{ $milestone->start_time }} - {{ $milestone->end_time }}
                        @endif
                    </div>
                @endif

                <div class="milestone-price">
                    @currency($milestone->price)
                </div>

                {{-- Buyer Actions --}}
                @if($milestone->status === 'delivered')
                    <div class="milestone-actions">
                        <button class="btn btn-success approve-milestone-btn"
                                data-milestone-id="{{ $milestone->id }}">
                            <i class="bx bx-check"></i> Approve & Release Payment
                        </button>

                        @if($milestone->canRequestRevision())
                            <button class="btn btn-warning request-revision-btn"
                                    data-milestone-id="{{ $milestone->id }}">
                                <i class="bx bx-revision"></i> Request Revision
                                ({{ $milestone->revisions - $milestone->revisions_used }} left)
                            </button>
                        @endif
                    </div>
                @endif

                {{-- Delivery Note (shown when delivered) --}}
                @if($milestone->delivery_note)
                    <div class="delivery-note">
                        <strong>Seller's Delivery Note:</strong>
                        {{ $milestone->delivery_note }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif
```

**3.2 Add JavaScript for Buyer Milestone Actions**

File: `public/assets/user/js/custom-offer-milestones.js`

```javascript
// Approve milestone
$(document).on('click', '.approve-milestone-btn', function() {
    const milestoneId = $(this).data('milestone-id');
    if(confirm('Are you sure you want to approve this milestone and release payment?')) {
        $.ajax({
            url: `/milestones/${milestoneId}/approve`,
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                alert('Failed to approve milestone');
            }
        });
    }
});

// Request revision modal
$(document).on('click', '.request-revision-btn', function() {
    const milestoneId = $(this).data('milestone-id');
    $('#revisionMilestoneId').val(milestoneId);
    $('#revisionModal').modal('show');
});
```

---

### Phase 4: Seller-Side UI Changes

**4.1 Update Seller Order Details View**

File: `resources/views/Teacher-Dashboard/order-details.blade.php`

Add milestone management section:

```blade
@if($order->custom_offer_id && $order->customOffer)
    <div class="info-card">
        <div class="info-card-header">
            <i class="bx bx-list-check"></i>
            <h3>Manage Milestones</h3>
        </div>

        @foreach($order->customOffer->milestones as $index => $milestone)
            <div class="milestone-card {{ $milestone->status }}">
                <div class="milestone-header">
                    <span class="milestone-number">#{{ $index + 1 }}</span>
                    <h4>{{ $milestone->title }}</h4>
                    <span class="badge status-{{ $milestone->status }}">
                        {{ ucfirst(str_replace('_', ' ', $milestone->status)) }}
                    </span>
                </div>

                <p>{{ $milestone->description }}</p>

                <div class="milestone-price">
                    Amount: @currency($milestone->price)
                </div>

                {{-- Seller Actions Based on Status --}}
                @if($milestone->status === 'pending')
                    <button class="btn btn-primary start-milestone-btn"
                            data-milestone-id="{{ $milestone->id }}">
                        <i class="bx bx-play"></i> Start Working
                    </button>

                @elseif($milestone->status === 'in_progress')
                    <button class="btn btn-success deliver-milestone-btn"
                            data-milestone-id="{{ $milestone->id }}">
                        <i class="bx bx-check-double"></i> Mark as Delivered
                    </button>

                @elseif($milestone->status === 'delivered')
                    <span class="text-info">
                        <i class="bx bx-time"></i> Awaiting buyer approval
                    </span>

                @elseif($milestone->status === 'completed' || $milestone->status === 'released')
                    <span class="text-success">
                        <i class="bx bx-check-circle"></i> Completed
                    </span>
                @endif

                {{-- Revision Request Alert --}}
                @if($milestone->revision_note && $milestone->status === 'in_progress')
                    <div class="alert alert-warning mt-2">
                        <strong>Revision Requested:</strong>
                        {{ $milestone->revision_note }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endif
```

**4.2 Add JavaScript for Seller Milestone Actions**

File: `public/assets/teacher/js/custom-offer-milestones.js`

```javascript
// Start milestone
$(document).on('click', '.start-milestone-btn', function() {
    const milestoneId = $(this).data('milestone-id');
    $.ajax({
        url: `/milestones/${milestoneId}/start`,
        type: 'POST',
        data: { _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(response) {
            location.reload();
        }
    });
});

// Deliver milestone - show modal for delivery note
$(document).on('click', '.deliver-milestone-btn', function() {
    const milestoneId = $(this).data('milestone-id');
    $('#deliveryMilestoneId').val(milestoneId);
    $('#deliveryModal').modal('show');
});
```

---

### Phase 5: Order List Progress Indicators

**5.1 Update Buyer Order List (class-management.blade.php)**

File: `resources/views/User-Dashboard/class-management.blade.php`

Add milestone progress indicator to each order card:

```blade
@if($order->custom_offer_id && $order->customOffer)
    @php
        $milestones = $order->customOffer->milestones;
        $completedCount = $milestones->whereIn('status', ['completed', 'released'])->count();
        $totalCount = $milestones->count();
        $progressPercent = $totalCount > 0 ? ($completedCount / $totalCount) * 100 : 0;
    @endphp
    <div class="milestone-progress-mini">
        <small>Milestones: {{ $completedCount }}/{{ $totalCount }}</small>
        <div class="progress" style="height: 6px;">
            <div class="progress-bar bg-success" style="width: {{ $progressPercent }}%"></div>
        </div>
    </div>
@endif
```

**5.2 Update Seller Order List (client-managment.blade.php)**

File: `resources/views/Teacher-Dashboard/client-managment.blade.php`

Add similar milestone progress indicator with action needed alerts:

```blade
@if($order->custom_offer_id && $order->customOffer)
    @php
        $milestones = $order->customOffer->milestones;
        $pendingCount = $milestones->where('status', 'pending')->count();
        $inProgressCount = $milestones->where('status', 'in_progress')->count();
        $deliveredCount = $milestones->where('status', 'delivered')->count();
        $completedCount = $milestones->whereIn('status', ['completed', 'released'])->count();
        $totalCount = $milestones->count();
    @endphp

    <div class="milestone-status-mini">
        <small>
            <span class="badge bg-secondary">{{ $pendingCount }} Pending</span>
            <span class="badge bg-primary">{{ $inProgressCount }} In Progress</span>
            <span class="badge bg-info">{{ $deliveredCount }} Delivered</span>
            <span class="badge bg-success">{{ $completedCount }} Completed</span>
        </small>
    </div>
@endif
```

---

### Phase 6: CSS Styling

**6.1 Add Milestone Styles**

File: Create `public/assets/css/custom-offer-milestones.css`

```css
/* Milestone Cards */
.milestone-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.milestone-card.pending {
    border-left: 4px solid #6c757d;
}

.milestone-card.in_progress {
    border-left: 4px solid #007bff;
    background: #f0f7ff;
}

.milestone-card.delivered {
    border-left: 4px solid #17a2b8;
    background: #e8f7fa;
}

.milestone-card.completed,
.milestone-card.released {
    border-left: 4px solid #28a745;
    background: #e8f5e9;
}

/* Status Badges */
.status-pending { background: #6c757d; color: white; }
.status-in_progress { background: #007bff; color: white; }
.status-delivered { background: #17a2b8; color: white; }
.status-completed, .status-released { background: #28a745; color: white; }

/* Mini Progress Bar */
.milestone-progress-mini {
    margin-top: 10px;
    padding: 8px;
    background: #f8f9fa;
    border-radius: 4px;
}
```

---

## File Changes Summary

### Files to Create:
1. `app/Http/Controllers/CustomOfferMilestoneController.php` - New controller
2. `public/assets/user/js/custom-offer-milestones.js` - Buyer JS
3. `public/assets/teacher/js/custom-offer-milestones.js` - Seller JS
4. `public/assets/css/custom-offer-milestones.css` - Shared styles

### Files to Modify:
1. `routes/web.php` - Add 5 new routes
2. `resources/views/User-Dashboard/order-details.blade.php` - Add milestone section
3. `resources/views/Teacher-Dashboard/order-details.blade.php` - Add milestone management
4. `resources/views/User-Dashboard/class-management.blade.php` - Add progress indicator
5. `resources/views/Teacher-Dashboard/client-managment.blade.php` - Add progress indicator

---

## Testing Checklist

After implementation, verify:

- [ ] Buyer can see milestones in order details
- [ ] Buyer can approve delivered milestones
- [ ] Buyer can request revisions (if available)
- [ ] Seller can see milestones in order details
- [ ] Seller can start a pending milestone
- [ ] Seller can deliver a milestone with note
- [ ] Order lists show milestone progress for both buyer and seller
- [ ] Revision requests decrement available revisions count
- [ ] Status transitions work correctly

---

## Approval Required

Please review this plan and confirm:
1. Is the milestone workflow (pending → in_progress → delivered → completed) correct?
2. Should payment be released per milestone or at the end?
3. Any additional fields needed for milestones?
4. Should there be notifications for milestone status changes?

**Awaiting your approval before implementation.**
