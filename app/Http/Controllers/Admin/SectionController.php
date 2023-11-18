<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function sections()
    {
        Session::put('page', "sections");
        $sections = Section::get();

        return view('admin.sections.sections', compact('sections'));
    }

    public function updateSectionStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Section::where('id', $data['section_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'section_id' => $data['section_id']]);
        }
    }

    public function addEditSection( Request $request, $id = null)
    {
        Session::put('page', "sections");
        if ($id == "") {
            //Add Section Functionality
            $title = "Add Section";
            $section = new Section();
            $sectiondata = array();
            $message = "Section Added Successfully";
        } else {
            //Edit Section Functionality
            $title = "Edit Section";
            $section = Section::find($id);
            $message = "Section Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'section_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'section_name.required' => 'Section Name is Required',
                'section_name.regex' => 'Valid Section Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $section->name = $data['section_name'];
            $section->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.sections');
        }

        return view('admin.sections.add_edit_section',[
            'title' => $title,
            'section' => $section,
        ]);
    }

    public function deleteSections($id)
    {
        $deleteSections = Section::find($id)->delete();
        Session::flash('success_message', 'Section Deleted Successfully');

        return redirect()->back();
    }
}
