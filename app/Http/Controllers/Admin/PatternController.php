<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pattern;
use Illuminate\Support\Facades\Session;

class PatternController extends Controller
{
    public function pattern()
    {
        Session::put('page', "pattern");
        $patterns = Pattern::get();
        return view('admin.patterns.patterns',[
            'patterns' => $patterns,
            ]);
    }

    public function updatePatternStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Pattern::where('id', $data['pattern_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'pattern_id' => $data['pattern_id']]);
        }
    }

    public function addEditpattern( Request $request, $id = null)
    {
        Session::put('page', "pattern");
        if ($id == "") {
            //Add pattern Functionality
            $title = "Add Pattern";
            $pattern = new Pattern();
            $patterndata = array();
            $message = "Pattern Added Successfully";
        } else {
            //Edit Pattern Functionality
            $title = "Edit Pattern";
            $pattern = Pattern::find($id);
            $message = "Pattern Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'pattern_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'pattern_name.required' => 'Pattern Name is Required',
                'pattern_name.regex' => 'Valid Pattern Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $pattern->name = $data['pattern_name'];
            $pattern->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.pattern');

        }

        return view('admin.patterns.add_edit_pattern',[
            'title' => $title,
            'pattern' => $pattern,
        ]);
    }

    public function deletePatterns($id)
    {
        $deletepatterns = Pattern::find($id)->delete();
        Session::flash('success_message', 'Pattern Deleted Successfully');
        return redirect()->back();
    }
}
