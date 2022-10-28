<?php

namespace App\Http\Controllers\Front;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function registerUser( Request $request)
    {
        if($request->isMethod('post')){
        $data = $request->all();
        $userCount = User::where('email', $data['email'])->count();
            if($userCount > 0){
                Session::flash('error_message', 'Email already exists');
                return redirect()->back();
            }else{
                $user = new User();
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();

                if( Auth::attempt( ['email'=> $data['email'], 'password' => $data['password'] ]) ){
                    return redirect('casul-t-shirts');
                }
            }
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }
}
