<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrdersLog;
use App\ReturnRequest;
use App\OrderProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function ordersCancel(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            if (isset($data['reason']) && empty('reason')) {
                return redirect()->back();
            }

            $user_id_auth = Auth::user()->id;
            $user_id_order = Order::select('user_id')->where('id', $id)->first();

            if ($user_id_auth == $user_id_order->user_id ) {

                $cancelOrder = Order::where('id', $id)->update(['order_status' => 'Cancelled']);

                //update oder log
                $log = new OrdersLog();

                $log->order_id = $id;
                $log->order_status = 'User Cancelled';
                $log->reason = $data['reason'];
                $log->updated_by = "User";
                $log->save();

                $message = "Order has been Cancelled";
                Session::flash('success_message', $message);

                return redirect()->back();
            }else{
                $message = "Your order cancellation request is not valid !";
                Session::flash('error_message', $message);

                return redirect()->route('front.orders');
            }
        }
    }


    public function ordersReturn(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $user_id_auth = Auth::user()->id;
            $user_id_order = Order::select('user_id')->where('id', $id)->first();

            if ($user_id_auth == $user_id_order->user_id ) {

                $productArr = explode('-', $data['product_info'] );
                $product_code = $productArr[0];
                $product_size = $productArr[1];

                OrderProduct::where(['order_id' => $id, 'product_code' => $product_code, 'product_size' => $product_size])->update(['item_status' => 'Return Initiated']);

                $return = new ReturnRequest();

                $return->order_id = $id;
                $return->user_id = $user_id_auth;
                $return->product_size = $product_size;
                $return->product_code = $product_code;
                $return->return_reason = $data['return_reason'];
                $return->return_status = 'Pending';
                $return->comment = $data['comment'];
                $return->save();

                $message = "Return request has been placed for the ordered product";
                Session::flash('success_message', $message);
                return redirect()->back();
            }else{
                $message = "Your order return request is not valid!";
                Session::flash('error_message', $message);

                return redirect()->route('front.orders');
            }
        }
    }


}
