<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;

class CouponController extends Controller
{

    function coupons() {

        $coupons = Coupon::get();
        return view('admin.coupons.coupons',[
            'coupons' => $coupons,
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
