<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Section;
use App\Category;
use App\ProductsAttribute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
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
        // dd($request->all());
        if ($id == "") {
            //Add Product Functionality
            $title = "Add Product";
            $product = new Product();
            $productdata = array();
            $message = "Product Added Successfully";

        } else {
            //Edit Product Functionality
            $title = "Edit Product";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata), true);
            $product = Product::find($id);
            $message = "Product Updated Successfully";
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

             // Upload Product Image
             if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    $image_name = $image_tmp->getClientOriginalName();
                    $extention = $image_tmp->getClientOriginalExtension();
                    $imageName = $image_name .'-'.rand(111, 99999) . '.' . $extention;
                    $large_image_path = 'images/product_images/large/' . $imageName;
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260, 300)->save($small_image_path);
                    $product->main_image = $imageName;
                }
            }

            // Upload Product Video
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    $video_name = $video_tmp->getClientOriginalName();
                    $extention = $video_tmp->getClientOriginalExtension();
                    $VideoName = $video_name .'-'.rand() . '.' . $extention;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path, $VideoName);
                    $product->product_video = $VideoName;
                }
            }

            $categoriesDetails = Category::find($data['category_id']);

            $product->section_id = $categoriesDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
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

            Session::flash('success_message', $message);
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

        return view('admin.products.add_edit_product', compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'productdata'));
    }

    public function deleteProductImage($id)
    {
        $product = Product::find($id);

        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        if (file_exists( $small_image_path . $product->main_image)) {
            unlink($small_image_path . $product->main_image);
        }
        if (file_exists( $medium_image_path . $product->main_image)) {
            unlink($medium_image_path. $product->main_image);
        }
        if (file_exists( $large_image_path . $product->main_image)) {
            unlink($large_image_path . $product->main_image);
        }
        $product->main_image = "";
        $product->save();
        return redirect()->back()->with('success_message', 'Product Image Deleted Successfully');
    }

    public function deleteProductVideo($id)
    {
        $product = Product::find($id);
        if (file_exists('videos/product_videos/' . $product->product_video)) {
            unlink('videos/product_videos/' . $product->product_video);
        }
        $product->product_video = "";
        $product->save();
        return redirect()->back()->with('success_message', 'Product Video Deleted Successfully');
    }

    function add_attributes(Request $request, $id)
    {
        if($request->isMethod('post')) {
            $data = $request->all();
            foreach($data['sku'] as $key => $val) {
                if(!empty($val)) {
                    $attrCountSKU = ProductsAttribute::where(['sku' => $val])->count();
                    if($attrCountSKU > 0){
                        Session::flash('error_message', 'SKU already Exists.Please add another SKU');
                        return redirect()->back();
                    }
                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $val;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
        }

       $productdata = Product::find($id);
       $productdata = json_decode(json_encode($productdata), true);

       $title = "Product Attributes";

       return view('admin.products.add_attributes', compact('productdata', 'title'));

    }
}
