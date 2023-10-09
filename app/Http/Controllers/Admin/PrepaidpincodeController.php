<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PrepaidPincode;
use Illuminate\Support\Facades\Session;

class PrepaidpincodeController extends Controller
{
    public function prepaidpincode()
    {
        Session::put('page', "prepaidpincode");
        $prepaidpincodes = PrepaidPincode::get();
        return view('admin.prepaidpincodes.prepaidpincodes',[
            'prepaidpincodes' => $prepaidpincodes,
            ]);
    }

    public function updatePrepaidpincodeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            PrepaidPincode::where('id', $data['prepaidpincode_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'prepaidpincode_id' => $data['prepaidpincode_id']]);
        }
    }

    public function addEditprepaidpincode( Request $request, $id = null)
    {
        Session::put('page', "prepaidpincodes");

        if ($id == "") {
            //Add Prepaidpincode Functionality
            $title = "Add Prepaidpincode";
            $prepaidpincode = new PrepaidPincode();
            $prepaidpincodedata = array();
            $message = "Prepaidpincode Added Successfully";
        } else {
            //Edit prepaidpincode Functionality
            $title = "Edit Prepaidpincode";
            $prepaidpincode = PrepaidPincode::find($id);
            $message = "Prepaidpincode Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'pincode' => 'required',
            ];
            $customMessage = [
                'pincode.required' => 'Prepaidpincode Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $prepaidpincode->pincode = $data['pincode'];
            $prepaidpincode->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.prepaidpincode');

        }

        return view('admin.prepaidpincodes.add_edit_prepaidpincode',[
            'title' => $title,
            'prepaidpincode' => $prepaidpincode,
        ]);
    }

    public function deletePrepaidpincode($id)
    {
        $deleteprepaidpincodes = PrepaidPincode::find($id)->delete();
        Session::flash('success_message', 'Prepaidpincode Deleted Successfully');

        return redirect()->back();
    }
}
