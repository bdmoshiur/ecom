<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    public function banners()
    {
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners',[
            'banners' => $banners,
        ]);

    }

    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'banner_id' => $data['banner_id']]);
        }
    }

    public function deleteBanners($id)
    {
        $bannerImage = Banner::find($id);
        $banner_Image_Path = 'images/banner_images/';
        if(file_exists($banner_Image_Path.$bannerImage->image)){
            unlink($banner_Image_Path.$bannerImage->image);
        }
        Banner::find($id)->delete();
        Session::flash('success_message', 'Banner Deleted Successfully');
        return redirect()->back();
    }
}
