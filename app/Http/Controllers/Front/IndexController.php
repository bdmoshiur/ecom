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
        return view('front.index', [
            'index_page' => $index_page,
            'featuredItemCount' => $featuredItemCount,
            'featuredItemsChunk' => $featuredItemsChunk,
            'newProducts' => $newProducts,
        ]);
    }
}
