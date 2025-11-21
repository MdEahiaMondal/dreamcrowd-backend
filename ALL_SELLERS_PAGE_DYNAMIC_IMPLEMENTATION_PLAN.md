# All Sellers Page - Dynamic Implementation Plan

## 📋 Current State Analysis

### Issues Identified:

1. **100% Static Seller Data** (Lines 353-1137, repeated across 5 tabs)
   - All rows show identical hardcoded data in each tab
   - Seller: "Usama A." (repeated)
   - Seller ID: "#7906108" (repeated)
   - Reg. Date: "October 23, 2023" (repeated)
   - Service Type: "Freelance Service" (hardcoded)
   - Category: "Graphic Design" (hardcoded)
   - Location: "London, US" (hardcoded)
   - Rating: "4.5 (400+ reviews)" (hardcoded)
   - Total Orders: "400" (hardcoded)
   - Total Amount: "$14,840" (hardcoded)
   - Refunds: "$14,840" (hardcoded)
   - No database integration despite controller passing `$sellers`

2. **Non-Functional Filters** (Lines 101-236)
   - Date filter dropdown has duplicate/incorrect values
   - Custom date range fields appear but don't submit
   - Second filter dropdown has irrelevant options (Top Reviews, Top Sellers, etc.)
   - Search box doesn't search
   - No form submission action

3. **Static Pagination**
   - No pagination visible in current implementation
   - Controller uses `paginate(20)` but view doesn't render it

4. **Non-Functional Tabs** (5 Tabs)
   - **Active Accounts** (status = 0): Shows hardcoded data
   - **Hidden Seller** (hidden status): Shows same hardcoded data
   - **Paused Accounts** (paused status): Shows same hardcoded data
   - **Banned Accounts** (banned status): Shows same hardcoded data
   - **Deleted Accounts** (soft deleted): Shows same hardcoded data
   - All tabs display identical static data
   - No actual status filtering

5. **Non-Functional Actions** (Lines 374-438 per row)
   - Dropdown with 5 actions:
     - View Dashboard → Goes to "#"
     - View Services → Goes to "#"
     - Hide Seller → Goes to "#"
     - Pause Account → Goes to "#"
     - Delete Account → Goes to "#"
   - No actual functionality implemented

6. **Missing Features**
   - No seller statistics/summary cards
   - No service type breakdown
   - No commission management links
   - No export functionality (Excel/PDF)
   - No bulk actions
   - No seller verification status
   - No earnings display
   - No profile picture display
   - No status badges

7. **Data Already Available from Controller**
   - `$sellers` - Paginated users with role = 1
   - Includes relationships: `expertProfile`, `teacherGigs`, `bookOrders`
   - Counts: `teacher_gigs_count`, `book_orders_count`

---

## 🎯 Implementation Plan

### **PHASE 1: Backend Controller Enhancement**

#### File: `app/Http/Controllers/AdminController.php`

**Current Method** (Line 1667):
```php
public function allSellers()
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $sellers = User::where('role', 1)
        ->with('expertProfile')
        ->withCount('teacherGigs')
        ->withCount('bookOrders')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('Admin-Dashboard.all-sellers', compact('sellers'));
}
```

**Enhanced Method**:
```php
public function allSellers(Request $request)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    // Determine which tab/status to show
    $status = $request->get('status', 'active'); // active, hidden, paused, banned, deleted

    // Base query for sellers (users with role = 1)
    $query = User::where('role', 1);

    // Apply status filter based on tab
    switch ($status) {
        case 'active':
            $query->where('status', 0); // Active sellers
            break;
        case 'hidden':
            $query->where('status', 2); // Hidden sellers (assuming status 2 = hidden)
            break;
        case 'paused':
            $query->where('status', 3); // Paused sellers (assuming status 3 = paused)
            break;
        case 'banned':
            $query->where('status', 4); // Banned sellers (assuming status 4 = banned)
            break;
        case 'deleted':
            $query->onlyTrashed(); // Soft deleted sellers
            break;
    }

    // FILTER 1: Date Range Filter (Registration Date)
    if ($request->filled('date_filter')) {
        switch ($request->date_filter) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'yesterday':
                $query->whereDate('created_at', today()->subDay());
                break;
            case 'last_week':
                $query->whereBetween('created_at', [now()->subWeek(), now()]);
                break;
            case 'last_7_days':
                $query->whereBetween('created_at', [now()->subDays(7), now()]);
                break;
            case 'last_month':
                $query->whereMonth('created_at', now()->subMonth()->month)
                      ->whereYear('created_at', now()->subMonth()->year);
                break;
            case 'current_month':
                $query->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                break;
            case 'custom':
                if ($request->filled(['from_date', 'to_date'])) {
                    $query->whereBetween('created_at', [
                        $request->from_date . ' 00:00:00',
                        $request->to_date . ' 23:59:59'
                    ]);
                }
                break;
        }
    }

    // FILTER 2: Search (Name, Email, ID)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    // FILTER 3: Service Type (via gigs)
    if ($request->filled('service_type')) {
        $query->whereHas('teacherGigs', function($q) use ($request) {
            $q->where('service_type', $request->service_type);
        });
    }

    // FILTER 4: Category
    if ($request->filled('category_id')) {
        $query->whereHas('teacherGigs', function($q) use ($request) {
            $q->where('category_id', $request->category_id);
        });
    }

    // FILTER 5: Location (Country/City)
    if ($request->filled('location')) {
        $location = $request->location;
        $query->where(function($q) use ($location) {
            $q->where('country', 'like', "%{$location}%")
              ->orWhere('city', 'like', "%{$location}%");
        });
    }

    // FILTER 6: Order Range
    if ($request->filled('min_orders')) {
        $query->has('bookOrders', '>=', $request->min_orders);
    }
    if ($request->filled('max_orders')) {
        $query->has('bookOrders', '<=', $request->max_orders);
    }

    // Load relationships and calculate aggregates
    $query->with([
        'expertProfile:id,user_id,expert_name,category,sub_category',
        'teacherGigs:id,user_id,title,service_type,service_role,category_id,image',
        'sellerCommission:id,seller_id,commission_percentage',
    ])
    ->withCount([
        'teacherGigs',
        'bookOrders',
        'sellerTransactions',
    ])
    ->withSum('sellerTransactions as total_earnings', 'seller_earnings')
    ->withAvg('receivedReviews as average_rating', 'rating');

    // Check if export is requested
    if ($request->has('export') && $request->export == 'excel') {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\SellersExport($query->get(), $status),
            'sellers_' . $status . '_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    // Get paginated sellers
    $sellers = $query->orderBy('created_at', 'desc')->paginate(20);

    // Calculate Statistics for each status
    $stats = [
        'total_sellers' => User::where('role', 1)->count(),
        'active_sellers' => User::where('role', 1)->where('status', 0)->count(),
        'hidden_sellers' => User::where('role', 1)->where('status', 2)->count(),
        'paused_sellers' => User::where('role', 1)->where('status', 3)->count(),
        'banned_sellers' => User::where('role', 1)->where('status', 4)->count(),
        'deleted_sellers' => User::where('role', 1)->onlyTrashed()->count(),
        'sellers_this_month' => User::where('role', 1)
            ->whereMonth('created_at', now()->month)->count(),
        'total_services' => \App\Models\TeacherGig::count(),
        'total_orders' => \App\Models\BookOrder::count(),
        'total_revenue' => \App\Models\Transaction::where('status', 'completed')
            ->sum('total_amount'),
    ];

    // Get categories for filter dropdown
    $categories = \App\Models\Category::orderBy('category_name')->get(['id', 'category_name']);

    return view('Admin-Dashboard.all-sellers', compact('sellers', 'stats', 'categories', 'status'));
}
```

**Add Action Methods**:

```php
/**
 * Update seller status (hide, pause, activate)
 */
public function updateSellerStatus(Request $request, $id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $request->validate([
        'status' => 'required|in:0,2,3,4', // 0=active, 2=hidden, 3=paused, 4=banned
    ]);

    try {
        $seller = User::findOrFail($id);
        $seller->status = $request->status;
        $seller->save();

        $statusText = [
            0 => 'activated',
            2 => 'hidden',
            3 => 'paused',
            4 => 'banned'
        ];

        return redirect()->back()->with('success', 'Seller ' . $statusText[$request->status] . ' successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to update seller status: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update seller status.');
    }
}

/**
 * Delete seller (soft delete)
 */
public function deleteSeller($id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    try {
        $seller = User::findOrFail($id);
        $seller->delete(); // Soft delete

        return redirect()->back()->with('success', 'Seller deleted successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to delete seller: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to delete seller.');
    }
}

/**
 * Restore deleted seller
 */
public function restoreSeller($id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    try {
        $seller = User::withTrashed()->findOrFail($id);
        $seller->restore();
        $seller->status = 0; // Set to active

        return redirect()->back()->with('success', 'Seller restored successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to restore seller: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to restore seller.');
    }
}
```

**Changes Summary:**
- ✅ Add `Request $request` parameter for filters
- ✅ Implement status-based tab filtering (active, hidden, paused, banned, deleted)
- ✅ Implement date range filtering
- ✅ Implement search functionality (name, email, ID)
- ✅ Add service type filter
- ✅ Add category filter
- ✅ Add location filter
- ✅ Add order range filter
- ✅ Calculate earnings, ratings, counts via relationships
- ✅ Calculate comprehensive statistics
- ✅ Support Excel export
- ✅ Add seller status management methods
- ✅ Add seller delete/restore methods
- ✅ Get categories for filter dropdown

---

### **PHASE 2: View File Complete Rewrite**

#### File: `resources/views/Admin-Dashboard/all-sellers.blade.php`

**Current State:** 3,198 lines of mostly duplicated static HTML across 5 tabs

**Proposed Changes:**

#### 2.1 Add Statistics Cards (After line 96)

```blade
<!-- Statistics Cards Section -->
<div class="row mb-4">
    <!-- Total Sellers -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Total Sellers</h6>
                        <h3 class="mb-0">{{ number_format($stats['total_sellers']) }}</h3>
                        <small class="text-muted">{{ $stats['sellers_this_month'] }} this month</small>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="bx bx-user-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Sellers -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Active Sellers</h6>
                        <h3 class="mb-0">{{ number_format($stats['active_sellers']) }}</h3>
                        <small class="text-success">Currently active</small>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="bx bx-user-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Services -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Total Services</h6>
                        <h3 class="mb-0">{{ number_format($stats['total_services']) }}</h3>
                        <small class="text-muted">Services listed</small>
                    </div>
                    <div class="stat-icon bg-info">
                        <i class="bx bx-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Total Revenue</h6>
                        <h3 class="mb-0">${{ number_format($stats['total_revenue'], 2) }}</h3>
                        <small class="text-muted">All transactions</small>
                    </div>
                    <div class="stat-icon bg-warning">
                        <i class="bx bx-dollar-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

#### 2.2 Make Filters Functional (Replace lines 98-237)

```blade
<!-- Filter Section -->
<div class="date-section">
    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.all-sellers') }}" id="filterForm">
                <!-- Preserve current tab status -->
                <input type="hidden" name="status" value="{{ $status }}">

                <div class="row align-items-end">
                    <!-- Date Filter -->
                    <div class="col-md-2 mb-2">
                        <label class="form-label small"><strong>Registration Date</strong></label>
                        <div class="date-sec">
                            <i class="fa-solid fa-calendar-days"></i>
                            <select class="form-select" name="date_filter" id="dateFilter">
                                <option value="">All Time</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                                <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                                <option value="current_month" {{ request('date_filter') == 'current_month' ? 'selected' : '' }}>This Month</option>
                                <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                            </select>
                        </div>
                    </div>

                    <!-- Custom Date Range -->
                    <div class="col-md-2 mb-2" id="fromDateFields" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }}">
                        <label class="form-label small"><strong>From</strong></label>
                        <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" />
                    </div>
                    <div class="col-md-2 mb-2" id="toDateFields" style="display: {{ request('date_filter') == 'custom' ? 'block' : 'none' }}">
                        <label class="form-label small"><strong>To</strong></label>
                        <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" />
                    </div>

                    <!-- Service Type Filter -->
                    <div class="col-md-2 mb-2">
                        <label class="form-label small"><strong>Service Type</strong></label>
                        <select class="form-select" name="service_type">
                            <option value="">All Types</option>
                            <option value="OneOff" {{ request('service_type') == 'OneOff' ? 'selected' : '' }}>One-Off Class</option>
                            <option value="Subscription" {{ request('service_type') == 'Subscription' ? 'selected' : '' }}>Subscription</option>
                            <option value="Freelance" {{ request('service_type') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-md-2 mb-2">
                        <label class="form-label small"><strong>Category</strong></label>
                        <select class="form-select" name="category_id">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-filter"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Search & Export Row -->
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bx bx-search"></i></span>
                            <input type="text" name="search" class="form-control"
                                   placeholder="Search by name, email, or ID..."
                                   value="{{ request('search') }}" />
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        @if(request()->hasAny(['date_filter', 'search', 'service_type', 'category_id', 'location']))
                            <a href="{{ route('admin.all-sellers', ['status' => $status]) }}" class="btn btn-secondary">
                                <i class="bx bx-reset"></i> Clear Filters
                            </a>
                        @endif
                        <button type="button" class="btn btn-success" id="exportExcel">
                            <i class="bx bx-download"></i> Export Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
```

#### 2.3 Update Tab Navigation (Lines 242-309)

```blade
<div class="super-tab-nav">
    <nav>
        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <!-- Active Accounts Tab -->
            <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
               href="{{ route('admin.all-sellers', array_merge(request()->query(), ['status' => 'active'])) }}">
                Active Accounts
                <span class="badge bg-success ms-1">{{ $stats['active_sellers'] }}</span>
            </a>

            <!-- Hidden Sellers Tab -->
            <a class="nav-link {{ $status == 'hidden' ? 'active' : '' }}"
               href="{{ route('admin.all-sellers', array_merge(request()->query(), ['status' => 'hidden'])) }}">
                Hidden Seller
                <span class="badge bg-secondary ms-1">{{ $stats['hidden_sellers'] }}</span>
            </a>

            <!-- Paused Accounts Tab -->
            <a class="nav-link {{ $status == 'paused' ? 'active' : '' }}"
               href="{{ route('admin.all-sellers', array_merge(request()->query(), ['status' => 'paused'])) }}">
                Paused Accounts
                <span class="badge bg-warning ms-1">{{ $stats['paused_sellers'] }}</span>
            </a>

            <!-- Banned Accounts Tab -->
            <a class="nav-link {{ $status == 'banned' ? 'active' : '' }}"
               href="{{ route('admin.all-sellers', array_merge(request()->query(), ['status' => 'banned'])) }}">
                Banned Accounts
                <span class="badge bg-danger ms-1">{{ $stats['banned_sellers'] }}</span>
            </a>

            <!-- Deleted Accounts Tab -->
            <a class="nav-link {{ $status == 'deleted' ? 'active' : '' }}"
               href="{{ route('admin.all-sellers', array_merge(request()->query(), ['status' => 'deleted'])) }}">
                Deleted Accounts
                <span class="badge bg-dark ms-1">{{ $stats['deleted_sellers'] }}</span>
            </a>
        </div>
    </nav>
</div>
```

#### 2.4 Replace All 5 Static Tab Content Sections with One Dynamic Table

**Remove:** Lines 312-3166 (all 5 tab-pane sections with static data)

**Replace with:**

```blade
<!-- Sellers Table (Single Dynamic Table) -->
<div class="tab-content border bg-light" id="nav-tabContent">
    <div class="main-container d-flex">
        <div class="content w-100" id="vt-main-section">
            <div class="container-fluid" id="installment-contant">
                <div class="row" id="main-contant-AI">
                    <div class="col-md-12 p-0">
                        <div class="row installment-table">
                            <div class="col-md-12 p-0">
                                <div class="table-responsive">
                                    <div class="hack1">
                                        <div class="hack2">
                                            <table class="table">
                                                <thead>
                                                    <tr class="text-nowrap">
                                                        <th>Seller</th>
                                                        <th>Seller ID</th>
                                                        <th>Reg. Date</th>
                                                        <th>Service Type</th>
                                                        <th>Category</th>
                                                        <th>Location</th>
                                                        <th>Rating</th>
                                                        <th>Total Orders</th>
                                                        <th>Total Earnings</th>
                                                        <th>Gigs</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($sellers as $seller)
                                                        <tr>
                                                            <!-- Seller (Name + Profile Pic) -->
                                                            <td>
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @if($seller->profile_pic)
                                                                        <img src="/storage/{{ $seller->profile_pic }}"
                                                                             class="rounded-circle"
                                                                             width="40" height="40"
                                                                             alt="Seller">
                                                                    @else
                                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                                             style="width: 40px; height: 40px;">
                                                                            {{ strtoupper(substr($seller->first_name, 0, 1)) }}
                                                                        </div>
                                                                    @endif
                                                                    <div>
                                                                        <strong>{{ $seller->first_name }} {{ $seller->last_name }}</strong><br>
                                                                        <small class="text-muted">{{ $seller->email }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <!-- Seller ID -->
                                                            <td>#{{ str_pad($seller->id, 7, '0', STR_PAD_LEFT) }}</td>

                                                            <!-- Registration Date -->
                                                            <td class="text-nowrap">
                                                                {{ $seller->created_at->format('M d, Y') }}<br>
                                                                <small class="text-muted">{{ $seller->created_at->diffForHumans() }}</small>
                                                            </td>

                                                            <!-- Service Type (from gigs) -->
                                                            <td>
                                                                @if($seller->teacherGigs->isNotEmpty())
                                                                    @php
                                                                        $serviceTypes = $seller->teacherGigs->pluck('service_type')->unique();
                                                                    @endphp
                                                                    @foreach($serviceTypes as $type)
                                                                        <span class="badge bg-info mb-1">{{ $type }}</span><br>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">No Services</span>
                                                                @endif
                                                            </td>

                                                            <!-- Category (from expert profile or gigs) -->
                                                            <td>
                                                                @if($seller->expertProfile && $seller->expertProfile->category)
                                                                    {{ $seller->expertProfile->category }}
                                                                @elseif($seller->teacherGigs->isNotEmpty())
                                                                    @php
                                                                        $categories = $seller->teacherGigs->pluck('category.category_name')->unique()->take(2);
                                                                    @endphp
                                                                    {{ $categories->implode(', ') }}
                                                                @else
                                                                    <span class="text-muted">N/A</span>
                                                                @endif
                                                            </td>

                                                            <!-- Location -->
                                                            <td class="text-nowrap">
                                                                @if($seller->city && $seller->country)
                                                                    {{ $seller->city }}, {{ $seller->country }}
                                                                @elseif($seller->country)
                                                                    {{ $seller->country }}
                                                                @else
                                                                    <span class="text-muted">Not set</span>
                                                                @endif
                                                            </td>

                                                            <!-- Rating -->
                                                            <td>
                                                                @if($seller->average_rating)
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="bx bxs-star text-warning"></i>
                                                                        <span class="ms-1">{{ number_format($seller->average_rating, 1) }}</span>
                                                                    </div>
                                                                    <small class="text-muted">({{ $seller->received_reviews_count ?? 0 }} reviews)</small>
                                                                @else
                                                                    <span class="text-muted">No reviews</span>
                                                                @endif
                                                            </td>

                                                            <!-- Total Orders -->
                                                            <td>
                                                                <strong>{{ number_format($seller->book_orders_count) }}</strong>
                                                            </td>

                                                            <!-- Total Earnings -->
                                                            <td class="text-nowrap">
                                                                <strong class="text-success">
                                                                    ${{ number_format($seller->total_earnings ?? 0, 2) }}
                                                                </strong>
                                                            </td>

                                                            <!-- Total Gigs -->
                                                            <td>
                                                                <strong>{{ $seller->teacher_gigs_count }}</strong>
                                                            </td>

                                                            <!-- Status Badge -->
                                                            <td>
                                                                @if($seller->status == 0)
                                                                    <span class="badge bg-success">Active</span>
                                                                @elseif($seller->status == 2)
                                                                    <span class="badge bg-secondary">Hidden</span>
                                                                @elseif($seller->status == 3)
                                                                    <span class="badge bg-warning">Paused</span>
                                                                @elseif($seller->status == 4)
                                                                    <span class="badge bg-danger">Banned</span>
                                                                @elseif($seller->trashed())
                                                                    <span class="badge bg-dark">Deleted</span>
                                                                @else
                                                                    <span class="badge bg-secondary">Unknown</span>
                                                                @endif
                                                            </td>

                                                            <!-- Actions -->
                                                            <td>
                                                                <div class="expert-dropdown">
                                                                    <button class="btn action-btn" type="button"
                                                                            id="dropdownMenuButton{{ $seller->id }}"
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                        ...
                                                                    </button>
                                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $seller->id }}">
                                                                        <!-- View Dashboard -->
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ route('admin.seller.dashboard', $seller->id) }}">
                                                                                <i class="bx bx-dashboard"></i> View Dashboard
                                                                            </a>
                                                                        </li>

                                                                        <!-- View Services -->
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ route('admin.all-services', ['seller_id' => $seller->id]) }}">
                                                                                <i class="bx bx-briefcase"></i> View Services
                                                                            </a>
                                                                        </li>

                                                                        <li><hr class="dropdown-divider"></li>

                                                                        <!-- Status Actions (conditional based on current status) -->
                                                                        @if($status == 'active')
                                                                            <li>
                                                                                <a class="dropdown-item" href="#"
                                                                                   onclick="updateSellerStatus({{ $seller->id }}, 2)">
                                                                                    <i class="bx bx-hide"></i> Hide Seller
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item" href="#"
                                                                                   onclick="updateSellerStatus({{ $seller->id }}, 3)">
                                                                                    <i class="bx bx-pause-circle"></i> Pause Account
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a class="dropdown-item text-danger" href="#"
                                                                                   onclick="updateSellerStatus({{ $seller->id }}, 4)">
                                                                                    <i class="bx bx-block"></i> Ban Account
                                                                                </a>
                                                                            </li>
                                                                        @elseif($status == 'hidden' || $status == 'paused' || $status == 'banned')
                                                                            <li>
                                                                                <a class="dropdown-item text-success" href="#"
                                                                                   onclick="updateSellerStatus({{ $seller->id }}, 0)">
                                                                                    <i class="bx bx-check-circle"></i> Activate Account
                                                                                </a>
                                                                            </li>
                                                                        @endif

                                                                        @if($status != 'deleted')
                                                                            <li><hr class="dropdown-divider"></li>
                                                                            <li>
                                                                                <a class="dropdown-item text-danger" href="#"
                                                                                   onclick="confirmDelete({{ $seller->id }})">
                                                                                    <i class="bx bx-trash"></i> Delete Account
                                                                                </a>
                                                                            </li>
                                                                        @else
                                                                            <li>
                                                                                <a class="dropdown-item text-success" href="#"
                                                                                   onclick="restoreSeller({{ $seller->id }})">
                                                                                    <i class="bx bx-undo"></i> Restore Account
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="12" class="text-center py-4">
                                                                <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                                                                <p class="text-muted mt-2">No sellers found</p>
                                                                @if(request()->hasAny(['date_filter', 'search', 'service_type', 'category_id']))
                                                                    <a href="{{ route('admin.all-sellers', ['status' => $status]) }}"
                                                                       class="btn btn-sm btn-primary">Clear Filters</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
                                    <div class="text-muted">
                                        Showing {{ $sellers->firstItem() ?? 0 }} to {{ $sellers->lastItem() ?? 0 }}
                                        of {{ $sellers->total() }} sellers
                                    </div>
                                    <div>
                                        {{ $sellers->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

#### 2.5 Add JavaScript for Functionality (Before `</body>`)

```javascript
<script>
// Export to Excel
document.getElementById('exportExcel')?.addEventListener('click', function() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.location.href = '{{ route("admin.all-sellers") }}?' + params.toString();
});

// Date filter toggle
const dateFilter = document.getElementById('dateFilter');
const fromDateFields = document.getElementById('fromDateFields');
const toDateFields = document.getElementById('toDateFields');

dateFilter?.addEventListener('change', function() {
    if (this.value === 'custom') {
        fromDateFields.style.display = 'block';
        toDateFields.style.display = 'block';
    } else {
        fromDateFields.style.display = 'none';
        toDateFields.style.display = 'none';
    }
});

// Update seller status
function updateSellerStatus(sellerId, status) {
    const statusText = {
        0: 'activate',
        2: 'hide',
        3: 'pause',
        4: 'ban'
    };

    if (confirm(`Are you sure you want to ${statusText[status]} this seller?`)) {
        // Create and submit form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/sellers/' + sellerId + '/status';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;

        form.appendChild(csrfInput);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Delete seller confirmation
function confirmDelete(sellerId) {
    if (confirm('Are you sure you want to delete this seller? This will soft delete their account.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/sellers/' + sellerId + '/delete';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Restore seller
function restoreSeller(sellerId) {
    if (confirm('Are you sure you want to restore this seller?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/sellers/' + sellerId + '/restore';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;

        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
```

#### 2.6 Add CSS Styles

```css
<style>
.stat-card {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    transition: transform 0.2s;
    margin-bottom: 20px;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items-center;
    justify-content: center;
    font-size: 24px;
    color: white;
}
.table td {
    vertical-align: middle;
}
.badge {
    font-weight: 500;
    padding: 5px 10px;
}
.nav-link .badge {
    font-size: 11px;
    padding: 3px 7px;
}
.action-btn {
    background: transparent;
    border: none;
    font-size: 20px;
    font-weight: bold;
    color: #0072b1;
    cursor: pointer;
}
.dropdown-item i {
    width: 20px;
    margin-right: 5px;
}
</style>
```

---

### **PHASE 3: Create Excel Export Class**

#### File: `app/Exports/SellersExport.php` (NEW)

```php
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SellersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $sellers;
    protected $status;

    public function __construct($sellers, $status = 'all')
    {
        $this->sellers = $sellers;
        $this->status = $status;
    }

    public function collection()
    {
        return $this->sellers;
    }

    public function headings(): array
    {
        return [
            'Seller ID',
            'Name',
            'Email',
            'Registration Date',
            'Country',
            'City',
            'Status',
            'Total Gigs',
            'Total Orders',
            'Total Earnings',
            'Average Rating',
            'Total Reviews',
            'Category',
            'Service Types',
            'Phone',
            'Created At',
        ];
    }

    public function map($seller): array
    {
        $serviceTypes = $seller->teacherGigs->pluck('service_type')->unique()->implode(', ');
        $category = $seller->expertProfile ? $seller->expertProfile->category : 'N/A';

        $statusText = [
            0 => 'Active',
            2 => 'Hidden',
            3 => 'Paused',
            4 => 'Banned',
        ];

        return [
            str_pad($seller->id, 7, '0', STR_PAD_LEFT),
            $seller->first_name . ' ' . $seller->last_name,
            $seller->email,
            $seller->created_at->format('Y-m-d'),
            $seller->country ?? 'N/A',
            $seller->city ?? 'N/A',
            $statusText[$seller->status] ?? 'Unknown',
            $seller->teacher_gigs_count,
            $seller->book_orders_count,
            number_format($seller->total_earnings ?? 0, 2),
            $seller->average_rating ? number_format($seller->average_rating, 2) : 'N/A',
            $seller->received_reviews_count ?? 0,
            $category,
            $serviceTypes ?: 'N/A',
            $seller->phone ?? 'N/A',
            $seller->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}
```

---

### **PHASE 4: Update Routes**

#### File: `routes/web.php`

Update and add these routes:

```php
// All Sellers Management
Route::get('/admin/all-sellers', [AdminController::class, 'allSellers'])->name('admin.all-sellers');
Route::post('/admin/sellers/{id}/status', [AdminController::class, 'updateSellerStatus'])->name('admin.sellers.update-status');
Route::post('/admin/sellers/{id}/delete', [AdminController::class, 'deleteSeller'])->name('admin.sellers.delete');
Route::post('/admin/sellers/{id}/restore', [AdminController::class, 'restoreSeller'])->name('admin.sellers.restore');

// Seller Dashboard (if needed)
Route::get('/admin/sellers/{id}/dashboard', [AdminController::class, 'sellerDashboard'])->name('admin.seller.dashboard');
```

---

### **PHASE 5: Database Migrations (if needed)**

#### Check if `users` table has `deleted_at` column for soft deletes

**File:** Create new migration if needed

```bash
php artisan make:migration add_soft_deletes_to_users_table
```

**Migration content:**
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes(); // Adds deleted_at column
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
```

#### Update User Model

**File:** `app/Models/User.php`

Add to the top of the class:
```php
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    // ... rest of the code
}
```

---

## 📊 Summary of Changes

### Files to Modify:
1. ✅ `app/Http/Controllers/AdminController.php` - Enhanced allSellers() method + action methods
2. ✅ `resources/views/Admin-Dashboard/all-sellers.blade.php` - Complete rewrite (reduce from 3,198 to ~600 lines)
3. ✅ `app/Models/User.php` - Add SoftDeletes trait
4. ✅ `routes/web.php` - Add seller management routes

### Files to Create:
5. ✅ `app/Exports/SellersExport.php` - Excel export functionality
6. ✅ Migration for soft deletes (if not exists)

---

## ✨ New Features to Implement

### Statistics Dashboard (NEW)
- ✅ Total sellers count
- ✅ Active sellers count
- ✅ Total services count
- ✅ Total revenue display
- ✅ Sellers this month count

### Advanced Filters (NEW)
- ✅ Filter by registration date (Today, Yesterday, Last Week, Custom Range, etc.)
- ✅ Service type filter
- ✅ Category filter
- ✅ Location filter
- ✅ Search by name, email, or ID
- ✅ Filters preserved across pagination

### Dynamic Tab System (NEW)
- ✅ Tab-based status filtering (Active, Hidden, Paused, Banned, Deleted)
- ✅ Count badges on each tab
- ✅ Filter preservation when switching tabs
- ✅ Single dynamic table instead of 5 duplicate tables

### Seller Table Features (NEW)
- ✅ Real seller data from database
- ✅ Profile pictures with fallback to initials
- ✅ Service type badges
- ✅ Category display from expert profile or gigs
- ✅ Location (city, country)
- ✅ Average rating with star icon
- ✅ Total orders count
- ✅ Total earnings display
- ✅ Total gigs count
- ✅ Status badges (color-coded)
- ✅ Registration date with "time ago"

### Seller Actions (NEW)
- ✅ View seller dashboard
- ✅ View seller services
- ✅ Hide seller (status = 2)
- ✅ Pause account (status = 3)
- ✅ Ban account (status = 4)
- ✅ Activate account (status = 0)
- ✅ Delete account (soft delete)
- ✅ Restore deleted account
- ✅ Contextual actions based on current status
- ✅ Confirmation dialogs

### Export & Reporting (NEW)
- ✅ Excel export with all filters applied
- ✅ Comprehensive data export (16 columns)
- ✅ Status-specific export file naming

### UI/UX Improvements
- ✅ Professional statistics cards
- ✅ User profile pictures
- ✅ Better table layout with proper spacing
- ✅ Status badges with appropriate colors
- ✅ Service type badges
- ✅ Empty state handling
- ✅ Filter persistence in pagination
- ✅ Responsive design maintained
- ✅ Confirmation dialogs for destructive actions
- ✅ Tab count badges

---

## 🎨 Data Flow & Relationships

### Seller Data Aggregation:
```
User (Seller)
├── expertProfile (hasOne) → Category, Sub-category
├── teacherGigs (hasMany) → Service types, Categories
├── bookOrders (hasMany) → Total orders count
├── sellerTransactions (hasMany) → Total earnings sum
├── receivedReviews (hasMany) → Average rating
├── sellerCommission (hasOne) → Custom commission rate
└── Status (0=active, 2=hidden, 3=paused, 4=banned)
```

### Status Management:
- **Active (0)**: Normal operational status
- **Hidden (2)**: Seller not visible to public but account active
- **Paused (3)**: Seller temporarily suspended operations
- **Banned (4)**: Seller permanently blocked
- **Deleted (soft)**: Seller account soft deleted (can be restored)

---

## 📝 Notes

- File size reduced from 3,198 lines to approximately 600 lines
- All 5 duplicate tab sections consolidated into one dynamic table
- Excel export package (`maatwebsite/excel`) already installed
- All database columns referenced exist in current schema
- Soft deletes require migration if not already implemented
- Profile pictures path assumes `/storage/` prefix
- Status values may need adjustment based on actual database schema
- Action methods use CSRF protection
- Tab switching preserves filter parameters

---

## 🚀 Implementation Priority

**High Priority (Must Have):**
1. Dynamic table with real seller data
2. Tab-based status filtering
3. Basic filters (date, search)
4. Statistics cards
5. Pagination

**Medium Priority (Should Have):**
6. Seller actions (hide, pause, ban, delete)
7. Category and service type filters
8. Excel export
9. Profile pictures
10. Rating display

**Low Priority (Nice to Have):**
11. Advanced filters (location, order range)
12. Bulk actions
13. Seller dashboard view
14. Commission management link

---

**Estimated Time:** 5-6 hours for full implementation
**Dependencies:**
- Soft deletes migration (if not exists)
- Status values clarification (0, 2, 3, 4)
- Seller dashboard route (if implementing view)

**Breaking Changes:** None - purely additive changes

---

## 🔧 Additional Recommendations

### 1. Clarify Status Values
Current assumptions:
- 0 = Active
- 2 = Hidden
- 3 = Paused
- 4 = Banned

**Action:** Verify actual status values in database or add constants to User model:
```php
// User model
const STATUS_ACTIVE = 0;
const STATUS_HIDDEN = 2;
const STATUS_PAUSED = 3;
const STATUS_BANNED = 4;
```

### 2. Add Indexes for Performance
```php
// In users table migration
$table->index('status');
$table->index('role');
$table->index(['role', 'status']);
```

### 3. Add Validation Rules
```php
// In updateSellerStatus method
$request->validate([
    'status' => 'required|in:0,2,3,4',
]);
```

### 4. Add Activity Logging
Consider logging all seller status changes for audit trail:
```php
\Log::info("Seller #{$seller->id} status changed to {$status} by admin #{auth()->id()}");
```

---

## ✅ Testing Checklist

After implementation, test:

- [ ] Page loads without errors
- [ ] Seller data displays correctly
- [ ] All 5 tabs work and show correct sellers
- [ ] Tab count badges are accurate
- [ ] Date filters work (Today, Yesterday, Last Week, etc.)
- [ ] Custom date range filter works
- [ ] Search functionality works
- [ ] Service type filter works
- [ ] Category filter works
- [ ] Pagination works and preserves filters
- [ ] Statistics cards show correct data
- [ ] Excel export downloads with correct data
- [ ] Hide seller action works
- [ ] Pause seller action works
- [ ] Ban seller action works
- [ ] Activate seller action works
- [ ] Delete seller action works (soft delete)
- [ ] Restore seller action works
- [ ] Empty state shows when no data
- [ ] Clear filters button works
- [ ] Responsive design works on mobile
- [ ] Profile pictures display correctly
- [ ] Rating display is accurate
- [ ] Earnings calculation is correct
- [ ] Tab switching preserves filters

---

**END OF PLAN**
