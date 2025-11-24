# 📋 Admin Payment Management - সম্পূর্ণ Implementation Plan

**প্রজেক্ট:** DreamCrowd Admin Panel - Payment, Payout & Refund Management Enhancement
**তারিখ:** ২৪ নভেম্বর ২০২৫
**স্ট্যাটাস:** Planning Phase (Approval Required)

---

## 📍 Overview

এই document টি DreamCrowd admin panel এর Payment Management section এর জন্য একটি সম্পূর্ণ implementation plan। এতে তিনটি main page রয়েছে:

1. **All Orders** (`/admin/all-orders`) - সব order এর list ও details
2. **Payout Details** (`/admin/payout-details`) - Seller payout management
3. **Refund Details** (`/admin/refund-details`) - Refund ও dispute management

এই plan টি PRD (Product Requirements Document) এবং বর্তমান system analysis এর উপর ভিত্তি করে তৈরি।

---

## 🔍 PART 1: Current State Analysis

### 1.1 All Orders Page (`/admin/all-orders`)

**Current Status:**
- ✅ **Route:** `/admin/all-orders` (working)
- ✅ **Controller Method:** `AdminController::allOrders()` (exists)
- ✅ **View File:** `resources/views/Admin-Dashboard/All-orders.blade.php` (exists)
- ⚠️ **Data:** Shows static/dummy data, not real database data
- ❌ **Filters:** Date filters are not functional
- ❌ **Search:** Search functionality not implemented
- ❌ **Actions:** No order detail view, no actions
- ❌ **Pagination:** Hardcoded, not dynamic

**Current Controller Method:**
```php
public function allOrders()
{
    $orders = \App\Models\BookOrder::with(['user', 'teacher', 'gig'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    $statusCounts = [
        'pending' => BookOrder::where('status', 0)->count(),
        'active' => BookOrder::where('status', 1)->count(),
        'delivered' => BookOrder::where('status', 2)->count(),
        'completed' => BookOrder::where('status', 3)->count(),
        'cancelled' => BookOrder::where('status', 4)->count(),
    ];

    return view('Admin-Dashboard.All-orders', compact('orders', 'statusCounts'));
}
```

**Current View Issues:**
- Shows hardcoded dummy data (Usama A., Hillary Clinton)
- No Blade loops to display actual $orders data
- No status badge logic based on real order status
- No links to order details
- Date filters are HTML only, no backend connection

---

### 1.2 Payout Details Page (`/admin/payout-details`)

**Current Status:**
- ✅ **Route:** `/admin/payout-details` (working)
- ✅ **Controller Method:** `AdminController::payoutDetails()` (exists)
- ✅ **View File:** `resources/views/Admin-Dashboard/payout-details.blade.php` (exists)
- ⚠️ **Data:** Shows static/dummy data, not real database data
- ❌ **Payout Actions:** No approve/process payout button
- ❌ **Statistics:** Stats cards missing
- ❌ **Seller Details:** No seller profile links
- ❌ **Filters:** No status filters (pending, completed, failed)

**Current Controller Method:**
```php
public function payoutDetails()
{
    $payouts = Transaction::where('payout_status', 'pending')
        ->where('status', 'completed')
        ->with(['seller', 'buyer'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    $stats = [
        'pending_amount' => Transaction::where('payout_status', 'pending')
            ->where('status', 'completed')
            ->sum('seller_earnings'),
        'pending_count' => Transaction::where('payout_status', 'pending')
            ->where('status', 'completed')
            ->count(),
        'completed_amount' => Transaction::where('payout_status', 'completed')
            ->sum('seller_earnings'),
        'completed_count' => Transaction::where('payout_status', 'completed')
            ->count(),
    ];

    return view('Admin-Dashboard.payout-details', compact('payouts', 'stats'));
}
```

**Good News:** Controller method অনেক ভালো! শুধু view file টা update করতে হবে।

---

### 1.3 Refund Details Page (`/admin/refund-details`)

**Current Status:**
- ✅ **Route:** `/admin/refund-details` (working)
- ✅ **Controller Method:** `AdminController::refundDetails()` (exists)
- ✅ **View File:** `resources/views/Admin-Dashboard/refund-details.blade.php` (exists)
- ⚠️ **Data:** Shows static/dummy data
- ❌ **Critical:** Approve/Reject buttons এর কোন functionality নেই
- ❌ **Dispute Info:** Buyer ও Seller reason show হয় না
- ❌ **Refund Type:** Full/Partial distinction নেই
- ❌ **Filters:** Pending, Approved, Rejected filter নেই

**Current Controller Method:**
```php
public function refundDetails()
{
    $refunds = Transaction::where('status', 'refunded')
        ->with(['seller', 'buyer', 'bookOrder'])
        ->orderBy('updated_at', 'desc')
        ->paginate(20);

    $stats = [
        'total_refunded' => Transaction::where('status', 'refunded')
            ->sum('total_amount'),
        'refund_count' => Transaction::where('status', 'refunded')
            ->count(),
        'pending_disputes' => DisputeOrder::where('status', 0)->count(),
    ];

    return view('Admin-Dashboard.refund-details', compact('refunds', 'stats'));
}
```

**Problem:** এই method শুধু refunded transactions show করে। কিন্তু **pending disputes** show করে না যেগুলো admin কে approve/reject করতে হবে!

---

## 🎯 PART 2: Required Changes - প্রতিটি Page এর জন্য

### 2.1 All Orders Page - Required Changes

#### **A. Controller Updates (`AdminController::allOrders()`)**

**যা যোগ করতে হবে:**

1. **Advanced Filters:**
   - Date range filter (today, yesterday, last week, last month, custom)
   - Status filter (all, pending, active, delivered, completed, cancelled)
   - Service type filter (Class, Freelance)
   - Search by buyer name, seller name, order ID, service title

2. **Statistics Cards:**
   - Total orders (all time)
   - Pending orders count
   - Active orders count
   - Completed orders (this month)
   - Cancelled orders (this month)
   - Total revenue (completed orders)

3. **Order Export:**
   - Export to Excel/CSV functionality
   - Export filtered orders

**New Controller Method:**
```php
public function allOrders(Request $request)
{
    // Auth check
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    // Base query with relationships
    $query = BookOrder::with(['user', 'teacher', 'gig', 'transaction']);

    // FILTER 1: Date Range
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('created_at', [
            $request->date_from . ' 00:00:00',
            $request->date_to . ' 23:59:59'
        ]);
    } elseif ($request->filled('date_preset')) {
        switch ($request->date_preset) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', today()->subDay());
                break;
            case 'last_week':
                $query->whereBetween('created_at', [now()->subWeek(), now()]);
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month);
                break;
        }
    }

    // FILTER 2: Status
    if ($request->filled('status') && $request->status !== 'all') {
        $statusMap = [
            'pending' => 0,
            'active' => 1,
            'delivered' => 2,
            'completed' => 3,
            'cancelled' => 4,
        ];
        $query->where('status', $statusMap[$request->status]);
    }

    // FILTER 3: Service Type
    if ($request->filled('service_type') && $request->service_type !== 'all') {
        $query->whereHas('gig', function($q) use ($request) {
            $q->where('service_role', $request->service_type);
        });
    }

    // FILTER 4: Search
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            // Search by order ID
            $q->where('id', 'like', "%{$search}%")
              // Search by buyer name
              ->orWhereHas('user', function($userQuery) use ($search) {
                  $userQuery->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
              })
              // Search by seller name
              ->orWhereHas('teacher', function($teacherQuery) use ($search) {
                  $teacherQuery->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%")
                              ->orWhere('email', 'like', "%{$search}%");
              })
              // Search by service title
              ->orWhere('title', 'like', "%{$search}%");
        });
    }

    // Get paginated orders
    $orders = $query->orderBy('created_at', 'desc')->paginate(20);

    // Status counts for filter badges
    $statusCounts = [
        'all' => BookOrder::count(),
        'pending' => BookOrder::where('status', 0)->count(),
        'active' => BookOrder::where('status', 1)->count(),
        'delivered' => BookOrder::where('status', 2)->count(),
        'completed' => BookOrder::where('status', 3)->count(),
        'cancelled' => BookOrder::where('status', 4)->count(),
    ];

    // Statistics for cards
    $stats = [
        'total_orders' => BookOrder::count(),
        'pending_orders' => BookOrder::where('status', 0)->count(),
        'active_orders' => BookOrder::where('status', 1)->count(),
        'completed_this_month' => BookOrder::where('status', 3)
            ->whereMonth('created_at', now()->month)
            ->count(),
        'cancelled_this_month' => BookOrder::where('status', 4)
            ->whereMonth('created_at', now()->month)
            ->count(),
        'total_revenue' => BookOrder::where('status', 3)
            ->sum('finel_price'),
        'this_month_revenue' => BookOrder::where('status', 3)
            ->whereMonth('created_at', now()->month)
            ->sum('finel_price'),
    ];

    return view('Admin-Dashboard.All-orders', compact('orders', 'statusCounts', 'stats'));
}
```

#### **B. View File Updates (`All-orders.blade.php`)**

**যা পরিবর্তন করতে হবে:**

1. **Statistics Cards Section (Add before table):**
```blade
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <h2 class="stats-number">{{ number_format($stats['total_orders']) }}</h2>
                <small class="text-muted">All time</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Active Orders</h5>
                <h2 class="stats-number">{{ number_format($stats['active_orders']) }}</h2>
                <small class="text-success">In progress</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Completed (This Month)</h5>
                <h2 class="stats-number">{{ number_format($stats['completed_this_month']) }}</h2>
                <small class="text-primary">{{ now()->format('F Y') }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Revenue</h5>
                <h2 class="stats-number">${{ number_format($stats['this_month_revenue'], 2) }}</h2>
                <small class="text-muted">This month</small>
            </div>
        </div>
    </div>
</div>
```

2. **Filter Section (Replace existing filter section):**
```blade
<!-- Filters -->
<div class="date-section">
    <form method="GET" action="{{ route('admin.all-orders') }}" id="filterForm">
        <div class="row mb-3">
            <!-- Date Preset Dropdown -->
            <div class="col-md-3">
                <label class="form-label">Date Range</label>
                <select class="form-select" name="date_preset" id="datePreset">
                    <option value="">All Time</option>
                    <option value="today" {{ request('date_preset') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('date_preset') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="last_week" {{ request('date_preset') == 'last_week' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="last_month" {{ request('date_preset') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                    <option value="custom" {{ request('date_from') ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>

            <!-- Custom Date Range (Hidden by default) -->
            <div class="col-md-2" id="customDateFrom" style="display: {{ request('date_from') ? 'block' : 'none' }};">
                <label class="form-label">From</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2" id="customDateTo" style="display: {{ request('date_from') ? 'block' : 'none' }};">
                <label class="form-label">To</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
            </div>

            <!-- Status Filter -->
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="all">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending ({{ $statusCounts['pending'] }})
                    </option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                        Active ({{ $statusCounts['active'] }})
                    </option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                        Delivered ({{ $statusCounts['delivered'] }})
                    </option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                        Completed ({{ $statusCounts['completed'] }})
                    </option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                        Cancelled ({{ $statusCounts['cancelled'] }})
                    </option>
                </select>
            </div>

            <!-- Service Type Filter -->
            <div class="col-md-2">
                <label class="form-label">Service Type</label>
                <select class="form-select" name="service_type">
                    <option value="all">All Types</option>
                    <option value="Class" {{ request('service_type') == 'Class' ? 'selected' : '' }}>Class</option>
                    <option value="Freelance" {{ request('service_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                </select>
            </div>

            <!-- Filter & Reset Buttons -->
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bx bx-filter"></i> Filter
                </button>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="row">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control"
                       placeholder="Search by Order ID, Buyer, Seller, or Service..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.all-orders') }}" class="btn btn-secondary w-100">
                    <i class="bx bx-reset"></i> Reset
                </a>
            </div>
        </div>
    </form>
</div>
```

3. **Table Body (Replace hardcoded data with dynamic data):**
```blade
<tbody>
    @forelse($orders as $order)
    <tr>
        <!-- Seller -->
        <td>
            <div class="d-flex gap-2 align-items-center">
                @if($order->teacher && $order->teacher->profile_pic)
                    <img src="/uploads/user/{{ $order->teacher->profile_pic }}"
                         alt="" class="rounded-circle" width="35" height="35">
                @else
                    <img src="/assets/admin/asset/img/Ellipse 348.svg" alt="" width="35">
                @endif
                <span>{{ $order->teacher ? $order->teacher->first_name . ' ' . $order->teacher->last_name : 'N/A' }}</span>
            </div>
        </td>

        <!-- Buyer -->
        <td>
            <div class="d-flex gap-2 align-items-center">
                @if($order->user && $order->user->profile_pic)
                    <img src="/uploads/user/{{ $order->user->profile_pic }}"
                         alt="" class="rounded-circle" width="35" height="35">
                @else
                    <img src="/assets/admin/asset/img/all-orders.svg" alt="" width="35">
                @endif
                <span>{{ $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'N/A' }}</span>
            </div>
        </td>

        <!-- Service Type -->
        <td class="online-class">
            {{ $order->gig ? $order->gig->service_role : 'N/A' }}
            @if($order->gig && $order->gig->service_type)
                <br><small class="text-muted">{{ $order->gig->service_type }}</small>
            @endif
        </td>

        <!-- Freelance Type -->
        <td>{{ $order->freelance_service ?: 'N/A' }}</td>

        <!-- Class Type -->
        <td>
            @if($order->frequency == 1)
                One-time
            @else
                Subscription ({{ $order->frequency }} classes)
            @endif
        </td>

        <!-- Service Title -->
        <td class="service-decs">{{ Str::limit($order->title, 50) }}</td>

        <!-- Group Type -->
        <td class="group-type">{{ $order->group_type ?: 'N/A' }}</td>

        <!-- Start Date -->
        <td class="refund-date">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</td>

        <!-- Due Date -->
        <td class="refund-date">
            @if($order->action_date)
                {{ \Carbon\Carbon::parse($order->action_date)->format('M d, Y') }}
            @else
                N/A
            @endif
        </td>

        <!-- Price -->
        <td class="refund-date">${{ number_format($order->finel_price, 2) }}</td>

        <!-- Extend Date -->
        <td class="refund-date">
            @if($order->action_date)
                {{ \Carbon\Carbon::parse($order->created_at)->diffInDays(\Carbon\Carbon::parse($order->action_date)) }} days
            @else
                N/A
            @endif
        </td>

        <!-- Status -->
        <td class="status">
            <h5>
                @switch($order->status)
                    @case(0)
                        <span class="badge bg-warning text-dark">Pending</span>
                        @break
                    @case(1)
                        <span class="badge bg-primary">Active</span>
                        @break
                    @case(2)
                        <span class="badge bg-info text-dark">Delivered</span>
                        @break
                    @case(3)
                        <span class="badge bg-success">Completed</span>
                        @break
                    @case(4)
                        <span class="badge bg-danger">Cancelled</span>
                        @break
                    @default
                        <span class="badge bg-secondary">Unknown</span>
                @endswitch

                @if($order->refund == 1)
                    <br><small class="badge bg-warning mt-1">Refunded</small>
                @endif
            </h5>
        </td>

        <!-- Actions -->
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-light dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.order.details', $order->id) }}">
                            <i class="bx bx-show"></i> View Details
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.invoice.download', $order->id) }}">
                            <i class="bx bx-download"></i> Download Invoice
                        </a>
                    </li>
                    @if($order->status != 4)
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                               onclick="cancelOrder({{ $order->id }})">
                                <i class="bx bx-x-circle"></i> Cancel Order
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="13" class="text-center py-4">
            <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
            <p class="text-muted mt-2">No orders found matching your filters.</p>
        </td>
    </tr>
    @endforelse
</tbody>
```

4. **Pagination (Replace hardcoded pagination):**
```blade
<!-- Pagination -->
<div class="demo">
    {{ $orders->appends(request()->query())->links() }}
</div>
```

5. **JavaScript for Date Filter:**
```blade
<script>
document.getElementById('datePreset').addEventListener('change', function() {
    const customFrom = document.getElementById('customDateFrom');
    const customTo = document.getElementById('customDateTo');

    if (this.value === 'custom') {
        customFrom.style.display = 'block';
        customTo.style.display = 'block';
    } else {
        customFrom.style.display = 'none';
        customTo.style.display = 'none';
    }
});
</script>
```

---

### 2.2 Payout Details Page - Required Changes

#### **A. Controller Updates (`AdminController::payoutDetails()`)**

**Current method ভালো আছে, শুধু minor improvements:**

```php
public function payoutDetails(Request $request)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    // Base query
    $query = Transaction::with(['seller', 'buyer', 'bookOrder']);

    // FILTER 1: Payout Status
    $payoutStatus = $request->get('payout_status', 'pending');

    if ($payoutStatus !== 'all') {
        $query->where('payout_status', $payoutStatus);
    }

    // Only show completed transactions (orders that are ready for payout)
    $query->where('status', 'completed');

    // FILTER 2: Date Range
    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('created_at', [
            $request->date_from . ' 00:00:00',
            $request->date_to . ' 23:59:59'
        ]);
    }

    // FILTER 3: Search by seller name/email
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('seller', function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    $payouts = $query->orderBy('created_at', 'desc')->paginate(20);

    // Statistics
    $stats = [
        'pending_amount' => Transaction::where('payout_status', 'pending')
            ->where('status', 'completed')
            ->sum('seller_earnings'),
        'pending_count' => Transaction::where('payout_status', 'pending')
            ->where('status', 'completed')
            ->count(),
        'completed_amount' => Transaction::where('payout_status', 'completed')
            ->sum('seller_earnings'),
        'completed_count' => Transaction::where('payout_status', 'completed')
            ->count(),
        'on_hold_amount' => Transaction::where('payout_status', 'on_hold')
            ->sum('seller_earnings'),
        'on_hold_count' => Transaction::where('payout_status', 'on_hold')
            ->count(),
        'failed_count' => Transaction::where('payout_status', 'failed')
            ->count(),
    ];

    // Seller-wise earnings summary (for pending payouts)
    $sellerSummary = Transaction::where('payout_status', 'pending')
        ->where('status', 'completed')
        ->selectRaw('seller_id, SUM(seller_earnings) as total_earnings, COUNT(*) as order_count')
        ->groupBy('seller_id')
        ->with('seller:id,first_name,last_name,email')
        ->get();

    return view('Admin-Dashboard.payout-details', compact('payouts', 'stats', 'sellerSummary'));
}
```

#### **B. New Controller Method: Process Payout**

```php
/**
 * Mark payout as completed (for manual payouts)
 * In future: Integrate with Stripe Connect for automatic payouts
 */
public function processPayout(Request $request, $transactionId)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $transaction = Transaction::findOrFail($transactionId);

    // Validate payout can be processed
    if ($transaction->payout_status !== 'pending') {
        return back()->with('error', 'This payout has already been processed.');
    }

    if ($transaction->status !== 'completed') {
        return back()->with('error', 'Order must be completed before payout.');
    }

    // Update payout status
    $transaction->payout_status = 'completed';
    $transaction->payout_date = now();
    $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Payout processed by admin: " . Auth::user()->email;
    $transaction->save();

    // Send notification to seller
    $this->notificationService->send(
        userId: $transaction->seller_id,
        type: 'payout_completed',
        title: 'Payout Processed',
        message: "Your earnings of $" . number_format($transaction->seller_earnings, 2) . " have been processed.",
        data: [
            'transaction_id' => $transaction->id,
            'amount' => $transaction->seller_earnings,
            'payout_date' => now()->toDateString()
        ],
        sendEmail: true,
        orderId: $transaction->stripe_transaction_id
    );

    return back()->with('success', 'Payout marked as completed successfully.');
}
```

#### **C. View File Updates (`payout-details.blade.php`)**

**যা যোগ করতে হবে:**

1. **Statistics Cards (Add at top):**
```blade
<!-- Payout Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card bg-warning">
            <div class="card-body text-white">
                <h6 class="card-title">⏳ Pending Payouts</h6>
                <h2 class="stats-number">${{ number_format($stats['pending_amount'], 2) }}</h2>
                <small>{{ $stats['pending_count'] }} transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-success">
            <div class="card-body text-white">
                <h6 class="card-title">✅ Completed Payouts</h6>
                <h2 class="stats-number">${{ number_format($stats['completed_amount'], 2) }}</h2>
                <small>{{ $stats['completed_count'] }} transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-info">
            <div class="card-body text-white">
                <h6 class="card-title">⏸️ On Hold</h6>
                <h2 class="stats-number">${{ number_format($stats['on_hold_amount'], 2) }}</h2>
                <small>{{ $stats['on_hold_count'] }} transactions</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-danger">
            <div class="card-body text-white">
                <h6 class="card-title">❌ Failed</h6>
                <h2 class="stats-number">{{ $stats['failed_count'] }}</h2>
                <small>Requires attention</small>
            </div>
        </div>
    </div>
</div>
```

2. **Filters:**
```blade
<!-- Filters -->
<div class="date-section mb-4">
    <form method="GET" action="{{ route('admin.payout-details') }}">
        <div class="row">
            <!-- Status Filter Tabs -->
            <div class="col-md-12 mb-3">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.payout-details', ['payout_status' => 'all']) }}"
                       class="btn {{ request('payout_status', 'pending') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                        All
                    </a>
                    <a href="{{ route('admin.payout-details', ['payout_status' => 'pending']) }}"
                       class="btn {{ request('payout_status', 'pending') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Pending ({{ $stats['pending_count'] }})
                    </a>
                    <a href="{{ route('admin.payout-details', ['payout_status' => 'completed']) }}"
                       class="btn {{ request('payout_status') == 'completed' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Completed ({{ $stats['completed_count'] }})
                    </a>
                    <a href="{{ route('admin.payout-details', ['payout_status' => 'on_hold']) }}"
                       class="btn {{ request('payout_status') == 'on_hold' ? 'btn-primary' : 'btn-outline-primary' }}">
                        On Hold ({{ $stats['on_hold_count'] }})
                    </a>
                    <a href="{{ route('admin.payout-details', ['payout_status' => 'failed']) }}"
                       class="btn {{ request('payout_status') == 'failed' ? 'btn-primary' : 'btn-outline-primary' }}">
                        Failed ({{ $stats['failed_count'] }})
                    </a>
                </div>
            </div>

            <!-- Search & Date Range -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="Search by seller name or email..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_from" class="form-control"
                       placeholder="From Date" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_to" class="form-control"
                       placeholder="To Date" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bx bx-filter"></i> Filter
                </button>
            </div>
        </div>
    </form>
</div>
```

3. **Table with Dynamic Data:**
```blade
<table class="table">
    <thead>
        <tr class="text-nowrap">
            <th>Seller</th>
            <th>Order ID</th>
            <th>Service</th>
            <th>Order Amount</th>
            <th>Commission</th>
            <th>Seller Earnings</th>
            <th>Order Date</th>
            <th>Payout Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($payouts as $payout)
        <tr>
            <!-- Seller -->
            <td>
                <div class="d-flex gap-2 align-items-center">
                    @if($payout->seller && $payout->seller->profile_pic)
                        <img src="/uploads/user/{{ $payout->seller->profile_pic }}"
                             alt="" class="rounded-circle" width="35" height="35">
                    @else
                        <div class="avatar-placeholder">{{ substr($payout->seller->first_name, 0, 1) }}</div>
                    @endif
                    <div>
                        <strong>{{ $payout->seller->first_name }} {{ $payout->seller->last_name }}</strong>
                        <br><small class="text-muted">{{ $payout->seller->email }}</small>
                    </div>
                </div>
            </td>

            <!-- Order ID -->
            <td>
                <a href="{{ route('admin.order.details', $payout->bookOrder->id ?? '#') }}">
                    #{{ $payout->bookOrder->id ?? 'N/A' }}
                </a>
            </td>

            <!-- Service -->
            <td>
                <div>
                    {{ Str::limit($payout->bookOrder->title ?? 'N/A', 40) }}
                    <br><small class="text-muted">
                        {{ $payout->bookOrder->gig->service_role ?? 'N/A' }}
                    </small>
                </div>
            </td>

            <!-- Order Amount -->
            <td>${{ number_format($payout->total_amount, 2) }}</td>

            <!-- Commission -->
            <td>
                <span class="text-danger">
                    -${{ number_format($payout->seller_commission_amount, 2) }}
                </span>
                <br><small class="text-muted">({{ number_format($payout->seller_commission_rate, 1) }}%)</small>
            </td>

            <!-- Seller Earnings -->
            <td>
                <strong class="text-success">
                    ${{ number_format($payout->seller_earnings, 2) }}
                </strong>
            </td>

            <!-- Order Date -->
            <td>{{ \Carbon\Carbon::parse($payout->created_at)->format('M d, Y') }}</td>

            <!-- Payout Status -->
            <td>
                @switch($payout->payout_status)
                    @case('pending')
                        <span class="badge bg-warning text-dark">⏳ Pending</span>
                        @break
                    @case('completed')
                        <span class="badge bg-success">✅ Completed</span>
                        <br><small class="text-muted">
                            {{ $payout->payout_date ? \Carbon\Carbon::parse($payout->payout_date)->format('M d, Y') : '' }}
                        </small>
                        @break
                    @case('on_hold')
                        <span class="badge bg-info">⏸️ On Hold</span>
                        @break
                    @case('failed')
                        <span class="badge bg-danger">❌ Failed</span>
                        @break
                    @default
                        <span class="badge bg-secondary">Unknown</span>
                @endswitch
            </td>

            <!-- Actions -->
            <td>
                @if($payout->payout_status == 'pending')
                    <form method="POST" action="{{ route('admin.payout.process', $payout->id) }}"
                          style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success"
                                onclick="return confirm('Mark this payout as completed?')">
                            <i class="bx bx-check"></i> Mark Paid
                        </button>
                    </form>
                @else
                    <button class="btn btn-sm btn-secondary" disabled>
                        <i class="bx bx-check-double"></i> Paid
                    </button>
                @endif

                <a href="{{ route('admin.transaction.details', $payout->id) }}"
                   class="btn btn-sm btn-light">
                    <i class="bx bx-show"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center py-4">
                <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                <p class="text-muted mt-2">No payouts found.</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
```

4. **Seller Summary Section (Optional - at bottom):**
```blade
<!-- Seller-wise Summary (for pending payouts) -->
@if(request('payout_status', 'pending') == 'pending' && $sellerSummary->isNotEmpty())
<div class="card mt-4">
    <div class="card-header">
        <h5>📊 Seller-wise Pending Payouts Summary</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Seller</th>
                        <th>Orders</th>
                        <th>Total Earnings</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellerSummary as $summary)
                    <tr>
                        <td>
                            {{ $summary->seller->first_name }} {{ $summary->seller->last_name }}
                            <br><small class="text-muted">{{ $summary->seller->email }}</small>
                        </td>
                        <td>{{ $summary->order_count }} orders</td>
                        <td><strong>${{ number_format($summary->total_earnings, 2) }}</strong></td>
                        <td>
                            <button class="btn btn-sm btn-primary">
                                <i class="bx bx-send"></i> Process All
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
```

---

### 2.3 Refund Details Page - CRITICAL Changes

এই page টিই সবচেয়ে গুরুত্বপূর্ণ কারণ এখানে admin কে refund approve/reject করতে হবে।

#### **A. Controller - MAJOR Rewrite Needed**

**Problem:** Current method শুধু already refunded transactions show করে। কিন্তু **pending disputes** show করে না!

**Solution:** নতুন method যা disputes show করবে:

```php
public function refundDetails(Request $request)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    // Determine what to show: disputes or refunds
    $view = $request->get('view', 'pending_disputes');

    if ($view === 'pending_disputes') {
        // Show pending disputes that need admin action
        $query = DisputeOrder::with([
            'user',
            'order.user',
            'order.teacher',
            'order.gig'
        ])->where('status', 0); // Pending

        // Only show disputes where both buyer and seller have disputed
        // OR where user disputed and 48 hours passed (auto-refund eligible)
        $query->whereHas('order', function($q) {
            // Seller has counter-disputed (needs admin review)
            $q->where(function($subQ) {
                $subQ->where('user_dispute', 1)
                     ->where('teacher_dispute', 1);
            })
            // OR auto-refund hasn't been processed yet but should be reviewed
            ->orWhere(function($subQ) {
                $subQ->where('user_dispute', 1)
                     ->where('teacher_dispute', 0)
                     ->where('auto_dispute_processed', 0);
            });
        });

    } elseif ($view === 'refunded') {
        // Show already refunded orders
        $query = DisputeOrder::with([
            'user',
            'order.user',
            'order.teacher',
            'order.gig'
        ])->where('status', 1); // Approved/Refunded

    } elseif ($view === 'rejected') {
        // Show rejected refund requests
        $query = DisputeOrder::with([
            'user',
            'order.user',
            'order.teacher',
            'order.gig'
        ])->where('status', 2); // Rejected

    } else {
        // All disputes
        $query = DisputeOrder::with([
            'user',
            'order.user',
            'order.teacher',
            'order.gig'
        ]);
    }

    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('reason', 'like', "%{$search}%")
              ->orWhereHas('order', function($orderQ) use ($search) {
                  $orderQ->where('id', 'like', "%{$search}%")
                         ->orWhere('title', 'like', "%{$search}%");
              });
        });
    }

    $disputes = $query->orderBy('created_at', 'desc')->paginate(20);

    // Statistics
    $stats = [
        'pending_disputes' => DisputeOrder::where('status', 0)->count(),
        'refunded' => DisputeOrder::where('status', 1)->count(),
        'rejected' => DisputeOrder::where('status', 2)->count(),
        'total_refunded_amount' => DisputeOrder::where('status', 1)->sum('amount'),
        'pending_refund_amount' => DisputeOrder::where('status', 0)->sum('amount'),
    ];

    return view('Admin-Dashboard.refund-details', compact('disputes', 'stats', 'view'));
}
```

#### **B. New Controller Methods: Approve & Reject Refund**

```php
/**
 * Approve Refund Request (Admin Action)
 */
public function approveRefund(Request $request, $disputeId)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    Stripe::setApiKey(env('STRIPE_SECRET'));

    $dispute = DisputeOrder::with('order')->findOrFail($disputeId);
    $order = $dispute->order;

    // Validate
    if ($dispute->status != 0) {
        return back()->with('error', 'This dispute has already been processed.');
    }

    if (!$order) {
        return back()->with('error', 'Order not found.');
    }

    DB::beginTransaction();

    try {
        // Process Stripe refund
        $paymentIntent = PaymentIntent::retrieve($order->payment_id);

        if ($dispute->refund_type == 0) {
            // FULL REFUND
            if (in_array($paymentIntent->status, ['requires_capture', 'requires_confirmation'])) {
                $paymentIntent->cancel();
            } elseif ($paymentIntent->status === 'succeeded') {
                Refund::create(['payment_intent' => $order->payment_id]);
            }

            $refundAmount = $order->finel_price;

        } else {
            // PARTIAL REFUND
            $refundAmount = floatval($request->input('refund_amount', $dispute->amount));

            if (!$refundAmount || $refundAmount > $order->finel_price) {
                return back()->with('error', 'Invalid refund amount.');
            }

            if ($paymentIntent->status === 'requires_capture') {
                $paymentIntent->capture();
            }

            if ($paymentIntent->status === 'succeeded') {
                Refund::create([
                    'payment_intent' => $order->payment_id,
                    'amount' => round($refundAmount * 100)
                ]);
            }
        }

        // Update dispute
        $dispute->status = 1; // Approved
        $dispute->amount = $refundAmount;
        $dispute->save();

        // Update order
        $order->refund = 1;
        $order->payment_status = 'refunded';
        $order->status = 4; // Cancelled
        $order->save();

        // Update transaction
        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        if ($transaction) {
            if ($dispute->refund_type == 0) {
                // Full refund
                $transaction->markAsRefunded();
                $transaction->payout_status = 'failed';
            } else {
                // Partial refund - recalculate
                $remainingAmount = $transaction->total_amount - $refundAmount;
                $newSellerCommission = ($remainingAmount * $transaction->seller_commission_rate) / 100;
                $newBuyerCommission = ($remainingAmount * $transaction->buyer_commission_rate) / 100;

                $transaction->coupon_discount += $refundAmount;
                $transaction->seller_commission_amount = $newSellerCommission;
                $transaction->buyer_commission_amount = $newBuyerCommission;
                $transaction->total_admin_commission = $newSellerCommission + $newBuyerCommission;
                $transaction->seller_earnings = $remainingAmount - $newSellerCommission;
            }

            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Admin approved refund: $" . $refundAmount;
            $transaction->save();
        }

        DB::commit();

        // Send notifications
        $refundType = $dispute->refund_type == 0 ? 'Full' : 'Partial';

        // To Buyer
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'refund_approved',
            title: 'Refund Approved ✅',
            message: "Your refund request has been approved by admin. {$refundType} refund of $" . number_format($refundAmount, 2) . " has been processed.",
            data: [
                'dispute_id' => $dispute->id,
                'order_id' => $order->id,
                'refund_amount' => $refundAmount,
                'refund_type' => $refundType
            ],
            sendEmail: true,
            orderId: $order->id
        );

        // To Seller
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'refund_approved',
            title: 'Refund Approved by Admin',
            message: "Admin has approved the refund request for order #{$order->id}. {$refundType} refund of $" . number_format($refundAmount, 2) . " has been issued.",
            data: [
                'dispute_id' => $dispute->id,
                'order_id' => $order->id,
                'refund_amount' => $refundAmount,
                'refund_type' => $refundType
            ],
            sendEmail: true,
            orderId: $order->id
        );

        return back()->with('success', 'Refund approved successfully. ' . ucfirst($refundType) . ' refund of $' . number_format($refundAmount, 2) . ' has been processed.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Admin refund approval failed: ' . $e->getMessage());
        return back()->with('error', 'Refund processing failed: ' . $e->getMessage());
    }
}

/**
 * Reject Refund Request (Admin Action)
 */
public function rejectRefund(Request $request, $disputeId)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $dispute = DisputeOrder::with('order')->findOrFail($disputeId);
    $order = $dispute->order;

    // Validate
    if ($dispute->status != 0) {
        return back()->with('error', 'This dispute has already been processed.');
    }

    $rejectReason = $request->input('reject_reason', 'Admin decision after review');

    DB::beginTransaction();

    try {
        // Update dispute
        $dispute->status = 2; // Rejected
        $dispute->admin_notes = $rejectReason;
        $dispute->save();

        // Update order - back to delivered or active
        $order->user_dispute = 0;
        $order->teacher_dispute = 0;

        // If order was cancelled due to dispute, revert to previous status
        if ($order->status == 4) {
            $order->status = 2; // Back to Delivered
        }
        $order->save();

        // Update transaction - release payment for seller
        $transaction = Transaction::where('buyer_id', $order->user_id)
            ->where('seller_id', $order->teacher_id)
            ->first();

        if ($transaction) {
            $transaction->payout_status = 'approved'; // Seller will get paid
            $transaction->status = 'completed';
            $transaction->notes .= "\n[" . now()->format('Y-m-d H:i:s') . "] Admin rejected refund request. Payment released to seller.";
            $transaction->save();
        }

        DB::commit();

        // Send notifications
        // To Buyer
        $this->notificationService->send(
            userId: $order->user_id,
            type: 'refund_rejected',
            title: 'Refund Request Rejected ❌',
            message: "Your refund request has been reviewed and rejected by admin. Reason: {$rejectReason}",
            data: [
                'dispute_id' => $dispute->id,
                'order_id' => $order->id,
                'reason' => $rejectReason
            ],
            sendEmail: true,
            orderId: $order->id
        );

        // To Seller
        $this->notificationService->send(
            userId: $order->teacher_id,
            type: 'refund_rejected',
            title: 'Refund Request Rejected - Payment Released',
            message: "Admin has rejected the refund request for order #{$order->id}. Your earnings have been released for payout.",
            data: [
                'dispute_id' => $dispute->id,
                'order_id' => $order->id,
                'reason' => $rejectReason
            ],
            sendEmail: true,
            orderId: $order->id
        );

        return back()->with('success', 'Refund request rejected successfully. Payment released to seller.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Admin refund rejection failed: ' . $e->getMessage());
        return back()->with('error', 'Rejection processing failed: ' . $e->getMessage());
    }
}
```

#### **C. View File - Complete Rewrite**

এই page টি সম্পূর্ণ নতুন করে তৈরি করতে হবে কারণ এখানে dispute review করার জন্য অনেক বেশি information দরকার।

**Full view code:** (This is a detailed view - I'll provide a summary structure)

```blade
{{-- Statistics Cards --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card bg-warning">
            <div class="card-body text-white">
                <h6>⏳ Pending Disputes</h6>
                <h2>{{ $stats['pending_disputes'] }}</h2>
                <small>${{ number_format($stats['pending_refund_amount'], 2) }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-success">
            <div class="card-body text-white">
                <h6>✅ Refunded</h6>
                <h2>{{ $stats['refunded'] }}</h2>
                <small>${{ number_format($stats['total_refunded_amount'], 2) }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-danger">
            <div class="card-body text-white">
                <h6>❌ Rejected</h6>
                <h2>{{ $stats['rejected'] }}</h2>
                <small>Seller payments released</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stats-card bg-info">
            <div class="card-body text-white">
                <h6>📊 Total Disputes</h6>
                <h2>{{ $stats['pending_disputes'] + $stats['refunded'] + $stats['rejected'] }}</h2>
                <small>All time</small>
            </div>
        </div>
    </div>
</div>

{{-- View Tabs --}}
<div class="btn-group mb-3" role="group">
    <a href="{{ route('admin.refund-details', ['view' => 'pending_disputes']) }}"
       class="btn {{ $view == 'pending_disputes' ? 'btn-primary' : 'btn-outline-primary' }}">
        ⏳ Pending ({{ $stats['pending_disputes'] }})
    </a>
    <a href="{{ route('admin.refund-details', ['view' => 'refunded']) }}"
       class="btn {{ $view == 'refunded' ? 'btn-primary' : 'btn-outline-primary' }}">
        ✅ Refunded ({{ $stats['refunded'] }})
    </a>
    <a href="{{ route('admin.refund-details', ['view' => 'rejected']) }}"
       class="btn {{ $view == 'rejected' ? 'btn-primary' : 'btn-outline-primary' }}">
        ❌ Rejected ({{ $stats['rejected'] }})
    </a>
    <a href="{{ route('admin.refund-details', ['view' => 'all']) }}"
       class="btn {{ $view == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
        All
    </a>
</div>

{{-- Disputes Table --}}
<table class="table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Service</th>
            <th>Buyer</th>
            <th>Seller</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Disputed By</th>
            <th>Filed On</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($disputes as $dispute)
        <tr>
            <td>
                <a href="{{ route('admin.order.details', $dispute->order->id) }}">
                    #{{ $dispute->order->id }}
                </a>
            </td>
            <td>{{ Str::limit($dispute->order->title, 30) }}</td>
            <td>
                {{ $dispute->order->user->first_name }} {{ $dispute->order->user->last_name }}
                <br><small class="text-muted">{{ $dispute->order->user->email }}</small>
            </td>
            <td>
                {{ $dispute->order->teacher->first_name }} {{ $dispute->order->teacher->last_name }}
                <br><small class="text-muted">{{ $dispute->order->teacher->email }}</small>
            </td>
            <td>
                <strong class="text-danger">${{ number_format($dispute->amount, 2) }}</strong>
            </td>
            <td>
                @if($dispute->refund_type == 0)
                    <span class="badge bg-danger">Full Refund</span>
                @else
                    <span class="badge bg-warning text-dark">Partial</span>
                @endif
            </td>
            <td>
                @if($dispute->order->user_dispute && $dispute->order->teacher_dispute)
                    <span class="badge bg-info">⚡ Both Parties</span>
                @elseif($dispute->order->user_dispute)
                    <span class="badge bg-primary">👤 Buyer</span>
                @else
                    <span class="badge bg-secondary">👨‍🏫 Seller</span>
                @endif
            </td>
            <td>{{ \Carbon\Carbon::parse($dispute->created_at)->format('M d, Y') }}</td>
            <td>
                @switch($dispute->status)
                    @case(0)
                        <span class="badge bg-warning text-dark">⏳ Pending Review</span>
                        @break
                    @case(1)
                        <span class="badge bg-success">✅ Refunded</span>
                        @break
                    @case(2)
                        <span class="badge bg-danger">❌ Rejected</span>
                        @break
                @endswitch
            </td>
            <td>
                @if($dispute->status == 0)
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#disputeModal{{ $dispute->id }}">
                        <i class="bx bx-show"></i> Review
                    </button>
                @else
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#disputeModal{{ $dispute->id }}">
                        <i class="bx bx-show"></i> View
                    </button>
                @endif
            </td>
        </tr>

        {{-- Dispute Review Modal --}}
        <div class="modal fade" id="disputeModal{{ $dispute->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Dispute Review - Order #{{ $dispute->order->id }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Order Details --}}
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>📦 Order Information</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order ID:</strong> #{{ $dispute->order->id }}</p>
                                        <p><strong>Service:</strong> {{ $dispute->order->title }}</p>
                                        <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($dispute->order->created_at)->format('M d, Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Order Amount:</strong> ${{ number_format($dispute->order->finel_price, 2) }}</p>
                                        <p><strong>Refund Amount:</strong> <span class="text-danger">${{ number_format($dispute->amount, 2) }}</span></p>
                                        <p><strong>Refund Type:</strong>
                                            @if($dispute->refund_type == 0)
                                                <span class="badge bg-danger">Full Refund</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Partial Refund</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Buyer's Reason --}}
                        @if($dispute->order->user_dispute)
                        <div class="card mb-3 border-primary">
                            <div class="card-header bg-primary text-white">
                                <strong>👤 Buyer's Reason</strong>
                            </div>
                            <div class="card-body">
                                {{ $dispute->reason }}
                                <hr>
                                <small class="text-muted">
                                    Filed by: {{ $dispute->order->user->first_name }} {{ $dispute->order->user->last_name }}
                                    ({{ $dispute->order->user->email }})
                                    <br>Filed on: {{ \Carbon\Carbon::parse($dispute->created_at)->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                        @endif

                        {{-- Seller's Counter-Dispute --}}
                        @if($dispute->order->teacher_dispute)
                        @php
                            $sellerDispute = \App\Models\DisputeOrder::where('order_id', $dispute->order->id)
                                ->where('user_role', 1) // Seller
                                ->first();
                        @endphp
                        @if($sellerDispute)
                        <div class="card mb-3 border-warning">
                            <div class="card-header bg-warning">
                                <strong>👨‍🏫 Seller's Counter-Dispute</strong>
                            </div>
                            <div class="card-body">
                                {{ $sellerDispute->reason }}
                                <hr>
                                <small class="text-muted">
                                    Filed by: {{ $dispute->order->teacher->first_name }} {{ $dispute->order->teacher->last_name }}
                                    ({{ $dispute->order->teacher->email }})
                                    <br>Filed on: {{ \Carbon\Carbon::parse($sellerDispute->created_at)->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                        @endif
                        @endif

                        {{-- Timeline --}}
                        <div class="card">
                            <div class="card-header bg-light">
                                <strong>🕐 Timeline</strong>
                            </div>
                            <div class="card-body">
                                <ul class="timeline">
                                    <li>
                                        <strong>Order Created:</strong>
                                        {{ \Carbon\Carbon::parse($dispute->order->created_at)->format('M d, Y H:i') }}
                                    </li>
                                    @if($dispute->order->user_dispute)
                                    <li>
                                        <strong>Buyer Filed Dispute:</strong>
                                        {{ \Carbon\Carbon::parse($dispute->created_at)->format('M d, Y H:i') }}
                                    </li>
                                    @endif
                                    @if($dispute->order->teacher_dispute && $sellerDispute)
                                    <li>
                                        <strong>Seller Counter-Disputed:</strong>
                                        {{ \Carbon\Carbon::parse($sellerDispute->created_at)->format('M d, Y H:i') }}
                                        ({{ \Carbon\Carbon::parse($dispute->created_at)->diffInHours(\Carbon\Carbon::parse($sellerDispute->created_at)) }} hours after buyer dispute)
                                    </li>
                                    @endif
                                    @if($dispute->status != 0)
                                    <li>
                                        <strong>Admin Decision:</strong>
                                        {{ $dispute->status == 1 ? 'Approved' : 'Rejected' }}
                                        on {{ \Carbon\Carbon::parse($dispute->updated_at)->format('M d, Y H:i') }}
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($dispute->status == 0)
                            {{-- Approve Form --}}
                            <form method="POST" action="{{ route('admin.refund.approve', $dispute->id) }}"
                                  style="display: inline;">
                                @csrf
                                @if($dispute->refund_type == 1)
                                    <div class="input-group me-2">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="refund_amount"
                                               class="form-control" value="{{ $dispute->amount }}"
                                               max="{{ $dispute->order->finel_price }}" required>
                                        <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Approve partial refund?')">
                                            <i class="bx bx-check"></i> Approve Partial
                                        </button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Approve full refund of ${{ number_format($dispute->amount, 2) }}?')">
                                        <i class="bx bx-check"></i> Approve Full Refund
                                    </button>
                                @endif
                            </form>

                            {{-- Reject Button --}}
                            <button type="button" class="btn btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#rejectModal{{ $dispute->id }}">
                                <i class="bx bx-x"></i> Reject Refund
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Reject Modal --}}
        <div class="modal fade" id="rejectModal{{ $dispute->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.refund.reject', $dispute->id) }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Refund Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Reason for Rejection (will be sent to buyer):</label>
                                <textarea name="reject_reason" class="form-control" rows="4"
                                          required placeholder="Explain why this refund is being rejected..."></textarea>
                            </div>
                            <div class="alert alert-warning">
                                <strong>⚠️ Note:</strong> Rejecting this refund will:
                                <ul class="mb-0 mt-2">
                                    <li>Release payment to seller for payout</li>
                                    <li>Close this dispute</li>
                                    <li>Notify both buyer and seller</li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to reject this refund?')">
                                <i class="bx bx-x"></i> Confirm Rejection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @empty
        <tr>
            <td colspan="10" class="text-center py-5">
                <i class="bx bx-info-circle" style="font-size: 60px; color: #ccc;"></i>
                <p class="text-muted mt-3">No disputes found.</p>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
```

---

## 🗂️ PART 3: File Structure & Routes

### 3.1 New Routes to Add

**File:** `routes/web.php`

```php
Route::middleware(['auth', 'admin'])->group(function () {

    // Existing routes...
    Route::get('/admin/all-orders', [AdminController::class, 'allOrders'])->name('admin.all-orders');
    Route::get('/admin/payout-details', [AdminController::class, 'payoutDetails'])->name('admin.payout-details');
    Route::get('/admin/refund-details', [AdminController::class, 'refundDetails'])->name('admin.refund-details');

    // NEW ROUTES:

    // Payout Management
    Route::post('/admin/payout/process/{transaction}', [AdminController::class, 'processPayout'])
        ->name('admin.payout.process');

    // Refund Management (CRITICAL)
    Route::post('/admin/refund/approve/{dispute}', [AdminController::class, 'approveRefund'])
        ->name('admin.refund.approve');
    Route::post('/admin/refund/reject/{dispute}', [AdminController::class, 'rejectRefund'])
        ->name('admin.refund.reject');

    // Order Details
    Route::get('/admin/order/{id}/details', [AdminController::class, 'orderDetails'])
        ->name('admin.order.details');

    // Transaction Details
    Route::get('/admin/transaction/{id}/details', [AdminController::class, 'transactionDetails'])
        ->name('admin.transaction.details');

    // Invoice Download
    Route::get('/admin/invoice/download/{orderId}', [AdminController::class, 'downloadInvoice'])
        ->name('admin.invoice.download');
});
```

### 3.2 Files to Create

```
app/Http/Controllers/
└── AdminController.php (modify existing methods + add new methods)

resources/views/Admin-Dashboard/
├── All-orders.blade.php (complete rewrite)
├── payout-details.blade.php (complete rewrite)
├── refund-details.blade.php (complete rewrite)
├── order-details.blade.php (NEW - create this)
└── transaction-details.blade.php (NEW - create this)

resources/views/components/
└── admin-sidebar.blade.php (already exists, no changes needed)

public/assets/admin/asset/css/
└── payment-management.css (NEW - optional, for custom styles)
```

### 3.3 Database Changes Needed

**None!** আপনার database schema ইতিমধ্যে সব ঠিক আছে। শুধু একটি optional improvement:

**Optional Migration:** Add `admin_notes` field to `dispute_orders` table

```php
Schema::table('dispute_orders', function (Blueprint $table) {
    $table->text('admin_notes')->nullable()->after('reason');
});
```

---

## 📝 PART 4: Implementation Steps (Step-by-Step)

### Step 1: Backup Current Files
```bash
cp app/Http/Controllers/AdminController.php app/Http/Controllers/AdminController.php.backup
cp resources/views/Admin-Dashboard/All-orders.blade.php resources/views/Admin-Dashboard/All-orders.blade.php.backup
cp resources/views/Admin-Dashboard/payout-details.blade.php resources/views/Admin-Dashboard/payout-details.blade.php.backup
cp resources/views/Admin-Dashboard/refund-details.blade.php resources/views/Admin-Dashboard/refund-details.blade.php.backup
```

### Step 2: Update AdminController

1. Open `app/Http/Controllers/AdminController.php`
2. Replace these methods:
   - `allOrders()` (full replacement)
   - `payoutDetails()` (minor updates)
   - `refundDetails()` (full replacement)
3. Add these new methods:
   - `approveRefund()`
   - `rejectRefund()`
   - `processPayout()`

### Step 3: Update View Files

**Priority Order:**
1. **Refund Details** (MOST CRITICAL - এটা প্রথমে করুন)
2. **All Orders** (HIGH PRIORITY)
3. **Payout Details** (MEDIUM PRIORITY)

For each view:
- Create backup
- Update statistics cards section
- Update filters section
- Update table structure
- Add modals (for refund details)
- Update JavaScript

### Step 4: Add Routes

1. Open `routes/web.php`
2. Find the admin routes section
3. Add the new routes listed in section 3.1

### Step 5: Test Each Page

**Testing Checklist:**

**All Orders Page:**
- [ ] Page loads without errors
- [ ] Shows real order data (not dummy)
- [ ] Statistics cards show correct counts
- [ ] Date filter works
- [ ] Status filter works
- [ ] Search works
- [ ] Pagination works
- [ ] Order details link works

**Payout Details Page:**
- [ ] Page loads
- [ ] Shows real transaction data
- [ ] Statistics cards accurate
- [ ] Status tabs work
- [ ] "Mark Paid" button works
- [ ] Notification sent to seller
- [ ] Transaction status updates

**Refund Details Page (CRITICAL):**
- [ ] Page loads
- [ ] Shows pending disputes
- [ ] Buyer reason shows
- [ ] Seller counter-dispute shows (if any)
- [ ] "Review" button opens modal
- [ ] Modal shows all details
- [ ] "Approve" button:
  - [ ] Processes Stripe refund
  - [ ] Updates dispute status
  - [ ] Updates order status
  - [ ] Updates transaction
  - [ ] Sends notifications to buyer & seller
- [ ] "Reject" button:
  - [ ] Opens reject modal
  - [ ] Requires reason
  - [ ] Updates statuses
  - [ ] Releases payment to seller
  - [ ] Sends notifications
- [ ] View tabs work (pending, refunded, rejected, all)

### Step 6: Optional Enhancements

1. **Add Export to Excel:**
   - Install: `composer require maatwebsite/excel`
   - Add export buttons on each page

2. **Add Custom Styles:**
   - Create `public/assets/admin/asset/css/payment-management.css`
   - Add custom CSS for better visuals

3. **Add Loading States:**
   - Add JavaScript loading spinners for approve/reject actions

---

## ⚠️ PART 5: Important Notes & Warnings

### Critical Points:

1. **Refund Details Page is MOST IMPORTANT**
   - This is where admin makes financial decisions
   - Must test thoroughly
   - Any bug here = money loss

2. **Stripe API Keys**
   - Ensure `.env` has correct Stripe keys
   - Use test keys for testing
   - Switch to live keys only after full testing

3. **Notifications**
   - Ensure `NotificationService` is working
   - Test email delivery
   - Check notification queue is processing

4. **Database Transactions**
   - All approve/reject actions use `DB::beginTransaction()`
   - Critical for data consistency

5. **48-Hour Auto-Refund**
   - `AutoHandleDisputes` command must keep running
   - Schedule: `php artisan schedule:run` (cron job)

### Common Pitfalls to Avoid:

1. **Don't** process refund if order.payment_id is empty
2. **Don't** approve refund twice (check dispute.status == 0)
3. **Don't** forget to update transaction after refund
4. **Don't** skip sending notifications
5. **Always** use try-catch for Stripe API calls

---

## 🎯 PART 6: Success Criteria

এই implementation সফল হবে যদি:

### For All Orders Page:
- [x] Shows real database data
- [x] All filters work properly
- [x] Search works
- [x] Statistics are accurate
- [x] Performance is good (< 2 seconds load time)

### For Payout Details Page:
- [x] Shows correct pending/completed payouts
- [x] Statistics match actual database
- [x] "Mark Paid" button works
- [x] Seller gets notification
- [x] Transaction updates correctly

### For Refund Details Page:
- [x] Shows all pending disputes
- [x] Displays both buyer & seller reasons clearly
- [x] Approve button:
  - [x] Processes actual Stripe refund
  - [x] Updates all relevant tables
  - [x] Sends notifications
  - [x] No errors in logs
- [x] Reject button:
  - [x] Releases payment to seller
  - [x] Updates statuses correctly
  - [x] Sends rejection notification
- [x] View filters work (pending, refunded, rejected)
- [x] No duplicate refunds possible
- [x] Edge cases handled (invalid amounts, missing data, etc.)

---

## 📞 PART 7: Support & Next Steps

### After Implementation:

1. **Deploy to Staging:**
   - Test with real data
   - Test Stripe refunds (use test mode)
   - Get admin user to test workflow

2. **User Training:**
   - Train admin on new interface
   - Document the approval/rejection process
   - Create admin user guide

3. **Monitor:**
   - Watch logs for errors
   - Monitor Stripe dashboard
   - Check notification delivery

4. **Future Enhancements:**
   - Integrate Stripe Connect (for automatic payouts)
   - Add bulk actions (approve multiple disputes at once)
   - Add dispute comments/chat
   - Add refund analytics dashboard

---

## 📋 Summary

এই plan অনুসরণ করলে আপনার admin panel এর Payment Management section সম্পূর্ণ functional এবং PRD requirements meet করবে।

**Key Takeaways:**
1. **Refund Details page সবচেয়ে critical** - এটা প্রথমে implement করুন
2. **Controller methods বেশিরভাগ ready** - শুধু view files update করতে হবে
3. **Approve/Reject logic carefully tested** - financial operations এ কোন ভুল চলবে না
4. **Notifications properly implemented** - users কে inform রাখা জরুরি

**Timeline Estimate:**
- Refund Details Page: 2-3 days
- All Orders Page: 1-2 days
- Payout Details Page: 1 day
- Testing & Fixes: 2-3 days
- **Total: 6-9 days**

---

**End of Plan Document**

_This plan is ready for implementation. Please review and approve before proceeding._
