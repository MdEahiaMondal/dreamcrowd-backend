# Order Details Page - Implementation Plan

## Overview
Create a comprehensive, professional Order Details page for Admin/Teacher/User dashboards that displays complete information about a book order including payment, service, participants, and lifecycle status.

---

## 1. Route Structure

### Routes to Create (`routes/web.php`)

```php
// Admin Order Details
Route::get('/admin/order-details/{id}', [OrderManagementController::class, 'showOrderDetails'])
    ->name('admin.order.details')
    ->middleware(['auth', 'role:admin']);

// Teacher Order Details
Route::get('/teacher/order-details/{id}', [OrderManagementController::class, 'showTeacherOrderDetails'])
    ->name('teacher.order.details')
    ->middleware(['auth', 'role:teacher']);

// User Order Details
Route::get('/user/order-details/{id}', [OrderManagementController::class, 'showUserOrderDetails'])
    ->name('user.order.details')
    ->middleware(['auth', 'role:user']);
```

---

## 2. Controller Method Structure

### `OrderManagementController.php`

```php
/**
 * Show order details for admin
 * Full access to all order information
 */
public function showOrderDetails($id)
{
    $order = BookOrder::with([
        'user',           // Buyer
        'teacher',        // Seller
        'gig',           // Service/Gig details
        'gig.category',  // Service category
        'transaction',   // Payment transaction
        'classDates',    // Scheduled classes
        'zoomMeetings',  // Zoom meetings
    ])->findOrFail($id);

    return view('Admin-Dashboard.order-details', compact('order'));
}

/**
 * Show order details for teacher
 * Only their own orders
 */
public function showTeacherOrderDetails($id)
{
    $order = BookOrder::with([...])
        ->where('teacher_id', auth()->id())
        ->findOrFail($id);

    return view('Teacher-Dashboard.order-details', compact('order'));
}

/**
 * Show order details for user
 * Only their own orders
 */
public function showUserOrderDetails($id)
{
    $order = BookOrder::with([...])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    return view('User-Dashboard.order-details', compact('order'));
}
```

---

## 3. Page Layout & Sections

### A. Header Section
```
┌─────────────────────────────────────────────────────────┐
│  Order Details - #ORD-000053                            │
│  ← Back to Notifications / Orders                       │
│                                                          │
│  Status Badge: [ACTIVE] [EMERGENCY]                     │
│  Order Date: Nov 21, 2025, 10:30 AM                     │
│  Last Updated: Nov 21, 2025, 11:45 AM                   │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Large order number display
- Breadcrumb navigation
- Color-coded status badges
- Timestamps with relative time (e.g., "2 hours ago")

---

### B. Order Status Timeline
```
┌─────────────────────────────────────────────────────────┐
│  Order Lifecycle                                         │
│                                                          │
│  ● Pending ──> ● Active ──> ● Delivered ──> ○ Completed │
│  Nov 20       Nov 21      (In Progress)      (Pending)  │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Visual timeline with progress indicators
- Date stamps for each stage
- Current status highlighted
- Estimated completion date

---

### C. Quick Stats Cards (3-column grid)
```
┌─────────────────┬─────────────────┬─────────────────┐
│  Order Value    │  Participants   │  Status         │
│  $150.00       │  5 People       │  Active         │
│  +$15 comm.    │  3 Adults       │  In Progress    │
└─────────────────┴─────────────────┴─────────────────┘
```

---

### D. Service Information Card
```
┌─────────────────────────────────────────────────────────┐
│  📚 Service Details                                      │
├─────────────────────────────────────────────────────────┤
│  Title:           Math Tutoring - Grade 10               │
│  Category:        Education > Mathematics                │
│  Type:            Subscription (Monthly)                 │
│  Delivery:        Online (Zoom)                          │
│  Group Type:      Group Session                          │
│  Frequency:       Weekly                                 │
│                                                          │
│  [View Service Page →]                                   │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Service thumbnail/image
- Complete service details
- Link to view full service page
- Icon indicators for delivery type

---

### E. Participants Section (2-column)
```
┌──────────────────────────┬─────────────────────────────┐
│  👤 Buyer Information    │  👨‍🏫 Seller Information     │
├──────────────────────────┼─────────────────────────────┤
│  Name:    John Smith     │  Name:    Sarah Johnson     │
│  Email:   john@mail.com  │  Email:   sarah@mail.com    │
│  Role:    Buyer          │  Role:    Teacher/Seller    │
│  Phone:   +1234567890    │  Phone:   +0987654321       │
│                          │                             │
│  [Contact Buyer]         │  [Contact Seller]           │
└──────────────────────────┴─────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  👥 Group Participants                                   │
├─────────────────────────────────────────────────────────┤
│  • Main Guest:       1 person                            │
│  • Extra Guests:     2 people                            │
│  • Children:         2 people                            │
│  • Total:            5 people                            │
│                                                          │
│  Additional Emails: guest1@mail.com, guest2@mail.com    │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- User avatars (if available)
- Contact buttons
- Participant breakdown
- Guest email list

---

### F. Payment & Financial Details
```
┌─────────────────────────────────────────────────────────┐
│  💳 Payment Information                                  │
├─────────────────────────────────────────────────────────┤
│  Base Price:                              $150.00       │
│                                                          │
│  Buyer Commission:                                       │
│    Rate: 10%                                             │
│    Amount: $15.00                                        │
│                                                          │
│  Seller Commission:                                      │
│    Rate: 15%                                             │
│    Amount: $22.50                                        │
│                                                          │
│  Discount/Coupon:                                        │
│    Code: SUMMER10                                        │
│    Discount: -$10.00                                     │
│    Admin Absorbed: Yes                                   │
│                                                          │
│  ──────────────────────────────────────────────────     │
│  Total Admin Commission:      $22.50                     │
│  Seller Earnings:             $127.50                    │
│  Buyer Total:                 $165.00                    │
│                                                          │
│  Payment Method:     💳 Stripe (Card ending ****1234)   │
│  Payment Status:     ✅ Completed                        │
│  Payment ID:         pi_3MtwBwLkdIwHu7ix28a3tqPz        │
│  Transaction Date:   Nov 20, 2025, 3:45 PM              │
│                                                          │
│  [View Full Transaction →]                               │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Clear financial breakdown
- Visual separation of sections
- Highlighted totals
- Link to full transaction details
- Payment method icons

---

### G. Class Schedule & Zoom Details (if applicable)
```
┌─────────────────────────────────────────────────────────┐
│  📅 Class Schedule                                       │
├─────────────────────────────────────────────────────────┤
│  Upcoming Classes:                                       │
│                                                          │
│  ✓ Class 1  │  Nov 22, 2025  │  10:00 AM - 11:00 AM    │
│  ○ Class 2  │  Nov 29, 2025  │  10:00 AM - 11:00 AM    │
│  ○ Class 3  │  Dec 06, 2025  │  10:00 AM - 11:00 AM    │
│  ○ Class 4  │  Dec 13, 2025  │  10:00 AM - 11:00 AM    │
│                                                          │
│  ✓ = Completed  ○ = Scheduled                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│  🎥 Zoom Meeting Information                             │
├─────────────────────────────────────────────────────────┤
│  Meeting Link:  https://zoom.us/j/1234567890            │
│  Meeting ID:    123 456 7890                             │
│  Passcode:      ••••••                                   │
│  Status:        Scheduled                                │
│                                                          │
│  [Copy Link]  [Join Meeting]                             │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Sortable class list
- Status indicators (completed/scheduled/cancelled)
- Zoom integration
- Copy to clipboard functionality
- Direct join button

---

### H. Reschedule History (if any)
```
┌─────────────────────────────────────────────────────────┐
│  🔄 Reschedule Requests                                  │
├─────────────────────────────────────────────────────────┤
│  Teacher Reschedule: 1 request                           │
│    Requested: Nov 21, 2025, 2:00 PM                      │
│    Reason: Personal emergency                            │
│    Status: Pending buyer approval                        │
│                                                          │
│  User Reschedule: 0 requests                             │
└─────────────────────────────────────────────────────────┘
```

---

### I. Dispute & Refund Section (if applicable)
```
┌─────────────────────────────────────────────────────────┐
│  ⚠️ Dispute Information                                  │
├─────────────────────────────────────────────────────────┤
│  User Dispute:          Yes                              │
│  Opened:                Nov 22, 2025, 4:30 PM            │
│  Reason:                Service not delivered            │
│                                                          │
│  Teacher Response:      Pending                          │
│  Auto-Process Date:     Nov 24, 2025, 4:30 PM           │
│                         (48 hours from dispute)          │
│                                                          │
│  Refund Status:         Processing                       │
│  Refund Amount:         $165.00 (Full refund)            │
│                                                          │
│  [View Dispute Details]  [Admin Override]                │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Warning/alert styling
- Countdown timer for auto-process
- Admin action buttons
- Dispute timeline
- Refund tracking

---

### J. Order Actions Panel (Admin Only)
```
┌─────────────────────────────────────────────────────────┐
│  ⚡ Admin Actions                                        │
├─────────────────────────────────────────────────────────┤
│  [Mark as Delivered]  [Mark as Completed]                │
│  [Cancel Order]       [Process Refund]                   │
│  [Send Notification]  [View Logs]                        │
│  [Contact Support]    [Export Details]                   │
└─────────────────────────────────────────────────────────┘
```

---

### K. Activity Log / Timeline
```
┌─────────────────────────────────────────────────────────┐
│  📋 Order Activity Log                                   │
├─────────────────────────────────────────────────────────┤
│  ● Nov 22, 2025, 4:30 PM                                │
│    User opened dispute                                   │
│    By: John Smith                                        │
│                                                          │
│  ● Nov 21, 2025, 10:00 AM                                │
│    Order marked as Active                                │
│    By: System                                            │
│                                                          │
│  ● Nov 20, 2025, 3:45 PM                                 │
│    Payment completed via Stripe                          │
│    By: John Smith                                        │
│                                                          │
│  ● Nov 20, 2025, 3:44 PM                                 │
│    Order created                                         │
│    By: John Smith                                        │
│                                                          │
│  [Load More...]                                          │
└─────────────────────────────────────────────────────────┘
```

**Features:**
- Reverse chronological order
- User/system attribution
- Icons for different event types
- Load more pagination

---

## 4. Technical Implementation Details

### A. Database Queries

```php
// Eager load all necessary relationships
$order = BookOrder::with([
    'user:id,first_name,last_name,email,phone',
    'teacher:id,first_name,last_name,email,phone',
    'gig:id,title,category_id,service_delivery,group_type,frequency',
    'gig.category:id,name',
    'gig.subCategory:id,name',
    'transaction',
    'classDates' => function($query) {
        $query->orderBy('class_date', 'asc');
    },
    'zoomMeetings' => function($query) {
        $query->latest();
    },
    'disputeOrder',
    'reschedules',
])->findOrFail($id);
```

### B. Status Badge Colors

```php
$statusColors = [
    0 => ['badge' => 'warning', 'text' => 'Pending'],     // Orange
    1 => ['badge' => 'primary', 'text' => 'Active'],      // Blue
    2 => ['badge' => 'info', 'text' => 'Delivered'],      // Cyan
    3 => ['badge' => 'success', 'text' => 'Completed'],   // Green
    4 => ['badge' => 'danger', 'text' => 'Cancelled'],    // Red
];
```

### C. Computed Properties/Helpers

```php
// In BookOrder model, add computed attributes:
protected $appends = [
    'order_number',
    'status_text',
    'status_color',
    'total_participants',
    'buyer_total_amount',
    'is_disputed',
    'can_be_cancelled',
    'can_be_refunded',
];
```

---

## 5. Responsive Design Considerations

### Mobile Layout (< 768px)
- Stack sections vertically
- Collapse financial details into expandable accordion
- Sticky header with order number
- Bottom action bar for quick actions

### Tablet Layout (768px - 1024px)
- 2-column layout for participant sections
- Condensed financial breakdown
- Horizontal class timeline

### Desktop Layout (> 1024px)
- Full 3-column layout where applicable
- Sidebar with quick actions
- Expanded financial details

---

## 6. Security & Permissions

### Access Control
```php
// Middleware checks
- Admin: Can view ALL orders
- Teacher: Can only view orders where teacher_id = auth()->id()
- User: Can only view orders where user_id = auth()->id()
```

### Sensitive Data Handling
- Mask full card numbers (show last 4 digits only)
- Hide CVV completely
- Redact personal phone numbers for non-admins
- Email addresses visible only to authorized roles

---

## 7. Performance Optimizations

1. **Eager Loading**: Load all relationships in single query
2. **Caching**: Cache order details for 5 minutes
3. **Lazy Loading**: Load activity log on-demand
4. **Query Optimization**: Use select() to limit columns
5. **Image Optimization**: Use thumbnails for service images

---

## 8. Error Handling

### Scenarios to Handle:
- Order not found (404)
- Unauthorized access (403)
- Missing relationships (graceful null checks)
- Deleted user/teacher accounts
- Missing payment information

### Error Messages:
```php
if (!$order) {
    return redirect()->back()
        ->with('error', 'Order not found or you do not have permission to view it.');
}
```

---

## 9. View Files to Create

```
1. resources/views/Admin-Dashboard/order-details.blade.php
2. resources/views/Teacher-Dashboard/order-details.blade.php
3. resources/views/User-Dashboard/order-details.blade.php
4. resources/views/components/order-status-badge.blade.php
5. resources/views/components/order-timeline.blade.php
6. resources/views/components/payment-breakdown.blade.php
```

---

## 10. JavaScript Functionality

### Required Features:
1. **Copy to Clipboard**: For Zoom links, payment IDs
2. **Print Order**: Generate printable invoice
3. **Export PDF**: Download order as PDF
4. **Real-time Updates**: WebSocket for status changes
5. **Tooltips**: Hover info for commission calculations
6. **Modals**: Confirmation dialogs for actions
7. **AJAX Actions**: Mark as delivered/completed without page reload

---

## 11. Testing Checklist

### Test Cases:
- [ ] Admin can view any order
- [ ] Teacher can only view their own orders
- [ ] User can only view their own orders
- [ ] Order with no classes displays correctly
- [ ] Order with dispute shows warning
- [ ] Refunded order displays refund info
- [ ] Cancelled order shows cancellation details
- [ ] Print functionality works
- [ ] Mobile responsive layout
- [ ] All links work correctly
- [ ] Financial calculations are accurate

---

## 12. Future Enhancements (Phase 2)

1. **Export Options**: CSV, Excel, PDF
2. **Email Order Details**: Send to buyer/seller
3. **Order Notes**: Admin can add internal notes
4. **Change History**: Track all changes with diff view
5. **Related Orders**: Show other orders from same buyer/seller
6. **Recommendations**: Suggest similar services
7. **Rating/Review Integration**: Show reviews for this order
8. **Communication Log**: Show all messages between parties
9. **Webhook Events**: Track Stripe webhook events
10. **Analytics**: Order value trends, commission analysis

---

## 13. Implementation Priority

### Phase 1 (Essential - Week 1):
1. ✅ Create routes
2. ✅ Create controller methods
3. ✅ Create basic view layout
4. ✅ Display order overview
5. ✅ Display service information
6. ✅ Display participant information
7. ✅ Display payment breakdown
8. ✅ Add status badges

### Phase 2 (Important - Week 2):
1. ⏳ Add class schedule section
2. ⏳ Add Zoom details
3. ⏳ Add dispute information
4. ⏳ Add reschedule history
5. ⏳ Add activity log
6. ⏳ Mobile responsive design

### Phase 3 (Enhanced - Week 3):
1. ⏳ Admin action buttons
2. ⏳ Print/Export functionality
3. ⏳ Real-time updates
4. ⏳ Copy to clipboard features
5. ⏳ Order timeline visualization

---

## 14. Design References

### Color Scheme:
- Primary: `#667eea` (Purple gradient)
- Success: `#28a745` (Green)
- Warning: `#ffc107` (Yellow)
- Danger: `#dc3545` (Red)
- Info: `#17a2b8` (Cyan)

### Fonts:
- Headings: System font stack (Arial, Helvetica, sans-serif)
- Body: System font stack
- Numbers: Monospace for payment amounts

### Icons:
- BoxIcons (already in use)
- FontAwesome (already in use)

---

## 15. Accessibility Considerations

1. **ARIA Labels**: Add to all interactive elements
2. **Keyboard Navigation**: Tab through all sections
3. **Screen Reader Support**: Proper heading hierarchy
4. **Color Contrast**: WCAG AA compliance
5. **Alt Text**: For all images and icons
6. **Focus Indicators**: Visible focus states

---

## 16. Localization (Future)

- Support for multiple languages
- Currency formatting
- Date/time formatting based on locale
- Number formatting (commas, decimals)

---

## 17. Dependencies Required

### PHP Packages:
- `barryvdh/laravel-dompdf` (for PDF generation) - Already installed
- `maatwebsite/excel` (for Excel export) - Already installed

### JavaScript Libraries:
- `clipboard.js` (for copy functionality)
- `chart.js` (for analytics charts - future)

### CSS Framework:
- Bootstrap 5 (already in use)
- Custom CSS for order-specific styling

---

## Estimated Implementation Time

- **Backend (Controller + Routes)**: 4-6 hours
- **Frontend (View Design)**: 8-10 hours
- **JavaScript Functionality**: 4-6 hours
- **Testing & Debugging**: 4-6 hours
- **Responsive Design**: 4-6 hours
- **Documentation**: 2-3 hours

**Total: 26-37 hours** (3-5 working days)

---

## Success Criteria

✅ Page loads in < 2 seconds
✅ All order information displays correctly
✅ Financial calculations are accurate
✅ Mobile-responsive on all devices
✅ Security checks prevent unauthorized access
✅ Print/Export functions work
✅ No JavaScript errors in console
✅ Passes accessibility audit
✅ Code reviewed and approved

---

## Questions for Clarification

1. Should we add a comments/notes section for internal admin use?
2. Do we need to track IP addresses for orders?
3. Should we integrate with email to send order summaries?
4. Do we need to support multiple payment methods display?
5. Should we show seller payout status on this page?
6. Do we need order comparison feature (compare 2 orders)?
7. Should we add order rating/feedback section?

---

**End of Plan Document**

Please review this comprehensive plan and provide feedback or approval to proceed with implementation.
