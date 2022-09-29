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
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1)->simplePaginate(2);
            // dd($categoryDetails, $categoryProducts);
            return view('front.products.listing', [
                'categoryDetails' => $categoryDetails,
                'categoryProducts' => $categoryProducts,
            ]);
        } else {
            abort(404);
        }
    }
}
