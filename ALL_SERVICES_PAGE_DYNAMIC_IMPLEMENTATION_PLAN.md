# All Services Page - Dynamic Implementation Plan

## 📋 Current State Analysis

### Database Column Verification (teacher_gigs table):
✅ **Verified Columns from Migration:**
- `id`, `user_id` (string, FK to users)
- `title` (service title)
- `service_role`, `service_type`
- `main_file` (NOT `image`)
- `category` (string, NOT `category_id`), `category_name`, `sub_category`
- `rate`, `public_rate`, `private_rate`
- `payment_type`, `freelance_type`, `freelance_service`
- `class_type`, `lesson_type`
- `delivery_time`, `revision`
- `full_available`, `start_date`, `start_time`
- `impressions`, `clicks`, `cancelation`, `orders`, `reviews`
- `status` (tinyInteger: 0=?, 1=active, etc.)
- `created_at`, `updated_at`

### Relationships Available:
- ✅ `user()` → belongsTo User
- ✅ `category()` → belongsTo Category (using `category` column, NOT FK)
- ✅ `all_reviews()` → hasMany ServiceReviews

### Issues Identified:

1. **100% Static Service Data** (Lines 350-2500+, repeated across 5 tabs)
   - All rows show identical hardcoded data in each tab
   - Seller: "Usama A." (repeated)
   - Date: "October 23, 2023" (hardcoded)
   - Service Type: "Freelance Service" (hardcoded)
   - Category: "Graphic Design" (hardcoded)
   - Title: "I'll Design most attractive and minimalists website" (hardcoded)
   - Lesson Type: "In Person" (hardcoded)
   - No database integration despite controller passing `$services`

2. **Non-Functional Filters** (Lines 93-232)
   - Date filter dropdown doesn't work
   - Custom date range fields don't submit
   - Search box doesn't search
   - No form submission action

3. **Static Tabs** (5 Tabs - Lines 244-307)
   - **Newly Created** (status = 0?)
   - **Active Services** (status = 1?)
   - **Delivered Services** (status = 2?)
   - **Cancelled Services** (status = 3?)
   - **Completed Services** (status = 4?)
   - All tabs display identical static data
   - No actual status filtering

4. **Non-Functional Actions** (Lines 366-426 per row)
   - Dropdown with 5 actions:
     - Add to Our Experts → Goes to "#"
     - Add to Trending Services → Goes to "#"
     - Set Commission Rate → Modal doesn't work
     - Hide Service → Goes to "#"
     - Cancel Service → Goes to "#"
   - No actual functionality implemented

5. **Missing Features**
   - No service statistics/summary cards
   - No seller filter (despite URL parameter `seller_id`)
   - No service type breakdown
   - No export functionality (Excel/PDF)
   - No bulk actions
   - No price/rate display
   - No order count display
   - No review/rating display
   - No thumbnail image display

6. **Data Already Available from Controller**
   - `$services` - Paginated TeacherGig models
   - Includes relationships: `user`, `category`
   - Includes: `all_reviews_avg_rating`

---

## 🎯 Implementation Plan

### **PHASE 1: Backend Controller Enhancement**

#### File: `app/Http/Controllers/AdminController.php`

**Current Method** (Line 1891):
```php
public function allServices()
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $services = \App\Models\TeacherGig::with(['user', 'category'])
        ->withAvg('all_reviews', 'rating')
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    return view('Admin-Dashboard.all-services', compact('services'));
}
```

**Enhanced Method**:
```php
public function allServices(Request $request)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    // Determine which tab/status to show
    $status = $request->get('status', 'newly_created');
    // Options: newly_created, active, delivered, cancelled, completed

    // Base query for services (teacher_gigs)
    $query = \App\Models\TeacherGig::query();

    // Apply status filter based on tab
    switch ($status) {
        case 'newly_created':
            $query->where('status', 0); // Newly created services
            break;
        case 'active':
            $query->where('status', 1); // Active services
            break;
        case 'delivered':
            $query->where('status', 2); // Delivered services
            break;
        case 'cancelled':
            $query->where('status', 3); // Cancelled services
            break;
        case 'completed':
            $query->where('status', 4); // Completed services
            break;
    }

    // FILTER 1: Seller Filter (from URL parameter)
    if ($request->filled('seller_id')) {
        $query->where('user_id', $request->seller_id);
    }

    // FILTER 2: Date Range Filter (Creation Date)
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

    // FILTER 3: Search (Title, Category, Seller Name)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('category_name', 'like', "%{$search}%")
              ->orWhereHas('user', function($userQuery) use ($search) {
                  $userQuery->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%");
              });
        });
    }

    // FILTER 4: Service Type
    if ($request->filled('service_type')) {
        $query->where('service_type', $request->service_type);
    }

    // FILTER 5: Service Role
    if ($request->filled('service_role')) {
        $query->where('service_role', $request->service_role);
    }

    // FILTER 6: Category
    if ($request->filled('category_id')) {
        $query->where('category', $request->category_id);
    }

    // FILTER 7: Price Range
    if ($request->filled('min_price')) {
        $query->where('rate', '>=', $request->min_price);
    }
    if ($request->filled('max_price')) {
        $query->where('rate', '<=', $request->max_price);
    }

    // Load relationships and calculate aggregates
    $query->with([
        'user:id,first_name,last_name,email,profile_pic',
        'user.expertProfile:id,user_id,category_class,category_freelance',
    ])
    ->withCount('all_reviews')
    ->withAvg('all_reviews as average_rating', 'rating');

    // Check if export is requested
    if ($request->has('export') && $request->export == 'excel') {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ServicesExport($query->get(), $status),
            'services_' . $status . '_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    // Get paginated services
    $services = $query->orderBy('created_at', 'desc')->paginate(20);

    // Calculate Statistics for each status
    $stats = [
        'total_services' => \App\Models\TeacherGig::count(),
        'newly_created' => \App\Models\TeacherGig::where('status', 0)->count(),
        'active_services' => \App\Models\TeacherGig::where('status', 1)->count(),
        'delivered_services' => \App\Models\TeacherGig::where('status', 2)->count(),
        'cancelled_services' => \App\Models\TeacherGig::where('status', 3)->count(),
        'completed_services' => \App\Models\TeacherGig::where('status', 4)->count(),
        'services_this_month' => \App\Models\TeacherGig::whereMonth('created_at', now()->month)->count(),
        'total_orders' => \App\Models\BookOrder::count(),
        'total_revenue' => \App\Models\Transaction::where('status', 'completed')->sum('total_amount'),
        'avg_service_price' => \App\Models\TeacherGig::whereNotNull('rate')->avg('rate'),
    ];

    // Get categories for filter dropdown
    $categories = \App\Models\Category::orderBy('category')->get(['id', 'category']);

    // Get seller info if filtering by seller
    $seller = null;
    if ($request->filled('seller_id')) {
        $seller = \App\Models\User::find($request->seller_id);
    }

    return view('Admin-Dashboard.all-services', compact('services', 'stats', 'categories', 'status', 'seller'));
}
```

**Add Action Methods**:

```php
/**
 * Update service status
 */
public function updateServiceStatus(Request $request, $id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $request->validate([
        'status' => 'required|in:0,1,2,3,4',
    ]);

    try {
        $service = \App\Models\TeacherGig::findOrFail($id);
        $service->status = $request->status;
        $service->save();

        $statusText = [
            0 => 'set as newly created',
            1 => 'activated',
            2 => 'marked as delivered',
            3 => 'cancelled',
            4 => 'completed'
        ];

        return redirect()->back()->with('success', 'Service ' . $statusText[$request->status] . ' successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to update service status: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update service status.');
    }
}

/**
 * Set service commission
 */
public function setServiceCommission(Request $request, $id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    $request->validate([
        'commission_rate' => 'required|numeric|min:0|max:100',
    ]);

    try {
        $serviceCommission = \App\Models\ServiceCommission::updateOrCreate(
            ['service_id' => $id],
            [
                'commission_rate' => $request->commission_rate,
                'is_active' => true,
            ]
        );

        return redirect()->back()->with('success', 'Service commission set successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to set service commission: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to set service commission.');
    }
}

/**
 * Hide/unhide service
 */
public function toggleServiceVisibility($id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    try {
        $service = \App\Models\TeacherGig::findOrFail($id);
        // Assuming status 5 = hidden, or use a separate column
        $service->status = ($service->status == 5) ? 1 : 5;
        $service->save();

        $message = ($service->status == 5) ? 'Service hidden successfully!' : 'Service made visible successfully!';
        return redirect()->back()->with('success', $message);
    } catch (\Exception $e) {
        \Log::error('Failed to toggle service visibility: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update service visibility.');
    }
}
```

**Changes Summary:**
- ✅ Add `Request $request` parameter for filters
- ✅ Implement status-based tab filtering
- ✅ Implement seller_id filter (from URL)
- ✅ Implement date range filtering
- ✅ Implement search functionality
- ✅ Add service type, role, category filters
- ✅ Add price range filter
- ✅ Calculate statistics
- ✅ Support Excel export
- ✅ Add service status management methods
- ✅ Add commission setting method
- ✅ Add visibility toggle method

---

### **PHASE 2: View File Complete Rewrite**

#### File: `resources/views/Admin-Dashboard/all-services.blade.php`

**Current State:** 2,606 lines of mostly duplicated static HTML across 5 tabs

**Proposed Changes:**

#### 2.1 Add Statistics Cards (After breadcrumb section)

```blade
<!-- Statistics Cards Section -->
<div class="row mb-4">
    <!-- Total Services -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Total Services</h6>
                        <h3 class="mb-0">{{ number_format($stats['total_services']) }}</h3>
                        <small class="text-muted">{{ $stats['services_this_month'] }} this month</small>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="bx bx-briefcase"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Services -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Active Services</h6>
                        <h3 class="mb-0">{{ number_format($stats['active_services']) }}</h3>
                        <small class="text-success">Currently active</small>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="bx bx-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Total Orders</h6>
                        <h3 class="mb-0">{{ number_format($stats['total_orders']) }}</h3>
                        <small class="text-muted">All bookings</small>
                    </div>
                    <div class="stat-icon bg-info">
                        <i class="bx bx-shopping-bag"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Price -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Avg Service Price</h6>
                        <h3 class="mb-0">${{ number_format($stats['avg_service_price'], 2) }}</h3>
                        <small class="text-muted">Across all services</small>
                    </div>
                    <div class="stat-icon bg-warning">
                        <i class="bx bx-dollar-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($seller)
<!-- Seller Filter Info -->
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="bx bx-info-circle"></i> Showing services for seller: <strong>{{ $seller->first_name }} {{ $seller->last_name }}</strong>
    <a href="{{ route('admin.all-services', array_except(request()->query(), ['seller_id'])) }}" class="btn btn-sm btn-primary ms-2">
        Clear Filter
    </a>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
```

#### 2.2 Make Filters Functional

```blade
<!-- Filter Section -->
<div class="date-section">
    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="{{ route('admin.all-services') }}" id="filterForm">
                <!-- Preserve current tab status and seller_id -->
                <input type="hidden" name="status" value="{{ $status }}">
                @if(request('seller_id'))
                    <input type="hidden" name="seller_id" value="{{ request('seller_id') }}">
                @endif

                <div class="row align-items-end">
                    <!-- Date Filter -->
                    <div class="col-md-2 mb-2">
                        <label class="form-label small"><strong>Creation Date</strong></label>
                        <select class="form-select" name="date_filter" id="dateFilter">
                            <option value="">All Time</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                            <option value="last_7_days" {{ request('date_filter') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="current_month" {{ request('date_filter') == 'current_month' ? 'selected' : '' }}>This Month</option>
                            <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                            <option value="custom" {{ request('date_filter') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                        </select>
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
                                    {{ $category->category }}
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
                                   placeholder="Search by title, category, or seller name..."
                                   value="{{ request('search') }}" />
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        @if(request()->hasAny(['date_filter', 'search', 'service_type', 'category_id']))
                            <a href="{{ route('admin.all-services', array_merge(['status' => $status], request()->only('seller_id'))) }}" class="btn btn-secondary">
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

#### 2.3 Update Tab Navigation

```blade
<div class="super-tab-nav">
    <nav>
        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <!-- Newly Created Tab -->
            <a class="nav-link {{ $status == 'newly_created' ? 'active' : '' }}"
               href="{{ route('admin.all-services', array_merge(request()->except('status'), ['status' => 'newly_created'])) }}">
                Newly Created
                <span class="badge bg-primary ms-1">{{ $stats['newly_created'] }}</span>
            </a>

            <!-- Active Services Tab -->
            <a class="nav-link {{ $status == 'active' ? 'active' : '' }}"
               href="{{ route('admin.all-services', array_merge(request()->except('status'), ['status' => 'active'])) }}">
                Active Services
                <span class="badge bg-success ms-1">{{ $stats['active_services'] }}</span>
            </a>

            <!-- Delivered Services Tab -->
            <a class="nav-link {{ $status == 'delivered' ? 'active' : '' }}"
               href="{{ route('admin.all-services', array_merge(request()->except('status'), ['status' => 'delivered'])) }}">
                Delivered Services
                <span class="badge bg-info ms-1">{{ $stats['delivered_services'] }}</span>
            </a>

            <!-- Cancelled Services Tab -->
            <a class="nav-link {{ $status == 'cancelled' ? 'active' : '' }}"
               href="{{ route('admin.all-services', array_merge(request()->except('status'), ['status' => 'cancelled'])) }}">
                Cancelled Services
                <span class="badge bg-danger ms-1">{{ $stats['cancelled_services'] }}</span>
            </a>

            <!-- Completed Services Tab -->
            <a class="nav-link {{ $status == 'completed' ? 'active' : '' }}"
               href="{{ route('admin.all-services', array_merge(request()->except('status'), ['status' => 'completed'])) }}">
                Completed Services
                <span class="badge bg-secondary ms-1">{{ $stats['completed_services'] }}</span>
            </a>
        </div>
    </nav>
</div>
```

#### 2.4 Replace All 5 Static Tab Content Sections with One Dynamic Table

**Remove:** All static tab-pane sections (Lines 310-2500+)

**Replace with:**

```blade
<!-- Services Table (Single Dynamic Table) -->
<div class="tab-content border bg-light">
    <div class="main-container d-flex">
        <div class="content w-100">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 p-0">
                        <div class="row installment-table">
                            <div class="col-md-12 p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr class="text-nowrap">
                                                <th>Service ID</th>
                                                <th>Thumbnail</th>
                                                <th>Seller</th>
                                                <th>Created Date</th>
                                                <th>Service Type</th>
                                                <th>Category</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Rating</th>
                                                <th>Orders</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($services as $service)
                                                <tr>
                                                    <!-- Service ID -->
                                                    <td>#{{ str_pad($service->id, 6, '0', STR_PAD_LEFT) }}</td>

                                                    <!-- Thumbnail -->
                                                    <td>
                                                        @if($service->main_file)
                                                            <img src="/storage/{{ $service->main_file }}"
                                                                 class="rounded"
                                                                 width="60" height="60"
                                                                 style="object-fit: cover;"
                                                                 alt="Service">
                                                        @else
                                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                                                 style="width: 60px; height: 60px;">
                                                                <i class="bx bx-image text-white"></i>
                                                            </div>
                                                        @endif
                                                    </td>

                                                    <!-- Seller -->
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if($service->user)
                                                                @if($service->user->profile_pic)
                                                                    <img src="/storage/{{ $service->user->profile_pic }}"
                                                                         class="rounded-circle"
                                                                         width="35" height="35" alt="Seller">
                                                                @else
                                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                                         style="width: 35px; height: 35px; font-size: 14px;">
                                                                        {{ strtoupper(substr($service->user->first_name, 0, 1)) }}
                                                                    </div>
                                                                @endif
                                                                <div>
                                                                    <strong>{{ $service->user->first_name }} {{ $service->user->last_name }}</strong><br>
                                                                    <small class="text-muted">{{ $service->user->email }}</small>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <!-- Created Date -->
                                                    <td class="text-nowrap">
                                                        {{ $service->created_at->format('M d, Y') }}<br>
                                                        <small class="text-muted">{{ $service->created_at->diffForHumans() }}</small>
                                                    </td>

                                                    <!-- Service Type -->
                                                    <td>
                                                        @if($service->service_type)
                                                            <span class="badge bg-info">{{ $service->service_type }}</span>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Category -->
                                                    <td>
                                                        {{ $service->category_name ?? $service->category ?? 'N/A' }}
                                                    </td>

                                                    <!-- Title -->
                                                    <td style="max-width: 250px;">
                                                        <div class="text-truncate" title="{{ $service->title }}">
                                                            {{ $service->title ?? 'Untitled Service' }}
                                                        </div>
                                                    </td>

                                                    <!-- Price -->
                                                    <td class="text-nowrap">
                                                        @if($service->rate)
                                                            <strong class="text-success">${{ number_format($service->rate, 2) }}</strong>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Rating -->
                                                    <td>
                                                        @if($service->average_rating)
                                                            <div class="d-flex align-items-center">
                                                                <i class="bx bxs-star text-warning"></i>
                                                                <span class="ms-1">{{ number_format($service->average_rating, 1) }}</span>
                                                            </div>
                                                            <small class="text-muted">({{ $service->all_reviews_count ?? 0 }})</small>
                                                        @else
                                                            <span class="text-muted">No reviews</span>
                                                        @endif
                                                    </td>

                                                    <!-- Orders -->
                                                    <td>
                                                        <strong>{{ $service->orders ?? 0 }}</strong>
                                                    </td>

                                                    <!-- Status Badge -->
                                                    <td>
                                                        @if($service->status == 0)
                                                            <span class="badge bg-primary">New</span>
                                                        @elseif($service->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @elseif($service->status == 2)
                                                            <span class="badge bg-info">Delivered</span>
                                                        @elseif($service->status == 3)
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @elseif($service->status == 4)
                                                            <span class="badge bg-secondary">Completed</span>
                                                        @else
                                                            <span class="badge bg-dark">Unknown</span>
                                                        @endif
                                                    </td>

                                                    <!-- Actions -->
                                                    <td>
                                                        <div class="expert-dropdown">
                                                            <button class="btn action-btn" type="button"
                                                                    id="dropdownMenuButton{{ $service->id }}"
                                                                    data-bs-toggle="dropdown"
                                                                    aria-expanded="false">
                                                                ...
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $service->id }}">
                                                                <!-- View Service -->
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ url('/service/' . $service->id) }}" target="_blank">
                                                                        <i class="bx bx-show"></i> View Service
                                                                    </a>
                                                                </li>

                                                                <!-- View Seller -->
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('admin.all-sellers') }}?search={{ $service->user_id }}">
                                                                        <i class="bx bx-user"></i> View Seller
                                                                    </a>
                                                                </li>

                                                                <li><hr class="dropdown-divider"></li>

                                                                <!-- Set Commission -->
                                                                <li>
                                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#commissionModal{{ $service->id }}">
                                                                        <i class="bx bx-money"></i> Set Commission
                                                                    </a>
                                                                </li>

                                                                <li><hr class="dropdown-divider"></li>

                                                                <!-- Status Actions -->
                                                                @if($status != 'active')
                                                                    <li>
                                                                        <a class="dropdown-item text-success" href="#"
                                                                           onclick="updateServiceStatus({{ $service->id }}, 1); return false;">
                                                                            <i class="bx bx-check-circle"></i> Activate Service
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if($status != 'cancelled')
                                                                    <li>
                                                                        <a class="dropdown-item text-danger" href="#"
                                                                           onclick="confirmCancel({{ $service->id }}); return false;">
                                                                            <i class="bx bx-x-circle"></i> Cancel Service
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
                                                        <p class="text-muted mt-2">No services found</p>
                                                        @if(request()->hasAny(['date_filter', 'search', 'service_type', 'category_id']))
                                                            <a href="{{ route('admin.all-services', array_merge(['status' => $status], request()->only('seller_id'))) }}"
                                                               class="btn btn-sm btn-primary">Clear Filters</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-3 px-3 pb-3">
                                    <div class="text-muted">
                                        Showing {{ $services->firstItem() ?? 0 }} to {{ $services->lastItem() ?? 0 }}
                                        of {{ $services->total() }} services
                                    </div>
                                    <div>
                                        {{ $services->appends(request()->query())->links('pagination::bootstrap-5') }}
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

#### 2.5 Add JavaScript and CSS

```javascript
<script>
// Export to Excel
document.getElementById('exportExcel')?.addEventListener('click', function() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'excel');
    window.location.href = '{{ route("admin.all-services") }}?' + params.toString();
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

// Update service status
function updateServiceStatus(serviceId, status) {
    const statusText = {
        0: 'set as newly created',
        1: 'activate',
        2: 'mark as delivered',
        3: 'cancel',
        4: 'complete'
    };

    if (confirm(`Are you sure you want to ${statusText[status]} this service?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/services/' + serviceId + '/status';

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

// Confirm cancel
function confirmCancel(serviceId) {
    if (confirm('Are you sure you want to cancel this service?')) {
        updateServiceStatus(serviceId, 3);
    }
}
</script>

<style>
.stat-card {
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    transition: transform 0.2s;
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
.action-btn {
    background: transparent;
    border: none;
    font-size: 20px;
    font-weight: bold;
    color: #0072b1;
    cursor: pointer;
}
</style>
```

---

### **PHASE 3: Create Excel Export Class**

#### File: `app/Exports/ServicesExport.php` (NEW)

```php
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServicesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $services;
    protected $status;

    public function __construct($services, $status = 'all')
    {
        $this->services = $services;
        $this->status = $status;
    }

    public function collection()
    {
        return $this->services;
    }

    public function headings(): array
    {
        return [
            'Service ID',
            'Title',
            'Seller Name',
            'Seller Email',
            'Service Type',
            'Service Role',
            'Category',
            'Sub Category',
            'Price',
            'Payment Type',
            'Status',
            'Total Orders',
            'Total Reviews',
            'Average Rating',
            'Impressions',
            'Clicks',
            'Created At',
        ];
    }

    public function map($service): array
    {
        $statusText = [
            0 => 'Newly Created',
            1 => 'Active',
            2 => 'Delivered',
            3 => 'Cancelled',
            4 => 'Completed',
        ];

        return [
            str_pad($service->id, 6, '0', STR_PAD_LEFT),
            $service->title ?? 'Untitled',
            $service->user ? $service->user->first_name . ' ' . $service->user->last_name : 'N/A',
            $service->user ? $service->user->email : 'N/A',
            $service->service_type ?? 'N/A',
            $service->service_role ?? 'N/A',
            $service->category_name ?? $service->category ?? 'N/A',
            $service->sub_category ?? 'N/A',
            $service->rate ?? '0.00',
            $service->payment_type ?? 'N/A',
            $statusText[$service->status] ?? 'Unknown',
            $service->orders ?? 0,
            $service->all_reviews_count ?? 0,
            $service->average_rating ? number_format($service->average_rating, 2) : 'N/A',
            $service->impressions ?? 0,
            $service->clicks ?? 0,
            $service->created_at->format('Y-m-d H:i:s'),
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

Add these routes after the all-services route:

```php
Route::get('/admin/all-services', 'allServices')->name('admin.all-services');
Route::post('/admin/services/{id}/status', 'updateServiceStatus')->name('admin.services.update-status');
Route::post('/admin/services/{id}/commission', 'setServiceCommission')->name('admin.services.set-commission');
Route::post('/admin/services/{id}/toggle-visibility', 'toggleServiceVisibility')->name('admin.services.toggle-visibility');
```

---

## 📊 Summary of Changes

### Files to Modify:
1. ✅ `app/Http/Controllers/AdminController.php` - Enhanced allServices() + 3 new action methods
2. ✅ `resources/views/Admin-Dashboard/all-services.blade.php` - Complete rewrite (reduce from 2,606 to ~800 lines)
3. ✅ `routes/web.php` - Add 3 new routes

### Files to Create:
4. ✅ `app/Exports/ServicesExport.php` - Excel export functionality

---

## ✨ New Features to Implement

### Statistics Dashboard (NEW)
- ✅ Total services count
- ✅ Active services count
- ✅ Total orders count
- ✅ Average service price

### Advanced Filters (NEW)
- ✅ Filter by seller_id (from URL parameter)
- ✅ Filter by creation date
- ✅ Service type filter
- ✅ Category filter
- ✅ Search by title, category, seller name
- ✅ Filters preserved across pagination

### Dynamic Tab System (NEW)
- ✅ Newly Created (status = 0)
- ✅ Active Services (status = 1)
- ✅ Delivered Services (status = 2)
- ✅ Cancelled Services (status = 3)
- ✅ Completed Services (status = 4)
- ✅ Count badges on each tab

### Service Table Features (NEW)
- ✅ Service thumbnail display
- ✅ Seller info with profile picture
- ✅ Service type badges
- ✅ Category name display
- ✅ Price display
- ✅ Rating with review count
- ✅ Order count
- ✅ Status badges
- ✅ Creation date with "time ago"

### Service Actions (NEW)
- ✅ View service (public page)
- ✅ View seller details
- ✅ Set custom commission
- ✅ Activate service
- ✅ Cancel service
- ✅ Status change with confirmation

### Export & Reporting (NEW)
- ✅ Excel export with all filters
- ✅ 17 columns of comprehensive data
- ✅ Status-specific file naming

---

## 🔧 Database Column Reference (VERIFIED)

### teacher_gigs table:
- `id`, `user_id`, `title`
- `service_role`, `service_type`
- `main_file` (NOT image)
- `category`, `category_name`, `sub_category`
- `rate`, `public_rate`, `private_rate`
- `payment_type`, `freelance_type`, `freelance_service`
- `class_type`, `lesson_type`
- `delivery_time`, `revision`
- `full_available`, `start_date`, `start_time`
- `impressions`, `clicks`, `cancelation`, `orders`, `reviews`
- `status` (0=new, 1=active, 2=delivered, 3=cancelled, 4=completed)
- `created_at`, `updated_at`

### Relationships:
- `user()` - belongsTo User
- `category()` - belongsTo Category (using `category` column as string, NOT FK)
- `all_reviews()` - hasMany ServiceReviews

---

## 📝 Implementation Priority

**High Priority:**
1. Dynamic service table with real data
2. Tab-based status filtering
3. Seller_id filter support
4. Basic filters (date, search)
5. Statistics cards

**Medium Priority:**
6. Service actions (activate, cancel)
7. Category and service type filters
8. Excel export
9. Commission setting
10. Thumbnail display

**Low Priority:**
11. Advanced filters
12. Bulk actions
13. Service visibility toggle

---

**Estimated Time:** 6-7 hours for full implementation

**Dependencies:**
- ServiceCommission model/table (may need to verify structure)
- Status value clarification (0,1,2,3,4)
- Image path verification (/storage/ or /assets/)

---

**END OF PLAN**
