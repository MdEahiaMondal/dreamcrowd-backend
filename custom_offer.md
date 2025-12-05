### ক্লায়েন্ট (Dreamcrowd) পুরো মিটিংয়ে **Custom Offer** নিয়ে যা যা বলেছে – একদম ফুল ডিটেইলস (ট্রান্সক্রিপ্ট থেকে সরাসরি এক্সট্রাক্ট)

#### ১. কাস্টম অফার কোথা থেকে শুরু হয়?
- বায়ার যখন কোনো সেলারকে মেসেজ করে (ইনবক্সে), তখন সেলারের কাছে **“Send Custom Offer”** বাটন থাকবে।
- এটাই কাস্টম অফারের এন্ট্রি পয়েন্ট।

#### ২. কাস্টম অফারে দুই ধরনের সার্ভিস থাকবে
ক্লায়েন্ট দুইবার খুব ক্লিয়ার করে বলেছে (01:17:22 – 01:37:57):

| টাইপ | কী থাকবে |
|------|----------|
| **ক্লাস বুকিং** | সেলার তার এক্সিস্টিং ক্লাস সিলেক্ট করবে → সিঙ্গেল পেমেন্ট বা মাইলস্টোন পেমেন্ট → ডেট + টাইম সেট করবে |
| **ফ্রিল্যান্স সার্ভিস** | সার্ভিস ডেসক্রিপশন, রিভিশন সংখ্যা, ডেলিভারি টাইম, প্রাইস → সিঙ্গেল বা মাইলস্টোন |

#### ৩. পেমেন্ট অপশন (খুব গুরুত্বপূর্ণ – ক্লায়েন্ট বারবার বলেছে)
- **সিঙ্গেল পেমেন্ট** → একবারে পুরো টাকা দিয়ে দেবে
- **মাইলস্টোন পেমেন্ট** → মাল্টিপল মাইলস্টোন → প্রতিটা মাইলস্টোনে আলাদা ডেসক্রিপশন, ডেট, প্রাইস

ক্লায়েন্ট বলেছে:  
> “For single payment one class, milestone payment multiple classes.”

#### ৪. অনলাইন vs ইন-পার্সন কাস্টম অফার (01:35:18 – 01:37:57)
- **অনলাইন সার্ভিস** → সব ফিচার আছে (যা উপরে বলা)
- **ইন-পার্সন সার্ভিস** → এখনো ডিজাইন হয়নি। প্রতিটা মাইলস্টোন বা সিঙ্গেল পেমেন্টে **Start Date, Start Time, End Time** ফিল্ড যোগ করতে হবে (ক্লাসের মতো)।

#### ৫. কাস্টম অফার পাঠানোর পর কী হবে?
1. সেলার অফার সেন্ড করবে  
2. বায়ারের ইনবক্সে মেসেজ আকারে আসবে  
3. বায়ারের ৩টা অপশন:
   - **Accept** → পেমেন্ট পেজে যাবে → পে করলে অর্ডার ক্রিয়েট
   - **Reject** → অফার রিজেক্ট
   - **Counter offer / Message** → দামাদামি চলতে পারে

#### ৬. সাবস্ক্রিপশন কাস্টম অফারে থাকবে না (খুব গুরুত্বপূর্ণ!)
ক্লায়েন্ট স্পষ্ট বলেছে (01:17:22 এর কাছাকাছি):
> “Subscription custom offer is too complex – we are removing it.”  
→ অর্থাৎ কাস্টম অফারে কোনো মাসিক/রিকারিং সাবস্ক্রিপশন অপশন থাকবে না। শুধু সিঙ্গেল + মাইলস্টোন।

#### ৭. Back / Next ন্যাভিগেশন
ক্লায়েন্ট বলেছে কাস্টম অফার ফ্লোতে **Back** এবং **Next** বাটন থাকতে হবে (মাল্টি-স্টেপ ফর্মের মতো)।

#### ৮. সারাংশে ক্লায়েন্ট চায় কী (তার সরাসরি কথায়)
- “Custom offer for classes and freelance both”  
- “Single payment or milestone payment”  
- “For class booking → select active class → set date/time”  
- “For freelance → revisions, delivery time, price”  
- “In-person → need start date, start time, end time for each milestone”  
- “No subscription in custom offer”  
- “Buyer gets message → approve/reject”  
- “Payment held until job completion (for freelance)”

#### ফাইনাল ফ্লো (ক্লায়েন্টের কথা অনুযায়ী
```
Seller → Message thread → Click “Custom Offer”
→ Choose Class or Freelance
→ Single or Milestone
→ Fill details (date/time/revision/price etc.)
→ Send Offer
→ Buyer gets message → Accept / Reject / Counter
→ Accept → Payment → Order Created
```


### কাস্টম অফার তৈরির সময় সেলারের জন্য **এক্স্যাক্ট ফ্লো** (ক্লায়েন্টের কথা অনুযায়ী)

```
Step 1 → Service Type সিলেক্ট করো  
   ├── Class Booking  
   └── Freelance Service  

Step 2 → Delivery Mode সিলেক্ট করো  
   ├── Online  
   └── In-Person  

Step 3 → তোমার সেই টাইপ + মোডের সব সার্ভিস/ক্লাস লোড হয়ে আসবে  
     (যেমন: যদি “Class Booking + Online” সিলেক্ট করে → সব অনলাইন ক্লাস লিস্ট আসবে)  

Step 4 → সিলেক্ট করা সার্ভিস থেকে কাস্টম অফার বানাবে  
     (সিঙ্গেল বা মাইলস্টোন পেমেন্ট)
```

### ক্লায়েন্টের সরাসরি কথা (ট্রান্সক্রিপ্ট থেকে)

> “when creating a custom offer, the seller can select either ‘class booking’ or ‘freelance booking’ … then it will ask online or in-person … then it will show the active classes or services accordingly.”  
> (01:21:18 এর কাছাকাছি)

আবার পরে আরেকবার বলেছে (01:35:18):
> “all described functionalities primarily apply to online services … for in-person services, particularly for freelance, will require additional fields for start date, start time, and end time … similar to how it's implemented for classes.”

### তাই ফাইনাল স্টেপ-বাই-স্টেপ UI/UX ফ্লো হবে এরকম:

| স্টেপ | স্ক্রিনে কী দেখাবে | কী করবে |
|------|-------------------|--------|
| 1    | Service Type      | [ ] Class Booking [ ] Freelance Service |
| 2    | Delivery Mode     | [ ] Online [ ] In-Person |
| 3    | Service List      | শুধু সিলেক্ট করা টাইপ + মোডের সার্ভিসগুলো লোড হবে (অ্যাকটিভ অবস্থায়) |
| 4    | Payment Type      | [ ] Single Payment [ ] Milestone Payment |
| 5    | Fill Details      | অনলাইন হলে → রিভিশন, ডেলিভারি টাইম <br>ইন-পার্সন হলে → Start Date, Start Time, End Time (প্রতি মাইলস্টোনে) |
| 6    | Send Offer        | বায়ারের ইনবক্সে যাবে |

### ইমপ্লিমেন্টেশন নোট
- Step 1 ও Step 2 চেঞ্জ হলে Step 3-এর লিস্টটা ডাইনামিক্যালি লোড হতে হবে (AJAX/Vue reactivity)  
- ইন-পার্সন ফ্রিল্যান্স সার্ভিসে প্রতি মাইলস্টোনে ডেট-টাইম ফিল্ড বাধ্যতামূলক  
- কোনো সাবস্ক্রিপশন অপশন থাকবে না (ক্লায়েন্ট স্পষ্টভাবে রিমুভ করেছে)


ei page a same kaj kora ace 
/home/eahiya/nexa-lance/dreamcrowd-backend/resources/views/Public-site/services.blade.php 
ei section tai "All Services (Online & Inperson)"