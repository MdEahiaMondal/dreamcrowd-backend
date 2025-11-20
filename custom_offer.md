# Product Requirements Document (PRD)
**Feature: Custom Offer System**  
**Platform:** Dreamcrowd (Web App)  
**Date:** November 19, 2025  
**Prepared for:** Development Team

## 1. Objective
সেলার যেন মেসেজ চ্যাটের ভিতর থেকেই বায়ারের চাহিদা অনুযায়ী একদম কাস্টমাইজড অফার পাঠাতে পারে (যেমন Fiverr/Upwork-এ আছে)। এটা দুই ধরনের সার্ভিসের জন্য কাজ করবে:
- Live Class Booking (online / in-person)
- Freelance Service (online / in-person)

## 2. User Stories (Acceptance Criteria)

| # | As a …       | I want to …                                                                 | So that …                              | Priority |
|---|--------------|-----------------------------------------------------------------------------|----------------------------------------|----------|
| 1 | Seller       | মেসেজ চ্যাটের ভিতর “Send Custom Offer” বাটন দেখতে ও ক্লিক করতে পারি          | বায়ারকে কাস্টম অফার পাঠাতে পারি          | Must     |
| 2 | Seller       | Class Booking বা Freelance Booking – দুটোর একটা বেছে নিতে পারি                 | সঠিক সার্ভিস টাইপের অফার তৈরি করতে পারি     | Must     |
| 3 | Seller       | Single Payment বা Milestone Payment বেছে নিতে পারি                              | একসাথে পেমেন্ট বা ধাপে ধাপে পেমেন্ট করাতে পারি | Must     |
| 4 | Seller       | Online বা In-person বেছে নিতে পারি                                            | লোকেশন/জুম লিঙ্ক অনুযায়ী অফার তৈরি করি      | Must     |
| 5 | Seller       | যত খুশি মিলেস্টোন যোগ/রিমুভ করতে পারি (Milestone Payment-এর ক্ষেত্রে)             | বড় প্রজেক্ট/মাল্টিপল ক্লাস অফার করতে পারি    | Must     |
| 6 | Seller       | প্রতিটি ক্লাস/মিলেস্টোনের জন্য Title, Description, Date, Start Time, End Time, Price সেট করতে পারি | বায়ার যেন পরিষ্কার বুঝতে পারে কী পাচ্ছে     | Must     |
| 7 | Seller       | In-person সার্ভিস হলে প্রতি মিলেস্টোনের জন্য Date + Start Time + End Time বাধ্যতামূলক | সঠিক শিডিউল দেওয়া যায়                     | Must     |
| 8 | Seller       | Back / Next বাটন দিয়ে স্টেপ-বাই-স্টেপ ফর্ম পূরণ করতে পারি                          | ভুল হলে আগের স্টেপে ফিরে ঠিক করতে পারি      | Must     |
| 9 | Seller       | সবকিছু পূরণ করার পর একটা Preview দেখতে পারি এবং Send করতে পারি                  | বায়ারকে পাঠানোর আগে চেক করতে পারি          | Must     |
| 10| Buyer        | মেসেজে Custom Offer নোটিফিকেশন পাই + Offer ডিটেইলস দেখতে পারি                  | কী অফার করা হয়েছে বুঝতে পারি              | Must     |
| 11| Buyer        | Offer টা Accept / Reject করতে পারি                                               | পছন্দ না হলে রিজেক্ট করতে পারি              | Must     |
| 12| Buyer        | Accept করলে সরাসরি Stripe পেমেন্ট পেজে যাই                                       | পে করে অর্ডার কনফার্ম করতে পারি             | Must     |
| 13| System       | পেমেন্ট সাকসেসফুল হলে অটোমেটিক অর্ডার তৈরি হবে (Pending → Seller accept করলে Active) | ম্যানুয়াল কাজ কমে                          | Must     |

## 3. Detailed Flow (Step-by-Step Wizard)

### Step 0: Entry Point
- Message thread-এর ভিতরে “Send Custom Offer” বাটন (চ্যাট হেডারে বা মেসেজ ইনপুটের পাশে)

### Step 1: Offer Type
- Radio buttons:  
  – Class Booking  
  – Freelance Booking

### Step 2: Payment Method
- Radio buttons:  
  – Single Payment  
  – Milestone Payment

### Step 3: Service Mode
- Radio buttons:  
  – Online (Zoom/Google Meet)  
  – In-person

### Step 4: Add Milestones / Classes
- Single Payment → শুধু ১টা কার্ড
- Milestone Payment → “+ Add Milestone” বাটন (যত খুশি যোগ করা যাবে, রিমুভ বাটন থাকবে)

প্রতিটি মিলেস্টোন/ক্লাসের ফিল্ডস:

| Field               | Required?                  | Notes                                      |
|---------------------|----------------------------|--------------------------------------------|
| Title               | Yes                        |                                            |
| Description         | Yes                        | Rich text (optional)                       |
| Date                | Yes (In-person) / Optional (Online single class) | Date picker                          |
| Start Time          | Yes (In-person & Live class) | Time picker                              |
| End Time            | Yes (In-person & Live class) | Time picker                              |
| Price               | Yes                        | Currency auto-detect                       |
| Number of Revisions | Only Freelance             | Default 0                                  |
| Delivery Days       | Only Freelance Single     |                                            |

### Step 5: Summary / Preview
- সব মিলেস্টোন/ক্লাস লিস্ট আকারে দেখাবে
- Total Amount হাইলাইট করে দেখাবে
- Edit বাটন প্রতিটি মিলেস্টোনের পাশে
- Send Offer বাটন

### Step 6: Buyer Side
- মেসেজে কার্ড আকারে অফার আসবে
- View Details → মডালে পুরো অফার দেখাবে
- Accept → Stripe checkout
- Reject → অপশনাল মেসেজ দিয়ে রিজেক্ট

## 4. UI/UX Requirements
- Multi-step wizard (Back / Next buttons)
- Mobile responsive
- Real-time total price calculation
- Loading states
- Validation (required fields, date/time logic)
- Preview page must look beautiful (like Fiverr custom offer preview)

## 5. Technical Requirements
- Backend API endpoints:  
  – POST /custom-offers (create draft)  
  – POST /custom-offers/{id}/send  
  – GET /custom-offers/{id} (for buyer view)  
  – POST /custom-offers/{id}/accept  
  – POST /custom-offers/{id}/reject
- Store in DB table: custom_offers + custom_offer_milestones
- Real-time notification (WebSocket / Pusher) when offer sent
- Integrate with existing Order system (on accept → create Order with milestones)

## 6. Edge Cases
- Seller edits offer after sending → not allowed (must cancel & create new)
- Buyer already has active order with same seller → still allow
- Timezone handling for dates/times
- Currency conversion if needed

## 7. Dependencies
- Stripe Checkout already working
- Message system real-time
- Zoom integration (for online classes) – later phase

## 8. Success Metrics
- 90% of custom offers accepted within 48 hours
- Zero bugs in milestone creation
