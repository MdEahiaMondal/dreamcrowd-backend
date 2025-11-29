<?php

namespace App\Http\Controllers;

use App\Models\AboutUsDynamic;
use App\Models\BecomeExpert;
use App\Models\BecomeExpertFaqs;
use App\Models\BookingDuration;
use App\Models\Category;
use App\Models\ExpertKeyPoint;
use App\Models\ExpertProfile;
use App\Models\Faqs;
use App\Models\FaqsHeading;
use App\Models\Home2Dynamic;
use App\Models\HomeDynamic;
use App\Models\HostFeature;
use App\Models\HostGuidline;
use App\Models\KeywordSuggession;
use App\Models\Languages;
use App\Models\PannelFaqs;
use App\Models\SiteBanner;
use App\Models\SocialMedia;
use App\Models\SubCategory;
use App\Models\TeacherGig;
use App\Models\TeacherGigData;
use App\Models\TermPrivacy;
use App\Models\TopSellerTag;
use Carbon\Language;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DynamicManagementController extends Controller
{

    
    public function AdmincheckAuth() {

        if (!Auth::user()) {
           return redirect()->to('/')->with('error','Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 0) {
                return redirect()->to('/user-dashboard');
            }elseif(Auth::user()->role == 1){
                return redirect()->to('/teacher-dashboard');
            }
        }
        
        
    }

    // Hoem Page Dynamic Functions Start====================
    
    public function HomeDynamic() {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
      

        $home = HomeDynamic::first();
        $home2 = Home2Dynamic::first();

        return view("Admin-Dashboard.homepage", compact('home','home2'));
    }
    
    
    
    public function UpdateHomeDynamic(Request $request) {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $home = HomeDynamic::first();
        $home2 = Home2Dynamic::first();

 
        if ($request->cate == 'identity') {

            if ($home) {

                
            if ($request->hasfile('site_logo')) {
                $site_logo = $request->site_logo;
                $site_logoName =  $site_logo->getClientOriginalName();
               $site_logoData = $site_logoName;
                
                if ($home->site_logo != $site_logoData) {
                    $site_logo->move(public_path().'/assets/public-site/asset/img', $site_logoName);
                $home->site_logo =  $site_logoData ;
                }
            }
             

            if ($request->hasfile('fav_icon')) {
                $fav_icon = $request->fav_icon;
            $fav_iconName =  $fav_icon->getClientOriginalName();
            $fav_iconData = $fav_iconName;
                
                if ($home->fav_icon != $fav_iconData) {
                    $fav_icon->move(public_path().'/assets/public-site/asset/img', $fav_iconName);
                    $home->fav_icon =  $fav_iconData ;
                }
            }

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {

                $site_logo = $request->site_logo;
                $site_logoName =  $site_logo->getClientOriginalName();
                $site_logo->move(public_path().'/assets/public-site/asset/img', $site_logoName);
                $site_logoData = $site_logoName;
    
    
    
    
                $fav_icon = $request->fav_icon;
                $fav_iconName =  $fav_icon->getClientOriginalName();
                $fav_icon->move(public_path().'/assets/public-site/asset/img', $fav_iconName);
                $fav_iconData = $fav_iconName;
               

                $home = HomeDynamic::create([
                'site_logo'=> $site_logoData ,
                'fav_icon'=> $fav_iconData ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }




        if ($request->cate == 'notification') {

            if ($home) {

                
                $home->notification_bar = $request->notification_bar  ;
                $home->notification_heading = $request->notification_heading ;
                $home->notification = $request->notification ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {

               

                $home = HomeDynamic::create([
                'notification_bar'=> $request->notification_bar  ,
                'notification_heading'=> $request->notification_heading ,
                'notification'=> $request->notification ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }


        
        if ($request->cate == 'hero') {

            if ($home) {

                
              

                if ($request->hasfile('hero_image')) {
                    $hero_image = $request->hero_image;
                    $hero_imageName =  $hero_image->getClientOriginalName();
                   $hero_imageData = $hero_imageName;
                    
                    if ($home->hero_image != $hero_imageData) {
                        $hero_image->move(public_path().'/assets/public-site/asset/img', $hero_imageName);
                        $home->hero_image =  $hero_imageData ;
                    }
                }

                $home->hero_text= $request->hero_text ;
            $home->hero_discription= $request->hero_description ;
            // $home->hero_note= $request->hero_note ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {

                $hero_image = $request->hero_image;
                $hero_imageName =  $hero_image->getClientOriginalName();
                $hero_image->move(public_path().'/assets/public-site/asset/img', $hero_imageName);
                $hero_imageData = $hero_imageName;
               

                $home = HomeDynamic::create([
                'hero_text'=> $request->hero_text ,
                'hero_discription'=> $request->hero_description ,
                'hero_image'=>  $hero_imageData ,
                // 'hero_note'=> $request->hero_note ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }


          
        if ($request->cate == 'counter') {

            if ($home) {

                
              

                $home->counter_heading_1= $request->counter_heading1 ;
            $home->counter_number_1= $request->counter_number1 ;
            $home->counter_heading_2= $request->counter_heading2 ;
            $home->counter_number_2= $request->counter_number2 ;
            $home->counter_heading_3= $request->counter_heading3 ;
            $home->counter_number_3= $request->counter_number3 ;
            $home->counter_heading_4= $request->counter_heading4 ;
            $home->counter_number_4= $request->counter_number4 ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
               

                $home = HomeDynamic::create([
                'counter_heading_1'=> $request->counter_heading1 ,
                'counter_number_1'=> $request->counter_number1 ,
                'counter_heading_2'=> $request->counter_heading2 ,
                'counter_number_2'=> $request->counter_number2 ,
                'counter_heading_3'=> $request->counter_heading3 ,
                'counter_number_3'=> $request->counter_number3 ,
                'counter_heading_4'=> $request->counter_heading4 ,
                'counter_number_4'=> $request->counter_number4 ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }


          
        if ($request->cate == 'rating') {

            if ($home) {

              
            if ($request->hasfile('rating_image1')) {
                $rating_image1 = $request->rating_image1;
            $rating_image1Name =  $rating_image1->getClientOriginalName();
           $rating_image1Data = $rating_image1Name;
                
                if ($home->rating_image_1 != $rating_image1Data) {
                    $rating_image1->move(public_path().'/assets/public-site/asset/img', $rating_image1Name);
                    $home->rating_image_1 =  $rating_image1Data ;
                }
            }
             

            if ($request->hasfile('rating_image2')) {
                $rating_image2 = $request->rating_image2;
                $rating_image2Name =  $rating_image2->getClientOriginalName();
                $rating_image2Data = $rating_image2Name;
                
                if ($home->rating_image_2 != $rating_image2Data) {
                    $rating_image2->move(public_path().'/assets/public-site/asset/img', $rating_image2Name);
                    $home->rating_image_2 =  $rating_image2Data ;
                }
            }
             

            if ($request->hasfile('rating_image3')) {
                $rating_image3 = $request->rating_image3;
            $rating_image3Name =  $rating_image3->getClientOriginalName();
            $rating_image3Data = $rating_image3Name;
                
                if ($home->rating_image_3 != $rating_image3Data) {
                    $rating_image3->move(public_path().'/assets/public-site/asset/img', $rating_image3Name);
                    $home->rating_image_3 =  $rating_image3Data ;
                }
            }
             

            if ($request->hasfile('rating_image4')) {
                $rating_image4 = $request->rating_image4;
            $rating_image4Name =  $rating_image4->getClientOriginalName();
            $rating_image4Data = $rating_image4Name;
                
                if ($home->rating_image_4 != $rating_image4Data) {
                    $rating_image4->move(public_path().'/assets/public-site/asset/img', $rating_image4Name);
                    $home->rating_image_4 =  $rating_image4Data ;
                }
            }
             

            if ($request->hasfile('rating_image5')) {
                $rating_image5 = $request->rating_image5;
            $rating_image5Name =  $rating_image5->getClientOriginalName();
           $rating_image5Data = $rating_image5Name;
                
                if ($home->rating_image_5 != $rating_image5Data) {
                    $rating_image5->move(public_path().'/assets/public-site/asset/img', $rating_image5Name);
                    $home->rating_image_5 =  $rating_image5Data ;
                }
            }
             

            if ($request->hasfile('rating_image6')) {
                $rating_image6 = $request->rating_image6;
            $rating_image6Name =  $rating_image6->getClientOriginalName();
           $rating_image6Data = $rating_image6Name;
                
                if ($home->rating_image_6 != $rating_image6Data) {
                    $rating_image6->move(public_path().'/assets/public-site/asset/img', $rating_image6Name);
                    $home->rating_image_6 =  $rating_image6Data ;
                }
            }

                
            $home->rating_heading= $request->rating_heading ;
            $home->rating_stars= $request->rating_stars ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {

                


            $rating_image1 = $request->rating_image1;
            $rating_image1Name =  $rating_image1->getClientOriginalName();
            $rating_image1->move(public_path().'/assets/public-site/asset/img', $rating_image1Name);
            $rating_image1Data = $rating_image1Name;



            $rating_image2 = $request->rating_image2;
            $rating_image2Name =  $rating_image2->getClientOriginalName();
            $rating_image2->move(public_path().'/assets/public-site/asset/img', $rating_image2Name);
            $rating_image2Data = $rating_image2Name;




            $rating_image3 = $request->rating_image3;
            $rating_image3Name =  $rating_image3->getClientOriginalName();
            $rating_image3->move(public_path().'/assets/public-site/asset/img', $rating_image3Name);
            $rating_image3Data = $rating_image3Name;



            $rating_image4 = $request->rating_image4;
            $rating_image4Name =  $rating_image4->getClientOriginalName();
            $rating_image4->move(public_path().'/assets/public-site/asset/img', $rating_image4Name);
            $rating_image4Data = $rating_image4Name;



            $rating_image5 = $request->rating_image5;
            $rating_image5Name =  $rating_image5->getClientOriginalName();
            $rating_image5->move(public_path().'/assets/public-site/asset/img', $rating_image5Name);
            $rating_image5Data = $rating_image5Name;



            $rating_image6 = $request->rating_image6;
            $rating_image6Name =  $rating_image6->getClientOriginalName();
            $rating_image6->move(public_path().'/assets/public-site/asset/img', $rating_image6Name);
            $rating_image6Data = $rating_image6Name;
               

                $home = HomeDynamic::create([
                    'reating_heading'=> $request->rating_heading ,
                    'reating_stars'=> $request->rating_stars ,
                    'reating_image_1'=> $rating_image1Data ,
                    'reating_image_2'=> $rating_image2Data ,
                    'reating_image_3'=> $rating_image3Data ,
                    'reating_image_4'=> $rating_image4Data ,
                    'reating_image_5'=> $rating_image5Data ,
                    'reating_image_6'=> $rating_image6Data ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }


           
        if ($request->cate == 'work') {

            if ($home) {

                

            if ($request->hasfile('work_image1')) {
                $work_image1 = $request->work_image1;
            $work_image1Name =  $work_image1->getClientOriginalName();
            $work_image1Data = $work_image1Name;
                
                if ($home->work_image_1 != $work_image1Data) {
                    $work_image1->move(public_path().'/assets/public-site/asset/img', $work_image1Name);
                    $home->work_image_1 =  $work_image1Data ;
                }
            }
             

            if ($request->hasfile('work_image2')) {
                $work_image2 = $request->work_image2;
                $work_image2Name =  $work_image2->getClientOriginalName();
                $work_image2Data = $work_image2Name;
                
                if ($home->work_image_2 != $work_image2Data) {
                    $work_image2->move(public_path().'/assets/public-site/asset/img', $work_image2Name);
                    $home->work_image_2 =  $work_image2Data ;
                }
            }
             

            if ($request->hasfile('work_image3')) {
                $work_image3 = $request->work_image3;
                $work_image3Name =  $work_image3->getClientOriginalName();
               $work_image3Data = $work_image3Name;
                
                if ($home->work_image_3 != $work_image3Data) {
                    $work_image3->move(public_path().'/assets/public-site/asset/img', $work_image3Name);
                    $home->work_image_3 =  $work_image3Data ;
                }
            }
              

            $home->work_heading= $request->work_heading ;
            $home->work_tagline= $request->work_tagline ;
            $home->work_heading_1= $request->work_heading1 ;
            $home->work_description_1= $request->work_description1 ;
            $home->work_heading_2= $request->work_heading2 ;
            $home->work_description_2= $request->work_description2 ;
            $home->work_heading_3= $request->work_heading3 ;
            $home->work_description_3= $request->work_description3 ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
               
                $work_image1 = $request->work_image1;
                $work_image1Name =  $work_image1->getClientOriginalName();
                $work_image1->move(public_path().'/assets/public-site/asset/img', $work_image1Name);
                $work_image1Data = $work_image1Name;
    
    
    
                $work_image2 = $request->work_image2;
                $work_image2Name =  $work_image2->getClientOriginalName();
                $work_image2->move(public_path().'/assets/public-site/asset/img', $work_image2Name);
                $work_image2Data = $work_image2Name;
    
    
    
                $work_image3 = $request->work_image3;
                $work_image3Name =  $work_image3->getClientOriginalName();
                $work_image3->move(public_path().'/assets/public-site/asset/img', $work_image3Name);
                $work_image3Data = $work_image3Name;

                $home = HomeDynamic::create([
               'work_heading'=> $request->work_heading ,
                'work_tagline'=> $request->work_tagline ,
                'work_image_1'=> $work_image1Data ,
                'work_heading_1'=> $request->work_heading1 ,
                'work_description_1'=> $request->work_description1 ,
                'work_image_2'=> $work_image2Data ,
                'work_heading_2'=> $request->work_heading2 ,
                'work_description_2'=> $request->work_description2 ,
                'work_image_3'=> $work_image3Data ,
                'work_heading_3'=> $request->work_heading3 ,
                'work_description_3'=> $request->work_description3 ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }


        
           
        if ($request->cate == 'category') {

            if ($home) {

                

                if ($request->hasfile('category_image1')) {
                    $category_image1 = $request->category_image1;
                    $category_image1Name =  $category_image1->getClientOriginalName();
                    $category_image1Data = $category_image1Name;
                    
                    if ($home->category_image_1 != $category_image1Data) {
                        $category_image1->move(public_path().'/assets/public-site/asset/img', $category_image1Name);
                        $home->category_image_1 =  $category_image1Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image2')) {
                    $category_image2 = $request->category_image2;
                    $category_image2Name =  $category_image2->getClientOriginalName();
                    $category_image2Data = $category_image2Name;
                    
                    if ($home->category_image_2 != $category_image2Data) {
                        $category_image2->move(public_path().'/assets/public-site/asset/img', $category_image2Name);
                        $home->category_image_2 =  $category_image2Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image3')) {
                    $category_image3 = $request->category_image3;
                $category_image3Name =  $category_image3->getClientOriginalName();
               $category_image3Data = $category_image3Name;
                    
                    if ($home->category_image_3 != $category_image3Data) {
                        $category_image3->move(public_path().'/assets/public-site/asset/img', $category_image3Name);
                        $home->category_image_3 =  $category_image3Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image4')) {
                    $category_image4 = $request->category_image4;
                    $category_image4Name =  $category_image4->getClientOriginalName();
                   $category_image4Data = $category_image4Name;
                    
                    if ($home->category_image_4 != $category_image4Data) {
                        $category_image4->move(public_path().'/assets/public-site/asset/img', $category_image4Name);
                        $home->category_image_4 =  $category_image4Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image5')) {
                    $category_image5 = $request->category_image5;
                    $category_image5Name =  $category_image5->getClientOriginalName();
                    $category_image5Data = $category_image5Name;
                    
                    if ($home->category_image_5 != $category_image5Data) {
                        $category_image5->move(public_path().'/assets/public-site/asset/img', $category_image5Name);
                        $home->category_image_5 =  $category_image5Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image6')) {
                    $category_image6 = $request->category_image6;
                $category_image6Name =  $category_image6->getClientOriginalName();
               $category_image6Data = $category_image6Name;
                    
                    if ($home->category_image_6 != $category_image6Data) {
                        $category_image6->move(public_path().'/assets/public-site/asset/img', $category_image6Name);
                        $home->category_image_6 =  $category_image6Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image7')) {
                    $category_image7 = $request->category_image7;
                $category_image7Name =  $category_image7->getClientOriginalName();
               $category_image7Data = $category_image7Name;
                    
                    if ($home->category_image_7 != $category_image7Data) {
                        $category_image7->move(public_path().'/assets/public-site/asset/img', $category_image7Name);
                        $home->category_image_7 =  $category_image7Data ;
                    }
                }
                 
    
                if ($request->hasfile('category_image8')) {
                    $category_image8 = $request->category_image8;
                $category_image8Name =  $category_image8->getClientOriginalName();
               $category_image8Data = $category_image8Name;
                    
                    if ($home->category_image_8 != $category_image8Data) {
                        $category_image8->move(public_path().'/assets/public-site/asset/img', $category_image8Name);
                        $home->category_image_8 =  $category_image8Data ;
                    }
                }
                 
    
    
                
               
    
                
                $home->category_heading= $request->category_heading ;
                $home->category_tagline= $request->category_tagline ;
                $home->category_name_1= $request->category_name1 ;
                $home->category_name_2= $request->category_name2 ;
                $home->category_name_3= $request->category_name3 ;
                $home->category_name_4= $request->category_name4 ;
                $home->category_name_5= $request->category_name5 ;
                $home->category_name_6= $request->category_name6 ;
                $home->category_name_7= $request->category_name7 ;
                $home->category_name_8= $request->category_name8 ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
               
              
            $category_image1 = $request->category_image1;
            $category_image1Name =  $category_image1->getClientOriginalName();
            $category_image1->move(public_path().'/assets/public-site/asset/img', $category_image1Name);
            $category_image1Data = $category_image1Name;




            $category_image2 = $request->category_image2;
            $category_image2Name =  $category_image2->getClientOriginalName();
            $category_image2->move(public_path().'/assets/public-site/asset/img', $category_image2Name);
            $category_image2Data = $category_image2Name;



            $category_image3 = $request->category_image3;
            $category_image3Name =  $category_image3->getClientOriginalName();
            $category_image3->move(public_path().'/assets/public-site/asset/img', $category_image3Name);
            $category_image3Data = $category_image3Name;



            $category_image4 = $request->category_image4;
            $category_image4Name =  $category_image4->getClientOriginalName();
            $category_image4->move(public_path().'/assets/public-site/asset/img', $category_image4Name);
            $category_image4Data = $category_image4Name;



            $category_image5 = $request->category_image5;
            $category_image5Name =  $category_image5->getClientOriginalName();
            $category_image5->move(public_path().'/assets/public-site/asset/img', $category_image5Name);
            $category_image5Data = $category_image5Name;


            $category_image6 = $request->category_image6;
            $category_image6Name =  $category_image6->getClientOriginalName();
            $category_image6->move(public_path().'/assets/public-site/asset/img', $category_image6Name);
            $category_image6Data = $category_image6Name;


            $category_image7 = $request->category_image7;
            $category_image7Name =  $category_image7->getClientOriginalName();
            $category_image7->move(public_path().'/assets/public-site/asset/img', $category_image7Name);
            $category_image7Data = $category_image7Name;


            $category_image8 = $request->category_image8;
            $category_image8Name =  $category_image8->getClientOriginalName();
            $category_image8->move(public_path().'/assets/public-site/asset/img', $category_image8Name);
            $category_image8Data = $category_image8Name;


                $home = HomeDynamic::create([
               'category_heading'=> $request->category_heading ,
                'category_tagline'=> $request->category_tagline ,
                'category_image_1'=> $category_image1Data ,
                'category_name_1'=> $request->category_name1 ,
                'category_image_2'=> $category_image2Data ,
                'category_name_2'=> $request->category_name2 ,
                'category_image_3'=> $category_image3Data ,
                'category_name_3'=> $request->category_name3 ,
                'category_image_4'=> $category_image4Data  ,
                'category_name_4'=> $request->category_name4 ,
                'category_image_5'=> $category_image5Data  ,
                'category_name_5'=> $request->category_name5 ,
                'category_image_6'=> $category_image6Data  ,
                'category_name_6'=> $request->category_name6 ,
                'category_image_7'=> $category_image7Data  ,
                'category_name_7'=> $request->category_name7 ,
                'category_image_8'=>  $category_image8Data ,
                'category_name_8'=> $request->category_name8 ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }



           
        if ($request->cate == 'expert') {

            if ($home) {

                for ($i=1; $i <= 8 ; $i++) { 
                    $expertLink = $request->input('expert_link' . $i);
                    $gig_id = explode('/',$expertLink);
                    $gig = TeacherGig::find($gig_id[1]);
                    if (!$gig) {
                        return redirect()->back()->with('error','Service Not Get from ID Link '.$i.'!');
                    }
                     
                }
                

                $home->expert_heading= $request->expert_heading ;
                $home->expert_tagline= $request->expert_tagline ;
                $home->expert_link_1= $request->expert_link1 ;
                $home->expert_link_2= $request->expert_link2 ;
                $home->expert_link_3= $request->expert_link3 ;
                $home->expert_link_4= $request->expert_link4 ;
                $home->expert_link_5= $request->expert_link5 ;
                $home->expert_link_6= $request->expert_link6 ;
                $home->expert_link_7= $request->expert_link7 ;
                $home->expert_link_8= $request->expert_link8 ;

            $home->update();

            if ($home) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
               
                for ($i=1; $i <= 8 ; $i++) { 
                    $expertLink = $request->input('expert_link' . $i);
                    $gig_id = explode('/',$expertLink);
                    $gig = TeacherGig::find($gig_id[1]);
                    if (!$gig) {
                        return redirect()->back()->with('error','Service Not Get from ID Link '.$i.'!');
                    }
                     
                }

                $home = HomeDynamic::create([
                    'expert_heading'=> $request->expert_heading ,
                    'expert_tagline'=> $request->expert_tagline ,
                    'expert_link_1'=> $request->expert_link1 ,
                    'expert_link_2'=> $request->expert_link2 ,
                    'expert_link_3'=> $request->expert_link3 ,
                    'expert_link_4'=> $request->expert_link4 ,
                    'expert_link_5'=> $request->expert_link5 ,
                    'expert_link_6'=> $request->expert_link6 ,
                    'expert_link_7'=> $request->expert_link7 ,
                    'expert_link_8'=> $request->expert_link8 ,
                ]);


                if ($home) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }

        
         
        if ($request->cate == 'banner1') {

            if ($home2) {

                if ($request->hasfile('banner1_image')) {
                    $banner1_image = $request->banner1_image;
                    $banner1_imageName =  $banner1_image->getClientOriginalName();
                   $banner1_imageData = $banner1_imageName;
                    
                    if ($home2->banner_1_image != $banner1_imageData) {
                        $banner1_image->move(public_path().'/assets/public-site/asset/img', $banner1_imageName);
                     $home2->banner_1_image =  $banner1_imageData ;
                    }
                }

                $home2->banner_1_heading= $request->banner1_heading  ;
            $home2->banner_1_description= $request->banner1_description ;
            $home2->banner_1_btn1_name= $request->banner1_btn1  ;
            $home2->banner_1_btn1_link= $request->banner1_link1 ;
            $home2->banner_1_btn2_name= $request->banner1_btn2 ;
            $home2->banner_1_btn2_link= $request->banner1_link2 ;

            $home2->update();

            if ($home2) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
               
                $banner1_image = $request->banner1_image;
            $banner1_imageName =  $banner1_image->getClientOriginalName();
            $banner1_image->move(public_path().'/assets/public-site/asset/img', $banner1_imageName);
            $banner1_imageData = $banner1_imageName;

                $home2 = Home2Dynamic::create([
                    'banner_1_heading'=> $request->banner1_heading  ,
                    'banner_1_description'=> $request->banner1_description ,
                    'banner_1_image'=> $banner1_imageData ,
                    'banner_1_btn1_name'=> $request->banner1_btn1  ,
                    'banner_1_btn1_link'=> $request->banner1_link1 ,
                    'banner_1_btn2_name'=> $request->banner1_btn2 ,
                    'banner_1_btn2_link'=> $request->banner1_link2 ,
                ]);


                if ($home2) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }

         
         
        if ($request->cate == 'services') {

            if ($home2) {

                $home2->service_heading= $request->service_heading ;
                $home2->service_tagline= $request->service_tagline  ;
                $home2->service_link_1= $request->service_link1 ;
                $home2->service_link_2= $request->service_link2  ;
                $home2->service_link_3= $request->service_link3 ;
                $home2->service_link_4= $request->service_link4 ;

            $home2->update();

            if ($home2) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
                

                $home2 = Home2Dynamic::create([
                    'service_heading'=> $request->service_heading ,
                    'service_tagline'=> $request->service_tagline  ,
                    'service_link_1'=> $request->service_link1 ,
                    'service_link_2'=> $request->service_link2  ,
                    'service_link_3'=> $request->service_link3 ,
                    'service_link_4'=> $request->service_link4 ,
                ]);


                if ($home2) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }

 
        if ($request->cate == 'banner2') {

            if ($home2) {

                if ($request->hasfile('banner2_image')) {
                    $banner2_image = $request->banner2_image;
                    $banner2_imageName =  $banner2_image->getClientOriginalName();
                   $banner2_imageData = $banner2_imageName;
                    
                    if ($home2->banner_2_image != $banner2_imageData) {
                        $banner2_image->move(public_path().'/assets/public-site/asset/img', $banner2_imageName);
                        $home2->banner_2_image =  $banner2_imageData ;
                    }
                }

                $home2->banner_2_heading= $request->banner2_heading ;
                $home2->banner_2_description= $request->banner2_description ;
                $home2->banner_2_btn1_name= $request->banner2_btn1 ;
                $home2->banner_2_btn1_link= $request->banner2_link1 ;
                $home2->banner_2_btn2_name= $request->banner2_btn2 ;
                $home2->banner_2_btn2_link= $request->banner2_link2 ;

            $home2->update();

            if ($home2) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
                
 
                $banner2_image = $request->banner2_image;
                $banner2_imageName =  $banner2_image->getClientOriginalName();
                $banner2_image->move(public_path().'/assets/public-site/asset/img', $banner2_imageName);
                $banner2_imageData = $banner2_imageName;


                $home2 = Home2Dynamic::create([
                    'banner_2_heading'=> $request->banner2_heading ,
                'banner_2_description'=> $request->banner2_description ,
                'banner_2_image'=> $banner2_imageData ,
                'banner_2_btn1_name'=> $request->banner2_btn1 ,
                'banner_2_btn1_link'=> $request->banner2_link1 ,
                'banner_2_btn2_name'=> $request->banner2_btn2 ,
                'banner_2_btn2_link'=> $request->banner2_link2 ,
                ]);


                if ($home2) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }


        
        if ($request->cate == 'reviews') {

            if ($home2) {

                
            
            if ($request->hasfile('review_image1')) {
                $review_image1 = $request->review_image1;
            $review_image1Name =  $review_image1->getClientOriginalName();
           $review_image1Data = $review_image1Name;
                
                if ($home2->review_image_1 != $review_image1Data) {
                    $review_image1->move(public_path().'/assets/public-site/asset/img', $review_image1Name);
                    $home2->review_image_1 =  $review_image1Data ;
                }
            }
            
            
            if ($request->hasfile('review_image2')) {
                $review_image2 = $request->review_image2;
            $review_image2Name =  $review_image2->getClientOriginalName();
            $review_image2Data = $review_image2Name;
                
                if ($home2->review_image_2 != $review_image2Data) {
                    $review_image2->move(public_path().'/assets/public-site/asset/img', $review_image2Name);
                    $home2->review_image_2 =  $review_image2Data ;
                }
            }
            
            
            if ($request->hasfile('review_image3')) {
                $review_image3 = $request->review_image3;
            $review_image3Name =  $review_image3->getClientOriginalName();
           $review_image3Data = $review_image3Name;
                
                if ($home2->review_image_3 != $review_image3Data) {
                    $review_image3->move(public_path().'/assets/public-site/asset/img', $review_image3Name);
                    $home2->review_image_3 =  $review_image3Data ;
                }
            }
            
            if ($request->hasfile('review_image4')) {
                $review_image4 = $request->review_image4;
            $review_image4Name =  $review_image4->getClientOriginalName();
           $review_image4Data = $review_image4Name;
                
                if ($home2->review_image_4 != $review_image4Data) {
                    $review_image4->move(public_path().'/assets/public-site/asset/img', $review_image4Name);
                    $home2->review_image_4 =  $review_image4Data ;
                }
            }

            $home2->review_heading= $request->review_heading ;
            $home2->review_tagline= $request->review_tagline ;
            $home2->review_name_1= $request->review_name1 ;
            $home2->review_designation_1= $request->review_designation1 ;
            $home2->review_rating_1= $request->review_rating1 ;
            $home2->review_review_1= $request->review_review1 ;
            $home2->review_name_2= $request->review_name2 ;
            $home2->review_designation_2= $request->review_designation2 ;
            $home2->review_rating_2= $request->review_rating2 ;
            $home2->review_review_2= $request->review_review2  ;
            $home2->review_name_3=$request->review_name3;
            $home2->review_designation_3= $request->review_designation3;
            $home2->review_rating_3= $request->review_rating3 ;
            $home2->review_review_3= $request->review_review3 ;
            $home2->review_name_4= $request->review_name4 ;
            $home2->review_designation_4= $request->review_designation4 ;
            $home2->review_rating_4= $request->review_rating4 ;
            $home2->review_review_4= $request->review_review4 ;

            $home2->update();

            if ($home2) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {
                
 
                  
            $review_image1Data = null;
            if ($request->hasfile('review_image1')) {
                $review_image1 = $request->review_image1;
                $review_image1Name =  $review_image1->getClientOriginalName();
                $review_image1->move(public_path().'/assets/public-site/asset/img', $review_image1Name);
                $review_image1Data = $review_image1Name;
            }



             
            $review_image2Data = null;
            if ($request->hasfile('review_image2')) {
                $review_image2 = $request->review_image2;
                $review_image2Name =  $review_image2->getClientOriginalName();
                $review_image2->move(public_path().'/assets/public-site/asset/img', $review_image2Name);
                $review_image2Data = $review_image2Name;
            }


             
            $review_image3Data = null;
            if ($request->hasfile('review_image3')) {
                $review_image3 = $request->review_image3;
                $review_image3Name =  $review_image3->getClientOriginalName();
                $review_image3->move(public_path().'/assets/public-site/asset/img', $review_image3Name);
                $review_image3Data = $review_image3Name;
            }
             
            $review_image4Data = null;
            if ($request->hasfile('review_image4')) {
                $review_image4 = $request->review_image4;
                $review_image4Name =  $review_image4->getClientOriginalName();
                $review_image4->move(public_path().'/assets/public-site/asset/img', $review_image4Name);
                $review_image4Data = $review_image4Name;
            }


                $home2 = Home2Dynamic::create([
                'review_heading'=> $request->review_heading ,
                'review_tagline'=> $request->review_tagline ,
                'review_image_1'=> $review_image1Data ,
                'review_name_1'=> $request->review_name1 ,
                'review_designation_1'=> $request->review_designation1 ,
                'review_rating_1'=> $request->review_rating1 ,
                'review_review_1'=> $request->review_review1 ,
                'review_image_2'=> $review_image2Data ,
                'review_name_2'=> $request->review_name2 ,
                'review_designation_2'=> $request->review_designation2 ,
                'review_rating_2'=> $request->review_rating2 ,
                'review_review_2'=> $request->review_review2  ,
                'review_image_3'=> $review_image3Data ,
                'review_name_3'=>$request->review_name3,
                'review_designation_3'=> $request->review_designation3,
                'review_rating_3'=> $request->review_rating3 ,
                'review_review_3'=> $request->review_review3 ,
                'review_image_4'=> $request->review_image4Data ,
                'review_name_4'=> $request->review_name4 ,
                'review_designation_4'=> $request->review_designation4 ,
                'review_rating_4'=> $request->review_rating4 ,
                'review_review_4'=> $request->review_review4 ,
                ]);


                if ($home2) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            

            
        }






    }
    
    
    // Hoem Page Dynamic Functions END====================

    // Category Dynamic Function Start=================
    
    public function CategoryDynamic() {
        
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        $online = Category::where(['service_type'=>'Online'])->get();
        $inperson = Category::where(['service_type'=>'Inperson'])->get();

        return view("Admin-Dashboard.category", compact('online','inperson'));
        
    }
    
    
    
    public function AddCategoryDynamic() {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        } 
       
        return view("Admin-Dashboard.add-category");
        
    }

    public function UploadCategoryDynamic(Request $request)   {

      
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

   

        if ($request->type == 'All') {

            if ($request->sub_category != null) {
                $sub_cate =   explode(',',$request->sub_category);
               $count_sub_cate = 1;
            }else{
                $count_sub_cate = 0;
             } 

            $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Online' ;
            $category->service_role = 'Class' ;
            $category->save();
           

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }
           

            $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Online' ;
            $category->service_role = 'Freelance' ;
            $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }

            $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Inperson' ;
            $category->service_role = 'Class' ;
            $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }

            $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Inperson' ;
            $category->service_role = 'Freelance' ;
            $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }

            if ($category) {
                return redirect()->to('/admin-category-dynamic')->with('success','Category Added Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
        }elseif($request->type == 'All,Online'){

            if ($request->sub_category != null) {
                $sub_cate =   explode(',',$request->sub_category);
               $count_sub_cate = 1;
            }else{
                $count_sub_cate = 0;
             } 

             $category = new Category();
             $category->category = $request->category ;
             $category->sub_category = $count_sub_cate ;
             $category->service_type = 'Online' ;
             $category->service_role = 'Class' ;
             $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }

            $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Online' ;
            $category->service_role = 'Freelance' ;
            $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }
            

            if ($category) {
                return redirect()->to('/admin-category-dynamic')->with('success','Category Added Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }

        }elseif($request->type == 'All,Inperson'){

            if ($request->sub_category != null) {
                $sub_cate =   explode(',',$request->sub_category);
               $count_sub_cate = 1;
            }else{
                $count_sub_cate = 0;
             } 

             
              $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Inperson' ;
            $category->service_role = 'Class' ;
            $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }

            $category = new Category();
            $category->category = $request->category ;
            $category->sub_category = $count_sub_cate ;
            $category->service_type = 'Inperson' ;
            $category->service_role = 'Freelance' ;
            $category->save();

            if ($count_sub_cate == 1) {
                foreach ($sub_cate as $key => $value) {
                    $sub_category = SubCategory::create([
                        'cate_id'=>$category->id,
                        'sub_category'=>$value,
                    ]);
                }
            }

            if ($category) {
                return redirect()->to('/admin-category-dynamic')->with('success','Category Added Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }

        }

        $type = explode(',',$request->type);

        if ($request->sub_category != null) {
            $sub_cate =   explode(',',$request->sub_category);
           $count_sub_cate = 1;
        }else{
            $count_sub_cate = 0;
         } 
        
         $category = new Category();
         $category->category = $request->category ;
         $category->sub_category = $count_sub_cate ;
         $category->service_type = $type[0] ;
         $category->service_role = $type[1] ;
         $category->save();

     

        if ($count_sub_cate == 1) {
            foreach ($sub_cate as $key => $value) {
                $sub_category = SubCategory::create([
                    'cate_id'=>$category->id,
                    'sub_category'=>$value,
                ]);
            }
        }
        
        if ($category) {
            return redirect()->to('/admin-category-dynamic')->with('success','Category Added Successfully!');
        } else {
            return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
        }
        
    }

    public function AdminGetSubCategories(Request $request)  {
        $sub_cate = SubCategory::where(['cate_id'=>$request->id])->get();
        $response['sub_cate'] = $sub_cate;
        return response()->json($response);
    }

        // Actions For Sub Categories ===
        public function ActionSubCategories(Request $request)
        {
            
            $cate = Category::find($request->cate_id);
            $sub_cate = SubCategory::find($request->sub_id);
        
            if ($request->action === 'Add') {
                $new_sub_cate = SubCategory::create([
                    'cate_id' => $request->cate_id,
                    'sub_category' => $request->sub_category,
                ]);
        
                // Update category's sub_category status
                $cate->update(['sub_category' => 1]);
        
                return response()->json([
                    'sub_cate' => $new_sub_cate,
                    'action' => $request->action,
                    'success' => 'New Sub Category Added Successfully!'
                ]);
            }
        
            $this->updateExpertProfileSubCategories($request->cate_id, $sub_cate->sub_category, $request->action, $request->sub_category);
        
            // Define common update logic for TeacherGig and TeacherGigData
            $gigs = TeacherGig::where(['category' => $request->cate_id, 'sub_category' => $sub_cate->sub_category]);
            $gigs_data = TeacherGigData::where(['category' => $request->cate_id, 'sub_category' => $sub_cate->sub_category]);
        
            if ($request->action === 'Remove') {
                $gigs->update(['sub_category' => null]);
                $gigs_data->update(['sub_category' => null]);
        
                $sub_cate->delete();
        
                // Update category's sub_category status if no subcategories remain
                $cate->update(['sub_category' => SubCategory::where('cate_id', $request->cate_id)->exists() ? 1 : 0]);
        
                return response()->json([
                    'action' => $request->action,
                    'info' => 'Sub Category Removed Successfully!'
                ]);
            }
        
            // Update existing subcategory records
            $gigs->update(['sub_category' => $request->sub_category]);
            $gigs_data->update(['sub_category' => $request->sub_category]);
        
            $sub_cate->update(['sub_category' => $request->sub_category]);
        
            return response()->json([
                'gigs' => $gigs->get(),
                'action' => $request->action,
                'success' => 'Sub Category Updated Successfully!'
            ]);
        }
        
        private function updateExpertProfileSubCategories($cate_id, $sub_category, $action, $sub_category_request)
        {
            $category = Category::find($cate_id);
            $sub_category_field = $category->service_role === 'Class' ? 'sub_category_class' : 'sub_category_freelance';
            
            $column = $category->service_role === 'Class' ? 'category_class' : 'category_freelance';

            $profiles = ExpertProfile::whereRaw("FIND_IN_SET(?, $column)", [(string) $cate_id])->get();
            
            
        
            foreach ($profiles as $profile) {
                [$onlineSubcategories, $inpersonSubcategories] = explode('|*|', $profile->$sub_category_field ?? '|*|');
        
                if ($category->service_type === 'Online') {
                    $onlineSubcategories = $this->modifySubcategories($onlineSubcategories, $sub_category, $action, $sub_category_request);
                } else {
                    $inpersonSubcategories = $this->modifySubcategories($inpersonSubcategories, $sub_category, $action, $sub_category_request);
                }
        
                $profile->$sub_category_field = $onlineSubcategories . '|*|' . $inpersonSubcategories;
                $profile->save();
            }
         

        }
        
        private function modifySubcategories($subcategories, $sub_category, $action, $sub_category_request)
        {
            $sub_array = explode(',', $subcategories);
        
            if ($action === 'Remove') {
                $sub_array = array_diff($sub_array, [$sub_category]);
            } elseif ($action === 'Update' && in_array($sub_category, $sub_array)) {
                $key = array_search($sub_category, $sub_array);
                $sub_array[$key] = $sub_category_request;
            }
        
            return implode(',', $sub_array);
        }
        

    

        public function UpdateCategoryDynamic(Request $request)
        {
            if ($redirect = $this->AdmincheckAuth()) {
                return $redirect;
            }
        
            // Find the existing category and store original type and role
            $category = Category::find($request->id);
            if (!$category) {
                return redirect()->back()->with('error', 'Category not found.');
            }
        
            $oldServiceType = $category->service_type;  // Original Online/Inperson
            $oldServiceRole = $category->service_role;  // Original Class/Freelance
        
            $type = explode(',', $request->type);
            $newServiceType = $type[0];  // New Online/Inperson
            $newServiceRole = $type[1];  // New Class/Freelance
        
            // Update category details
            $category->category = $request->category;
            $category->service_type = $newServiceType;
            $category->service_role = $newServiceRole;
            $category->status = $request->status;
            $category->save();
        
            TeacherGig::where('category', $category->id)->update([
                'category_name' => $category->category,
            ]);

            // If service_role or service_type has changed, adjust ExpertProfile
            if ($oldServiceRole != $newServiceRole || $oldServiceType != $newServiceType) {
              $pros =  ExpertProfile::all()->each(function ($profile) use ($category, $oldServiceRole, $newServiceRole, $oldServiceType, $newServiceType) {
                    $oldRoleColumn = $oldServiceRole === 'Class' ? 'category_class' : 'category_freelance';
                    $newRoleColumn = $newServiceRole === 'Class' ? 'category_class' : 'category_freelance';
        
                    $oldSubCatColumn = $oldServiceRole === 'Class' ? 'sub_category_class' : 'sub_category_freelance';
                    $newSubCatColumn = $newServiceRole === 'Class' ? 'sub_category_class' : 'sub_category_freelance';
        
                    // Move category between role columns
                    $profile->$oldRoleColumn = $this->removeItemFromCsvUpd($profile->$oldRoleColumn, $category->id);
                    $profile->$newRoleColumn = $this->addItemToCsv($profile->$newRoleColumn, $category->id);
        
                    // Adjust subcategories based on service_type
                    $oldSubCategories = explode('|*|', $profile->$oldSubCatColumn);
                    $newSubCategories = explode('|*|', $profile->$newSubCatColumn);
        
                    $oldIndex = $oldServiceType === 'Online' ? 0 : 1;
                    $newIndex = $newServiceType === 'Online' ? 0 : 1;
        
                    // Update subcategories for the new role and type
                    $oldSubList = explode(',', $oldSubCategories[$oldIndex] ?? '');
                    $newSubList = explode(',', $newSubCategories[$newIndex] ?? '');
        
                    // Remove matching subcategories in the old list
                    $updatedOldSubList = array_diff($oldSubList, SubCategory::where('cate_id', $category->id)->pluck('sub_category')->toArray());
                    $oldSubCategories[$oldIndex] = implode(',', $updatedOldSubList);
        
                    // Add subcategories to the new list
                    $updatedNewSubList = array_merge($newSubList, SubCategory::where('cate_id', $category->id)->pluck('sub_category')->toArray());
                    $newSubCategories[$newIndex] = implode(',', array_unique($updatedNewSubList));
        
                    $profile->$oldSubCatColumn = implode('|*|', $oldSubCategories);
                    $profile->$newSubCatColumn = implode('|*|', $newSubCategories);
        
                    $profile->save();
                });
               
            }
        
            return redirect()->back()->with('success', 'Category and related entries updated successfully!');
        }
        
        /**
         * Remove an item from a CSV string
         */
        private function removeItemFromCsvUpd($csv, $item)
        {
            $items = explode(',', $csv);
            $updatedItems = array_filter($items, fn($i) => $i != $item);
            return implode(',', $updatedItems);
        }
        
        /**
         * Add an item to a CSV string if not already present
         */
        private function addItemToCsv($csv, $item)
        {
            $items = explode(',', $csv);
            if (!in_array($item, $items)) {
                $items[] = $item;
            }
            return implode(',', $items);
        }
        
    
    public function CategoryDynamicDelete($id)
{
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;
    }

    // Find the category and retrieve its ID and related details
    $category = Category::find($id);

    if ($category) {
        // Delete related subcategories based on category ID
        $subCategories = SubCategory::where('cate_id', $category->id)->pluck('sub_category')->toArray();
        SubCategory::where('cate_id', $category->id)->delete();

        // Remove category and subcategory entries from TeacherGig and TeacherGigData tables
        TeacherGig::where('category', $category->id)->update([
            'category' => null,
            'category_name' => null,
            'sub_category' => null,
        ]);
        TeacherGigData::where('category', $category->id)->update([
            'category' => null,
            'sub_category' => null,
        ]);

        // Update the ExpertProfile for service_type-specific removal
        ExpertProfile::all()->each(function ($profile) use ($category, $subCategories) {
            $serviceRoleColumn = $category->service_role === 'Class' ? 'category_class' : 'category_freelance';
            $subCategoryColumn = $category->service_role === 'Class' ? 'sub_category_class' : 'sub_category_freelance';

            // Remove category ID from category_class or category_freelance
            $profile->$serviceRoleColumn = $this->removeItemFromCsv($profile->$serviceRoleColumn, $category->id);

            // Separate subcategories by type (online or in-person) and remove matching subcategories
            $subCategorySegments = explode('|*|', $profile->$subCategoryColumn);
            foreach ($subCategorySegments as &$segment) {
                $segmentItems = explode(',', $segment);
                $segment = implode(',', array_diff($segmentItems, $subCategories));
            }
            $profile->$subCategoryColumn = implode('|*|', $subCategorySegments);

            $profile->save();
        });

        // Finally, delete the category itself
        $category->delete();

        return redirect()->back()->with('success', 'Category and related entries deleted!');
    } else {
        return redirect()->back()->with('error', 'Category not found or unable to delete.');
    }
}

/**
 * Remove an item from a CSV string
 */
private function removeItemFromCsv($csv, $item)
{
    $items = explode(',', $csv);
    $updatedItems = array_filter($items, fn($i) => $i != $item);
    return implode(',', $updatedItems);
}

    // Category Dynamic Function END=================
    // About Us Dynamic Functions Start============
    
    public function AboutUsDynamic() {

       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        $about = AboutUsDynamic::first();
        return view("Admin-Dashboard.about-us", compact('about'));
    }
    
    
    
    public function UpdateAboutUsDynamic(Request $request) {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $about = AboutUsDynamic::first();

        if ($about) {

            if ($request->hasfile('cover_image_1')) {
                $image1 = $request->cover_image_1;
                $imageName1 =  $image1->getClientOriginalName();
                $imageData1 = $imageName1;
                
                if ($about->cover_image_1 != $imageData1) {
                    $image1->move(public_path().'/assets/public-site/asset/img', $imageName1);
                    $about->cover_image_1 =  $imageData1 ;
                }
            }

           
            if ($request->hasfile('cover_image_2')) {
                $image2 = $request->cover_image_2;
                $imageName2 =  $image2->getClientOriginalName();
                $imageData2 = $imageName2;
                
                if ($about->cover_image_2 != $imageData2) {
                    $image1->move(public_path().'/assets/public-site/asset/img', $imageName2);
                    $about->cover_image_2 =  $imageData2 ;
                }
            }
           


            
            $about->section_1=$request->section_1;
            $about->section_2=$request->section_2;
            $about->image_heading=$request->image_heading;
            $about->about=$request->about;
            $about->tag_line=$request->tag_line;
            $about->heading_1=$request->heading_1;
            $about->details_1=$request->detail_1;
            $about->heading_2=$request->heading_2;
            $about->details_2=$request->detail_2;
            $about->heading_3=$request->heading_3;
            $about->details_3=$request->detail_3;

            $about->update();

            if ($about) {
                
                return redirect()->back()->with('success','About Us Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }

         
        } else {

            // Handle cover image uploads with null checks
            $imageData1 = null;
            if ($request->hasfile('cover_image_1')) {
                $image1 = $request->cover_image_1;
                $imageName1 =  $image1->getClientOriginalName();
                $image1->move(public_path().'/assets/public-site/asset/img', $imageName1);
                $imageData1 = $imageName1;
            }

            $imageData2 = null;
            if ($request->hasfile('cover_image_2')) {
                $image2 = $request->cover_image_2;
                $imageName2 =  $image2->getClientOriginalName();
                $image2->move(public_path().'/assets/public-site/asset/img', $imageName2);
                $imageData2 = $imageName2;
            }
             

                $about_create = AboutUsDynamic::create([
                    'section_1'=>$request->section_1,
                    'section_2'=>$request->section_2,
                    'image_heading'=>$request->image_heading,
                    'cover_image_1'=>$imageData1,
                    'about'=>$request->about,
                    'cover_image_2'=>$imageData2,
                    'tag_line'=>$request->tag_line,
                    'heading_1'=>$request->heading_1,
                    'details_1'=>$request->detail_1,
                    'heading_2'=>$request->heading_2,
                    'details_2'=>$request->detail_2,
                    'heading_3'=>$request->heading_3,
                    'details_3'=>$request->detail_3,
                ]);


                if ($about_create) {
                
                        return redirect()->back()->with('success','About Us Details Updated Successfully!');
                    } else {
                        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                    }

        
            
        }
        
    }
    
    
    // About Us Dynamic Functions End============
    
//  Terms,Condition & Privacy,Polices Dynamic Functions Start =============

public function TermConditionDynamic() {
    
    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    
    $term = TermPrivacy::where(['type'=>'term'])->get();
    $privacy = TermPrivacy::where(['type'=>'privacy'])->get();
    return view("Admin-Dashboard.term&condition", compact('term', 'privacy'));
}



public function AddTermConditionDynamic($type) {
    
    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    
    
    return view("Admin-Dashboard.add-term&condition", compact('type'));
}




public function UploadTermConditionDynamic(Request $request) {
   
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    if ($request->detail == null) {
        return redirect()->back()->with('error',"Details Required!");
    }

      
    $term = TermPrivacy::create([
        'type'=>$request->type,
        'heading'=>$request->heading,
        'detail'=>$request->detail,
    ]);

    if ($term) {
        return redirect("/admin-term-condition-dynamic")->with('success',"Details Added Successfully!");
    } else {
        return redirect("/admin-term-condition-dynamic")->with('error','Something Went Rong,Tryagain Later!');
    }
    
    
}

public function EditTermConditionDynamic($id)  {

    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    

    $term = TermPrivacy::find($id);

    return view("Admin-Dashboard.edit-term&condition", compact('term'));
    
}

public function UpdateTermConditionDynamic(Request $request)  {
    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    if ($request->detail == null) {
        return redirect()->back()->with('error',"Details Required!");
    }

    $term = TermPrivacy::find($request->id);
    $term->heading = $request->heading;
    $term->detail = $request->detail;
    $term->update();

    if ($term) {
        return redirect("/admin-term-condition-dynamic")->with('success',"Details Updated Successfully!");
    } else {
        return redirect("/admin-term-condition-dynamic")->with('error','Something Went Rong,Tryagain Later!');
    }
}


public function DeleteTermConditionDynamic($id)  {

    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    $term = TermPrivacy::find($id);
    $term->delete();

    if ($term) {
        return redirect("/admin-term-condition-dynamic")->with('success',"Details Deleted Successfully!");
    } else {
        return redirect("/admin-term-condition-dynamic")->with('error','Something Went Rong,Tryagain Later!');
    }
    
}

//  Terms,Condition & Privacy,Polices Dynamic Functions END =============
    
    
    // Faq's Dynamic Functions Start =================
    
    public function FaqDynamic() {
        
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $pannel_faqs = PannelFaqs::all();
        $heading_faqs = FaqsHeading::all();
        $seller_faqs = Faqs::where(['type'=>'seller'])->get();
        $buyer_faqs = Faqs::where(['type'=>'buyer'])->get();
        return view("Admin-Dashboard.faq", compact('pannel_faqs','seller_faqs','buyer_faqs','heading_faqs'));
    }

    
    public function AddFaqDynamic($type) {
        
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        if ($type == 'heading') {
            return view("Admin-Dashboard.add-faq", compact('type'));
            
        } else if($type == 'general'){

            return view("Admin-Dashboard.add-faq", compact('type'));
        }else {
           
            $headings = FaqsHeading::where(['type'=>$type])->get();
            return view("Admin-Dashboard.add-faq", compact('type','headings'));
        }
        
        
    }

    

    
    public function UploadFaqDynamic(Request $request) {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        if ($request->type == 'heading') {
            if ($request->heading == null) {
                return redirect()->back()->with('error',"Faq's Heading Required!");
            
            }
            
            $faqs = FaqsHeading::create([
                'type'=>$request->heading_type,
                'heading'=>$request->heading,
            ]);
    
        } else if($request->type == 'general'){
            if ($request->answer == null) {
                return redirect()->back()->with('error',"Faq's Answer is Required!");
             }

             $faqs = PannelFaqs::create([
                'type'=>$request->faq_type,
                'question'=>$request->question,
                'answer'=>$request->answer,
            ]);

        } else{
            if ($request->answer == null) {
                return redirect()->back()->with('error',"Faq's Answer is Required!");
             }
            if ($request->heading == null) {
                return redirect()->back()->with('error',"Faq's Heading is Required!");
             }
             $heading = FaqsHeading::find($request->heading);
            
            $faqs = Faqs::create([
                'type'=>$heading->type,
                'heading'=>$request->heading,
                'question'=>$request->question,
                'answer'=>$request->answer,
            ]);
    
        }

      
        if ($faqs) {
            return redirect("/admin-faq-dynamic")->with('success',"Faq's Added Successfully!");
        } else {
            return redirect("/admin-faq-dynamic")->with('error','Something Went Rong,Tryagain Later!');
        }
        
    }

    
    public function EditFaqDynamic($id) {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $faq = Faqs::find($id);
        $heading = FaqsHeading::find($faq->heading);
        $headings = FaqsHeading::where(['type'=>$faq->type])->get();
        $type = 'faq';
        return view("Admin-Dashboard.edit-faqs",compact('faq','type','heading','headings'));
    }


    
    
    public function EditFaqHeadingDynamic($id) {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $faq = FaqsHeading::find($id);
        $type = 'heading';
        return view("Admin-Dashboard.edit-faqs",compact('faq','type'));
    }

    
    public function EditFaqGeneralDynamic($id) {
        
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $faq = PannelFaqs::find($id);
        $type = 'general';
        return view("Admin-Dashboard.edit-faqs",compact('faq','type'));
    }


    
    public function UpdateFaqDynamic(Request $request) {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        if ($request->type == 'heading') {
            if ($request->heading == null) {
                return redirect()->back()->with('error',"Faq's Heading Required!");
            
            }
           
            $faq = FaqsHeading::find($request->id);
                $faq_content = Faqs::where(['heading'=>$faq->id])->get();
                if ($faq_content) {
                   foreach ($faq_content as $key => $value) {
                     $value->type = $request->heading_type;
                     $value->update();
                   }
                }
            $faq->type = $request->heading_type;
            $faq->heading = $request->heading;
            $faq->update();
        } else if($request->type == 'general'){
            if ($request->answer == null) {
                return redirect()->back()->with('error',"Faq's Answer Required!");
            }

            $faq = PannelFaqs::find($request->id);
    
            $faq->type = $request->faq_type;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->update();
       
        }else {
            if ($request->answer == null) {
                return redirect()->back()->with('error',"Faq's Answer Required!");
            
            }
           
            $faq = Faqs::find($request->id);
    
            $faq->heading = $request->heading;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->update();
        }
        
      

        if ($faq) {
            return redirect("/admin-faq-dynamic")->with('success',"Faq's Updated Successfully!");
        } else {
            return redirect("/admin-faq-dynamic")->with('error','Something Went Rong,Tryagain Later!');
        }

    }


    public function DeleteFaqDynamic($id) {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $faq = Faqs::find($id);
        $faq->delete();

        if ($faq) {
            return redirect("/admin-faq-dynamic")->with('success',"Faq's Deleted!");
        } else {
            return redirect("/admin-faq-dynamic")->with('error','Something Went Rong,Tryagain Later!');
        }
        
    }


    public function DeleteFaqHeadingDynamic($id) {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $faq = FaqsHeading::find($id);

        $faq_content = Faqs::where(['heading'=>$faq->id])->get();
        if ($faq_content) {
           foreach ($faq_content as $key => $value) {
             $value->delete();
           }
        }

        $faq->delete();

        if ($faq) {
            return redirect("/admin-faq-dynamic")->with('success',"Faq's Deleted!");
        } else {
            return redirect("/admin-faq-dynamic")->with('error','Something Went Rong,Tryagain Later!');
        }
        
    }

    public function DeleteFaqGeneralDynamic($id) {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $faq = PannelFaqs::find($id);
        $faq->delete();

        if ($faq) {
            return redirect("/admin-faq-dynamic")->with('success',"Faq's Deleted!");
        } else {
            return redirect("/admin-faq-dynamic")->with('error','Something Went Rong,Tryagain Later!');
        }
        
    }



    // Faq's Dynamic Functions END =================
    
    
    // Social Media Dynamic Functions Start ====================
    
    public function SocialMediaDynamic() {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        } 
        
        $links = SocialMedia::first();
        
        return view("Admin-Dashboard.social-media", compact('links'));
    }
    
    
    
    
    public function UpdateSocialMediaDynamic(Request $request) {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        
        $links = SocialMedia::first();
        if ($links) {
            $links->facebook_link = $request->facebook;
            $links->insta_link = $request->insta;
            $links->twitter_link = $request->twitter;
            $links->youtube_link = $request->youtube;
            $links->tiktok_link = $request->tiktok;
            $links->update();
            if ($links) {
                return redirect()->back()->with('success','Social Media Links Generated Successfuly!');
            } else {
                   return redirect()->back()->with('error','Something Went Rong, Tryagain Later!');
               }
            
        }else{
           $social_create = SocialMedia::create([
            'facebook_link'=>$request->facebook,
            'insta_link'=>$request->insta,
            'twitter_link'=>$request->twitter,
            'youtube_link'=>$request->youtube,
            'tiktok_link'=>$request->tiktok,
           ]);

           if ($social_create) {
            return redirect()->back()->with('success','Social Media Links Generated Successfuly!');
        } else {
               return redirect()->back()->with('error','Something Went Rong, Tryagain Later!');
           }
           
        }
    }
    

    public function SocialMediaStatusChange(Request $request)  {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $links = SocialMedia::first();
        if ($links) {
          
            if ($request->link_name == 'facebook') {

                if ($links->facebook_link != null) {
                    
                    if ($links->facebook_status == 0) {
                        $links->facebook_status = 1;
                    } else {
                        $links->facebook_status = 0;
                    }
                    $links->update();
                    if ($links) {
                        return response()->json(['success'=> true,
            'message'=>'This Social Media Link Status Changed!']);
                    } else {
                        return response()->json(['error'=> true,
            'message'=>'Please Update Social Media Links First!']);
                    }
                    
                    
                } else {
                    return response()->json(['error'=> true,
                    'message'=>'Please Add Link For Change Status!']);
                }
                
            }
          
            if ($request->link_name == 'insta') {

                if ($links->insta_link != null) {
                    
                    if ($links->insta_status == 0) {
                        $links->insta_status = 1;
                    } else {
                        $links->insta_status = 0;
                    }
                    $links->update();
                    if ($links) {
                        return response()->json(['success'=> true,
            'message'=>'This Social Media Link Status Changed!']);
                    } else {
                        return response()->json(['error'=> true,
            'message'=>'Please Update Social Media Links First!']);
                    }
                    
                    
                } else {
                    return response()->json(['error'=> true,
                    'message'=>'Please Add Link For Change Status!']);
                }
                
            }
            
          
            if ($request->link_name == 'twitter') {

                if ($links->twitter_link != null) {
                    
                    if ($links->twitter_status == 0) {
                        $links->twitter_status = 1;
                    } else {
                        $links->twitter_status = 0;
                    }
                    $links->update();
                    if ($links) {
                        return response()->json(['success'=> true,
            'message'=>'This Social Media Link Status Changed!']);
                    } else {
                        return response()->json(['error'=> true,
            'message'=>'Please Update Social Media Links First!']);
                    }
                    
                    
                } else {
                    return response()->json(['error'=> true,
                    'message'=>'Please Add Link For Change Status!']);
                }
                
            }
            
          
            if ($request->link_name == 'youtube') {

                if ($links->youtube_link != null) {
                    
                    if ($links->youtube_status == 0) {
                        $links->youtube_status = 1;
                    } else {
                        $links->youtube_status = 0;
                    }
                    $links->update();
                    if ($links) {
                        return response()->json(['success'=> true,
            'message'=>'This Social Media Link Status Changed!']);
                    } else {
                        return response()->json(['error'=> true,
            'message'=>'Please Update Social Media Links First!']);
                    }
                    
                    
                } else {
                    return response()->json(['error'=> true,
                    'message'=>'Please Add Link For Change Status!']);
                }
                
            }
            
            
          
            if ($request->link_name == 'tiktok') {

                if ($links->tiktok_link != null) {
                    
                    if ($links->tiktok_status == 0) {
                        $links->tiktok_status = 1;
                    } else {
                        $links->tiktok_status = 0;
                    }
                    $links->update();
                    if ($links) {
                        return response()->json(['success'=> true,
            'message'=>'This Social Media Link Status Changed!']);
                    } else {
                        return response()->json(['error'=> true,
            'message'=>'Please Update Social Media Links First!']);
                    }
                    
                    
                } else {
                    return response()->json(['error'=> true,
                    'message'=>'Please Add Link For Change Status!']);
                }
                
            }
            



        }else{
            return response()->json(['error'=> true,
            'message'=>'Please Update Social Media Links First!']);
        }
     



        
    }
    
    
    // Social Media Dynamic Functions End ====================

    // BEcome Expert Dynamic Functions Start ==============
    
    public function BecomeExpertDynamic() {

       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $expert = BecomeExpert::first();
        $expertfaqs = BecomeExpertFaqs::all();

        return view("Admin-Dashboard.become-expert", compact('expert','expertfaqs'));
    }
    
    

    public function UpdateBecomeExpertDynamic(Request $request) {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        if ($request->host_description == null) {
            return redirect()->back()->with('error','Host Description is Required!');
            
        }

        $expert = BecomeExpert::first();


        
        if ($expert) {

                
            if ($request->hasfile('hero_image')) {
                $hero_image = $request->hero_image;
                $hero_imageName =  $hero_image->getClientOriginalName();
                $hero_imageData = $hero_imageName;
                
                if ($expert->hero_image != $hero_imageData) {
                     $hero_image->move(public_path().'/assets/expert/asset/img', $hero_imageName);
                $expert->hero_image =  $hero_imageData ;
                }
            }
             
 
                
            if ($request->hasfile('work_image_1')) {
                $work_image_1 = $request->work_image_1;
                $work_image_1Name =  $work_image_1->getClientOriginalName();
                $work_image_1Data = $work_image_1Name;
                
                if ($expert->work_image_1 != $work_image_1Data) {
                     $work_image_1->move(public_path().'/assets/expert/asset/img', $work_image_1Name);
                $expert->work_image_1 =  $work_image_1Data ;
                }
            }
             
 
 
                
            if ($request->hasfile('work_image_2')) {
                $work_image_2 = $request->work_image_2;
                $work_image_2Name =  $work_image_2->getClientOriginalName();
                $work_image_2Data = $work_image_2Name;
                
                if ($expert->work_image_2 != $work_image_2Data) {
                     $work_image_2->move(public_path().'/assets/expert/asset/img', $work_image_2Name);
                $expert->work_image_2 =  $work_image_2Data ;
                }
            }
                
            if ($request->hasfile('work_image_3')) {
                $work_image_3 = $request->work_image_3;
                $work_image_3Name =  $work_image_3->getClientOriginalName();
                $work_image_3Data = $work_image_3Name;
                
                if ($expert->work_image_3 != $work_image_3Data) {
                     $work_image_3->move(public_path().'/assets/expert/asset/img', $work_image_3Name);
                $expert->work_image_3 =  $work_image_3Data ;
                }
            }
             
                
            if ($request->hasfile('host_image_1')) {
                $host_image_1 = $request->host_image_1;
                $host_image_1Name =  $host_image_1->getClientOriginalName();
                $host_image_1Data = $host_image_1Name;
                
                if ($expert->host_image_1 != $host_image_1Data) {
                     $host_image_1->move(public_path().'/assets/expert/asset/img', $host_image_1Name);
                $expert->host_image_1 =  $host_image_1Data ;
                }
            }
             
 
                
            if ($request->hasfile('host_image_2')) {
                $host_image_2 = $request->host_image_2;
                $host_image_2Name =  $host_image_2->getClientOriginalName();
                $host_image_2Data = $host_image_2Name;
                
                if ($expert->host_image_2 != $host_image_2Data) {
                     $host_image_2->move(public_path().'/assets/expert/asset/img', $host_image_2Name);
                $expert->host_image_2 =  $host_image_2Data ;
                }
            }
             
 
                
            if ($request->hasfile('host_image_3')) {
                $host_image_3 = $request->host_image_3;
                $host_image_3Name =  $host_image_3->getClientOriginalName();
                $host_image_3Data = $host_image_3Name;
                
                if ($expert->host_image_3 != $host_image_3Data) {
                     $host_image_3->move(public_path().'/assets/expert/asset/img', $host_image_3Name);
                $expert->host_image_3 =  $host_image_3Data ;
                }
            }
             
 
                
            if ($request->hasfile('host_image_4')) {
                $host_image_4 = $request->host_image_4;
                $host_image_4Name =  $host_image_4->getClientOriginalName();
                $host_image_4Data = $host_image_4Name;
                
                if ($expert->host_image_4 != $host_image_4Data) {
                     $host_image_4->move(public_path().'/assets/expert/asset/img', $host_image_4Name);
                $expert->host_image_4 =  $host_image_4Data ;
                }
            }
             
                
            if ($request->hasfile('expert_image')) {
                $expert_image = $request->expert_image;
                $expert_imageName =  $expert_image->getClientOriginalName();
                $expert_imageData = $expert_imageName;
                
                if ($expert->expert_image != $expert_imageData) {
                     $expert_image->move(public_path().'/assets/expert/asset/img', $expert_imageName);
                $expert->expert_image =  $expert_imageData ;
                }
            }
             
            $expert->hero_heading= $request->hero_heading ;
            $expert->hero_description= $request->hero_description ;
            $expert->hero_btn_link= $request->hero_btn_link ;
            $expert->work_heading_1= $request->work_heading_1 ;
            $expert->work_detail_1= $request->work_detail_1 ;
            $expert->work_heading_2= $request->work_heading_2 ;
            $expert->work_detail_2= $request->work_detail_2 ;
            $expert->work_heading_3= $request->work_heading_3 ;
            $expert->work_detail_3= $request->work_detail_3 ;
            $expert->host_heading= $request->host_heading ;
            $expert->host_description= $request->host_description ;
            $expert->feature_heading= $request->feature_heading ;
            
            // $expert->faqs= $request->faqs ;
            $expert->banner_heading= $request->banner_heading ;
            $expert->banner_btn_link= $request->banner_btn_link ;
            $expert->expert_heading= $request->expert_heading ;
            // $expert->expert_btn_link= $request->expert_btn_link ;

            $expert->update();

            if ($expert) {
                
                return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
            }
            
                 
            } else {

                // Handle hero_image upload with null check
                $hero_imageData = null;
                if ($request->hasfile('hero_image')) {
                    $hero_image = $request->hero_image;
                    $hero_imageName =  $hero_image->getClientOriginalName();
                    $hero_image->move(public_path().'/assets/expert/asset/img', $hero_imageName);
                    $hero_imageData = $hero_imageName;
                }

                $host_image_1Data = null;
                if ($request->hasfile('host_image_1')) {
                    $host_image_1 = $request->host_image_1;
                    $host_image_1Name =  $host_image_1->getClientOriginalName();
                    $host_image_1->move(public_path().'/assets/expert/asset/img', $host_image_1Name);
                    $host_image_1Data = $host_image_1Name;
                }
    

                $host_image_2Data = null;
                if ($request->hasfile('host_image_2')) {
                    $host_image_2 = $request->host_image_2;
                    $host_image_2Name =  $host_image_2->getClientOriginalName();
                    $host_image_2->move(public_path().'/assets/expert/asset/img', $host_image_2Name);
                    $host_image_2Data = $host_image_2Name;
                }
    

                $host_image_3Data = null;
                if ($request->hasfile('host_image_3')) {
                    $host_image_3 = $request->host_image_3;
                    $host_image_3Name =  $host_image_3->getClientOriginalName();
                    $host_image_3->move(public_path().'/assets/expert/asset/img', $host_image_3Name);
                    $host_image_3Data = $host_image_3Name;
                }
    
    

                $host_image_4Data = null;
                if ($request->hasfile('host_image_4')) {
                    $host_image_4 = $request->host_image_4;
                    $host_image_4Name =  $host_image_4->getClientOriginalName();
                    $host_image_4->move(public_path().'/assets/expert/asset/img', $host_image_4Name);
                    $host_image_4Data = $host_image_4Name;
                }
    
    

                $expert_imageData = null;
                if ($request->hasfile('expert_image')) {
                    $expert_image = $request->expert_image;
                    $expert_imageName =  $expert_image->getClientOriginalName();
                    $expert_image->move(public_path().'/assets/expert/asset/img', $expert_imageName);
                    $expert_imageData = $expert_imageName;
                }
    
    

                $work_image_1Data = null;
                if ($request->hasfile('work_image_1')) {
                    $work_image_1 = $request->work_image_1;
                    $work_image_1Name =  $work_image_1->getClientOriginalName();
                    $work_image_1->move(public_path().'/assets/expert/asset/img', $work_image_1Name);
                    $work_image_1Data = $work_image_1Name;
                }
    

                $work_image_2Data = null;
                if ($request->hasfile('work_image_2')) {
                    $work_image_2 = $request->work_image_2;
                    $work_image_2Name =  $work_image_2->getClientOriginalName();
                    $work_image_2->move(public_path().'/assets/expert/asset/img', $work_image_2Name);
                    $work_image_2Data = $work_image_2Name;
                }
    

                $work_image_3Data = null;
                if ($request->hasfile('work_image_3')) {
                    $work_image_3 = $request->work_image_3;
                    $work_image_3Name =  $work_image_3->getClientOriginalName();
                    $work_image_3->move(public_path().'/assets/expert/asset/img', $work_image_3Name);
                    $work_image_3Data = $work_image_3Name;
                }
    
    
    
     
               

                $expert = BecomeExpert::create([
                'hero_heading'=> $request->hero_heading ,
                'hero_description'=> $request->hero_description ,
                'hero_btn_link'=> $request->hero_btn_link ,
                'hero_image'=> $hero_imageData ,
                'work_heading_1'=> $request->work_heading_1 ,
                'work_detail_1'=> $request->work_detail_1 ,
                'work_image_1'=> $work_image_1Data ,
                'work_heading_2'=> $request->work_heading_2 ,
                'work_detail_2'=> $request->work_detail_2 ,
                'work_image_2'=> $work_image_2Data ,
                'work_heading_3'=> $request->work_heading_3 ,
                'work_detail_3'=> $request->work_detail_3 ,
                'work_image_3'=> $work_image_3Data ,
                'host_heading'=> $request->host_heading ,
                'host_description'=> $request->host_description ,
                'host_image_1'=> $host_image_1Data ,
                'host_image_2'=> $host_image_2Data ,
                'host_image_3'=> $host_image_3Data ,
                'host_image_4'=> $host_image_4Data ,
                'feature_heading'=> $request->feature_heading ,
                // 'faqs'=> $request->faqs ,
                'banner_heading'=> $request->banner_heading ,
                'banner_btn_link'=> $request->banner_btn_link ,
                'expert_heading'=> $request->expert_heading ,
                // 'expert_btn_link'=> $request->expert_btn_link ,
                'expert_image'=> $expert_imageData ,
                ]);


                if ($expert) {
                
                    return redirect()->back()->with('success','Home Dynamic Details Updated Successfully!');
                } else {
                    return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
                }
                
            }
            


        
    }
    
//  Become Expert Dynamic Host Feature Functions Start ========
    public function GetHostFeature()  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
       
        $feature = HostFeature::all();
     
        $response['features'] = $feature;
        
        return response()->json($response);

    }
    
    
    

    public function HostFeatureAdd(Request $request)  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $feature = HostFeature::create([
            'feature'=> $request->feature,
        ]);
        
        if ($feature) {
            $response['response'] = 'success';
            $response['message'] = 'Host Feature Added Successfuly!';
        } else {
            $response['response'] = 'error';
            $response['message'] = 'Something Went Rong,Tryagain Later!';
        }
        
        $feature = HostFeature::all();
        $response['features'] = $feature;
        
        return response()->json($response);

    }
    

    public function HostFeatureDelete(Request $request)  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $feature = HostFeature::find($request->id);
        $feature->delete();
        if ($feature) {
            $response['response'] = 'success';
            $response['message'] = 'This Host Feature Deleted Successfuly!';
        } else {
           $response['response'] = 'error';
            $response['message'] = 'Something Went Rong,Tryagain Later!';
        }

        $feature = HostFeature::all();
     
        
        $response['features'] = $feature;
        
        return response()->json($response);

    }
    
    
// Update Host Features
    public function HostFeatureUpdate(Request $request)  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $feature = HostFeature::find($request->id);
        $feature->feature = $request->feature;
        $feature->update();
        if ($feature) {
            $response['response'] = 'success';
            $response['message'] = 'This Host Feature Updated Successfuly!';
        } else {
           $response['response'] = 'error';
            $response['message'] = 'Something Went Rong,Tryagain Later!';
        }

        $feature = HostFeature::all();
     
        
        $response['features'] = $feature;
        
        return response()->json($response);

    }
    
    //  Become Expert Dynamic Host Feature Functions END ========
    
    
    
//  Become Expert Dynamic Key Points Functions Start ========
    public function GetKeyPoints()  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
       
        $point = ExpertKeyPoint::all();
     
        $response['points'] = $point;
        
        return response()->json($response);

    }
    
    
    

    public function KeyPointsAdd(Request $request)  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $point = ExpertKeyPoint::create([
            'point'=> $request->points,
        ]);
        
        if ($point) {
            $response['response'] = 'success';
            $response['message'] = 'Host Feature Added Successfuly!';
        } else {
            $response['response'] = 'error';
            $response['message'] = 'Something Went Rong,Tryagain Later!';
        }
        
        $point = ExpertKeyPoint::all();
        $response['points'] = $point;
        
        return response()->json($response);

    }
    

    public function KeyPointsDelete(Request $request)  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $point = ExpertKeyPoint::find($request->id);
        $point->delete();
        if ($point) {
            $response['response'] = 'success';
            $response['message'] = 'This Host Feature Deleted Successfuly!';
        } else {
           $response['response'] = 'error';
            $response['message'] = 'Something Went Rong,Tryagain Later!';
        }

        $point = ExpertKeyPoint::all();
     
        
        $response['points'] = $point;
        
        return response()->json($response);

    }
    
    //  Become Expert Dynamic Key Points Functions END ========
    
    //  Become Expert Dynamic Faqs Update  Functions Start ========
    public function AdminBecomeExpertFaqsUpdate(Request $request)  {

        if ($request->question == null || $request->answer == null) {
            $response['error'] = true;
            $response['message'] = 'Faqs Question and Answer Required!';
            return response()->json($response);
        }
        
        $faqs = BecomeExpertFaqs::find($request->id);
        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->status = $request->status;
        $faqs->update();

        if ($faqs) {
            $faqs = BecomeExpertFaqs::all();
            $response['faqs'] = $faqs;
            $response['success'] = true;
            $response['message'] = 'Faqs Updated Successfully!';
            return response()->json($response);

        } else {
            $response['error'] = true;
            $response['message'] = 'Something Went Rong,Tryagain Later!';
            return response()->json($response);
        }
        
    }
    //  Become Expert Dynamic Faqs Update  Functions END ========

    // BEcome Expert Dynamic Functions END ==============
    
    // Site Banner Functions Start ==============


    public function SiteBannerDynamic() {
           
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $banner = SiteBanner::all();
        return view("Admin-Dashboard.site-banner", compact('banner'));
    }


    public function AddSiteBanner() {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        return view("Admin-Dashboard.add-site-banner");
    }


    public function UploadSiteBanner(Request $request) {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        if ($request->description == null) {
            return redirect()->back()->with('error','Description is Required!');
        }

        $banner = SiteBanner::create([
            'heading'=>$request->heading,
            'description'=>$request->description,
        ]);


        if ($banner) {
                
            return redirect()->to('/admin-site-banner-dynamic')->with('success','Site Banner Uploaded Successfully!');
        } else {
            return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
        }

    }






    public function EditSiteBanner($id) {
           
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $banner = SiteBanner::find($id);
        return view("Admin-Dashboard.edit-site-banner", compact('banner'));
    }


    
    public function UpdateSiteBanner(Request $request) {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        if ($request->description == null) {
            return redirect()->back()->with('error','Description is Required!');
        }

        $banner = SiteBanner::find($request->id);
        $banner->heading = $request->heading;
        $banner->description = $request->description;
        $banner->update();

        if ($banner) {
                
            return redirect()->to('/admin-site-banner-dynamic')->with('success','Site Banner Updated Successfully!');
        } else {
            return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
        }

    }

    

    public function DeleteSiteBanner($id) {
           
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
       
        $banner = SiteBanner::find($id);
        $banner->delete();

        if ($banner) {
                
            return redirect()->to('/admin-site-banner-dynamic')->with('success','Site Banner Updated Successfully!');
        } else {
            return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
        }
    }


    
    // Site Banner Functions END ==============
    
    
    

    public function ContactUsDynamic() {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        return view("Admin-Dashboard.contact-us");
    }
    
    
 

    public function VerificationCenterDynamic() {

         
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        $expert = BecomeExpert::first();
        return view("Admin-Dashboard.verification-center", compact('expert'));
    }
    
    // Verification Update Function Start ==========
    public function UpdateVerificationCenter(Request $request)  {

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $expert = BecomeExpert::first();

        if ($expert) {
            $expert->verification_center = $request->verification;
            $expert->update();

            if ($expert) {
                return response()->json(['success'=> true,
                'message'=>'Verification Center Updated Successfully!']);
               } else {
                return response()->json(['error'=> true,
                'message'=>'Something Wrong, Tryagain Later!']);
               }
               
        } else {
           $expert = BecomeExpert::create([
            'verification_center'=>$request->verification,
           ]);

           if ($expert) {
            return response()->json(['success'=> true,
            'message'=>'Verification Center Updated Successfully!']);
           } else {
            return response()->json(['error'=> true,
            'message'=>'Something Wrong, Tryagain Later!']);
           }
           
        }
        
        
    }
    // Verification Update Function End ==========
    
    // Languages Dynamic Functions Start =========================
    
    public function LanguagesDynamic() {

         
     
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        return view("Admin-Dashboard.add-languages");
    }

    
    
    public function GetLanguagesDynamic() {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $languages = Languages::all();
        $response['languages'] = $languages;
        return response()->json($response);
        
    }

    
    
    public function AddLanguagesDynamic(Request $request) {
       

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
       $language = Languages::create([
            'language'=>$request->language,
         ]);

        //  $languages = Languages::all();
         $response['languages'] = $language;
         return response()->json($response);
    }
    
    
    public function DeleteLanguagesDynamic(Request $request) {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

       $language = Languages::find($request->id);
       $response['languages'] = $language->id;
       $language->delete();
        //  $languages = Languages::all();
         return response()->json($response);
    }


    // Languages Dynamic Functions End =========================
    

      
    // Languages Dynamic Functions Start =========================
    
    public function KeywordDynamic() {

         
     
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

        return view("Admin-Dashboard.keyword-suggessions");
    }

    
    
    public function GetKeywordDynamic() {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
        $keywords = KeywordSuggession::all();
        $response['keywords'] = $keywords;
        return response()->json($response);
        
    }

    
    
    public function AddKeywordDynamic(Request $request) {
       

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        
       $keyword = KeywordSuggession::create([
            'keyword'=>$request->keyword,
         ]);

         $keywords = KeywordSuggession::all();
         $response['keywords'] = $keywords;
         return response()->json($response);
    }
    
    
    public function DeleteKeywordDynamic(Request $request) {
       
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }
        

       $keyword = KeywordSuggession::find($request->id);
       $keyword->delete();
         $keywords = KeywordSuggession::all();
         $response['keywords'] = $keywords;
         return response()->json($response);
    }


    // Languages Dynamic Functions End =========================


    // Booking Duration Dynamic Functions Start =========================

    public function BookingDuration() {
        
        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }

        $duration = BookingDuration::first();
        
        return view("Admin-Dashboard.booking-duration", compact('duration'));
    }

    // Update ////////////
    public function BookingDurationUpdate(Request $request){

        if ($redirect = $this->AdmincheckAuth()) {
            return $redirect;  
        }

        $duration = BookingDuration::first();

        if ($duration) {
            $duration->class_online = $request->class_online;
            $duration->class_inperson = $request->class_inperson;
            $duration->class_oneday = $request->class_oneday;
            $duration->reschedule = $request->reschedule;
            $duration->freelance_online_normal = $request->freelance_online_normal;
            $duration->freelance_online_consultation = $request->freelance_online_consultation;
            $duration->freelance_inperson = $request->freelance_inperson;
            $duration->update();
        } else {
           $duration = new BookingDuration();
           $duration->class_online = $request->class_online;
           $duration->class_inperson = $request->class_inperson;
           $duration->class_oneday = $request->class_oneday;
           $duration->reschedule = $request->reschedule;
           $duration->freelance_online_normal = $request->freelance_online_normal;
           $duration->freelance_online_consultation = $request->freelance_online_consultation;
           $duration->freelance_inperson = $request->freelance_inperson;
           $duration->save();
        }
        

        if ($duration) {
            return redirect()->back()->with('success',"Booking Duration Updated Successfully!");
        } else {
            return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
        }
    
        


    }

    // Booking Duration Dynamic Functions End =========================
    


    // Admin Host Guidline Functions Start ================
public function AdminHostGuidline()  {
    
    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    $host = HostGuidline::all();
    return view("Admin-Dashboard.host-guideline", compact('host'));

}


public function AddHostGuidline()  {
    
   
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    
   
    return view("Admin-Dashboard.add-host-guidelines" );

}

public function UploadHostGuidline(Request $request)  {

    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    if ($request->detail == null) {
        return redirect()->back()->with('error',"Host Guidline Details Required!");
    
    }
    
    $host = HostGuidline::create([
        'heading'=>$request->heading,
        'detail'=>$request->detail,
    ]);

    if ($host) {
        return redirect("/admin-host-guidline")->with('success',"Host Guidline Added Successfully!");
    } else {
        return redirect("admin-host-guidline")->with('error','Something Went Rong,Tryagain Later!');
    }

    
}

public function EditHostGuidline($id)  {
    
  
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    

    $host = HostGuidline::find($id);
    
    return view("Admin-Dashboard.add-host-guideline", compact('host'));

}


public function UpdateHostGuidline(Request $request)  {

    
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    if ($request->detail == null) {
        return redirect()->back()->with('error',"Host Guidline Details Required!");
    
    }
  
   
    $host = HostGuidline::find($request->id);

    $host->heading = $request->heading;
    $host->detail = $request->detail;
    $host->update();

    if ($host) {
        return redirect("/admin-host-guidline")->with('success',"Host Guidline Updated Successfully!");
    } else {
        return redirect("admin-host-guidline")->with('error','Something Went Rong,Tryagain Later!');
    }

    
}


public function DeleteHostGuidline($id)  {
   
    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    

    $host = HostGuidline::find($id);
    
    $host->delete();

    if ($host) {
        return redirect("/admin-host-guidline")->with('success',"Host Guidline Deleted!");
    } else {
        return redirect("admin-host-guidline")->with('error','Something Went Rong,Tryagain Later!');
    }
}



// Admin Host GuidLine Functions END ================

// Admin Top Seller Functions Start ================
public function AdminTopSeller()  {

    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }

    $tag = TopSellerTag::first();
    return view('Admin-Dashboard.TopSellerTag',compact('tag'));
    
}

// Top Seller Tag Update Setting
public function UpdateTopSellerRe(Request $request)   {

    $tag = TopSellerTag::first();

  

    if ($tag) {
        $tag->earning = $request->earning;
        $tag->booking = $request->booking;
        $tag->review = $request->review;
        $tag->update();
    } else {
        $tag = new TopSellerTag();
        $tag->earning = $request->earning;
        $tag->booking = $request->booking;
        $tag->review = $request->review;
        $tag->save();
         
    }
    
    if ($tag) {
        return redirect()->back()->with('success',"Top Seller Tag Requirements Updated!");
    } else {
        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    }
    
}
// Admin Top Seller Functions END ================

// Admin Services Listing Sorting Functions Start ================
public function AdminServicesSorting()  {

    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    $tag = TopSellerTag::first();
    return view('Admin-Dashboard.ServicesSorting',compact('tag'));
    
}

// Sorting Setting  Update Setting
public function UpdateServicesSortingRe(Request $request)   {

    $tag = TopSellerTag::first();

  

    if ($tag) {
        $tag->sorting_impressions = $request->impressions;
        $tag->sorting_clicks = $request->clicks;
        $tag->sorting_orders = $request->orders;
        $tag->sorting_reviews = $request->reviews;
        $tag->update();
    } else {
        $tag = new TopSellerTag();
        $tag->sorting_impressions = $request->impressions;
        $tag->sorting_clicks = $request->clicks;
        $tag->sorting_orders = $request->orders;
        $tag->sorting_reviews = $request->reviews;
        $tag->save();
         
    }
    
    if ($tag) {
        return redirect()->back()->with('success',"Services Sorting Setting Updated!");
    } else {
        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    }
    
}
// Admin Services Listing Sorting Functions END ================

// Admin Commission Set Functions Start ================
public function AdminCommissionSet()  {

    if ($redirect = $this->AdmincheckAuth()) {
        return $redirect;  
    }
    
    $tag = TopSellerTag::first();
    return view('Admin-Dashboard.CommissionSet',compact('tag'));
    
}

// Sorting Setting  Update Setting
public function UpdateCommissionRe(Request $request)   {

    
    $request->validate([
        'commission' => 'required|integer|min:5|max:30',
    ], [
        'commission.min' => 'The commission must be at least 5%.',
        'commission.max' => 'The commission cannot exceed 30%.'
    ]);
    
    $tag = TopSellerTag::first();

    if ($tag) {
        $tag->commission = $request->commission; 
        $tag->update();
    } else {
        $tag = new TopSellerTag();
        $tag->commission = $request->commission;  
        $tag->save();
         
    }
    
    if ($tag) {
        return redirect()->back()->with('success',"Commission Rate Updated Successfuly Updated!");
    } else {
        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    }
    
}



// Buyer Commision Update Setting
public function UpdateBuyerCommissionRe(Request $request)   {

    if ($request->buyer_commission == 1) {
      
            $request->validate([
                'buyer_commission_rate' => 'required|integer|min:1|max:15',
            ], [
                'buyer_commission_rate.min' => 'The commission must be at least 1%.',
                'buyer_commission_rate.max' => 'The commission cannot exceed 15%.'
            ]);
        }


    $tag = TopSellerTag::first();

    if ($tag) {
        $tag->buyer_commission = $request->buyer_commission; 
        $tag->buyer_commission_rate = $request->buyer_commission_rate; 
        $tag->update();
    } else {
        $tag = new TopSellerTag();
        $tag->buyer_commission = $request->buyer_commission; 
        $tag->buyer_commission_rate = $request->buyer_commission_rate; 
        $tag->save();
         
    }
    
    if ($tag) {
        return redirect()->back()->with('success',"Buyer Commission Rate Updated Successfuly Updated!");
    } else {
        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    }
    
}
// Admin Commission Set Functions END ================




}
