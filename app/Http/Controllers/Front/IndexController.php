<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $index_page = 'index';
        $featuredItemCount = Product::where('is_featured', 'yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured', 'yes')->where('status', 1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);

        $newProducts = Product::orderBy('id','DESC')->where('status', 1)->limit(3)->get()->toArray();

        $meta_title = 'E-commerce website';
        $meta_description = 'E-commerce website';
        $meta_keywords = 'ecommerce, website, laravel website, php, business, website, e-commerce';

        return view('front.index', [
            'index_page' => $index_page,
            'featuredItemCount' => $featuredItemCount,
            'featuredItemsChunk' => $featuredItemsChunk,
            'newProducts' => $newProducts,
            'meta_title' => $meta_title,
            'meta_description' => $meta_description,
            'meta_keywords' => $meta_keywords,

        ]);
    }
}
