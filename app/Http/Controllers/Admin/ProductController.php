<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Product;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page', "products");
        $products = Product::with(['category' => function ($query) {
            $query->select('id', 'category_name');
        }, 'section' => function ($query) {
            $query->select('id', 'name');
        }])->get();
        return view('admin.products.products', compact('products'));
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
            $title = "Add Product";
            $product = new Product();
        } else {
            //Edit Product Functionality
            $title = "Edit Product";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();


            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'category_id.required' => 'Category is Required',
                'product_name.required' => 'Product Name is Required',
                'product_name.regex' => 'Valid Product Name is Required',
                'product_code.required' => 'Product Code is Required',
                'product_code.regex' => 'Valid Product Code is Required',
                'product_price.required' => 'Product Price is Required',
                'product_price.numeric' => 'Valid Product Price is Required',
                'product_color.required' => 'Product Color is Required',
                'product_color.regex' => 'Valid Product Color is Required',
            ];

            $this->validate($request, $rules, $customMessage);

            if(empty($data['is_featured'])){
                $is_featured = 'No';
            } else {
                $is_featured = "Yes";
            }

            if (empty($data['fabric'])) {
                $data['fabric'] = "";
            }

            if (empty($data['sleeve'])) {
                $data['sleeve'] = "";
            }

            if (empty($data['pattern'])) {
                $data['pattern'] = "";
            }
            if (empty($data['wash_care'])) {
                $data['wash_care'] = "";
            }

            if (empty($data['fit'])) {
                $data['fit'] = "";
            }

            if (empty($data['occasion'])) {
                $data['occasion'] = "";
            }

            if (empty($data['meta_title'])) {
                $data['meta_title'] = "";
            }

            if (empty($data['meta_description'])) {
                $data['meta_description'] = "";
            }

            if (empty($data['meta_keywords'])) {
                $data['meta_keywords'] = "";
            }

            if (empty($data['product_discount'])) {
                $data['product_discount'] = 0;
            }

            if (empty($data['product_weight'])) {
                $data['product_weight'] = 0;
            }

            if (empty($data['description'])) {
                $data['description'] = "";
            }

            if (empty($data['main_image'])) {
                $data['main_image'] = "";
            }

            if (empty($data['product_video'])) {
                $data['product_video'] = "";
            }






            $categoriesDetails = Category::find($data['category_id']);

            $product->section_id = $categoriesDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->main_image = $data['main_image'];
            $product->product_video = $data['product_video'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->is_featured = $is_featured;
            $product->status = 1;
            $product->save();

            Session::flash('success_message', 'Product Added Successfully');
            return redirect()->route('admin.products');
        }

        $fabricArray = array('Coton', 'Polyester', 'Wool');
        $sleeveArray = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $fitArray = array('Regular', 'Slim');
        $occasionArray = array('Casual', 'Formal');
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        // echo "<pre>"; print_r($categories); die;

        return view('admin.products.add_edit_product', compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories'));
    }
}
