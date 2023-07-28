<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        $orders = Order::with('orders_products')->where('user_id', Auth::user()->id)->orderBy('id','DESC')->get()->toArray();

        return view('front.orders.orders', [
            'orders' => $orders,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ordersDetails($id)
    {
        $orders_details = Order::with('orders_products')->where('id', $id)->first()->toArray();

        return view('front.orders.orders_details', [
            'orders_details' => $orders_details,
        ]);
    }

}
