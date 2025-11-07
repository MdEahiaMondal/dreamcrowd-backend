<?php

namespace App\Http\Controllers;

use App\Models\BookOrder;
use App\Models\Category;
use App\Models\ExpertProfile;
use App\Models\ServiceReviews;
use Illuminate\Support\Facades\Auth;
use App\Models\Faqs;
use App\Models\HostGuidline;
use App\Models\Languages;
use App\Models\PannelFaqs;
use App\Models\TeacherCalender;
use App\Models\TeacherCategoryRequest;
use App\Models\TeacherFaqs;
use App\Models\TeacherLocationRequest;
use App\Models\TeacherProfileRequest;
use App\Models\TeacherRequest;
use App\Services\TeacherDashboardService;
use Carbon\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeacherController extends Controller
{

    public function TeachercheckAuth()
    {

        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 2) {
                return redirect()->to('/admin-dashboard');
            } elseif (Auth::user()->role == 0) {
                return redirect()->to('/user-dashboard');
            }
        }


    }


    public function TeacherDashboard()
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $teacher = Auth::user();

        // Get recent bookings (initial load)
        $recentBookings = BookOrder::where('teacher_id', $teacher->id)
            ->with(['gig', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        return view("Teacher-Dashboard.dashboard", compact('recentBookings'));
    }

    /**
     * Get dashboard statistics via AJAX
     */
    public function getDashboardStatistics(Request $request)
    {
        $teacher = Auth::user();
        $preset = $request->input('preset', 'all_time');
        $customFrom = $request->input('date_from');
        $customTo = $request->input('date_to');

        $service = new TeacherDashboardService();

        // Use custom dates if provided, otherwise use preset
        if ($customFrom && $customTo) {
            $dateFrom = $customFrom;
            $dateTo = $customTo;
        } else {
            $dates = $service->applyDatePreset($preset);
            $dateFrom = $dates['from'];
            $dateTo = $dates['to'];
        }

        // Get all statistics
        $statistics = $service->getAllStatistics(
            $teacher->id,
            $dateFrom,
            $dateTo
        );

        return response()->json($statistics);
    }

    /**
     * Get earnings trend chart data
     */
    public function getEarningsTrendChart(Request $request)
    {
        $teacher = Auth::user();
        $months = $request->input('months', 6);

        $service = new TeacherDashboardService();
        $chartData = $service->getMonthlyEarningsTrend($teacher->id, $months);

        return response()->json($chartData);
    }

    /**
     * Get order status breakdown chart data
     */
    public function getOrderStatusChart(Request $request)
    {
        $teacher = Auth::user();
        $preset = $request->input('preset', 'all_time');
        $customFrom = $request->input('date_from');
        $customTo = $request->input('date_to');

        $service = new TeacherDashboardService();

        // Use custom dates if provided, otherwise use preset
        if ($customFrom && $customTo) {
            $dateFrom = $customFrom;
            $dateTo = $customTo;
        } else {
            $dates = $service->applyDatePreset($preset);
            $dateFrom = $dates['from'];
            $dateTo = $dates['to'];
        }

        $chartData = $service->getOrderStatusBreakdown($teacher->id, $dateFrom, $dateTo);

        return response()->json($chartData);
    }


    public function TeacherFaqs()
    {


        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        $faqs = PannelFaqs::where(['type' => 'seller'])->get();

        return view("Teacher-Dashboard.faq", compact('faqs'));
    }


    // Teacher Profile Update Functions Start ==============

    public function TeacherProfile()
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $profile = ExpertProfile::where(['user_id' => Auth::user()->id])->first();
        $languages = Languages::all();
        $faqs = TeacherFaqs::where(['user_id' => Auth::user()->id])->get();

        return view("Teacher-Dashboard.manage-profile", compact('profile', 'languages', 'faqs'));
    }


    public function TeacherProfileUpdate(Request $request)
    {


        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        if ($request->overview == null || $request->about_me == null) {
            return redirect()->back()->with('error', 'Overview and About me is Required!');
        }

        $pending_req = TeacherRequest::where(['user_id' => Auth::user()->id, 'request_type' => $request->request_type, 'status' => 0])->first();

        if ($pending_req) {
            return redirect()->back()->with('error', 'Your Profile Update Request Already in Pending!');
        }

        $profile = new TeacherProfileRequest();

        if ($request->hasfile('profile_image')) {
            $profile_image = $request->profile_image;
            $profile_imageName = $profile_image->getClientOriginalName();
            $profile_imageData = $profile_imageName;
            $profile_image->move(public_path() . '/assets/profile/img', $profile_imageName);
            $profile->profile_image = $profile_imageData;
        }

        if ($request->hasfile('main_image')) {
            $main_image = $request->main_image;
            $main_imageName = $main_image->getClientOriginalName();
            $main_imageData = $main_imageName;
            $main_image->move(public_path() . '/assets/expert/asset/img', $main_imageName);
            $profile->main_image = $main_imageData;
        }


        if ($request->hasfile('image_1')) {
            $image_1 = $request->image_1;
            $image_1Name = $image_1->getClientOriginalName();
            $image_1Data = $image_1Name;
            $image_1->move(public_path() . '/assets/expert/asset/img', $image_1Name);
            $profile->more_image_1 = $image_1Data;
        }


        if ($request->hasfile('image_2')) {
            $image_2 = $request->image_2;
            $image_2Name = $image_2->getClientOriginalName();
            $image_2Data = $image_2Name;
            $image_2->move(public_path() . '/assets/expert/asset/img', $image_2Name);
            $profile->more_image_2 = $image_2Data;
        }

        if ($request->hasfile('image_3')) {
            $image_3 = $request->image_3;
            $image_3Name = $image_3->getClientOriginalName();
            $image_3Data = $image_3Name;
            $image_3->move(public_path() . '/assets/expert/asset/img', $image_3Name);
            $profile->more_image_3 = $image_3Data;
        }

        if ($request->hasfile('image_4')) {
            $image_4 = $request->image_4;
            $image_4Name = $image_4->getClientOriginalName();
            $image_4Data = $image_4Name;
            $image_4->move(public_path() . '/assets/expert/asset/img', $image_4Name);
            $profile->more_image_4 = $image_4Data;
        }

        if ($request->hasfile('image_5')) {
            $image_5 = $request->image_5;
            $image_5Name = $image_5->getClientOriginalName();
            $image_5Data = $image_5Name;
            $image_5->move(public_path() . '/assets/expert/asset/img', $image_5Name);
            $profile->more_image_5 = $image_5Data;
        }

        if ($request->hasfile('image_6')) {
            $image_6 = $request->image_6;
            $image_6Name = $image_6->getClientOriginalName();
            $image_6Data = $image_6Name;
            $image_6->move(public_path() . '/assets/expert/asset/img', $image_6Name);
            $profile->more_image_6 = $image_6Data;
        }

        if ($request->hasfile('video')) {
            $video = $request->video;
            $videoName = $video->getClientOriginalName();
            $videoData = $videoName;
            $video->move(public_path() . '/assets/expert/asset/img', $videoName);
            $profile->video = $videoData;
        }


        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->show_full_name = $request->show_full_name;
        $profile->gender = $request->gender;
        $profile->profession = $request->profession;
        $profile->primary_language = $request->primary_language;
        if ($request->primary_language == 'English') {
            $profile->fluent_english = 'No';
        } else {

            $profile->fluent_english = $request->fluent_english;
        }
        $profile->speak_other_language = $request->speak_other_language;
        if ($request->speak_other_language == 1) {
            $profile->other_language = $request->other_language;
        } else {
            $profile->other_language = null;
        }


        $profile->overview = $request->overview;
        $profile->about_me = $request->about_me;
        $profile->first_service = $request->first_service;
        $profile->save();

        if ($profile) {

            $new_req = TeacherRequest::create([
                'request_type' => $request->request_type,
                'user_id' => Auth::user()->id,
                'request_id' => $profile->id,
                'request_date' => date("M d, Y"),
            ]);

            return redirect()->back()->with('success', 'Profile Update Request Uploaded Successfuly!');

        } else {
            return redirect()->back()->with('error', 'Something Error Please Try again Later!');

        }


    }


    public function TeacherLocationUpdate(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        if ($request->reason == null) {
            return redirect()->back()->with('error', 'Please Add Reason For Location Update!');
        }
        if ($request->street_address == null) {
            return redirect()->back()->with('error', 'Please Select Your Live Location Again For Update!');
        }


        $pending_req = TeacherRequest::where(['user_id' => Auth::user()->id, 'request_type' => $request->request_type, 'status' => 0])->first();

        if ($pending_req) {
            return redirect()->back()->with('error', 'Your Location Update Request Already in Pending!');
        }

        $location = new TeacherLocationRequest();

        $location->street_address = $request->street_address;
        $location->latitude = $request->latitude;
        $location->longitude = $request->longitude;
        $location->ip_address = $request->ip_address;
        $location->country = $request->country;
        $location->country_code = $request->country_code;
        $location->city = $request->city;
        $location->zip_code = $request->zip_code;
        $location->reason = $request->reason;

        $location->save();

        if ($location) {

            $new_req = TeacherRequest::create([
                'request_type' => $request->request_type,
                'user_id' => Auth::user()->id,
                'request_id' => $location->id,
                'request_date' => date("M d, Y"),
            ]);

            return redirect()->back()->with('success', 'Location Update Request Uploaded Successfuly!');

        } else {
            return redirect()->back()->with('error', 'Something Error Please Try again Later!');

        }

    }


    // Add New Category =======

    public function TeacherAddNewCategory($id)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        $app = ExpertProfile::find($id);

        $freelance = Category::where(['service_role' => 'Freelance'])->get();
        $classes = Category::where(['service_role' => 'Class'])->get();

        if ($app->service_type == 'Class') {
            // Selected Categories in Unique Array ==
            $categoryIds = explode(',', $app->category_class);

            // Fetch the category names based on the IDs
            $categories = Category::whereIn('id', $categoryIds)->pluck('category')->toArray();

            // Remove duplicate category names (in case two IDs have the same name)
            $uniqueCategories = array_unique($categories);

            $ClassCates = count($uniqueCategories);
            $FreelanceCates = null;
        } else if ($app->service_type == 'Freelance') {

            // Selected Categories in Unique Array ==
            $categoryIds = explode(',', $app->category_freelance);

            // Fetch the category names based on the IDs
            $categories = Category::whereIn('id', $categoryIds)->pluck('category')->toArray();

            // Remove duplicate category names (in case two IDs have the same name)
            $uniqueCategories = array_unique($categories);

            $ClassCates = null;
            $FreelanceCates = count($uniqueCategories);
        } else {

            // Selected Categories in Unique Array ==
            $ClscategoryIds = explode(',', $app->category_class);

            // Fetch the category names based on the IDs
            $Clscategories = Category::whereIn('id', $ClscategoryIds)->pluck('category')->toArray();

            // Remove duplicate category names (in case two IDs have the same name)
            $ClsuniqueCategories = array_unique($Clscategories);

            $ClassCates = count($ClsuniqueCategories);


            // Selected Categories in Unique Array ==
            $FlscategoryIds = explode(',', $app->category_freelance);

            // Fetch the category names based on the IDs
            $Flscategories = Category::whereIn('id', $FlscategoryIds)->pluck('category')->toArray();

            // Remove duplicate category names (in case two IDs have the same name)
            $FlsuniqueCategories = array_unique($Flscategories);

            $FreelanceCates = count($FlsuniqueCategories);

        }


        return view("Teacher-Dashboard.add-new-category", compact('freelance', 'classes', 'app', 'FreelanceCates', 'ClassCates'));
    }

    public function GetServicesForTeacher(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

        if ($request->service_role == "Class") {
            $have_all_cates = $app->category_class;
        } else {
            $have_all_cates = $app->category_freelance;
        }


        if ($request->service_type != 'Both') {

            $services = Category::where(['service_role' => $request->service_role, 'service_type' => $request->service_type, 'status' => 1])->get();

            $response['have_all_cates'] = $have_all_cates;
            $response['service_type'] = $request->service_type;
            $response['service_role'] = $request->service_role;
            $response['services'] = $services;
            $response['service'] = 'Freelance';

            return response()->json($response);

        } elseif ($request->service_type == 'Both') {

            $services_freelance_online = Category::where(['service_role' => $request->service_role, 'service_type' => 'Online', 'status' => 1])->get();
            $services_freelance_inperson = Category::where(['service_role' => $request->service_role, 'service_type' => 'Inperson', 'status' => 1])->get();

            $response['have_all_cates'] = $have_all_cates;
            $response['service_type'] = $request->service_type;
            $response['service_role'] = $request->service_role;
            $response['service'] = 'Freelance';
            $response['services_freelance_online'] = $services_freelance_online;
            $response['services_freelance_inperson'] = $services_freelance_inperson;

            return response()->json($response);

        }


    }

    // Update Service Type and Role Script Start======
    public function TeacherUpdateServiceType(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $profile = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

        if ($profile->service_role != 'Both') {
            if ($profile->service_role != $request->service_role) {
                $profile->service_role = 'Both';
            }
        }

        if ($profile->service_type != 'Both') {
            if ($profile->service_type != $request->service_type) {
                $profile->service_type = 'Both';
            }
        }

        $profile->update();

        if ($profile) {
            return redirect()->back()->with('success', 'Your Service Type Updated Successfuly!');

        } else {
            return redirect()->back()->with('error', 'Something Went Rong, Try Again Later!');

        }


    }

    // Update Service Type and Role Script END======

    public function TeacherAddCategoryRequest(Request $request)
    {


        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        if ($request->category == null) {
            return redirect()->back()->with('error', 'Please Select a Category!');
        }
        $pending_req = TeacherRequest::where(['user_id' => Auth::user()->id, 'request_type' => $request->type, 'status' => 0])->first();

        if ($pending_req) {
            return redirect()->to('/teacher-profile')->with('error', 'Your Category Add Request Already in Pending!');
        }


        $convertedArray = array_map(function ($item) {
            return '[' . $item . ']';
        }, $request->url);

        // Join the elements with '|*|'
        $url = implode('|*|', $convertedArray);

        $category = new  TeacherCategoryRequest();


        $category->category = $request->category;
        $category->sub_category = $request->sub_category;
        $category->category_role = $request->service_role;

        if ($request->portfolio != "not_link") {
            foreach ($request->url as $key => $value) {
                if (empty($value)) {
                    return redirect()->back()->with('error', 'Please Add Portfolio If you have, Or Select Not have Link!');
                }
            }
            $category->portfolio = $request->portfolio;
            $category->portfolio_url = $url;
        } else {
            $category->portfolio = $request->portfolio;

        }

        if ($request->hasfile('certificate')) {
            $certificate = $request->certificate;
            $certificateName = $certificate->getClientOriginalName();
            $certificateData = $certificateName;
            $certificate->move(public_path() . '/assets/teacher/asset/img/certificate', $certificateName);
            $category->certificate = $certificateData;
        }

        $category->save();


        if ($category) {

            $request = TeacherRequest::create([
                'user_id' => Auth::user()->id,
                'request_type' => $request->type,
                'request_id' => $category->id,
                'request_date' => date("M d, Y"),
            ]);

            return redirect()->to('/teacher-profile')->with('success', 'Add New Category Request Uploaded!');
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }

    }


    public function TeacherAddFaq()
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        return view("Teacher-Dashboard.add-faq");


    }


    public function TeacherUploadFaq(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        if ($request->answer == null) {
            return redirect()->back()->with('error', "Please Write Answer of your Question For Add Faq's!");
        }

        $faq = new TeacherFaqs();
        $faq->user_id = Auth::user()->id;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
        if ($faq) {
            return redirect()->to('/teacher-profile')->with('success', "Faq's Added Successfuly!");
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }


    }


    public function TeacherEditFaq($id)
    {


        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        $faq = TeacherFaqs::find($id);

        return view("Teacher-Dashboard.edit-faq", compact('faq'));


    }


    public function TeacherUpdateFaq(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        if ($request->answer == null) {
            return redirect()->back()->with('error', "Please Write Answer of your Question For Add Faq's!");
        }

        $faq = TeacherFaqs::find($request->id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->update();
        if ($faq) {
            return redirect()->to('/teacher-profile')->with('success', "Faq's Update Successfuly!");
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }


    }

    public function TeacherFaqRemove($id)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $faq = TeacherFaqs::find($id);
        $faq->delete();
        if ($faq) {
            return redirect()->to('/teacher-profile')->with('success', "Faq's Deleted Successfuly!");
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }
    }

    // Teacher Profile Update Functions End==============

    public function HostGuidline()
    {


        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        $host = HostGuidline::all();

        return view("Teacher-Dashboard.host-guidlines", compact('host'));
    }


    public function HostHeading($id)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        $host = HostGuidline::find($id);

        return view("Teacher-Dashboard.host-heading", compact('host'));
    }


    // Contact Us Functions Start================
    public function TeacherContactUs()
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        return view("Teacher-Dashboard.contact");

    }
    // Contact Us Functions End================


    // Notes & Calender Functions Start================
    public function TeacherNotesCalender(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        return view("Teacher-Dashboard.notes&calander");

    }


    // Fetch all calendar events for the teacher
    public function TeacherCalenderindex(Request $request)
    {
        $userId = Auth::user()->id;
        $events = TeacherCalender::where(['user_id' => $userId])->get();

        return response()->json($events);
    }

    // Store a new event/note
    public function TeacherCalenderstore(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'color' => 'required',
            'reminder' => 'required',
            'notes' => 'required',
        ]);

        $event = new TeacherCalender();
        $event->user_id = Auth::user()->id;  // Store currently authenticated teacher
        $event->title = $request->title;
        $event->color = $request->color;
        $event->reminder = $request->reminder;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->notes = $request->notes;
        $event->save();

        return response()->json(['success' => 'Event added successfully', 'event' => $event]);
    }

    // Update an event/note
    public function TeacherCalenderupdate(Request $request, $id)
    {
        $request->validate([
            'title_upd' => 'required|string',
            'date_upd' => 'required|date',
            'time_upd' => 'nullable',
            'color_upd' => 'nullable|string',
            'reminder_upd' => 'nullable|string',
            'notes_upd' => 'nullable|string',
        ]);

        $event = TeacherCalender::find($id);
        if (!$event || $event->user_id != Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized or not found'], 403);
        }

        $event->title = $request->title_upd;
        $event->color = $request->color_upd;
        $event->reminder = $request->reminder_upd;
        $event->date = $request->date_upd;
        $event->time = $request->time_upd;
        $event->notes = $request->notes_upd;
        $event->save();

        return response()->json(['success' => 'Event updated successfully']);
    }

    // Delete an event/note
    public function TeacherCalenderdestroy($id)
    {
        $event = TeacherCalender::find($id);
        if (!$event || $event->user_id != Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized or not found'], 403);
        }

        $event->delete();

        return response()->json(['success' => 'Event deleted successfully']);
    }


    // Notes & Calender Functions End================

    // Submit Review of Order ===========
    public function submitReview(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 0) {
            return redirect('/')->with('error', 'Login First!');
        }
        if ($request->order_id == null || $request->rating == 0) {
            return back()->with('error', 'Please Select Rating First!');
        }

        $request->validate([
            'order_id' => 'required|exists:book_orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'cmnt' => 'nullable|string|max:1000'
        ]);

        $order = BookOrder::find($request->order_id);

        if (!$order) {
            return back()->with('error', 'Order not found!');
        }

        // Check if review already exists
        $existingReview = ServiceReviews::where('order_id', $request->order_id)
            ->with(['replies'])
            ->where('teacher_id', Auth::id())
            ->first();

        if ($existingReview && $existingReview->replies->count() > 0) {
            return redirect()->back()->with('error', 'You have already submitted a review for this order. You can not edit it.');
        }

        if ($existingReview) {
            $existingReview->update([
                'rating' => $request->rating,
                'cmnt' => $request->cmnt
            ]);
            return redirect()->back()->with('success', 'Successfully submitted a review for this order.');
        } else {
            ServiceReviews::create([
                'user_id' => Auth::id(),
                'teacher_id' => $order->teacher_id,
                'gig_id' => $order->gig_id,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'cmnt' => $request->cmnt
            ]);
        }
        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    public function deleteReview($review_id)
    {
        ServiceReviews::where('id', $review_id)
            ->where('teacher_id', Auth::id())
            ->delete();
        return redirect()->back()->with('success', 'Your review has been deleted.');
    }


    /**
     * Display all reviews with search and filter
     */
    public function getAllReviews(Request $request)
    {
        $query = ServiceReviews::with(['teacher', 'gig', 'order'])
            ->where('teacher_id', Auth::id())
            ->whereNull('parent_id');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cmnt', 'like', "%{$search}%")
                    ->orWhere('rating', 'like', "%{$search}%")
                    ->orWhereHas('gig', function ($gigQuery) use ($search) {
                        $gigQuery->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('order', function ($orderQuery) use ($search) {
                        $orderQuery->where('order_number', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by service type
        if ($request->filled('service_type')) {
            if ($request->service_type == 'gig') {
                $query->whereNotNull('gig_id');
            } elseif ($request->service_type == 'order') {
                $query->whereNotNull('order_id');
            }
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reviews = $query->latest()->paginate(10);

        return view('Teacher-Dashboard.reviews', compact('reviews'));
    }

    public function getSingleReview($id)
    {
        $review = ServiceReviews::with(['teacher', 'gig', 'order', 'replies.teacher'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);

        // Check if reply can be edited/deleted (within 7 days)
        $canEditReply = false;
        if ($review->replies->isNotEmpty()) {
            $reply = $review->replies->first();
            $canEditReply = $reply->canEditOrDelete();
        }

        return response()->json([
            'success' => true,
            'review' => $review,
            'can_edit' => $review->replies->isEmpty(),
            'can_edit_reply' => $canEditReply,
            'service_title' => $this->getServiceTitle($review),
            'service_type' => $this->getServiceType($review),
            'service_image' => $this->getServiceImage($review)
        ]);
    }

    private function getServiceTitle($review)
    {
        if ($review->gig) {
            return $review->gig->title ?? 'N/A';
        } elseif ($review->order) {
            return $review->order->service_title ?? 'Order #' . $review->order->order_number;
        }
        return 'N/A';
    }

    /**
     * Get service type
     */
    private function getServiceType($review)
    {
        if ($review->gig_id) {
            return 'Freelance Service';
        } elseif ($review->order_id) {
            return 'Order Service';
        }
        return 'N/A';
    }

    /**
     * Get service image
     */
    private function getServiceImage($review)
    {
        if ($review->gig && $review->gig->image) {
            return asset('storage/' . $review->gig->image);
        } elseif ($review->order && $review->order->image) {
            return asset('storage/' . $review->order->image);
        }
        return asset('assets/user/asset/img/table img.jpeg');
    }


    /**
     * Store teacher reply to a review
     */
    public function storeReply(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 1) { // Assuming role 1 is teacher
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $request->validate([
            'parent_id' => 'required|exists:service_reviews,id',
            'cmnt' => 'required|string|max:1000'
        ]);

        $parentReview = ServiceReviews::where('id', $request->parent_id)
            ->where('teacher_id', Auth::id())
            ->whereNull('parent_id')
            ->first();

        if (!$parentReview) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found or unauthorized.'
            ], 404);
        }

        // Check if teacher already replied
        $existingReply = ServiceReviews::where('parent_id', $request->parent_id)
            ->where('teacher_id', Auth::id())
            ->first();

        if ($existingReply) {
            return response()->json([
                'success' => false,
                'message' => 'You have already replied to this review.'
            ], 409);
        }

        $reply = ServiceReviews::create([
            'parent_id' => $request->parent_id,
            'user_id' => $parentReview->user_id,
            'teacher_id' => Auth::id(),
            'gig_id' => $parentReview->gig_id,
            'order_id' => $parentReview->order_id,
            'rating' => $parentReview->rating,
            'cmnt' => $request->cmnt,
        ]);

        // Send notification to buyer
        $sellerName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $gig = \App\Models\TeacherGig::find($parentReview->gig_id);
        $serviceName = $gig ? $gig->title : 'service';

        app(\App\Services\NotificationService::class)->send(
            userId: $parentReview->user_id,
            type: 'review',
            title: 'Seller Responded to Your Review',
            message: $sellerName . ' has responded to your review for ' . $serviceName . '.',
            data: ['review_id' => $parentReview->id, 'reply_id' => $reply->id, 'gig_id' => $parentReview->gig_id],
            sendEmail: false
        );

        return response()->json([
            'success' => true,
            'message' => 'Reply submitted successfully!',
            'reply' => $reply->load('teacher')
        ]);
    }

    /**
     * Update teacher reply
     */
    public function updateReply(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $reply = ServiceReviews::where('id', $id)
            ->where('teacher_id', Auth::id())
            ->whereNotNull('parent_id')
            ->first();

        if (!$reply) {
            return response()->json([
                'success' => false,
                'message' => 'Reply not found or unauthorized.'
            ], 404);
        }

        // Check if reply is within 7-day edit window
        if (!$reply->canEditOrDelete()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only edit your reply within 7 days of posting it.'
            ], 403);
        }

        $request->validate([
            'cmnt' => 'required|string|max:1000'
        ]);

        $reply->update([
            'cmnt' => $request->cmnt,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reply updated successfully!',
            'reply' => $reply->load('teacher')
        ]);
    }

    /**
     * Delete teacher reply
     */
    public function deleteReply($id)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.'
            ], 403);
        }

        $reply = ServiceReviews::where('id', $id)
            ->where('teacher_id', Auth::id())
            ->whereNotNull('parent_id')
            ->first();

        if (!$reply) {
            return response()->json([
                'success' => false,
                'message' => 'Reply not found or unauthorized.'
            ], 404);
        }

        // Check if reply is within 7-day delete window
        if (!$reply->canEditOrDelete()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your reply within 7 days of posting it.'
            ], 403);
        }

        $reply->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reply deleted successfully!'
        ]);
    }
}
