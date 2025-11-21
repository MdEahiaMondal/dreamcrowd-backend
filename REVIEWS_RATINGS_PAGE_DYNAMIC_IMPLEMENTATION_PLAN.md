# Reviews & Ratings Page - Dynamic Implementation Plan

## 📋 Current State Analysis

### Issues Identified:

1. **100% Static Table Data** (Lines 109-309)
   - All 10 rows show identical hardcoded data
   - Seller: "Usama A." (repeated)
   - Buyer: "Orhan Khan" (repeated)
   - Service: Same image and "Learn How to design" title
   - Review: Same text "This Course is very helpful for Beginners I learn ......"
   - Rating: Hardcoded 4-star SVG graphics
   - Date: All show "June 15, 2023"
   - No real database integration despite controller passing `$reviews`

2. **Non-Functional Search** (Line 80)
   - Search box exists but doesn't submit/filter

3. **Missing Statistics Display**
   - Controller calculates stats but view doesn't display them:
     - `total_reviews`
     - `average_rating`
     - `five_star` count
     - `one_star` count

4. **Static Pagination** (Lines 321-341)
   - Hardcoded page numbers (1-5)
   - No connection to actual data pagination

5. **Non-Functional Actions** (Lines 124-130, repeated)
   - View and Delete dropdown links go to "#"
   - No actual functionality

6. **Missing Features**
   - No date range filters
   - No rating filters (1-5 stars)
   - No service type filters
   - No seller/buyer filters
   - No review moderation (approve/reject)
   - No export functionality
   - No review reply management
   - Hardcoded SVG stars instead of dynamic star component

7. **Data Available from Controller** (Currently Unused)
   - `$reviews` - Paginated reviews with relationships (user, teacher, gig, replies)
   - `$stats` - Statistics array with 4 metrics

---

## 🎯 Implementation Plan

### **PHASE 1: Backend Controller Enhancement**

#### File: `app/Http/Controllers/AdminController.php`

**Current Method** (Line 1934):
```php
public function reviewsRatings()
{
    $reviews = \App\Models\ServiceReviews::with(['user', 'teacher', 'gig', 'replies'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

    $stats = [
        'total_reviews' => \App\Models\ServiceReviews::count(),
        'average_rating' => \App\Models\ServiceReviews::avg('rating'),
        'five_star' => \App\Models\ServiceReviews::where('rating', 5)->count(),
        'one_star' => \App\Models\ServiceReviews::where('rating', 1)->count(),
    ];

    return view('Admin-Dashboard.reviews&rating', compact('reviews', 'stats'));
}
```

**Enhanced Method**:
```php
public function reviewsRatings(Request $request)
{
    // Base query with relationships
    $query = \App\Models\ServiceReviews::with([
        'user:id,first_name,last_name,email,profile_pic',
        'teacher:id,first_name,last_name,email,profile_pic',
        'gig:id,title,service_role,service_type,image',
        'replies.user:id,first_name,last_name'
    ])->whereNull('parent_id'); // Only parent reviews, not replies

    // FILTER 1: Rating Filter
    if ($request->filled('rating')) {
        $query->where('rating', $request->rating);
    }

    // FILTER 2: Date Range Filter
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

    // FILTER 3: Search (Buyer/Seller name, Service title, Review text)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('teacher', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('gig', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })
            ->orWhere('cmnt', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%");
        });
    }

    // FILTER 4: Service Type
    if ($request->filled('service_type')) {
        $query->whereHas('gig', function($q) use ($request) {
            $q->where('service_type', $request->service_type);
        });
    }

    // FILTER 5: With/Without Replies
    if ($request->filled('has_replies')) {
        if ($request->has_replies == 'yes') {
            $query->has('replies');
        } elseif ($request->has_replies == 'no') {
            $query->doesntHave('replies');
        }
    }

    // FILTER 6: Seller Filter
    if ($request->filled('seller_id')) {
        $query->where('teacher_id', $request->seller_id);
    }

    // Check if export is requested
    if ($request->has('export') && $request->export == 'excel') {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ReviewsExport($query->get()),
            'reviews_' . now()->format('Y-m-d_His') . '.xlsx'
        );
    }

    // Get paginated reviews
    $reviews = $query->orderBy('created_at', 'desc')->paginate(20);

    // Enhanced Statistics
    $stats = [
        'total_reviews' => \App\Models\ServiceReviews::whereNull('parent_id')->count(),
        'average_rating' => round(\App\Models\ServiceReviews::whereNull('parent_id')->avg('rating'), 2),
        'five_star' => \App\Models\ServiceReviews::whereNull('parent_id')->where('rating', 5)->count(),
        'four_star' => \App\Models\ServiceReviews::whereNull('parent_id')->where('rating', 4)->count(),
        'three_star' => \App\Models\ServiceReviews::whereNull('parent_id')->where('rating', 3)->count(),
        'two_star' => \App\Models\ServiceReviews::whereNull('parent_id')->where('rating', 2)->count(),
        'one_star' => \App\Models\ServiceReviews::whereNull('parent_id')->where('rating', 1)->count(),
        'total_replies' => \App\Models\ServiceReviews::whereNotNull('parent_id')->count(),
        'reviews_this_month' => \App\Models\ServiceReviews::whereNull('parent_id')
            ->whereMonth('created_at', now()->month)->count(),
        'unanswered_reviews' => \App\Models\ServiceReviews::whereNull('parent_id')
            ->doesntHave('replies')->count(),
    ];

    // Get top sellers for filter dropdown
    $topSellers = \App\Models\User::where('role', 1)
        ->withCount('receivedReviews')
        ->having('received_reviews_count', '>', 0)
        ->orderBy('received_reviews_count', 'desc')
        ->limit(50)
        ->get(['id', 'first_name', 'last_name']);

    return view('Admin-Dashboard.reviews&rating', compact('reviews', 'stats', 'topSellers'));
}
```

**Add Delete Method**:
```php
/**
 * Delete a review
 */
public function deleteReview($id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    try {
        $review = \App\Models\ServiceReviews::findOrFail($id);

        // Delete replies first
        $review->replies()->delete();

        // Delete the review
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    } catch (\Exception $e) {
        \Log::error('Failed to delete review: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to delete review.');
    }
}
```

---

### **PHASE 2: View File Complete Rewrite**

#### File: `resources/views/Admin-Dashboard/reviews&rating.blade.php`

**Changes to Make:**

#### 2.1 Add Statistics Cards (After line 71)
```blade
<!-- Statistics Cards Section -->
<div class="row mb-4">
    <!-- Total Reviews -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Total Reviews</h6>
                        <h3 class="mb-0">{{ number_format($stats['total_reviews']) }}</h3>
                        <small class="text-muted">{{ $stats['reviews_this_month'] }} this month</small>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="bx bx-comment-detail"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Rating -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Average Rating</h6>
                        <h3 class="mb-0">
                            {{ $stats['average_rating'] }} <i class="bx bxs-star text-warning"></i>
                        </h3>
                        <small class="text-muted">Out of 5.0</small>
                    </div>
                    <div class="stat-icon bg-warning">
                        <i class="bx bx-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5-Star Reviews -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">5-Star Reviews</h6>
                        <h3 class="mb-0">{{ number_format($stats['five_star']) }}</h3>
                        <small class="text-success">
                            {{ $stats['total_reviews'] > 0 ? round(($stats['five_star'] / $stats['total_reviews']) * 100, 1) : 0 }}% of total
                        </small>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="bx bx-happy"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unanswered Reviews -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-1">Unanswered</h6>
                        <h3 class="mb-0">{{ number_format($stats['unanswered_reviews']) }}</h3>
                        <small class="text-warning">Need seller response</small>
                    </div>
                    <div class="stat-icon bg-info">
                        <i class="bx bx-message-alt-x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rating Distribution Chart -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Rating Distribution</h5>
                <div class="rating-bars">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        @php
                            $count = $stats[$star === 5 ? 'five_star' : ($star === 4 ? 'four_star' : ($star === 3 ? 'three_star' : ($star === 2 ? 'two_star' : 'one_star')))];
                            $percentage = $stats['total_reviews'] > 0 ? ($count / $stats['total_reviews']) * 100 : 0;
                        @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div style="width: 60px;">{{ $star }} <i class="bx bxs-star text-warning"></i></div>
                            <div class="progress flex-grow-1 mx-3" style="height: 20px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                     style="width: {{ $percentage }}%">
                                </div>
                            </div>
                            <div style="width: 80px; text-align: right;">
                                {{ number_format($count) }} ({{ round($percentage, 1) }}%)
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
```

#### 2.2 Add Functional Filters (Replace lines 73-84)
```blade
<!-- Filter Section -->
<div class="filter-section">
    <form method="GET" action="{{ route('admin.reviews.ratings') }}" id="filterForm">
        <div class="row align-items-end">
            <!-- Rating Filter -->
            <div class="col-md-2 mb-2">
                <label class="form-label small"><strong>Rating</strong></label>
                <select class="form-select" name="rating">
                    <option value="">All Ratings</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>

            <!-- Date Filter -->
            <div class="col-md-2 mb-2">
                <label class="form-label small"><strong>Date Filter</strong></label>
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

            <!-- Has Replies Filter -->
            <div class="col-md-2 mb-2">
                <label class="form-label small"><strong>Replies</strong></label>
                <select class="form-select" name="has_replies">
                    <option value="">All</option>
                    <option value="yes" {{ request('has_replies') == 'yes' ? 'selected' : '' }}>With Replies</option>
                    <option value="no" {{ request('has_replies') == 'no' ? 'selected' : '' }}>No Replies</option>
                </select>
            </div>
        </div>

        <!-- Search & Actions Row -->
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bx bx-search"></i></span>
                    <input type="text" name="search" class="form-control"
                           placeholder="Search by buyer, seller, service, or review text..."
                           value="{{ request('search') }}" />
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-filter"></i> Filter
                </button>
                @if(request()->hasAny(['rating', 'date_filter', 'search', 'service_type', 'has_replies']))
                    <a href="{{ route('admin.reviews.ratings') }}" class="btn btn-secondary">
                        <i class="bx bx-reset"></i> Clear
                    </a>
                @endif
                <button type="button" class="btn btn-success" id="exportExcel">
                    <i class="bx bx-download"></i> Export Excel
                </button>
            </div>
        </div>
    </form>
</div>
```

#### 2.3 Replace Static Table with Dynamic Data (Lines 94-312)
```blade
<table class="table">
    <thead>
        <tr class="text-nowrap">
            <th>Review ID</th>
            <th>Seller</th>
            <th>Buyer</th>
            <th>Service</th>
            <th>Review</th>
            <th>Rating</th>
            <th>Date</th>
            <th>Replies</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reviews as $review)
            <tr>
                <!-- Review ID -->
                <td><small class="text-muted">#{{ $review->id }}</small></td>

                <!-- Seller -->
                <td>
                    @if($review->teacher)
                        <div class="d-flex align-items-center">
                            @if($review->teacher->profile_pic)
                                <img src="/storage/{{ $review->teacher->profile_pic }}"
                                     class="rounded-circle me-2"
                                     width="40" height="40" alt="Seller">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                     style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($review->teacher->first_name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $review->teacher->first_name }} {{ $review->teacher->last_name }}</strong><br>
                                <small class="text-muted">{{ $review->teacher->email }}</small>
                            </div>
                        </div>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>

                <!-- Buyer -->
                <td>
                    @if($review->user)
                        <div class="d-flex align-items-center">
                            @if($review->user->profile_pic)
                                <img src="/storage/{{ $review->user->profile_pic }}"
                                     class="rounded-circle me-2"
                                     width="40" height="40" alt="Buyer">
                            @else
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                     style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($review->user->first_name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $review->user->first_name }} {{ $review->user->last_name }}</strong><br>
                                <small class="text-muted">{{ $review->user->email }}</small>
                            </div>
                        </div>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>

                <!-- Service -->
                <td>
                    @if($review->gig)
                        <div class="d-flex align-items-center">
                            @if($review->gig->image)
                                <img src="/storage/{{ $review->gig->image }}"
                                     class="table-img me-2" width="50" alt="Service">
                            @endif
                            <div>
                                <strong>{{ Str::limit($review->gig->title, 30) }}</strong><br>
                                <small class="badge bg-info">{{ $review->gig->service_type }}</small>
                            </div>
                        </div>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif
                </td>

                <!-- Review Text -->
                <td>
                    <p class="review-text mb-0">{{ Str::limit($review->cmnt, 80) }}</p>
                    @if(strlen($review->cmnt) > 80)
                        <a href="#" class="text-primary small" data-bs-toggle="modal"
                           data-bs-target="#reviewModal{{ $review->id }}">Read more...</a>
                    @endif
                </td>

                <!-- Rating (Dynamic Stars) -->
                <td>
                    <div class="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="bx bxs-star text-warning"></i>
                            @else
                                <i class="bx bx-star text-muted"></i>
                            @endif
                        @endfor
                        <br>
                        <small class="text-muted">({{ $review->rating }}/5)</small>
                    </div>
                </td>

                <!-- Date -->
                <td class="text-nowrap">
                    {{ $review->created_at->format('M d, Y') }}<br>
                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                </td>

                <!-- Replies Count -->
                <td class="text-center">
                    @if($review->replies->count() > 0)
                        <span class="badge bg-success">
                            {{ $review->replies->count() }} {{ Str::plural('reply', $review->replies->count()) }}
                        </span>
                    @else
                        <span class="badge bg-secondary">No replies</span>
                    @endif
                </td>

                <!-- Actions -->
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info"
                                data-bs-toggle="modal"
                                data-bs-target="#reviewModal{{ $review->id }}"
                                title="View Details">
                            <i class="bx bx-show"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger"
                                onclick="confirmDelete({{ $review->id }})"
                                title="Delete Review">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Review Details Modal -->
            <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Review Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Buyer Information</h6>
                                    <p><strong>Name:</strong> {{ $review->user->first_name }} {{ $review->user->last_name }}</p>
                                    <p><strong>Email:</strong> {{ $review->user->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Seller Information</h6>
                                    <p><strong>Name:</strong> {{ $review->teacher->first_name }} {{ $review->teacher->last_name }}</p>
                                    <p><strong>Email:</strong> {{ $review->teacher->email }}</p>
                                </div>
                            </div>
                            <hr>
                            <h6>Service</h6>
                            <p>{{ $review->gig->title }}</p>
                            <hr>
                            <h6>Rating</h6>
                            <div class="star-rating mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bx bxs-star text-warning" style="font-size: 24px;"></i>
                                    @else
                                        <i class="bx bx-star text-muted" style="font-size: 24px;"></i>
                                    @endif
                                @endfor
                                <span class="ms-2">({{ $review->rating }}/5)</span>
                            </div>
                            <hr>
                            <h6>Review</h6>
                            <p>{{ $review->cmnt }}</p>

                            @if($review->replies->count() > 0)
                                <hr>
                                <h6>Seller Replies ({{ $review->replies->count() }})</h6>
                                @foreach($review->replies as $reply)
                                    <div class="alert alert-light">
                                        <strong>{{ $reply->user->first_name }} {{ $reply->user->last_name }}</strong>
                                        <small class="text-muted">({{ $reply->created_at->diffForHumans() }})</small>
                                        <p class="mb-0 mt-2">{{ $reply->cmnt }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <tr>
                <td colspan="9" class="text-center py-4">
                    <i class="bx bx-info-circle" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-2">No reviews found</p>
                    @if(request()->hasAny(['rating', 'date_filter', 'search', 'service_type']))
                        <a href="{{ route('admin.reviews.ratings') }}" class="btn btn-sm btn-primary">Clear Filters</a>
                    @endif
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
```

#### 2.4 Replace Static Pagination with Laravel Pagination (Lines 321-341)
```blade
<!-- Pagination -->
<div class="d-flex justify-content-between align-items-center mt-3">
    <div class="text-muted">
        Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }}
        of {{ $reviews->total() }} reviews
    </div>
    <div>
        {{ $reviews->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    window.location.href = '{{ route("admin.reviews.ratings") }}?' + params.toString();
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

// Delete confirmation
function confirmDelete(reviewId) {
    if (confirm('Are you sure you want to delete this review? This action cannot be undone.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/reviews/' + reviewId + '/delete';

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
    justify-content-center;
    font-size: 24px;
    color: white;
}
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.table td {
    vertical-align: middle;
}
.review-text {
    font-size: 14px;
    line-height: 1.5;
}
.table-img {
    border-radius: 8px;
    object-fit: cover;
}
.star-rating i {
    font-size: 18px;
}
.rating-bars {
    padding: 10px 0;
}
</style>
```

---

### **PHASE 3: Create Excel Export Class**

#### File: `app/Exports/ReviewsExport.php` (NEW)

```php
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReviewsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $reviews;

    public function __construct($reviews)
    {
        $this->reviews = $reviews;
    }

    public function collection()
    {
        return $this->reviews;
    }

    public function headings(): array
    {
        return [
            'Review ID',
            'Date',
            'Seller Name',
            'Seller Email',
            'Buyer Name',
            'Buyer Email',
            'Service Title',
            'Service Type',
            'Rating',
            'Review Text',
            'Replies Count',
            'Created At',
        ];
    }

    public function map($review): array
    {
        return [
            $review->id,
            $review->created_at->format('Y-m-d'),
            $review->teacher ? $review->teacher->first_name . ' ' . $review->teacher->last_name : 'N/A',
            $review->teacher ? $review->teacher->email : 'N/A',
            $review->user ? $review->user->first_name . ' ' . $review->user->last_name : 'N/A',
            $review->user ? $review->user->email : 'N/A',
            $review->gig ? $review->gig->title : 'N/A',
            $review->gig ? $review->gig->service_type : 'N/A',
            $review->rating . '/5',
            $review->cmnt,
            $review->replies->count(),
            $review->created_at->format('Y-m-d H:i:s'),
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

### **PHASE 4: Add Routes**

#### File: `routes/web.php`

Add these routes:
```php
// Reviews & Ratings
Route::get('/admin/reviews-ratings', [AdminController::class, 'reviewsRatings'])->name('admin.reviews.ratings');
Route::post('/admin/reviews/{id}/delete', [AdminController::class, 'deleteReview'])->name('admin.reviews.delete');
```

---

## 📊 Summary of Changes

### Files to Modify:
1. ✅ `app/Http/Controllers/AdminController.php` - Enhanced reviewsRatings() method + deleteReview() method
2. ✅ `resources/views/Admin-Dashboard/reviews&rating.blade.php` - Complete rewrite

### Files to Create:
3. ✅ `app/Exports/ReviewsExport.php` - Excel export functionality

### Files to Update:
4. ✅ `routes/web.php` - Add review routes

---

## ✨ New Features to Implement

### Statistics Dashboard (NEW)
- ✅ Total reviews count
- ✅ Average rating display
- ✅ 5-star reviews count & percentage
- ✅ Unanswered reviews count
- ✅ Rating distribution chart (1-5 stars)
- ✅ Monthly review count

### Advanced Filters (NEW)
- ✅ Filter by rating (1-5 stars)
- ✅ Date range filters (Today, Yesterday, Last 7 Days, Custom Range, etc.)
- ✅ Service type filter
- ✅ Has replies filter (With/Without replies)
- ✅ Search by buyer, seller, service, or review text

### Dynamic Table Features (NEW)
- ✅ Real review data from database
- ✅ Buyer & seller information with profile pictures
- ✅ Service details with image
- ✅ Dynamic star ratings (not hardcoded SVG)
- ✅ Review text with "Read more" for long reviews
- ✅ Reply count badges
- ✅ Time ago display

### Review Details Modal (NEW)
- ✅ Full review details in modal
- ✅ Buyer & seller complete information
- ✅ Service information
- ✅ All seller replies displayed
- ✅ Large star rating display

### Actions (NEW)
- ✅ View review details button
- ✅ Delete review with confirmation
- ✅ Delete also removes all replies

### Export & Reporting (NEW)
- ✅ Excel export with all filters applied
- ✅ Comprehensive data export (12 columns)

### UI/UX Improvements
- ✅ Professional statistics cards
- ✅ Rating distribution visual chart
- ✅ User profile pictures
- ✅ Service thumbnails
- ✅ Better table layout
- ✅ Modal for full review details
- ✅ Confirmation dialogs
- ✅ Empty state handling
- ✅ Filter persistence in pagination

---

## 🎨 UI Components

### Star Rating Component
- Dynamic star generation (filled/empty)
- Visual rating display
- Numeric rating alongside

### Profile Picture Component
- Shows user profile pictures
- Fallback to initials in colored circle
- Consistent 40px circles

### Rating Distribution Chart
- Visual progress bars for each rating (1-5 stars)
- Percentage calculation
- Count display

### Review Modal
- Full review details
- All replies displayed
- Seller & buyer info
- Service information

---

## 📝 Notes

- All packages required are already installed
- No database migrations needed
- Existing controller already passes some data
- Route might need updating to match naming convention
- Profile pictures path assumes `/storage/` prefix
- Delete functionality uses POST method (add CSRF protection)

---

## 🚀 Implementation Priority

**High Priority (Must Have):**
1. Dynamic table with real data
2. Star rating display
3. Basic filters (rating, date, search)
4. Statistics cards
5. Pagination

**Medium Priority (Should Have):**
6. Review details modal
7. Delete functionality
8. Excel export
9. Rating distribution chart

**Low Priority (Nice to Have):**
10. Advanced filters (seller, replies)
11. Profile pictures
12. Service thumbnails

---

**Estimated Time:** 4-5 hours for full implementation
**Dependencies:** None - all packages already installed
**Breaking Changes:** None - purely additive changes

---

**END OF PLAN**
