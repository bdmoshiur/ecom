<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\CmsPage;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cmsPages()
    {
        Session::put('page', "cmsPages");
        $cms_pages = CmsPage::get();

        return view('admin.pages.cms_pages',[
            'cms_pages' => $cms_pages,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateCmsPageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }

            CmsPage::where('id', $data['cmspage_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'cmspage_id' => $data['cmspage_id']]);
        }
    }

    public function addEditCmsPage( Request $request, $id = null)
    {
        Session::put('page', "cmsPages");
        if ($id == "") {
            //Add CMS Page Functionality
            $title = "Add CMS Page";
            $cms_page = new CmsPage();
            $message = "CMS Page Added Successfully";
        } else {
            //Edit CMS Page Functionality
            $title = "Edit CMS Page";
            $cms_page = CmsPage::find($id);
            $message = "CMS Page Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'title' => 'required',
                'description' => 'required',
                'url' => 'required',
            ];

            $customMessage = [
                'title.required' => 'Title is Required',
                'description.required' => 'Description is Required',
                'url.required' => 'Url is Required',
            ];

            $this->validate($request, $rules, $customMessage);


            $cms_page->title = $data['title'];
            $cms_page->description = $data['description'];
            $cms_page->url = $data['url'];
             // Check if the fields exist before assigning them
            if (isset($data['meta_title'])) {
                $cms_page->meta_title = $data['meta_title'];
            }
            if (isset($data['meta_description'])) {
                $cms_page->meta_description = $data['meta_description'];
            }
            if (isset($data['meta_keywords'])) {
                $cms_page->meta_keywords = $data['meta_keywords'];
            }
            $cms_page->status = 1;
            $cms_page->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.cms.pages');
        }

        return view('admin.pages.add_edit_cms_pages',[
            'title' => $title,
            'cms_page' => $cms_page,
        ]);
    }

    public function deleteCmsPages($id)
    {
        CmsPage::find($id)->delete();
        Session::flash('success_message', 'CMS Page Deleted Successfully');

        return redirect()->back();
    }
}
