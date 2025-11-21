<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChangeEmail;
use App\Models\AdminCalender;
use App\Models\BankDetails;
use App\Models\Category;
use App\Models\ExpertFastPayment;
use App\Models\ExpertProfile;
use App\Models\RejectExpert;
use App\Models\SubCategory;
use App\Models\TeacherCategoryRequest;
use App\Models\TeacherLocationRequest;
use App\Models\TeacherProfileRequest;
use App\Models\TeacherRequest;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Stripe\Stripe;
use Stripe\Refund;
use Stripe\PaymentIntent;
use App\Models\WebSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Services\AdminDashboardService;

class AdminController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notification)
    {
        // Laravel automatically inject করবে
        $this->notificationService = $notification;
    }

    public function AdmincheckAuth()
    {
        if (!Auth::user()) {
            return redirect()->to('/')->with('error', 'Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 0) {
                return redirect()->to('/user-dashboard');
            } elseif (Auth::user()->role == 1) {
                return redirect()->to('/teacher-dashboard');
            }
        }
    }

    public function AdminDashboard()
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Dashboard loads via AJAX, no initial data needed
        return view("Admin-Dashboard.dashboard");
    }

    /**
     * Get admin dashboard statistics via AJAX
     */
    public function getAdminDashboardStatistics(Request $request)
    {
        $service = new AdminDashboardService();
        $preset = $request->input('preset', 'all_time');
        $customFrom = $request->input('date_from');
        $customTo = $request->input('date_to');

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
        $statistics = $service->getAllStatistics($dateFrom, $dateTo);

        return response()->json($statistics);
    }

    /**
     * Get revenue chart data for admin dashboard
     */
    public function getAdminRevenueChart(Request $request)
    {
        $service = new AdminDashboardService();
        $months = $request->input('months', 12);

        $chartData = $service->getRevenueChartData($months);

        return response()->json($chartData);
    }

    /**
     * Get order status chart data
     */
    public function getAdminOrderStatusChart(Request $request)
    {
        $service = new AdminDashboardService();
        $preset = $request->input('preset', 'all_time');
        $customFrom = $request->input('date_from');
        $customTo = $request->input('date_to');

        // Use custom dates if provided, otherwise use preset
        if ($customFrom && $customTo) {
            $dateFrom = $customFrom;
            $dateTo = $customTo;
        } else {
            $dates = $service->applyDatePreset($preset);
            $dateFrom = $dates['from'];
            $dateTo = $dates['to'];
        }

        $chartData = $service->getOrderStatusChart($dateFrom, $dateTo);

        return response()->json($chartData);
    }

    /**
     * Get top performers data (sellers, buyers, services, categories)
     */
    public function getAdminTopPerformers(Request $request)
    {
        $service = new AdminDashboardService();
        $type = $request->input('type', 'sellers');
        $limit = $request->input('limit', 10);
        $preset = $request->input('preset', 'all_time');
        $customFrom = $request->input('date_from');
        $customTo = $request->input('date_to');

        // Use custom dates if provided, otherwise use preset
        if ($customFrom && $customTo) {
            $dateFrom = $customFrom;
            $dateTo = $customTo;
        } else {
            $dates = $service->applyDatePreset($preset);
            $dateFrom = $dates['from'];
            $dateTo = $dates['to'];
        }

        switch ($type) {
            case 'sellers':
                $data = $service->getTopSellers($limit, $dateFrom, $dateTo);
                break;
            case 'buyers':
                $data = $service->getTopBuyers($limit, $dateFrom, $dateTo);
                break;
            case 'services':
                $data = $service->getTopServices($limit, $dateFrom, $dateTo);
                break;
            case 'categories':
                $data = $service->getTopCategories($limit, $dateFrom, $dateTo);
                break;
            default:
                $data = [];
        }

        return response()->json($data);
    }

    /**
     * Get management action items (pending applications, disputes, etc.)
     */
    public function getAdminActionItems(Request $request)
    {
        $service = new AdminDashboardService();

        $actionItems = [
            'pending_applications' => $service->getPendingApplications(10),
            'active_disputes' => $service->getActiveDisputes(10),
            'pending_refunds' => $service->getPendingRefunds(10),
        ];

        return response()->json($actionItems);
    }


    // Seller Management Start================

    // Seller Application Functions Start =========

    public function AllApplication()
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $new_app = ExpertProfile::where(['status' => 0])->latest()->get();
        $approved_app = ExpertProfile::where(['status' => 1])->latest()->get();
        $reject_app = ExpertProfile::where(['status' => 2])->latest()->get();

        return view("Admin-Dashboard.all-application", compact('new_app', 'approved_app', 'reject_app'));
    }


    public function ApplicationRequest($id)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }


        $app = ExpertProfile::find($id);

        return view("User-Dashboard.Application-request", compact('app'));
    }


    public function GetClassSubCategory(Request $request)
    {


        $category = Category::where(['id' => $request->cate_id])->first();
        $sub_cate = SubCategory::where(['cate_id' => $request->cate_id])->pluck('sub_category');

        $response['category'] = $category;
        $response['sub_cate'] = $sub_cate;
        return response()->json($response);
    }


    public function RejectApplicationCategory(Request $request)
    {


        $app = ExpertProfile::find($request->app_id);

        if ($request->type == 'Class') {
            $cate = $app->category_class;
            $sub_cate = $app->sub_category_class;
        } else {
            $cate = $app->category_freelance;
            $sub_cate = $app->sub_category_freelance;
        }

        $category = Category::where(['id' => $request->cate_id])->first();
        $sub_category = SubCategory::where(['cate_id' => $request->cate_id])->pluck('sub_category');


        $array = explode(',', $cate);
        $result = array_diff($array, [$request->cate_id]);

        $result = implode(',', $result);

        if ($sub_category) {

            $sub_cate = explode('|*|', $sub_cate);
            if ($category->service_type == 'Online') {
                $array1 = explode(',', $sub_cate[0]);
            } else {
                $array1 = explode(',', $sub_cate[1]);
            }


            $array1 = array_map('trim', $array1);
            $array2 = $sub_category;
            $object1 = (object)['items' => collect($array1)];
            $object2 = (object)['items' => collect($array2)];
            $result_sub = array_diff($object1->items->toArray(), $object2->items->toArray());
            // $result_sub = array_diff($array1, $array2);
            $result_sub = implode(',', $result_sub);

            if ($request->type == 'Class') {
                $app->category_class = $result;

                if ($category->service_type == 'Online') {
                    $app->sub_category_class = $result_sub . '|*|' . $sub_cate[1];
                } else {
                    $app->sub_category_class = $sub_cate[0] . '|*|' . $result_sub;
                }
            } else {
                $app->category_freelance = $result;
                if ($category->service_type == 'Online') {
                    $app->sub_category_freelance = $result_sub . '|*|' . $sub_cate[1];
                } else {
                    $app->sub_category_freelance = $sub_cate[0] . '|*|' . $result_sub;
                }
            }
        }


        $app->update();

        // Send notification to seller
        $this->notificationService->send(
            userId: $app->user_id,
            type: 'account',
            title: 'Category Rejected',
            message: 'The category "' . $category->category . '" has been removed from your seller application. Please review your application or contact support for more information.',
            data: ['application_id' => $app->id, 'rejected_category' => $category->category, 'type' => $request->type],
            sendEmail: true,
            actorUserId: Auth::id(),
            targetUserId: $app->user_id
        );

        if ($app) {
            $response['cate'] = $app;
            $response['type'] = $request->type;
            $response['success'] = true;
            $response['message'] = 'Category Removed Successfuly!';
            return response()->json($response);
        } else {

            $response['error'] = true;
            $response['message'] = 'Something Wrong, Tryagain Later!';
            return response()->json($response);
        }
    }


    public function RejectClassSubCategory(Request $request)
    {


        $sub_cate = ExpertProfile::find($request->app_id);
        if ($request->service_type == 'class_sub') {
            $sub_cates = explode('|*|', $sub_cate->sub_category_class);
            if ($request->cates_type == 'Online') {
                $sub_cates = $request->sub_category . '|*|' . $sub_cates[1];
            } else {
                $sub_cates = $sub_cates[0] . '|*|' . $request->sub_category;
            }

            $sub_cate->sub_category_class = $sub_cates;
        } else {
            $sub_cates = explode('|*|', $sub_cate->sub_category_freelance);
            if ($request->cates_type == 'Online') {
                $sub_cates = $request->sub_category . '|*|' . $sub_cates[1];
            } else {
                $sub_cates = $sub_cates[0] . '|*|' . $request->sub_category;
            }
            $sub_cate->sub_category_freelance = $sub_cates;
        }
        $sub_cate->update();

        if ($sub_cate) {

            $response['service_type'] = $request->service_type;
            if ($request->service_type == 'class_sub') {
                $response['sub_category'] = $sub_cate->sub_category_class;
            } else {
                $response['sub_category'] = $sub_cate->sub_category_freelance;
            }

            $response['success'] = true;
            $response['message'] = 'Sub Category Rejected Successfuly!';
            return response()->json($response);
        } else {
            $response['error'] = true;
            $response['message'] = 'Something Wrong, Tryagain Later!';
            return response()->json($response);
        }
    }

    public function RejectAllCategories($id)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $category = ExpertProfile::find($id);

        $category->category_class = null;
        $category->sub_category_class = null;
        $category->category_freelance = null;
        $category->sub_category_freelance = null;

        $category->update();

        if ($category) {
            return redirect()->back()->with('success', 'All Categories Rejected Successfuly!');
        } else {
            return redirect()->back()->with('error', 'Something Error Please Try again Later!');
        }
    }


    public function ApplicationAction(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $expert = ExpertProfile::find($request->app_id);

        if ($request->action == 'reject') {

            $user = User::find($expert->user_id);
            $oldRole = $user->role;
            $user->role = 0;


            $expert->status = 2;
            $expert->action_date = date("M d, Y");

            $payment = ExpertFastPayment::where(['user_id' => $expert->user_id, 'status' => 0])->first();
            Stripe::setApiKey(config('services.stripe.secret'));
            if ($request->payment_refund == 'Yes') {
                if (!$payment) {
                    return redirect()->back()->with(['error' => 'Payment not found!'], 404);
                }
                if ($payment) {

                    // Cancel the PaymentIntent
                    $paymentIntent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);
                    $paymentIntent->cancel();

                    $payment->return = 1;
                    $payment->status = 2;
                    $payment->update();
                }
            } else {
                if ($payment) {
                    // Capture the payment
                    $paymentIntent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);
                    $paymentIntent->capture();
                    $payment->status = 2;
                    $payment->update();
                }
            }


            RejectExpert::updateOrCreate(
                [
                    'user_id' => $expert->user_id, // Match condition
                    'expert_id' => $expert->id    // Match condition
                ],
                [
                    'reason' => $request->reason  // Data to insert or update
                ]
            );


            $user->update();
            $expert->update();

            // Send account role change notification
            if ($oldRole != 0) {
                try {
                    $this->notificationService->send(
                        userId: $expert->user_id,
                        type: 'account',
                        title: 'Account Role Changed',
                        message: 'Your account role has been changed to Buyer due to seller application rejection.',
                        data: [
                            'old_role' => $oldRole,
                            'new_role' => 0,
                            'changed_at' => now()->toISOString(),
                            'reason' => 'Seller application rejected'
                        ],
                        sendEmail: false,
                        actorUserId: Auth::id(),
                        targetUserId: $expert->user_id
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send role change notification: ' . $e->getMessage());
                }
            }

            // If rejected
            $this->notificationService->send(
                userId: $expert->user_id,
                type: 'account',
                title: 'Seller Application Rejected',
                message: 'Unfortunately, your seller application was not approved. Reason: ' . $request->reason,
                data: ['rejection_reason' => $request->reason],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $expert->user_id
            );

            if ($expert) {
                return redirect()->to('/all-application')->with('success', 'Application Rejected Successfuly!');
            } else {
                return redirect()->back()->with('error', 'Something Rong, Tryagain Later!');
            }
        } else {
            $user = User::find($expert->user_id);

            $oldRole = $user->role;
            $user->profile = $expert->profile_image;
            $user->first_name = $expert->first_name;
            $user->last_name = $expert->last_name;
            $user->city = $expert->city;
            $user->country = $expert->country;
            $user->country_code = $expert->country_code;
            $user->zip_code = $expert->zip_code;
            $user->ip = $expert->ip_address;
            $user->role = 1;
            $user->update();

            // Send account role change notification
            if ($oldRole != 1) {
                try {
                    $this->notificationService->send(
                        userId: $expert->user_id,
                        type: 'account',
                        title: 'Account Role Changed',
                        message: 'Congratulations! Your account has been upgraded to Seller. You can now create and manage services.',
                        data: [
                            'old_role' => $oldRole,
                            'new_role' => 1,
                            'changed_at' => now()->toISOString(),
                            'reason' => 'Seller application approved'
                        ],
                        sendEmail: false,
                        actorUserId: Auth::id(),
                        targetUserId: $expert->user_id
                    );
                } catch (\Exception $e) {
                    \Log::error('Failed to send role change notification: ' . $e->getMessage());
                }
            }

            $expert->status = 1;
            $expert->action_date = date("M d, Y");
            $expert->update();
            $payment = ExpertFastPayment::where(['user_id' => $expert->user_id, 'status' => 0])->first();
            if ($payment) {
                // Capture the payment
                $paymentIntent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);
                $paymentIntent->capture();
                $payment->status = 1;
                $payment->update();
            }


            // If approved
            $this->notificationService->send(
                userId: $expert->user_id,
                type: 'account',
                title: 'Seller Application Approved',
                message: 'Congratulations! Your seller application has been approved. You can now start creating services and accepting orders.',
                data: ['approved_at' => now()],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $expert->user_id
            );


            if ($expert) {
                return redirect()->to('/all-application')->with('success', 'Application Approved Successfully!');
            } else {
                return redirect()->back()->with('error', 'Something wrong, Try again Later!');
            }
        }
    }


    //   Seller Application Functions  END==========

    //   Seller Request Functions  END==========

    public function SellerRequest()
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }


        $request = TeacherRequest::where(['status' => 0])->get();

        return view("Admin-Dashboard.seller-request", compact('request'));
    }


    public function SellerUpdateRequest($id)
    {


        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request = TeacherRequest::find($id);
        if ($request->request_type == 'profile') {
            $main = TeacherProfileRequest::find($request->request_id);
        } elseif ($request->request_type == 'location') {
            $main = TeacherLocationRequest::find($request->request_id);
        } else {
            $main = TeacherCategoryRequest::find($request->request_id);
        }
        $user = User::find($request->user_id);
        $expert = ExpertProfile::where(['user_id' => $request->user_id])->first();

        return view("Admin-Dashboard.Application-request", compact('request', 'user', 'expert', 'main'));
    }

    public function RejectSellerRequest($id)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request = TeacherRequest::find($id);
        $request->status = 2;
        $request->update();

        // Send notification to seller about request rejection
        if ($request && $request->user_id) {
            $this->notificationService->send(
                userId: $request->user_id,
                type: 'account',
                title: 'Request Rejected',
                message: 'Your request has been rejected by the admin team. Please contact support for more information.',
                data: [
                    'request_id' => $id,
                    'rejected_at' => now()->toISOString(),
                    'request_type' => $request->request_type ?? 'unknown'
                ],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $request->user_id
            );
        }

        if ($request) {
            return redirect()->to('/seller-request')->with('success', 'Seller Request Rejected!');
        } else {
            return redirect()->back()->with('error', 'Something Error Please Try again Later!');
        }
    }

    // Fetch Sub Categories Function Start ======


    public function GetRequestedSubCategory(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }


        $sub_cate = SubCategory::where(['cate_id' => $request->cate_id])->pluck('sub_category');


        $response['sub_cate'] = $sub_cate;
        return response()->json($response);
    }


    public function RejectRequestedSubCategory(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request_cate = TeacherRequest::find($request->request_id);
        $sub_cate = TeacherCategoryRequest::find($request_cate->request_id);

        $sub_cates = explode('|*|', $sub_cate->sub_category);
        if ($request->cates_type == 'Online') {
            $sub_cates = $request->sub_category . '|*|' . $sub_cates[1];
        } else {
            $sub_cates = $sub_cates[0] . '|*|' . $request->sub_category;
        }

        $sub_cate->sub_category = $sub_cates;

        $sub_cate->update();

        if ($sub_cate) {

            $response['service_role'] = $request->service_role;

            $response['sub_category'] = $sub_cate->sub_category;

            $response['success'] = true;
            $response['message'] = 'Sub Category Rejected Successfuly!';
            return response()->json($response);
        } else {
            $response['error'] = true;
            $response['message'] = 'Something Wrong, Tryagain Later!';
            return response()->json($response);
        }
    }


    public function RejectRequestedApplicationCategory(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request_cate = TeacherRequest::find($request->request_id);
        $app = TeacherCategoryRequest::find($request_cate->request_id);


        $cate = $app->category;
        $sub_cate = $app->sub_category;
        $sub_cate = explode('|*|', $sub_cate);

        $category = Category::where(['id' => $request->cate_id])->first();
        $sub_category = SubCategory::where(['cate_id' => $request->cate_id])->pluck('sub_category');


        $array = explode(',', $cate);
        $array = array_map('trim', $array);
        $result = array_diff($array, [$category->id]);

        $result = implode(',', $result);

        if ($sub_category) {


            if ($category->service_type == 'Online') {
                $array1 = explode(',', $sub_cate[0]);
            } else {
                $array1 = explode(',', $sub_cate[1]);
            }


            $array1 = array_map('trim', $array1);
            $array2 = $sub_category;
            $object1 = (object)['items' => collect($array1)];
            $object2 = (object)['items' => collect($array2)];
            $result_sub = array_diff($object1->items->toArray(), $object2->items->toArray());

            // $result_sub = array_diff($array1, $array2);
            $result_sub = implode(',', $result_sub);


            $app->category = $result;

            if ($category->service_type == 'Online') {
                $app->sub_category = $result_sub . '|*|' . $sub_cate[1];
            } else {
                $app->sub_category = $sub_cate[0] . '|*|' . $result_sub;
            }
        }


        $app->update();


        if ($app) {
            $response['cate'] = $app;
            $response['type'] = $request->type;
            $response['success'] = true;
            $response['message'] = 'Category Removed Successfuly!';
            return response()->json($response);
        } else {

            $response['error'] = true;
            $response['message'] = 'Something Wrong, Tryagain Later!';
            return response()->json($response);
        }
    }


    // Fetch Sub Categories Function End ======


    public function ApproveSellerRequest($id)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request = TeacherRequest::find($id);

        $user = User::find($request->user_id);
        $expert = ExpertProfile::where(['user_id' => $request->user_id])->first();


        if ($request->request_type == 'profile') {

            $main = TeacherProfileRequest::find($request->request_id);

            if ($main->profile_image != null) {
                $expert->profile_image = $main->profile_image;
                $user->profile = $main->profile_image;
            }


            if ($main->first_name != null) {
                $expert->first_name = $main->first_name;
                $user->first_name = $main->first_name;
            }
            if ($main->last_name != null) {
                $expert->last_name = $main->last_name;
                $user->last_name = $main->last_name;
            }
            if ($main->show_full_name != 0) {
                $expert->show_full_name = 1;
            } else {
                $expert->show_full_name = 0;
            }


            if ($main->gender != null) {
                $expert->gender = $main->gender;
            }
            if ($main->profession != null) {
                $expert->profession = $main->profession;
            }
            if ($main->primary_language != null) {
                $expert->primary_language = $main->primary_language;
            }
            if ($main->primary_language != 'English') {
                $expert->fluent_english = $main->fluent_english;
            } else {
                $expert->fluent_english = Null;
            }
            $expert->fluent_other_language = $main->speak_other_language;

            if ($main->speak_other_language == 1) {
                $expert->speak_other_language = 1;
                // if ($main->other_language != null) {
                $expert->fluent_other_language = $main->other_language;
                // }
            } else {
                $expert->speak_other_language = 0;

                $expert->fluent_other_language = null;
            }
            if ($main->overview != null) {
                $expert->overview = $main->overview;
            }
            if ($main->about_me != null) {
                $expert->about_me = $main->about_me;
            }
            if ($main->main_image != null) {
                $expert->main_image = $main->main_image;
            }
            if ($main->more_image_1 != null) {
                $expert->more_image_1 = $main->more_image_1;
            }
            if ($main->more_image_2 != null) {
                $expert->more_image_2 = $main->more_image_2;
            }
            if ($main->more_image_3 != null) {
                $expert->more_image_3 = $main->more_image_3;
            }
            if ($main->more_image_4 != null) {
                $expert->more_image_4 = $main->more_image_4;
            }
            if ($main->more_image_5 != null) {
                $expert->more_image_5 = $main->more_image_5;
            }
            if ($main->more_image_6 != null) {
                $expert->more_image_6 = $main->more_image_6;
            }
            if ($main->video != null) {
                $expert->video = $main->video;
            }

            $request->status = 1;

            $expert->update();
            $user->update();
            $request->update();

            // Send notification to seller about profile update approval
            $this->notificationService->send(
                userId: $user->id,
                type: 'account',
                title: 'Profile Update Approved',
                message: 'Your profile update request has been approved by the admin team.',
                data: [
                    'request_id' => $id,
                    'approved_at' => now()->toISOString(),
                    'request_type' => 'profile'
                ],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $user->id
            );

            if ($expert) {
                return redirect()->to('/seller-request')->with('success', 'Seller Request Approved!');
            } else {
                return redirect()->back()->with('error', 'Something Error Please Try again Later!');
            }
        } elseif ($request->request_type == 'location') {

            $main = TeacherLocationRequest::find($request->request_id);


            $expert->street_address = $main->street_address;
            $expert->ip_address = $main->ip_address;
            $user->ip = $main->ip_address;
            $expert->latitude = $main->latitude;
            $expert->longitude = $main->longitude;
            $expert->country = $main->country;
            $user->country = $main->country;
            $expert->city = $main->city;
            $user->city = $main->city;
            $expert->zip_code = $main->zip_code;
            $user->zip_code = $main->zip_code;


            $request->status = 1;

            $expert->update();
            $user->update();
            $request->update();

            if ($expert) {
                return redirect()->to('/seller-request')->with('success', 'Seller Request Approved!');
            } else {
                return redirect()->back()->with('error', 'Something Error Please Try again Later!');
            }
        } else {

            $main = TeacherCategoryRequest::find($request->request_id);

            if ($main->category_role == "Class") {
                $get_cate = $expert->category_class;
                $get_cate_sub = $expert->sub_category_class;
                $array2 = explode(',', $expert->category_class);
                $sub_array2 = explode('|*|', $expert->sub_category_class);
                $sub_array20 = explode(',', $sub_array2[0]);
                $sub_array21 = explode(',', $sub_array2[1]);
            } else {
                $get_cate = $expert->category_freelance;
                $get_cate_sub = $expert->sub_category_freelance;
                $array2 = explode(',', $expert->category_freelance);
                $sub_array2 = explode('|*|', $expert->sub_category_freelance);
                $sub_array20 = explode(',', $sub_array2[0]);
                $sub_array21 = explode(',', $sub_array2[1]);
            }

            // Convert the strings to arrays
            $array1 = explode(',', $main->category);
            $sub_array1 = explode('|*|', $main->sub_category);
            $sub_array10 = explode(',', $sub_array1[0]);
            $sub_array11 = explode(',', $sub_array1[1]);


            foreach ($array1 as $item) {
                if (!in_array($item, $array2)) {
                    $array2[] = $item;
                }
            }
            foreach ($sub_array10 as $item) {
                if (!in_array($item, $sub_array20)) {
                    $sub_array20[] = $item;
                }
            }
            foreach ($sub_array11 as $item) {
                if (!in_array($item, $sub_array21)) {
                    $sub_array21[] = $item;
                }
            }


            // Convert back to a string
            $category = implode(',', $array2);
            // Convert back to a string
            $sub_category0 = implode(',', $sub_array20);
            $sub_category1 = implode(',', $sub_array21);
            $sub_category = $sub_category0 . '|*|' . $sub_category1;


            if ($main->category_role == 'Freelance') {
                if ($get_cate != null) {
                    $expert->category_freelance = $category;
                } else {
                    $expert->category_freelance = $main->category;
                }
                if ($get_cate_sub != null) {
                    $expert->sub_category_freelance = $sub_category;
                } else {
                    $expert->sub_category_freelance = $main->sub_category;
                }
            } else {

                if ($get_cate != null) {
                    $expert->category_class = $category;
                } else {
                    $expert->category_class = $main->category;
                }
                if ($get_cate_sub != null) {
                    $expert->sub_category_class = $sub_category;
                } else {
                    $expert->sub_category_class = $main->sub_category;
                }
            }


            $request->status = 1;
            $expert->update();
            $request->update();

            if ($expert) {
                return redirect()->to('/seller-request')->with('success', 'Seller Request Approved!');
            } else {
                return redirect()->back()->with('error', 'Something Error Please Try again Later!');
            }
        }
    }

    //   Seller Request Functions  END==========

    // Seller Management END================

    // Admin Management Start================

    public function AdminManagement()
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }


        $admins = User::where('role', '=', 2)->where('admin_role', '<', Auth::user()->admin_role)->paginate(10);
        return view("Admin-Dashboard.admin-management", compact('admins'));
    }


    // Create Admin ============
    public function CreateAdmin(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }


        $password = $request->input('password');


        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'The password must be at least 8 characters long.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return redirect()->back()->with('error', 'The password must contain at least one uppercase letter.');
        }
        if (!preg_match('/[0-9]/', $password)) {
            return redirect()->back()->with('error', 'The password must contain at least one number.');
        }

        if (!preg_match('/[\W_]/', $password)) {
            return redirect()->back()->with('error', 'The password must contain at least one special character.');
        }


        if ($request->password != $request->c_password) {
            return redirect()->back()->with('error', 'Password did not Matched!');
        }


        if ($request->email == null || $request->password == null || $request->c_password == null || $request->first_name == null || $request->last_name == null) {
            return redirect()->back()->with('error', 'All Fields Are Required!');
        }

        if ($request->password != $request->c_password) {
            return redirect()->back()->with('error', 'Password did not Matched');
        }

        $user = User::where(['email' => $request->email])->first();

        if (!empty($user)) {
            return redirect()->back()->with('error', 'This Email is Already Registered');
        }

        if ($request->role >= Auth::user()->admin_role) {
            return redirect()->back()->with('error', 'You are Not Allowed to Add Admin in Heigher Rank!');
        }


        //  $userIp = $_SERVER['REMOTE_ADDR']; /* Live IP address */
        // $userIp = $request->ip(); /* Live IP address */
        //  $userIp = '162.159.24.227'; /* Static IP address */
        //  $location = Location::get($userIp);
        //  echo $location->countryName;
        // echo $location->countryCode ;
        // echo $location->cityName ;


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'email_verify' => 'verified',
            'password' => Hash::make($request->password),
            // 'ip' => $userIp,
            // 'city' => $location->cityName,
            // 'country' => $location->countryName,
            'status' => 1,
            'role' => 2,
            'admin_role' => $request->role,
        ]);

        if ($user) {
            return redirect()->back()->with('success', 'New Admin Created Successfuly!');
        } else {
            return redirect()->back()->with('error', 'Something Error Please Try again Later!');
        }
    }

    public function UpdateAdmin(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        if ($request->email == null || $request->first_name == null || $request->last_name == null) {
            return redirect()->back()->with('error', 'Fields Are Required!');
        }

        if ($request->role >= Auth::user()->admin_role) {
            return redirect()->back()->with('error', 'You are Not Allowed to Update Admin in Heigher Rank!');
        }

        $admin = User::find($request->id);

        if ($request->email != $admin->email) {

            $user = User::where(['email' => $request->email])->first();
            if (!empty($user)) {
                return redirect()->back()->with('error', 'This Email is Already Registered');
            }
            $admin->email = $request->email;
        }

        if ($request->password != null) {


            $password = $request->input('password');


            if (strlen($password) < 8) {
                return redirect()->back()->with('error', 'The password must be at least 8 characters long.');
            }

            if (!preg_match('/[A-Z]/', $password)) {
                return redirect()->back()->with('error', 'The password must contain at least one uppercase letter.');
            }
            if (!preg_match('/[0-9]/', $password)) {
                return redirect()->back()->with('error', 'The password must contain at least one number.');
            }

            if (!preg_match('/[\W_]/', $password)) {
                return redirect()->back()->with('error', 'The password must contain at least one special character.');
            }


            if ($request->password != $request->c_password) {
                return redirect()->back()->with('error', 'Password did not Matched!');
            }


            if ($request->password != $request->c_password) {
                return redirect()->back()->with('error', 'Password did not Matched');
            }
            $admin->password = Hash::make($request->password);
        }

        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->admin_role = $request->role;
        $admin->update();

        return redirect()->back()->with('success', 'Admin Details Updated Successfuly!');
    }


    // Delete Admin ===========
    public function DeleteAdmin($id)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $admin = User::find($id);
        $admin->delete();
        return redirect()->back()->with('success', 'Admin Deleted Successfuly!');
    }

    // Block Admin ===========
    public function BlockAdmin($id)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $admin = User::find($id);
        if ($admin->status == 2) {
            $admin->status = 1;
            $admin->update();
            return redirect()->back()->with('success', 'Admin Un Blocked Successfuly!');
        } else {
            $admin->status = 2;
            $admin->update();
            return redirect()->back()->with('success', 'Admin Blocked Successfuly!');
        }
    }

    // Admin Management End================

    // Admin Profile Functions Start ================
    // Account Setting Functions Start =================
    public function AdminProfile()
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }


        $web_setting = WebSetting::first();
        $bank_details = BankDetails::where(['user_id' => Auth::user()->id])->first();
        return view("Admin-Dashboard.account-setting", compact('web_setting', 'bank_details'));
    }


    public function UpdatePassword(Request $request)
    {


        $password = $request->input('new_password');


        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'The password must be at least 8 characters long.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            return redirect()->back()->with('error', 'The password must contain at least one uppercase letter.');
        }
        if (!preg_match('/[0-9]/', $password)) {
            return redirect()->back()->with('error', 'The password must contain at least one number.');
        }

        if (!preg_match('/[\W_]/', $password)) {
            return redirect()->back()->with('error', 'The password must contain at least one special character.');
        }


        if ($request->new_password != $request->c_password) {
            return redirect()->back()->with('error', 'Password did not Matched!');
        }

        $user = User::find(Auth::user()->id);

        if (Hash::check($request->password, $user->password)) {
            if ($request->new_password != $request->c_password) {
                return redirect()->back()->with('error', "New Password and Confirm Password Didn't Matched!");
            }
            $user->password = Hash::make($request->new_password);
            $user->update();
            if ($user) {
                return redirect()->back()->with('success', 'Password Changed Successfuly!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        } else {
            return redirect()->back()->with('error', 'You Entered an Incorrect Password!');
        }
    }

    public function ChangeEmailSendCode(Request $request)
    {


        $user = User::find(Auth::user()->id);

        if ($user->email != $request->email) {
            return response()->json([
                'error' => true,
                'message' => 'Crrunt Email is Invalid!'
            ]);
        }

        $randomNumber = random_int(100000, 999999);

        $user->email_code = $randomNumber;


        $mailData = [
            'title' => 'Email Change',
            'randomNumber' => $randomNumber,
        ];

        $email_send = Mail::to($request->email)->send(new ChangeEmail($mailData));

        if ($email_send) {
            $user->update();
            return response()->json([
                'success' => true,
                'message' => 'Verification Code Send to Your Mail!'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Something Went Rong, Tryagain!'
            ]);
        }
    }


    public function UpdateEmail(Request $request)
    {


        $user = User::find(Auth::user()->id);

        if ($user->email != $request->email) {
            return redirect()->back()->with('error', "Crrunt Email is Invalid!");
        }

        if ($user->email == $request->new_email) {
            return redirect()->back()->with('error', "Please Use Different Email!");
        }

        $new_mail = User::where(['email' => $request->new_email])->first();

        if ($new_mail) {
            return redirect()->back()->with('error', "This Email Already in Use!");
        }

        if ($user->email_code != $request->code) {
            return redirect()->back()->with('error', "You Enterred an Incorrect Code!");
        }

        $user->email = $request->new_email;
        $user->email_code = null;
        $user->update();

        if ($user) {
            return redirect()->back()->with('success', 'Email Updated Successfuly!');
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }
    }

    public function UpdateBankDetails(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $bank_details = BankDetails::where(['user_id' => $user->id])->first();

        if ($user->role == 2 || $user->role == 3) {

            if ($bank_details) {

                $bank_details->user_id = $user->id;
                $bank_details->bank_name = $request->bank_name;
                $bank_details->holder_name = $request->holder_name;
                $bank_details->iban = $request->iban;
                $bank_details->update();

                if ($bank_details) {
                    return redirect()->back()->with('success', 'Bank Details Updated Successfuly!');
                } else {
                    return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
                }
            } else {

                $bank_details = BankDetails::create([
                    'user_id' => $user->id,
                    'bank_name' => $request->bank_name,
                    'holder_name' => $request->holder_name,
                    'iban' => $request->iban,
                ]);

                if ($bank_details) {
                    return redirect()->back()->with('success', 'Bank Details Updated Successfuly!');
                } else {
                    return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
                }
            }
        } else {


            if ($bank_details) {

                $bank_details->user_id = $user->id;
                $bank_details->holder_name = $request->holder_name;
                $bank_details->card_number = $request->card_number;
                $bank_details->cvv = $request->cvv;
                $bank_details->expiry_date = $request->expiry_date;
                $bank_details->update();

                if ($bank_details) {
                    return redirect()->back()->with('success', 'Bank Details Updated Successfuly!');
                } else {
                    return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
                }
            } else {

                $bank_details = BankDetails::create([
                    'user_id' => $user->id,
                    'holder_name' => $request->holder_name,
                    'card_number' => $request->card_number,
                    'cvv' => $request->cvv,
                    'expiry_date' => $request->expiry_date,
                ]);

                if ($bank_details) {
                    return redirect()->back()->with('success', 'Bank Details Updated Successfuly!');
                } else {
                    return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
                }
            }
        }
    }


    public function DeleteBankDetails($id)
    {


        $bank_details = BankDetails::find($id);
        $bank_details->delete();
        if ($bank_details) {
            return redirect()->back()->with('success', 'Bank Details Deleted!');
        } else {
            return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
        }
    }


    public function UpdateWebSetting(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $web_setting = WebSetting::first();

        if ($web_setting) {

            $web_setting->classes_expert = $request->classes_expert;
            $web_setting->remote_expert = $request->remote_expert;
            $web_setting->commission_rate = $request->commission_rate;
            $web_setting->currency = $request->currency;
            $web_setting->meta_description = $request->meta_description;
            $web_setting->update();

            if ($web_setting) {
                return redirect()->back()->with('success', 'Web Setting Updated Successfuly!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        } else {

            $web_setting = WebSetting::create([
                'classes_expert' => $request->classes_expert,
                'remote_expert' => $request->remote_expert,
                'commission_rate' => $request->commission_rate,
                'currency' => $request->currency,
                'meta_description' => $request->meta_description,
            ]);

            if ($web_setting) {
                return redirect()->back()->with('success', 'Web Setting Updated Successfuly!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong,Tryagain Later!');
            }
        }
    }


    // Admin Profile Functions END ================
    // Account Setting Functions END =================


    // Notes & Calender Functions Start================
    public function AdminNotesCalender(Request $request)
    {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        return view("Admin-Dashboard.notes&calender");
    }


    // Fetch all calendar events for the teacher
    public function AdminCalenderindex(Request $request)
    {
        $userId = Auth::user()->id;
        $events = AdminCalender::where('user_id', $userId)->get();

        return response()->json($events);
    }

    // Store a new event/note
    public function AdminCalenderstore(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'time' => 'required',
            'color' => 'required',
            'reminder' => 'required',
            'notes' => 'required',
        ]);

        $event = new AdminCalender();
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
    public function AdminCalenderupdate(Request $request, $id)
    {
        $request->validate([
            'title_upd' => 'required|string',
            'date_upd' => 'required|date',
            'time_upd' => 'nullable',
            'color_upd' => 'nullable|string',
            'reminder_upd' => 'nullable|string',
            'notes_upd' => 'nullable|string',
        ]);

        $event = AdminCalender::find($id);
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
    public function AdminCalenderdestroy($id)
    {
        $event = AdminCalender::find($id);
        if (!$event || $event->user_id != Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized or not found'], 403);
        }

        $event->delete();

        return response()->json(['success' => 'Event deleted successfully']);
    }


    // Notes & Calender Functions End================


    /**
     * Admin manually marks payout as completed
     * This should be in your Admin controller, but I'm showing it here
     */
    public function adminMarkPayoutCompleted($transactionId)
    {
        // This method would be in AdminController
        if (!Auth::check() || Auth::user()->role != 2) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        try {
            $transaction = Transaction::findOrFail($transactionId);

            if ($transaction->payout_status == 'paid') {
                return redirect()->back()->with('error', 'Payout already completed');
            }

            $transaction->markPayoutCompleted();

            \Log::info('Admin marked payout as completed', [
                'transaction_id' => $transaction->id,
                'seller_id' => $transaction->seller_id,
                'amount' => $transaction->seller_earnings,
                'admin_id' => Auth::id()
            ]);

            // Send notification to seller
            $amount = number_format($transaction->seller_earnings, 2);
            $this->notificationService->send(
                userId: $transaction->seller_id,
                type: 'payout',
                title: 'Payment Processed',
                message: 'Your payment of $' . $amount . ' has been processed by admin and will be transferred to your account shortly.',
                data: ['transaction_id' => $transaction->id, 'amount' => $amount],
                sendEmail: true,
                actorUserId: Auth::id(),
                targetUserId: $transaction->seller_id
            );

            return redirect()->back()->with('success', 'Payout marked as completed successfully');
        } catch (\Exception $e) {
            \Log::error('Payout completion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark payout as completed');
        }
    }

    /**
     * Batch process payouts for multiple transactions
     */
    public function adminBatchProcessPayouts(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        $transactionIds = $request->transaction_ids; // Array of IDs

        if (empty($transactionIds)) {
            return redirect()->back()->with('error', 'No transactions selected');
        }

        $processed = 0;
        $failed = 0;

        foreach ($transactionIds as $id) {
            try {
                $transaction = Transaction::find($id);

                if ($transaction && $transaction->payout_status == 'pending' && $transaction->status == 'completed') {
                    $transaction->markPayoutCompleted();
                    $processed++;

                    // Send notification to seller
                    $amount = number_format($transaction->seller_earnings, 2);
                    $this->notificationService->send(
                        userId: $transaction->seller_id,
                        type: 'payout',
                        title: 'Payment Processed',
                        message: 'Your payment of $' . $amount . ' has been processed and will be transferred to your account shortly.',
                        data: ['transaction_id' => $transaction->id, 'amount' => $amount],
                        sendEmail: true,
                        actorUserId: Auth::id(),
                        targetUserId: $transaction->seller_id
                    );
                }
            } catch (\Exception $e) {
                \Log::error('Batch payout failed for transaction ' . $id . ': ' . $e->getMessage());
                $failed++;
            }
        }

        return redirect()->back()->with('success', "Processed {$processed} payouts successfully. Failed: {$failed}");
    }

    // ============================================
    // CRITICAL-2 FIX: Missing Admin Panel Features
    // ============================================

    /**
     * All Sellers Management
     */
    public function allSellers(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Determine which tab/status to show
        $status = $request->get('status', 'active'); // active, hidden, paused, banned, deleted

        // Base query for sellers (users with role = 1)
        $query = User::where('role', 1);

        // Apply status filter based on tab
        switch ($status) {
            case 'active':
                $query->where('status', User::STATUS_ACTIVE);
                break;
            case 'hidden':
                $query->where('status', User::STATUS_HIDDEN);
                break;
            case 'paused':
                $query->where('status', User::STATUS_PAUSED);
                break;
            case 'banned':
                $query->where('status', User::STATUS_BANNED);
                break;
            case 'deleted':
                $query->onlyTrashed();
                break;
        }

        // FILTER 1: Date Range Filter (Registration Date)
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

        // FILTER 2: Search (Name, Email, ID)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // FILTER 3: Service Type (via gigs)
        if ($request->filled('service_type')) {
            $query->whereHas('teacherGigs', function($q) use ($request) {
                $q->where('service_type', $request->service_type);
            });
        }

        // FILTER 4: Category
        if ($request->filled('category_id')) {
            $query->whereHas('teacherGigs', function($q) use ($request) {
                $q->where('category', $request->category_id);
            });
        }

        // FILTER 5: Location (Country/City)
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function($q) use ($location) {
                $q->where('country', 'like', "%{$location}%")
                  ->orWhere('city', 'like', "%{$location}%");
            });
        }

        // Load relationships and calculate aggregates
        $query->with([
            'expertProfile',
            'teacherGigs:id,user_id,title,service_type,service_role,category,category_name,sub_category,main_file',
            'sellerCommission:id,seller_id,commission_rate,is_active',
        ])
        ->withCount([
            'teacherGigs',
            'bookOrders',
            'sellerTransactions',
        ])
        ->withSum('sellerTransactions as total_earnings', 'seller_earnings')
        ->withAvg('receivedReviews as average_rating', 'rating')
        ->withCount('receivedReviews');

        // Check if export is requested
        if ($request->has('export') && $request->export == 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\SellersExport($query->get(), $status),
                'sellers_' . $status . '_' . now()->format('Y-m-d_His') . '.xlsx'
            );
        }

        // Get paginated sellers
        $sellers = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate Statistics for each status
        $stats = [
            'total_sellers' => User::where('role', 1)->count(),
            'active_sellers' => User::where('role', 1)->where('status', User::STATUS_ACTIVE)->count(),
            'hidden_sellers' => User::where('role', 1)->where('status', User::STATUS_HIDDEN)->count(),
            'paused_sellers' => User::where('role', 1)->where('status', User::STATUS_PAUSED)->count(),
            'banned_sellers' => User::where('role', 1)->where('status', User::STATUS_BANNED)->count(),
            'deleted_sellers' => User::where('role', 1)->onlyTrashed()->count(),
            'sellers_this_month' => User::where('role', 1)
                ->whereMonth('created_at', now()->month)->count(),
            'total_services' => \App\Models\TeacherGig::count(),
            'total_orders' => \App\Models\BookOrder::count(),
            'total_revenue' => \App\Models\Transaction::where('status', 'completed')
                ->sum('total_amount'),
        ];

        // Get categories for filter dropdown
        $categories = \App\Models\Category::orderBy('category')->get(['id', 'category']);

        return view('Admin-Dashboard.all-sellers', compact('sellers', 'stats', 'categories', 'status'));
    }

    /**
     * Update seller status (hide, pause, ban, activate)
     */
    public function updateSellerStatus(Request $request, $id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $request->validate([
            'status' => 'required|in:0,2,3,4', // 0=active, 2=hidden, 3=paused, 4=banned
        ]);

        try {
            $seller = User::findOrFail($id);
            $seller->status = $request->status;
            $seller->save();

            $statusText = [
                0 => 'activated',
                2 => 'hidden',
                3 => 'paused',
                4 => 'banned'
            ];

            return redirect()->back()->with('success', 'Seller ' . $statusText[$request->status] . ' successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update seller status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update seller status.');
        }
    }

    /**
     * Delete seller (soft delete)
     */
    public function deleteSeller($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $seller = User::findOrFail($id);
            $seller->delete(); // Soft delete

            return redirect()->back()->with('success', 'Seller deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete seller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete seller.');
        }
    }

    /**
     * Restore deleted seller
     */
    public function restoreSeller($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $seller = User::withTrashed()->findOrFail($id);
            $seller->restore();
            $seller->status = User::STATUS_ACTIVE; // Set to active
            $seller->save();

            return redirect()->back()->with('success', 'Seller restored successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to restore seller: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to restore seller.');
        }
    }

    /**
     * All Services Management
     */
    public function allServices(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Handle Excel Export
        if ($request->has('export')) {
            return Excel::download(new \App\Exports\ServicesExport($request->all()), 'services-' . date('Y-m-d') . '.xlsx');
        }

        // Get filter parameters
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $seller_id = $request->get('seller_id');
        $service_type = $request->get('service_type');
        $service_role = $request->get('service_role');
        $category = $request->get('category');
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');

        // Base query
        $query = \App\Models\TeacherGig::query();

        // Load relationships with correct column names
        $query->with([
            'user:id,first_name,last_name,email,status,deleted_at',
            'teacherGigData:id,gig_id,description',
            'all_reviews:id,gig_id,rating,cmnt',
        ])
        ->withCount('all_reviews')
        ->withAvg('all_reviews', 'rating')
        ->withSum('transactions', 'seller_earnings');

        // Status-based filtering
        switch ($status) {
            case 'newly_created':
                $query->where('status', 0);
                break;
            case 'active':
                $query->where('status', 1);
                break;
            case 'delivered':
                $query->where('status', 2);
                break;
            case 'cancelled':
                $query->where('status', 3);
                break;
            case 'completed':
                $query->where('status', 4);
                break;
            case 'all':
            default:
                // No status filter
                break;
        }

        // Seller ID filter (important for seller_id=5 parameter)
        if ($seller_id) {
            $query->where('user_id', $seller_id);
        }

        // Search filter (title, category_name, sub_category)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('category_name', 'like', '%' . $search . '%')
                  ->orWhere('sub_category', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Service type filter
        if ($service_type) {
            $query->where('service_type', $service_type);
        }

        // Service role filter
        if ($service_role) {
            $query->where('service_role', $service_role);
        }

        // Category filter
        if ($category) {
            $query->where('category', $category);
        }

        // Date range filter
        if ($date_from) {
            $query->whereDate('created_at', '>=', $date_from);
        }
        if ($date_to) {
            $query->whereDate('created_at', '<=', $date_to);
        }

        // Get paginated results
        $services = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->query());

        // Calculate statistics
        $stats = [
            'total_services' => \App\Models\TeacherGig::count(),
            'newly_created' => \App\Models\TeacherGig::where('status', 0)->count(),
            'active' => \App\Models\TeacherGig::where('status', 1)->count(),
            'delivered' => \App\Models\TeacherGig::where('status', 2)->count(),
            'cancelled' => \App\Models\TeacherGig::where('status', 3)->count(),
            'completed' => \App\Models\TeacherGig::where('status', 4)->count(),
            'total_revenue' => \App\Models\Transaction::where('service_type', 'service')->sum('total_admin_commission'),
        ];

        // Get unique categories from teacher_gigs table (using category column)
        $categories = \App\Models\TeacherGig::whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Get unique sellers (users with teacher_gigs)
        $sellers = \App\Models\User::whereHas('teacherGigs')
            ->orderBy('first_name')
            ->get(['id', 'first_name', 'last_name']);

        return view('Admin-Dashboard.all-services', compact('services', 'stats', 'categories', 'sellers'));
    }

    /**
     * Update service status
     */
    public function updateServiceStatus(Request $request, $id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $service = \App\Models\TeacherGig::findOrFail($id);
            $service->status = $request->status;
            $service->save();

            return redirect()->back()->with('success', 'Service status updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update service status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update service status.');
        }
    }

    /**
     * Set custom commission for service
     */
    public function setServiceCommission(Request $request, $id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $service = \App\Models\TeacherGig::findOrFail($id);

            // Create or update service commission
            \App\Models\ServiceCommission::updateOrCreate(
                ['service_id' => $id],
                [
                    'commission_rate' => $request->commission_rate,
                    'is_active' => $request->has('is_active') ? 1 : 0,
                    'notes' => $request->notes,
                ]
            );

            return redirect()->back()->with('success', 'Service commission updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to set service commission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update service commission.');
        }
    }

    /**
     * Toggle service visibility (pause/unpause)
     */
    public function toggleServiceVisibility(Request $request, $id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        try {
            $service = \App\Models\TeacherGig::findOrFail($id);

            // Toggle between active (1) and paused (0)
            $service->status = $service->status == 1 ? 0 : 1;
            $service->save();

            return redirect()->back()->with('success', 'Service visibility toggled successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to toggle service visibility: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to toggle service visibility.');
        }
    }

    /**
     * Buyer Management
     */
    public function buyerManagement()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $buyers = User::where('role', 0)
            ->withCount('bookOrders')
            ->withSum('buyerTransactions as total_spent', 'total_amount')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('Admin-Dashboard.buyer-management', compact('buyers'));
    }

    /**
     * All Orders Management
     */
    public function allOrders()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $orders = \App\Models\BookOrder::with(['user', 'teacher', 'gig'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Order status counts
        $statusCounts = [
            'pending' => \App\Models\BookOrder::where('status', 0)->count(),
            'active' => \App\Models\BookOrder::where('status', 1)->count(),
            'delivered' => \App\Models\BookOrder::where('status', 2)->count(),
            'completed' => \App\Models\BookOrder::where('status', 3)->count(),
            'cancelled' => \App\Models\BookOrder::where('status', 4)->count(),
        ];

        return view('Admin-Dashboard.All-orders', compact('orders', 'statusCounts'));
    }

    /**
     * Payout Details
     */
    public function payoutDetails()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $payouts = \App\Models\Transaction::where('payout_status', 'pending')
            ->where('status', 'completed')
            ->with(['seller', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'pending_amount' => \App\Models\Transaction::where('payout_status', 'pending')
                ->where('status', 'completed')
                ->sum('seller_earnings'),
            'pending_count' => \App\Models\Transaction::where('payout_status', 'pending')
                ->where('status', 'completed')
                ->count(),
            'completed_amount' => \App\Models\Transaction::where('payout_status', 'completed')
                ->sum('seller_earnings'),
            'completed_count' => \App\Models\Transaction::where('payout_status', 'completed')
                ->count(),
        ];

        return view('Admin-Dashboard.payout-details', compact('payouts', 'stats'));
    }

    /**
     * Refund Details
     */
    public function refundDetails()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $refunds = \App\Models\Transaction::where('status', 'refunded')
            ->with(['seller', 'buyer', 'bookOrder'])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_refunded' => \App\Models\Transaction::where('status', 'refunded')
                ->sum('total_amount'),
            'refund_count' => \App\Models\Transaction::where('status', 'refunded')
                ->count(),
            'pending_disputes' => \App\Models\DisputeOrder::where('status', 0)->count(),
        ];

        return view('Admin-Dashboard.refund-details', compact('refunds', 'stats'));
    }

    /**
     * Invoice & Statement
     */
    public function invoice(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Base query with relationships
        $query = \App\Models\Transaction::with([
            'seller:id,first_name,last_name,email',
            'buyer:id,first_name,last_name,email',
            'bookOrder.gig:id,title,service_role,service_type'
        ]);

        // FILTER 1: Date Range Filter
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

        // FILTER 2: Search (Seller/Buyer name, Transaction ID)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('seller', function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('buyer', function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('stripe_transaction_id', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // FILTER 3: Service Type
        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        // FILTER 4: Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER 5: Payout Status Filter
        if ($request->filled('payout_status')) {
            $query->where('payout_status', $request->payout_status);
        }

        // Check if export is requested
        if ($request->has('export') && $request->export == 'excel') {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\TransactionsExport($query->get()),
                'transactions_' . now()->format('Y-m-d_His') . '.xlsx'
            );
        }

        // Get paginated transactions
        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Calculate Statistics
        $stats = [
            'total_transactions' => \App\Models\Transaction::count(),
            'monthly_revenue' => \App\Models\Transaction::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('total_admin_commission'),
            'total_revenue' => \App\Models\Transaction::where('status', 'completed')
                ->sum('total_admin_commission'),
            'pending_payouts' => \App\Models\Transaction::where('payout_status', 'pending')
                ->where('status', 'completed')
                ->sum('total_admin_commission'),
            'transactions_this_month' => \App\Models\Transaction::whereMonth('created_at', now()->month)
                ->count(),
            'refunded_amount' => \App\Models\Transaction::where('status', 'refunded')
                ->sum('total_amount'),
        ];

        return view('Admin-Dashboard.invoice', compact('transactions', 'stats'));
    }

    /**
     * Download Transaction Invoice PDF
     */
    public function downloadInvoice($id)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $transaction = \App\Models\Transaction::with(['seller', 'buyer', 'bookOrder.gig'])
            ->findOrFail($id);

        $pdf = \PDF::loadView('Admin-Dashboard.TransactionInvoice', compact('transaction'));

        return $pdf->download('invoice_' . $transaction->id . '_' . now()->format('Ymd') . '.pdf');
    }

    /**
     * Reviews & Ratings
     */
    public function reviewsRatings(Request $request)
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        // Base query with relationships
        $query = \App\Models\ServiceReviews::with([
            'user:id,first_name,last_name,email,profile',
            'teacher:id,first_name,last_name,email,profile',
            'gig:id,title,service_role,service_type,main_file',
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

        return view('Admin-Dashboard.reviews&rating', compact('reviews', 'stats'));
    }

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

    /**
     * Seller Reports
     */
    public function sellerReports()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $sellers = User::where('role', 1)
            ->with('expertProfile')
            ->withCount('teacherGigs')
            ->withCount('bookOrders')
            ->withSum('sellerTransactions as total_earnings', 'seller_earnings')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_sellers' => User::where('role', 1)->count(),
            'active_sellers' => User::where('role', 1)->whereHas('teacherGigs', function($q) {
                $q->where('status', 1);
            })->count(),
            'total_services' => \App\Models\TeacherGig::count(),
            'total_revenue' => \App\Models\Transaction::where('status', 'completed')->sum('seller_earnings'),
        ];

        return view('Admin-Dashboard.seller-reports', compact('sellers', 'stats'));
    }

    /**
     * Buyer Reports
     */
    public function buyerReports()
    {
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;
        }

        $buyers = User::where('role', 0)
            ->withCount('bookOrders')
            ->withSum('buyerTransactions as total_spent', 'total_amount')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_buyers' => User::where('role', 0)->count(),
            'active_buyers' => User::where('role', 0)->whereHas('bookOrders')->count(),
            'total_orders' => \App\Models\BookOrder::count(),
            'total_revenue' => \App\Models\Transaction::where('status', 'completed')->sum('total_amount'),
        ];

        return view('Admin-Dashboard.Buyer-reports', compact('buyers', 'stats'));
    }
}
