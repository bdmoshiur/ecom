<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::get();

        return view('admin.brands.brands',[
            'brands' => $brands,
            ]);
    }
}
