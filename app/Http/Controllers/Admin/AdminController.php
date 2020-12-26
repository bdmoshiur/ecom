<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            //  echo '<pre>';
            //  print_r($data);
            //  die;
            if(Auth::guard('admin')->attempt(['email' =>$data['email'],'password'=> $data['password']])){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout(Request $request)
    {
        echo 'ok';
    }

}
