# Teacher Dashboard Implementation Plan

## Overview
This document outlines the comprehensive plan for implementing a dynamic, filterable teacher dashboard similar to the user dashboard, showing accurate statistics with no dummy data.

**Dashboard URL:** `/teacher-dashboard`
**View File:** `resources/views/Teacher-Dashboard/dashboard.blade.php`
**Design Reference:** User Dashboard (`resources/views/User-Dashboard/index.blade.php`)

---

## 1. Statistics to Display

### 1.1 Financial Overview (Primary Focus)

| Metric | Description | Data Source |
|--------|-------------|-------------|
| **Total Earnings** | All-time earnings from completed transactions | `transactions.seller_earnings` WHERE `seller_id = teacher_id` AND `status = 'completed'` |
| **Pending Earnings** | Orders delivered but not yet completed (48hr window) | `book_orders.seller_earnings` WHERE `teacher_id` AND `status = 2` |
| **Completed Payouts** | Amount already paid out to teacher | `transactions.seller_earnings` WHERE `seller_id = teacher_id` AND `payout_status = 'paid'` |
| **Pending Payouts** | Earnings awaiting payout | `transactions.seller_earnings` WHERE `seller_id = teacher_id` AND `payout_status = 'pending'` |
| **This Month Earnings** | Current month earnings | Filtered by `MONTH(created_at) = current_month` |
| **Today's Earnings** | Today's earnings | Filtered by `DATE(created_at) = today` |
| **Average Order Value** | Average booking price | `AVG(book_orders.seller_earnings)` |
| **Total Commission Paid** | Platform fees paid | `SUM(transactions.seller_commission_amount)` |
| **Refunds Issued** | Total refunded to customers | `SUM(transactions.total_amount)` WHERE `status = 'refunded'` |
| **Net Earnings** | Total Earnings - Commission Paid - Refunds | Calculated field |

### 1.2 Order/Booking Statistics

| Metric | Description | Data Source |
|--------|-------------|-------------|
| **Total Bookings** | All bookings received | `COUNT(book_orders)` WHERE `teacher_id` |
| **Active Bookings** | Currently in progress | `COUNT(book_orders)` WHERE `status = 1` |
| **Pending Bookings** | Payment received, awaiting start | `COUNT(book_orders)` WHERE `status = 0` |
| **Delivered Bookings** | Service delivered, awaiting completion | `COUNT(book_orders)` WHERE `status = 2` |
| **Completed Bookings** | Fully completed (ready for payout) | `COUNT(book_orders)` WHERE `status = 3` |
| **Cancelled Bookings** | Cancelled/Refunded | `COUNT(book_orders)` WHERE `status = 4` |
| **Disputed Orders** | Orders with active disputes | `COUNT(book_orders)` WHERE `user_dispute = 1` OR `teacher_dispute = 1` |

### 1.3 Service Type Breakdown

| Metric | Description | Data Source |
|--------|-------------|-------------|
| **Class Bookings** | Total class bookings | `COUNT(book_orders)` JOIN `teacher_gigs` WHERE `service_role = 'Class'` |
| **Freelance Bookings** | Total freelance bookings | `COUNT(book_orders)` JOIN `teacher_gigs` WHERE `service_role = 'Freelance'` |
| **Online Bookings** | Online delivery bookings | `COUNT(book_orders)` JOIN `teacher_gigs` WHERE `service_type = 'Online'` |
| **In-Person Bookings** | In-person delivery bookings | `COUNT(book_orders)` JOIN `teacher_gigs` WHERE `service_type = 'Inperson'` |
| **Class Earnings** | Revenue from classes | `SUM(seller_earnings)` WHERE `service_role = 'Class'` |
| **Freelance Earnings** | Revenue from freelance | `SUM(seller_earnings)` WHERE `service_role = 'Freelance'` |
| **Online Earnings** | Revenue from online services | `SUM(seller_earnings)` WHERE `service_type = 'Online'` |
| **In-Person Earnings** | Revenue from in-person services | `SUM(seller_earnings)` WHERE `service_type = 'Inperson'` |

### 1.4 Service Performance Metrics

| Metric | Description | Data Source |
|--------|-------------|-------------|
| **Total Gigs/Services** | All services created | `COUNT(teacher_gigs)` WHERE `user_id = teacher_id` |
| **Active Gigs** | Live services | `COUNT(teacher_gigs)` WHERE `status = 1` |
| **Inactive Gigs** | Paused/Disabled services | `COUNT(teacher_gigs)` WHERE `status = 0` |
| **Total Impressions** | Total service views | `SUM(teacher_gigs.impressions)` |
| **Total Clicks** | Total service clicks | `SUM(teacher_gigs.clicks)` |
| **Total Orders** | Orders from gigs | `SUM(teacher_gigs.orders)` |
| **Conversion Rate** | (Orders / Clicks) × 100 | Calculated field |
| **CTR (Click-Through Rate)** | (Clicks / Impressions) × 100 | Calculated field |

### 1.5 Engagement & Quality Metrics

| Metric | Description | Data Source |
|--------|-------------|-------------|
| **Total Reviews Received** | Customer reviews on services | `COUNT(service_reviews)` WHERE `teacher_id` AND `parent_id IS NULL` |
| **Average Rating** | Overall rating score | `AVG(service_reviews.rating)` WHERE `teacher_id` |
| **5-Star Reviews** | Count of 5-star ratings | `COUNT(service_reviews)` WHERE `rating = 5` |
| **Total Unique Clients** | Distinct customers | `COUNT(DISTINCT book_orders.user_id)` |
| **Repeat Customers** | Clients with 2+ bookings | Calculated from `book_orders` grouping |
| **Repeat Customer Rate** | (Repeat Customers / Total Clients) × 100 | Calculated field |
| **Completion Rate** | (Completed Orders / Total Orders) × 100 | Calculated field |
| **Cancellation Rate** | (Cancelled Orders / Total Orders) × 100 | Calculated field |

---

## 2. Filter Options

### 2.1 Preset Date Ranges (Quick Filters)
- **All Time** (default)
- **Today**
- **Yesterday**
- **This Week**
- **Last Week**
- **This Month**
- **Last Month**
- **Last 3 Months**
- **Last 6 Months**
- **Last Year**
- **Year to Date**

### 2.2 Custom Date Range
- **From Date** (date picker)
- **To Date** (date picker)
- **Apply Custom** button

### 2.3 Additional Filters (Optional/Future Enhancement)
- Service Type (Class/Freelance)
- Delivery Method (Online/In-Person)
- Order Status
- Category

---

## 3. Visual Components

### 3.1 Dashboard Layout Structure
```
┌─────────────────────────────────────────────────────────┐
│ Header: Dashboard Title + Welcome Message               │
├─────────────────────────────────────────────────────────┤
│ Filter Panel: Preset Buttons + Custom Date Range        │
├─────────────────────────────────────────────────────────┤
│ Section 1: Financial Overview (4-5 large cards)         │
│ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐          │
│ │Total │ │Month │ │ Avg  │ │Pend. │ │Comp. │          │
│ │Earn. │ │Earn. │ │Order │ │Payout│ │Payout│          │
│ └──────┘ └──────┘ └──────┘ └──────┘ └──────┘          │
├─────────────────────────────────────────────────────────┤
│ Section 2: Order Statistics (6 small cards)             │
│ ┌────┐ ┌────┐ ┌────┐ ┌────┐ ┌────┐ ┌────┐            │
│ │Tot.│ │Act.│ │Pend│ │Comp│ │Can.│ │Del.│            │
│ └────┘ └────┘ └────┘ └────┘ └────┘ └────┘            │
├─────────────────────────────────────────────────────────┤
│ Section 3: Service Type Breakdown (4 cards)             │
│ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐  │
│ │  Class   │ │Freelance │ │ Online   │ │In-Person │  │
│ │ Bookings │ │ Bookings │ │ Bookings │ │ Bookings │  │
│ └──────────┘ └──────────┘ └──────────┘ └──────────┘  │
├─────────────────────────────────────────────────────────┤
│ Section 4: Service Performance (4 cards)                │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐      │
│ │ Active  │ │Impress. │ │ Clicks  │ │Convert. │      │
│ │  Gigs   │ │         │ │         │ │  Rate   │      │
│ └─────────┘ └─────────┘ └─────────┘ └─────────┘      │
├─────────────────────────────────────────────────────────┤
│ Section 5: Engagement Metrics (4 cards)                 │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐      │
│ │Reviews  │ │ Avg     │ │ Total   │ │ Repeat  │      │
│ │Received │ │ Rating  │ │ Clients │ │Customers│      │
│ └─────────┘ └─────────┘ └─────────┘ └─────────┘      │
├─────────────────────────────────────────────────────────┤
│ Section 6: Charts & Visualizations                      │
│ ┌────────────────────────┐ ┌──────────────────┐        │
│ │ Earnings Trend Chart   │ │ Order Status Pie │        │
│ │ (Line - Last 6 Months) │ │      Chart       │        │
│ └────────────────────────┘ └──────────────────┘        │
├─────────────────────────────────────────────────────────┤
│ Section 7: Recent Bookings Table                        │
│ ┌─────────────────────────────────────────────────────┐ │
│ │ Service │ Customer │ Date │ Amount │ Status         │ │
│ └─────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────┘
```

### 3.2 Chart Types
1. **Earnings Trend** - Line Chart (Monthly revenue for last 6 months)
2. **Order Status Breakdown** - Pie/Doughnut Chart
3. **Service Performance** - Bar Chart (Impressions, Clicks, Orders)
4. **Revenue by Category** - Horizontal Bar Chart

---

## 4. Technical Implementation

### 4.1 Backend Structure

#### **File: `app/Services/TeacherDashboardService.php`** (NEW)
```php
namespace App\Services;

class TeacherDashboardService
{
    // Methods to implement:
    public function getAllStatistics($teacherId, $dateFrom, $dateTo)
    public function getFinancialStatistics($teacherId, $dateFrom, $dateTo)
    public function getOrderStatistics($teacherId, $dateFrom, $dateTo)
    public function getServicePerformance($teacherId, $dateFrom, $dateTo)
    public function getEngagementMetrics($teacherId, $dateFrom, $dateTo)
    public function getMonthlyEarningsTrend($teacherId, $months = 6)
    public function getOrderStatusBreakdown($teacherId, $dateFrom, $dateTo)
    public function getRecentBookings($teacherId, $limit = 10)
    public function applyDatePreset($preset)
}
```

#### **File: `app/Http/Controllers/TeacherController.php`** (UPDATE)
```php
// Update existing TeacherDashboard() method:
public function TeacherDashboard()
{
    // Get authenticated teacher
    $teacher = Auth::user();

    // Get recent bookings (initial load)
    $recentBookings = BookOrder::where('teacher_id', $teacher->id)
        ->with(['gig', 'user'])
        ->latest()
        ->limit(10)
        ->get();

    return view("Teacher-Dashboard.dashboard", compact('recentBookings'));
}

// Add new AJAX endpoint for statistics:
public function getDashboardStatistics(Request $request)
{
    $teacher = Auth::user();
    $preset = $request->input('preset', 'all_time');

    $service = new TeacherDashboardService();
    $dates = $service->applyDatePreset($preset);

    // Get all statistics
    $statistics = $service->getAllStatistics(
        $teacher->id,
        $dates['from'],
        $dates['to']
    );

    return response()->json($statistics);
}

// Add chart data endpoints:
public function getEarningsTrendChart(Request $request)
public function getOrderStatusChart(Request $request)
```

### 4.2 Routes to Add

#### **File: `routes/web.php`** (UPDATE)
```php
Route::controller(TeacherController::class)->group(function () {
    // Existing routes...
    Route::get('/teacher-dashboard', 'TeacherDashboard');

    // NEW AJAX routes for dashboard
    Route::get('/teacher-dashboard/statistics', 'getDashboardStatistics');
    Route::get('/teacher-dashboard/earnings-trend', 'getEarningsTrendChart');
    Route::get('/teacher-dashboard/order-status-chart', 'getOrderStatusChart');
});
```

### 4.3 Frontend Structure

#### **File: `resources/views/Teacher-Dashboard/dashboard.blade.php`** (COMPLETE REWRITE)
- Copy structure from `User-Dashboard/index.blade.php`
- Adapt statistics cards for teacher-specific metrics
- Use same filtering UI (preset buttons + custom date pickers)
- Include Chart.js and Flatpickr libraries
- Add loading overlay for AJAX requests

#### **File: `public/assets/teacher/asset/js/dashboard.js`** (NEW)
```javascript
// Functions to implement:
- loadDashboardStatistics(preset)
- applyCustomDateFilter()
- updateStatisticCards(data)
- renderEarningsTrendChart(data)
- renderOrderStatusChart(data)
- exportPDF()
- exportExcel()
```

#### **File: `public/assets/teacher/asset/css/dashboard.css`** (NEW)
- Copy from user dashboard CSS
- Adapt color scheme if needed

---

## 5. Data Validation & Accuracy

### 5.1 Data Integrity Checks
- ✅ All statistics must come from actual database queries (NO hardcoded values)
- ✅ Use Eloquent ORM with proper relationships
- ✅ Apply date filters correctly to all queries
- ✅ Handle edge cases (division by zero for rates/percentages)
- ✅ Return 0 or null for missing data, never fake values

### 5.2 Testing Scenarios
1. **Empty State:** New teacher with no bookings → All stats should show 0
2. **Single Booking:** One completed order → Accurate financial calculations
3. **Multiple Bookings:** Various statuses → Correct counts per status
4. **Date Filtering:** Test each preset and custom ranges
5. **Chart Rendering:** Ensure charts display with real data
6. **Commission Calculations:** Verify earnings = price - commission

---

## 6. Implementation Steps

### Phase 1: Backend Setup
- [ ] Create `TeacherDashboardService.php` with all statistical methods
- [ ] Update `TeacherController.php` with dashboard and AJAX methods
- [ ] Add routes in `routes/web.php`
- [ ] Test all service methods with database queries

### Phase 2: Frontend Development
- [ ] Update `dashboard.blade.php` with new layout
- [ ] Create `dashboard.js` with AJAX functionality
- [ ] Create `dashboard.css` for styling
- [ ] Integrate Chart.js for visualizations
- [ ] Add Flatpickr for date pickers

### Phase 3: Testing & Refinement
- [ ] Test with real teacher accounts
- [ ] Verify all statistics accuracy
- [ ] Test date filtering (all presets + custom)
- [ ] Check responsive design (mobile, tablet, desktop)
- [ ] Performance optimization (query optimization, caching)

### Phase 4: Optional Enhancements
- [ ] Add export to PDF/Excel functionality
- [ ] Add service-level drill-down (click gig to see details)
- [ ] Add comparison mode (compare two date ranges)
- [ ] Add goal setting and tracking
- [ ] Add notifications for important milestones

---

## 7. Database Queries Reference

### Key Queries for Service Methods

#### Financial Statistics
```php
// Total Earnings (completed transactions)
Transaction::where('seller_id', $teacherId)
    ->where('status', 'completed')
    ->sum('seller_earnings');

// Pending Earnings (delivered orders)
BookOrder::where('teacher_id', $teacherId)
    ->where('status', 2)
    ->sum('seller_earnings');

// Commission Paid
Transaction::where('seller_id', $teacherId)
    ->sum('seller_commission_amount');
```

#### Order Statistics
```php
// Bookings by status
BookOrder::where('teacher_id', $teacherId)
    ->where('status', $statusCode)
    ->count();

// Service type breakdown
BookOrder::where('teacher_id', $teacherId)
    ->whereHas('gig', function($q) {
        $q->where('service_role', 'Class');
    })
    ->count();
```

#### Service Performance
```php
// Active gigs
TeacherGig::where('user_id', $teacherId)
    ->where('status', 1)
    ->count();

// Total impressions/clicks
TeacherGig::where('user_id', $teacherId)
    ->sum('impressions');
```

#### Engagement Metrics
```php
// Average rating
ServiceReviews::where('teacher_id', $teacherId)
    ->whereNull('parent_id')
    ->avg('rating');

// Unique clients
BookOrder::where('teacher_id', $teacherId)
    ->distinct('user_id')
    ->count('user_id');
```

---

## 8. Design Consistency

### Match User Dashboard Styling
- Use same card designs and color scheme
- Maintain consistent spacing and typography
- Reuse filter panel layout
- Keep same chart styling (Chart.js configurations)
- Use same loading spinner and transitions

### Teacher-Specific Adaptations
- Adjust terminology (e.g., "Spent" → "Earned")
- Different icon set (seller-focused icons)
- Green/success color theme for earnings (vs. blue for spending)
- Seller-centric metric labels

---

## 9. Performance Considerations

### Optimization Strategies
1. **Eager Loading:** Use `with()` for relationships to avoid N+1 queries
2. **Query Caching:** Cache expensive aggregations (24-hour TTL)
3. **Pagination:** Limit recent bookings table (10-15 items)
4. **Database Indexing:** Ensure indexes on:
   - `book_orders.teacher_id`
   - `transactions.seller_id`
   - `teacher_gigs.user_id`
   - `created_at` columns for date filtering
5. **AJAX Loading:** Load statistics asynchronously to improve perceived performance

---

## 10. Success Criteria

The implementation will be considered complete when:
- ✅ All statistics display accurate, real-time data
- ✅ All date filters work correctly (preset and custom)
- ✅ Charts render properly with dynamic data
- ✅ No dummy/hardcoded values present
- ✅ Design matches user dashboard consistency
- ✅ Responsive on all device sizes
- ✅ AJAX filtering works smoothly without page reload
- ✅ Performance is acceptable (<2s initial load, <500ms filter change)

---

## 11. Future Enhancements (Post-MVP)

1. **Advanced Analytics:**
   - Revenue forecasting
   - Seasonal trend analysis
   - Service performance comparison

2. **Insights & Recommendations:**
   - "Optimize your pricing" suggestions
   - "Best performing categories" highlights
   - "Improve your rating" tips

3. **Notifications & Alerts:**
   - New booking alerts
   - Payment received notifications
   - Review reminder alerts

4. **Export & Reporting:**
   - PDF export for financial records
   - Excel export for accounting
   - Custom report builder

5. **Mobile App Integration:**
   - API endpoints for mobile dashboard
   - Push notifications

---

## Appendix A: Status Code Reference

### BookOrder Status Codes
- `0` = Pending (Payment received, awaiting service start)
- `1` = Active (Service in progress)
- `2` = Delivered (Service delivered, 48hr dispute window)
- `3` = Completed (Final status, ready for payout)
- `4` = Cancelled (Refunded or cancelled)

### Transaction Status Codes
- `completed` = Payment processed successfully
- `refunded` = Payment refunded to buyer
- `pending` = Payment processing

### Payout Status Codes
- `pending` = Earnings awaiting payout
- `paid` = Earnings paid out to teacher
- `processing` = Payout in progress

---

## Appendix B: Color Coding

### Status Colors
- **Pending:** `#ffc107` (Yellow/Warning)
- **Active:** `#007bff` (Blue/Primary)
- **Delivered:** `#17a2b8` (Cyan/Info)
- **Completed:** `#28a745` (Green/Success)
- **Cancelled:** `#dc3545` (Red/Danger)

### Financial Metrics Colors
- **Earnings:** `#28a745` (Green)
- **Payouts:** `#17a2b8` (Cyan)
- **Commission:** `#6c757d` (Gray)
- **Refunds:** `#dc3545` (Red)

---

**Document Version:** 1.0
**Created:** 2025-11-06
**Last Updated:** 2025-11-06
**Status:** Ready for Implementation
