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
        $featuredItemCount = Product::where('is_featured', 'yes')->count();
        $featuredItems = Product::where('is_featured', 'yes')->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);
        return view('front.index', [
            'index_page' => $index_page,
            'featuredItemCount' => $featuredItemCount,
            'featuredItemsChunk' => $featuredItemsChunk,
        ]);
    }
}
