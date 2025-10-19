<?php

namespace App\Http\Controllers;

use App\Mail\ChangeEmail;
use App\Mail\ContactMail;
use App\Models\BankDetails;
use App\Models\DeleteAccounts;
use Illuminate\Support\Facades\Auth;
use App\Models\Faqs;
use App\Models\PannelFaqs;
use App\Models\User;
use App\Models\WishList;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function UsercheckAuth() {

        if (!Auth::user()) {
           return redirect()->to('/')->with('error','Please LoginIn to Your Account!');
        } else {
            if (Auth::user()->role == 1) {
                return redirect()->to('/teacher-dashboard');
            }elseif(Auth::user()->role == 2){
                return redirect()->to('/admin-dashboard');
            }
        }
        
        
    }
    
    public function UserDashboard()  {
                
        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;  
        }
        
        return view("User-Dashboard.index");
    }

    
    public function UserFaqs()  {
          
        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;  
        }
        
         

        $faqs = PannelFaqs::where(['type'=>'buyer'])->get();
        return view("User-Dashboard.faq", compact('faqs'));
    }


    
    public function ChangePassword()  {
       
        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        return view("User-Dashboard.change-pass");
    }


    
    public function ChangeEmail()  {

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }
        return view("User-Dashboard.change-email");
    }


    
    public function ChangeCardDetail()  {
 
        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }
        
        $bank_details = BankDetails::where(['user_id'=>Auth::user()->id])->first();
        return view("User-Dashboard.card-detail", compact('bank_details'));
    }


    
    public function DeleteAccount(Request $request)  {
 
        if (!Auth::user()) {
            return redirect('/');
        }

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        $user = User::find(Auth::user()->id);

        if ($request->mainOptions == 'option1') {
             
            $delete_account = DeleteAccounts::create([
                'user_id'=> $user->id,
                'user_email'=> $user->email,
                'reason'=> "I completed a job and don't need Dreamcrowd anymore",
            ]);

            if ($delete_account) {
                 $user->delete();
                 Auth::logout();
                return redirect()->to('/')->with('success','Account Deleted!');
                
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    
            }
        } elseif ($request->mainOptions == 'option2') {

            $delete_account = DeleteAccounts::create([
                'user_id'=> $user->id,
                'user_email'=> $user->email,
                'reason'=> "I find it hard to use Dreamcrowd",
                'additional_reason'=> $request->additionalOption2,
            ]);

            if ($delete_account) {
                 $user->delete();
                 Auth::logout();
                return redirect()->to('/')->with('success','Account Deleted!');
                
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    
            }
        } elseif ($request->mainOptions == 'option3') {

            $delete_account = DeleteAccounts::create([
                'user_id'=> $user->id,
                'user_email'=> $user->email,
                'reason'=> "I am struggling to find jobs",
            ]);

            if ($delete_account) {
                 $user->delete();
                 Auth::logout();
                return redirect()->to('/')->with('success','Account Deleted!');
                
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    
            }
        } else {

            $delete_account = DeleteAccounts::create([
                'user_id'=> $user->id,
                'user_email'=> $user->email,
                'reason'=> "Other reasons",
                'additional_reason'=> $request->additionalOption4,
            ]);

            if ($delete_account) {
                 $user->delete();
                 Auth::logout();
                return redirect()->to('/')->with('success','Account Deleted!');
                
            } else {
                return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    
            }
        }
    


    }


    // Contact Us Functions Start================
    public function UserContactUs()   {
        
                 
        if (!Auth::user()) {
            return redirect('/');
        }

        if (Auth::user()->role == 2) {
            return redirect('/admin-dashboard');
        }

        return view("User-Dashboard.contact");

    }

    public function ContactMail(Request $request)  {
       
        
        if ($request->msg == null) {
            return redirect()->back()->with('error','Please Write a Text Message!');
        }

        $mailData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
             'email' => $request->email,
            'subject' => $request->subject,
            'msg' => $request->msg,
        ];
        $name = $request->first_name.' '.$request->last_name;
        $subject = $request->subject;
        $mail = $request->email;
       $mail_send =  Mail::to('ma2550645@gmail.com')->send(new ContactMail($mailData, $subject,$name, $mail));
    //    $mail_send =  Mail::to('dreamcrowd@bravemindstudio.com')->send(new ContactMail($mailData, $subject,$name, $mail));

       if ($mail_send) {
        return redirect()->back()->with('success','Hi there, We will back to you soon!');
    } else {
           return redirect()->back()->with('error','Something Went Rong, Tryagain Later!');
       }
        
    }
    // Contact Us Functions End================


    // Wish List Functions Start================
       
    public function WishList()  {
                
        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;  
        }

        $list = WishList::where(['user_id'=>Auth::user()->id])->get();
        
        return view("User-Dashboard.wishlist", compact('list'));
    }

       
    public function RemoveWishList($id)  {
                
        if ($redirect = $this->UsercheckAuth()) {
            return $redirect;  
        }

        $list = WishList::where(['id'=>$id])->first();

        $list->delete();
        if ( $list) {
             
       
        return redirect()->back()->with('info','Service Removed From List!');
    } else {
        return redirect()->back()->with('error','Something Went Rong,Tryagain Later!');
    }
    }


    // Wish List Functions END================ 


}
        