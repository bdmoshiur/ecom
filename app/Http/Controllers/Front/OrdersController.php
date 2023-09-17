<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\OrdersLog;
use App\ReturnRequest;
use App\OrderProduct;
use App\Product;
use App\ProductsAttribute;
use App\ExchangeRequest;
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

                if ($data['return_exchange'] == 'Return') {

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

                }else if($data['return_exchange'] == 'Exchange'){

                    $productArr = explode('-', $data['product_info'] );
                    $product_code = $productArr[0];
                    $product_size = $productArr[1];

                    OrderProduct::where(['order_id' => $id, 'product_code' => $product_code, 'product_size' => $product_size])->update(['item_status' => 'Exchange Initiated']);

                    $exchange = new ExchangeRequest();

                    $exchange->order_id = $id;
                    $exchange->user_id = $user_id_auth;
                    $exchange->product_size = $product_size;
                    $exchange->required_size = $data['required_size'];
                    $exchange->product_code = $product_code;
                    $exchange->exchange_reason = $data['return_reason'];
                    $exchange->exchange_status = 'Pending';
                    $exchange->comment = $data['comment'];
                    $exchange->save();

                    $message = "Exchange request has been placed for the ordered product";
                    Session::flash('success_message', $message);
                    return redirect()->back();

                }else{
                    $message = "Your order return/exchange request is not valid!";
                    Session::flash('error_message', $message);
                    return redirect()->route('front.orders');
                }

            }else{
                $message = "Your order return/exchange request is not valid!";
                Session::flash('error_message', $message);

                return redirect()->route('front.orders');
            }

        }
    }


    public function getProductSize(Request $request) {
        $data = $request->all();

        // Split the product_info into product_code and product_size
        $productArr = explode('-', $data['product_info']);
        $product_code = $productArr[0];
        $product_size = $productArr[1];

        // Get the product id from the product code
        $productId = Product::select('id')->where('product_code' , $product_code)->first();
        $product_id = $productId->id;

        // Get available sizes for the product
        $productSizes = ProductsAttribute::select('size')
            ->where('product_id', $product_id)
            ->where('size', '!=', $product_size)
            ->where('stock', '>', 0)
            ->get()
            ->toArray();

        // Generate HTML for dropdown menu
        $appendSizes = '<option value="">Select Required Size</option>';
        foreach ($productSizes as $size) {
            $appendSizes .= '<option value="'.$size['size'].'">'.$size['size'].'</option>';
        }

        // Return the HTML for the dropdown menu
        return $appendSizes;
    }



}
