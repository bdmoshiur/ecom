<?php

namespace App\Http\Controllers\Front;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function listing($url)
    {
        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount > 0) {
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
            // dd($categoryDetails, $categoryProducts);
            if(isset($_GET['sort']) && !empty($_GET['sort'])){
                if($_GET['sort'] == 'product_latest'){
                    $categoryProducts->orderBy('id','desc');
                } else if($_GET['sort'] == 'priduct_name_a_z'){
                    $categoryProducts->orderBy('product_name','asc');
                }else if($_GET['sort'] == 'priduct_name_z_a'){
                    $categoryProducts->orderBy('product_name','desc');
                }else if($_GET['sort'] == 'price_lowest'){
                    $categoryProducts->orderBy('product_price','asc');
                }else if($_GET['sort'] == 'price_highest'){
                    $categoryProducts->orderBy('product_price','desc');
                }
            } else {
                $categoryProducts->orderBy('id','desc');
            }
            $categoryProducts = $categoryProducts->paginate(2);
            return view('front.products.listing', [
                'categoryDetails' => $categoryDetails,
                'categoryProducts' => $categoryProducts,
            ]);
        } else {
            abort(404);
        }
    }
}
