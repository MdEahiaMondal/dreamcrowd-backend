<?php

namespace App\Http\Controllers;

use App\Models\BecomeExpert;
use App\Models\BecomeExpertFaqs;
use App\Models\Category;
use App\Models\ExpertFastPayment;
use App\Models\ExpertKeyPoint;
use App\Models\ExpertProfile;
use App\Models\HostFeature;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;
use Stripe;

class ExpertController extends Controller
{
    
    public function BecomeAnExpert()   {
        
        $expert = BecomeExpert::first();
        $feature = HostFeature::all();
        $faqs = BecomeExpertFaqs::all();
        
        return view("Become-expert.index", compact('expert','feature','faqs'));
    }
    
    
    public function GetStarted()   {
         
        $expert = BecomeExpert::first();
        $points = ExpertKeyPoint::all();
        return view("Become-expert.get-started", compact('expert','points'));
    }
    
    
    
    public function ExpertProfile()   {

        if (!Auth::user()) {
            return redirect('/')->with('error','Login First!');
        }
        if (Auth::user()->role != 0 ) {
            if (Auth::user()->role == 1 ) {
                return redirect('/')->with('error','You Already Uploaded Expert Profile!');
            }else{
                return redirect('/')->with('error','Only Users go to Expert Profile!');

            }
        }

        $expert = ExpertProfile::where(['user_id'=>Auth::user()->id, 'status'=>1])->first();
        if ($expert) {
            return redirect()->to('/')->with('error','Your Expert Application Already Approved!');
        }
        $expert = ExpertProfile::where(['user_id'=>Auth::user()->id, 'status'=>0])->first();
        if ($expert) {
            return redirect()->to('/')->with('error','Your Expert Application in Pending!');
        }
        
        $expert = BecomeExpert::first(); 
        $payments = ExpertFastPayment::where(['user_id'=>Auth::user()->id,'status'=>0])->count();
        
         
        return view("Become-expert.expert-profile", compact('expert','payments'));
    }
    
// Expert Profile Services Categories get for selection Ajax Start ============
public function GetServicesForExpert(Request $request)  {

   
    if($request->service_role != 'Both' && $request->service_type != 'Both') {
       
        $services = Category::where(['service_role'=>$request->service_role , 'service_type'=>$request->service_type,'status'=>1])->get();
       
        $response['service_type'] = $request->service_type;
       $response['service_role'] = $request->service_role;
       $response['services'] = $services;
       $response['service'] = $request->service_role;

       return response()->json($response);

   }elseif ($request->service_role == 'Both' && $request->service_type != 'Both') {
      
    $services = Category::where(['service_type'=>$request->service_type,'status'=>1])->get();
    
    $response['service_type'] = $request->service_type;
    $response['service_role'] = $request->service_role;
    $response['services'] = $services;
     $response['service'] = $request->service_role;
    
    return response()->json($response);

}elseif ($request->service_role != 'Both' && $request->service_type == 'Both') {
      
    $services_class_online = Category::where(['service_role'=>'Class','service_type'=>'Online','status'=>1])->get();
    $services_class_inperson = Category::where(['service_role'=>'Class','service_type'=>'Inperson','status'=>1])->get();
    $services_freelance_online = Category::where(['service_role'=>'Freelance','service_type'=>'Online','status'=>1])->get();
    $services_freelance_inperson = Category::where(['service_role'=>'Freelance','service_type'=>'Inperson','status'=>1])->get();

    $response['service_type'] = $request->service_type;
    $response['service_role'] = $request->service_role;
    $response['service'] = $request->service_role;
    $response['services_class_online'] = $services_class_online;
    $response['services_class_inperson'] = $services_class_inperson;
    $response['services_freelance_online'] = $services_freelance_online;
    $response['services_freelance_inperson'] = $services_freelance_inperson;
      
    return response()->json($response);

    }elseif ($request->service_role == 'Both' && $request->service_type == 'Both') {

       $services_class_online = Category::where(['service_role'=>'Class','service_type'=>'Online','status'=>1])->get();
       $services_class_inperson = Category::where(['service_role'=>'Class','service_type'=>'Inperson','status'=>1])->get();
       $services_freelance_online = Category::where(['service_role'=>'Freelance','service_type'=>'Online','status'=>1])->get();
       $services_freelance_inperson = Category::where(['service_role'=>'Freelance','service_type'=>'Inperson','status'=>1])->get();
  
       $response['service_type'] = $request->service_type;
       $response['service_role'] = $request->service_role;
       $response['service'] = $request->service_role;
       $response['services_class_online'] = $services_class_online;
       $response['services_class_inperson'] = $services_class_inperson;
       $response['services_freelance_online'] = $services_freelance_online;
       $response['services_freelance_inperson'] = $services_freelance_inperson;
        
       return response()->json($response);
   
    } 

    
    
}


// Class Sub categories Get ===
public function GetClassSubCates(Request $request)   {

    $category_ids = $request->ClsAllCates; // Example of category IDs to filter
    $category_ids = array_map('intval', explode(',', $category_ids));
    
    // Fetch categories with subcategories
    $SubCategoriesOnline = DB::table('sub_categories')
    ->leftJoin('categories', 'sub_categories.cate_id', '=', 'categories.id')  // Ensure this join is correct
    ->whereIn('categories.id', $category_ids)  // Filter by the specified category IDs
    ->where('categories.sub_category', 1)  // Filter by the specified category IDs
    ->where('categories.service_role', 'Class')  // Filter by the specified category IDs
    ->where('categories.service_type', 'Online')  // Filter by the specified category IDs
    ->select('categories.id','categories.category','categories.service_type', 'sub_categories.sub_category')
    ->get();

    $SubCategoriesInperson = DB::table('sub_categories')
    ->leftJoin('categories', 'sub_categories.cate_id', '=', 'categories.id')  // Ensure this join is correct
    ->whereIn('categories.id', $category_ids)  // Filter by the specified category IDs
    ->where('categories.sub_category', 1)  // Filter by the specified category IDs
    ->where('categories.service_role', 'Class')  // Filter by the specified category IDs
    ->where('categories.service_type', 'Inperson')  // Filter by the specified category IDs
    ->select('categories.id','categories.category','categories.service_type', 'sub_categories.sub_category')
    ->get();

    $response['subcatesonline'] = $SubCategoriesOnline;
    $response['subcatesinperson'] = $SubCategoriesInperson;
    return response()->json($response);

}


// Freelance Sub categories Get ===
public function GetFreelanceSubCates(Request $request)   {

    $category_ids = $request->FlsAllCates; // Example of category IDs to filter
    $category_ids = array_map('intval', explode(',', $category_ids));
    
    // Fetch categories with subcategories
    $SubCategoriesOnline = DB::table('sub_categories')
    ->leftJoin('categories', 'sub_categories.cate_id', '=', 'categories.id')  // Ensure this join is correct
    ->whereIn('categories.id', $category_ids)  // Filter by the specified category IDs
    ->where('categories.sub_category', 1)  // Filter by the specified category IDs
    ->where('categories.service_role', $request->service_role)  // Filter by the specified category IDs
    ->where('categories.service_type', 'Online')  // Filter by the specified category IDs
    ->select('categories.id','categories.category','categories.service_type', 'sub_categories.sub_category')
    ->get();

    $SubCategoriesInperson = DB::table('sub_categories')
    ->leftJoin('categories', 'sub_categories.cate_id', '=', 'categories.id')  // Ensure this join is correct
    ->whereIn('categories.id', $category_ids)  // Filter by the specified category IDs
    ->where('categories.sub_category', 1)  // Filter by the specified category IDs
    ->where('categories.service_role', $request->service_role)  // Filter by the specified category IDs
    ->where('categories.service_type', 'Inperson')  // Filter by the specified category IDs
    ->select('categories.id','categories.category','categories.service_type', 'sub_categories.sub_category')
    ->get();

    $response['subcatesonline'] = $SubCategoriesOnline;
    $response['subcatesinperson'] = $SubCategoriesInperson;
    return response()->json($response);

}

 
// Expert Profile Services Categories get for selection Ajax End ============


// Expert Profile Upload Function Start==================
public function ExpertProfileUpload(Request $request)   {

    $expert = ExpertProfile::where(['user_id'=>Auth::user()->id, 'status'=>1])->first();
    if ($expert) {
        return redirect()->to('/')->with('error','Your Expert Application Already Approved!');
    }

    $expert = ExpertProfile::where(['user_id'=>Auth::user()->id, 'status'=>0])->first();
    if ($expert) {
        return redirect()->to('/')->with('error','Your Expert Application in Pending!');
    }
    $expert_center = BecomeExpert::first();
    $new_expert = new ExpertProfile();

    if ($request->hasfile('profile_image')) {
        $profile_image = $request->profile_image;
        $profile_imageName =  $profile_image->getClientOriginalName();
        $profile_imageData = $profile_imageName;
        $profile_image->move(public_path().'/assets/profile/img', $profile_imageName);
            $new_expert->profile_image =  $profile_imageData ;
    }

    if ($request->hasfile('main_image')) {
        $main_image = $request->main_image;
        $main_imageName =  $main_image->getClientOriginalName();
        $main_imageData = $main_imageName;
        $main_image->move(public_path().'/assets/expert/asset/img', $main_imageName);
            $new_expert->main_image =  $main_imageData ;
    }


    if ($request->hasfile('image_1')) {
        $image_1 = $request->image_1;
        $image_1Name =  $image_1->getClientOriginalName();
        $image_1Data = $image_1Name;
        $image_1->move(public_path().'/assets/expert/asset/img', $image_1Name);
            $new_expert->more_image_1 =  $image_1Data ;
    }


    if ($request->hasfile('image_2')) {
        $image_2 = $request->image_2;
        $image_2Name =  $image_2->getClientOriginalName();
        $image_2Data = $image_2Name;
        $image_2->move(public_path().'/assets/expert/asset/img', $image_2Name);
            $new_expert->more_image_2 =  $image_2Data ;
    }

    if ($request->hasfile('image_3')) {
        $image_3 = $request->image_3;
        $image_3Name =  $image_3->getClientOriginalName();
        $image_3Data = $image_3Name;
        $image_3->move(public_path().'/assets/expert/asset/img', $image_3Name);
            $new_expert->more_image_3 =  $image_3Data ;
    }

    if ($request->hasfile('image_4')) {
        $image_4 = $request->image_4;
        $image_4Name =  $image_4->getClientOriginalName();
        $image_4Data = $image_4Name;
        $image_4->move(public_path().'/assets/expert/asset/img', $image_4Name);
            $new_expert->more_image_4 =  $image_4Data ;
    }

    if ($request->hasfile('image_5')) {
        $image_5 = $request->image_5;
        $image_5Name =  $image_5->getClientOriginalName();
        $image_5Data = $image_5Name;
        $image_5->move(public_path().'/assets/expert/asset/img', $image_5Name);
            $new_expert->more_image_5 =  $image_5Data ;
    }

    if ($request->hasfile('image_6')) {
        $image_6 = $request->image_6;
        $image_6Name =  $image_6->getClientOriginalName();
        $image_6Data = $image_6Name;
        $image_6->move(public_path().'/assets/expert/asset/img', $image_6Name);
            $new_expert->more_image_6 =  $image_6Data ;
    }

    if ($request->hasfile('video')) {
        $video = $request->video;
        $videoName =  $video->getClientOriginalName();
        $videoData = $videoName;
        $video->move(public_path().'/assets/expert/asset/img', $videoName);
            $new_expert->video =  $videoData ;
    }

    if ($request->hasfile('option_1')) {
        $option_1 = $request->option_1;
        $option_1Name =  $option_1->getClientOriginalName();
        $option_1Data = $option_1Name;
        $option_1->move(public_path().'/assets/expert/asset/img', $option_1Name);
            $new_expert->option_1 =  $option_1Data ;
    }

    if ($request->hasfile('option_2')) {
        $option_2 = $request->option_2;
        $option_2Name =  $option_2->getClientOriginalName();
        $option_2Data = $option_2Name;
        $option_2->move(public_path().'/assets/expert/asset/img', $option_2Name);
            $new_expert->option_2 =  $option_2Data ;
    }

    if ($expert_center) {
      if ($expert_center->verification_center == 1) {
        if ($request->hasfile('option_3')) {
            $option_3 = $request->option_3;
            $option_3Name =  $option_3->getClientOriginalName();
            $option_3Data = $option_3Name;
            $option_3->move(public_path().'/assets/expert/asset/img', $option_3Name);
                $new_expert->option_3 =  $option_3Data ;
        }
    
        if ($request->hasfile('option_4')) {
            $option_4 = $request->option_4;
            $option_4Name =  $option_4->getClientOriginalName();
            $option_4Data = $option_4Name;
            $option_4->move(public_path().'/assets/expert/asset/img', $option_4Name);
                $new_expert->option_4 =  $option_4Data ;
        }
      }
    }

   


    $new_expert->user_id  = Auth::user()->id ;
    $new_expert->first_name  = $request->first_name ;
    $new_expert->last_name  = $request->last_name ;
    $new_expert->gender  = $request->gender ;
    $new_expert->profession  = $request->profession ;
    $new_expert->service_role  = $request->service_role ;
    $new_expert->service_type  = $request->service_type ;
    $new_expert->street_address  = $request->street_address ;
    $new_expert->ip_address  = $request->ip_address ;
    $new_expert->latitude  = $request->latitude ;
    $new_expert->longitude  = $request->longitude ;
    $new_expert->country  = $request->country ;
    $new_expert->country_code  =  $request->country_code ;
    $new_expert->city  = $request->city ;
    $new_expert->zip_code  = $request->zip_code ;

    if ($request->service_role == 'freelance') {
      $new_expert->category_freelance = $request->freelance_cate_ids ;
      $new_expert->sub_category_freelance  = $request->freelance_sub_category ;
      $new_expert->positive_search_freelance  = $request->freelance_term ;
    } else if($request->service_role == 'class') {
        $new_expert->category_class  = $request->class_cate_ids ;
        $new_expert->sub_category_class  = $request->class_sub_category ;
        $new_expert->positive_search_class  = $request->class_term ;
    }else{
        $new_expert->category_class  = $request->class_cate_ids ;
        $new_expert->sub_category_class  = $request->class_sub_category ;
        $new_expert->positive_search_class  = $request->class_term ;
        $new_expert->category_freelance = $request->freelance_cate_ids ;
        $new_expert->sub_category_freelance  = $request->freelance_sub_category ;
        $new_expert->positive_search_freelance  = $request->freelance_term ;
    }
    
    
    $new_expert->experience  = $request->experience ;
    // $new_expert->experience_graphic  = $request->graphic_experience ;
    // $new_expert->experience_web  = $request->web_experience ;
    $new_expert->portfolio  = $request->portfolio ;

    if ($request->portfolio != 'not_link') {
        $new_expert->portfolio_url  = $request->portfolio_url ;
        }

    $new_expert->primary_language  = $request->primary_language ;
    $new_expert->fluent_english  = $request->english_language ;
    $new_expert->speak_other_language  = $request->speak_other_language ;
if ($request->speak_other_language == 1) {
    $new_expert->fluent_other_language  = $request->other_language ;
}
    $new_expert->overview  = $request->overview ;
    $new_expert->about_me  = $request->about_me ;
    $new_expert->app_date  = date("M d, Y") ;
    $new_expert->app_type  = $request->app_type ;
    $new_expert->save();

    if ($new_expert) {
        // Send notification to seller (confirmation)
        app(\App\Services\NotificationService::class)->send(
            userId: Auth::id(),
            type: 'account',
            title: 'Application Submitted',
            message: 'Your seller application has been submitted successfully. We will review it and notify you once a decision is made.',
            data: ['application_id' => $new_expert->id, 'submitted_at' => now()],
            sendEmail: true
        );

        // Send notification to admin (new application alert)
        $adminIds = \App\Models\User::where('role', 2)->pluck('id')->toArray();
        if (!empty($adminIds)) {
            app(\App\Services\NotificationService::class)->sendToMultipleUsers(
                userIds: $adminIds,
                type: 'account',
                title: 'New Seller Application',
                message: Auth::user()->first_name . ' ' . Auth::user()->last_name . ' has submitted a new seller application for review.',
                data: ['application_id' => $new_expert->id, 'user_id' => Auth::id(), 'app_type' => $request->app_type],
                sendEmail: true
            );
        }

        return redirect()->to('/')->with('success','Your Expert Application Submmited Successfuly, Please Wait Addmin Approvel!');
    } else {
        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    }

}
// Expert Profile Upload Function END==================


// Fast Track App Payment Function Start =====
function FastTrackAppPayment(Request $request)   {
    
     if (!Auth::user()) {
        return redirect('/');
     }
      

       // Validate card details input
       $request->validate([
           'holder_name' => 'required|string',
           'card_number' => 'required|numeric|digits_between:13,19',
           'cvv' => 'required|numeric|digits:3',  // Use 4 for AMEX
           'date' => 'required|date_format:m/y',
       ]);

         // Set Stripe API secret key
         Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

       try {
        // Create a PaymentIntent
        $paymentIntent = PaymentIntent::create([
            'amount' => 500,  // Amount in cents
            'currency' => 'usd',
            'capture_method' => 'manual',  // Set to manual to hold the payment
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        if ($paymentIntent) {
            ExpertFastPayment::create([
                'user_id' => Auth::user()->id,  // Amount in cents
                'stripe_payment_intent_id' => $paymentIntent->id,  // Amount in cents
                'name' => $request->holder_name, 
                'card_number' => $request->card_number, 
                'cvv' => $request->cvv, 
                'date' => $request->date, 
            ]);
            return response()->json(['success' => 'Payment Completed Successfully!']);
        } else {
            return response()->json(['error' => 'Something Went Rong, Tryagain Later!']);
        }
        

        
    } catch (\Exception $e) {
        return response()->json(['error' => 'Payment failed', 'message' => $e->getMessage()], 500);
    }

}
// Fast Track App Payment Function END =====


}
