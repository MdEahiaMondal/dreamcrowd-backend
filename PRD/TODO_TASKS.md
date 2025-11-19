# DreamCrowd - TO-DO Tasks Checklist

## Overview
This document contains ALL pending tasks that need to be completed, organized by feature phases.

---

# PHASE 1: CRITICAL BUG FIXES & CORE FUNCTIONALITY

## 🔴 Priority: CRITICAL

### Buyer Panel - Critical Fixes
- [ ] **FIX**: "Contact" and "Confirm Booking" buttons not appearing consistently
  - Buttons should ALWAYS be visible (logged in or not)
  - Show login popup for non-logged-in users
  - Currently only appears for some accounts (BUG)
  - File location: Booking page views and controllers

- [ ] **FIX**: Message functionality internal error
  - Works with Google login but NOT with normal registration
  - Investigate why messages fail for some login methods
  - Test and fix for all registration types
  - File location: Message controllers and authentication

- [ ] **FIX**: Search bar errors on homepage
  - Errors appearing when searching
  - Investigate and fix search functionality

### Seller Panel - Critical Fixes
- [ ] **FIX**: Calendar functionality on Microsoft Edge
  - Currently only works on Chrome
  - Test and fix for Microsoft Edge browser
  - File location: Calendar component

---

# PHASE 2: REAL-TIME UPDATES & NOTIFICATIONS

## 🟡 Priority: HIGH

### Real-Time Updates Implementation
- [ ] **Implement**: Real-time dashboard updates
  - Buyer dashboard: metrics, recent bookings
  - Seller dashboard: notifications, recent activities
  - Admin dashboard: all statistics
  - Technology: Consider WebSockets or Pusher

- [ ] **Implement**: Real-time message updates
  - Messages should update without page refresh
  - Both buyer and seller panels
  - File location: Message controllers and views

- [ ] **Implement**: Real-time notification system
  - Use front-end source code designs
  - Notifications for ALL actions:
    - Order confirmations
    - Order cancellations
    - Refunds
    - Disputes
    - Reviews
    - Application approvals/rejections
  - Improve notification message wording (better English)
  - Example: "your email is verified successfully" → "your email has been successfully verified"

- [ ] **Implement**: Real-time order status changes
  - Display status changes without refresh
  - Active, delivered, completed, cancelled

---

# PHASE 3: VIDEO COURSES & MY LEARNING

## 🟡 Priority: HIGH

### Video Course Public Page
- [ ] Improve video course public page design
  - Move heading to proper position
  - Adjust payment section positioning
  - Add "Buy Cost" button with amount
  - Use front-end source code for design
  - File location: Public site views

### My Learning Section - Video Orders
- [ ] Implement video course access in "My Learning"
  - "Access Class" button functionality
  - "Mark as Satisfactory" option
  - "Mark as Unsatisfactory" option with popup:
    - Discuss concerns with seller
    - Rate and review
    - Cancel and request refund
  - Video content lock/unlock feature (padlocks for locked content)
  - Full/partial refund request flow
  - File location: User dashboard, My Learning section

---

# PHASE 4: STRIPE PAYMENT INTEGRATION

## 🔴 Priority: CRITICAL

### Complete Stripe Integration
- [ ] **Implement**: Full payment processing (currently just form submission)
  - Payment intent creation
  - Payment confirmation handling
  - Webhook integration
  - File location: BookingController, StripeWebhookController

- [ ] **Implement**: Card details update for buyers
  - Follow Fiverr/Upwork process
  - Stripe payment method management
  - File location: Account settings for buyers

- [ ] **Implement**: Card details update for sellers (if necessary)
  - Determine if needed for withdrawals
  - Stripe Connect or similar
  - File location: Account settings for sellers

- [ ] **Implement**: Automated payout system
  - Seller withdrawal functionality
  - PayPal integration
  - Stripe payouts
  - Regional payment options (Bangladesh, Pakistan, etc.)
  - File location: Earnings and Payouts section

- [ ] **Implement**: Automated refund system
  - Automatic refunds via Stripe API
  - Full and partial refunds
  - Handle payment intent cancellation
  - File location: AutoHandleDisputes command, AdminController

- [ ] **Configure**: USD/GBP currency conversion
  - Handle UK company with USD payments
  - Stripe currency handling
  - Admin Stripe settings configuration

- [ ] **Configure**: Admin Stripe settings
  - API keys management
  - Webhook configuration
  - Currency settings

- [ ] **Implement**: Fast track payment link
  - Under "Become an Expert" section
  - For faster application review
  - File location: Public site, application process

---

# PHASE 5: ZOOM INTEGRATION

## 🟡 Priority: HIGH

### Zoom Account & Video Chat
- [ ] **Require**: Zoom account for all sellers
  - Mandatory for providing online classes
  - Mandatory for video discussions with buyers
  - Seller Zoom account linking via email
  - File location: Seller registration, settings

- [ ] **Implement**: Zoom API integration
  - API key management in admin panel
  - Zoom meeting generation
  - File location: Admin panel - Zoom settings

- [ ] **Implement**: Video chat request system
  - Buyer can request video chat with seller
  - Seller can request video chat with buyer
  - Approval/rejection system
  - Notification system for requests
  - Similar to Upwork process
  - File location: Message section

- [ ] **Implement**: Zoom link generation for live classes
  - Trial classes
  - One-day classes
  - Recurring classes
  - Automatic meeting creation
  - File location: Class management, booking system

- [ ] **Add**: Zoom and Google Meet options for all live classes
  - Display when "Live" is selected
  - Available for trial, one-day, and recurring classes
  - NOT for video courses
  - File location: Class creation form

---

# PHASE 6: CUSTOM OFFERS & MILESTONE PAYMENTS

## 🟢 Priority: MEDIUM

### Custom Offer - Class Booking
- [ ] **Implement**: Complete custom offer functionality
  - Select active class to customize
  - Single payment option (1 class):
    - Class description
    - Number of classes: 1 (fixed)
    - Price, date, time, requirements
  - Milestone payment option (multiple classes):
    - Multiple class selection
    - Individual date, time, requirements for each
  - "Back" and "Next" navigation buttons
  - Send offer to buyer
  - Buyer approval/rejection system
  - Payment processing upon approval
  - File location: Message section, custom offer controller

### Custom Offer - Freelance Service
- [ ] **Implement**: Single payment option
  - Service description
  - Number of revisions
  - Delivery time
  - Price
  - Payment held until completion
  - File location: Custom offer controller

- [ ] **Implement**: Milestone payment option
  - Multiple milestones
  - Description and details for each milestone
  - Individual pricing per milestone
  - File location: Custom offer controller

- [ ] **Implement**: In-person service design
  - Start date field
  - Start time field
  - End time field
  - For each milestone or single payment
  - Time-based work tracking
  - File location: Custom offer forms

---

# PHASE 7: TRIAL CLASSES

## 🟢 Priority: MEDIUM

### Trial Class Implementation
- [ ] **Add**: Trial class option
  - Display only when:
    - "One-off Payment" is selected
    - "Live" class type is selected
  - NOT for video courses
  - NOT for subscription payments
  - File location: Class creation form

- [ ] **Implement**: Free trial class
  - Fixed duration: 30 minutes
  - Fixed price: Zero (0)
  - Cannot be changed by seller
  - File location: Class management

- [ ] **Implement**: Paid trial class
  - Custom duration (seller can set)
  - Custom pricing (seller can set)
  - File location: Class management

- [ ] **Add**: Trial class filter on listing page
  - Default: show only "Ongoing Class"
  - Manual selection for trial/one-day classes
  - Filter options: Ongoing, One-day, Free Trial, Paid Trial
  - File location: Seller listing page

---

# PHASE 8: ORDER MANAGEMENT & EXPERT TAB

## 🟡 Priority: HIGH

### Buyer Panel - Expert Tab
- [ ] **Implement**: Display list of all sellers with payments made
  - File location: Order management, expert tab

- [ ] **Implement**: Active subscription cancellation
  - Only show active subscriptions
  - Cancel subscription functionality
  - File location: Expert tab

- [ ] **Implement**: View seller profile option
  - Navigate to seller's profile page
  - File location: Expert tab

- [ ] **Implement**: Send message to seller
  - Navigate to messages or popup
  - File location: Expert tab

- [ ] **Implement**: Report seller popup and functionality
  - Popup with reason field
  - Submit report to admin
  - Admin receives email notification
  - File location: Expert tab, reports system

### Order Lifecycle Testing
- [ ] **Test**: Active orders functionality
- [ ] **Test**: Pending to active transitions
- [ ] **Validate**: 12-hour cancellation logic
- [ ] **Test**: Refund process (full and partial)
- [ ] **Test**: Subscription cancellation workflow

### Private Group Classes Workflow
- [ ] **Implement**: Main buyer actions
  - Cancel, reschedule, message seller
  - File location: Order management

- [ ] **Implement**: Guest user restrictions
  - Attend class only, no other actions
  - File location: Class attendance system

- [ ] **Implement**: Email notifications for private groups
  - Buyer receives booking confirmation (needs seller approval)
  - Buyer receives approval confirmation
  - Guests receive payment notification (with class details in buyer's timezone)
  - All receive email 2 hours before start time
  - Registration/login button for new guests
  - File location: Email templates, notification system

---

# PHASE 9: SELLER PANEL FEATURES

## 🟢 Priority: MEDIUM

### Client Management
- [ ] **Test**: List of all clients who made payments
- [ ] **Test**: Active orders display
- [ ] **Implement**: Send message functionality
- [ ] **Test**: Subscription cancellation (not on expert tab)
- [ ] **Implement**: Report buyer functionality
  - Popup with reason field
  - Submit to admin
  - File location: Client management

### Earnings and Payouts
- [ ] **Implement**: Withdrawal system
  - PayPal integration
  - Stripe integration
  - Regional payment methods (Bangladesh, Pakistan, etc.)
  - Withdrawal request and processing
  - File location: Earnings and payouts section

### Invoice Statement
- [ ] **Implement**: Display payment history
  - List of all payments received
  - Transaction details
  - File location: Invoice section

- [ ] **Implement**: Invoice download functionality
  - PDF generation with transaction details
  - File location: Invoice section

### Profile Name Display
- [ ] **Fix**: Full name display logic
  - Full name only on seller's profile page (when activated)
  - First name and initial on cards (always)
  - Ensure full name doesn't appear on cards
  - File location: Profile management, card views

---

# PHASE 10: REVIEW SYSTEM

## 🟢 Priority: MEDIUM

### Buyer Reviews
- [ ] **Implement**: Enable reviews from completed orders
  - Review form with rating and comment
  - File location: Completed orders tab

- [ ] **Implement**: Review editing rules
  - Can edit if seller hasn't replied
  - Can edit within 24 hours of posting
  - Cannot edit after seller replies
  - File location: Reviews section

- [ ] **Implement**: Review deletion
  - Buyer can delete their own review
  - File location: Reviews section

- [ ] **Implement**: Display rating and review details
  - Show rating, review text, date
  - Show seller replies
  - File location: Reviews section

### Seller Review Management
- [ ] **Test**: View buyer reviews
- [ ] **Test**: Reply to reviews functionality
- [ ] **Test**: Edit own replies
- [ ] **Test**: Delete own replies
  - File location: Review management section

---

# PHASE 11: ADMIN PANEL - DASHBOARD & ANALYTICS

## 🔴 Priority: CRITICAL

### Real-Time Dashboard
- [ ] **Implement**: Real-time dashboard updates
  - Total sellers
  - Total buyers
  - Total orders
  - Total applications
  - Total visitors
  - Total appointments (Zoom calls)
  - File location: Admin dashboard

- [ ] **Implement**: Dashboard breakdown
  - Total sellers online
  - Total buyers online
  - Payout requests
  - New signups
  - File location: Admin dashboard

- [ ] **Implement**: Google Analytics integration
  - Page-specific results
  - Visitor tracking
  - Traffic analytics
  - File location: Admin analytics

- [ ] **Create**: Finance report
  - Display amounts in currency (not just numbers)
  - Total refunds
  - Total payments
  - Commission earnings
  - File location: Admin finance section

- [ ] **Implement**: Time filters
  - Today
  - Yesterday
  - Custom Date range
  - Lifetime
  - File location: Admin dashboard

---

# PHASE 12: ADMIN PANEL - SELLER MANAGEMENT

## 🟡 Priority: HIGH

### Seller Actions
- [ ] **Test**: Approve/reject applications
- [ ] **Test**: View seller dashboard (full access except account settings)
- [ ] **Test**: View seller profile
- [ ] **Implement**: Edit commission for seller
  - Custom commission rate per seller
  - File location: Seller management

- [ ] **Implement**: Hide seller functionality
  - Remove from search/listings
  - Cards don't appear publicly
  - File location: Seller management

- [ ] **Implement**: Pause seller functionality
  - No new bookings allowed
  - Can be unpaused
  - File location: Seller management

- [ ] **Implement**: Ban seller functionality
  - No seller account access
  - Can still access buyer account
  - Notification with ban reason
  - File location: Seller management

- [ ] **Test**: Manage deleted sellers
  - View deleted seller accounts
  - File location: Seller management

### Homepage Card Replacement
- [ ] **Update**: Automatic card replacement on homepage
  - If seller deletes featured card
  - Automatically display new card from seller with 4+ star rating
  - From same category/section
  - File location: Dynamic management, homepage

---

# PHASE 13: ADMIN PANEL - SERVICE & BUYER MANAGEMENT

## 🟡 Priority: HIGH

### Service Management
- [ ] **Implement**: Display all services list
  - From all sellers
  - File location: Service management

- [ ] **Implement**: Feature services on homepage
  - Admin can add service to homepage
  - File location: Service management

- [ ] **Implement**: Cancel services
  - Send notification to seller
  - Provide cancellation reason
  - File location: Service management

- [ ] **Implement**: Edit commission for specific services
  - Custom commission per service
  - File location: Service management

### Buyer Management
- [ ] **Implement**: Manage active buyers
  - Buyers who made payments
  - View dashboard (except account settings)
  - Delete account option
  - Ban account option
  - File location: Buyer management

- [ ] **Implement**: Manage inactive buyers
  - Registered but no payments
  - View dashboard
  - Delete/ban options
  - File location: Buyer management

- [ ] **Implement**: Manage banned buyers
  - View dashboard
  - Unban option (returns to active or inactive)
  - File location: Buyer management

- [ ] **Implement**: Manage deleted buyers
  - View dashboard only (read-only)
  - File location: Buyer management

---

# PHASE 14: ADMIN PANEL - ADVANCED FEATURES

## 🟢 Priority: MEDIUM

### Admin Management
- [ ] **Create**: Hardcoded top super admin email
  - Undeletable email address
  - Bypass standard role restrictions
  - Full access to everything
  - File location: Admin management, authentication

- [ ] **Test**: Existing admin management functionality
  - Add new admins
  - Set roles and permissions
  - Super admin hierarchy
  - File location: Admin management

### Category Management
- [ ] **Update**: Homepage dropdown menu categories
  - As mentioned in video call and document
  - Proper category display
  - Subcategory organization
  - File location: Dynamic management

- [ ] **Test**: Category and subcategory management
  - Add/edit/delete categories
  - Add/edit/delete subcategories
  - Category-subcategory relationships
  - File location: Dynamic management

### Top Seller Criteria
- [ ] **Implement**: Set earning benchmarks
  - Minimum earnings required
  - File location: Seller settings

- [ ] **Implement**: Set booking number requirements
  - Minimum number of bookings
  - File location: Seller settings

- [ ] **Implement**: Set review rating requirements
  - Minimum average rating (e.g., 4.0, 4.5 stars)
  - File location: Seller settings

- [ ] **Implement**: Display icon on eligible seller cards
  - "Top Seller" badge/icon
  - Only for sellers meeting all criteria
  - File location: Seller card views

### Survey Sorting System
- [ ] **Test**: Set importance percentage
  - Impressions weight
  - Clicks weight
  - Orders weight
  - Reviews weight
  - Total must equal 100%
  - File location: Seller settings

- [ ] **Implement**: Service ranking system
  - Algorithm based on weighted factors
  - Automatic ranking updates
  - File location: Listing page logic

---

# PHASE 15: ADMIN PANEL - NOTIFICATIONS

## 🟡 Priority: HIGH

### Notification System
- [ ] **Implement**: Send notifications to all users
  - Broadcast to everyone
  - File location: Admin notifications

- [ ] **Implement**: Send to sellers only
  - Targeted seller notifications
  - File location: Admin notifications

- [ ] **Implement**: Send to buyers only
  - Targeted buyer notifications
  - File location: Admin notifications

- [ ] **Implement**: Send to specific users by email
  - Individual user targeting
  - Multiple email addresses
  - File location: Admin notifications

- [ ] **Use**: Front-end source code designs
  - Notification UI/UX
  - Popup designs
  - File location: Notification views

---

# PHASE 16: ADMIN PANEL - PAYMENT & REFUND MANAGEMENT

## 🔴 Priority: CRITICAL

### Payment Management
- [ ] **Implement**: Display all orders and transaction statuses
  - Real-time status updates
  - Filter options
  - File location: Payment management

- [ ] **Implement**: Show payout details
  - Automated seller payments
  - Payout history
  - File location: Payment management

- [ ] **Implement**: Automatic refunds via Stripe
  - If seller doesn't respond within 48 hours
  - Integration with Stripe API
  - File location: AutoHandleDisputes command

### Refund Process Management
- [ ] **Improve**: Refund information display
  - Show buyer dispute reason
  - Show seller counter-dispute reason
  - File location: Refund management

- [ ] **Implement**: View dispute details
  - Full dispute history
  - Buyer and seller reasons
  - File location: Refund management

- [ ] **Implement**: Approve/reject refunds
  - Admin decision interface
  - Approve for buyer option
  - Approve for seller option
  - Automatic payment processing
  - File location: Refund management

- [ ] **Test**: 48-hour dispute window
  - Automated refund after 48 hours
  - If seller doesn't respond
  - File location: AutoHandleDisputes command

- [ ] **Implement**: Payment hold system
  - When both parties dispute
  - Admin investigation required
  - Release to appropriate party
  - File location: Payment management

- [ ] **Research**: Stripe refund automation options
  - Direct API integration vs manual transfers
  - Best practices
  - File location: Payment management, Stripe integration

---

# PHASE 17: ADMIN PANEL - REPORTS & REVIEWS

## 🟢 Priority: MEDIUM

### Reports Feature
- [ ] **Implement**: View buyer reports against sellers
  - Report list with details
  - File location: Reports section

- [ ] **Implement**: View seller reports against buyers
  - Report list with details
  - File location: Reports section

- [ ] **Implement**: Admin investigation interface
  - View full report details
  - Report date, reporter, reason
  - File location: Reports section

- [ ] **Optional**: Ban accounts from reports
  - Direct ban action
  - Only if not too complex
  - File location: Reports section

- [ ] **Optional**: Send emails from report interface
  - Direct email to reporter/reported user
  - Only if not too complex
  - File location: Reports section

### Reviews and Ratings
- [ ] **Implement**: View buyer reviews
  - All reviews across platform
  - Filter by seller, buyer, rating
  - File location: Review management

- [ ] **Implement**: Delete abusive reviews
  - Admin moderation
  - Remove inappropriate content
  - File location: Review management

- [ ] **Implement**: Admin moderation interface
  - Review flagging system
  - Bulk actions
  - File location: Review management

---

# PHASE 18: ADMIN PANEL - SETTINGS & SEO

## 🟢 Priority: MEDIUM

### Invoice Statement
- [ ] **Implement**: Track all payments
  - Complete payment history
  - Buyer and seller names
  - Amounts and service types
  - File location: Invoice section

- [ ] **Implement**: Download invoices
  - PDF generation
  - Transaction details
  - File location: Invoice section

### Discount Codes (Enhancement)
- [ ] **Test**: General discount codes
  - Apply to all sellers
  - File location: Discount management

- [ ] **Test**: Seller-specific discount codes
  - Apply to specific seller by email
  - File location: Discount management

- [ ] **Implement**: Promoter discount codes
  - Special discount type
  - Tracking and analytics
  - File location: Discount management

### SEO Improvements
- [ ] **Improve**: Meta descriptions
  - All major pages
  - SEO-friendly content
  - File location: All view files, SEO settings

- [ ] **Optimize**: Website SEO-friendliness
  - Page titles
  - URL structure
  - Schema markup
  - File location: Layout files, routes

- [ ] **Create**: SEO-friendly content
  - Page content optimization
  - Keyword integration
  - File location: Content pages

### Account Settings (Admin)
- [ ] **Test**: Email change functionality
- [ ] **Test**: Password update functionality
  - File location: Admin account settings

---

# PHASE 19: GLOBAL EMAIL SYSTEM

## 🔴 Priority: CRITICAL

### Account-Related Emails
- [ ] **Implement**: Registration and activation notifications
  - Welcome email
  - Account activation link
  - File location: Email templates, AuthController

- [ ] **Implement**: Email verification
  - Verification link email
  - Confirmation message
  - File location: Email templates, verification

- [ ] **Improve**: Password reset emails
  - Reset link generation
  - Security instructions
  - File location: Password reset emails

- [ ] **Implement**: Security alerts
  - Suspicious login notifications
  - Profile change notifications
  - File location: Email templates, security

### Communication and Inbox Emails
- [ ] **Implement**: Direct message notifications
  - Email when new message received
  - Message preview
  - File location: Message notification emails

- [ ] **Implement**: Custom offer notifications
  - Order requests
  - Quote notifications
  - Revision requests
  - File location: Custom offer emails

### Notification and Reminder Emails
- [ ] **Implement**: Order action reminders
  - Pending deliveries
  - Review requests
  - File location: Reminder emails

- [ ] **Implement**: Special subscription reminders
  - Every 5 days if dates/times not selected
  - Continue until all dates/times selected
  - File location: Subscription reminder emails

- [ ] **Implement**: Rating and review notifications
  - New review received
  - Seller reply notification
  - File location: Review notification emails

### Policy and Security Emails
- [ ] **Implement**: Terms of service updates
  - Policy change notifications
  - Privacy updates
  - File location: Policy emails

- [ ] **Implement**: Account warnings
  - Strike notifications
  - Ban notifications with reasons
  - File location: Warning emails

### Transactional Emails - Standard Order Process
- [ ] **Implement**: Buyer order confirmation (pending)
  - Payment received
  - Needs seller approval
  - File location: Order confirmation emails

- [ ] **Implement**: Seller new order notification
  - New booking alert
  - Order details
  - File location: Seller notification emails

- [ ] **Implement**: Buyer order approval notification
  - Seller accepted order
  - Next steps
  - File location: Order approval emails

- [ ] **Implement**: Class/service reminder (2 hours before)
  - For live classes
  - For in-person services
  - Zoom link included
  - File location: Reminder emails

### Transactional Emails - Private Group Classes
- [ ] **Implement**: Buyer booking confirmation
  - Payment received
  - Needs seller approval
  - Guest list included
  - File location: Group booking emails

- [ ] **Implement**: Guest payment notification
  - Buyer paid for them
  - Class details in buyer's timezone
  - File location: Guest notification emails

- [ ] **Implement**: Group reminder (2 hours before)
  - For buyer and all guests
  - Registration/login button for new guests
  - Zoom link
  - File location: Group reminder emails

### Transactional Emails - General
- [ ] **Implement**: Order status updates
  - In progress
  - Delivered
  - Revision requests
  - Completion
  - Cancellation
  - File location: Order status emails

- [ ] **Implement**: Payment notifications
  - Funds cleared
  - Withdrawals processed
  - Payment issues
  - File location: Payment notification emails

- [ ] **Implement**: Class booking updates
  - Rescheduling notifications
  - Attendance reminders
  - File location: Booking update emails

- [ ] **Implement**: Application status emails
  - Seller application approved
  - Seller application rejected
  - File location: Application emails

- [ ] **Implement**: Cancellation emails
  - To buyer and seller
  - Cancellation reason
  - Refund status
  - Similar to Fiverr
  - File location: Cancellation emails

- [ ] **Implement**: Refund notification emails
  - Refund initiated
  - Refund processed
  - Refund denied
  - File location: Refund emails

---

# PHASE 20: UI/UX IMPROVEMENTS

## 🟢 Priority: MEDIUM

### Video Autoplay Control
- [ ] **Disable**: Video autoplay on seller cards
  - Videos don't play automatically
  - File location: Seller card views

- [ ] **Implement**: Play on click or hover
  - User-initiated playback
  - File location: Video player component

- [ ] **Add**: Mute/unmute option
  - Volume control
  - File location: Video player component

- [ ] **Implement**: Click-to-play functionality
  - Manual play button
  - Similar to Fiverr
  - File location: Video player component

### Navigation Improvements
- [ ] **Enable**: Homepage return from dashboard
  - Logo click navigation
  - All panels (buyer, seller, admin)
  - File location: Dashboard layouts

- [ ] **Add**: "Back" and "Next" buttons
  - Custom offer flow
  - Multi-step forms
  - File location: Custom offer forms

### Dashboard Improvements
- [ ] **Add**: "No bookings yet" message
  - When no recent bookings
  - User-friendly messaging
  - File location: Dashboard views

---

# PHASE 21: PURCHASE HISTORY & WISHLIST

## 🟢 Priority: MEDIUM

### Purchase History
- [ ] **Implement**: Display invoice/statement list
  - All transactions
  - Transaction details
  - File location: Purchase history section

- [ ] **Implement**: PDF download functionality
  - Download invoice button
  - PDF generation with all details
  - File location: Invoice download

- [ ] **Include**: All transaction details
  - Buyer/seller names
  - Amounts
  - Service types
  - Dates
  - File location: Invoice template

### Wishlist
- [ ] **Test**: Display saved items in card format
- [ ] **Test**: Remove item option
- [ ] **Test**: Navigate to item page on click
  - File location: Wishlist section

---

# PHASE 22: CALENDAR ENHANCEMENTS

## 🟢 Priority: LOW

### Google Calendar Integration
- [ ] **Research**: Google Calendar integration feasibility
  - Complexity assessment
  - API requirements
  - File location: Calendar component

- [ ] **Optional**: Implement if not too complex
  - Two-way sync
  - Event creation
  - File location: Calendar integration

- [ ] **Alternative**: Remove email reminders if too complex
  - Simplify to basic calendar
  - File location: Calendar component

---

# PHASE 23: TESTING & QUALITY ASSURANCE

## 🟡 Priority: HIGH

### Comprehensive Testing
- [ ] **Test**: All class management features
  - Add, edit, delete services
  - Hide/unhide services
  - Trial class creation

- [ ] **Test**: All order management features
  - Order lifecycle
  - Status transitions
  - Cancellation logic
  - Refund process

- [ ] **Test**: All admin features
  - Seller management
  - Buyer management
  - Service management
  - Payment management
  - Report management

- [ ] **Test**: All seller features
  - Client management
  - Custom offers
  - Earnings and payouts
  - Invoice downloads

- [ ] **Test**: All buyer features
  - Order management
  - Expert tab
  - Purchase history
  - Wishlist
  - Reviews

- [ ] **Test**: All authentication features
  - Email/password login
  - Google OAuth
  - Facebook OAuth
  - Email verification
  - Password reset

- [ ] **Test**: All email notifications
  - Account emails
  - Transactional emails
  - Reminder emails
  - Policy emails

### Cross-Browser Testing
- [ ] **Test**: Chrome browser
  - All features
  - All panels

- [ ] **Test**: Microsoft Edge browser
  - All features (especially calendar)
  - All panels

- [ ] **Test**: Firefox browser
  - All features
  - All panels

- [ ] **Test**: Safari browser (if applicable)
  - All features
  - All panels

### Mobile Responsiveness Testing
- [ ] **Test**: Mobile devices
  - All panels
  - All features
  - Touch interactions

---

# IMPORTANT NOTES

## Design Priority
1. **First**: Check front-end source code (improved designs)
2. **Second**: If not found, refer to Figma designs
3. **Reason**: Front-end source code contains improved designs

## Business Rules to Remember

### Trial Class Requirements
- Only for "Live" classes
- Only for "One-off Payment"
- Free trial: 30 minutes, zero price
- Paid trial: custom duration and price

### Commission and Discounts
- Admin default commission: 15%
- Discounts ALWAYS deducted from admin commission, NOT seller's fee
- Service-specific commission can be changed

### Refund Timeframe
- Within 12 hours of class start: NO refund
- More than 12 hours: Refund eligible
- Seller dispute window: 48 hours
- Different timeframes for different services (configured in admin)

### Private Group Classes
- Main buyer: Can cancel, reschedule, message seller
- Guest users: Can ONLY attend, no other actions
- Public group classes: All users can perform normal actions

### In-Person vs Online Services
- Online: All described functionality applies
- In-Person Freelance: Requires start date, start time, end time (time-based work)

### Subscription Cancellation
- Cancelling one order cancels ALL active subscriptions
- Only active subscriptions shown in Experts tab

### Class Auto-Delivery
- Automatically mark as "Delivered" after scheduled time
- Freelance services: Manual marking required

## Files to Receive from Client
- [ ] Front-end source code (via Google Drive)
- [ ] Figma design link
- [ ] Any additional design documents

## Developer Questions to Clarify
- [ ] Stripe refund automation: Direct API vs manual process?
- [ ] Card details for seller withdrawals: necessary?
- [ ] Google Calendar integration: complexity and timeline?
- [ ] Regional payment methods: which to prioritize?
- [ ] Currency conversion: USD to GBP handling?

---

**Total Phases: 23**
**Estimated Tasks: 250+**
**Priority Distribution:**
- 🔴 Critical: ~40 tasks
- 🟡 High: ~90 tasks
- 🟢 Medium/Low: ~120 tasks
