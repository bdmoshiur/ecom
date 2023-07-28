<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\OrderStatus;
use Illuminate\Support\Facades\Session;

class OrderssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        Session::put('page', "orders");
        $orders = Order::with('orders_products')->orderBy('id','desc')->get()->toArray();

        return  view('admin.orders.orders',[
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
        $users_details = User::where('id',$orders_details['user_id'])->first()->toArray();
        $order_statues = OrderStatus::where('status',1)->get()->toArray();
        return view('admin.orders.orders_details', [
            'orders_details' => $orders_details,
            'users_details' => $users_details,
            'order_statues' => $order_statues
        ]);
    }
    public function updateOrdersStaus(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status' => $data['order_status']]);
            Session::put('success_message','Order status has been updated successfully');
            return redirect()->back();
        }
    }

}
