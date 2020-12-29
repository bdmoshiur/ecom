<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page',"categories");
        $categories = Category::all();
        return view('admin.categories.categories',compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id','category_id')->update(['status'=>$status]);
            return response()->jeson(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }




    

}
