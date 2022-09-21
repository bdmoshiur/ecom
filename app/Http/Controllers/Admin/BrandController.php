<?php

namespace App\Http\Controllers\Admin;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    //
=======
use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function brands()
    {
        Session::put('page', "brands");
        $brands = Brand::get();
        return view('admin.brands.brands',[
            'brands' => $brands,
            ]);
    }

    public function updateBrandStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'brand_id' => $data['brand_id']]);
        }
    }

    public function addEditBrand( Request $request, $id = null)
    {
        Session::put('page', "brands");
        if ($id == "") {
            //Add Brand Functionality
            $title = "Add Brand";
            $brand = new Brand();
            $branddata = array();
            $message = "Brand Added Successfully";
        } else {
            //Edit Brand Functionality
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'brand_name.required' => 'Brand Name is Required',
                'brand_name.regex' => 'Valid Brand Name is Required',
            ];
            $this->validate($request, $rules, $customMessage);

            $brand->name = $data['brand_name'];
            $brand->save();

            Session::flash('success_message', $message);
            return redirect()->route('admin.brands');

        }

        return view('admin.brands.add_edit_brand',[
            'title' => $title,
            'brand' => $brand,
        ]);
    }

    public function deleteBrands($id)
    {
        $deleteBrands = Brand::find($id)->delete();
        Session::flash('success_message', 'Brand Deleted Successfully');
        return redirect()->back();
    }
>>>>>>> 61183679f2b2a0026380ae560234fd821ab40917
}
