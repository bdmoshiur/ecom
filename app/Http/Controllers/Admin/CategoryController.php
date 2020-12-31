<?php

namespace App\Http\Controllers\Admin;

use App\Section;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
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


    public function addEditCategory(Request $request,$id=null)
    {
            if($id ==""){
                $title = "add category";
                $category = new Category();
            }else{
                $title = "edit Category";
            }

            if($request->isMethod('post')){
                    $data = $request->all();
                    // echo "<pre>"; print_r($data); die;

                    $rules = [
                        'category_name'=> 'required|regex:/^[\pL\s\-]+$/u',
                        'section_id' => 'required',
                        'url'=> 'required',
                        'category_image'=> 'image',
                    ];
                    $customMessage = [
                        'category_name.required' => 'Category Name is Required',
                        'category_name.regex' => 'Valid Category Name is Required',
                        'section_id.required' => 'Section is Required',
                        'url.required' => 'Category URL is Required',
                        'category_image.image' => 'Valid Image is Required',
                    ];
                    $this->validate($request,$rules,$customMessage);


                    // Upload Category Image
                    if($request->hasFile('category_image')){
                        $image_tmp = $request->file('category_image');
                        if($image_tmp->isValid()){
                            $extention = $image_tmp->getClientOriginalExtension();
                            $imageName = rand(111,99999).'.'.$extention;
                            $imagePath = 'images/category_images/'.$imageName;
                            Image::make($image_tmp)->resize(300,400)->save($imagePath);
                            $category->category_image = $imageName;
                        }
                    }

                    if(empty($data['category_discount'])){
                        $data['category_discount'] = "";
                    }
                    if(empty($data['description'])){
                        $data['description'] = "";
                    }
                    if(empty($data['meta_title'])){
                        $data['meta_title'] = "";
                    }
                    if(empty($data['meta_description'])){
                        $data['meta_description'] = "";
                    }
                    if(empty($data['meta_keywords'])){
                        $data['meta_keywords'] = "";
                    }

                    $category->parent_id = $data['parent_id'];
                    $category->section_id = $data['section_id'];
                    $category->category_name = $data['category_name'];
                    $category->category_discount = $data['category_discount'];
                    $category->description = $data['description'];
                    $category->url = $data['url'];
                    $category->meta_title = $data['meta_title'];
                    $category->meta_description = $data['meta_description'];
                    $category->meta_keywords = $data['meta_keywords'];
                    $category->status = 1;
                    $category->save();
                    Session::flash('success_message','Category Added Successfully');
                    return redirect()->route('admin.categories');
                }

                //get all sections
                $getSections = Section::get();
                return view('admin.categories.add_edit_category',compact('title','getSections'));
    }


    public function appendCategoryLevel(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            echo "<pre>"; print_r($data); die;
        }
    }






}
