# 🔄 DreamCrowd Payment & Refund System
## Phase 2: Enhanced Refund System & Workflow (MEDIUM PRIORITY)

**Document Version:** 1.0
**Date:** 24 November 2025
**Status:** Ready for Implementation (After Phase 1)
**Timeline:** Week 3-4 (10-12 days)
**Priority:** 🟡 MEDIUM
**Depends On:** Phase 1 Must Be Completed First

---

## 📋 Table of Contents

1. [Executive Summary](#executive-summary)
2. [Phase 2 Objectives](#phase-2-objectives)
3. [Implementation Details](#implementation-details)
   - [3.1 Seller 48-Hour Countdown UI](#31-seller-48-hour-countdown-ui)
   - [3.2 Invoice PDF Generation](#32-invoice-pdf-generation)
   - [3.3 Coupon Discount Verification](#33-coupon-discount-verification)
   - [3.4 Webhook Enhancements](#34-webhook-enhancements)
   - [3.5 Email Template Improvements](#35-email-template-improvements)
4. [Testing Checklist](#testing-checklist)
5. [Success Criteria](#success-criteria)
6. [Timeline](#timeline)

---

## 1. Executive Summary

### 🎯 What This Phase Delivers

Phase 2 focuses on **enhancing the refund workflow** and improving user experience for sellers and buyers. This phase makes the system more transparent and automated.

**Key Deliverables:**
- ✅ **48-Hour Countdown Timer** - Sellers see real-time countdown for refund requests
- ✅ **Invoice PDF Generation** - Downloadable invoices for all transactions
- ✅ **Coupon Verification** - Ensure discounts only affect admin commission
- ✅ **Webhook Handler** - Auto-update system when Stripe events occur
- ✅ **Email Templates** - Professional HTML emails for all notifications

**Why This Matters:**
- Sellers need visual countdown to respond in time
- Professional invoices required for accounting/tax purposes
- Coupon system must protect seller earnings
- Webhooks make system truly automated
- Better emails = better user experience

---

## 2. Phase 2 Objectives

### 🎯 Primary Goals

1. **Seller Dashboard Improvements**
   - Real-time 48-hour countdown timer
   - Prominent "Accept" and "Dispute" buttons
   - Urgency indicators (red alert for < 6 hours)
   - Clear display of refund amount

2. **Invoice System**
   - PDF generation for every completed order
   - Download from admin, buyer, and seller dashboards
   - Professional design with all transaction details
   - Unique invoice ID generation

3. **Coupon System Verification**
   - Verify discount only reduces admin commission
   - Test all coupon scenarios
   - Fix any calculation bugs
   - Add unit tests

4. **Webhook Automation**
   - Handle `charge.refunded` event
   - Handle `payout.paid` event
   - Handle `payment_intent.succeeded` event
   - Signature verification for security

5. **Communication Enhancement**
   - Beautiful HTML email templates
   - Consistent branding
   - Clear action items
   - Mobile-responsive designs

### 🚫 Out of Scope for Phase 2

These will be handled in Phase 3:
- ❌ Stripe Connect integration
- ❌ Automated seller payouts
- ❌ Refund analytics dashboard
- ❌ Payment hold system enhancements
- ❌ Bulk operations

---

## 3. Implementation Details

---

## 3.1 Seller 48-Hour Countdown UI

**Priority:** 🔴 HIGH
**Location:** Seller Dashboard - Client Management Page
**Files:** `OrderManagementController.php`, `resources/views/Teacher-Dashboard/client-management.blade.php`
**Estimated Time:** 3-4 days

### 3.1.1 The 48-Hour Rule (Client Requirement)

> "If the seller does not reply within 48 hours → buyer automatically gets the refund."
> — Client, Direct Quote

**Current Status:**
- ✅ Backend logic exists (`AutoHandleDisputes` command runs daily)
- ✅ Notifications sent to seller
- ❌ **No visual countdown on seller dashboard**
- ❌ **Sellers don't know how much time remaining**

### 3.1.2 Controller Updates

**File:** `app/Http/Controllers/OrderManagementController.php`

Add method to calculate countdown for each pending dispute:

```php
/**
 * Get pending refund requests with countdown data
 * for seller dashboard
 */
public function ClientManagement()
{
    // ... existing code ...

    // Get orders with pending refund requests (48-hour window active)
    $pendingRefunds = BookOrder::where('teacher_id', Auth::id())
        ->where('user_dispute', 1) // Buyer has disputed
        ->where('teacher_dispute', 0) // Seller hasn't responded yet
        ->where('status', '!=', 4) // Not cancelled yet
        ->with(['user', 'gig'])
        ->get()
        ->map(function($order) {
            // Calculate hours remaining
            $disputeCreatedAt = DisputeOrder::where('order_id', $order->id)
                ->where('user_role', 0) // Buyer's dispute
                ->orderBy('created_at', 'desc')
                ->first()
                ->created_at ?? $order->action_date;

            $hoursElapsed = Carbon::parse($disputeCreatedAt)->diffInHours(now());
            $hoursRemaining = 48 - $hoursElapsed;

            $order->hours_remaining = max(0, $hoursRemaining);
            $order->dispute_created_at = $disputeCreatedAt;

            // Urgency level
            if ($hoursRemaining > 24) {
                $order->urgency = 'low'; // Green
            } elseif ($hoursRemaining > 6) {
                $order->urgency = 'medium'; // Yellow
            } else {
                $order->urgency = 'high'; // Red
            }

            return $order;
        });

    return view('Teacher-Dashboard.client-management', compact(
        'orders',
        'pendingRefunds', // NEW
        // ... other variables
    ));
}
```

### 3.1.3 View File Updates

**File:** `resources/views/Teacher-Dashboard/client-management.blade.php`

Add pending refunds section at the top:

```blade
@if($pendingRefunds->isNotEmpty())
<!-- ⚠️ URGENT: Pending Refund Requests -->
<div class="alert alert-warning mb-4" role="alert">
    <div class="d-flex align-items-center">
        <i class="bx bx-error-circle fs-2 me-2"></i>
        <div>
            <h5 class="alert-heading mb-1">⚠️ {{ $pendingRefunds->count() }} Pending Refund Request(s)</h5>
            <p class="mb-0">You have refund requests that require your response within 48 hours.</p>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-warning">
        <h5 class="mb-0">🕐 Refund Requests - Action Required</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Buyer</th>
                        <th>Amount</th>
                        <th>Buyer's Reason</th>
                        <th>Time Remaining</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingRefunds as $refund)
                    <tr>
                        <td>
                            <strong>#{{ $refund->id }}</strong>
                            <br><small class="text-muted">{{ Str::limit($refund->title, 30) }}</small>
                        </td>
                        <td>
                            {{ $refund->user->first_name }} {{ $refund->user->last_name }}
                            <br><small class="text-muted">{{ $refund->user->email }}</small>
                        </td>
                        <td>
                            <strong class="text-danger">${{ number_format($refund->finel_price, 2) }}</strong>
                        </td>
                        <td>
                            @php
                                $dispute = \App\Models\DisputeOrder::where('order_id', $refund->id)
                                    ->where('user_role', 0)
                                    ->first();
                            @endphp
                            {{ $dispute ? Str::limit($dispute->reason, 50) : 'N/A' }}
                            @if($dispute && strlen($dispute->reason) > 50)
                                <button class="btn btn-sm btn-link p-0" data-bs-toggle="modal"
                                        data-bs-target="#reasonModal{{ $refund->id }}">
                                    Read More
                                </button>
                            @endif
                        </td>
                        <td>
                            <!-- Countdown Timer -->
                            <div class="countdown-wrapper">
                                @if($refund->urgency == 'high')
                                    <span class="badge bg-danger fs-6 countdown-badge"
                                          data-end-time="{{ Carbon::parse($refund->dispute_created_at)->addHours(48)->toIso8601String() }}"
                                          id="countdown-{{ $refund->id }}">
                                        🔴 {{ $refund->hours_remaining }}h remaining
                                    </span>
                                    <br><small class="text-danger fw-bold">⚠️ URGENT!</small>
                                @elseif($refund->urgency == 'medium')
                                    <span class="badge bg-warning text-dark fs-6 countdown-badge"
                                          data-end-time="{{ Carbon::parse($refund->dispute_created_at)->addHours(48)->toIso8601String() }}"
                                          id="countdown-{{ $refund->id }}">
                                        🟡 {{ $refund->hours_remaining }}h remaining
                                    </span>
                                @else
                                    <span class="badge bg-success fs-6 countdown-badge"
                                          data-end-time="{{ Carbon::parse($refund->dispute_created_at)->addHours(48)->toIso8601String() }}"
                                          id="countdown-{{ $refund->id }}">
                                        🟢 {{ $refund->hours_remaining }}h remaining
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- Accept Refund Button -->
                                <form method="POST" action="{{ route('AcceptDisputedOrder') }}" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $refund->id }}">
                                    <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirm('Accept refund and issue full refund to buyer?')">
                                        <i class="bx bx-check-circle"></i> Accept Refund
                                    </button>
                                </form>

                                <!-- Dispute Refund Button -->
                                <button type="button" class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal" data-bs-target="#disputeModal{{ $refund->id }}">
                                    <i class="bx bx-shield-x"></i> Dispute
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Reason Modal -->
                    <div class="modal fade" id="reasonModal{{ $refund->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Buyer's Refund Reason</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Order:</strong> #{{ $refund->id }} - {{ $refund->title }}</p>
                                    <p><strong>Buyer:</strong> {{ $refund->user->first_name }} {{ $refund->user->last_name }}</p>
                                    <hr>
                                    <p>{{ $dispute->reason ?? 'N/A' }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dispute Modal -->
                    <div class="modal fade" id="disputeModal{{ $refund->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('DisputeOrder') }}">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $refund->id }}">
                                    <input type="hidden" name="refund_type" value="0"> <!-- Full refund -->

                                    <div class="modal-header">
                                        <h5 class="modal-title">Counter-Dispute Refund Request</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <strong>ℹ️ What happens next:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li>Your payment will be held</li>
                                                <li>Your reason will be sent to admin for review</li>
                                                <li>Admin will decide within 24-48 hours</li>
                                            </ul>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Your Counter-Dispute Reason (Required):</label>
                                            <textarea name="reason" class="form-control" rows="5" required
                                                      placeholder="Explain why this refund should not be issued..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Submit counter-dispute to admin?')">
                                            <i class="bx bx-shield-x"></i> Submit Dispute
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
```

### 3.1.4 JavaScript Countdown Timer

Add to the bottom of the view file:

```blade
<script>
/**
 * Real-time countdown timer for refund requests
 * Updates every minute
 */
function initializeCountdowns() {
    const countdownElements = document.querySelectorAll('.countdown-badge');

    countdownElements.forEach(element => {
        const endTime = new Date(element.getAttribute('data-end-time'));

        function updateCountdown() {
            const now = new Date();
            const diff = endTime - now;

            if (diff <= 0) {
                element.textContent = '⏰ Time Expired!';
                element.classList.remove('bg-success', 'bg-warning', 'bg-danger');
                element.classList.add('bg-dark');
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

            // Update badge color based on time remaining
            element.classList.remove('bg-success', 'bg-warning', 'bg-danger');
            if (hours > 24) {
                element.classList.add('bg-success');
                element.innerHTML = `🟢 ${hours}h ${minutes}m remaining`;
            } else if (hours > 6) {
                element.classList.add('bg-warning', 'text-dark');
                element.innerHTML = `🟡 ${hours}h ${minutes}m remaining`;
            } else {
                element.classList.add('bg-danger');
                element.innerHTML = `🔴 ${hours}h ${minutes}m remaining`;

                // Flash animation for urgent cases
                if (hours < 2) {
                    element.style.animation = 'flash 1s infinite';
                }
            }
        }

        // Update immediately
        updateCountdown();

        // Update every minute
        setInterval(updateCountdown, 60000);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initializeCountdowns);

// Optional: Add flash animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes flash {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
`;
document.head.appendChild(style);
</script>
```

---

## 3.2 Invoice PDF Generation

**Priority:** 🟡 MEDIUM
**Package:** Already installed - `barryvdh/laravel-dompdf`
**Estimated Time:** 2-3 days

### 3.2.1 Create Invoice Controller

**File:** `app/Http/Controllers/InvoiceController.php` (NEW)

```php
<?php

namespace App\Http\Controllers;

use App\Models\BookOrder;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Generate invoice ID
     * Format: INV-YYYYMM-00001
     */
    private function generateInvoiceId($orderId)
    {
        $yearMonth = now()->format('Ym');
        $paddedId = str_pad($orderId, 5, '0', STR_PAD_LEFT);
        return "INV-{$yearMonth}-{$paddedId}";
    }

    /**
     * Download invoice for order (accessible by buyer, seller, admin)
     */
    public function downloadInvoice($orderId)
    {
        $order = BookOrder::with(['user', 'teacher', 'gig', 'transaction'])
            ->findOrFail($orderId);

        // Authorization check
        $userId = auth()->id();
        $isAuthorized = ($order->user_id == $userId) ||
                       ($order->teacher_id == $userId) ||
                       (auth()->user()->role == 2); // Admin

        if (!$isAuthorized) {
            abort(403, 'Unauthorized to view this invoice.');
        }

        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        $invoiceData = [
            'invoice_id' => $this->generateInvoiceId($order->id),
            'order' => $order,
            'transaction' => $transaction,
            'buyer' => $order->user,
            'seller' => $order->teacher,
            'service' => $order->gig,
            'generated_date' => now()->format('F d, Y'),
        ];

        $pdf = Pdf::loadView('invoices.order-invoice', $invoiceData);

        return $pdf->download("Invoice-{$invoiceData['invoice_id']}.pdf");
    }

    /**
     * View invoice in browser (for preview)
     */
    public function viewInvoice($orderId)
    {
        $order = BookOrder::with(['user', 'teacher', 'gig', 'transaction'])
            ->findOrFail($orderId);

        // Authorization check
        $userId = auth()->id();
        $isAuthorized = ($order->user_id == $userId) ||
                       ($order->teacher_id == $userId) ||
                       (auth()->user()->role == 2);

        if (!$isAuthorized) {
            abort(403, 'Unauthorized to view this invoice.');
        }

        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        $invoiceData = [
            'invoice_id' => $this->generateInvoiceId($order->id),
            'order' => $order,
            'transaction' => $transaction,
            'buyer' => $order->user,
            'seller' => $order->teacher,
            'service' => $order->gig,
            'generated_date' => now()->format('F d, Y'),
        ];

        return view('invoices.order-invoice', $invoiceData);
    }
}
```

### 3.2.2 Invoice View Template

**File:** `resources/views/invoices/order-invoice.blade.php` (NEW)

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #4F46E5;
        }
        .invoice-title {
            font-size: 24px;
            margin-top: 10px;
            color: #333;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 5px 0;
        }
        .parties {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .party {
            display: table-cell;
            width: 48%;
            vertical-align: top;
        }
        .party-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            color: #4F46E5;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .details-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .totals-table {
            width: 50%;
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px;
            text-align: right;
        }
        .totals-table .label {
            text-align: left;
            font-weight: bold;
        }
        .totals-table .grand-total {
            border-top: 2px solid #333;
            font-size: 18px;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 12px;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-refunded {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">DreamCrowd</div>
        <div class="invoice-title">INVOICE</div>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-info">
        <table>
            <tr>
                <td><strong>Invoice ID:</strong> {{ $invoice_id }}</td>
                <td style="text-align: right;"><strong>Date:</strong> {{ $generated_date }}</td>
            </tr>
            <tr>
                <td><strong>Order ID:</strong> #{{ $order->id }}</td>
                <td style="text-align: right;">
                    <strong>Status:</strong>
                    @switch($order->status)
                        @case(0)
                            <span class="status-badge status-pending">Pending</span>
                            @break
                        @case(1)
                            <span class="status-badge status-pending">Active</span>
                            @break
                        @case(2)
                            <span class="status-badge status-pending">Delivered</span>
                            @break
                        @case(3)
                            <span class="status-badge status-completed">Completed</span>
                            @break
                        @case(4)
                            <span class="status-badge status-refunded">Cancelled</span>
                            @break
                    @endswitch
                    @if($order->refund == 1)
                        <span class="status-badge status-refunded">Refunded</span>
                    @endif
                </td>
            </tr>
            @if($order->payment_id)
            <tr>
                <td colspan="2"><strong>Stripe Payment ID:</strong> {{ $order->payment_id }}</td>
            </tr>
            @endif
        </table>
    </div>

    <!-- Parties (Buyer & Seller) -->
    <div class="parties">
        <div class="party">
            <div class="party-title">Bill To (Buyer)</div>
            <div>
                <strong>{{ $buyer->first_name }} {{ $buyer->last_name }}</strong><br>
                Email: {{ $buyer->email }}<br>
                @if($buyer->phone)
                    Phone: {{ $buyer->phone }}<br>
                @endif
            </div>
        </div>
        <div class="party" style="padding-left: 4%;">
            <div class="party-title">Service Provider (Seller)</div>
            <div>
                <strong>{{ $seller->first_name }} {{ $seller->last_name }}</strong><br>
                Email: {{ $seller->email }}<br>
                @if($seller->phone)
                    Phone: {{ $seller->phone }}<br>
                @endif
            </div>
        </div>
    </div>

    <!-- Service Details -->
    <table class="details-table">
        <thead>
            <tr>
                <th>Service Description</th>
                <th style="width: 150px; text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $order->title }}</strong><br>
                    <small>
                        Type: {{ $service->service_role ?? 'N/A' }}<br>
                        @if($order->frequency)
                            Frequency: {{ $order->frequency == 1 ? 'One-time' : 'Subscription (' . $order->frequency . ' sessions)' }}<br>
                        @endif
                        @if($order->group_type)
                            Group Type: {{ $order->group_type }}<br>
                        @endif
                        Order Date: {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                    </small>
                </td>
                <td style="text-align: right;">
                    ${{ number_format($order->finel_price, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Price Breakdown -->
    <table class="totals-table">
        <tr>
            <td class="label">Service Price:</td>
            <td>${{ number_format($order->finel_price, 2) }}</td>
        </tr>
        @if($transaction)
            @if($transaction->buyer_commission_amount > 0)
            <tr>
                <td class="label">Buyer Commission:</td>
                <td>${{ number_format($transaction->buyer_commission_amount, 2) }}</td>
            </tr>
            @endif
            @if($transaction->coupon_discount > 0)
            <tr>
                <td class="label">Discount:</td>
                <td style="color: green;">-${{ number_format($transaction->coupon_discount, 2) }}</td>
            </tr>
            @endif
        @endif
        <tr class="grand-total">
            <td class="label">Total Paid:</td>
            <td>${{ number_format($order->finel_price + ($transaction->buyer_commission_amount ?? 0) - ($transaction->coupon_discount ?? 0), 2) }}</td>
        </tr>
    </table>

    <!-- Commission Breakdown (For Admin/Seller view) -->
    @if($transaction)
    <table class="details-table" style="margin-top: 30px;">
        <thead>
            <tr>
                <th colspan="2" style="background-color: #e9ecef;">Commission Breakdown</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label">Seller Commission ({{ number_format($transaction->seller_commission_rate, 1) }}%):</td>
                <td style="text-align: right;">${{ number_format($transaction->seller_commission_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Admin Commission (Buyer):</td>
                <td style="text-align: right;">${{ number_format($transaction->buyer_commission_amount, 2) }}</td>
            </tr>
            <tr style="border-top: 2px solid #333;">
                <td class="label"><strong>Seller Earnings:</strong></td>
                <td style="text-align: right;"><strong>${{ number_format($transaction->seller_earnings, 2) }}</strong></td>
            </tr>
            <tr>
                <td class="label"><strong>Total Admin Commission:</strong></td>
                <td style="text-align: right;"><strong>${{ number_format($transaction->total_admin_commission, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
    @endif

    <!-- Payment Status -->
    <div style="margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-left: 4px solid #4F46E5;">
        <strong>Payment Status:</strong>
        @if($order->payment_status == 'paid')
            ✅ Paid on {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
        @elseif($order->payment_status == 'refunded')
            ⚠️ Refunded
        @else
            ⏳ {{ ucfirst($order->payment_status) }}
        @endif
        <br>
        <strong>Payout Status:</strong>
        @if($transaction)
            {{ ucfirst($transaction->payout_status) }}
        @else
            N/A
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>DreamCrowd</strong> - Connecting Teachers & Learners</p>
        <p>This is an automatically generated invoice. No signature required.</p>
        <p>For support, contact: support@dreamcrowd.com</p>
    </div>
</body>
</html>
```

### 3.2.3 Add Routes

**File:** `routes/web.php`

```php
Route::middleware(['auth'])->group(function () {
    // Invoice routes
    Route::get('/invoice/download/{orderId}', [InvoiceController::class, 'downloadInvoice'])
        ->name('invoice.download');
    Route::get('/invoice/view/{orderId}', [InvoiceController::class, 'viewInvoice'])
        ->name('invoice.view');
});
```

### 3.2.4 Add Download Buttons

**In Admin Dashboard - All Orders Page:**

```blade
<a class="dropdown-item" href="{{ route('invoice.download', $order->id) }}">
    <i class="bx bx-download"></i> Download Invoice
</a>
```

**In Buyer Dashboard - Order Details:**

```blade
<a href="{{ route('invoice.download', $order->id) }}" class="btn btn-primary">
    <i class="bx bx-download"></i> Download Invoice
</a>
```

**In Seller Dashboard - Order Details:**

```blade
<a href="{{ route('invoice.download', $order->id) }}" class="btn btn-secondary">
    <i class="bx bx-file-blank"></i> Download Receipt
</a>
```

---

## 3.3 Coupon Discount Verification

**Priority:** 🟢 MEDIUM-LOW
**Location:** `TopSellerTag::calculateCommission()`, `BookingController`
**Estimated Time:** 1-2 days

### 3.3.1 The Requirement

> "Discount amount will reduce **Admin's 15% commission only**,
> **Seller earnings will remain unchanged**."
> — PRD Requirement

### 3.3.2 Verification Steps

**File:** `app/Models/TopSellerTag.php`

Review the `calculateCommission()` method:

```php
public static function calculateCommission($servicePrice, $gig = null, $seller = null, $couponDiscount = 0)
{
    // 1. Calculate base commissions
    $sellerCommissionRate = self::getSellerCommissionRate($gig, $seller);
    $buyerCommissionRate = 15; // Default buyer commission

    $sellerCommissionAmount = ($servicePrice * $sellerCommissionRate) / 100;
    $buyerCommissionAmount = ($servicePrice * $buyerCommissionRate) / 100;

    // 2. Calculate seller earnings (MUST remain unchanged by coupon)
    $sellerEarnings = $servicePrice - $sellerCommissionAmount;

    // 3. Apply coupon discount to ADMIN commission only
    $totalAdminCommission = $sellerCommissionAmount + $buyerCommissionAmount - $couponDiscount;

    // ✅ CRITICAL: Ensure admin commission cannot be negative
    $totalAdminCommission = max(0, $totalAdminCommission);

    // 4. Return breakdown
    return [
        'service_price' => $servicePrice,
        'seller_commission_rate' => $sellerCommissionRate,
        'seller_commission_amount' => $sellerCommissionAmount,
        'buyer_commission_rate' => $buyerCommissionRate,
        'buyer_commission_amount' => $buyerCommissionAmount,
        'coupon_discount' => $couponDiscount,
        'total_admin_commission' => $totalAdminCommission,
        'seller_earnings' => $sellerEarnings, // ✅ UNCHANGED by coupon
        'buyer_total' => $servicePrice + $buyerCommissionAmount - $couponDiscount,
    ];
}
```

### 3.3.3 Test Scenarios

Create test file: `tests/Feature/CouponCommissionTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TopSellerTag;

class CouponCommissionTest extends TestCase
{
    /**
     * Test Scenario 1: $100 service, 15% commission, $10 coupon
     * Expected:
     * - Seller earnings: $85 (unchanged)
     * - Admin commission: $15 (original) - $10 (coupon) = $5
     */
    public function test_coupon_reduces_admin_commission_not_seller_earnings()
    {
        $result = TopSellerTag::calculateCommission(
            servicePrice: 100,
            gig: null,
            seller: null,
            couponDiscount: 10
        );

        $this->assertEquals(85, $result['seller_earnings']); // ✅ Unchanged
        $this->assertEquals(15, $result['seller_commission_amount']);
        $this->assertEquals(10, $result['coupon_discount']);
        $this->assertEquals(5, $result['total_admin_commission']); // 15 - 10
    }

    /**
     * Test Scenario 2: $100 service, 15% commission, $20 coupon (exceeds admin commission)
     * Expected:
     * - Seller earnings: $85 (unchanged)
     * - Admin commission: $0 (cannot be negative)
     */
    public function test_coupon_cannot_make_admin_commission_negative()
    {
        $result = TopSellerTag::calculateCommission(
            servicePrice: 100,
            gig: null,
            seller: null,
            couponDiscount: 20 // More than admin commission!
        );

        $this->assertEquals(85, $result['seller_earnings']); // ✅ Still unchanged
        $this->assertEquals(0, $result['total_admin_commission']); // ✅ Floor at 0
    }

    /**
     * Test Scenario 3: No coupon
     */
    public function test_no_coupon_default_commission()
    {
        $result = TopSellerTag::calculateCommission(
            servicePrice: 100,
            gig: null,
            seller: null,
            couponDiscount: 0
        );

        $this->assertEquals(85, $result['seller_earnings']);
        $this->assertEquals(15, $result['total_admin_commission']);
    }
}
```

**Run tests:**
```bash
php artisan test --filter CouponCommissionTest
```

### 3.3.4 If Tests Fail - Fix Required

If tests reveal bugs, update the `calculateCommission()` method to match the expected logic above.

---

## 3.4 Webhook Enhancements

**Priority:** 🟡 MEDIUM
**Location:** `app/Http/Controllers/StripeWebhookController.php`
**Estimated Time:** 2-3 days

### 3.4.1 Current Status

⚠️ **Current webhook handler is incomplete:**
- Missing `charge.refunded` handler
- Missing `payout.paid` handler
- No webhook signature verification (CRITICAL for production)

### 3.4.2 Complete Webhook Handler

**File:** `app/Http/Controllers/StripeWebhookController.php`

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BookOrder;
use App\Models\Transaction;
use App\Services\NotificationService;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle Stripe webhook events
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        // ✅ CRITICAL: Verify webhook signature
        if ($webhookSecret) {
            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            } catch (SignatureVerificationException $e) {
                Log::error('Webhook signature verification failed: ' . $e->getMessage());
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        } else {
            // Development mode - no signature verification
            $event = json_decode($payload, true);
            Log::warning('Webhook received without signature verification (development mode)');
        }

        // Log webhook event
        Log::channel('stripe_webhooks')->info('Webhook received', [
            'type' => $event['type'],
            'id' => $event['id'],
            'data' => $event['data']
        ]);

        // Handle event based on type
        switch ($event['type']) {
            case 'charge.refunded':
                $this->handleChargeRefunded($event['data']['object']);
                break;

            case 'payout.paid':
                $this->handlePayoutPaid($event['data']['object']);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event['data']['object']);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event['data']['object']);
                break;

            default:
                Log::info('Unhandled webhook event type: ' . $event['type']);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle charge.refunded event
     * Triggered when a refund is processed
     */
    protected function handleChargeRefunded($charge)
    {
        $paymentIntentId = $charge['payment_intent'];

        Log::info('Processing charge.refunded webhook', [
            'payment_intent' => $paymentIntentId,
            'amount_refunded' => $charge['amount_refunded'] / 100
        ]);

        // Find order by payment_id
        $order = BookOrder::where('payment_id', $paymentIntentId)->first();

        if (!$order) {
            Log::warning('Order not found for payment_intent: ' . $paymentIntentId);
            return;
        }

        // Update order status
        $order->refund = 1;
        $order->payment_status = 'refunded';
        $order->status = 4; // Cancelled
        $order->save();

        // Update transaction
        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        if ($transaction) {
            $transaction->status = 'refunded';
            $transaction->payout_status = 'failed';
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Refund processed via Stripe webhook";
            $transaction->save();
        }

        // Send confirmation email to buyer
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'refund_processed',
            title: 'Refund Processed Successfully',
            message: "Your refund of $" . number_format($charge['amount_refunded'] / 100, 2) . " has been processed and will appear in your account within 5-10 business days.",
            data: [
                'order_id' => $order->id,
                'refund_amount' => $charge['amount_refunded'] / 100
            ],
            sendEmail: true,
            orderId: $order->id
        );

        Log::info('Refund webhook processed successfully for order #' . $order->id);
    }

    /**
     * Handle payout.paid event (for future Stripe Connect)
     * Triggered when seller receives payout
     */
    protected function handlePayoutPaid($payout)
    {
        Log::info('Processing payout.paid webhook', [
            'payout_id' => $payout['id'],
            'amount' => $payout['amount'] / 100
        ]);

        // This will be implemented in Phase 3 when Stripe Connect is integrated
        // For now, just log it

        // Future implementation:
        // - Find transactions by payout_id
        // - Update payout_status to 'completed'
        // - Update seller's total_earnings
        // - Send notification to seller
    }

    /**
     * Handle payment_intent.succeeded event
     * Triggered when payment is successful
     */
    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        $paymentIntentId = $paymentIntent['id'];

        Log::info('Processing payment_intent.succeeded webhook', [
            'payment_intent' => $paymentIntentId,
            'amount' => $paymentIntent['amount'] / 100
        ]);

        // Find order by payment_id
        $order = BookOrder::where('payment_id', $paymentIntentId)->first();

        if (!$order) {
            Log::warning('Order not found for payment_intent: ' . $paymentIntentId);
            return;
        }

        // Update order payment status
        $order->payment_status = 'paid';
        if ($order->status == 0) {
            $order->status = 1; // Activate order
        }
        $order->save();

        // Update transaction
        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        if ($transaction) {
            $transaction->status = 'active';
            $transaction->save();
        }

        Log::info('Payment success webhook processed for order #' . $order->id);
    }

    /**
     * Handle payment_intent.payment_failed event
     * Triggered when payment fails
     */
    protected function handlePaymentIntentFailed($paymentIntent)
    {
        Log::error('Payment failed webhook received', [
            'payment_intent' => $paymentIntent['id'],
            'error' => $paymentIntent['last_payment_error']
        ]);

        // Send notification to admin
        // This is critical - admin should know about failed payments
    }
}
```

### 3.4.3 Add Webhook Logging Channel

**File:** `config/logging.php`

```php
'channels' => [
    // ... existing channels ...

    'stripe_webhooks' => [
        'driver' => 'daily',
        'path' => storage_path('logs/stripe-webhooks.log'),
        'level' => 'info',
        'days' => 30,
    ],
],
```

### 3.4.4 Register Webhook in Stripe Dashboard

**Production Setup (Manual Steps):**

1. Login to Stripe Dashboard
2. Go to Developers → Webhooks
3. Click "Add endpoint"
4. Endpoint URL: `https://yourdomain.com/stripe/webhook`
5. Select events:
   - `charge.refunded`
   - `payout.paid`
   - `payment_intent.succeeded`
   - `payment_intent.payment_failed`
6. Copy webhook signing secret
7. Add to `.env`:
```env
STRIPE_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxx
```

**Testing with Stripe CLI:**

```bash
# Install Stripe CLI
stripe listen --forward-to localhost:8000/stripe/webhook

# Test refund event
stripe trigger charge.refunded

# Test payout event
stripe trigger payout.paid
```

---

## 3.5 Email Template Improvements

**Priority:** 🟢 LOW
**Location:** `resources/views/emails/`
**Estimated Time:** 1-2 days

### 3.5.1 Create Email Layouts

**File:** `resources/views/emails/layouts/base.blade.php` (NEW)

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DreamCrowd')</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }
        .button:hover {
            background-color: #5568d3;
        }
        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
        }
        .success-box {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
        .danger-box {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>DreamCrowd</h1>
        </div>
        <div class="email-body">
            @yield('content')
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} DreamCrowd. All rights reserved.</p>
            <p>
                <a href="{{ config('app.url') }}">Visit Website</a> |
                <a href="{{ config('app.url') }}/support">Support</a>
            </p>
        </div>
    </div>
</body>
</html>
```

### 3.5.2 Refund Approved Email Template

**File:** `resources/views/emails/refund-approved.blade.php` (NEW)

```blade
@extends('emails.layouts.base')

@section('title', 'Refund Approved')

@section('content')
<h2 style="color: #28a745;">✅ Refund Approved</h2>

<p>Hi {{ $userName }},</p>

<p>Good news! Your refund request for order <strong>#{{ $orderId }}</strong> has been approved.</p>

<div class="success-box">
    <h3 style="margin-top: 0;">Refund Details:</h3>
    <ul style="margin: 10px 0;">
        <li><strong>Order:</strong> {{ $serviceName }}</li>
        <li><strong>Refund Type:</strong> {{ $refundType }}</li>
        <li><strong>Refund Amount:</strong> ${{ number_format($refundAmount, 2) }}</li>
    </ul>
</div>

<p>The refund has been processed and will appear in your original payment method within <strong>5-10 business days</strong>.</p>

<a href="{{ $orderUrl }}" class="button">View Order Details</a>

<p>If you have any questions, please don't hesitate to contact our support team.</p>

<p>Thank you for using DreamCrowd!</p>

<p>Best regards,<br>The DreamCrowd Team</p>
@endsection
```

### 3.5.3 48-Hour Reminder Email

**File:** `resources/views/emails/seller-refund-reminder.blade.php` (NEW)

```blade
@extends('emails.layouts.base')

@section('title', 'Refund Request - Action Required')

@section('content')
<h2 style="color: #ffc107;">⚠️ Refund Request - Action Required</h2>

<p>Hi {{ $sellerName }},</p>

<div class="warning-box">
    <h3 style="margin-top: 0;">⏰ Time-Sensitive: You have {{ $hoursRemaining }} hours remaining!</h3>
    <p>A buyer has requested a refund for one of your orders. Please respond within 48 hours to avoid automatic refund.</p>
</div>

<p><strong>Order Details:</strong></p>
<ul>
    <li><strong>Order ID:</strong> #{{ $orderId }}</li>
    <li><strong>Service:</strong> {{ $serviceName }}</li>
    <li><strong>Buyer:</strong> {{ $buyerName }}</li>
    <li><strong>Refund Amount:</strong> ${{ number_format($refundAmount, 2) }}</li>
</ul>

<p><strong>Buyer's Reason:</strong></p>
<div class="info-box">
    {{ $buyerReason }}
</div>

<p><strong>Your Options:</strong></p>
<ol>
    <li><strong>Accept Refund:</strong> Immediate full refund will be issued to the buyer.</li>
    <li><strong>Dispute Refund:</strong> Provide your reason and admin will review (payment held until decision).</li>
    <li><strong>No Action:</strong> After 48 hours, automatic full refund will be issued.</li>
</ol>

<a href="{{ $orderUrl }}" class="button">Respond Now</a>

<p style="color: #dc3545; font-weight: bold;">
    ⏰ Deadline: {{ $deadline }}
</p>

<p>Best regards,<br>The DreamCrowd Team</p>
@endsection
```

### 3.5.4 Update NotificationService to Use Templates

**File:** `app/Services/NotificationService.php`

Update the `send()` method to use Blade templates for emails:

```php
// In sendEmail() method:
Mail::send('emails.' . $type, $emailData, function ($message) use ($user, $title) {
    $message->to($user->email, $user->first_name . ' ' . $user->last_name)
            ->subject($title);
});
```

---

## 4. Testing Checklist

### 4.1 Seller 48-Hour Countdown

- [ ] **Countdown Display:**
  - [ ] Pending refund section appears on seller dashboard
  - [ ] Countdown shows correct hours remaining
  - [ ] Badge color changes based on urgency (green > 24h, yellow 6-24h, red < 6h)
  - [ ] JavaScript countdown updates every minute
  - [ ] Flash animation appears when < 2 hours

- [ ] **Accept Refund Button:**
  - [ ] Click "Accept Refund" processes immediately
  - [ ] Stripe API refund triggered
  - [ ] Order status updates
  - [ ] Both parties notified
  - [ ] Refund disappears from pending list

- [ ] **Dispute Button:**
  - [ ] Modal opens with dispute form
  - [ ] Seller can enter counter-dispute reason
  - [ ] Form submits successfully
  - [ ] Payment held
  - [ ] Admin sees dispute in pending tab
  - [ ] Countdown stops (no longer shows)

- [ ] **Auto-Refund After 48 Hours:**
  - [ ] Seller doesn't respond for 48 hours
  - [ ] `AutoHandleDisputes` command processes refund
  - [ ] Buyer receives refund
  - [ ] Both parties notified

### 4.2 Invoice PDF

- [ ] **Invoice Generation:**
  - [ ] Download invoice from admin panel → PDF downloads
  - [ ] Download invoice from buyer dashboard → PDF downloads
  - [ ] Download receipt from seller dashboard → PDF downloads
  - [ ] PDF contains all required information
  - [ ] Invoice ID format correct (INV-YYYYMM-00001)
  - [ ] All amounts displayed correctly
  - [ ] Commission breakdown accurate
  - [ ] Professional appearance

- [ ] **Authorization:**
  - [ ] Only authorized users can download (buyer, seller, admin)
  - [ ] Unauthorized user gets 403 error

- [ ] **Edge Cases:**
  - [ ] Invoice for refunded order shows "Refunded" status
  - [ ] Invoice for cancelled order shows correctly
  - [ ] Invoice with coupon discount shows discount amount

### 4.3 Coupon Verification

- [ ] **Unit Tests Pass:**
  ```bash
  php artisan test --filter CouponCommissionTest
  ```
  - [ ] All 3 test scenarios pass

- [ ] **Manual Testing:**
  - [ ] Create order with $10 coupon
  - [ ] Verify seller earnings = $85 (unchanged)
  - [ ] Verify admin commission = $5 ($15 - $10)
  - [ ] Create order with $20 coupon (exceeds commission)
  - [ ] Verify admin commission = $0 (not negative)
  - [ ] Verify seller earnings still $85

### 4.4 Webhooks

- [ ] **Webhook Signature Verification:**
  - [ ] Set `STRIPE_WEBHOOK_SECRET` in `.env`
  - [ ] Send webhook with invalid signature → Gets rejected
  - [ ] Send webhook with valid signature → Processed successfully

- [ ] **charge.refunded Event:**
  - [ ] Process refund from admin panel
  - [ ] Stripe sends `charge.refunded` webhook
  - [ ] Order status updates to "Refunded"
  - [ ] Transaction status updates
  - [ ] Buyer receives confirmation email
  - [ ] No errors in logs

- [ ] **payment_intent.succeeded Event:**
  - [ ] Create new order with payment
  - [ ] Payment succeeds
  - [ ] Webhook updates order status to "Active"
  - [ ] Transaction status updates

- [ ] **Webhook Logs:**
  - [ ] Check `storage/logs/stripe-webhooks.log`
  - [ ] All events logged correctly

### 4.5 Email Templates

- [ ] **Refund Approved Email:**
  - [ ] Buyer receives email after admin approval
  - [ ] HTML template renders correctly
  - [ ] All variables populated
  - [ ] "View Order Details" button works
  - [ ] Mobile-responsive

- [ ] **48-Hour Reminder Email:**
  - [ ] Seller receives email when dispute filed
  - [ ] Countdown shows correct hours
  - [ ] Buyer's reason displayed
  - [ ] "Respond Now" button links correctly

- [ ] **Email Appearance:**
  - [ ] Logo displays correctly
  - [ ] Colors match brand
  - [ ] No broken images
  - [ ] Links work
  - [ ] Footer information correct

---

## 5. Success Criteria

**Phase 2 is considered SUCCESSFUL when:**

### ✅ Seller Dashboard
- [x] Pending refunds section displays on seller dashboard
- [x] Real-time countdown shows hours:minutes remaining
- [x] Urgency indicators work (color-coded badges)
- [x] Accept button processes refund immediately
- [x] Dispute button opens modal and submits to admin
- [x] Countdown updates automatically

### ✅ Invoice System
- [x] PDF invoices generate for all orders
- [x] Download works from admin, buyer, seller dashboards
- [x] Invoice contains all required information
- [x] Professional design and layout
- [x] Unique invoice IDs generated
- [x] Authorization checks working

### ✅ Coupon Verification
- [x] Coupon discount only reduces admin commission
- [x] Seller earnings remain unchanged
- [x] All unit tests pass
- [x] Manual testing confirms correct calculations
- [x] Admin commission cannot go negative

### ✅ Webhooks
- [x] Webhook signature verification working
- [x] `charge.refunded` event handled correctly
- [x] `payment_intent.succeeded` event handled
- [x] All webhook events logged
- [x] Order/transaction statuses update automatically
- [x] No errors in webhook processing

### ✅ Email Templates
- [x] All emails use professional HTML templates
- [x] Consistent branding across all emails
- [x] Mobile-responsive designs
- [x] All variables populate correctly
- [x] Action buttons work

---

## 6. Timeline

**Week 3:**
- Days 1-2: Seller 48-hour countdown UI
- Day 3: Invoice PDF generation
- Day 4: Coupon verification testing
- Day 5: Webhook enhancements

**Week 4:**
- Days 1-2: Email template improvements
- Day 3-4: Integration testing
- Day 5: Bug fixes and deployment

**Total: 10-12 days**

---

## 📞 Next Steps

### After Phase 2 Completion

**Immediate Actions:**
1. **Deploy to Staging:** Test all new features
2. **User Acceptance Testing:** Get feedback from sellers and buyers
3. **Monitor Webhooks:** Check logs for any issues
4. **Performance Check:** Verify PDF generation doesn't slow down system

**Prepare for Phase 3:**
- [ ] Research Stripe Connect setup process
- [ ] Plan analytics dashboard design
- [ ] Gather requirements for bulk operations
- [ ] Plan performance optimization tasks

**Phase 3 Preview (Coming Next):**
- Stripe Connect integration
- Automated seller payouts
- Refund analytics dashboard
- Payment hold system enhancements
- Performance optimization
- Security audits

---

**🎯 END OF PHASE 2 PRD**

**Next:** [Phase 3: Advanced Features & Analytics](./DREAMCROWD_PRD_PHASE_3_ADVANCED_FEATURES.md)
