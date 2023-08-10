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
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            CmsPage::where('id', $data['cmspage_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'cmspage_id' => $data['cmspage_id']]);
        }
    }


}
