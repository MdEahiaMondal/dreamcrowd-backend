# Seller Dashboard: Earnings & Payouts - Implementation PRD

## Overview

DreamCrowd Seller Dashboard-এ "Earnings & Payouts" feature implement করতে হবে। Upwork/Fiverr-এর মতো Seller যেন দেখতে পারে কত টাকা আছে, কত পাবে, কবে পাবে।

**Target Page:** `/home/hiya/nexa-lance/dreamcrowd/dreamcrowd-backend/resources/views/Teacher-Dashboard/Earning_And_Payouts.blade.php`

**Current State:** Static/hardcoded page with dummy data. Needs to be made fully dynamic.

---

## Scope: Phase 1 (Dashboard Only)

| Feature | Status |
|---------|--------|
| Earnings Overview Cards | ✅ In Scope |
| Transaction History Table | ✅ In Scope |
| Invoice PDF Download | ✅ In Scope |
| Export Earnings Report (Excel) | ✅ In Scope |
| Withdrawal System | ❌ Phase 2 (Future) |
| Stripe Connect | ❌ Phase 2 (Future) |
| PayPal Integration | ❌ Phase 2 (Future) |

---

## Client Requirements Summary

| Requirement | Value |
|-------------|-------|
| Holding Period | 14 days before funds become available |
| Minimum Withdrawal | Admin configurable (add to TopSellerTag settings) |
| Commission | 15% default (existing - from TopSellerTag) |
| Future Withdrawal Methods | Stripe Connect + PayPal + Manual Bank |

---

## Phase 1 Features

### 1. Earnings Overview Cards (4 Cards)

| Card | Description | Calculation |
|------|-------------|-------------|
| **Total Earned** | Lifetime earnings | `SUM(seller_earnings) WHERE status='completed'` |
| **Available for Withdrawal** | Ready to withdraw | `SUM(seller_earnings) WHERE status='completed' AND payout_status='pending' AND created_at < NOW() - 14 DAYS` |
| **Pending Clearance** | In 14-day holding | `SUM(seller_earnings) WHERE status='completed' AND payout_status='pending' AND created_at >= NOW() - 14 DAYS` |
| **Withdrawn** | Already paid out | `SUM(seller_earnings) WHERE payout_status='completed'` |

### 2. Transaction History Table

| Column | Source |
|--------|--------|
| Date | `transactions.created_at` |
| Buyer Name | `users.first_name` (privacy: first name + last initial) |
| Service Title | `book_orders.title` or `teacher_gigs.title` |
| Service Type | Class / Freelance (from `teacher_gigs.service_role`) |
| Order Amount | `transactions.total_amount` |
| Commission (%) | `transactions.seller_commission_rate` |
| Commission ($) | `transactions.seller_commission_amount` |
| Your Earnings | `transactions.seller_earnings` |
| Status | `transactions.status` + `transactions.payout_status` |
| Action | View Details / Download Invoice |

**Filters:**
- Date Range (Today, This Week, This Month, Custom)
- Service Type (All, Class, Freelance)
- Status (All, Completed, Pending, Paid)

**Pagination:** 20 per page

### 3. Invoice PDF Download

Generate professional PDF invoice for each transaction containing:
- Transaction ID
- Date
- Buyer Name (masked: John D.)
- Service Details
- Order Amount
- Commission Breakdown
- Net Earnings
- DreamCrowd Platform Info

### 4. Export Earnings Report

Excel export with all transaction data (similar to admin export).

---

## Database Changes

### 1. Add Payout Settings to TopSellerTag

```php
// Migration: add_payout_settings_to_top_seller_tags_table.php
$table->integer('holding_period_days')->default(14);
$table->decimal('minimum_withdrawal', 10, 2)->default(25.00);
$table->boolean('auto_payout_enabled')->default(true);
```

### 2. Transaction Model - Already Complete

Existing fields are sufficient:
- `seller_earnings` - Net amount for seller
- `seller_commission_rate` - Commission %
- `seller_commission_amount` - Commission $
- `status` - pending/completed/refunded/failed
- `payout_status` - pending/approved/completed/failed
- `payout_at` - When payout was completed

---

## Files to Create/Modify

### 1. New Controller

**File:** `app/Http/Controllers/SellerEarningsController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TopSellerTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SellerEarningsController extends Controller
{
    /**
     * Display Earnings & Payouts Dashboard
     */
    public function index(Request $request)
    {
        $sellerId = Auth::id();
        $settings = TopSellerTag::first();
        $holdingDays = $settings->holding_period_days ?? 14;

        // Calculate earnings
        $stats = [
            'total_earned' => Transaction::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->sum('seller_earnings'),

            'available' => Transaction::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->where('payout_status', 'pending')
                ->where('created_at', '<', now()->subDays($holdingDays))
                ->sum('seller_earnings'),

            'pending_clearance' => Transaction::where('seller_id', $sellerId)
                ->where('status', 'completed')
                ->where('payout_status', 'pending')
                ->where('created_at', '>=', now()->subDays($holdingDays))
                ->sum('seller_earnings'),

            'withdrawn' => Transaction::where('seller_id', $sellerId)
                ->where('payout_status', 'completed')
                ->sum('seller_earnings'),
        ];

        // Transaction history query
        $query = Transaction::with(['buyer', 'service', 'bookOrder'])
            ->where('seller_id', $sellerId)
            ->where('status', 'completed');

        // Apply filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }
        if ($request->filled('status')) {
            $query->where('payout_status', $request->status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('Teacher-Dashboard.earnings-payouts', compact(
            'stats',
            'transactions',
            'settings'
        ));
    }

    /**
     * Generate Invoice PDF
     */
    public function downloadInvoice($transactionId)
    {
        $transaction = Transaction::with(['buyer', 'seller', 'service', 'bookOrder'])
            ->where('seller_id', Auth::id())
            ->findOrFail($transactionId);

        $pdf = Pdf::loadView('invoices.seller-earnings-invoice', [
            'transaction' => $transaction
        ]);

        return $pdf->download('invoice-' . $transaction->id . '.pdf');
    }

    /**
     * Export Earnings Report
     */
    public function exportReport(Request $request)
    {
        return Excel::download(
            new SellerEarningsExport(Auth::id(), $request->all()),
            'earnings-report-' . date('Y-m-d') . '.xlsx'
        );
    }
}
```

### 2. New Routes

**File:** `routes/web.php`

```php
// Seller Earnings & Payouts Routes (inside Route::group for teacher middleware)
Route::controller(SellerEarningsController::class)->group(function () {
    Route::get('/seller/earnings', 'index')->name('seller.earnings');
    Route::get('/seller/earnings/invoice/{id}', 'downloadInvoice')->name('seller.earnings.invoice');
    Route::get('/seller/earnings/export', 'exportReport')->name('seller.earnings.export');
});
```

### 3. Update Sidebar Link

**File:** `resources/views/components/teacher-sidebar.blade.php`

Change:
```blade
<a href="Earning & Payouts.html">
```
To:
```blade
<a href="/seller/earnings">
```

### 4. New View (Replace Static Page)

**File:** `resources/views/Teacher-Dashboard/earnings-payouts.blade.php`

```blade
@extends('layouts.teacher')

@section('title', 'Earnings & Payouts')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/teacher-dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Earnings & Payouts</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-12 class-management">
            <i class="bx bx-dollar-circle"></i>
            <h5>Earnings & Payouts</h5>
        </div>
    </div>

    <!-- Earnings Cards -->
    <div class="row mb-4">
        <!-- Total Earned -->
        <div class="col-md-3">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('assets/teacher/asset/img/Total-earning-image.png') }}" width="50">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Total Earned</h6>
                            <h3 class="mb-0">${{ number_format($stats['total_earned'], 2) }}</h3>
                            <small>Lifetime</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available for Withdrawal -->
        <div class="col-md-3">
            <div class="card bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('assets/teacher/asset/img/Available-amount-image.png') }}" width="50">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Available</h6>
                            <h3 class="mb-0">${{ number_format($stats['available'], 2) }}</h3>
                            <small>Ready to withdraw</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Clearance -->
        <div class="col-md-3">
            <div class="card bg-gradient-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('assets/teacher/asset/img/class-booking-image.png') }}" width="50">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Pending Clearance</h6>
                            <h3 class="mb-0">${{ number_format($stats['pending_clearance'], 2) }}</h3>
                            <small>14-day holding</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Withdrawn -->
        <div class="col-md-3">
            <div class="card bg-gradient-secondary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('assets/teacher/asset/img/freelance-booking-image.png') }}" width="50">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Withdrawn</h6>
                            <h3 class="mb-0">${{ number_format($stats['withdrawn'], 2) }}</h3>
                            <small>Already paid</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Export -->
    <div class="row mb-3">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h5>Transaction History</h5>
            <div>
                <a href="{{ route('seller.earnings.export', request()->all()) }}" class="btn btn-success">
                    <i class="bx bx-download"></i> Export Report
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-3">
        <div class="col-md-12">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label>From Date</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label>To Date</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label>Service Type</label>
                    <select name="service_type" class="form-control">
                        <option value="">All</option>
                        <option value="service" {{ request('service_type') == 'service' ? 'selected' : '' }}>Freelance</option>
                        <option value="class" {{ request('service_type') == 'class' ? 'selected' : '' }}>Class</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label>Payout Status</label>
                    <select name="status" class="form-control">
                        <option value="">All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('seller.earnings') }}" class="btn btn-secondary ms-2">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Buyer</th>
                            <th>Service</th>
                            <th>Type</th>
                            <th>Order Total</th>
                            <th>Commission</th>
                            <th>Your Earnings</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txn)
                        <tr>
                            <td>{{ $txn->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($txn->buyer)
                                    {{ $txn->buyer->first_name }} {{ strtoupper(substr($txn->buyer->last_name ?? '', 0, 1)) }}.
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $txn->bookOrder->title ?? $txn->service->title ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $txn->service_type == 'class' ? 'info' : 'primary' }}">
                                    {{ ucfirst($txn->service_type) }}
                                </span>
                            </td>
                            <td>${{ number_format($txn->total_amount, 2) }}</td>
                            <td>
                                <span class="text-danger">
                                    -${{ number_format($txn->seller_commission_amount, 2) }}
                                    ({{ $txn->seller_commission_rate }}%)
                                </span>
                            </td>
                            <td>
                                <strong class="text-success">${{ number_format($txn->seller_earnings, 2) }}</strong>
                            </td>
                            <td>
                                @if($txn->payout_status == 'completed')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($txn->created_at < now()->subDays($settings->holding_period_days ?? 14))
                                    <span class="badge bg-primary">Available</span>
                                @else
                                    <span class="badge bg-warning">Clearing</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('seller.earnings.invoice', $txn->id) }}" class="btn btn-sm btn-outline-primary" title="Download Invoice">
                                    <i class="bx bx-download"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                No transactions found. Complete orders to see your earnings here.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $transactions->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
```

### 5. Invoice PDF Template

**File:** `resources/views/invoices/seller-earnings-invoice.blade.php`

```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaction->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { max-width: 150px; }
        .invoice-details { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f5f5f5; }
        .total-row { font-weight: bold; background-color: #e8f5e9; }
        .footer { margin-top: 30px; text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>EARNINGS INVOICE</h1>
        <p>DreamCrowd Marketplace</p>
    </div>

    <div class="invoice-details">
        <p><strong>Invoice #:</strong> INV-{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
        <p><strong>Date:</strong> {{ $transaction->created_at->format('F d, Y') }}</p>
        <p><strong>Seller:</strong> {{ $transaction->seller->first_name }} {{ $transaction->seller->last_name }}</p>
        <p><strong>Buyer:</strong> {{ $transaction->buyer->first_name }} {{ strtoupper(substr($transaction->buyer->last_name ?? '', 0, 1)) }}.</p>
    </div>

    <table>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Service: {{ $transaction->bookOrder->title ?? 'N/A' }}</td>
            <td>${{ number_format($transaction->total_amount, 2) }}</td>
        </tr>
        <tr>
            <td>Platform Commission ({{ $transaction->seller_commission_rate }}%)</td>
            <td>-${{ number_format($transaction->seller_commission_amount, 2) }}</td>
        </tr>
        <tr class="total-row">
            <td>Your Earnings</td>
            <td>${{ number_format($transaction->seller_earnings, 2) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>This is an automatically generated invoice from DreamCrowd.</p>
        <p>Transaction ID: {{ $transaction->stripe_transaction_id }}</p>
    </div>
</body>
</html>
```

### 6. Excel Export Class

**File:** `app/Exports/SellerEarningsExport.php`

```php
<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SellerEarningsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $sellerId;
    protected $filters;

    public function __construct($sellerId, $filters = [])
    {
        $this->sellerId = $sellerId;
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Transaction::with(['buyer', 'bookOrder'])
            ->where('seller_id', $this->sellerId)
            ->where('status', 'completed');

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Date', 'Transaction ID', 'Buyer', 'Service', 'Type',
            'Order Amount', 'Commission Rate', 'Commission Amount',
            'Your Earnings', 'Payout Status'
        ];
    }

    public function map($txn): array
    {
        return [
            $txn->created_at->format('Y-m-d'),
            $txn->id,
            $txn->buyer->first_name ?? 'N/A',
            $txn->bookOrder->title ?? 'N/A',
            $txn->service_type,
            $txn->total_amount,
            $txn->seller_commission_rate . '%',
            $txn->seller_commission_amount,
            $txn->seller_earnings,
            $txn->payout_status
        ];
    }
}
```

### 7. Migration for Payout Settings

**File:** `database/migrations/xxxx_add_payout_settings_to_top_seller_tags.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('top_seller_tags', function (Blueprint $table) {
            $table->integer('holding_period_days')->default(14)->after('buyer_commission_rate');
            $table->decimal('minimum_withdrawal', 10, 2)->default(25.00)->after('holding_period_days');
            $table->boolean('auto_payout_enabled')->default(true)->after('minimum_withdrawal');
        });
    }

    public function down(): void
    {
        Schema::table('top_seller_tags', function (Blueprint $table) {
            $table->dropColumn(['holding_period_days', 'minimum_withdrawal', 'auto_payout_enabled']);
        });
    }
};
```

---

## Implementation Order

| Step | Task | Files |
|------|------|-------|
| 1 | Create migration for payout settings | `migrations/xxxx_add_payout_settings.php` |
| 2 | Update TopSellerTag model | `app/Models/TopSellerTag.php` |
| 3 | Create SellerEarningsController | `app/Http/Controllers/SellerEarningsController.php` |
| 4 | Add routes | `routes/web.php` |
| 5 | Create earnings-payouts view | `resources/views/Teacher-Dashboard/earnings-payouts.blade.php` |
| 6 | Create invoice PDF template | `resources/views/invoices/seller-earnings-invoice.blade.php` |
| 7 | Create Excel export class | `app/Exports/SellerEarningsExport.php` |
| 8 | Update sidebar link | `resources/views/components/teacher-sidebar.blade.php` |
| 9 | Delete old static page | `Earning_And_Payouts.blade.php` |

---

## Critical Files Reference

| File | Purpose |
|------|---------|
| `app/Models/Transaction.php` | Existing - has seller_earnings, commissions, payout_status |
| `app/Models/TopSellerTag.php` | Existing - add payout settings |
| `app/Http/Controllers/SellerEarningsController.php` | New - main controller |
| `resources/views/Teacher-Dashboard/earnings-payouts.blade.php` | New - replace static page |
| `resources/views/invoices/seller-earnings-invoice.blade.php` | New - PDF template |
| `app/Exports/SellerEarningsExport.php` | New - Excel export |
| `routes/web.php` | Add routes |
| `resources/views/components/teacher-sidebar.blade.php` | Fix sidebar link |

---

## Phase 2 (Future) - Withdrawal System

**To be implemented later:**

1. **Withdrawal Request System**
   - Create `withdrawals` table
   - Create WithdrawalController
   - Add "Request Withdrawal" button
   - Admin approval workflow

2. **Stripe Connect Integration**
   - Add `stripe_account_id` to users table
   - Implement Stripe Connect onboarding
   - Automated payouts to connected accounts

3. **PayPal Integration**
   - Add `paypal_email` to users table
   - Implement PayPal Payouts API
   - Alternative withdrawal method

4. **Manual Bank Transfer**
   - Store bank details securely
   - Manual processing by admin

---

## Testing Checklist

- [ ] Earnings overview cards show correct amounts
- [ ] 14-day holding period calculation works
- [ ] Transaction history displays all completed orders
- [ ] Filters (date, type, status) work correctly
- [ ] Pagination works
- [ ] Invoice PDF generates correctly
- [ ] Excel export works with filters
- [ ] Sidebar link points to correct route
- [ ] Mobile responsive layout
- [ ] Commission breakdown is accurate