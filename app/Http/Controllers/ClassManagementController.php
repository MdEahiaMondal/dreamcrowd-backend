<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ExpertProfile;
use App\Models\ServicesFaqs;
use App\Models\SiteBanner;
use App\Models\SubCategory;
use App\Models\TeacherGig;
use App\Models\TeacherGigData;
use App\Models\TeacherGigPayment;
use App\Models\TeacherReapetDays;
use App\Models\TopSellerTag;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

class ClassManagementController extends Controller
{

    // Authentication Check Function Start====

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

    // Authentication Check Function END====


    public function ClassManagement()
    {
        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $serviceSelect = 'All,All';

        $gigs = TeacherGig::where(['user_id' => Auth::user()->id])->orderBy('updated_at', 'desc')->get();


        if (count($gigs) > 0) {
            return view("Teacher-Dashboard.Class-management", compact('gigs', 'serviceSelect'));
        } else {
            return view("Teacher-Dashboard.Result");
        }

    }


    public function ClassManagementServices(Request $request)
    {
        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $serviceSelect = $request->get('service_select', 'All,All');

        list($serviceRole, $serviceType) = explode(',', $serviceSelect);

        $gigs = TeacherGig::where(['user_id' => Auth::user()->id])->orderBy('updated_at', 'desc')->get();

        $query = TeacherGig::where('user_id', Auth::user()->id);

        // Filter by service_role if it's not "All"
        if ($serviceRole !== 'All') {
            $query->where('service_role', $serviceRole);
        }

        // Filter by service_type if it's not "All"
        if ($serviceType !== 'All') {
            $query->where('service_type', $serviceType);
        }

        // Get the filtered services
        $gigs = $query->get();

        if (count($gigs) > 0) {
            return view("Teacher-Dashboard.Class-management", compact('gigs', 'serviceSelect'));
        } else {
            return view("Teacher-Dashboard.Result");
        }

    }


    public function ClassServiceSelect()
    {
        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        return view("Teacher-Dashboard.Class-RADIO-2");
    }


    public function SelectServiceType(Request $request)
    {
        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $profile = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

        if ($request->action == 'Role') {

            if ($profile->service_role != 'Both') {

                if ($profile->service_role != $request->engine) {
                    return redirect()->to('/teacher-add-new-category/' . $profile->id)->with('error', 'Please Update Service First!');
                }

            }

            $role = $request->engine;

            return view("Teacher-Dashboard.Class-RADIO-1", compact('role'));
        } else {


            if ($profile->service_type != 'Both') {

                if ($profile->service_type != $request->engine) {
                    return redirect()->to('/teacher-add-new-category/' . $profile->id)->with('error', 'Please Update Service First!');
                }

            }

            $banner = SiteBanner::all();
            $role = $request->role;
            $type = $request->engine;
            if ($request->role == 'Class') {

                $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

                if ($app->category_class == null) {
                    return redirect()->to('/teacher-add-new-category/' . $app->id)->with('error', 'Please Add Categories For Class!');
                }

                $categoryIds = explode(',', $app->category_class);


                if ($request->engine == 'Online') {
                    $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('category')->toArray();
                    $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('id')->toArray();

                    return view("Teacher-Dashboard.Learn-How", compact('categories', 'categoryIds', 'banner', 'role', 'type'));
                } else {
                    $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('category')->toArray();
                    $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('id')->toArray();

                    return view("Teacher-Dashboard.Learn-How", compact('categories', 'categoryIds', 'banner', 'role', 'type'));
                }
            } else {


                $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

                if ($app->category_freelance == null) {
                    return redirect()->to('/teacher-add-new-category/' . $app->id)->with('error', 'Please Add Categories For Freelance!');
                }

                $categoryIds = explode(',', $app->category_freelance);


                if ($request->engine == 'Online') {
                    $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('category')->toArray();
                    $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('id')->toArray();

                    return view("Teacher-Dashboard.Learn-How-5", compact('categories', 'categoryIds', 'banner', 'role', 'type'));
                } else {
                    $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('category')->toArray();
                    $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('id')->toArray();

                    return view("Teacher-Dashboard.Learn-How-5", compact('categories', 'categoryIds', 'banner', 'role', 'type'));
                }
            }


        }


    }


    public function GetClassManageSubCates(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        if ($request->role == 'Class') {
            $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();
            $have_sub = explode('|*|', $app->sub_category_class);
            if ($request->type == 'Online') {
                $have_sub = explode(',', $have_sub[0]);
            } else {
                $have_sub = explode(',', $have_sub[1]);
            }


            $have_sub = array_map('trim', $have_sub);
            $sub_cates = SubCategory::where(['cate_id' => $request->category])->pluck('sub_category');
        } else {
            $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();
            $have_sub = explode('|*|', $app->sub_category_freelance);
            if ($request->type == 'Online') {
                $have_sub = explode(',', $have_sub[0]);
            } else {
                $have_sub = explode(',', $have_sub[1]);
            }
            $have_sub = array_map('trim', $have_sub);
            $sub_cates = SubCategory::where(['cate_id' => $request->category])->pluck('sub_category');
        }

        $array1 = collect($have_sub);
        $array2 = collect($sub_cates);

        // Convert collections to arrays using `toArray()` method
        $array1 = $array1->toArray();
        $array2 = $array2->toArray();

        // Use array_intersect to get common elements
        $commonCates = array_intersect($array1, $array2);
        $sub_cates = array_values(array_unique($commonCates));
        $response['sub_cates'] = $sub_cates;

        return response()->json($response);


    }


    public function ClassPaymentSet()
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $gig_id = session('gig_id');
        $gig = TeacherGig::find($gig_id);
        $gigData = TeacherGigData::where('gig_id', '=', $gig_id)->first();
        $role = session('role');
        $type = session('type');
        $lesson_type = session('lesson_type');
        $commission = TopSellerTag::first()->commission ?? 12;


        if ($role == 'Class') {
            if ($lesson_type == 'One' || $gigData->class_type == 'Video') {
                return view("Teacher-Dashboard.payment-1", [
                    'gig_id' => $gig_id,
                    'gig' => $gig,
                    'gigData' => $gigData,
                    'commission' => $commission,
                    'success' => 'Gig Data Uploaded, Please Set Payment Details For Publish Your Service!'
                ]);
            } else {
                return view("Teacher-Dashboard.payment", [
                    'gig_id' => $gig_id,
                    'gig' => $gig,
                    'gigData' => $gigData,
                    'commission' => $commission,
                    'success' => 'Gig Data Uploaded, Please Set Payment Details For Publish Your Service!'
                ]);
            }

        } else if ($role == 'Freelance') {
            return view("Teacher-Dashboard.payment-2", [
                'gig_id' => $gig_id,
                'gig' => $gig,
                'gigData' => $gigData,
                'commission' => $commission,
                'success' => 'Gig Data Uploaded, Please Set Payment Details For Publish Your Service!'
            ]);
        } else {
            return redirect()->to('/class-management');
        }

    }

// Gig Data Upload
    public function ClassGigDataUpload(Request $request)
    {
        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $category = Category::find($request->category);

        $gig = new TeacherGig();

        $gig->user_id = Auth::user()->id;
        $gig->title = $request->title;
        $gig->service_role = $request->role;
        $gig->service_type = $request->type;

        $gigData = new TeacherGigData();

        $gigData->payment_type = $request->payment_type;
        $gig->payment_type = $request->payment_type;

        if ($request->role == 'Class') {

            $gigData->description = $request->description;
            $gigData->requirements = $request->requirements;

            if ($request->type == 'Online') {

                $gigData->class_type = $request->class_type;
                $gig->class_type = $request->class_type;

                if ($request->class_type == 'Video') {
                    $gigData->course = $request->course_input;
                    $gigData->resource = $request->resource_input;

                } else {
                    $gigData->lesson_type = $request->lesson_type;
                    $gig->lesson_type = $request->lesson_type;
                    $gigData->recurring_type = $request->recurring_type;

                    $gigData->meeting_platform = $request->meeting_platform;
                    $gig->meeting_platform = $request->meeting_platform;

                    if ($request->recurring_type == 'Trial') {
                        if ($request->class_type != 'Live') {
                            return back()->with('error', 'Trial class must be Live class');
                        }

                        if ($request->payment_type != 'OneOff') {
                            return back()->with('error', 'Trial class cannot be subscription');
                        }

                        $gigData->trial_type = $request->trial_type;
                        $gig->trial_type = $request->trial_type;
                    }

                    if ($request->lesson_type == 'Group') {
                        $gigData->group_type = $request->group_type;
                    }
                }

            } else {
                $gigData->lesson_type = $request->lesson_type;
                $gig->lesson_type = $request->lesson_type;

                $gigData->service_delivery = $request->service_delivery;

                if ($request->service_delivery == 0) {
                    $gigData->max_distance = $request->max_distance;
                } else if ($request->service_delivery == 1) {
                    $gigData->work_site = $request->work_site;
                } else {
                    $gigData->max_distance = $request->max_distance;
                    $gigData->work_site = $request->work_site;
                }

                if ($request->lesson_type == 'Group') {
                    $gigData->group_type = $request->group_type;
                }
            }

        } else {
            $gigData->freelance_type = $request->freelance_type;
            $gig->freelance_type = $request->freelance_type;

            if ($request->freelance_type == 'Both') {
                $gigData->description = $request->description . '|*|' . $request->description_2;
                $gigData->requirements = $request->requirements . '|*|' . $request->requirements_2;
            } else {
                $gigData->description = $request->description;
                $gigData->requirements = $request->requirements;
            }

            $gigData->freelance_service = $request->freelance_service;
            $gig->freelance_service = $request->freelance_service;

            if ($request->type == 'Online') {

                if ($request->freelance_service == 'Consultation') {
                    $gigData->video_call = $request->video_call;
                }

            } else {

                $gigData->service_delivery = $request->service_delivery;

                if ($request->service_delivery == 0) {
                    $gigData->max_distance = $request->max_distance;
                } else if ($request->service_delivery == 1) {
                    $gigData->work_site = $request->work_site;
                } else {
                    $gigData->max_distance = $request->max_distance;
                    $gigData->work_site = $request->work_site;
                }
            }
        }

        if ($request->hasfile('main_file')) {
            $main_file = $request->main_file;
            $main_fileName = $main_file->getClientOriginalName();
            $main_file->move(public_path() . '/assets/teacher/listing/data_' . Auth::user()->id . '/media', $main_fileName);
            $main_fileData = $main_fileName;

            $gigData->main_file = $main_fileData;
            $gig->main_file = $main_fileData;
        }

        if ($request->hasfile('other')) {

            $other_array = [];
            foreach ($request->other as $key => $value) {
                $other = $value;
                $otherName = $other->getClientOriginalName();
                $other->move(public_path() . '/assets/teacher/listing/data_' . Auth::user()->id . '/media', $otherName);
                $otherData = $otherName;
                $other_array[] = $otherData;
            }

            $other = implode(',_,', $other_array);
            $gigData->other = $other;
        }

        if ($request->hasfile('video')) {
            $video = $request->video;
            $videoName = $video->getClientOriginalName();
            $video->move(public_path() . '/assets/teacher/listing/data_' . Auth::user()->id . '/media', $videoName);
            $videoData = $videoName;

            $gigData->video = $videoData;
        }

        $gig->category_name = $category->category;
        $gig->category = $request->category;
        $gig->sub_category = $request->sub_category;

        $gig->save();

        $gigData->gig_id = $gig->id;
        $gigData->category = $request->category;
        $gigData->sub_category = $request->sub_category;
        $gigData->experience_level = $request->experience_level;
        $gigData->title = $request->title;

        $gigData->save();

        $gig_id = $gig->id;
        $role = $request->role;
        $type = $request->type;
        $lesson_type = $request->lesson_type;

        setcookie("gig_id", $gig_id, time() + 86400);

        return redirect()->to('/class-payment-set')->with([
            'gig_id' => $gig_id,
            'role' => $role,
            'type' => $type,
            'lesson_type' => $lesson_type
        ]);
    }

    // Gig Payment Upload ====
    public function ClassGigPaymentUpload(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $gig = TeacherGig::find($request->gig_id);
        $gigData = TeacherGigData::where(['gig_id' => $request->gig_id])->first();
        $payment = new TeacherGigPayment();


        $payment->gig_id = $request->gig_id;

        if ($gig->service_role == 'Class') {


            if ($gig->class_type == 'Video' || $gig->lesson_type == 'One') {

                $gig->rate = $request->rate;
                $payment->rate = $request->rate;
                $payment->earning = $request->earning;


            } else {

                if (in_array($gigData->group_type, ['Public', 'Both'])) {
                    $gig->private_rate = $request->private_rate;
                    $payment->public_rate = $request->public_rate;
                    $payment->public_earning = $request->public_earning;
                    $payment->public_group_size = $request->public_group_size;
                    $payment->public_discount = $request->public_discount;
                }

                if (in_array($gigData->group_type, ['Private', 'Both'])) {
                    $gig->private_rate = $request->private_rate;
                    $payment->private_rate = $request->private_rate;
                    $payment->private_earning = $request->private_earning;
                    $payment->private_group_size = $request->private_group_size;
                    $payment->private_discount = $request->private_discount;
                }


            }

            $payment->minor_attend = $request->minor_attend;
            if ($request->minor_attend == 1) {
                $payment->age_limit = $request->age_limit;
                $payment->childs = $request->childs;
            }

            $payment->positive_term = $request->positive_term;

            if ($gig->class_type == 'Video') {
                $payment->duration = $request->duration;
            } else {
                $payment->duration = $request->durationH . ':' . $request->durationM;
            }


            //   Repeat On Day Insert

            if ($gigData->recurring_type == 'OneDay') {

                $gig->start_date = $request->start_date;
                $gig->start_time = $request->start_time;

                $payment->start_date = $request->start_date;
                $payment->start_time = $request->start_time;
                $payment->end_time = $request->end_time;
                $gig->status = 1;
            } else {

                $gig->status = 1;
                if ($request->day_repeat != null) {
                    $i = 0;
                    foreach ($request->day_repeat as $key => $value) {
                        $day = TeacherReapetDays::create([
                            'gig_id' => $request->gig_id,
                            'day' => $value,
                            'start_time' => $request->start_repeat[$key],
                            'end_time' => $request->end_repeat[$key],
                        ]);
                    }
                }

            }


        } else {


            if ($gigData->freelance_type == 'Both') {
                $gig->rate = $request->rate . '|*|' . $request->rate_2;
                $payment->rate = $request->rate . '|*|' . $request->rate_2;
                $payment->earning = $request->earning . '|*|' . $request->earning;

                if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal') {
                    $payment->duration = $request->durationH . ':' . $request->durationM . '|*|' . $request->durationH_2 . ':' . $request->durationM_2;
                } else {
                    $payment->delivery_time = $request->delivery_time . '|*|' . $request->delivery_time_2;
                    $gig->delivery_time = $request->delivery_time . '|*|' . $request->delivery_time_2;
                }
                $payment->revision = $request->revision . '|*|' . $request->revision_2;
                $gig->revision = $request->revision . '|*|' . $request->revision_2;

            } else {
                $gig->rate = $request->rate;
                $payment->rate = $request->rate;
                $payment->earning = $request->earning;

                $payment->delivery_time = $request->delivery_time;
                $gig->delivery_time = $request->delivery_time;
                $payment->revision = $request->revision;
                $gig->revision = $request->revision;
            }


            $payment->positive_term = $request->positive_term;
            $payment->full_available = $request->full_available;
            $gig->full_available = $request->full_available;


            if ($gig->service_type != 'Inperson' && $gigData->freelance_service != 'Normal') {

                if ($gigData->freelance_service == 'Consultation') {
                    $payment->duration = $request->durationH . ':' . $request->durationM;
                }
            }


            if ($request->full_available == 0) {
                $i = 0;
                foreach ($request->day_repeat as $key => $value) {
                    $day = TeacherReapetDays::create([
                        'gig_id' => $request->gig_id,
                        'day' => $value,
                        'start_time' => $request->start_repeat[$key],
                        'end_time' => $request->end_repeat[$key],
                    ]);
                }
            }

            $gig->status = 1;


        }


        $payment->save();

        $gig->update();


        if ($payment) {
            setcookie("gig_id", "", time() - 3600, "/"); // Expire the cookie
            return redirect()->to('/class-management')->with('success', 'Your Service Published Successfuly!');
        } else {
            return redirect()->to('/class-management')->with('error', 'Something Went Rong, Try Again Later!');

        }


    }


    // Upload Course Videos Function Start==========

    public function CourseVideoUpload(Request $request)
    {
        // Validate the video file
        $request->validate([
            'video' => 'required|mimetypes:video/mp4,video/mkv|max:1024000', // 1 GB limit
        ]);

        // Store the video in the 'public/assets/teacher/listing/data_{user_id}/course' directory
        if ($request->hasFile('video')) {
            $video = $request->file('video'); // Get the uploaded video file
            $videoName = time() . '_' . $video->getClientOriginalName(); // Generate a unique file name

            // Create the directory path using user ID
            $path = public_path('/assets/teacher/listing/data_' . Auth::user()->id . '/course');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); // Create the directory if it doesn't exist
            }

            // Move the video to the specified directory
            $video->move($path, $videoName);

            // Return the video data in JSON response to use in the front end
            return response()->json([
                'success' => true,
                'video_name' => $videoName,
                'video_url' => asset('assets/teacher/listing/data_' . Auth::user()->id . '/course/' . $videoName)
            ]);
        }

        return response()->json(['error' => 'No video uploaded.'], 400);
    }


    // Upload Course Videos Function END==========

    // Delete Course Videos Function Start==========

    public function CourseVideoDelete(Request $request)
    {
        $fileName = $request->input('fileName');
        $filePath = public_path('/assets/teacher/listing/data_' . Auth::user()->id . '/course/' . $fileName);

        // Check if the file exists and delete it
        if (File::exists($filePath)) {
            File::delete($filePath);
            return response()->json(['message' => 'Video deleted'], 200);
        }

        return response()->json(['error' => 'File not found'], 404);
    }


    // Delete Course Videos Function END==========

    // Upload Resource File Function Start==========

    public function TeacherResourceUpload(Request $request)
    {
        // Validate the ZIP file
        $request->validate([
            'zip' => 'required|mimes:zip|max:1024000', // 1 GB limit
        ]);

        if ($request->hasFile('zip')) {
            $zip = $request->file('zip');
            $zipName = time() . '_' . $zip->getClientOriginalName();

            // Create the directory path using user ID
            $path = public_path('/assets/teacher/listing/data_' . Auth::user()->id . '/resource');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // Move the ZIP to the specified directory
            $zip->move($path, $zipName);

            // Return the zip data in JSON response
            return response()->json([
                'success' => true,
                'zip_name' => $zipName,
                'zip_url' => asset('assets/teacher/listing/data_' . Auth::user()->id . '/resource/' . $zipName)
            ]);
        }

        return response()->json(['error' => 'No zip uploaded.'], 400);
    }


    // Upload Resource File Function END==========

    // Delete Resource File Function Start==========

    public function TeacherResourceDelete(Request $request)
    {
        $fileName = $request->input('fileName');
        $filePath = public_path('/assets/teacher/listing/data_' . Auth::user()->id . '/resource/' . $fileName);

        if (File::exists($filePath)) {
            File::delete($filePath);
            return response()->json(['message' => 'ZIP deleted'], 200);
        }

        return response()->json(['error' => 'File not found'], 404);
    }


    // Delete Resource File Function END==========


    // Gig Action Function Start ======
    public function TeacherGigAction($id, $action)
    {

        $gig = TeacherGig::find($id);

        if ($action == 'deletepermanent') {

            $gigData = TeacherGigData::where(['gig_id' => $id])->first();
            $gigPayment = TeacherGigPayment::where(['gig_id' => $id])->first();
            $gigdays = TeacherReapetDays::where(['gig_id' => $id])->get();

            if ($gigData) {
                $gigData->delete();
            }
            if ($gigPayment) {
                $gigPayment->delete();
            }
            if ($gigdays) {
                foreach ($gigdays as $key => $value) {
                    $gigPayment->delete();
                }

            }

            $gig->delete();

            if ($gig) {
                return redirect()->back()->with('success', 'Service Permanently Deleted!');
            } else {
                return redirect()->back()->with('error', 'Something Went Rong, Try Again Later!');
            }


        }


        if ($action == 'hide') {
            $gig->status = 3;
        } elseif ($action == 'delete') {
            $gig->status = 4;
        } elseif ($action == 'publish') {
            $gig->status = 1;
        }

        $gig->update();
        if ($gig) {

            if ($action == 'hide') {
                return redirect()->back()->with('success', 'Your Service Sent to Hide!');
            } elseif ($action == 'delete') {
                return redirect()->back()->with('success', 'Your Service Deleted Successfuly!');
            } elseif ($action == 'publish') {
                return redirect()->back()->with('success', 'Your Service Published Successfuly!');
            }


        } else {
            return redirect()->back()->with('error', 'Something Went Rong, Try Again Later!');
        }


    }
    // Gig Action Function End ======

    // Service Draft Edit Function Start ========
    public function TeacherServiceEdit($id, $action)
    {


        $gig = TeacherGig::find($id);
        $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();
        $banner = SiteBanner::all();
        $selectedCate = Category::find($gigData->category);
        $sub_categories = SubCategory::where('cate_id', $gigData->category)->pluck('sub_category')->toArray();
        if ($gig->service_role == 'Class') {

            $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

            if ($app->category_class == null) {
                return redirect()->to('/teacher-add-new-category/' . $app->id)->with('error', 'Please Add Categories For Class!');
            }

            $categoryIds = explode(',', $app->category_class);


            if ($gig->service_type == 'Online') {
                $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('category')->toArray();
                $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('id')->toArray();


                return view("Teacher-Dashboard.edit-Learn-How", compact('categories', 'sub_categories', 'categoryIds', 'banner', 'selectedCate', 'gig', 'gigData'));
            } else {
                $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('category')->toArray();
                $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('id')->toArray();

                return view("Teacher-Dashboard.edit-Learn-How", compact('categories', 'sub_categories', 'categoryIds', 'banner', 'selectedCate', 'gig', 'gigData'));
            }
        } else {


            $app = ExpertProfile::where(['user_id' => Auth::user()->id, 'status' => 1])->first();

            if ($app->category_freelance == null) {
                return redirect()->to('/teacher-add-new-category/' . $app->id)->with('error', 'Please Add Categories For Freelance!');
            }

            $categoryIds = explode(',', $app->category_freelance);


            if ($gig->service_type == 'Online') {
                $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('category')->toArray();
                $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Online')->pluck('id')->toArray();

                return view("Teacher-Dashboard.edit-Learn-How-5", compact('categories', 'sub_categories', 'categoryIds', 'banner', 'selectedCate', 'gig', 'gigData'));
            } else {
                $categories = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('category')->toArray();
                $categoryIds = Category::whereIn('id', $categoryIds)->where('service_type', 'Inperson')->pluck('id')->toArray();

                return view("Teacher-Dashboard.edit-Learn-How-5", compact('categories', 'sub_categories', 'categoryIds', 'banner', 'selectedCate', 'gig', 'gigData'));
            }
        }


    }

    // Update Function Service Data Start
    // Gig Data Upload
    public function ClassGigDataUpdate(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $category = Category::find($request->category);

        $gig = TeacherGig::find($request->gig_id);

        $gig->title = $request->title;
        $gig->category = $request->category;
        $gig->category_name = $category->category;
        $gig->sub_category = $request->sub_category;


        if ($gig) {

            $gigData = TeacherGigData::where(['gig_id' => $gig->id])->first();

            $gigData->experience_level = $request->experience_level;
            $gigData->payment_type = $request->payment_type;
            $gig->payment_type = $request->payment_type;


            $gigData->category = $request->category;
            $gigData->sub_category = $request->sub_category;
            $gigData->title = $request->title;


            if ($request->role == 'Class') {

                $gigData->description = $request->description;
                $gigData->requirements = $request->requirements;

                // Class Online Data Update
                if ($request->type == 'Online') {

                    $gigData->class_type = $request->class_type;
                    $gig->class_type = $request->class_type;

                    if ($request->class_type == 'Video') {
                        $gigData->course = $request->course_input;
                        $gigData->resource = $request->resource_input;

                        $gigData->lesson_type = null;
                        $gig->lesson_type = null;
                        $gigData->recurring_type = null;
                        $gigData->group_type = null;

                    } else {

                        $gigData->course = null;
                        $gigData->resource = null;


                        $gigData->lesson_type = $request->lesson_type;
                        $gig->lesson_type = $request->lesson_type;
                        $gigData->recurring_type = $request->recurring_type;

                        if ($request->lesson_type == 'Group') {
                            $gigData->group_type = $request->group_type;
                        } else {
                            $gigData->group_type = null;
                        }


                    }


                } else {

                    // Class Inperson Data Update
                    $gigData->lesson_type = $request->lesson_type;
                    $gig->lesson_type = $request->lesson_type;

                    $gigData->service_delivery = $request->service_delivery;

                    if ($request->service_delivery == 0) {
                        $gigData->max_distance = $request->max_distance;
                        $gigData->work_site = null;
                    } else if ($request->service_delivery == 1) {
                        $gigData->work_site = $request->work_site;
                        $gigData->max_distance = null;
                    } else {
                        $gigData->max_distance = $request->max_distance;
                        $gigData->work_site = $request->work_site;
                    }


                    if ($request->lesson_type == 'Group') {
                        $gigData->group_type = $request->group_type;
                    } else {
                        $gigData->group_type = null;
                    }

                }


            } else {


                $gigData->freelance_type = $request->freelance_type;
                $gig->freelance_type = $request->freelance_type;

                if ($request->freelance_type == 'Both') {
                    $gigData->description = $request->description . '|*|' . $request->description_2;
                    $gigData->requirements = $request->requirements . '|*|' . $request->requirements_2;
                } else {
                    $gigData->description = $request->description;
                    $gigData->requirements = $request->requirements;
                }


                $gigData->freelance_service = $request->freelance_service;
                $gig->freelance_service = $request->freelance_service;

                if ($request->type == 'Online') {

                    if ($request->freelance_service == 'Consultation') {
                        $gigData->video_call = $request->video_call;
                    } else {
                        $gigData->video_call = null;
                    }

                } else {


                    $gigData->service_delivery = $request->service_delivery;

                    if ($request->service_delivery == 0) {
                        $gigData->max_distance = $request->max_distance;
                        $gigData->work_site = null;
                    } else if ($request->service_delivery == 1) {
                        $gigData->work_site = $request->work_site;
                        $gigData->max_distance = null;
                    } else {
                        $gigData->max_distance = $request->max_distance;
                        $gigData->work_site = $request->work_site;
                    }


                }


                $payment = TeacherGigPayment::where(['gig_id' => $gig->id])->first();

                if ($payment) {
                    # code...

                    if ($request->freelance_type != 'Both') {
                        $rate = explode('|*|', $payment->rate);
                        $earning = explode('|*|', $payment->earning);
                        $delivery_time = explode('|*|', $payment->delivery_time);
                        $revision = explode('|*|', $payment->revision);


                        $gig->rate = $rate[0];
                        $payment->rate = $rate[0];
                        $payment->earning = $earning[0];

                        $payment->delivery_time = $delivery_time[0];
                        $gig->delivery_time = $delivery_time[0];
                        $payment->revision = $revision[0];
                        $gig->revision = $revision[0];

                        $payment->update();
                    }

                }


            }


            // Main File Upload ====
            if ($request->hasfile('main_file')) {
                $main_file = $request->main_file;
                $main_fileName = $main_file->getClientOriginalName();
                $main_file->move(public_path() . '/assets/teacher/listing/data_' . Auth::user()->id . '/media', $main_fileName);
                $main_fileData = $main_fileName;

                $gigData->main_file = $main_fileData;
                $gig->main_file = $main_fileData;
            }


            // Other Photos Upload ===
            if ($request->hasfile('other')) {

                $other_array = [];
                foreach ($request->other as $key => $value) {
                    $other = $value;
                    $otherName = $other->getClientOriginalName();
                    $other->move(public_path() . '/assets/teacher/listing/data_' . Auth::user()->id . '/media', $otherName);
                    $otherData = $otherName;
                    $other_array[] = $otherData;
                }

                $other = implode(',_,', $other_array);


                $gigData->other = $request->other_input;
            }


            // Video Upload ===
            if ($request->hasfile('video')) {
                $video = $request->video;
                $videoName = $video->getClientOriginalName();
                $video->move(public_path() . '/assets/teacher/listing/data_' . Auth::user()->id . '/media', $videoName);
                $videoData = $videoName;

                $gigData->video = $videoData;
            }


            $gig->status = 3;
            $gig->update();

            $gigData->update();


            $gig_id = $gig->id;
            $role = $gig->service_role;
            $type = $gig->service_type;
            $lesson_type = $gigData->lesson_type;
            $gigpayment = TeacherGigPayment::where(['gig_id' => $gig_id])->first();
            if ($gigpayment) {
                return redirect()->to('/class-payment-edit')->with(['gig_id' => $gig_id, 'role' => $role, 'type' => $type, 'lesson_type' => $lesson_type, 'success' => 'Gig Data Updated Successfully, For Active Gig Also Update Payment Type']);
            } else {
                return redirect()->to('/class-payment-set')->with(['gig_id' => $gig_id, 'role' => $role, 'type' => $type, 'lesson_type' => $lesson_type, 'success' => 'Gig Data Updated Successfully, For Active Gig Also Update Payment Type']);
            }


        } else {
            return redirect()->to('/class-management')->with('error', 'Something Went Rong,Tryagain Later!');
        }


    }
    // Update Function Service Data END


    // Payment Edit Function  Start


    public function ClassPaymentEdit()
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }

        $gig_id = session('gig_id');
        $role = session('role');
        $type = session('type');
        $commission = TopSellerTag::first()->commission ?? 12;
        $lesson_type = session('lesson_type');
        $gigPayment = TeacherGigPayment::where(['gig_id' => $gig_id])->first();
        $gigDays = TeacherReapetDays::where(['gig_id' => $gig_id])->get();

        $gig = TeacherGig::find($gig_id);
        $gigData = TeacherGigData::where('gig_id', '=', $gig_id)->first();

        if ($role == 'Class') {
            if ($lesson_type == 'One' || $gigData->class_type == 'Video') {
                return view("Teacher-Dashboard.edit-payment-1", [
                    'gig' => $gig,
                    'gigData' => $gigData,
                    'gig_id' => $gig_id,
                    'commission' => $commission,
                    'gigPayment' => $gigPayment,
                    'gigDays' => $gigDays,
                    'success' => 'Gig Data Updated!'
                ]);
            } else {
                return view("Teacher-Dashboard.edit-payment", [
                    'gig' => $gig,
                    'gigData' => $gigData,
                    'gig_id' => $gig_id,
                    'commission' => $commission,
                    'gigPayment' => $gigPayment,
                    'gigDays' => $gigDays,
                    'success' => 'Gig Data Updated!'
                ]);
            }

        } else if ($role == 'Freelance') {
            return view("Teacher-Dashboard.edit-payment-2", [
                'gig' => $gig,
                'gigData' => $gigData,
                'gig_id' => $gig_id,
                'commission' => $commission,
                'gigPayment' => $gigPayment,
                'gigDays' => $gigDays,
                'success' => 'Gig Data Updated, Please Set Payment Details For Publish Your Service!'
            ]);
        } else {
            return redirect()->to('/class-management');
        }

    }


    // Payment Edit Function  END

    // Payment Update Function  Start

    // Gig Payment Upload ====
    public function ClassGigPaymentUpdate(Request $request)
    {

        if ($redirect = $this->TeachercheckAuth()) {
            return $redirect;
        }


        $gig = TeacherGig::find($request->gig_id);
        $gigData = TeacherGigData::where(['gig_id' => $request->gig_id])->first();
        $payment = TeacherGigPayment::where(['gig_id' => $gig->id])->first();


        if ($gig->service_role == 'Class') {


            if ($gig->class_type == 'Video' || $gig->lesson_type == 'One') {

                $gig->rate = $request->rate;
                $payment->rate = $request->rate;
                $payment->earning = $request->earning;

                $gig->public_rate = null;
                $payment->public_rate = null;
                $payment->public_earning = null;
                $payment->public_group_size = null;
                $payment->public_discount = null;

                $gig->private_rate = null;
                $payment->private_rate = null;
                $payment->private_earning = null;
                $payment->private_group_size = null;
                $payment->private_discount = null;


            } else {

                $gig->rate = null;
                $payment->rate = null;
                $payment->earning = null;

                if (in_array($gigData->group_type, ['Public', 'Both'])) {
                    $gig->public_rate = $request->public_rate;
                    $payment->public_rate = $request->public_rate;
                    $payment->public_earning = $request->public_earning;
                    $payment->public_group_size = $request->public_group_size;
                    $payment->public_discount = $request->public_discount;
                } else {
                    $gig->private_rate = null;
                    $payment->public_rate = null;
                    $payment->public_earning = null;
                    $payment->public_group_size = null;
                    $payment->public_discount = null;
                }

                if (in_array($gigData->group_type, ['Private', 'Both'])) {
                    $gig->private_rate = $request->private_rate;
                    $payment->private_rate = $request->private_rate;
                    $payment->private_earning = $request->private_earning;
                    $payment->private_group_size = $request->private_group_size;
                    $payment->private_discount = $request->private_discount;
                } else {
                    $gig->private_rate = null;
                    $payment->private_rate = null;
                    $payment->private_earning = null;
                    $payment->private_group_size = null;
                    $payment->private_discount = null;
                }


            }

            $payment->minor_attend = $request->minor_attend;
            if ($request->minor_attend == 1) {
                $payment->age_limit = $request->age_limit;
                $payment->childs = $request->childs;
            } else {
                $payment->age_limit = null;
                $payment->childs = null;

            }

            $payment->positive_term = $request->positive_term;

            if ($gig->class_type == 'Video') {
                $payment->duration = $request->duration;
            } else {
                $payment->duration = $request->durationH . ':' . $request->durationM;
            }


            $gigDays = TeacherReapetDays::where(['gig_id' => $gig->id])->get();
            if ($gigDays) {
                foreach ($gigDays as $key => $value) {
                    $value->delete();
                }
            }


            if ($gigData->recurring_type == 'OneDay') {

                $gig->start_date = $request->start_date;
                $gig->start_time = $request->start_time;

                $payment->start_date = $request->start_date;
                $payment->start_time = $request->start_time;
                $payment->end_time = $request->end_time;
                $gig->status = 1;
            } else {

                $gig->start_date = null;
                $gig->start_time = null;

                $payment->start_date = null;
                $payment->start_time = null;
                $payment->end_time = null;


                if ($request->day_repeat != null) {

                    foreach ($request->day_repeat as $key => $value) {
                        $day = TeacherReapetDays::create([
                            'gig_id' => $request->gig_id,
                            'day' => $value,
                            'start_time' => $request->start_repeat[$key],
                            'end_time' => $request->end_repeat[$key],
                        ]);
                    }
                }

            }


        } else {


            if ($gigData->freelance_type == 'Both') {
                $gig->rate = $request->rate . '|*|' . $request->rate_2;
                $payment->rate = $request->rate . '|*|' . $request->rate_2;
                $payment->earning = $request->earning . '|*|' . $request->earning_2;

                if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal') {
                    $payment->duration = $request->durationH . ':' . $request->durationM . '|*|' . $request->durationH_2 . ':' . $request->durationM_2;
                } else {
                    $payment->delivery_time = $request->delivery_time . '|*|' . $request->delivery_time_2;
                    $gig->delivery_time = $request->delivery_time . '|*|' . $request->delivery_time_2;
                }


                $payment->revision = $request->revision . '|*|' . $request->revision_2;
                $gig->revision = $request->revision . '|*|' . $request->revision_2;

            } else {
                $gig->rate = $request->rate;
                $payment->rate = $request->rate;
                $payment->earning = $request->earning;

                if ($gig->service_type == 'Inperson' && $gigData->freelance_service == 'Normal') {
                    $payment->duration = $request->durationH . ':' . $request->durationM;
                } else {
                    $payment->delivery_time = $request->delivery_time;
                    $gig->delivery_time = $request->delivery_time;
                }

                $payment->revision = $request->revision;
                $gig->revision = $request->revision;
            }


            $payment->positive_term = $request->positive_term;
            $payment->full_available = $request->full_available;
            $gig->full_available = $request->full_available;


            if ($gig->service_type != 'Inperson' && $gigData->freelance_service != 'Normal') {


                if ($gigData->freelance_service == 'Consultation') {
                    $payment->duration = $request->durationH . ':' . $request->durationM;
                } else {
                    $payment->duration = null;
                }
            }


            $gigDays = TeacherReapetDays::where(['gig_id' => $gig->id])->get();
            if ($gigDays) {
                foreach ($gigDays as $key => $value) {
                    $value->delete();
                }
            }


            if ($request->full_available == 0) {

                foreach ($request->day_repeat as $key => $value) {
                    $day = TeacherReapetDays::create([
                        'gig_id' => $request->gig_id,
                        'day' => $value,
                        'start_time' => $request->start_repeat[$key],
                        'end_time' => $request->end_repeat[$key],
                    ]);
                }
            }


        }


        $gig->status = 1;
        $payment->update();

        $gig->update();


        if ($payment) {
            return redirect()->to('/class-management')->with('success', 'Your Service Published Successfuly!');
        } else {
            return redirect()->to('/class-management')->with('error', 'Something Went Rong, Try Again Later!');

        }


    }

    // Payment Update Function  END
    // Service Draft Edit Function END ========

// Services Faqs Functions Start =============
    public function GetFaqsServices(Request $request)
    {

        $faqs = ServicesFaqs::where(['gig_id' => $request->gig_id])->get();

        $response['faqs'] = $faqs;
        return response()->json($response);
    }

// Upload Faqs Services ===========Function Start
    public function UploadFaqsServices(Request $request)
    {

        // if ($request->answer == '' || $request->question) {
        //    return redirect()->back()->with('error','All Fields are Required!');
        // }

        $faqs = ServicesFaqs::create([
            'gig_id' => $request->gig_id,
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        if ($faqs) {
            $response['faqs'] = $faqs;
            $response['success'] = 'Faqs Added Successfuly!';
            return response()->json($response);
        } else {
            $response['error'] = 'Something Went Rong, Tryagain Later!';
            return response()->json($response);
        }


    }
// Upload Faqs Services ===========Function END

// Delete Faqs Services ===========Function Start
    public function DeleteFaqsServices(Request $request)
    {


        $faqs = ServicesFaqs::find($request->id);
        $faqs->delete();
        if ($faqs) {

            $response['success'] = 'Faqs Deleted Successfuly!';
            return response()->json($response);
        } else {
            $response['error'] = 'Something Went Rong, Tryagain Later!';
            return response()->json($response);
        }


    }
// Delete Faqs Services ===========Function END


// Update Faqs Services ===========Function Start
    public function UpdatedFaqsServices(Request $request)
    {

        $faqs = ServicesFaqs::find($request->id);
        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->update();
        if ($faqs) {

            $response['faqs'] = $faqs;
            $response['success'] = 'Faqs Updated Successfuly!';
            return response()->json($response);
        } else {
            $response['error'] = 'Something Went Rong, Tryagain Later!';
            return response()->json($response);
        }


    }
// Update Faqs Services ===========Function END


// Services Faqs Functions END =============


}
