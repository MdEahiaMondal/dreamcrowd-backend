# DreamCrowd - Detailed Client Requirements

## 📋 Table of Contents
1. [Project Overview](#project-overview)
2. [Business Logic & Rules](#business-logic--rules)
3. [Detailed Feature Requirements](#detailed-feature-requirements)
4. [Technical Integration Requirements](#technical-integration-requirements)
5. [Email System Requirements](#email-system-requirements)
6. [Important Implementation Notes](#important-implementation-notes)

---

# PROJECT OVERVIEW

## Platform Description
**DreamCrowd** is a multi-sided marketplace connecting:
- **Teachers/Sellers**: Provide classes and freelance services
- **Buyers/Users**: Book classes and services, make payments
- **Admins**: Manage platform, users, payments, commissions

## Three Panel Architecture
1. **Buyer Panel**: Browse, book, pay, review
2. **Seller Panel**: Create services, manage bookings, receive payments
3. **Admin Panel**: Platform management, analytics, moderation

---

# BUSINESS LOGIC & RULES

## Order Status Lifecycle

```
┌─────────────────────────────────────────────────────────┐
│                     ORDER LIFECYCLE                      │
└─────────────────────────────────────────────────────────┘

Pending (0)
    ↓ [Payment completed, Seller approves]
Active (1)
    ↓ [Due date passes / Manual action]
Delivered (2)
    ↓ [48 hours without dispute]
Completed (3) → Ready for seller payout

┌─────────────────────────────────────────────────────────┐
│                    DISPUTE PROCESS                       │
└─────────────────────────────────────────────────────────┘

Active/Delivered
    ↓ [User initiates dispute]
Disputed (flags set)
    ↓ [48 hours + no teacher counter-dispute]
Cancelled (4) → Automatic refund via Stripe
    OR
    ↓ [Teacher counter-disputes]
Payment on hold → Admin investigation → Refund or Release
```

## Due Date Calculation

### For Subscription Classes
- **Due Date**: 1 month from order creation date

### For One-Off Classes
- **Due Date**: Last class date from `class_dates` table
- Automatically moved to "Delivered" after last class time

### For Freelance Services
- **Due Date**: Manual marking by seller (not automated)

## Cancellation & Refund Rules

### Time-Based Cancellation
- **Less than 12 hours before class**:
  - Can cancel: YES
  - Refund eligible: NO

- **More than 12 hours before class**:
  - Can cancel: YES
  - Refund eligible: YES

### Dispute Window
- **Seller response time**: 48 hours after buyer dispute
- **Automatic refund**: If seller doesn't respond within 48 hours
- **Payment hold**: If seller counter-disputes
- **Admin decision**: Required when both parties dispute

### Service-Specific Timeframes
- Different refund timeframes can be configured per service type
- Configured in admin panel under dynamic management
- Needs testing to ensure working correctly

## Commission System

### Commission Priority (in order)
1. **Service-specific commission** (if enabled in `service_commissions` table)
2. **Seller-specific commission** (if enabled in `seller_commissions` table)
3. **Default commission** (configured in `top_seller_tags` table, typically 15%)

### Commission Calculation
```
Admin Earnings = (Service Price × Seller Commission %) + Buyer Commission Amount
Seller Payout = Service Price - (Service Price × Seller Commission %)
Buyer Total = Service Price + Buyer Commission + Tax
```

### Important Commission Rules
- **Default admin commission**: 15% from seller
- **Buyer commission**: Optional additional fee
- **Discount codes**: ALWAYS deducted from admin's 15%, NEVER from seller's fee
- **Service-specific**: Admin can edit commission per service
- **Seller-specific**: Admin can edit commission per seller

### Calculation Method
- Handled in `TopSellerTag::calculateCommission()` method
- File: `app/Models/TopSellerTag.php`

## Subscription Rules

### Subscription Cancellation
- **Rule**: Cancelling ONE order cancels ALL active subscriptions with that seller
- **Expert Tab**: Only shows ACTIVE subscriptions
- **Individual Class Cancellation**: Can cancel specific class without cancelling subscription
- **Date-specific**: Cancel one month/date while keeping subscription active

## Private Group Classes vs Public Group Classes

### Private Group Classes
- **Main Buyer** (person who paid):
  - Can cancel
  - Can reschedule
  - Can message seller
  - Full control

- **Guest Users** (invited by main buyer):
  - Can ONLY attend class
  - Cannot cancel
  - Cannot reschedule
  - Cannot message seller
  - No other actions

### Public Group Classes
- **All Users**:
  - Normal actions available
  - Can cancel their own booking
  - Can message seller
  - Full individual control

- **Exception**: Main buyers who add extra guests
  - Those specific guests follow private group rules

### Private Group Workflow
1. Main buyer pays and adds guest email addresses
2. Buyer receives booking confirmation email (needs seller approval)
3. Seller approves/rejects booking
4. Buyer receives approval confirmation email
5. Guest users receive email notification:
   - Informed that buyer paid for them
   - Class details included
   - Time shown in buyer's timezone
6. 2 hours before class:
   - All participants (buyer + guests) receive reminder
   - New guests get registration/login button
   - Zoom link included

## Trial Class Rules

### When Trial Classes Appear
- **ONLY when**:
  - Class Type: "Live" (NOT video course)
  - Payment Type: "One-off Payment" (NOT subscription)

- **NOT available for**:
  - Video courses
  - Subscription payments
  - Recorded classes

### Free Trial Class
- **Duration**: Fixed at 30 minutes
- **Price**: Fixed at $0 (zero)
- **Seller cannot change**: Duration or price
- **Zoom/Google Meet**: Required

### Paid Trial Class
- **Duration**: Custom (seller can set)
- **Price**: Custom (seller can set)
- **Zoom/Google Meet**: Required

### Trial Class Listing
- **Default view**: Only "Ongoing Class" cards shown
- **Manual selection**: Buyers must manually filter for trial classes
- **Filter location**: Seller listing page
- **Filter options**: Ongoing, One-day, Free Trial, Paid Trial

## Payment Hold Rules

### When Payment is Held
1. **Freelance services**: Until work completed and delivered
2. **Classes**: Until class is completed/delivered
3. **Disputes**: When both buyer and seller dispute
4. **Admin investigation**: During refund investigation

### When Payment is Released
1. **Completed orders**: 48 hours after delivery with no dispute
2. **Admin approval**: After investigation, to appropriate party
3. **Automated payout**: To seller after completion period

## In-Person vs Online Service Rules

### Online Services
- **Standard fields**: All described functionality
- **No time tracking**: Project-based pricing
- **Classes**: Standard class format
- **Freelance**: Description, revisions, delivery time, price

### In-Person Services
- **Required additional fields**:
  - Start date
  - Start time
  - End time

- **Reason**: Time-based work (e.g., plumber working 2 hours)
- **Classes**: Already implemented with time fields
- **Freelance**: Needs time fields added
- **Milestone payments**: Time fields for EACH milestone
- **Single payment**: Time fields for the one session

## Top Seller Criteria

### Requirements (All must be met)
- **Earnings benchmark**: Set by admin (e.g., $5,000)
- **Booking numbers**: Set by admin (e.g., 100 bookings)
- **Review rating**: Set by admin (e.g., 4.5+ stars)

### Top Seller Badge
- **Display**: Special icon on seller card
- **Qualification**: Automatic when criteria met
- **Real-time**: Updates as seller meets/loses criteria

## Survey Sorting System

### Ranking Factors
1. **Impressions**: How many times service viewed
2. **Clicks**: How many times service clicked
3. **Orders**: Number of bookings received
4. **Reviews**: Number and quality of reviews

### Importance Weighting
- **Admin sets**: Percentage importance of each factor
- **Total**: Must equal 100%
- **Example**: Reviews 55%, Orders 25%, Clicks 15%, Impressions 5%
- **Result**: Services ranked based on weighted algorithm

### Impact
- **Higher ranking**: Better position in search results
- **Better visibility**: More likely to be booked
- **Dynamic**: Updates as metrics change

---

# DETAILED FEATURE REQUIREMENTS

## BUYER/STUDENT PANEL

### 1. Booking Page Buttons (CRITICAL BUG)

#### Issue Description
- "Contact" and "Confirm Booking" buttons not appearing consistently
- Sometimes appear for logged-in users, sometimes don't
- Never appear for non-logged-in users (incorrect behavior)

#### Required Behavior
**For Non-Logged-In Users:**
- Buttons MUST always be visible
- Clicking either button shows login popup
- Login popup design already exists
- After login, proceed with action (contact or booking)

**For Logged-In Users:**
- Buttons MUST always be visible
- No popup required
- Direct action execution

#### Technical Details
- Bug appears to be account-specific or session-related
- Investigate authentication state checking
- Check button rendering conditions
- Test with multiple account types

#### Files Involved
- Booking page views
- Booking controllers
- Authentication middleware
- Button component/partial

### 2. Message Functionality (CRITICAL BUG)

#### Issue Description
- Internal error when accessing messages after normal registration
- Works perfectly with Google login
- Inconsistent behavior across accounts

#### Required Investigation
1. Check authentication method differences
2. Compare session data: normal login vs Google OAuth
3. Investigate database user records
4. Test with multiple registration methods:
   - Normal email/password
   - Google OAuth
   - Facebook OAuth

#### Expected Behavior
- Messages work identically for ALL registration methods
- No internal errors
- Real-time message updates (new requirement)

#### Technical Details
- File: Message controllers
- File: Authentication logic
- Error logs: Check for database/session issues
- OAuth integration: Compare user creation process

### 3. Dashboard Real-Time Updates

#### Metrics to Calculate in Real-Time
- Total bookings count
- Active orders count
- Completed orders count
- Total spent amount
- Current subscriptions count
- Pending orders count

#### Recent Bookings Display
- Show last 5-10 bookings
- Include booking details:
  - Service name
  - Seller name
  - Date and time
  - Status
- Update without page refresh

#### Empty State
- Show "No bookings yet" message when no bookings
- Friendly messaging
- Call-to-action button to browse services

#### Technical Requirements
- WebSocket or Pusher for real-time updates
- Or: Polling mechanism (less preferred)
- Efficient database queries
- Caching where appropriate

### 4. Notification System

#### Notification Types Needed

**Order Notifications:**
- New order placed (pending approval)
- Order approved by seller
- Order rejected by seller
- Order delivered
- Order completed
- Order cancelled
- Order disputed

**Payment Notifications:**
- Payment successful
- Refund initiated
- Refund processed
- Refund denied

**Review Notifications:**
- Seller replied to your review
- Review reminder (X days after completion)

**Class Notifications:**
- Class starting in 2 hours
- Class rescheduled
- Seller requested reschedule
- Class cancelled by seller

**System Notifications:**
- Account verified
- Password changed
- Email changed
- Security alert

#### Notification Display
- Notification bell icon in header
- Unread count badge
- Dropdown list of recent notifications
- Mark as read functionality
- View all notifications page

#### Notification Wording
- Improve English grammar and phrasing
- Example corrections:
  - "your email is verified successfully" → "your email has been successfully verified"
  - "order is confirmed successfully" → "order has been successfully confirmed"
- Professional, clear, concise messaging

#### Technical Requirements
- Real-time updates (WebSocket/Pusher)
- Database table: `notifications`
- Read/unread status tracking
- Notification preferences (future)

### 5. Order Management - Active Orders

#### Display Information
- Service/class name
- Seller name and profile link
- Order date
- Class dates and times (for classes)
- Delivery date (for freelance)
- Order status
- Amount paid
- Actions available

#### Available Actions

**For Classes (<12 hours before start):**
- View details
- Message seller
- Mark as delivered (if past time)
- No cancellation with refund

**For Classes (>12 hours before start):**
- View details
- Message seller
- Cancel with refund
- Reschedule request

**For Freelance Services:**
- View details
- Message seller
- Request revision
- Cancel (if not started)

**For Subscriptions:**
- Cancel subscription (affects ALL future classes)
- Cancel individual class (keep subscription active)
- View subscription details

### 6. Order Management - Delivered Orders

#### Display Information
- Same as active orders
- Delivered date
- Delivery confirmation

#### Available Actions
- Rate and review
- Mark as satisfactory
- Dispute order (request refund):
  - Full refund option
  - Partial refund option (specify amount)
  - Reason required
- View details
- Download invoice

#### Dispute Process
1. Buyer clicks "Dispute Order"
2. Popup appears with options:
   - Full refund
   - Partial refund (enter amount)
   - Reason textarea (required)
3. Submit dispute
4. Seller notified (email + notification)
5. Seller has 48 hours to respond:
   - Accept refund
   - Counter-dispute with reason
6. If seller doesn't respond: Automatic refund
7. If seller counter-disputes: Payment on hold, admin investigates

### 7. Experts Tab (Sellers)

#### Display Information
- List of all sellers to whom payments have been made
- Seller name and profile picture
- Services purchased from this seller
- Total amount spent with seller
- Number of orders
- Active subscription status
- Last order date

#### Available Actions
- **View Profile**: Navigate to seller's public profile
- **Send Message**: Open message interface
- **Cancel Active Subscription**:
  - Only shown if active subscription exists
  - Confirmation popup
  - Cancels ALL future classes/services
- **Report Seller**:
  - Popup with reason field
  - Submit report to admin
  - Admin receives email + notification

#### Technical Details
- Group orders by seller
- Calculate totals per seller
- Check for active subscriptions
- Filter logic for active vs completed

### 8. Video Orders/Courses

#### Public Page Design Improvements
- **Current**: Heading, payment, and content sections misaligned
- **Required**:
  - Move heading to top
  - Payment section to right sidebar
  - "Buy Cost" button prominent
  - Pricing clear and visible
  - Course curriculum preview

#### My Learning Section - Video Access
- **Display**: All purchased video courses
- **Course Card**:
  - Thumbnail
  - Course title
  - Progress indicator
  - Action button

#### Action Options
1. **Access Class**:
   - Opens video player interface
   - Shows all course sections/videos
   - Locked content has padlock icon
   - Unlocked content playable
   - Progress tracking

2. **Mark as Satisfactory**:
   - Simple confirmation
   - Moves to completed
   - Request review

3. **Mark as Unsatisfactory**:
   - Popup with options:
     a. Discuss concerns with seller (opens message)
     b. Rate and review
     c. Cancel and request refund (full or partial)

4. **Rate and Review**:
   - Star rating (1-5)
   - Written review
   - Submit and publish

#### Refund Request Flow
- Same as standard refund process
- Full refund or partial refund
- Reason required
- Seller notified
- 48-hour response window
- Admin investigation if disputed

#### Video Content Lock/Unlock
- **Locked content**: Padlock icon, not playable
- **Unlocked content**: Playable, accessible
- **Unlock logic**:
  - Purchase grants access
  - Progressive unlock (optional)
  - Admin can configure

### 9. Purchase History / Invoice Section

#### Display Information
- List of all transactions
- Each transaction shows:
  - Transaction ID
  - Date
  - Service/class name
  - Seller name
  - Amount paid
  - Payment method
  - Status
  - Action button (Download Invoice)

#### Invoice Download
- **Format**: PDF
- **Content**:
  - Platform name and logo
  - Buyer information
  - Seller information
  - Transaction details
  - Itemized breakdown
  - Subtotal, commission, tax, total
  - Payment method
  - Date and transaction ID

#### Technical Details
- Use DomPDF or similar
- Template design in view
- Generate on-demand
- File: `TransactionController`, invoice method

### 10. Wishlist

#### Display
- Card layout (similar to service listings)
- Each card shows:
  - Service image/video
  - Service title
  - Seller name
  - Price
  - Rating
  - Remove button (X icon)

#### Actions
- **Click card**: Navigate to service detail page
- **Click remove**: Remove from wishlist
  - Confirmation (optional)
  - Disappears from list
  - Can be re-added from service page

#### Technical Details
- Database: `wishlists` table
- User ID + Service ID relationship
- Toggle wishlist status
- Count for display

### 11. Review System - Buyer Side

#### When Reviews Allowed
- **After completion**: Order status = Completed or Delivered
- **From tabs**: Completed tab or Delivered tab
- **One review per order**: Cannot review twice

#### Review Submission
- Star rating (1-5 stars)
- Written review (textarea)
- Optional: Upload images
- Submit button

#### Review Editing Rules
1. **Can edit if**:
   - Seller has NOT replied to review
   - Within 24 hours of posting
2. **Cannot edit if**:
   - Seller has replied
   - More than 24 hours have passed

#### Review Deletion
- Buyer can delete their own review
- Confirmation required
- Seller's reply also deleted
- Affects seller's rating

#### Display
- **Reviews Section**: Shows all submitted reviews
- Each review displays:
  - Service name
  - Seller name
  - Date submitted
  - Rating given
  - Review text
  - Seller's reply (if any)
  - Edit button (if eligible)
  - Delete button

### 12. Account Settings

#### Change Password
- Current password required
- New password
- Confirm new password
- Validation rules
- Success message

#### Change Email
- Current email displayed
- New email input
- Verification email sent to new address
- Confirm verification before change
- Update all records

#### Update Card Details (Stripe)
- **Purpose**: Update payment method for future purchases
- **Process** (similar to Fiverr/Upwork):
  1. Click "Update Card Details"
  2. Redirect to Stripe payment method management
  3. Or: Modal with Stripe Elements
  4. Enter new card information
  5. Stripe validates and saves
  6. Display saved cards (last 4 digits)
  7. Set default payment method
  8. Delete saved cards option

#### Technical Details
- Stripe Customer ID stored in user record
- Stripe PaymentMethod API
- PCI compliance maintained
- Secure token handling

---

## SELLER/TEACHER PANEL

### 1. Dashboard Real-Time Updates

#### Metrics Display
- Total earnings (all time)
- This month earnings
- Pending payouts
- Active orders count
- Completed orders count
- Average rating
- Total reviews
- Profile views (impressions)

#### Recent Activities
- Latest orders received
- Recent messages
- New reviews
- Payout history
- Latest bookings

#### Notifications Display
- Similar to buyer panel
- Seller-specific notifications
- Action required indicators

### 2. Messaging System - Custom Offers

#### Custom Offer Interface
- Accessible from message thread
- "Custom Offer" button/icon
- Initiates custom offer creation flow

#### Custom Offer Types
1. **Class Booking Custom Offer**
2. **Freelance Service Custom Offer**

#### Navigation
- "Back" button: Return to previous step
- "Next" button: Proceed to next step
- "Cancel" button: Discard and return to messages
- "Send Offer" button: Submit offer to buyer

### 3. Custom Offer - Class Booking

#### Step 1: Select Class Type
- **Options**:
  - Class Booking
  - Freelance Booking
- Select and click "Next"

#### Step 2: Select Active Class
- Display all active classes created by seller
- Cannot select inactive/hidden classes
- Shows:
  - Class title
  - Class type (one-to-one, group)
  - Duration
  - Standard price
  - Subject
- Select one class and click "Next"

#### Step 3: Select Payment Structure
- **Single Payment**: One class only
- **Milestone Payment**: Multiple classes
- Select and click "Next"

#### Step 4a: Single Payment Details
- **Class heading**: Auto-filled from selected class
- **Description**: Customize offering
- **Number of classes**: Fixed at 1 (cannot change)
- **Price**: Set custom price
- **Class date**: Select date
- **Class time**: Select start and end time
- **Requirements**: Any special requirements or notes
- **Back** button: Return to Step 3
- **Send Offer** button: Submit to buyer

#### Step 4b: Milestone Payment Details
- **Class heading**: Auto-filled from selected class
- **Description**: Customize offering
- **Number of classes**: Dropdown (2, 3, 4, 5, etc.)
- **For each class**:
  - Class [X] label
  - Date selector
  - Start time
  - End time
  - Price
  - Requirements
- **Add class** button (if want more than initially selected)
- **Back** button: Return to Step 3
- **Send Offer** button: Submit to buyer

#### Offer Sent
- Confirmation message
- Buyer receives notification + email
- Message thread updated with offer
- Offer pending status

#### Buyer Receives Offer
- Notification + email
- Can view full offer details
- Options:
  - Accept offer → Proceed to payment
  - Reject offer → Declined message
  - Negotiate → Reply with message

#### Payment Processing
- Upon acceptance: Buyer redirected to payment
- Stripe payment processing
- Upon successful payment:
  - Order created
  - Seller notified
  - Order appears in active orders

### 4. Custom Offer - Freelance Service (Online)

#### Step 1-2: Same as Class Booking
- Select "Freelance Booking"
- Select active freelance service

#### Step 3: Select Payment Structure
- **Single Payment**: One-time delivery
- **Milestone Payment**: Multiple deliveries
- Select and click "Next"

#### Step 4a: Single Payment Details
- **Service heading**: Auto-filled
- **Description**: Customize offering
- **Number of revisions**: Set allowed revisions (0, 1, 2, 3, unlimited)
- **Delivery time**: Number of days
- **Price**: Set custom price
- **Requirements**: Any special notes
- **Back** button: Return to Step 3
- **Send Offer** button: Submit to buyer

#### Step 4b: Milestone Payment Details
- **Service heading**: Auto-filled
- **Description**: Customize offering
- **Number of milestones**: Select quantity
- **For each milestone**:
  - Milestone [X] name
  - Milestone description
  - Delivery time (days)
  - Price
  - Requirements
- **Add milestone** button
- **Back** button: Return to Step 3
- **Send Offer** button: Submit to buyer

#### Payment Held Until Completion
- **Important**: Payment held, not immediately released
- Buyer pays upfront
- Payment held by platform
- Released to seller upon:
  - Milestone delivery acceptance
  - Or: Final delivery acceptance
  - Or: Auto-release after X days no dispute

### 5. Custom Offer - Freelance Service (In-Person)

#### Additional Fields Required
- **Start date**: Date of work
- **Start time**: Time work begins
- **End time**: Time work ends

#### Reason
- In-person freelance is time-based work
- Example: Plumber works 2 hours, charges for 2 hours
- Different from project-based online work

#### Single Payment In-Person
- All fields from online version PLUS:
  - Start date
  - Start time
  - End time
- Price based on time or flat rate

#### Milestone Payment In-Person
- For EACH milestone, include:
  - All fields from online version
  - Start date
  - Start time
  - End time
- Useful for multi-day or multi-session work

#### Design Similarity
- **Classes**: Already implemented with time fields
- **Freelance In-Person**: Use similar design pattern
- **Freelance Online**: Project-based, no time fields

### 6. Client Management

#### Client List Display
- All buyers who made payments
- Display information:
  - Client name
  - Profile picture
  - Number of orders
  - Total spent
  - Active orders
  - Last order date

#### Available Actions
- **View Profile**: (If buyers have profiles) Navigate to buyer profile
- **Send Message**: Open message interface
- **Cancel Subscription**:
  - Only if active subscription exists
  - Confirmation popup
  - Cancels future recurring payments
- **Report Buyer**:
  - Popup with reason
  - Submit to admin
  - Admin reviews

#### Active Orders Tab
- Filter clients by active orders only
- Quick access to current engagements

### 7. Class/Service Management

#### Add New Service
- **Options**: Class or Freelance
- **Class Options**: Online or In-Person
- **Class Formats**: Ongoing, One-Day, Trial
- **Already implemented**: Needs testing
- **Process**:
  1. Select type (class/freelance)
  2. Fill in details (title, description, pricing, etc.)
  3. Upload images/videos
  4. Set availability
  5. Publish

#### Edit Service
- **Already implemented**: Needs testing
- Edit all service details
- Save changes
- Affects new bookings only (not existing orders)

#### Delete Service
- **Already implemented**: Needs testing
- Confirmation required
- Cannot delete if active orders exist
- Or: Archive instead of hard delete

#### Hide Service
- **Already implemented**: Needs testing
- Service removed from public listings
- Not deleted, just invisible
- Can be unhidden later
- Existing orders unaffected

#### Trial Class Options

**Requirements for Trial Class**:
- **Must be**: "Live" class (not video course)
- **Must be**: "One-off Payment" (not subscription)

**Free Trial Class**:
- **Duration**: Fixed 30 minutes (cannot change)
- **Price**: Fixed $0 (cannot change)
- **Zoom/Google Meet**: Required integration
- **Display**: Separate from regular classes

**Paid Trial Class**:
- **Duration**: Custom (seller sets)
- **Price**: Custom (seller sets)
- **Zoom/Google Meet**: Required integration
- **Display**: Separate from regular classes

#### Zoom and Google Meet Integration
- **For ALL live classes**:
  - Trial classes (free and paid)
  - One-day classes
  - Recurring classes
- **NOT for**:
  - Video courses (pre-recorded)
  - In-person classes
- **Implementation**:
  - Zoom meeting auto-generation
  - Google Meet link auto-generation
  - Seller can choose preferred platform
  - Link sent to participants 2 hours before class

### 8. Manage Profile - Name Display

#### Toggle Functionality
- **Option 1**: Show full name
- **Option 2**: Show first name only (first name + initial of last name)

#### Where Full Name Appears
- **Seller's main profile page ONLY**
- When buyer visits seller's profile
- Includes:
  - About section
  - Service listings on profile
  - Contact information

#### Where First Name + Initial Appears
- **Seller cards EVERYWHERE else**:
  - Homepage featured sellers
  - Search results
  - Category listings
  - Service detail pages (card view)
- **Format**: "John D." for "John Doe"

#### Important Rules
- Toggle affects profile page only
- Cards ALWAYS show first name + initial
- Cannot show full name on cards (privacy)

#### Current Issue
- Toggle exists but shows full name everywhere
- **Fix required**: Full name only on profile page

### 9. Earnings and Payouts

#### Earnings Display
- **Available balance**: Ready to withdraw
- **Pending balance**: Awaiting clearance
- **Total earnings**: All-time
- **This month earnings**: Current month
- **Earnings history**: Transaction list

#### Withdrawal Methods
- **PayPal**: PayPal email required
- **Stripe**: Bank account via Stripe Connect
- **Regional options**:
  - Methods suitable for Bangladesh (e.g., bKash, Nagad)
  - Methods suitable for Pakistan (e.g., Easypaisa, JazzCash)
  - Other regional payment systems

#### Withdrawal Process
1. Click "Withdraw Funds"
2. Select withdrawal method
3. Enter withdrawal amount
4. Minimum withdrawal amount enforced
5. Confirm withdrawal
6. Processing time notification
7. Funds transferred
8. Email confirmation

#### Stripe Integration
- **Stripe Connect**: Required for seller payouts
- Seller onboarding to Stripe
- Bank account verification
- Transfer funds directly to bank

#### PayPal Integration
- Seller provides PayPal email
- Platform sends payment via PayPal API
- Seller receives email notification

#### Technical Details
- Withdrawal requests tracked in database
- Admin approval (optional)
- Automated payout processing
- Payout history for sellers
- Transaction fees displayed

### 10. Invoice Statement

#### Display
- List of all payments received
- Each payment shows:
  - Date
  - Buyer name
  - Service/class name
  - Amount earned (after commission)
  - Status (pending, completed)
  - Action (Download Invoice)

#### Invoice Download
- PDF generation
- Includes:
  - Seller information
  - Buyer information
  - Service details
  - Amount paid by buyer
  - Platform commission
  - Amount earned by seller
  - Transaction ID
  - Date

### 11. Calendar Fixes

#### Microsoft Edge Issue
- **Current**: Works on Chrome, not on Edge
- **Required**: Test and fix for Edge compatibility
- **Check**: JavaScript compatibility, date pickers, etc.

#### Google Calendar Integration (Optional)
- **If not too complex**: Implement two-way sync
- **If too complex**: Remove email reminders, keep simple calendar
- **Features**:
  - Sync events to Google Calendar
  - Email reminders from Google
  - Two-way updates

#### Basic Calendar Features
- Add events (class dates, reminders, notes)
- Color coding
- Date/time selection
- Notes/description
- View by month/week/day

### 12. Review Management - Seller Side

#### View Reviews
- List of all reviews received
- Each review shows:
  - Buyer name
  - Service/class name
  - Rating (stars)
  - Review text
  - Date
  - Seller's reply (if exists)

#### Reply to Reviews
- Reply text input
- Submit reply
- Reply appears below review
- Buyer notified

#### Edit Reply
- Seller can edit their own reply
- **No time limit** (unlike buyer)
- **No restrictions** if buyer has seen it
- Edit button always available

#### Delete Reply
- Seller can delete their own reply
- Confirmation required
- Review remains, only reply removed

---

## ADMIN PANEL

### 1. Dashboard and Analytics - Real-Time

#### Key Metrics to Display

**User Statistics:**
- Total sellers (all-time)
- Total buyers (all-time)
- Total users (all-time)
- Sellers online now
- Buyers online now

**Order Statistics:**
- Total orders (all-time)
- Orders today
- Orders this month
- Active orders
- Completed orders
- Cancelled orders
- Disputed orders

**Application Statistics:**
- Total applications
- Pending applications
- Approved applications
- Rejected applications

**Visitor Statistics:**
- Total visitors (all-time)
- Visitors today
- Visitors this month
- Page views

**Appointment Statistics:**
- Total Zoom appointments
- Appointments today
- Appointments this month

**Payout Statistics:**
- Payout requests pending
- Payouts processed today
- Payouts processed this month

**Signup Statistics:**
- New signups today
- New signups this month
- New signups this year

#### Time Filter Options
- **Today**: Current day statistics
- **Yesterday**: Previous day statistics
- **Custom Date**: Select date range
- **Lifetime**: All-time statistics (default)

#### Google Analytics Integration
- Embed Google Analytics dashboard
- Or: Fetch data via Google Analytics API
- Display:
  - Page-specific results
  - Traffic sources
  - User behavior
  - Conversion rates
  - Bounce rates

#### Finance Report
- **Display amounts in currency** (not just numbers)
- Sections:
  - Total revenue
  - Commission earned (admin earnings)
  - Seller payouts
  - Refunds issued
  - Pending payouts
  - Net profit
- Time filters apply
- Export to CSV/Excel

### 2. Seller Management

#### All Sellers Section

**Categories:**
1. **Active Sellers**:
   - Approved and currently selling
   - Can receive bookings
   - Visible in search

2. **Hidden Sellers**:
   - Admin has hidden
   - Invisible in search/listings
   - Cannot receive new bookings
   - Can still fulfill existing orders

3. **Paused Sellers**:
   - Seller or admin paused account
   - No new bookings
   - Can be unpaused
   - Existing orders continue

4. **Banned Sellers**:
   - Cannot access seller account
   - Can still access buyer account
   - Notification with ban reason
   - Cannot create new services

5. **Deleted Sellers**:
   - Seller deleted their own account
   - Admin can view for records
   - Cannot be restored

#### Seller Actions (Active Sellers)

**View Dashboard:**
- Access full seller dashboard
- See all metrics, orders, earnings
- **EXCEPT**: Account settings (password, email)
- Read-only access

**View Profile:**
- Navigate to seller's public profile
- See as buyers see it

**Edit Commission:**
- Custom commission for this seller
- Overrides default 15%
- Can be percentage or amount
- Save changes
- Applies to all services by this seller (unless service-specific override)

**Hide Seller:**
- Moves to "Hidden" section
- Services invisible in search
- No new bookings
- Existing orders unaffected

**Pause Account:**
- Moves to "Paused" section
- No new bookings
- Seller can request unpause
- Can be unpaused by admin

**Ban Account:**
- Moves to "Banned" section
- No seller access
- Still can access buyer side
- Notification sent with reason
- Ban reason field required

**Delete Account:**
- Soft delete (preferred)
- Moves to "Deleted" section
- Can be restored (optional)

#### Application Management
- **Status**: Done but needs testing
- **Process**:
  1. User registers as seller
  2. Application appears in "Pending" tab
  3. Admin reviews application
  4. Admin approves or rejects:
     - **Approve**: User becomes active seller, receives email
     - **Reject**: User notified with reason, receives email

### 3. Service Management

#### All Services Display
- List of all services from all sellers
- Display information:
  - Service title
  - Seller name
  - Category
  - Price
  - Type (class/freelance, online/in-person)
  - Status (active, hidden, cancelled)
  - Orders count
  - Rating

#### Service Actions

**Feature on Homepage:**
- Add service card to homepage
- Select which section (trending, featured, top-rated, etc.)
- Service appears prominently
- Increases visibility

**Cancel Service:**
- Service no longer bookable
- Existing orders continue
- Seller notified with email + notification
- Cancellation reason required
- Service moves to "Cancelled" status

**Edit Commission:**
- Custom commission for THIS service only
- Overrides seller-specific and default commission
- Highest priority in commission calculation
- Percentage or amount

**Send Notification:**
- Send message to seller about service
- Notification + email
- Custom message

#### Homepage Featured Services

**Add to Homepage Process:**
1. Admin clicks "Add to Homepage"
2. Selects section (e.g., "Trending", "Featured")
3. Service added to that section
4. Displays on homepage

**Automatic Replacement:**
- **Issue**: If seller deletes featured service, it disappears
- **Required**: Automatic replacement
- **Logic**:
  - Detect when featured service deleted/hidden
  - Find replacement service from same category
  - Requirements for replacement:
    - Same category as deleted service
    - Seller has 4+ star rating
    - Service is active and visible
  - Automatically feature replacement
- **File**: Dynamic management, homepage controller

### 4. Buyer Management

#### Buyer Categories

1. **Active Buyers**:
   - Registered AND made at least one payment
   - Have transaction history

2. **Inactive Buyers**:
   - Registered but NO payments made
   - Account exists, no orders

3. **Banned Buyers**:
   - Admin banned their account
   - Cannot make purchases
   - Can view site (read-only)

4. **Deleted Buyers**:
   - Buyer deleted their own account
   - Admin can view for records

#### Buyer Actions

**View Dashboard (All Except Account Settings):**
- Access full buyer dashboard
- See orders, bookings, messages, reviews, wishlist
- **CANNOT access**: Change password, change email
- Read-only access

**Delete Account:**
- Soft delete
- Move to "Deleted" section
- Account deactivated

**Ban Account:**
- Move to "Banned" section
- Cannot make purchases
- Can still view site
- Notification sent with reason

**Unban Account:**
- Available for banned buyers
- Returns to Active (if has orders) or Inactive (if no orders)
- Notification sent

### 5. Admin Management

#### Add New Admins
- Invite by email
- Set admin role/level
- Set permissions

#### Admin Roles/Levels
- **Super Admin**: Full access to everything
- **Top Super Admin**: Hardcoded, undeletable (project owner)
- **Custom roles**: Set specific permissions

#### Permissions System
- View only
- Edit content
- Manage users
- Manage payments
- Manage services
- Manage reports
- Delete data
- Etc.

#### Top Super Admin
- **Hardcoded email address** (provided by client)
- Cannot be deleted by any other admin
- Full access to all features
- Bypasses all permission checks
- Can demote/remove any other admin
- Ultimate authority

#### Testing Required
- Test adding new admins
- Test setting roles and permissions
- Test permission enforcement
- Test super admin capabilities

### 6. Dynamic Management

#### Category and Subcategory Management
- **Status**: Done but needs homepage dropdown update
- **Issue**: Homepage dropdown menu not showing categories correctly
- **Required**:
  - Update dropdown display logic
  - Show categories as main menu items
  - Show subcategories as dropdown items under parent category
  - Clicking category: Goes to category page
  - Clicking subcategory: Goes to subcategory page

#### Category Actions
- Add new category
- Edit category (name, description, image)
- Delete category (if no services)
- Reorder categories

#### Subcategory Actions
- Add new subcategory to category
- Edit subcategory
- Delete subcategory (if no services)
- Move subcategory to different category
- Reorder subcategories

### 7. Host Guidelines

#### Admin Editing
- **Status**: Done for admins with right permissions, needs full testing
- Edit content for seller guidelines
- Add/edit sections
- Format text (rich text editor)
- Save changes

#### Display to Sellers
- Appears in seller panel under "Host Guidelines"
- Sellers can read but not edit
- Shows terms, rules, best practices

### 8. Top Seller Criteria

#### Settings to Configure
- **Minimum earnings**: Dollar amount (e.g., $5,000)
- **Minimum bookings**: Number of completed orders (e.g., 100)
- **Minimum rating**: Average star rating (e.g., 4.5)

#### Top Seller Badge
- **Display**: Icon/badge on seller card
- **Qualification**: Must meet ALL criteria
- **Updates**: Real-time or daily calculation
- **Benefits** (optional future):
  - Priority in search
  - "Top Seller" filter
  - Marketing materials

### 9. Survey Sorting (Service Ranking)

#### Ranking Factors
1. **Impressions**: Number of times service viewed
2. **Clicks**: Number of times service clicked
3. **Orders**: Number of bookings received
4. **Reviews**: Number and quality of reviews

#### Importance Percentage
- Admin sets weight for each factor
- Total MUST equal 100%
- Example configurations:
  - Reviews heavy: 55%, Orders 25%, Clicks 15%, Impressions 5%
  - Orders heavy: 50%, Reviews 30%, Clicks 15%, Impressions 5%

#### Ranking Algorithm
- Calculate weighted score for each service
- Example:
  ```
  Score = (Impressions × 0.05) + (Clicks × 0.15) + (Orders × 0.25) + (Review_Score × 0.55)
  ```
- Sort services by score
- Display in search results accordingly

#### Impact
- Higher-ranked services appear first in search
- Better visibility leads to more bookings
- Sellers incentivized to improve metrics

### 10. Notifications (Admin to Users)

#### Send Notification Options
1. **All Users**: Everyone (buyers + sellers + other admins)
2. **Sellers Only**: All sellers
3. **Buyers Only**: All buyers
4. **Specific Users**: Enter email addresses (comma-separated)

#### Notification Interface
- Title field
- Message field (rich text)
- Recipient selection (radio buttons)
- Email input (for specific users)
- Send button

#### Notification Delivery
- In-app notification (notification bell)
- Email notification
- Optional: Push notification (future)

#### Use Front-End Designs
- Front-end source code has designs
- If not in front-end, use Figma

### 11. Payment Management

#### All Orders Section
- **Display**: Every order/transaction
- **Information**:
  - Buyer name
  - Seller name
  - Service type
  - Service title
  - Amount
  - Status (pending, active, delivered, completed, cancelled, disputed)
  - Date
  - Actions

#### Payout Details Section
- **Display**: Seller payout information
- **Information**:
  - Seller name
  - Total earnings
  - Amount withdrawn
  - Available balance
  - Pending balance
  - Payout method
  - Last payout date
  - Action (Process payout, if manual)

#### Automatic Refunds via Stripe
- **Research required**: Best method
- **Options**:
  1. Stripe API automatic refunds
  2. Manual process via Stripe dashboard
  3. Hybrid approach
- **Preferred**: Automatic via API
- **Implementation**:
  - When buyer dispute not countered within 48 hours
  - Call Stripe Refund API
  - Refund payment intent
  - Update order status
  - Notify buyer and seller

### 12. Refund Process Management

#### Refund Information Display
- **Current**: Shows buyer and seller names
- **Required**: Add buyer dispute reason and seller counter-dispute reason
- **Display**:
  - Buyer name
  - Seller name
  - Service name
  - Refund amount requested
  - Buyer's reason (why they want refund)
  - Seller's counter-dispute reason (why refund shouldn't be granted)
  - Dispute date
  - Deadline for seller response
  - Status

#### View Dispute
- Click "View" action
- Popup or new page with full details:
  - Order details
  - Service description
  - Payment amount
  - Buyer's written reason
  - Seller's written reason
  - Timestamps
  - Evidence (if uploaded)

#### Approve/Reject Refund
- **Approve for Buyer**:
  - Buyer receives full or partial refund
  - Seller does NOT receive payment
  - Automatic Stripe refund processing
  - Email notifications sent

- **Approve for Seller** (Reject Refund):
  - Buyer does NOT receive refund
  - Seller receives payment (released from hold)
  - Email notifications sent

- **Partial Refund** (Optional):
  - Enter refund amount (less than full)
  - Split decision
  - Both parties notified

#### 48-Hour Dispute Window
- **Status**: Done under dynamic management, needs testing
- **Process**:
  1. Buyer initiates dispute
  2. Seller notified immediately (email + notification)
  3. 48-hour timer starts
  4. If seller doesn't respond: Automatic refund to buyer
  5. If seller responds: Payment on hold, admin investigates

#### Payment Hold System
- When both parties dispute
- Payment held by platform
- Cannot be released without admin approval
- Admin investigates and makes decision
- Payment released to appropriate party

### 13. Invoice Statement (Admin)

#### Track All Payments
- Every transaction on platform
- Display:
  - Date
  - Buyer name
  - Seller name
  - Service name
  - Amount paid by buyer
  - Admin commission earned
  - Amount to seller
  - Status
  - Service type

#### Download Invoices
- Admin can download platform revenue reports
- PDF or CSV
- Includes:
  - All transaction details
  - Commission breakdown
  - Totals and subtotals
  - Date range

### 14. Discount Codes

#### Coupon Creation
- Coupon name
- Coupon code (unique)
- Discount type: Amount or Percentage
- Discount value
- Start date
- Expiry date
- Usage limit (optional): Unlimited or specific number
- Minimum purchase amount (optional)

#### Discount Application Rules
- **CRITICAL**: Discount ALWAYS deducted from admin's 15% commission, NEVER from seller's fee
- Example:
  - Service price: $100
  - Seller gets: $85 (15% commission to admin)
  - Admin gets: $15
  - If 10% discount coupon used:
    - Buyer pays: $90
    - Seller still gets: $85 (unchanged)
    - Admin gets: $5 (reduced by discount)

#### Coupon Types

**General Discount (All Sellers):**
- Select "All Sellers"
- Applies to any service on platform
- Buyer can use for any purchase

**Seller-Specific Discount:**
- Select "Specific Sellers"
- Enter seller email address(es)
- Coupon only works for that seller's services
- Error message if buyer tries to use with other sellers

**Promoter Discount (Future):**
- For affiliate/promoter use
- Tracking who used the code
- Commission to promoter (optional)

### 15. Reviews and Ratings (Admin Moderation)

#### View All Reviews
- List of every review on platform
- Display:
  - Buyer name
  - Seller name
  - Service name
  - Rating
  - Review text
  - Date
  - Seller's reply (if any)
  - Status (published, flagged, deleted)

#### Admin Actions
- **View Details**: See full review and conversation
- **Delete Review**: Remove review permanently
  - Confirmation required
  - Reason logged
  - Seller and buyer notified
- **Flag Review**: Mark as inappropriate (optional)
- **Contact User**: Send message about review

#### Reasons for Deletion
- Abusive language
- Personal attacks
- False information
- Seller disputed and admin agrees
- Spam
- Off-topic

### 16. Zoom and Stripe Settings

#### Zoom Settings (Admin Panel)
- Zoom API Key input
- Zoom API Secret input
- Test connection button
- Save settings
- Status indicator (connected/not connected)

#### Stripe Settings (Admin Panel)
- Stripe Publishable Key input
- Stripe Secret Key input
- Stripe Webhook Secret input
- Test mode toggle (test/live keys)
- Currency selection (USD, GBP, etc.)
- Test connection button
- Save settings
- Status indicator

#### Seller Zoom Integration
- **Requirement**: Every seller MUST have Zoom account
- **Setup Process**:
  1. Seller enters Zoom email in settings
  2. Optional: OAuth connection to Zoom
  3. Seller authorizes DreamCrowd to create meetings
  4. Zoom account linked
  5. Platform can generate meetings for seller's classes

### 17. Web Settings

#### Maximum Number of Classes
- Set global limit
- Maximum classes each seller can create
- Applies to all sellers (unless overridden)

#### Commission Rates
- **Seller Commission**: Percentage admin takes from seller (default 15%)
- **Buyer Commission**: Optional fee added to buyer's payment (default 0%)
- Applies globally (unless service-specific or seller-specific override)

#### Currency Management
- **USD/GBP Conversion**:
  - Platform operates in USD
  - Company based in UK (GBP)
  - Question: How does Stripe handle conversion?
  - Required: Research Stripe multi-currency setup
  - Admin receives payouts in GBP?
  - Or: Keep everything in USD?
- **Need to clarify with client**

### 18. SEO

#### Meta Descriptions
- Improve wording for SEO
- All major pages need meta descriptions:
  - Homepage
  - Seller listing pages
  - Category pages
  - Service detail pages
  - About, Contact, etc.

#### SEO-Friendly Content
- Optimize page titles
- Add heading tags (H1, H2, H3)
- Alt text for images
- Schema markup (optional)
- Sitemap generation
- Robots.txt

#### Implementation
- Use Laravel SEO packages
- Or: Manual meta tag management
- Dynamic meta based on page content

### 19. Reports Feature

#### Buyer Reports Against Sellers
- List of all reports
- Display:
  - Buyer name
  - Seller name
  - Report date
  - Report reason
  - Status (new, reviewed, resolved)

#### Seller Reports Against Buyers
- List of all reports
- Display:
  - Seller name
  - Buyer name
  - Report date
  - Report reason
  - Status

#### Admin Investigation Interface
- Click report to view details
- Full report information:
  - Reporter and reported user
  - Date and time
  - Detailed reason/description
  - Related orders (if any)
  - User history/metrics

#### Actions (Optional if not too complex)
- **Ban Account**: Direct ban from report view
- **Send Email**: Contact reporter or reported user
- **Mark as Resolved**: Close report
- **Escalate**: Flag for senior admin review

### 20. Account Settings (Admin)

#### Change Email
- Current email displayed
- New email input
- Verification process
- Update email

#### Update Password
- Current password required
- New password
- Confirm new password
- Update password

---

# TECHNICAL INTEGRATION REQUIREMENTS

## STRIPE INTEGRATION

### Current Status
- **NOT integrated**: Currently just form submission
- **Required**: Full Stripe integration

### Required Implementations

#### 1. Payment Processing
- **Stripe PaymentIntent API**
  - Create PaymentIntent on order initiation
  - Confirm payment on client side
  - Handle payment success/failure
  - File: `BookingController`, `StripeController`

#### 2. Webhooks
- **Webhook Events to Handle**:
  - `payment_intent.succeeded`
  - `payment_intent.payment_failed`
  - `charge.refunded`
  - `customer.subscription.created`
  - `customer.subscription.deleted`
  - `payout.paid`
  - `payout.failed`
- **Webhook Signature Verification**: MUST verify signatures in production
- File: `StripeWebhookController`

#### 3. Buyer Card Management
- **Stripe Customer**:
  - Create Customer on registration
  - Store Customer ID in users table
- **Payment Methods**:
  - Save cards using Stripe Elements
  - Display saved cards (last 4 digits)
  - Delete cards
  - Set default payment method
- **Implementation**: Similar to Fiverr/Upwork process
- File: Account settings controller and views

#### 4. Seller Payout System
- **Stripe Connect**:
  - Express or Standard Connect accounts
  - Seller onboarding flow
  - Bank account verification
  - Identity verification
- **Payouts**:
  - Automated payout processing
  - Manual payout option
  - Payout scheduling
  - Balance tracking
- File: Earnings and payouts controller

#### 5. Refund Automation
- **Stripe Refund API**:
  - Create refund when buyer dispute uncontested
  - Handle partial refunds
  - Handle full refunds
  - Refund status tracking
- **Implementation**:
  ```php
  \Stripe\Refund::create([
    'payment_intent' => $paymentIntentId,
    'amount' => $amountInCents, // Optional for partial
  ]);
  ```
- File: `AutoHandleDisputes` command, Admin refund controller

#### 6. Currency Handling
- **Question**: USD to GBP conversion
- **Research**:
  - Can Stripe handle multi-currency?
  - Auto-convert on payout?
  - Present prices in GBP to UK customers?
- **Implementation**: Based on research findings
- File: Stripe settings, pricing display

#### 7. Subscription Payments
- **Stripe Subscriptions**:
  - Create subscription for recurring classes
  - Handle subscription lifecycle
  - Cancel subscriptions
  - Prorate refunds
- File: Subscription controller, Stripe webhook handler

#### 8. Fast Track Payment
- **Purpose**: Faster application review for sellers
- **Implementation**:
  - Payment link on "Become an Expert" page
  - Flat fee (e.g., $50)
  - Upon payment: Application flagged as "Fast Track"
  - Admin sees priority indicator
- File: Application controller, public site

---

## ZOOM INTEGRATION

### Requirements

#### 1. Zoom Account Requirement
- **All sellers MUST have Zoom account**
- Mandatory for:
  - Providing online live classes
  - Video chat with buyers
- Verification during seller registration or profile setup

#### 2. Zoom API Integration (Admin Panel)
- **API Credentials**:
  - Zoom API Key
  - Zoom API Secret
  - Or: OAuth app credentials
- **Settings Interface**:
  - Input fields for credentials
  - Test connection button
  - Save settings
  - Status display
- File: Admin settings controller and views

#### 3. Seller Zoom Account Linking
- **Method 1**: Email-based
  - Seller enters their Zoom email
  - Platform uses that email to create meetings
  - Simpler but less secure

- **Method 2**: OAuth
  - Seller clicks "Connect Zoom"
  - OAuth flow: Redirect to Zoom
  - Seller authorizes app
  - Zoom account linked
  - More secure, better UX

- **Recommendation**: OAuth method
- File: Seller settings, Zoom OAuth controller

#### 4. Zoom Meeting Generation
- **For Live Classes**:
  - Auto-generate Zoom meeting when class booked
  - Store meeting ID and join URL
  - Send to participants

- **Meeting Settings**:
  - Topic: Class title
  - Start time: Class start time
  - Duration: Class duration
  - Password: Optional
  - Waiting room: Optional
  - Recording: Optional

- **API Call**:
  ```php
  $meeting = $zoom->createMeeting([
    'topic' => 'Class Title',
    'type' => 2, // Scheduled meeting
    'start_time' => '2025-01-15T10:00:00Z',
    'duration' => 60,
    'settings' => [
      'join_before_host' => false,
      'waiting_room' => true,
    ],
  ]);
  ```

- File: Booking controller, class scheduler

#### 5. Video Chat Requests
- **From Buyer to Seller**:
  - Buyer clicks "Request Video Chat" in message thread
  - Popup: Select duration (15/30/60 minutes)
  - Send request to seller
  - Seller receives notification + email

- **From Seller to Buyer**:
  - Same process, reversed

- **Approval Process**:
  - Recipient clicks "Approve" or "Reject"
  - If approved:
    - Zoom meeting generated
    - Both parties receive meeting link
    - Meeting starts at scheduled time
  - If rejected: Request declined, both notified

- **Similar to Upwork**: Video call request system
- File: Message controller, video chat controller

#### 6. Zoom Link Distribution
- **When to Send**:
  - 2 hours before class start
  - In booking confirmation email (for pre-scheduled)
  - In reminder email

- **Where to Display**:
  - Order detail page (for buyer and seller)
  - Class dashboard (for seller)
  - My Learning section (for buyer)
  - Email (clickable link)

#### 7. Google Meet Alternative
- **Option**: Zoom OR Google Meet
- **Seller Choice**: Let seller choose preferred platform
- **Implementation**:
  - Similar to Zoom integration
  - Google Meet API or Calendar API
  - Generate Meet links via Calendar events

- **Recommendation**: Start with Zoom, add Google Meet later if requested

---

## GOOGLE MAPS INTEGRATION

### Current Status
- **Status**: Basic integration exists
- **Required**: Minor fixes and testing

### Testing Required
- Test location search
- Test map display
- Test marker placement
- Test geocoding
- Test reverse geocoding

### Potential Issues to Fix
- API key configuration
- Map not displaying
- Search not working
- Incorrect coordinates

---

## EMAIL SYSTEM

### Email Provider
- **Options**:
  - Laravel Mail with SMTP (Gmail, SendGrid, Mailgun, etc.)
  - AWS SES
  - Mailgun
  - Postmark
- **Recommendation**: Mailgun or SendGrid (better deliverability)

### Email Categories (As detailed in Phase 19)

#### Account-Related Emails
1. Registration and activation
2. Email verification
3. Password reset
4. Security alerts

#### Communication Emails
1. Direct message notifications
2. Custom offer notifications

#### Notification & Reminder Emails
1. Order action reminders
2. Special subscription reminders (every 5 days)
3. Rating and review notifications

#### Policy & Security Emails
1. Terms of service updates
2. Account warnings and bans

#### Transactional Emails
1. Standard order process
2. Private group classes process
3. Order status updates
4. Payment notifications
5. Class booking updates
6. Application status
7. Cancellation emails
8. Refund emails

### Email Templates
- Use Laravel Blade templates
- Responsive design (mobile-friendly)
- Include:
  - DreamCrowd logo
  - Clear subject lines
  - Call-to-action buttons
  - Unsubscribe link (for non-essential emails)
  - Footer with company info

### Email Queue
- Use Laravel Queue system
- Process emails asynchronously
- Prevent delays in user experience
- Monitor queue for failures

---

# IMPORTANT IMPLEMENTATION NOTES

## Design Priority System

### 1. Front-End Source Code (FIRST)
- **Priority**: Check front-end source code FIRST
- **Reason**: Contains improved designs
- **Client will provide**: Google Drive link
- **Contains**:
  - Updated UI/UX designs
  - Improved layouts
  - Corrected designs from Figma

### 2. Figma Designs (SECOND)
- **Priority**: Use ONLY if not in front-end source code
- **Reason**: Some designs outdated or changed
- **Client will provide**: Figma link
- **Caution**: May confuse if designs differ from front-end

### 3. Development Process
1. Receive front-end source code from client
2. Extract and review designs
3. Check if feature design exists in front-end
4. If EXISTS: Use front-end design
5. If NOT EXISTS: Check Figma
6. If in Figma: Use Figma design
7. If in neither: Ask client for clarification

## Testing Requirements

### Before Marking as Complete
- [ ] Test on Chrome browser
- [ ] Test on Microsoft Edge browser
- [ ] Test on Firefox browser
- [ ] Test on mobile devices
- [ ] Test with different user roles
- [ ] Test with different account types
- [ ] Test edge cases
- [ ] Test error handling

### Common Test Scenarios
- New user registration (email/password)
- User login (email/password, Google, Facebook)
- Browse services as guest
- Book service as logged-in user
- Seller creates service
- Seller receives order
- Order lifecycle (pending → active → delivered → completed)
- Order cancellation (within 12 hours, after 12 hours)
- Refund process (buyer dispute, seller counter, admin decision)
- Subscription payment and cancellation
- Review submission and editing
- Admin actions on users and services

## Commission Calculation Priority (Reminder)

### Calculation Order
1. **Check service-specific commission** in `service_commissions` table
   - If enabled: Use this commission

2. **Else, check seller-specific commission** in `seller_commissions` table
   - If enabled: Use this commission

3. **Else, use default commission** in `top_seller_tags` table
   - Typically 15%

### Implementation Location
- File: `app/Models/TopSellerTag.php`
- Method: `TopSellerTag::calculateCommission()`

## Discount Code Rules (Critical)

### ALWAYS Remember
- **Discounts deducted from ADMIN commission ONLY**
- **NEVER deduct from seller's fee**
- **Seller receives same amount regardless of discount**

### Example Calculation
- Service price: $100
- Admin commission: 15% = $15
- Seller receives: $85

**With 10% discount coupon:**
- Buyer pays: $90 (10% off)
- Seller receives: $85 (unchanged)
- Admin receives: $5 (15% of $100 minus $10 discount)

## Private Group Class Rules (Reminder)

### Main Buyer
- Person who paid
- Can cancel entire booking
- Can reschedule
- Can message seller
- Full control

### Guest Users
- Invited by main buyer
- Can ONLY attend class
- Cannot cancel
- Cannot reschedule
- Cannot message seller
- No other actions

### Emails
- Main buyer receives booking confirmations
- Guests receive attendance notification
- All receive class reminders
- Class details shown in MAIN BUYER'S timezone

## Subscription Cancellation Logic

### Canceling from Active Orders
- Cancels that specific order
- Cancels ALL future orders/classes with that seller
- Affects ALL active subscriptions

### Canceling from Expert Tab
- Same effect as above
- Only shows active subscriptions
- Confirmation required

### Canceling Individual Class
- Can cancel one class from milestone/recurring
- Does NOT cancel entire subscription
- Other classes remain active
- Only the cancelled class refunded (if >12 hours)

## Trial Class Display Rules

### When Trial Option Appears
- **MUST be**:
  - "Live" class type (not video course)
  - "One-off Payment" (not subscription)
- **IF subscription selected**: Trial option hidden
- **IF video course selected**: Trial option hidden

### Free vs Paid Trial
- **Free Trial**:
  - Fixed 30 minutes
  - Fixed $0 price
  - Seller cannot change

- **Paid Trial**:
  - Custom duration (seller sets)
  - Custom price (seller sets)

### Trial Class Listing
- **Default**: Homepage shows "Ongoing Class" only
- **To see trials**: Buyer must manually filter
- **Filter options**: Ongoing, One-Day, Free Trial, Paid Trial

## In-Person Service Rules

### Time Fields Required
- Start date
- Start time
- End time

### Applies To
- **In-person classes**: Already implemented
- **In-person freelance**: Needs implementation
- **Each milestone**: Individual time fields
- **Single payment**: One set of time fields

### Does NOT Apply To
- Online classes
- Online freelance services (project-based)
- Video courses

## Automated Tasks (Reference)

### Commands Created
1. `AutoMarkDelivered`: Marks orders as delivered after due date
   - Runs: Hourly
   - Log: `storage/logs/auto-deliver.log`

2. `AutoMarkCompleted`: Marks delivered orders as completed after 48 hours
   - Runs: Every 6 hours
   - Log: `storage/logs/auto-complete.log`

3. `AutoHandleDisputes`: Processes uncontested refunds
   - Runs: Daily at 3:00 AM
   - Log: `storage/logs/disputes.log`

### Scheduled in
- File: `app/Console/Kernel.php`
- Method: `schedule()`

---

## Questions for Client

### Payment Processing
1. Stripe refund automation: Should it be automatic via API or require admin approval?
2. Card details for seller withdrawals: Is this necessary or is bank account via Stripe Connect sufficient?

### Calendar
3. Google Calendar integration: Is this a must-have or nice-to-have? What's the priority?

### Regional Payments
4. Payment methods for Bangladesh/Pakistan: Which specific methods should be prioritized?

### Currency
5. USD to GBP conversion: How should this be handled? Keep everything in USD or convert?
6. Who handles conversion fees: Platform or seller?

### Reports
7. Ban accounts from reports feature: Is this high priority or can be skipped to save time?
8. Send emails from report interface: Same question as above.

---

## Files Provided by Client

### To Receive
- [ ] Front-end source code (via Google Drive)
- [ ] Figma design link
- [ ] Top super admin email address (for hardcoding)
- [ ] Any additional documentation

### To Request if Needed
- [ ] Zoom API credentials
- [ ] Stripe API credentials (test and live)
- [ ] Google Analytics tracking ID
- [ ] Google Maps API key
- [ ] Email provider credentials
- [ ] Any third-party API keys

---

**END OF DOCUMENT**

**Document Created**: Based on client meeting transcript (Oct 1, 2025) and development task list
**Total Requirements**: 250+ detailed tasks across 23 phases
**Estimated Timeline**: 3-6 months for full implementation
**Priority**: Critical bugs and Stripe integration first, then build out remaining features in phases
