<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Occasion;
use Illuminate\Support\Facades\Session;

class OccasionController extends Controller
{
    public function occasion()
    {
        Session::put('page', "occasion");
        $occasions = Occasion::get();
        return view('admin.occasions.occasions',[
            'occasions' => $occasions,
            ]);
    }

    public function updateOccasionStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Occasion::where('id', $data['occasion_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'occasion_id' => $data['occasion_id']]);
        }
    }

    public function addEditOccasion( Request $request, $id = null)
    {
        Session::put('page', "occasion");
        if ($id == "") {
            //Add Occasion Functionality
            $title = "Add Occasion";
            $occasion = new Occasion();
            $occasiondata = array();
            $message = "Occasion Added Successfully";
        } else {
            //Edit occasion Functionality
            $title = "Edit Occasion";
            $occasion = Occasion::find($id);
            $message = "Occasion Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'occasion_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'occasion_name.required' => 'Occasion Name is Required',
                'occasion_name.regex' => 'Valid Occasion Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $occasion->name = $data['occasion_name'];
            $occasion->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.occasion');

        }

        return view('admin.occasions.add_edit_occasion',[
            'title' => $title,
            'occasion' => $occasion,
        ]);
    }

    public function deleteOccasions($id)
    {
        $deleteoccasions = Occasion::find($id)->delete();
        Session::flash('success_message', 'Occasion Deleted Successfully');
        return redirect()->back();
    }
}
