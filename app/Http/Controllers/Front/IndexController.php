<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $index_page = 'index';
        return view('front.index', [
            'index_page' => $index_page,
        ]);
    }
}
