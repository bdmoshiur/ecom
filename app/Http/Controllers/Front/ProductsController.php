<?php

namespace App\Http\Controllers\Front;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $url = $data['url'];
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }

                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }

                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == 'product_latest') {
                        $categoryProducts->orderBy('id', 'desc');
                    } else if ($data['sort'] == 'priduct_name_a_z') {
                        $categoryProducts->orderBy('product_name', 'asc');
                    } else if ($data['sort'] == 'priduct_name_z_a') {
                        $categoryProducts->orderBy('product_name', 'desc');
                    } else if ($data['sort'] == 'price_lowest') {
                        $categoryProducts->orderBy('product_price', 'asc');
                    } else if ($data['sort'] == 'price_highest') {
                        $categoryProducts->orderBy('product_price', 'desc');
                    }
                } else {
                    $categoryProducts->orderBy('id', 'desc');
                }
                $categoryProducts = $categoryProducts->paginate(30);
                return view('front.products.ajax_products_listing', [
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                    'url' => $url,
                ]);
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                $categoryProducts = $categoryProducts->paginate(30);

                //products Filters
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];
                $page_name = 'listing';
                return view('front.products.listing', [
                    'page_name' => $page_name,
                    'categoryDetails' => $categoryDetails,
                    'categoryProducts' => $categoryProducts,
                    'url' => $url,
                    'fabricArray' => $fabricArray,
                    'sleeveArray' => $sleeveArray,
                    'patternArray' => $patternArray,
                    'fitArray' => $fitArray,
                    'occasionArray' => $occasionArray,
                ]);
            } else {
                abort(404);
            }
        }
    }
}
