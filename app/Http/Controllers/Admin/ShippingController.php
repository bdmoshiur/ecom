<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingCharge;
use Illuminate\Support\Facades\Session;

class ShippingController extends Controller
{
    public function viewShippingCharges() {
        Session::put('page', "shipping-charges");
        $shipping_charges = ShippingCharge::get()->toArray();

        return view('admin.shipping.view_shipping_charges',[
            'shipping_charges' => $shipping_charges,
        ]);
    }

    public function updateShippingCharges(Request $request, $id) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $updateData = [
                'shipping_charges' => $data['shipping_charges']
            ];

            $shipping_details = ShippingCharge::where('id', $id)->update($updateData);
            $message = "Shipping Charges Updated successfully";
            Session::put('success_message',$message);

            return redirect()->back();
        }

        $shipping_details = ShippingCharge::where('id',$id)->first();

        return view('admin.shipping.edit_shipping_charges',[
            'shipping_details' => $shipping_details,
        ]);
    }


    public function updateShippingStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ShippingCharge::where('id', $data['shipping_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'shipping_id' => $data['shipping_id']]);
        }
    }
}
