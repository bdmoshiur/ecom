<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page', "products");
        $products = Product::with(['category'=> function($query){
            $query->select('id', 'category_name');
        }, 'section'=> function($query){
            $query->select('id', 'name');
        }])->get();
        return view('admin.products.products',compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        $deleteCategories = Product::find($id)->delete();
        Session::flash('success_message', 'Category Deleted Successfully');
        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id = null)
    {
        if ($id == "") {
            //Add Product Functionality
            $title = "Add category";
        } else {
            //Edit Product Functionality
            $title = "Edit Category";

        }
        $fabricArray = array('Coton', 'Polyester', 'Wool');
        $SleeveArray = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked', 'Plain', 'Printed','Self','Solid');
        $fitArray = array('Regular', 'Slim');
        $occassionArray = array('Casual', 'Formal');

        return view('admin.products.add_edit_product', compact('title', 'fabricArray', 'SleeveArray', 'patternArray', 'fitArray', 'occassionArray'));
    }


}
