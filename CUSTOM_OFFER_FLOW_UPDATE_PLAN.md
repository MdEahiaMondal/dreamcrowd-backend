# Custom Offer Flow Update Plan

## Overview

This document outlines the changes required to update the Custom Offer feature flow according to the client's requirements specified in `custom_offer.md`. The current implementation has the flow steps in a different order than what the client requires.

---

## Current Implementation vs Required Flow

### Current Flow (Incorrect Order)
```
Step 1: Select Offer Type (Class or Freelance)
           ↓
Step 2: Load & Select Service (all services of that type)
           ↓
Step 3: Select Service Mode (Online or In-Person)
           ↓
Step 4: Select Payment Type (Single or Milestone)
           ↓
Step 5: Fill Details & Send Offer
```

### Required Flow (Per Client Requirements)
```
Step 1: Select Offer Type (Class Booking or Freelance Service)
           ↓
Step 2: Select Delivery Mode (Online or In-Person)
           ↓
Step 3: Load & Select Service (filtered by BOTH type AND mode)
           ↓
Step 4: Select Payment Type (Single or Milestone)
           ↓
Step 5: Fill Details & Send Offer
```

---

## Key Differences

| Aspect | Current | Required |
|--------|---------|----------|
| **Service Loading** | After selecting offer type only | After selecting BOTH offer type AND delivery mode |
| **Filter Criteria** | Only `service_role` (Class/Freelance) | Both `service_role` AND `service_type` (Online/Inperson) |
| **Modal Order** | myModal → secondModal/thirdModal → servicemode-modal → fourmodal | myModal → servicemode-modal → secondModal/thirdModal → fourmodal |
| **Service Mode Position** | Step 3 (after service selection) | Step 2 (before service selection) |

---

## Database Fields Reference

### TeacherGig Table Fields
- `service_role`: 'Class' or 'Freelance' (maps to Offer Type)
- `service_type`: 'Online', 'Inperson', or 'Both' (maps to Delivery Mode)
- `lesson_type`: Additional online/inperson indicator for classes
- `class_type`: 'Live' or 'Recorded'

### CustomOffer Table Fields (Already Correct)
- `offer_type`: 'Class' or 'Freelance'
- `service_mode`: 'Online' or 'In-person'
- `payment_type`: 'Single' or 'Milestone'

---

## Files to Modify

### 1. Frontend View (Teacher Dashboard)
**File:** `resources/views/Teacher-Dashboard/messages.blade.php`

**Changes Required:**
- Reorder modal sequence:
  - `myModal` (Step 1: Offer Type) → Goes to `servicemode-modal`
  - `servicemode-modal` (Step 2: Delivery Mode) → Goes to `secondModal` or `thirdModal`
  - `secondModal` / `thirdModal` (Step 3: Service Selection) → Goes to `fourmodal`
  - `fourmodal` (Step 4: Payment Type) → Goes to `fiveModal` or `sixModal`
  - `fiveModal` / `sixModal` (Step 5: Details) → Send Offer

**Specific Modal Updates:**

#### myModal (Offer Type Selection)
```html
<!-- BEFORE: Radio buttons go directly to secondModal/thirdModal -->
<input type="radio" id="offerTypeClass" name="offer_type" value="Class"
       data-bs-toggle="modal" data-bs-target="#secondModal" data-bs-dismiss="modal">
<input type="radio" id="offerTypeFreelance" name="offer_type" value="Freelance"
       data-bs-toggle="modal" data-bs-target="#thirdModal" data-bs-dismiss="modal">

<!-- AFTER: Radio buttons go to servicemode-modal first -->
<input type="radio" id="offerTypeClass" name="offer_type" value="Class"
       data-bs-toggle="modal" data-bs-target="#servicemode-modal" data-bs-dismiss="modal">
<input type="radio" id="offerTypeFreelance" name="offer_type" value="Freelance"
       data-bs-toggle="modal" data-bs-target="#servicemode-modal" data-bs-dismiss="modal">
```

#### servicemode-modal (Delivery Mode Selection)
```html
<!-- BEFORE: Goes to fourmodal (payment type) -->
<input type="radio" id="serviceModeOnline" name="service_mode" value="Online"
       data-bs-toggle="modal" data-bs-target="#fourmodal" data-bs-dismiss="modal">

<!-- AFTER: Goes to service selection modal based on offer_type -->
<!-- This will be handled by JavaScript to determine secondModal or thirdModal -->
<input type="radio" id="serviceModeOnline" name="service_mode" value="Online">
<input type="radio" id="serviceModeInPerson" name="service_mode" value="In-person">
<!-- Next button triggers JavaScript to navigate to correct service modal -->
```

#### servicemode-modal Back Button
```html
<!-- BEFORE: Goes back to secondModal -->
<button class="back-btn" data-bs-target="#secondModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>

<!-- AFTER: Goes back to myModal -->
<button class="back-btn" data-bs-target="#myModal" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>
```

#### secondModal / thirdModal (Service Selection)
```html
<!-- BEFORE: Back goes to myModal -->
<i class="fa-solid fa-arrow-left" data-bs-target="#myModal" data-bs-toggle="modal" data-bs-dismiss="modal">

<!-- AFTER: Back goes to servicemode-modal -->
<i class="fa-solid fa-arrow-left" data-bs-target="#servicemode-modal" data-bs-toggle="modal" data-bs-dismiss="modal">
```

#### fourmodal (Payment Type Selection)
```html
<!-- BEFORE: Back goes to servicemode-modal -->
<button class="back-btn" data-bs-target="#servicemode-modal" data-bs-toggle="modal" data-bs-dismiss="modal">Back</button>

<!-- AFTER: Back goes to appropriate service modal -->
<!-- This will be handled by JavaScript based on offer_type -->
```

---

### 2. JavaScript File
**File:** `public/assets/teacher/js/custom-offers.js`

**Changes Required:**

#### A. Update Service Loading Logic
```javascript
// BEFORE: Load services only by offer type
$('#secondModal').on('show.bs.modal', function() {
    loadSellerServices('Class');
});

// AFTER: Load services by BOTH offer type AND service mode
$('#secondModal').on('show.bs.modal', function() {
    loadSellerServices(offerState.offer_type, offerState.service_mode);
});
```

#### B. Update loadSellerServices Function
```javascript
// BEFORE: Only sends offer_type
function loadSellerServices(offerType) {
    $.ajax({
        url: '/get-services-for-custom',
        type: 'POST',
        data: {
            offer_type: offerType,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        // ...
    });
}

// AFTER: Send both offer_type AND service_mode
function loadSellerServices(offerType, serviceMode) {
    $.ajax({
        url: '/get-services-for-custom',
        type: 'POST',
        data: {
            offer_type: offerType,
            service_mode: serviceMode,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        // ...
    });
}
```

#### C. Add Service Mode Selection Handler
```javascript
// Add handler for service mode selection to set state before loading services
$('input[name="service_mode"]').on('change', function() {
    offerState.service_mode = $(this).val();
});

// Handle Next button in servicemode-modal to navigate to correct service modal
$('#servicemode-modal .next-btn').on('click', function() {
    const targetModal = offerState.offer_type === 'Class' ? '#secondModal' : '#thirdModal';
    $('#servicemode-modal').modal('hide');
    $(targetModal).modal('show');
});
```

#### D. Update Modal Navigation After Service Selection
```javascript
// After selecting a service, navigate to payment type (fourmodal)
// Already correct - service items have data-bs-target="#fourmodal"
```

#### E. Update Back Navigation in fourmodal
```javascript
// Need JavaScript handler to go back to correct service modal
$('#fourmodal .back-btn').on('click', function(e) {
    e.preventDefault();
    const targetModal = offerState.offer_type === 'Class' ? '#secondModal' : '#thirdModal';
    $('#fourmodal').modal('hide');
    $(targetModal).modal('show');
});
```

---

### 3. Backend Controller
**File:** `app/Http/Controllers/MessagesController.php`

**Function:** `GetServicesForCustom` (Line ~2362)

**Changes Required:**
```php
// BEFORE: Only filters by service_role
public function GetServicesForCustom(Request $request)
{
    $services = DB::table('teacher_gigs')
        ->join('teacher_gig_data', 'teacher_gigs.id', '=', 'teacher_gig_data.gig_id')
        ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
        ->where('teacher_gigs.user_id', Auth::id())
        ->where('teacher_gigs.service_role', $request->offer_type)
        ->where('teacher_gigs.status', 1)
        ->select('teacher_gigs.*', 'teacher_gig_data.*', 'teacher_gig_payments.*')
        ->get();

    return response()->json(['services' => $services]);
}

// AFTER: Filters by BOTH service_role AND service_type
public function GetServicesForCustom(Request $request)
{
    $query = DB::table('teacher_gigs')
        ->join('teacher_gig_data', 'teacher_gigs.id', '=', 'teacher_gig_data.gig_id')
        ->join('teacher_gig_payments', 'teacher_gigs.id', '=', 'teacher_gig_payments.gig_id')
        ->where('teacher_gigs.user_id', Auth::id())
        ->where('teacher_gigs.service_role', $request->offer_type)
        ->where('teacher_gigs.status', 1);

    // Filter by service_mode if provided
    if ($request->has('service_mode') && $request->service_mode) {
        $serviceMode = $request->service_mode === 'In-person' ? 'Inperson' : $request->service_mode;

        // Match services that are exactly this type OR 'Both'
        $query->where(function($q) use ($serviceMode) {
            $q->where('teacher_gigs.service_type', $serviceMode)
              ->orWhere('teacher_gigs.service_type', 'Both');
        });
    }

    $services = $query->select('teacher_gigs.*', 'teacher_gig_data.*', 'teacher_gig_payments.*')
        ->get();

    return response()->json(['services' => $services]);
}
```

---

## Visual Flow Diagram (Updated)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          CUSTOM OFFER WIZARD FLOW                          │
└─────────────────────────────────────────────────────────────────────────────┘

┌─────────────────┐
│   Start Chat    │
│  (Seller Side)  │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ Click "Custom   │
│   Offer" Btn    │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 1: myModal - Select Offer Type                                       │
│  ┌─────────────────────┐     ┌─────────────────────┐                        │
│  │  ○ Class Booking    │     │  ○ Freelance Service │                       │
│  └─────────────────────┘     └─────────────────────┘                        │
│                         [Next →]                                            │
└─────────────────────────────────────────────────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 2: servicemode-modal - Select Delivery Mode                          │
│  ┌─────────────────────┐     ┌─────────────────────┐                        │
│  │  ○ Online           │     │  ○ In-Person        │                       │
│  └─────────────────────┘     └─────────────────────┘                        │
│                    [← Back]  [Next →]                                       │
└─────────────────────────────────────────────────────────────────────────────┘
         │
         ├──────────────────────────────────┐
         │ If Class                         │ If Freelance
         ▼                                  ▼
┌─────────────────────┐           ┌─────────────────────┐
│  STEP 3: secondModal│           │  STEP 3: thirdModal │
│  Select Class       │           │  Select Freelance   │
│  Service (Filtered  │           │  Service (Filtered  │
│  by Online/InPerson)│           │  by Online/InPerson)│
│                     │           │                     │
│  ┌─────────────┐    │           │  ┌─────────────┐    │
│  │ Service 1   │    │           │  │ Service 1   │    │
│  ├─────────────┤    │           │  ├─────────────┤    │
│  │ Service 2   │    │           │  │ Service 2   │    │
│  └─────────────┘    │           │  └─────────────┘    │
│       [← Back]      │           │       [← Back]      │
└──────────┬──────────┘           └──────────┬──────────┘
           │                                  │
           └──────────────────┬───────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  STEP 4: fourmodal - Select Payment Type                                   │
│  ┌─────────────────────┐     ┌─────────────────────┐                        │
│  │  ○ Single Payment   │     │  ○ Milestone        │                       │
│  │  (One-time payment) │     │  (Multiple payments)│                       │
│  └─────────────────────┘     └─────────────────────┘                        │
│                    [← Back]  [Next →]                                       │
└─────────────────────────────────────────────────────────────────────────────┘
         │
         ├──────────────────────────────────┐
         │ If Single                        │ If Milestone
         ▼                                  ▼
┌─────────────────────┐           ┌─────────────────────┐
│  STEP 5: sixModal   │           │  STEP 5: fiveModal  │
│  Single Payment     │           │  Milestone Payment  │
│  Details            │           │  Details            │
│                     │           │                     │
│  • Description      │           │  • Description      │
│  • Revisions*       │           │  • Add Milestones   │
│  • Delivery Days*   │           │    - Title          │
│  • Price            │           │    - Price          │
│  • Date/Time**      │           │    - Revisions*     │
│                     │           │    - Delivery Days* │
│  * Freelance only   │           │    - Date/Time**    │
│  ** In-Person only  │           │                     │
│                     │           │  * Freelance only   │
│  ☐ Offer Expire     │           │  ** In-Person only  │
│  ☐ Request Req.     │           │                     │
│                     │           │  ☐ Offer Expire     │
│  [← Back] [Send →]  │           │  ☐ Request Req.     │
│                     │           │                     │
│                     │           │  [← Back] [Send →]  │
└─────────────────────┘           └─────────────────────┘
         │                                  │
         └──────────────────┬───────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│  OFFER SENT                                                                 │
│  • Saved to custom_offers table                                             │
│  • Buyer notified via message                                               │
│  • Email sent to buyer                                                      │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## Implementation Checklist

### Phase 1: Modal Reordering (View Changes) - COMPLETED
- [x] Update `myModal` - Change radio button targets to `#servicemode-modal`
- [x] Update `servicemode-modal` - Change back button target to `#myModal`
- [x] Update `servicemode-modal` - Remove direct modal targets from radio buttons
- [x] Update `secondModal` - Change back button target to `#servicemode-modal`
- [x] Update `thirdModal` - Change back button target to `#servicemode-modal`
- [x] Update `fourmodal` - Remove hardcoded back button (will be handled by JS)
- [x] Update `fiveModal` / `sixModal` - Verify back button targets

### Phase 2: JavaScript Updates - COMPLETED
- [x] Add state tracking for service_mode before service selection
- [x] Update `loadSellerServices()` to accept both offerType and serviceMode
- [x] Add AJAX parameter for service_mode
- [x] Add click handler for servicemode-modal Next button
- [x] Add dynamic navigation to correct service modal based on offer_type
- [x] Add dynamic back navigation in fourmodal
- [x] Update service item click handlers to go to fourmodal
- [x] Ensure state is properly reset when wizard is closed

### Phase 3: Backend Updates - COMPLETED
- [x] Update `GetServicesForCustom` method in MessagesController
- [x] Add service_mode filtering to the query
- [x] Handle 'Both' service_type to include in results
- [x] Handle 'In-person' vs 'Inperson' naming inconsistency

### Phase 4: Testing - PENDING
- [ ] Test Class + Online flow
- [ ] Test Class + In-Person flow
- [ ] Test Freelance + Online flow
- [ ] Test Freelance + In-Person flow
- [ ] Test Single Payment for each combination
- [ ] Test Milestone Payment for each combination
- [ ] Verify proper service filtering
- [ ] Verify date/time fields show only for In-Person
- [ ] Verify revisions/delivery fields show only for Freelance
- [ ] Test back navigation through all steps
- [ ] Test offer submission and buyer notification

---

## Notes

### Naming Consistency Issue
The codebase has inconsistent naming:
- Database uses: `Inperson` (one word)
- CustomOffer model uses: `In-person` (hyphenated)
- Frontend displays: `In-Person` (title case with hyphen)

The backend filtering logic should handle this by mapping `In-person` → `Inperson` when querying the database.

### Services with 'Both' Service Type
When a service has `service_type = 'Both'`, it should appear in BOTH Online and In-Person service lists. The query uses:
```php
$q->where('service_type', $serviceMode)->orWhere('service_type', 'Both');
```

### Empty Service Lists
If no services match the selected combination (e.g., seller has no Online Class services), the modal should display a user-friendly message instead of being empty.

### Reference Implementation
The services.blade.php file at `resources/views/Public-site/services.blade.php` contains a reference implementation of filtering services by type and mode (see line 798-1100) that can be used as guidance.

---

## Estimated Impact

| Category | Count |
|----------|-------|
| Files Modified | 3 |
| Views Changed | 1 (messages.blade.php) |
| JavaScript Files | 1 (custom-offers.js) |
| Controllers | 1 (MessagesController.php) |
| New Routes | 0 |
| Database Changes | 0 |
| Breaking Changes | 0 |

---

## Summary

The main change is reordering the wizard steps so that sellers select the **Delivery Mode (Online/In-Person)** BEFORE seeing the service list. This allows the service list to be filtered by both:
1. **Offer Type** (Class or Freelance)
2. **Delivery Mode** (Online or In-Person)

This matches the client's requirement:
> "when creating a custom offer, the seller can select either 'class booking' or 'freelance booking' … then it will ask online or in-person … then it will show the active classes or services accordingly."
