<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fit;
use Illuminate\Support\Facades\Session;

class FitController extends Controller
{
    public function fit()
    {
        Session::put('page', "fit");
        $fits = Fit::get();

        return view('admin.fits.fits',[
            'fits' => $fits,
            ]);
    }

    public function updatefitStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Fit::where('id', $data['fit_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'fit_id' => $data['fit_id']]);
        }
    }

    public function addEditfit( Request $request, $id = null)
    {
        Session::put('page', "fit");
        if ($id == "") {
            //Add Fit Functionality
            $title = "Add fit";
            $fit = new Fit();
            $fitdata = array();
            $message = "Fit Added Successfully";
        } else {
            //Edit fit Functionality
            $title = "Edit Fit";
            $fit = Fit::find($id);
            $message = "Fit Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'fit_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'fit_name.required' => 'fit Name is Required',
                'fit_name.regex' => 'Valid fit Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $fit->name = $data['fit_name'];
            $fit->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.fit');

        }

        return view('admin.fits.add_edit_fit',[
            'title' => $title,
            'fit' => $fit,
        ]);
    }

    public function deleteFits($id)
    {
        $deletefits = Fit::find($id)->delete();
        Session::flash('success_message', 'Fit Deleted Successfully');

        return redirect()->back();
    }
}
