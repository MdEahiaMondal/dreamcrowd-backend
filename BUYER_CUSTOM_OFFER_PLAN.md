# Buyer-Side Custom Offer Implementation Plan

## Current State Analysis

### What's Already Implemented (Buyer Side)
| Feature | Status | Location |
|---------|--------|----------|
| View Custom Offer Button | ✅ Done | `User-Dashboard/messages.blade.php:215-219` |
| Offer Detail Modal | ✅ Done | `components/custom-offer-modals.blade.php:6-87` |
| Accept & Pay Flow | ✅ Done | `custom-offers-buyer.js:77-321` |
| Stripe Payment Modal | ✅ Done | `components/custom-offer-modals.blade.php:117-204` |
| Reject with Reason | ✅ Done | `components/custom-offer-modals.blade.php:89-115` |
| Payment Success Modal | ✅ Done | `components/custom-offer-modals.blade.php:206-222` |

### What's Missing (Per Requirements)
From `custom_offer.md`:
> "Buyer gets message → Accept / Reject / Counter"
> "Counter offer / Message → দামাদামি চলতে পারে" (negotiation can happen)

| Feature | Status | Required Action |
|---------|--------|-----------------|
| Counter Offer Button | ❌ Missing | Add to offer detail modal |
| Counter Offer Modal/Form | ❌ Missing | Create new modal for buyer to propose changes |
| Counter Offer Route | ❌ Missing | Add route for counter offer submission |
| Counter Offer Controller | ❌ Missing | Add controller method to handle counter offers |
| Counter Offer Database Support | ❌ Missing | Add fields for counter offer tracking |
| Counter Offer Email Notification | ❌ Missing | Notify seller of counter offer |
| Seller-Side Counter Offer View | ❌ Missing | Show counter offers to seller |
| Counter Offer Accept/Reject by Seller | ❌ Missing | Seller actions on counter offers |

---

## Implementation Plan

### Phase 1: Database Schema Updates

**File:** `database/migrations/YYYY_MM_DD_add_counter_offer_fields.php`

Add to `custom_offers` table:
```php
$table->unsignedBigInteger('parent_offer_id')->nullable(); // Links counter to original
$table->boolean('is_counter_offer')->default(false);
$table->enum('counter_status', ['none', 'sent', 'accepted', 'rejected'])->default('none');
$table->timestamp('counter_sent_at')->nullable();
```

**Model Update:** `app/Models/CustomOffer.php`
- Add `parent_offer_id` relationship
- Add `counterOffers()` hasMany relationship
- Add helper methods: `isCounterOffer()`, `hasCounterOffer()`, `getLatestCounterOffer()`

---

### Phase 2: Backend Routes & Controller

**File:** `routes/web.php`
```php
Route::post('/custom-offers/{id}/counter', 'counterCustomOffer')->name('custom-offers.counter');
Route::post('/custom-offers/{id}/counter/accept', 'acceptCounterOffer')->name('custom-offers.counter.accept');
Route::post('/custom-offers/{id}/counter/reject', 'rejectCounterOffer')->name('custom-offers.counter.reject');
```

**File:** `app/Http/Controllers/MessagesController.php`

Add methods:
1. `counterCustomOffer(Request $request, $id)` - Buyer submits counter offer
2. `acceptCounterOffer(Request $request, $id)` - Seller accepts counter
3. `rejectCounterOffer(Request $request, $id)` - Seller rejects counter

---

### Phase 3: Buyer-Side UI Updates

#### 3.1 Add Counter Button to Offer Detail Modal

**File:** `resources/views/components/custom-offer-modals.blade.php`

Add counter button in `.offer-actions` (line 76-84):
```html
<button type="button" class="btn btn-warning" id="counter-offer-btn">
    <i class="fa-solid fa-exchange-alt"></i> Counter Offer
</button>
```

#### 3.2 Create Counter Offer Modal

**File:** `resources/views/components/custom-offer-modals.blade.php`

Add new modal after existing modals:
```html
<!-- Counter Offer Modal -->
<div class="modal fade" id="counterOfferModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Counter Offer</h5>
            </div>
            <div class="modal-body">
                <!-- Original Offer Summary (read-only) -->
                <!-- Counter Offer Form -->
                - Message/Description textarea
                - Total Amount (editable)
                - Option to modify milestones (if milestone payment)
                - Each milestone: title, price, description
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="submit-counter-btn">
                    <i class="fa-solid fa-paper-plane"></i> Send Counter Offer
                </button>
            </div>
        </div>
    </div>
</div>
```

---

### Phase 4: Buyer-Side JavaScript

**File:** `public/assets/user/js/custom-offers-buyer.js`

Add functions:
```javascript
// Handle counter offer button click
$(document).on('click', '#counter-offer-btn', function() {
    showCounterOfferModal();
});

// Show counter offer modal with original offer data
function showCounterOfferModal() {
    populateCounterOfferForm(currentOffer);
    $('#offerDetailModal').modal('hide');
    $('#counterOfferModal').modal('show');
}

// Submit counter offer
function submitCounterOffer() {
    $.ajax({
        url: `/custom-offers/${currentOffer.id}/counter`,
        type: 'POST',
        data: {
            message: $('#counter-message').val(),
            total_amount: $('#counter-total-amount').val(),
            milestones: collectCounterMilestones(),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Success handling
            alert('Counter offer sent successfully!');
            location.reload();
        }
    });
}

// Handle milestone modifications for counter offer
function collectCounterMilestones() { ... }
```

---

### Phase 5: Seller-Side Counter Offer Handling

#### 5.1 Display Counter Offers in Chat

**File:** `resources/views/Teacher-Dashboard/chat.blade.php`

Update message display to show counter offer indicator:
```html
@if($message['is_counter_offer'])
    <div class="counter-offer-badge">
        <i class="fa-solid fa-exchange-alt"></i> Counter Offer Received
    </div>
@endif
```

#### 5.2 Create Seller Counter Offer View Modal

**File:** Add to `resources/views/Teacher-Dashboard/chat.blade.php`

Counter offer detail modal for seller with:
- Original offer summary
- Buyer's counter proposal
- Accept / Reject / Send New Offer buttons

#### 5.3 Seller JavaScript

**File:** `public/assets/teacher/js/custom-offers.js`

Add functions:
- `viewCounterOffer(offerId)`
- `acceptCounterOffer(offerId)`
- `rejectCounterOffer(offerId)`

---

### Phase 6: Email Notifications

**File:** `app/Mail/CustomOfferCounterReceived.php`
- Create new mailable for counter offer notifications
- Send to seller when buyer submits counter

**File:** `app/Mail/CustomOfferCounterAccepted.php`
- Notify buyer when seller accepts counter

**File:** `app/Mail/CustomOfferCounterRejected.php`
- Notify buyer when seller rejects counter

---

### Phase 7: Status Updates & Message Integration

**Chat Message for Counter Offers:**
When counter offer is sent, create a chat message with:
- `is_custom_offer` = counter_offer_id
- Message text: "Counter offer sent" / "Counter offer received"
- Visual distinction from regular offers

---

## Implementation Order

1. **Database Migration** - Add counter offer fields
2. **Model Updates** - CustomOffer relationships
3. **Backend Routes & Controller** - Counter offer endpoints
4. **Buyer UI** - Counter button + modal
5. **Buyer JS** - Counter offer logic
6. **Seller UI** - Counter offer view/actions
7. **Seller JS** - Counter offer handling
8. **Email Notifications** - All counter notifications
9. **Testing** - Full flow testing

---

## Counter Offer Flow Diagram

```
Seller sends offer
       ↓
Buyer sees offer in messages
       ↓
Buyer clicks "View Custom Offer"
       ↓
Offer Detail Modal shows:
┌─────────────────────────────────────────┐
│  [Close] [Reject] [Counter] [Accept]    │
└─────────────────────────────────────────┘
       ↓ (clicks Counter)
Counter Offer Modal:
┌─────────────────────────────────────────┐
│  Original: $500                         │
│  Your Counter: $400                     │
│  Message: "Can we do $400?"             │
│  [Cancel] [Send Counter Offer]          │
└─────────────────────────────────────────┘
       ↓ (submits)
Seller receives counter in chat
       ↓
Seller views counter offer:
┌─────────────────────────────────────────┐
│  Original: $500                         │
│  Buyer Counter: $400                    │
│  [Reject] [Accept Counter] [New Offer]  │
└─────────────────────────────────────────┘
       ↓
Accept → Payment flow for buyer at $400
Reject → Notify buyer, offer remains open
New Offer → Seller creates new offer
```

---

## Files to Create/Modify

### New Files
| File | Purpose |
|------|---------|
| `database/migrations/YYYY_MM_DD_add_counter_offer_fields.php` | Counter offer schema |
| `app/Mail/CustomOfferCounterReceived.php` | Email to seller |
| `app/Mail/CustomOfferCounterAccepted.php` | Email to buyer |
| `app/Mail/CustomOfferCounterRejected.php` | Email to buyer |

### Files to Modify
| File | Changes |
|------|---------|
| `app/Models/CustomOffer.php` | Add relationships + helpers |
| `routes/web.php` | Add counter offer routes |
| `app/Http/Controllers/MessagesController.php` | Add counter methods |
| `resources/views/components/custom-offer-modals.blade.php` | Add counter button + modal |
| `public/assets/user/js/custom-offers-buyer.js` | Add counter functions |
| `resources/views/Teacher-Dashboard/chat.blade.php` | Add seller counter view |
| `public/assets/teacher/js/custom-offers.js` | Add seller counter functions |

---

## Estimated Complexity

| Phase | Complexity | Notes |
|-------|------------|-------|
| Phase 1: Database | Low | Simple migration |
| Phase 2: Backend | Medium | 3 new controller methods |
| Phase 3: Buyer UI | Medium | New modal + button |
| Phase 4: Buyer JS | Medium | AJAX + form handling |
| Phase 5: Seller UI | Medium | New modal + display |
| Phase 6: Email | Low | Similar to existing emails |
| Phase 7: Integration | Medium | Chat message updates |

---

## Notes

1. Counter offers should preserve the original offer structure (milestones, service mode, etc.)
2. Only pending offers can receive counter offers
3. A counter offer essentially creates a new offer linked to the original
4. Negotiation can go back and forth multiple times
5. Either party can accept/reject at any point
6. Once accepted, proceed to payment flow
