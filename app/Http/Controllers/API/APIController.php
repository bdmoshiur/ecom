<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

class APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pushOrder($id)
    {
        $getResult = Order::pushOrder($id);
        return response()->json([ 'status'=> $getResult]);
    }
}
