<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    public function banners()
    {
        Session::put('page', "banners");
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners',[
            'banners' => $banners,
        ]);

    }

    public function addEditBanner( Request $request, $id = null)
    {
        Session::put('page', "banners");
        if ($id == "") {
            //Add Banner Functionality
            $title = "Add Banner";
            $banner = new Banner();
            $bannerdata = array();
            $message = "Banner Added Successfully";
        } else {
            //Edit Banner Functionality
            $title = "Edit Banner";
            $banner = Banner::find($id);
            $bannerdata = Banner::find($id)->toArray();
            $message = "Banner Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'title' => 'required',
                'link' => 'required',
                'alt' => 'required',
            ];
            $customMessage = [
                'title.required' => 'Banner Title is Required',
                'link.required' => 'Banner Link is Required',
                'alt.required' => 'Banner Alt is Required',

            ];
            $this->validate($request, $rules, $customMessage);

            $banner->title = $data['title'];
            $banner->link = $data['link'];
            $banner->alt = $data['alt'];
             // Upload banner Image
             if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $image_name = $image_tmp->getClientOriginalName();
                    $extention = $image_tmp->getClientOriginalExtension();
                    $imageName = $image_name . '-' . rand(111, 99999) . '.' . $extention;
                    $banner_image_path = 'images/banner_images/' . $imageName;
                    Image::make($image_tmp)->resize(1170, 480)->save($banner_image_path);
                    $banner->image = $imageName;
                }
            }
            $banner->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.banners');

        }

        return view('admin.banners.add_edit_banner',[
            'title' => $title,
            'banner' => $banner,
            'bannerdata' => $bannerdata,
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
        if(!empty($bannerImage->image) && file_exists($banner_Image_Path.$bannerImage->image)){
            unlink($banner_Image_Path.$bannerImage->image);
        }
        Banner::find($id)->delete();
        Session::flash('success_message', 'Banner Deleted Successfully');
        return redirect()->back();
    }
}
