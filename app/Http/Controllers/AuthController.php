<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $IP;

    public function __construct()
    {
        $this->IP = $_SERVER['REMOTE_ADDR'];
        // public $IP =  '162.159.24.227';
    }

    public function CreateAccount(Request $request)
    {

        $password = $request->input('password');


        if (strlen($password) < 8) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must be at least 8 characters long.';
            return response()->json($response);
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must contain at least one uppercase letter.';
            return response()->json($response);
        }
        if (!preg_match('/[0-9]/', $password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must contain at least one number.';
            return response()->json($response);
        }

        if (!preg_match('/[\W_]/', $password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must contain at least one special character.';
            return response()->json($response);
        }


        if ($request->email == null || $request->password == null || $request->c_password == null || $request->first_name == null || $request->last_name == null) {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'All Fields Are Required!';
            return response()->json($response);
            // return redirect()->back()->with('error','All Fields Are Required!');
        }

        if ($request->password != $request->c_password) {
            $response['error'] = true;
            $response['geterror'] = 'c_password';
            $response['message'] = 'Password did not Matched';
            return response()->json($response);
            // return redirect()->back()->with('error','Password did not Matched');
        }

        $user = User::where(['email' => $request->email])->first();

        if (!empty($user)) {
            $response['error'] = true;
            $response['geterror'] = 'email';
            $response['message'] = 'This Email is Already Registered';
            return response()->json($response);
            // return redirect()->back()->with('error','This Email is Already Registered!');

        }


        //  $userIp = $_SERVER['REMOTE_ADDR']; /* Live IP address */
        // $userIp = $request->ip(); /* Live IP address */
        $userIp = $this->IP; /* Static IP address */
        $location = Location::get($userIp);
        //  echo $location->countryName."<br>";
        // echo $location->countryCode."<br>" ;
        // echo $location->cityName."<br>" ;

        $random_hash = bin2hex(openssl_random_pseudo_bytes(60));


        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'email_verify' => $random_hash,
            'password' => Hash::make($request->password),
            'ip' => $userIp,
            'city' => @$location->cityName,
            'country' => @$location->countryName,
            'country_code' => @$location->countryCode,
        ]);

        if ($user) {
            $mailData = [
                'title' => 'Email Verify',
                'token' => $random_hash,
            ];

            $email_send = Mail::to($request->email)->send(new VerifyMail($mailData));


            // Auth::login($user);
            $response['success'] = true;
            $response['geterror'] = 'email';
            $response['message'] = 'Please Verify Your Email, Check Your Email Box!';
            return response()->json($response);
            // return redirect('/')->with('success','Please Verify Your Email, Check Your Email Box!');

        } else {
            $response['error'] = true;
            $response['geterror'] = 'email';
            $response['message'] = 'Something Error Please Try again Later!';
            return response()->json($response);
            // return redirect()->back()->with('error','Something Error Please Try again Later!');

        }

    }


    // Login & SignUp With Google Start ==========================

    public function redirectToGoogle(Request $request)
    {

        switch ($request->input('google_action')) {
            case 'signup':
                // Save model
                session()->put('action', 'signup');
                break;

            case 'login':
                // Preview model
                session()->put('action', 'login');
                break;
        }


        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $action = session()->get('action');


        $googleUser = Socialite::driver('google')->user();

        if ($action == 'signup') {
            $user = User::where('email', $googleUser->email)->first();

            // $userIp = $_SERVER['REMOTE_ADDR']; /* Live IP address */
            // $userIp = $request->ip(); /* Live IP address */
            $userIp = $this->IP; /* Static IP address */
            $location = Location::get($userIp);
            //  echo $location->countryName;
            // echo $location->countryCode ;
            // echo $location->cityName ;


            if (!$user) {
                $name = explode(' ', $googleUser->name);
                $user = User::create([
                    'first_name' => $name[0],
                    'last_name' => $name[1],
                    'email' => $googleUser->email,
                    'email_verify' => 'verified',
                    'ip' => $userIp,
                    'city' => $location->cityName,
                    'country' => $location->countryName,
                    'country_code' => $location->countryCode,
                    'google_id' => $googleUser->id,
                    'status' => 1,
                    'password' => Hash::make(rand(100000, 999999))]);
            } else {
                if ($user->status == 2) {
                    return redirect()->back()->with('error', 'Your Account is Blocked!');
                }
                if ($user->google_id == null) {
                    $user->google_id = $googleUser->id;
                    $user->email_verify = 'verified';
                    $user->update();
                }

            }

            Auth::login($user);

            return redirect('/');

        } else {

            $user = User::where('email', $googleUser->email)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'Create Account First on this Email Address!');

            } else {
                if ($user->status == 2) {
                    return redirect()->back()->with('error', 'Your Account is Blocked!');
                }
                if ($user->google_id == null) {
                    $user->google_id = $googleUser->id;
                    $user->email_verify = 'verified';
                    $user->update();
                }
            }
            Auth::login($user);

            return redirect('/');
        }


    }

// Login & SignUp With Google End ==========================


// Login & SignUp With Facebook Start ==========================


    public function facebookRedirect(Request $request)
    {

        switch ($request->input('facebook_action')) {
            case 'signup':
                // Save model
                session()->put('action', 'signup');
                break;

            case 'login':
                // Preview model
                session()->put('action', 'login');
                break;
        }


        return Socialite::driver('facebook')->redirect();
    }


    public function facebookCallback()
    {
        $action = session()->get('action');


        $facebookUser = Socialite::driver('facebook')->user();

        if ($action == 'signup') {
            $user = User::where('email', $facebookUser->email)->first();

            // $userIp = $_SERVER['REMOTE_ADDR']; /* Live IP address */
            // $userIp = $request->ip(); /* Live IP address */
            $userIp = $this->IP; /* Static IP address */
            $location = Location::get($userIp);
            //  echo $location->countryName;
            // echo $location->countryCode ;
            // echo $location->cityName ;


            if (!$user) {
                $name = explode(' ', $facebookUser->name);
                $user = User::create([
                    'first_name' => $name[0],
                    'last_name' => $name[1],
                    'email' => $facebookUser->email,
                    'email_verify' => 'verified',
                    'ip' => $userIp,
                    'city' => $location->cityName,
                    'country' => $location->countryName,
                    'country_code' => $location->countryCode,
                    'facebook_id' => $facebookUser->id,
                    'status' => 1,
                    'password' => Hash::make(rand(100000, 999999))]);
            } else {
                if ($user->status == 2) {
                    return redirect()->back()->with('error', 'Your Account is Blocked!');
                }
                if ($user->facebook_id == null) {
                    $user->facebook_id = $facebookUser->id;
                    $user->email_verify = 'verified';
                    $user->update();
                }

            }

            Auth::login($user);

            return redirect('/');

        } else {

            $user = User::where('email', $facebookUser->email)->first();
            if (!$user) {
                return redirect()->back()->with('error', 'Create Account First on this Email Address!');

            } else {
                if ($user->status == 2) {
                    return redirect()->back()->with('error', 'Your Account is Blocked!');
                }
                if ($user->facebook_id == null) {
                    $user->facebook_id = $facebookUser->id;
                    $user->email_verify = 'verified';
                    $user->update();
                }
            }
            Auth::login($user);

            return redirect('/');
        }


    }


// Login & SignUp With Facebook End ==========================


    public function Login(Request $request)
    {


        $user = User::where(['email' => $request->email])->first();

        if (empty($user)) {
            $response['error'] = true;
            $response['geterror'] = 'email';
            $response['message'] = 'This Email is not Registered Please Create an Account!';
            return response()->json($response);
            // return redirect()->back()->with('error','This Email is not Registered Please Create an Account!');

        }
        if ($user->status == 2) {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Your Account is Blocked!';
            return response()->json($response);
            // return redirect()->back()->with('error','This Email is not Registered Please Create an Account!');

        }

        if (!Hash::check($request->password, $user->password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'You Entered Incorrect Password!';
            return response()->json($response);
            // return redirect()->back()->with('error','You Entered Incorrect Password!');

        }

        if ($user->email_verify != 'verified') {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Please Verify Your Mail First, Check Your Mail Box!';
            return response()->json($response);
            // return redirect()->back()->with('error','Please Verify Your Mail First, Check Your Mail Box!');
        }

        Auth::login($user);

        if (isset($request->remember) && !empty($request->remember)) {
            setcookie("email", $request->email, time() + 86400);
            setcookie("password", $request->password, time() + 86400);
        } else {
            setcookie("email", "");
            setcookie("password", "");
        }


        return response()->json(['success' => true]);
        // return redirect('/');


    }


    public function LogOut()
    {

        // Session::Flush();
        Auth::logout();
        return redirect()->to('/');
    }


    // Switch Account to Buyer or Saller Function Start========
    public function SwitchAccount()
    {
        if (!Auth::user()) {
            return redirect('/');

        }
        $user = User::find(Auth::user()->id);
        if ($user->role == 0) {
            $user->role = 1;
            $user->update();
            return redirect('/')->with('success', 'Account Switched to Seller');
        } elseif ($user->role == 1) {
            $user->role = 0;
            $user->update();
            return redirect('/')->with('success', 'Account Switched to Buyer');
        }

        return redirect('/');

    }
    // Switch Account to Buyer or Saller Function END========


    // Email Verifiy Customly Account Create Function Start========
    public function VerifyEmail($token)
    {
        $user = User::where(['email_verify' => $token])->first();
        if ($user) {
            $user->email_verify = 'verified';
            $user->status = 1;
            $user->update();
            Auth::login($user);

            return redirect('/')->with('success', 'Your Email is Verified Successfuly!');
        } else {
            return redirect('/')->with('error', 'This Verification Link is Expiered!');

        }
    }
    // Email Verifiy Customly Account Create Function END========

    // Forgot Password Function Start========
    public function ForgotPassword(Request $request)
    {


        $user = User::where(['email' => $request->email])->first();

        if (empty($user)) {
            $response['error'] = true;
            $response['geterror'] = 'email';
            $response['message'] = 'This Email is not Registered!';
            return response()->json($response);
            // return redirect()->back()->with('error','This Email is not Registered!');

        }

        if ($user->status == 2) {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Your Account is Blocked!';
            return response()->json($response);
            // return redirect()->back()->with('error','This Email is not Registered Please Create an Account!');

        }

        if ($user->email_verify != 'verified') {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Please Verify Your Mail First, Check Your Mail Box!';
            return response()->json($response);
            // return redirect()->back()->with('error','Please Verify Your Mail First, Check Your Mail Box!');
        }

        $random_hash = bin2hex(openssl_random_pseudo_bytes(60));

        $user->remember_token = $random_hash;
        $user->update();

        $mailData = [
            'title' => 'Email Verify',
            'token' => $random_hash,
        ];

        $email_send = Mail::to($request->email)->send(new ForgotPassword($mailData));

        if ($user) {
            $response['success'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Check Your Mail Box for Change Password!';
            return response()->json($response);
            // return redirect('/')->with('success','Check Your Mail Box for Change Password!');
        } else {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Something Error Please Try again Later!';
            return response()->json($response);
            // return redirect('/')->with('error','Something Error Please Try again Later!');

        }

    }


    public function ForgotPasswordVerify($token)
    {
        $user = User::where(['remember_token' => $token])->first();
        if ($user) {

            return redirect('/')->with('newPass', $user->id);
        } else {
            return redirect('/')->with('error', 'This Forgot Password Link is Expiered!');

        }
    }


    public function NewForgotPassword(Request $request)
    {


        $password = $request->input('password');


        if (strlen($password) < 8) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must be at least 8 characters long.';
            return response()->json($response);
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must contain at least one uppercase letter.';
            return response()->json($response);
        }
        if (!preg_match('/[0-9]/', $password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must contain at least one number.';
            return response()->json($response);
        }

        if (!preg_match('/[\W_]/', $password)) {
            $response['error'] = true;
            $response['geterror'] = 'password';
            $response['message'] = 'The password must contain at least one special character.';
            return response()->json($response);
        }


        if ($request->password != $request->c_password) {
            $response['error'] = true;
            $response['geterror'] = 'c_password';
            $response['message'] = 'Password did not Matched!';
            return response()->json($response);
            // return redirect()->back()->with('error','Password did not Matched!');
        }

        $user = User::find($request->id);

        $user->password = Hash::make($request->password);
        $user->remember_token = null;
        $user->update();

        if ($user) {
            // Auth::login($user);
            return response()->json(['success' => true,
                'message' => 'Password Changed Successfuly!']);
            // return redirect('/')->with('success','Password Changed Successfuly');
        } else {
            $response['error'] = true;
            $response['geterror'] = '';
            $response['message'] = 'Something Error Please Try again Later!';
            return response()->json($response);
            // return redirect('/')->with('error','Something Error Please Try again Later!');

        }

    }
    // Forgot Password Function END========


    // Fet Current Location Function start========
    public function GetCurrentLocation()
    {

        //  $userIp = $_SERVER['REMOTE_ADDR']; /* Live IP address */
        // $userIp = $request->ip(); /* Live IP address */
        $userIp = $this->IP; /* Static IP address */
        $location = Location::get($userIp);
        //  echo $location->countryName."<br>";
        // echo $location->countryCode."<br>" ;
        // echo $location->cityName."<br>" ;

        $response['country_code'] = $location->countryCode;
        $response['country_name'] = $location->countryName;
        $response['country_ip'] = $userIp;
        return response()->json($response);
    }
    // Fet Current Location Function END========


}





