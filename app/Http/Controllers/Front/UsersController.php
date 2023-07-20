<?php

namespace App\Http\Controllers\Front;


use App\User;
use App\Cart;
use App\Sms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;


class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::forget('success_message');
            Session::forget('error_message');
            $data = $request->all();
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                Session::flash('error_message', 'Email already exists');
                return redirect()->back();
            } else {
                $user = new User();
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();


                $email = $data['email'];
                $messageData = ['name' => $data['name'], 'email' => $data['email'], 'code' => base64_encode($data['email'])];
                Mail::send('emails.confirmation', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Confirm your E-commerce Account');
                });

                $message =  "Please confirm your email to activate your account";
                Session::put('success_message', $message);

                return redirect()->back();

                // Update user cart with user_id

                // if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                //     if(!empty(Session::get('session_id'))){
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('session_id');
                //         Cart::where('session_id', $session_id)->update(['user_id'=> $user_id]);
                //     }

                //     Send Register SMS
                //     $message = 'Dear Custommer, You havbeen successfully registered with e-com website. login to your account to access orders and available offers.';
                //     $mobile = $data['mobile'];
                //     Sms::sendSms($message,$mobile);


                //     $email = $data['email'];
                //     $messageData = ['name' => $data['name'], 'mobile' => $data['mobile'], 'email' => $data['email']];
                //     Mail::send('emails.register', $messageData, function ($message) use ($email) {
                //         $message->to($email)->subject('Subject');
                //     });


                //     return redirect('casul-t-shirts');
                // }


            }
        }
    }
    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::forget('success_message');
            Session::forget('error_message');
            $data = $request->all();
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

                $userStatus = User::where('email',$data['email'])->first();
                if($userStatus->status == 0){
                    Auth::logout();
                    $message = "Your account is not activated yet! please confirm your email to activation";
                    Session::put('error_message', $message);
                    return redirect()->back();
                }

                if(!empty(Session::get('session_id'))){
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=> $user_id]);
                }
                return redirect('/cart');
            } else{
                Session::flash('error_message', 'Invalid email or password');
                return redirect()->back();
            }
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $countEmail = User::where('email', $data['email'])->count();
        if ($countEmail > 0) {
            return "false";
        } else {
            return "true";
        }
    }

    function confirmAccount($email) {
        Session::forget('success_message');
        Session::forget('error_message');
        $email = base64_decode($email);
        $userCount = User::where('email', $email)->count();
        if($userCount > 0){
            $userDetails = User::where('email', $email)->first();

            if($userDetails->status == 1){
                $message = "Your email account is already activated. please login.";
                Session::put('error_message', $message);
                return redirect('login-register');
            } else {
                $user = User::where('email', $email)->update(['status'=> 1]);

                    // $message = 'Dear Custommer, You havbeen successfully registered with e-com website. login to your account to access orders and available offers.';
                    // $mobile = $userDetails['mobile'];
                    // Sms::sendSms($message,$mobile);



                    $messageData = ['name' => $userDetails['name'], 'mobile' => $userDetails['mobile'], 'email' => $email ];
                    Mail::send('emails.register', $messageData, function ($message) use ($email) {
                        $message->to($email)->subject('Subject');
                    });

                    $message = "Your email account is activated. you can login now.";
                    Session::put('success_message',$message );
                return redirect('login-register');

            }
        } else {
            abort(404);
        }


    }

    function forgotPassword( Request $request) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            $emailCount = User::where('email', $data['email'])->count();

            if($emailCount == 0){

                $message = "Emai dose not exists";
                Session::put('error_message',$message);
                Session::forget('success_message');

                return redirect()->back();
            }

            $random_password = str_random(8);

            $new_password = bcrypt($random_password);

            User::where('email', $data['email'])->update(['password' => $new_password]);
            $userName =  User::select('name')->where('email', $data['email'])->first();

            $email = $data['email'];
            $name = $userName->name;
            $messageData =  [
                'name' => $name,
                'email' => $email,
                'password' => $random_password,
            ];
            Mail::send('emails.forgot_password', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('New Password E-commerce Website');
            });

            $message = "Please check your email for new password";
            Session::put('success_message', $message);
            Session::forget('error_message');
        return redirect('login-register');


        }
        return view('front.users.forgot_password');
    }

    function account(Request $request) {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();

            $user = User::find($user_id);

            $user->name =  $data['name'];
            $user->address =  $data['address'];
            $user->country =  $data['country'];
            $user->city =  $data['city'];
            $user->state =  $data['state'];
            $user->pincode =  $data['pincode'];
            $user->mobile =  $data['mobile'];
            $user->save();

            $message = "Your account details has been updated successfully";
            Session::put('success_message',$message);
            Session::forget('error_message');

            return redirect()->back();

        }

        return view('front.users.account',['userDetails' => $userDetails]);
    }

    function updatePassword() {

    }


}
