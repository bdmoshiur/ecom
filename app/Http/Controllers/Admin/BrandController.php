<?php

namespace App\Http\Controllers\Admin;

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
        if ($id == "") {
            //Add Brand Functionality
            $title = "Add Brand";
            $brand = new Brand();
            $branddata = array();
            $message = "Brand Added Successfully";
        } else {
            //Edit Brand Functionality
            $title = "Edit Brand";
            $branddata = Brand::find($id);
            $branddata = json_decode(json_encode($branddata), true);
            $brand = Brand::find($id);
            $message = "Brand Updated Successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            dd($data);
        }
    }
}
