

##  **Product Requirements Document (PRD)**

### **Feature: Zoom Integration, Settings Management & Secure Live Class System**

**Product:** DreamCrowd Web Application

---

### **1️⃣ Purpose**

DreamCrowd প্ল্যাটফর্মে Zoom ইন্টেগ্রেশন যুক্ত করা হবে, যাতে শিক্ষক (Seller) ও ছাত্র (Buyer) নিরাপদভাবে লাইভ ক্লাস নিতে ও যোগ দিতে পারে।  
 এই ইন্টেগ্রেশনটি শুধুমাত্র Zoom meeting তৈরি নয় — বরং একটি end-to-end secure ecosystem তৈরি করবে যেখানে:

* **Admin** Zoom credentials configure করবে।

* **Seller** নিজের Zoom অ্যাকাউন্ট OAuth এর মাধ্যমে সংযুক্ত করবে।

* **Buyer/Guest** সিকিউর লিঙ্কের মাধ্যমে ক্লাসে যোগ দেবে।

* **System** real-time participant tracking এবং attendance log রাখবে।

* **Unauthorized Access** পুরোপুরি বন্ধ থাকবে।

---

### **2️⃣ Feature Overview**

| Field | Details |
| ----- | ----- |
| **Feature Name** | Zoom Integration & Secure Live Class System |
| **Modules Impacted** | Admin Panel, Seller Panel, Buyer Panel, Notification System |
| **Goal** | Centralized Zoom setup, secure class creation, controlled access, real-time monitoring |
| **User Roles** | Admin, Seller, Buyer, Guest |
| **Key Components** | Zoom OAuth, Central Credentials, Auto Meeting Creation, Secure Join Flow, Webhooks |

---

### **3️⃣ User Journey (Simplified Flow)**

#### **👨‍💼 Admin**

1. Admin Panel → **Zoom Settings** সেকশন থেকে Zoom App Credentials যোগ/আপডেট করতে পারবে:

   * Client ID

   * Client Secret

   * Redirect URL

   * Base URL / Account ID

2. এই credentials সব seller OAuth প্রক্রিয়ায় ব্যবহার হবে (centralized)।

3. “Live Classes” ট্যাব-এ চলমান ক্লাস ও পার্টিসিপেন্ট দেখা যাবে।

#### **👩‍🏫 Seller (Teacher)**

1. Seller Panel → **Zoom Menu** থেকে OAuth এর মাধ্যমে নিজের Zoom অ্যাকাউন্ট কানেক্ট করবে।

2. OAuth সফল হলে “Connected as \[Zoom Email\]” দেখাবে।

3. Seller ক্লাস শুরু করলে system auto Zoom meeting তৈরি করবে।

4. Dashboard-এ “Launch Zoom Meeting” বাটন দেখাবে।

#### **👨‍🎓 Buyer / Student**

1. Buyer ক্লাস বুক করলে system Zoom meeting assign করবে।

Email-এ raw Zoom link না পাঠিয়ে redirect link পাঠানো হবে:

 https://dreamcrowd.com/join/class/{class\_id}?token={secure\_token}

2.   
3. User click করলে backend verify করবে authorization → Zoom registrant API call করে unique join URL তৈরি করবে।

#### **👥 Guest Users**

* Guest invite হলে email-এ secure redirect link পাবে।

* Guest login ছাড়াই temporary token দিয়ে join করতে পারবে।

* তাদের উপস্থিতি admin dashboard-এ log হবে।

---

### **4️⃣ Functional Requirements**

| ID | Requirement | Description |
| ----- | ----- | ----- |
| FR-1 | Admin Zoom Settings Panel | Admin Panel-এ Zoom credentials add/update করার ব্যবস্থা। |
| FR-2 | Centralized Credentials | System সবসময় admin credentials ব্যবহার করবে। |
| FR-3 | Seller OAuth | Seller Panel থেকে OAuth connect/disconnect ও status দেখাবে। |
| FR-4 | Token Management | Access/refresh token store \+ auto-refresh cron। |
| FR-5 | Auto Meeting Creation | Seller “Start Class” দিলে Zoom API দিয়ে meeting তৈরি হবে। |
| FR-6 | Meeting Metadata | meeting\_id, join\_url, start\_url, duration DB-তে save হবে। |
| FR-7 | Redirect-based Join | Email-এ Zoom redirect link পাঠানো হবে, raw URL নয়। |
| FR-8 | Secure Join Validation | Redirect endpoint JWT/token verify করবে → registrant API call। |
| FR-9 | Participant Tracking | Webhook `/meeting.participant_joined` ও `/left` handle করবে। |
| FR-10 | Admin Live View | Admin Panel-এ real-time class ও participant data দেখাবে। |
| FR-11 | Role Tracking | Seller, Buyer, Guest অনুযায়ী role DB-তে log হবে। |
| FR-12 | Unauthorized Access Prevention | Token ছাড়া কেউ join করতে পারবে না। |
| FR-13 | Email Reminder | Valo kore mone rakbe Class start-এর 30 minute আগে reminder email যাবে userder kace nad guest user kace also real time notification pabe। |
| FR-14 | Audit Logs | All join/leave logs admin audit panel-এ দেখা যাবে। |
| FR-15 | Token Encryption | Tokens encrypted (AES-256) আকারে সংরক্ষণ। |

---

### **5️⃣ Admin Panel Features**

| Section | Description |
| ----- | ----- |
| **Menu Name** | Zoom Settings |
| **Fields** | Client ID, Client Secret, Redirect URL, Account ID, Base URL |
| **Actions** | Save / Update / Test Connection |
| **Permission** | Only Super Admin editable |
| **Validation** | Required fields, valid URLs, encryption on save |
| **Audit Logs** | Update history with admin ID & timestamp |
| **Extra Tab** | “Live Classes” → running meetings \+ participants view |

---

### **6️⃣ Seller Panel Features**

| Section | Description |
| ----- | ----- |
| **Menu Name** | Zoom |
| **Actions** | Connect Zoom (OAuth), Disconnect, Refresh Token |
| **Fields** | Connection status, Connected Zoom Email, Token expiry |
| **Integration** | “Start Class” → backend meeting creation trigger |
| **Security** | Seller শুধুমাত্র নিজের meeting দেখতে পারবে |
| **UI Alerts** | Success, reconnect warning, meeting list |

---

### **7️⃣ Buyer & Guest Join Flow (Secure)**

Email Template:

\<a href="https://dreamcrowd.com/join/class/{class\_id}?token={secure\_token}"\>  
  Join Live Class  
\</a\>

**Join Flow:**

1. `/join/class/:id` route → verify JWT/token → authorized user only।

2. Backend calls:

POST /meetings/{meetingId}/registrants  
{ "email": user\_email, "first\_name": user\_first\_name, "last\_name": user\_last\_name }

3. Receives `join_url` → redirect to Zoom meeting।

4. Unauthorized user → error: “Unauthorized access.”

✅ **Zoom link never exposed publicly.**

---

### **8️⃣ Participant Tracking (Webhooks)**

| Event | Description |
| ----- | ----- |
| meeting.participant\_joined | Log user\_email, join\_time, role |
| meeting.participant\_left | Update leave\_time |
| Storage | Table: zoom\_participants |
| Real-time Updates | WebSocket → Admin & Seller dashboards |

---

### **9️⃣ Real-Time Admin Monitoring**

| Field | Description |
| ----- | ----- |
| **Menu** | Admin Panel → Live Classes |
| **Data** | Class title, Seller, Start time, Participants, join/leave status |
| **Update Mode** | WebSocket or 10-sec polling |
| **Control** | View Details, End Class (future feature) |
| **Logs** | Full timeline history |

---

### **🔟 Security & Access Rules**

1. Zoom credentials editable only by Admin.

2. All tokens encrypted (AES-256).

3. Only authorized users (buyer/guest/teacher) can join.

4. Join links are single-use via registrant API.

5. No raw Zoom link in email or dashboard.

6. Unauthorized join attempts logged.

7. Admin can revoke Seller OAuth access.

---

### **11️⃣ Technical Implementation Summary**

| Area | Key Components |
| ----- | ----- |
| **Admin Panel** | CRUD for Zoom settings table |
| **Seller Panel** | OAuth connect/disconnect |
| **Buyer Join** | Secure redirect & registrant join API |
| **Meeting Creation** | Seller start → Zoom API call |
| **Webhooks** | `/api/zoom/webhook` handle join/leave |
| **Database** | zoom\_settings, zoom\_tokens, meetings, zoom\_participants |
| **Emails** | Redirect link only |
| **Cron Jobs** | Token refresh, meeting cleanup |

---

### **12️⃣ Acceptance Criteria (QA Checklist)**

| \# | Scenario | Expected Result |
| ----- | ----- | ----- |
| 1 | Admin adds credentials | Saved securely, encrypted |
| 2 | Seller connects OAuth | Token stored successfully |
| 3 | Seller starts class | Zoom meeting auto-created |
| 4 | Buyer receives email | Redirect link only |
| 5 | Buyer joins class | Verified → unique Zoom join |
| 6 | Guest invited | Temporary token allows join |
| 7 | Unauthorized join | Blocked |
| 8 | Participant joins | Real-time dashboard update |
| 9 | Admin view | Shows live meetings & users |
| 10 | Token expired | Auto-refresh works |

---

### **13️⃣ Dependencies**

* Zoom API (OAuth, Meetings, Registrants, Webhooks)

* Stripe (for paid classes)

* Email / Notification Service

* Background Jobs (Bull / Celery)

* WebSocket Service

---

### **14️⃣ Risks & Mitigation**

| Risk | Mitigation |
| ----- | ----- |
| Credentials leak | Store encrypted \+ admin-only access |
| Unauthorized join | Token validation \+ registrant API |
| Token expiry | Cron-based refresh |
| Webhook delay | Retry mechanism |
| Link sharing | Redirect join only (no raw link) |

---

### **15️⃣ Success Metrics**

| Metric | Target |
| ----- | ----- |
| Meeting creation success | ≥ 99% |
| Unauthorized joins | 0% |
| Tracking accuracy | ≥ 98% |
| Admin dashboard delay | ≤ 5s |
| Email redirect success | 100% |

---

✅ **Final Outcome:**

* **Admin:** Manages credentials, live class tracking, audit logs।

* **Seller:** Starts secure Zoom classes easily।

* **Buyer/Guest:** Joins via safe redirect links।

* **System:** Logs all activity, prevents link sharing & Zoom bombing।

* **Security:** End-to-end encryption \+ access validation ensures full protection।

---

(Admin role \== 2  
Teacher role \== 1  
User role \== 0\) but tumi full system ta read kore dekho