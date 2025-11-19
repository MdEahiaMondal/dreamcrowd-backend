# Order Status Lifecycle Documentation
# অর্ডার স্ট্যাটাস লাইফসাইকেল ডকুমেন্টেশন

**Date:** November 19, 2025
**Project:** DreamCrowd Marketplace Platform

---

## 📋 Table of Contents

1. [Order Status Values (অর্ডার স্ট্যাটাস ভ্যালু)](#order-status-values)
2. [Initial Order Creation (প্রথম অর্ডার তৈরি)](#initial-order-creation)
3. [Complete Status Flow Diagram](#complete-status-flow-diagram)
4. [Status Change Locations (স্ট্যাটাস চেঞ্জের লোকেশন)](#status-change-locations)
5. [Automated Scheduled Commands](#automated-scheduled-commands)
6. [Related Status Fields](#related-status-fields)
7. [Dispute Process (ডিসপিউট প্রসেস)](#dispute-process)
8. [Refund Logic (রিফান্ড লজিক)](#refund-logic)
9. [Quick Reference Table](#quick-reference-table)

---

## Order Status Values
## অর্ডার স্ট্যাটাস ভ্যালু

The `book_orders` table uses numeric status values:

| Status Code | Status Name | Bengali | Description |
|-------------|-------------|---------|-------------|
| **0** | **Pending** | **পেন্ডিং** | Order placed, awaiting seller acceptance |
| **1** | **Active** | **অ্যাক্টিভ** | Order accepted by seller, service in progress |
| **2** | **Delivered** | **ডেলিভারড** | Service completed, 48-hour dispute window active |
| **3** | **Completed** | **সম্পন্ন** | Order finalized, ready for seller payout |
| **4** | **Cancelled** | **বাতিল** | Order cancelled (with or without refund) |

### Additional Related Status Fields

**Payment Status (`payment_status` field):**
- `pending` - Payment authorized but not captured
- `completed` - Payment captured successfully
- `refunded` - Full or partial refund processed
- `failed` - Payment failed

**Dispute Status (`dispute_orders` table):**
- `0` = Pending (ডিসপিউট পেন্ডিং)
- `1` = Resolved (ডিসপিউট সমাধান হয়েছে)

**Reschedule Status (`class_reschedules` table):**
- `0` = Pending (রিশিডিউল পেন্ডিং)
- `1` = Approved (রিশিডিউল অনুমোদিত)
- `2` = Cancelled (রিশিডিউল বাতিল)

---

## Initial Order Creation
## প্রথম অর্ডার তৈরি

### When a Buyer Places an Order (যখন বায়ার অর্ডার করে)

**Location:** `app/Http/Controllers/BookingController.php`
**Method:** `ServicePayment()`
**Lines:** ~563, ~653

#### For Free Trial Classes:
```
status = 1 (Active - immediately)
payment_status = 'completed'
No Stripe payment created
All amounts = $0
```

#### For Paid Orders:
```
status = 0 (Pending - awaiting seller acceptance)
payment_status = 'pending'
Stripe PaymentIntent created
Payment authorized but NOT captured yet
```

**Key Point:** পেইড অর্ডারে সেলার অ্যাক্সেপ্ট না করা পর্যন্ত পেমেন্ট ক্যাপচার হয় না।

---

## Complete Status Flow Diagram
## সম্পূর্ণ স্ট্যাটাস ফ্লো ডায়াগ্রাম

```
┌─────────────────────────────────────────────────────────────────┐
│                    BUYER CREATES ORDER                          │
│                    বায়ার অর্ডার করে                            │
│                                                                 │
│  Free Trial → status = 1 (Active)                              │
│  Paid Order → status = 0 (Pending)                             │
│                                                                 │
│  📍 Location: BookingController::ServicePayment()              │
└───────────────────────────┬─────────────────────────────────────┘
                            │
        ┌───────────────────┴────────────────────┐
        │                                        │
        ▼                                        ▼
┌──────────────────────┐              ┌──────────────────────┐
│   AUTO-CANCEL        │              │   SELLER ACCEPTS     │
│   অটো বাতিল          │              │   সেলার অ্যাক্সেপ্ট  │
│                      │              │                      │
│   Status: 0 → 4      │              │   Status: 0 → 1      │
│                      │              │                      │
│   ⏰ Trigger:         │              │   👤 Trigger:         │
│   • 30 min before    │              │   • Seller clicks    │
│     class starts     │              │     "Accept Order"   │
│   • Class started    │              │                      │
│                      │              │   📍 Location:        │
│   🤖 Command:         │              │   OrderManagement    │
│   AutoCancelPending  │              │   Controller::       │
│   Orders             │              │   ActiveOrder()      │
│   (Every 5 min)      │              │                      │
│                      │              │   💰 Actions:         │
│   💸 Refund: Full    │              │   • Capture Stripe   │
│   (Cancel payment)   │              │     payment          │
│                      │              │   • Apply reschedule │
│   📍 File:            │              │   • payment_status   │
│   AutoCancelPending  │              │     = 'completed'    │
│   Orders.php         │              │                      │
└──────────────────────┘              └──────┬───────────────┘
                                             │
                    ┌────────────────────────┼─────────────────┐
                    │                        │                 │
                    ▼                        ▼                 ▼
         ┌─────────────────┐    ┌────────────────────┐  ┌──────────────┐
         │ MANUAL CANCEL   │    │  AUTO-DELIVERED    │  │ MANUAL MARK  │
         │ ম্যানুয়াল বাতিল │    │  অটো ডেলিভারড     │  │ DELIVERED    │
         │                 │    │                    │  │              │
         │ Status: 1/0 → 4 │    │  Status: 1 → 2     │  │ Status: 1→2  │
         │                 │    │                    │  │              │
         │ 👤 Trigger:      │    │  ⏰ Trigger:        │  │ 👤 Trigger:   │
         │ • Buyer/Seller  │    │  • OneOff: Last    │  │ • Teacher    │
         │   cancels       │    │    class ends      │  │   clicks     │
         │                 │    │  • Subscription:   │  │   "Deliver"  │
         │ 📍 Location:     │    │    1 month after   │  │              │
         │ OrderMgmt       │    │    creation        │  │ 📍 Location:  │
         │ Controller::    │    │                    │  │ OrderMgmt    │
         │ CancelOrder()   │    │  🤖 Command:        │  │ Controller:: │
         │                 │    │  AutoMarkDelivered │  │ DeliverOrder │
         │ 💸 Refund:       │    │  (Hourly)          │  │              │
         │ • Pending: Full │    │                    │  │              │
         │ • Active: Pro-  │    │  📍 File:           │  │              │
         │   rated based   │    │  AutoMarkDeliv     │  │              │
         │   on classes    │    │  ered.php          │  │              │
         │                 │    │                    │  │              │
         │ 📍 File:         │    │  📅 action_date     │  │              │
         │ OrderMgmt       │    │  = now()           │  │              │
         │ Controller.php  │    │                    │  │              │
         └─────────────────┘    └────────┬───────────┘  └──────┬───────┘
                                         │                     │
                                         └──────────┬──────────┘
                                                    │
                                                    ▼
                                    ┌───────────────────────────┐
                                    │    DELIVERED STATUS       │
                                    │    ডেলিভারড স্ট্যাটাস     │
                                    │    (Status = 2)           │
                                    │                           │
                                    │  ⏰ 48-Hour Dispute Window │
                                    │  (ডিসপিউট সময়সীমা)        │
                                    └────┬───────────────┬──────┘
                                         │               │
                    ┌────────────────────┘               └──────────────┐
                    │                                                   │
                    ▼                                                   ▼
         ┌──────────────────────┐                          ┌────────────────────┐
         │  BUYER FILES DISPUTE │                          │  NO DISPUTE        │
         │  বায়ার ডিসপিউট করে   │                          │  কোন ডিসপিউট নেই   │
         │                      │                          │                    │
         │  Status: 2 → 4       │                          │  Status: 2 → 3     │
         │                      │                          │                    │
         │  👤 Trigger:          │                          │  ⏰ Trigger:        │
         │  • Buyer clicks      │                          │  • 48 hours pass   │
         │    "Dispute"         │                          │    without dispute │
         │    within 48h        │                          │                    │
         │                      │                          │  🤖 Command:        │
         │  📍 Location:         │                          │  AutoMarkCompleted │
         │  OrderMgmt           │                          │  (Every 6 hours)   │
         │  Controller::        │                          │                    │
         │  DisputeOrder()      │                          │  📍 File:           │
         │                      │                          │  AutoMarkComp      │
         │  🚩 Actions:          │                          │  leted.php         │
         │  • user_dispute = 1  │                          │                    │
         │  • Creates Dispute   │                          │  💰 Actions:        │
         │    Order record      │                          │  • Order ready for │
         │  • 48h window for    │                          │    seller payout   │
         │    seller response   │                          │  • Transaction     │
         │                      │                          │    finalized       │
         │  📍 File:             │                          │  • Review request  │
         │  OrderMgmt           │                          │    sent to buyer   │
         │  Controller.php      │                          │                    │
         └──────┬───────────────┘                          └────────────────────┘
                │                                                      │
                │                                                      │
                ├──────────────────────┬─────────────────┐            │
                │                      │                 │            │
                ▼                      ▼                 ▼            │
    ┌──────────────────┐  ┌───────────────────┐  ┌──────────────┐   │
    │ SELLER ACCEPTS   │  │ SELLER DISPUTES   │  │ 48 HRS PASS  │   │
    │ REFUND           │  │ (Admin Review)    │  │ AUTO-REFUND  │   │
    │ সেলার রিফান্ড     │  │ সেলার ডিসপিউট    │  │ অটো রিফান্ড  │   │
    │ অ্যাক্সেপ্ট করে   │  │ করে (অ্যাডমিন     │  │              │   │
    │                  │  │ রিভিউ প্রয়োজন)    │  │              │   │
    │ 👤 Trigger:       │  │                   │  │ ⏰ Trigger:   │   │
    │ • Seller clicks  │  │ 👤 Trigger:        │  │ • 48+ hours  │   │
    │   "Accept        │  │ • Seller clicks   │  │   since      │   │
    │   Refund"        │  │   "Dispute"       │  │   buyer      │   │
    │                  │  │                   │  │   dispute    │   │
    │ 📍 Location:      │  │ 📍 Location:       │  │ • Seller     │   │
    │ OrderMgmt        │  │ OrderMgmt         │  │   didn't     │   │
    │ Controller::     │  │ Controller::      │  │   respond    │   │
    │ AcceptDisputed   │  │ DisputeOrder()    │  │              │   │
    │ Order()          │  │                   │  │ 🤖 Command:   │   │
    │                  │  │ 🚩 Actions:        │  │ AutoHandle   │   │
    │ 💸 Actions:       │  │ • teacher_        │  │ Disputes     │   │
    │ • Process        │  │   dispute = 1     │  │ (Daily 3AM)  │   │
    │   refund via     │  │ • Both parties    │  │              │   │
    │   Stripe         │  │   disputed        │  │ 📍 File:      │   │
    │ • payment_       │  │ • Manual admin    │  │ AutoHandle   │   │
    │   status =       │  │   resolution      │  │ Disputes.php │   │
    │   'refunded'     │  │   needed          │  │              │   │
    │ • dispute.       │  │                   │  │ 💸 Actions:   │   │
    │   status = 1     │  │ 📍 File:           │  │ • Full/      │   │
    │                  │  │ OrderMgmt         │  │   partial    │   │
    │ 📍 File:          │  │ Controller.php    │  │   refund     │   │
    │ OrderMgmt        │  │                   │  │ • dispute.   │   │
    │ Controller.php   │  │                   │  │   status = 1 │   │
    └──────────────────┘  └───────────────────┘  └──────────────┘   │
                                                                     │
                                                                     ▼
                                                          ┌──────────────────┐
                                                          │   ✅ COMPLETED    │
                                                          │   সম্পন্ন         │
                                                          │                  │
                                                          │  Status = 3      │
                                                          │                  │
                                                          │  💰 Ready for     │
                                                          │  payout          │
                                                          └──────────────────┘
```

---

## Status Change Locations
## স্ট্যাটাস চেঞ্জের লোকেশন

### 1. Order Creation (অর্ডার তৈরি)

**Status:** N/A → 0 (Pending) or N/A → 1 (Active for free trial)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/BookingController.php` |
| **Method** | `ServicePayment()` |
| **Lines** | ~563, ~653 |
| **Type** | Manual (User Action) |
| **Trigger** | User completes booking and payment |
| **Actions** | • Create BookOrder record<br>• Create Transaction record<br>• Create Stripe PaymentIntent (paid orders)<br>• Send notifications |

---

### 2. Seller Accepts Order (সেলার অর্ডার অ্যাক্সেপ্ট করে)

**Status:** 0 → 1 (Pending → Active)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Method** | `ActiveOrder($id)` |
| **Line** | ~1201 |
| **Type** | Manual (Seller Action) |
| **Trigger** | Seller clicks "Accept Order" button |
| **Actions** | • **Capture Stripe payment** (payment_status = 'completed')<br>• Apply pending reschedules (if any)<br>• Update transaction status to 'completed'<br>• Send notification to buyer<br>• Update order status to 1 (Active) |

---

### 3. Auto-Cancel Pending Orders (অটো পেন্ডিং অর্ডার বাতিল)

**Status:** 0 → 4 (Pending → Cancelled)

| Detail | Value |
|--------|-------|
| **File** | `/app/Console/Commands/AutoCancelPendingOrders.php` |
| **Method** | `handle()` |
| **Type** | **Automated (Scheduled Command)** |
| **Schedule** | **Every 5 minutes** (registered in `Kernel.php` - line ~15) |
| **Trigger** | • Class starts in ≤30 minutes OR<br>• Class has already started |
| **Actions** | • Cancel Stripe PaymentIntent (full refund)<br>• status = 4<br>• payment_status = 'refunded'<br>• refund = 1<br>• Create CancelOrder record<br>• Cancel pending reschedules (status → 2)<br>• Update transaction to 'refunded'<br>• Send notifications to buyer, seller, admin |

**Log File:** `storage/logs/auto-cancel.log`

---

### 4. Manual Cancellation (ম্যানুয়াল বাতিল)

**Status:** 0/1 → 4 (Pending/Active → Cancelled)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Method** | `CancelOrder(Request $request)` |
| **Lines** | ~1233-1620 |
| **Type** | Manual (Buyer or Seller Action) |
| **Trigger** | User clicks "Cancel Order" button |
| **Refund Logic** | **Pending Orders (status = 0):**<br>• Full refund via payment cancellation<br><br>**Active Orders (status = 1):**<br>• **Teacher-initiated:** Full or partial refund<br>• **Buyer-initiated:** Pro-rated refund based on:<br>&nbsp;&nbsp;- Classes >12 hours away: Refundable<br>&nbsp;&nbsp;- Classes <12 hours or passed: Non-refundable |
| **Actions** | • status = 4<br>• payment_status = 'refunded'<br>• refund = 1 (if applicable)<br>• Create CancelOrder record<br>• Process Stripe refund<br>• Update transaction<br>• Send notifications |

---

### 5. Auto-Mark Delivered (অটো ডেলিভারড মার্ক)

**Status:** 1 → 2 (Active → Delivered)

| Detail | Value |
|--------|-------|
| **File** | `/app/Console/Commands/AutoMarkDelivered.php` |
| **Method** | `handle()` |
| **Type** | **Automated (Scheduled Command)** |
| **Schedule** | **Hourly** (registered in `Kernel.php` - line ~22) |
| **Trigger** | **OneOff Service:**<br>• Last class date from `class_dates` table passes<br><br>**Subscription Service:**<br>• 1 month after order creation |
| **Actions** | • status = 2<br>• action_date = now()<br>• Cancel pending reschedules (status → 2)<br>• Update transaction notes<br>• Send delivery notification to buyer<br>• Start 48-hour dispute window |

**Log File:** `storage/logs/auto-deliver.log`

---

### 6. Manual Mark Delivered (ম্যানুয়াল ডেলিভারড মার্ক)

**Status:** 1 → 2 (Active → Delivered)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Methods** | • `DeliverOrder($id)` (line ~1620)<br>• `FreelanceOrderDeliver(Request $request)` (line ~1930) |
| **Type** | Manual (Teacher Action) |
| **Trigger** | Teacher clicks "Mark as Delivered" |
| **Actions** | • status = 2<br>• action_date = current date<br>• Cancel pending reschedules (status → 2)<br>• For freelance: Upload delivery file<br>• Send notification to buyer<br>• Start 48-hour dispute window |

---

### 7. Buyer Files Dispute (বায়ার ডিসপিউট করে)

**Status:** 2 → 4 (Delivered → Cancelled)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Method** | `DisputeOrder(Request $request)` |
| **Line** | ~1667 |
| **Type** | Manual (Buyer Action) |
| **Trigger** | Buyer files dispute **within 48 hours** of delivery |
| **Actions** | • status = 4<br>• user_dispute = 1<br>• Create DisputeOrder record (status = 0)<br>• Transaction status → 'refunded'<br>• Start 48-hour seller response window<br>• Send notification to seller |

**Important:** সেলারের কাছে ৪৮ ঘন্টা সময় থাকে রিফান্ড অ্যাক্সেপ্ট বা ডিসপিউট করার জন্য।

---

### 8. Seller Accepts Dispute (সেলার ডিসপিউট অ্যাক্সেপ্ট করে)

**Status:** No status change (remains 4)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Method** | `AcceptDisputedOrder($id)` |
| **Line** | ~1788 |
| **Type** | Manual (Seller Action) |
| **Trigger** | Seller clicks "Accept Refund" |
| **Actions** | • payment_status = 'refunded'<br>• refund = 1<br>• auto_dispute_processed = 0<br>• DisputeOrder status = 1 (Resolved)<br>• Process full or partial Stripe refund<br>• Update transaction commissions<br>• Send notifications |

---

### 9. Seller Counter-Disputes (সেলার ডিসপিউট করে)

**Status:** No status change (remains 4)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Method** | `DisputeOrder(Request $request)` |
| **Line** | ~1667 |
| **Type** | Manual (Seller Action) |
| **Trigger** | Seller clicks "Dispute" (within 48 hours) |
| **Actions** | • teacher_dispute = 1<br>• Both user_dispute and teacher_dispute = 1<br>• **Requires manual admin resolution**<br>• Admin must review and decide |

**Note:** যখন উভয় পক্ষ ডিসপিউট করে, তখন অ্যাডমিনকে ম্যানুয়ালি সমাধান করতে হবে।

---

### 10. Auto-Handle Disputes (অটো ডিসপিউট হ্যান্ডলিং)

**Status:** No status change (remains 4)

| Detail | Value |
|--------|-------|
| **File** | `/app/Console/Commands/AutoHandleDisputes.php` |
| **Method** | `handle()` |
| **Type** | **Automated (Scheduled Command)** |
| **Schedule** | **Daily at 3:00 AM** (registered in `Kernel.php` - line ~30) |
| **Trigger** | • Order status = 4 (Cancelled)<br>• user_dispute = 1 (buyer disputed)<br>• teacher_dispute = 0 (seller didn't respond)<br>• 48+ hours since action_date<br>• auto_dispute_processed = 0 |
| **Actions** | • auto_dispute_processed = 1<br>• refund = 1<br>• payment_status = 'refunded'<br>• DisputeOrder status = 1<br>• Process full or partial Stripe refund<br>• Update transaction<br>• Send notifications |

**Log File:** `storage/logs/disputes.log`

**Important:** যদি সেলার ৪৮ ঘন্টার মধ্যে রেসপন্স না করে, অটোমেটিক রিফান্ড প্রসেস হয়।

---

### 11. Auto-Mark Completed (অটো কমপ্লিটেড মার্ক)

**Status:** 2 → 3 (Delivered → Completed)

| Detail | Value |
|--------|-------|
| **File** | `/app/Console/Commands/AutoMarkCompleted.php` |
| **Method** | `handle()` |
| **Type** | **Automated (Scheduled Command)** |
| **Schedule** | **Every 6 hours** (registered in `Kernel.php` - line ~27) |
| **Trigger** | **48 hours** after delivery (action_date + 48 hours) |
| **Actions** | • status = 3<br>• Transaction ready for payout<br>• Update transaction notes<br>• Send completion notifications<br>• Send review request to buyer |

**Log File:** `storage/logs/auto-complete.log`

**Important:** ৪৮ ঘন্টা পরে যদি কোন ডিসপিউট না থাকে, অর্ডার অটোমেটিক কমপ্লিটেড হয়।

---

### 12. Back to Active (ব্যাক টু অ্যাক্টিভ)

**Status:** 2 → 1 (Delivered → Active)

| Detail | Value |
|--------|-------|
| **File** | `/app/Http/Controllers/OrderManagementController.php` |
| **Method** | `BackToActive($id)` |
| **Type** | Manual (Seller/Admin Action) |
| **Trigger** | Seller/Admin reverts delivered order back to active |
| **Use Case** | Service was marked delivered prematurely |
| **Actions** | • status = 1<br>• action_date = null<br>• Send notification |

---

## Automated Scheduled Commands
## অটোমেটেড শিডিউল কমান্ড

All commands are registered in `/app/Console/Kernel.php`

| Command | Schedule | Function | Status Change | Log File |
|---------|----------|----------|---------------|----------|
| `orders:auto-cancel` | **Every 5 minutes** | Cancel pending orders near class time | 0 → 4 | `auto-cancel.log` |
| `orders:auto-deliver` | **Hourly** | Mark active orders as delivered | 1 → 2 | `auto-deliver.log` |
| `orders:auto-complete` | **Every 6 hours** | Mark delivered orders as completed | 2 → 3 | `auto-complete.log` |
| `disputes:process` | **Daily at 3:00 AM** | Auto-refund uncontested disputes | Updates dispute status | `disputes.log` |

**To view scheduled tasks:**
```bash
php artisan schedule:list
```

**To run a command manually:**
```bash
php artisan orders:auto-cancel
php artisan orders:auto-deliver
php artisan orders:auto-complete
php artisan disputes:process
```

---

## Related Status Fields
## রিলেটেড স্ট্যাটাস ফিল্ড

### BookOrder Table Fields

| Field | Type | Values | Description (Bengali) |
|-------|------|--------|----------------------|
| `status` | Integer | 0,1,2,3,4 | মূল অর্ডার স্ট্যাটাস |
| `payment_status` | String | pending/completed/refunded/failed | পেমেন্ট স্ট্যাটাস |
| `user_dispute` | Integer | 0/1 | বায়ার ডিসপিউট করেছে কিনা |
| `teacher_dispute` | Integer | 0/1 | সেলার ডিসপিউট করেছে কিনা |
| `auto_dispute_processed` | Integer | 0/1 | অটো রিফান্ড প্রসেস হয়েছে কিনা |
| `refund` | Integer | 0/1 | রিফান্ড দেয়া হয়েছে কিনা |
| `teacher_reschedule` | Integer | 0/1 | সেলার রিশিডিউল রিকুয়েস্ট করেছে |
| `user_reschedule` | Integer | 0/1 | বায়ার রিশিডিউল রিকুয়েস্ট করেছে |
| `action_date` | Date | - | ডেলিভারড/ক্যানসেলড হওয়ার তারিখ |

### Transaction Table Status

| Status | Description |
|--------|-------------|
| `pending` | Order pending (status = 0) |
| `completed` | Payment captured (status = 1-2) |
| `refunded` | Order cancelled with refund (status = 4) |

---

## Dispute Process
## ডিসপিউট প্রসেস

### Timeline (টাইমলাইন)

```
Order Delivered (status = 2)
    │
    ├─── Within 48 hours ───┐
    │                       │
    │                       ▼
    │              Buyer Files Dispute
    │              (user_dispute = 1)
    │              status → 4
    │                       │
    │                       ├─── Seller has 48 hours ───┐
    │                       │                           │
    │                       │                           ▼
    │                       │               ┌───────────────────────┐
    │                       │               │ Option 1: Accept      │
    │                       │               │ (Full/partial refund) │
    │                       │               └───────────────────────┘
    │                       │                           │
    │                       │                           ▼
    │                       │               ┌───────────────────────┐
    │                       │               │ Option 2: Counter-    │
    │                       │               │ Dispute (Admin review)│
    │                       │               └───────────────────────┘
    │                       │                           │
    │                       │                           ▼
    │                       │               ┌───────────────────────┐
    │                       │               │ Option 3: No Response │
    │                       │               │ (Auto-refund after    │
    │                       │               │  48 hours)            │
    │                       │               └───────────────────────┘
    │                       │
    ├─── After 48 hours ────┤
    │                       │
    ▼                       ▼
No Dispute              (Dispute process continues)
Auto-Complete
status → 3
```

### Dispute Types

**1. Full Refund (সম্পূর্ণ রিফান্ড):**
- Service not delivered as promised
- Major quality issues

**2. Partial Refund (আংশিক রিফান্ড):**
- Service partially completed
- Minor quality issues
- Calculated based on completed vs total classes

**3. No Refund (কোন রিফান্ড নেই):**
- Admin decides in seller's favor
- Service delivered as promised

---

## Refund Logic
## রিফান্ড লজিক

### Cancellation Refund Rules

**1. Pending Orders (status = 0):**
```
Refund: 100% (Full refund)
Method: Cancel Stripe PaymentIntent
Reason: Payment not captured yet
```

**2. Active Orders - Teacher Cancellation:**
```
Refund: 100% or partial (teacher's choice)
Method: Stripe Refund API
Reason: Teacher-initiated cancellation
```

**3. Active Orders - Buyer Cancellation:**
```
Pro-rated refund based on:

Classes >12 hours away: REFUNDABLE
Classes <12 hours away: NON-REFUNDABLE
Classes already passed: NON-REFUNDABLE

Calculation:
refund_amount = (refundable_classes / total_classes) × order_amount
```

**Example (উদাহরণ):**
```
Total Classes: 10
Order Amount: $100
Classes Completed: 3
Classes >12h away: 5
Classes <12h away: 2

Refundable Classes: 5
Refund Amount: (5 / 10) × $100 = $50
```

**4. Dispute Refunds:**
```
Based on DisputeOrder.refund_type:
• 'full' → 100% refund
• 'partial' → Custom amount set by admin/seller
```

### Refund Processing

**File:** Multiple locations
- `OrderManagementController::CancelOrder()` - Manual cancellations
- `OrderManagementController::AcceptDisputedOrder()` - Dispute acceptance
- `AutoCancelPendingOrders.php` - Auto-cancel
- `AutoHandleDisputes.php` - Auto-dispute processing

**Stripe Integration:**
```php
// Cancel Payment (Pending orders)
\Stripe\PaymentIntent::cancel($payment_intent_id);

// Refund Payment (Active orders)
\Stripe\Refund::create([
    'payment_intent' => $payment_intent_id,
    'amount' => $refund_amount_in_cents
]);
```

---

## Quick Reference Table
## দ্রুত রেফারেন্স টেবিল

### All Possible Status Transitions

| From Status | To Status | Trigger Type | Location | Refund |
|-------------|-----------|--------------|----------|--------|
| N/A | 0 (Pending) | Manual | `BookingController::ServicePayment()` | - |
| N/A | 1 (Active) | Manual (Free Trial) | `BookingController::ServicePayment()` | - |
| 0 | 1 | Manual (Seller) | `OrderManagementController::ActiveOrder()` | - |
| 0 | 4 | Auto | `AutoCancelPendingOrders.php` | Full |
| 0 | 4 | Manual | `OrderManagementController::CancelOrder()` | Full |
| 1 | 2 | Auto | `AutoMarkDelivered.php` | - |
| 1 | 2 | Manual (Teacher) | `OrderManagementController::DeliverOrder()` | - |
| 1 | 4 | Manual | `OrderManagementController::CancelOrder()` | Pro-rated |
| 2 | 1 | Manual | `OrderManagementController::BackToActive()` | - |
| 2 | 3 | Auto | `AutoMarkCompleted.php` | - |
| 2 | 4 | Manual (Buyer) | `OrderManagementController::DisputeOrder()` | Depends |
| 4 | - | Auto (Refund) | `AutoHandleDisputes.php` | Full/Partial |

### Key Files Summary

| File | Purpose | Commands/Methods |
|------|---------|------------------|
| `/app/Http/Controllers/BookingController.php` | Order creation | `ServicePayment()` |
| `/app/Http/Controllers/OrderManagementController.php` | Manual order management | `ActiveOrder()`, `CancelOrder()`, `DeliverOrder()`, `DisputeOrder()`, `AcceptDisputedOrder()`, `BackToActive()` |
| `/app/Console/Commands/AutoCancelPendingOrders.php` | Auto-cancel pending orders | Runs every 5 min |
| `/app/Console/Commands/AutoMarkDelivered.php` | Auto-mark delivered | Runs hourly |
| `/app/Console/Commands/AutoMarkCompleted.php` | Auto-mark completed | Runs every 6 hours |
| `/app/Console/Commands/AutoHandleDisputes.php` | Auto-process disputes | Runs daily at 3AM |
| `/app/Console/Kernel.php` | Schedule registration | All scheduled commands |

---

## Important Notes
## গুরুত্বপূর্ণ নোট

### For Buyers (বায়ারদের জন্য):
1. ✅ Paid orders remain **Pending (0)** until seller accepts
2. ✅ You have **48 hours** after delivery to file a dispute
3. ✅ Cancellation refunds are **pro-rated** based on completed classes
4. ✅ Classes starting in <12 hours cannot be refunded
5. ✅ Free trial orders are **immediately active (1)**

### For Sellers (সেলারদের জন্য):
1. ✅ Accept orders **before class time** to avoid auto-cancellation
2. ✅ Auto-cancel triggers **30 minutes before** class start
3. ✅ You have **48 hours** to respond to buyer disputes
4. ✅ No response = automatic refund to buyer
5. ✅ Mark orders delivered manually or wait for auto-delivery

### For Admins (অ্যাডমিনদের জন্য):
1. ✅ Monitor scheduled commands via `php artisan schedule:list`
2. ✅ Check log files in `storage/logs/` directory
3. ✅ Manually resolve disputes when both parties dispute
4. ✅ Review auto-cancellations and auto-refunds regularly
5. ✅ Payout only **Completed (3)** orders

---

## Testing Commands
## টেস্টিং কমান্ড

```bash
# View all scheduled tasks
php artisan schedule:list

# Run auto-cancel manually
php artisan orders:auto-cancel

# Run auto-deliver manually
php artisan orders:auto-deliver

# Run auto-complete manually
php artisan orders:auto-complete

# Run dispute processing manually
php artisan disputes:process

# Check logs
tail -f storage/logs/auto-cancel.log
tail -f storage/logs/auto-deliver.log
tail -f storage/logs/auto-complete.log
tail -f storage/logs/disputes.log

# Database queries for debugging
php artisan tinker
>>> \App\Models\BookOrder::where('status', 0)->count(); // Pending orders
>>> \App\Models\BookOrder::where('status', 1)->count(); // Active orders
>>> \App\Models\BookOrder::where('status', 2)->count(); // Delivered orders
>>> \App\Models\BookOrder::where('status', 3)->count(); // Completed orders
>>> \App\Models\BookOrder::where('status', 4)->count(); // Cancelled orders
```

---

**Document Version:** 1.0
**Last Updated:** November 19, 2025
**Maintained By:** Development Team

---

**End of Documentation**
