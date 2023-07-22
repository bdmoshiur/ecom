<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Coupon;
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
            $coupondata = array();
            $message = "Coupon Added Successfully";
        } else {
            //Edit Coupon Functionality
            $title = "Edit Coupon";
            $coupon = Coupon::find($id);
            $coupondata = Coupon::find($id)->toArray();
            $message = "Coupon Updated Successfully";
        }

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        // if($request->isMethod('post')){
        //     $data = $request->all();

        //     $coupon->coupon_option = $data['coupon_option'];
        //     $coupon->coupon_code = $data['coupon_code'];
        //     $coupon->coupon_type = $data['coupon_type'];

        //     $banncouponer->save();

        //     Session::flash('success_message', $message);
        //     return redirect()->route('admin.coupons');

        // }

        return view('admin.coupons.add_edit_coupon',[
            'title' => $title,
            'coupon' => $coupon,
            'categories' => $categories,
            'coupondata' => $coupondata,
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
}
