<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Media;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class MediaController extends Controller
{
    public function media()
    {
        Session::put('page', "media");
        $medias = Media::get();
        return view('admin.media.media',[
            'medias' => $medias,
            ]);
    }

    public function updateMediaStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Media::where('id', $data['media_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'media_id' => $data['media_id']]);
        }
    }

    public function addEditMedia( Request $request, $id = null)
    {
        Session::put('page', "media");
        if ($id == "") {
            //Add media Functionality
            $title = "Add Media";
            $media = new Media();
            $mediadata = array();
            $message = "Media Added Successfully";
        } else {
            //Edit Media Functionality
            $title = "Edit Media";
            $media = Media::find($id);
            $message = "Media Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'link' => 'required',
            ];
            $customMessage = [
                'name.required' => 'Media Name is Required',
                'name.regex' => 'Valid Media Name is Required',
                'link.required' => 'Media Link is Required',
            ];
            $this->validate($request, $rules, $customMessage);


         // Upload media Image
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');
            if ($image_tmp->isValid()) {
                $extention = $image_tmp->getClientOriginalExtension();
                $imageName = rand(111, 99999) . '.' . $extention;
                $imagePath = 'images/media_images/' . $imageName;
                Image::make($image_tmp)->resize(60, 80)->save($imagePath);
            }
        }else if (!empty($data['image'])) {
            $imageName = $data['image'];
        } else {
            $imageName = "";
        }

            $media->name = $data['name'];
            $media->link = $data['link'];
            $media->image = $imageName;
            $media->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.media');

        }

        return view('admin.media.add_edit_media',[
            'title' => $title,
            'media' => $media,
        ]);
    }

    public function deleteMedia($id)
    {
        $deletemedia = Media::find($id)->delete();
        Session::flash('success_message', 'Media Deleted Successfully');
        return redirect()->back();
    }
}
