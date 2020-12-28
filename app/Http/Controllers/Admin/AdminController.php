<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function dashboard()
    {
        Session::put('page',"dashboard");
        return view('admin.admin_dashboard');
    }

    public function settings()
    {
        Session::put('page',"settings");
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings',compact('adminDetails'));
    }

    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            //  echo '<pre>';
            //  print_r($data);
            //  die;
            $rules =[
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessage = [
                'email.required' => 'Email Address is required',
                'email.email' => 'Valid Email Address is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessage);

            if(Auth::guard('admin')->attempt(['email' =>$data['email'],'password'=> $data['password']])){
                return redirect()->route('admin.dashboard');
            }else{
                Session::flash('error_message','Email or Password Invalid !');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.admin');
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if(Hash::check($data['current_password'],Auth::guard('admin')->user()->password)){
                if($data['new_password'] == $data['confirm_password']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    Session::flash('success_message','Password Has been Updated Successfully');
                }else{
                    Session::flash('error_message','New Password and Confirm Password not Match!');
                }
            }else{
                Session::flash('error_message','Your Current Password is Incorrect!');
                return redirect()->back();
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page',"update-admin-details");
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'     => 'required|numeric',
                'admin_image'     => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Admin Name is Required',
                'admin_name.alpha' => 'Valid Name is Required',
                'admin_mobile.required' => 'Mobile is Required',
                'admin_mobile.numeric' => 'Valid Mobile is Required',
                'admin_image.image' => 'Valid Image is Required',
            ];
            $this->validate($request,$rules,$customMessage);


            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){
                    $extention = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111,99999).'.'.$extention;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    Image::make($image_tmp)->resize(300,400)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{
                    $imageName = "";
                }
            }

            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile' =>$data['admin_mobile'],'image' =>$imageName]);
            Session::flash('success_message',"Admin Details Updated SuccessFully");
            return redirect()->back();

        }
        return view('admin.admin_update_details');
    }



}
