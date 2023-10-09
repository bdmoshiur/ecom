<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Product;
use App\Section;
use App\Category;
use App\AdminRole;
use Illuminate\Support\Facades\Auth;
use App\ProductsImage;
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

        $productModuleCount = AdminRole::where(['admin_id'=> Auth::guard('admin')->user()->id, 'module' => 'products'])->count();

        if(Auth::guard('admin')->user()->type == 'superadmin'){
            $productModule['view_access'] = 1;
            $productModule['edit_access'] = 1;
            $productModule['full_access'] = 1;
        }else if ($productModuleCount == 0) {
            $message =  "This feature is restrected for you!";
            Session::flash('error_message', $message);
            return redirect()->route('admin.dashboard');
        }else{
            $productModule = AdminRole::where(['admin_id'=> Auth::guard('admin')->user()->id, 'module' => 'products'])->first()->toArray();
        }

        return view('admin.products.products', compact('products','productModule'));
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
        Product::find($id)->delete();
        Session::flash('success_message', 'Product Deleted Successfully');

        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id = null)
    {

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
                'brand_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessage = [
                'category_id.required' => 'Category is Required',
                'brand_id.required' => 'Brand is Required',
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

            // Upload Product Image
            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    $image_name = $image_tmp->getClientOriginalName();
                    $extention = $image_tmp->getClientOriginalExtension();
                    $imageName = $image_name . '-' . rand(111, 99999) . '.' . $extention;
                    $large_image_path = 'images/product_images/large/' . $imageName;
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;
                    Image::make($image_tmp)->resize(1000, 1000)->save($large_image_path);
                    Image::make($image_tmp)->resize(500, 500)->save($medium_image_path);
                    Image::make($image_tmp)->resize(250, 250)->save($small_image_path);
                    $product->main_image = $imageName;
                }
            }

            // Upload Product Video
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    $video_name = $video_tmp->getClientOriginalName();
                    $extention = $video_tmp->getClientOriginalExtension();
                    $VideoName = $video_name . '-' . rand() . '.' . $extention;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path, $VideoName);
                    $product->product_video = $VideoName;
                }
            }

            $categoriesDetails = Category::find($data['category_id']);

            $product->section_id = $categoriesDetails['section_id'];
            $product->brand_id = $data['brand_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->group_code = $data['group_code'];
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
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = 'No';
            }

            $product->status = 1;
            $product->save();

            Session::flash('success_message', $message);

            return redirect()->route('admin.products');
        }

        //products Filters
        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        // echo "<pre>"; print_r($categories); die;
        $brands = Brand::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true);

        return view('admin.products.add_edit_product', compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'productdata', 'brands'));
    }

    public function deleteProductImage($id)
    {
        $product = Product::find($id);

        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        if (file_exists($small_image_path . $product->main_image)) {
            unlink($small_image_path . $product->main_image);
        }

        if (file_exists($medium_image_path . $product->main_image)) {
            unlink($medium_image_path . $product->main_image);
        }

        if (file_exists($large_image_path . $product->main_image)) {
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

    function addAttributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['sku'] as $key => $val) {
                if (!empty($val)) {

                    $attSku = ProductsAttribute::where(['sku' => $val]);

                    if ($attSku->count() > 0) {
                        $message = 'SKU already exists for this product. Please add another SKU.';
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]]);
                    if ($attSize->count() > 0) {
                        $message = 'Size already exists for this product. Please add another Size.';
                        Session::flash('error_message', $message);
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
            Session::flash('success_message', 'Product attributes has been added successfully');

            return redirect()->back();
        }

        $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'main_image')->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        $title = "Product Attributes";

        return view('admin.products.add_attributes', compact('productdata', 'title'));
    }

    public function editAttributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            foreach ($data['attrId'] as $key => $val) {
                if (!empty($val)) {
                    ProductsAttribute::where(['id' => $data['attrId'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
            }

            $success_message = 'Product Attributes updated successfully.';
            Session::flash('success_message', $success_message);

            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }

    public function deleteAttribute($id)
    {
        ProductsAttribute::find($id)->delete();
        Session::flash('success_message', 'Product Attribute Deleted Successfully');

        return redirect()->back();
    }

    public function addImagess(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    $temp_image = Image::make($file);
                    $extension = $file->getClientOriginalExtension();
                    $filename = rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/product_images/large/';
                    $medium_image_path = 'images/product_images/medium/';
                    $small_image_path = 'images/product_images/small/';
                    $file->move($large_image_path, $filename);
                    Image::make($temp_image)->save($large_image_path . $filename);
                    Image::make($large_image_path . $filename)->resize(520, 600)->save($medium_image_path . $filename);
                    Image::make($large_image_path . $filename)->resize(260, 300)->save($small_image_path . $filename);
                    $product_image = new ProductsImage;
                    $product_image->product_id = $id;
                    $product_image->image = $filename;
                    $product_image->status = 1;
                    $product_image->save();
                }
                $message = 'Product Images added successfully.';
                Session::flash('success_message', $message);

                return redirect()->back();
            }
        }

        $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_price', 'main_image')->with('images')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        $title = "Add Images";

        return view('admin.products.add_images', compact('productdata', 'title'));
    }

    public function updateImageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsImage::where('id', $data['image_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'image_id' => $data['image_id']]);
        }
    }


    public function deleteImage($id)
    {
        $product_image = ProductsImage::find($id);

        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        if (file_exists($small_image_path . $product_image->image)) {
            unlink($small_image_path . $product_image->image);
        }

        if (file_exists($medium_image_path . $product_image->image)) {
            unlink($medium_image_path . $product_image->image);
        }

        if (file_exists($large_image_path . $product_image->image)) {
            unlink($large_image_path . $product_image->image);
        }

        $product_image->delete();

        return redirect()->back()->with('success_message', 'Product Image Deleted Successfully');
    }

    public function editImages()
    {
        echo 'uncomplete work';
    }
}
