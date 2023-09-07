<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\AdminRole;
use App\OtherSetting;
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
        Session::put('page', "dashboard");
        return view('admin.admin_dashboard');
    }

    public function settings()
    {
        Session::put('page', "settings");
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings', compact('adminDetails'));
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo '<pre>';
            //  print_r($data);
            //  die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessage = [
                'email.required' => 'Email Address is required',
                'email.email' => 'Valid Email Address is required',
                'password.required' => 'Password is required',
            ];
            $this->validate($request, $rules, $customMessage);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
                return redirect()->route('admin.dashboard');
            } else {
                Session::flash('error_message', 'Email or Password Invalid !');
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
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    Session::flash('success_message', 'Password Has been Updated Successfully');
                } else {
                    Session::flash('error_message', 'New Password and Confirm Password not Match!');
                }
            } else {
                Session::flash('error_message', 'Your Current Password is Incorrect!');
                return redirect()->back();
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request)
    {
        Session::put('page', "update-admin-details");
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'     => 'required|numeric',
                'admin_image'     => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Admin Name is Required',
                'admin_name.regex' => 'Valid Name is Required',
                'admin_mobile.required' => 'Mobile is Required',
                'admin_mobile.numeric' => 'Valid Mobile is Required',
                'admin_image.image' => 'Valid Image is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Admin Iamge
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    $extention = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extention;
                    $imagePath = 'images/admin_images/admin_photos/' . $imageName;
                    Image::make($image_tmp)->resize(300, 400)->save($imagePath);
                } else if (!empty($data['current_admin_image'])) {
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }
            }

            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            Session::flash('success_message', "Admin Details Updated SuccessFully");
            return redirect()->back();
        }
        return view('admin.admin_update_details');
    }

    public function adminsSubadmins() {

        if (Auth::guard('admin')->user()->type == 'subadmin' ){
            Session::flash('error_message', 'This feature is restricted!');
            return redirect()->route('admin.dashboard');
        }

        Session::put('page', "admins_subadmins");
        $admins = Admin::get();
        return view('admin.admins_subadmins.admins_subadmins',[
            'admins' => $admins,
        ]);
    }

    public function updatAdminsStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'admin_id' => $data['admin_id']]);
        }
    }

    public function deleteAdmin($id)
    {
        Admin::find($id)->delete();
        Session::flash('success_message', 'Admin / Subadmin Deleted Successfully');
        return redirect()->back();
    }

    public function addEditAdminSubadmin(Request $request, $id = null) {
        Session::put('page', "admins_subadmins");
        if ($id == "") {
            //Add Admin/Sub-Admin Functionality
            $title = "Add Admin/Sub-Admin";
            $admindata = new Admin();
            $message = "Admin/Sub-Admin added successfully";
        } else {
            //Edit Admin/Sub-Admin Functionality
            $title = "Edit Admin/Sub-Admin";
            $admindata = Admin::find($id);
            $message = "Admin/Sub-Admin Updated successfully";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data);
            if($id == ''){
                $adminCount =  Admin::where('email',$data['admin_email'])->count();

                if($adminCount > 0 ){
                    Session::flash('error_message', "Admin/Subadmin Allready Exits");
                    return redirect()->route('admin.admins.subadmins');
                }
            }
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile'     => 'required|numeric',
                'admin_image'     => 'image',
            ];
            $customMessage = [
                'admin_name.required' => 'Admin Name is Required',
                'admin_name.regex' => 'Valid Name is Required',
                'admin_mobile.required' => 'Mobile is Required',
                'admin_mobile.numeric' => 'Valid Mobile is Required',
                'admin_image.image' => 'Valid Image is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            //Upload Admin Iamge
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    $extention = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extention;
                    $imagePath = 'images/admin_images/admin_photos/' . $imageName;
                    Image::make($image_tmp)->resize(300, 400)->save($imagePath);
                }

            }else if (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            } else {
                $imageName = "";
            }

            $admindata->image = $imageName;
            $admindata->name = $data['admin_name'];
            $admindata->mobile = $data['admin_mobile'];
            if($id == ''){
                $admindata->email = $data['admin_email'];
                $admindata->type = $data['admin_type'];
            }

            if($data['admin_password'] != ""){
                $admindata->password = bcrypt($data['admin_password']);
            }
            $admindata->save();
            Session::flash('success_message', $message);
            return redirect()->route('admin.admins.subadmins');
        }

        return view('admin.admins_subadmins.add_edit_admins_subadmins',[
            'title' => $title,
            'admindata' => $admindata,
        ]);
    }

    public function updateRole(Request $request, $id ) {

        Session::put('page', "admins_subadmins");
        if ($request->isMethod('post')) {
            $data = $request->all();
            unset($data['_token']);
            AdminRole::where('admin_id', $id)->delete();

            foreach ($data as $key => $value) {
                if (isset($value['view'])) {
                    $view =  $value['view'];
                } else {
                    $view = 0;
                }

                if (isset($value['edit'])) {
                    $edit =  $value['edit'];
                } else {
                    $edit = 0;
                }

                if (isset($value['full'])) {
                    $full =  $value['full'];
                } else {
                    $full = 0;
                }

                AdminRole::where('admin_id', $id)->insert([
                    'admin_id' => $id ,
                    'module' => $key ,
                    'view_access' => $view ,
                    'edit_access' => $edit,
                    'full_access' => $full,
                ]);
            }

            $message = "Roles Update Successfully";
            Session::flash('success_message', $message);
            return redirect()->back();
        }

        $adminDetails = Admin::where('id', $id)->first()->toArray();
        $adminRoles = AdminRole::where('admin_id', $id)->get()->toArray();

        $title = "Update " . $adminDetails['name'] . "(" . $adminDetails['type'] . " ) roles/permissions";
        return view('admin.admins_subadmins.update_role',[
            'title' => $title,
            'adminDetails' => $adminDetails,
            'adminRoles' => $adminRoles,
        ]);
    }

    public function updateOtherSetting(Request $request) {

        Session::put('page', "update_other_setting");
        $title = "Others Setting";
        $otherSetting = otherSetting::where('id', 1)->first()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();
            otherSetting::where('id', 1)->update(['min_cart_value' => $data['min_cart_value'], 'max_cart_value' => $data['max_cart_value'] ]);

            $message = "Min / Max cart value updated successfully";
            Session::flash('success_message', $message);
            return redirect()->back();
        }

        return view('admin.other_setting',[
            'title' => $title,
            'otherSetting' => $otherSetting,
        ]);

    }


}
