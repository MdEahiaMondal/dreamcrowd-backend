<?php

namespace App\Http\Controllers;

use App\Models\BookingDuration;
use App\Models\BookOrder;
use App\Models\ClassDate;
use App\Models\ExpertProfile;
use App\Models\ServicesFaqs;
use App\Models\TeacherGig;
use App\Models\TeacherGigData;
use App\Models\TeacherGigPayment;
use App\Models\TeacherReapetDays;
use App\Models\TopSellerTag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;

class BookingController extends Controller
{
    // Quick Booking Service Page =========


    public function QuickBooking($id)
    {
        $gig = TeacherGig::find($id);


        if (!$gig || $gig->status != 1) {
            return redirect('/')->with(['error' => 'Service not found!']);
        }

        $profile = ExpertProfile::where(['user_id' => $gig->user_id, 'status' => 1])->first();
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();
        $gigPayment = TeacherGigPayment::where(['gig_id' => $gig->id])->first();
        $gigFaqs = ServicesFaqs::where(['gig_id' => $gig->id])->get();
        $repeatDays = TeacherReapetDays::where(['gig_id' => $gig->id])->get();
        $allOrders = BookOrder::where('gig_id', $gig->id)->get();
        $admin_duration = BookingDuration::first();


        $category = $gig->category;

        // Increment gig clicks
        $gig->increment('impressions');
        $gig->increment('clicks');

        // Manage recently viewed gigs in cookies
        $recentlyViewedGigs = json_decode(request()->cookie('recently_viewed_gigs', '[]'), true);
        $recentlyViewedGigs = array_filter($recentlyViewedGigs, fn($item) => $item !== $id);
        array_unshift($recentlyViewedGigs, $id);
        Cookie::queue('recently_viewed_gigs', json_encode(array_slice($recentlyViewedGigs, 0, 10)), 60 * 24 * 30);
        Cookie::queue('recently_viewed_category', json_encode($category), 60 * 24 * 30);

        if ($gig->service_role == 'Class') {


            // Get booked orders & class dates in one step
            $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();
            $bookedTime = ClassDate::whereIn('order_id', $OrderIds)->pluck('teacher_date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('Y-m-d H:i'))->toArray();


            $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();
            // Fetch booked slots with total people count
            $bookedSlots = ClassDate::join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                ->where('book_orders.gig_id', $gig->id)
                ->get(['class_dates.teacher_date', 'class_dates.duration', 'book_orders.group_type', 'book_orders.total_people'])
                ->groupBy('teacher_date')
                ->map(function ($slots) {
                    return [
                        'teacher_date' => $slots->first()->teacher_date,
                        'duration' => $slots->first()->duration ?? '00:30',
                        'group_type' => $slots->first()->group_type,
                        'total_people' => $slots->sum('total_people'),
                    ];
                });


// Filter out fully reserved slots
            $availableSlots = [];
            foreach ($bookedSlots as $slot) {
                if ($gigData->lesson_type === 'One' || $gigData->group_type === 'Private') {
                    // Private or One-on-One lessons: Fully booked if any booking exists
                    continue;
                }
                if ($gigData->group_type === 'Both' || $gigData->group_type === 'Public') {
                    // Public group: Remove slot if total booked people reached the max group size
                    if ($slot['group_type'] === 'Public' && $slot['total_people'] >= $gigPayment->public_group_size) {
                        continue;
                    }
                }
                $availableSlots[] = $slot;
            }

// Convert available slots to JSON for frontend
            $bookedTimes = json_encode($availableSlots, JSON_UNESCAPED_SLASHES);


            // Pass gig availability details to the view
            return view("Seller-listing.quick-booking", compact('gig', 'profile', 'gigData', 'gigPayment', 'gigFaqs', 'repeatDays', 'bookedTime', 'allOrders', 'bookedTimes', 'admin_duration'));
        } else {


            // FREELANCE SERVICE
            $bookedTime = [];

            if ($gigData->freelance_service === 'Consultation') {
                // Get actual booked slots for Consultation to block on frontend
                $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id')->toArray();

                $bookedSlots = ClassDate::join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                    ->where('book_orders.gig_id', $gig->id)
                    ->get(['class_dates.teacher_date', 'class_dates.duration', 'book_orders.group_type', 'book_orders.total_people'])
                    ->groupBy('teacher_date')
                    ->map(function ($slots) {
                        return [
                            'teacher_date' => $slots->first()->teacher_date,
                            'duration' => $slots->first()->duration ?? '00:30',
                            'group_type' => $slots->first()->group_type,
                            'total_people' => $slots->sum('total_people'),
                        ];
                    });

                $bookedTimes = json_encode($bookedSlots, JSON_UNESCAPED_SLASHES);

            } else {
                // NORMAL FREELANCE SERVICE → show all slots, no blocking
                $bookedTimes = json_encode([], JSON_UNESCAPED_SLASHES);
            }


            // Pass gig availability details to the view
            return view("Seller-listing.freelance-booking", compact('gig', 'profile', 'gigData', 'gigPayment', 'gigFaqs', 'repeatDays', 'bookedTime', 'allOrders', 'bookedTimes', 'admin_duration'));
        }


    }


    // Get Available Times ===========

    public function GetAvailableTimes(Request $request)
    {
        $gig = TeacherGig::find($request->gig_id);
        if (!$gig) {
            return response()->json(['error' => 'Gig not found'], 404);
        }

        $gigData = TeacherGigData::where('gig_id', $gig->id)->first();
        $gigPayment = TeacherGigPayment::where('gig_id', $gig->id)->first();
        $teacherId = $gig->user_id;
        $selectedDateTime = Carbon::parse($request->date_time);
        $selectedDate = $selectedDateTime->toDateString();
        $selectedTime = $selectedDateTime->format('H:i');
        $duration = (int)$gigPayment->duration;

        /*** Step 1: Check Date and Time Availability ***/
        if ($gigPayment->start_date != null) {
            $gigStartDate = Carbon::parse($gigPayment->start_date);
            $gigEndDate = Carbon::parse($gigPayment->start_date);
            $gigStartTime = Carbon::parse($gigPayment->start_time);
            $gigEndTime = Carbon::parse($gigPayment->end_time);

            // if ($selectedDate <= $gigStartDate->toDateString() || $selectedDate >= $gigEndDate->toDateString()) {
            //     return response()->json(['error' => 'Selected date is outside the allowed range']);
            // }

            if ($selectedTime < $gigStartTime->format('H:i') || $selectedTime > $gigEndTime->format('H:i')) {
                return response()->json(['error' => 'Selected time is outside the available range']);
            }
        } else {
            $selectedDay = $selectedDateTime->format('l');
            $repeatDays = TeacherReapetDays::where(['gig_id' => $gig->id, 'day' => $selectedDay])->first();
            if (!$repeatDays) {
                return response()->json(['error' => 'Invalid Selection']);
            }

            $startTime = Carbon::parse($repeatDays->start_time);
            $endTime = Carbon::parse($repeatDays->end_time);
            $selectedTime = Carbon::parse($selectedTime);

            if ($selectedTime->lt($startTime) || $selectedTime->gt($endTime)) {
                return response()->json(['error' => 'Selected time is outside the allowed range']);
            }
        }

        /*** Step 2: Check if Selected Time is Already Booked ***/
        $OrderIds = BookOrder::where('teacher_id', $teacherId)->pluck('id')->toArray();
        $bookedTimes = ClassDate::whereIn('order_id', $OrderIds)->pluck('teacher_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d H:i'))
            ->toArray();

        $selectedStartTime = Carbon::parse($selectedDateTime);
        $selectedEndTime = $selectedStartTime->copy()->addHours($duration);


        /*** Step 3: Check Group Size Availability ***/
        if ($gig->lesson_type == 'Group') {
            $bookedOrders = BookOrder::where('gig_id', $gig->id)->pluck('id')->toArray();


            // Get the total number of guests already booked for this date & time
            $bookedGroup = ClassDate::whereIn('class_dates.order_id', $bookedOrders)
                ->whereRaw("DATE_FORMAT(class_dates.teacher_date, '%Y-%m-%d %H:%i') = ?", [$selectedDateTime->format('Y-m-d H:i')])
                ->join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                ->select('book_orders.group_type', 'book_orders.total_people')
                ->first();

// If the booked session is Private, remove slot from UI
            if ($bookedGroup && $bookedGroup->group_type == 'Private') {
                return response()->json(['group_full' => 'This time slot is reserved due to a Private group booking']);
            }


            // Get the total number of guests already booked for this date & time
            $totalBookedGuests = ClassDate::whereIn('class_dates.order_id', $bookedOrders)
                ->whereRaw("DATE_FORMAT(class_dates.teacher_date, '%Y-%m-%d %H:%i') = ?", [$selectedDateTime->format('Y-m-d H:i')])
                ->join('book_orders', 'class_dates.order_id', '=', 'book_orders.id')
                ->sum('book_orders.total_people'); // Sum up the guests count

            // Private session check: If any guest is booked, reject new bookings
            if ($request->group_type == 'Private' && $totalBookedGuests > 0) {
                return response()->json(['group_full' => 'Private group session is already booked']);
            }

            // Public session check: If total guests exceed allowed limit, show available slots
            if ($request->group_type == 'Public') {
                $remainingSlots = $gigPayment->public_group_size - $totalBookedGuests;

                if ($remainingSlots <= 0) {
                    return response()->json(['group_full' => 'Public group session is full']);
                } else {

                    return response()->json([
                        'success' => "Selected time allows a maximum of $remainingSlots guests",
                        'allowed_guests' => $remainingSlots
                    ]);


                }
            }
        }


        foreach ($bookedTimes as $bookedTime) {
            $bookedStartTime = Carbon::parse($bookedTime);
            $bookedEndTime = $bookedStartTime->copy()->addHours($duration);

            if ($selectedStartTime->between($bookedStartTime, $bookedEndTime) ||
                $selectedEndTime->between($bookedStartTime, $bookedEndTime)) {
                return response()->json(['booked' => 'Selected time is already booked', 'bookedTime' => $request->date_time]);
            }
        }

        return response()->json(['success' => 'Selected time is available']);
    }


    // Service Book Function ===========

    public function ServiceBook(Request $request)
    {

        if (!$request->gig_id) {
            return redirect('/')->with('error', 'Something rong');
        }


        if (!Auth::user() && Auth::user()->role != 0) {
            return redirect('/')->with('error', 'Something rong');
        }


        $gig = TeacherGig::find($request->gig_id);
        $buyer_commission = TopSellerTag::first()->buyer_commission_rate;
        $buyer_commission = $buyer_commission == null ? 0 : $buyer_commission;

        $profile = ExpertProfile::where(['user_id' => $gig->user_id, 'status' => 1])->first();
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();
        $gigPayment = TeacherGigPayment::where(['gig_id' => $request->id])->first();
        $repeatDays = TeacherReapetDays::where(['gig_id' => $request->id])->get();
        $bookedOrders = BookOrder::where(['gig_id' => $gig->id])->get();
        $OrderIds = BookOrder::where('teacher_id', $gig->user_id)->pluck('id'); // Get order IDs
        $bookedTime = ClassDate::whereIn('order_id', $OrderIds)->get(); // Get all booked dates
        $formData = $request->all();
        $formData['buyer_commission'] = $buyer_commission;
        $formData['extra_guests'] = $request->extra_guests == null ? 0 : $request->extra_guests;
        $formData['freelance_type'] = $request->freelance_type != null ? $request->freelance_type : null;
        $commission_amount = ($request->price * $buyer_commission) / 100;
        $finel_price = $request->price + $commission_amount;

        // Optional: round to 2 decimal places
        $finel_price = round($finel_price, 2);

        $formData['finel_price'] = $finel_price;
        if (!$request->group_type) {
            $formData['group_type'] = '1-to-1';
        } else {
            $formData['group_type'] = $request->group_type . ' Group';
        }

        return view('Public-site.payment', compact('gig', 'profile', 'gigData', 'gigPayment', 'repeatDays', 'formData', 'bookedOrders', 'bookedTime'));
    }


    // Payment Booking Of Class Function Start ----------
    public function ServicePayment(Request $request)
    {
        // Decode form_data if it's a JSON string
        $formData = json_decode($request->form_data, true);

        if (empty($formData['gig_id']) || !Auth::check() || Auth::user()->role != 0) {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }

        // Set Stripe API secret key
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));


        try {

            // Ensure `finel_price` is numeric
            $finalPrice = floatval($request->finel_price);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => round($finalPrice * 100), // Convert dollars to cents properly
                'currency' => 'usd',
                'capture_method' => 'manual',
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never', // Prevent redirect-based payment methods
                ],
            ]);


            if ($paymentIntent) {

                $gig = TeacherGig::find($formData['gig_id']);
                $gigData = TeacherGigData::where(['gig_id' => $formData['gig_id']])->first();
                $gigPayment = TeacherGigPayment::where(['gig_id' => $formData['gig_id']])->first();
                if ($gig->service_role == 'Class') {


                    $group_type = $formData['group_type'] == '1-to-1' ? '1-to-1' : str_replace(' Group', '', $formData['group_type']);
                    $formData['email'] = isset($formData['email']) && $formData['email'] != '' ? $formData['email'] : Auth::user()->email;
                    $formData['guests'] = isset($formData['guests']) && $formData['guests'] != '' ? $formData['guests'] : 1;
                    $formData['childs'] = isset($formData['childs']) && $formData['childs'] != '' ? $formData['childs'] : 0;
                    $formData['frequency'] = isset($formData['frequency']) && $formData['frequency'] != '' ? $formData['frequency'] : 1;


                    $bookOrder = new BookOrder();
                    $bookOrder->user_id = Auth::user()->id;
                    $bookOrder->gig_id = $formData['gig_id'];
                    $bookOrder->teacher_id = $gig->user_id;
                    $bookOrder->payment_type = $gig->payment_type;
                    $bookOrder->title = $gig->title;
                    $bookOrder->frequency = $formData['frequency'];
                    $bookOrder->group_type = $group_type;
                    $bookOrder->emails = $formData['email'];
                    if ($group_type == 'Private') {
                        $bookOrder->extra_guests = 'Yes';
                    } else {
                        $bookOrder->extra_guests = $formData['extra_guests'];
                    }

                    $bookOrder->guests = $formData['guests'];
                    $bookOrder->childs = $formData['childs'];
                    $bookOrder->total_people = $formData['total_people'];
                    if ($gig->service_type == 'Inperson') {
                        $bookOrder->service_delivery = $formData['service_delivery'];
                        $bookOrder->work_site = $formData['work_site'];
                    }
                    $bookOrder->price = $formData['price'];
                    $bookOrder->buyer_commission = $formData['buyer_commission'];
                    $bookOrder->coupen = $request->coupen;
                    $bookOrder->discount = $request->discount;
                    $bookOrder->finel_price = $request->finel_price;
                    $bookOrder->payment_id = $paymentIntent->id;
                    $bookOrder->holder_name = $request->holder_name;
                    $bookOrder->card_number = $request->card_number;
                    $bookOrder->cvv = $request->cvv;
                    $bookOrder->date = $request->date;

                    $bookOrder->save();

                    $user_date_time = explode(',', $formData['class_time']);
                    $teacher_date_time = explode(',', $formData['teacher_class_time']);

                    // Step 1: Pair each user and teacher date
                    $datePairs = [];

                    foreach ($user_date_time as $key => $value) {
                        if (!empty($value) && isset($teacher_date_time[$key])) {
                            $datePairs[] = [
                                'user_date' => $value,
                                'teacher_date' => $teacher_date_time[$key],
                            ];
                        }
                    }

                    // Step 2: Sort the pairs by nearest teacher_date (ascending)
                    usort($datePairs, function ($a, $b) {
                        return strtotime($a['teacher_date']) <=> strtotime($b['teacher_date']);
                    });

                    // Step 3: Insert sorted class dates
                    foreach ($datePairs as $pair) {
                        ClassDate::create([
                            'order_id' => $bookOrder->id,
                            'teacher_date' => $pair['teacher_date'],
                            'user_date' => $pair['user_date'],
                            'teacher_time_zone' => $formData['teacher_time_zone'],
                            'user_time_zone' => $formData['user_time_zone'],
                            'duration' => $gigPayment->duration,
                        ]);
                    }

                    // Then fill in the remaining frequency with 'Not Selected'
                    $totalSelected = count($datePairs);
                    $remaining = $formData['frequency'] - $totalSelected;

                    for ($i = 0; $i < $remaining; $i++) {
                        ClassDate::create([
                            'order_id' => $bookOrder->id,
                            'teacher_date' => null,
                            'user_date' => null,
                            'teacher_time_zone' => $formData['teacher_time_zone'],
                            'user_time_zone' => $formData['user_time_zone'],
                            'duration' => $gigPayment->duration,
                        ]);
                    }

                } else {

                    $formData['work_site'] = isset($formData['work_site']) && $formData['work_site'] != '' ? $formData['work_site'] : $gigData->work_site;

                    if ($gigPayment->duration == null) {
                        $duration = '00:00';
                    } else {
                        $duration = $gigPayment->duration;
                    }

                    $bookOrder = new BookOrder();
                    $bookOrder->user_id = Auth::user()->id;
                    $bookOrder->gig_id = $formData['gig_id'];
                    $bookOrder->teacher_id = $gig->user_id;
                    $bookOrder->title = $gig->title;
                    $bookOrder->price = $formData['price'];
                    $bookOrder->buyer_commission = $formData['buyer_commission'];
                    $bookOrder->freelance_service = $formData['freelance_service'];
                    $bookOrder->freelance_type = $formData['freelance_type'];
                    if ($gig->service_type == 'Inperson') {
                        $bookOrder->service_delivery = $formData['service_delivery'];
                        $bookOrder->work_site = $formData['work_site'];
                    }
                    $bookOrder->coupen = $request->coupen;
                    $bookOrder->discount = $request->discount;
                    $bookOrder->finel_price = $request->finel_price;
                    $bookOrder->payment_id = $paymentIntent->id;
                    $bookOrder->holder_name = $request->holder_name;
                    $bookOrder->card_number = $request->card_number;
                    $bookOrder->cvv = $request->cvv;
                    $bookOrder->date = $request->date;

                    $bookOrder->save();

                    $user_date_time = explode(',', $formData['class_time']);
                    $teacher_date_time = explode(',', $formData['teacher_class_time']);

                    foreach ($user_date_time as $key => $value) {
                        if ($value != null) {
                            ClassDate::create([
                                'order_id' => $bookOrder->id,
                                'teacher_date' => $teacher_date_time[$key],
                                'user_date' => $value,
                                'teacher_time_zone' => $formData['teacher_time_zone'],
                                'user_time_zone' => $formData['user_time_zone'],
                                'duration' => $duration,
                            ]);
                        }
                    }


                }

                return response()->json(['success' => 'Order Booked Successfully!']);

            } else {
                return response()->json(['error' => 'Payment Not Submmitted!'], 500);
            }


        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment failed', 'message' => $e->getMessage()], 500);
        }


    }

    // Payment Booking Of Class Function END ----------


}
