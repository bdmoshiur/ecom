<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sleeve;
use Illuminate\Support\Facades\Session;

class SleeveController extends Controller
{
    public function sleeve()
    {
        Session::put('page', "sleeve");
        $sleeves = Sleeve::get();
        return view('admin.sleeves.sleeves',[
            'sleeves' => $sleeves,
            ]);
    }

    public function updateSleeveStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Sleeve::where('id', $data['sleeve_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'sleeve_id' => $data['sleeve_id']]);
        }
    }

    public function addEditSleeve( Request $request, $id = null)
    {
        Session::put('page', "sleeve");
        if ($id == "") {
            //Add sleeve Functionality
            $title = "Add Sleeve";
            $sleeve = new Sleeve();
            $sleevedata = array();
            $message = "Sleeve Added Successfully";
        } else {
            //Edit sleeve Functionality
            $title = "Edit Sleeve";
            $sleeve = Sleeve::find($id);
            $message = "Sleeve Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'sleeve_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'sleeve_name.required' => 'Sleeve Name is Required',
                'sleeve_name.regex' => 'Valid Sleeve Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $sleeve->name = $data['sleeve_name'];
            $sleeve->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.sleeve');

        }

        return view('admin.sleeves.add_edit_sleeve',[
            'title' => $title,
            'sleeve' => $sleeve,
        ]);
    }

    public function deleteSleeve($id)
    {
        $deletesleeves = Sleeve::find($id)->delete();
        Session::flash('success_message', 'Sleeve Deleted Successfully');
        return redirect()->back();
    }
}
