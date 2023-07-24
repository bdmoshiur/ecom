<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Coupon;
use App\User;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{

    function coupons() {

        $coupons = Coupon::get();
        Session::put('page', "coupons");
        return view('admin.coupons.coupons',[
            'coupons' => $coupons,
        ]);
    }

    public function addEditCoupon( Request $request, $id = null)
    {
        Session::put('page', "coupons");
        if ($id == "") {
            //Add Coupon Functionality
            $title = "Add Coupon";
            $coupon = new Coupon();
            $selCats = array();
            $selUsers = array();
            $message = "Coupon Added Successfully";
        } else {
            //Edit Coupon Functionality
            $title = "Edit Coupon";
            $coupon = Coupon::find($id);

            $selCats = explode(',', $coupon['categories']);
            $selUsers =  explode(',', $coupon['users']);
            $message = "Coupon Updated Successfully";
        }

          if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'expiry_date' => 'required',
            ];
            $customMessage = [
                'categories.required' => 'Select Categories',
                'coupon_option.required' => 'Select Coupon Option',
                'coupon_type.required' => 'Select Coupon Type',
                'amount_type.required' => 'Select Amount Type',
                'amount.required' => 'Enter Amount',
                'amount.numeric' => 'Enter Valid Amount',
                'expiry_date.required' => 'Enter Expiry Date'
            ];

            $this->validate($request, $rules, $customMessage);

            if (isset($data['users'])) {
                $users = implode(',', $data['users']);
            }else{
                $users = "";
            }

            if (isset($data['categories'])) {
                $categories = implode(',', $data['categories']);
            }

            if($data['coupon_option'] == 'Automatic'){
                $coupon_code = str_random(8);
            } else {
                $coupon_code = $data['coupon_code'];
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.coupons');

        }

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        $users = User::select('email')->where('status',1)->get()->toArray();



        return view('admin.coupons.add_edit_coupon',[
            'title' => $title,
            'coupon' => $coupon,
            'categories' => $categories,
            'users' => $users,
            'selCats' => $selCats,
            'selUsers' => $selUsers
        ]);
    }

    public function updateCouponStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Coupon::where('id', $data['coupon_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'coupon_id' => $data['coupon_id']]);
        }
    }



    public function deleteCoupon($id)
    {
        $deleteBrands = Coupon::find($id)->delete();
        Session::flash('success_message', 'Coupon Deleted Successfully');
        return redirect()->back();
    }
}
