<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CodPincode;
use Illuminate\Support\Facades\Session;

class CodpincodeController extends Controller
{
    public function codpincode()
    {
        Session::put('page', "codpincode");
        $codpincodes = CodPincode::get();

        return view('admin.codpincodes.codpincodes',[
            'codpincodes' => $codpincodes,
            ]);
    }

    public function updateCodpincodeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            CodPincode::where('id', $data['codpincode_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'codpincode_id' => $data['codpincode_id']]);
        }
    }

    public function addEditCodpincode( Request $request, $id = null)
    {
        Session::put('page', "codpincodes");
        if ($id == "") {
            //Add Codpincode Functionality
            $title = "Add Codpincode";
            $codpincode = new CodPincode();
            $codpincodedata = array();
            $message = "Codpincode Added Successfully";
        } else {
            //Edit Codpincode Functionality
            $title = "Edit Codpincode";
            $codpincode = CodPincode::find($id);
            $message = "Codpincode Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'pincode' => 'required',
            ];
            $customMessage = [
                'pincode.required' => 'Codpincode Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $codpincode->pincode = $data['pincode'];
            $codpincode->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.codpincode');
        }

        return view('admin.codpincodes.add_edit_codpincode',[
            'title' => $title,
            'codpincode' => $codpincode,
        ]);
    }

    public function deleteCodpincode($id)
    {
        $deletecodpincodes = CodPincode::find($id)->delete();
        Session::flash('success_message', 'Codpincode Deleted Successfully');

        return redirect()->back();
    }
}
