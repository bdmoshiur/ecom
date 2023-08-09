<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use App\Order;
use App\Sms;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\ProductsAttribute;

class PaypalController extends Controller
{
    public function paypal(){
        if(Session::has('order_id')){
            Cart::where('user_id', Auth::user()->id)->delete();
           $orderDetails = Order::where('id',Session::get('order_id'))->first()->toArray();
           $nameArr = explode(' ', $orderDetails['name']);
            return view('front.paypal.paypal',[
                'orderDetails' => $orderDetails,
                'nameArr' => $nameArr
            ]);
        }else{
            return redirect()->route('cart');
        }
    }
    public function success() {
        if(Session::has('order_id')){
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.paypal.success');
        }else{
            return redirect()->route('cart');
        }
    }

    public function fail() {
            return view('front.paypal.fail');
    }

    public function ipn( Request $request ) {

        $data = $request->all();
        if ($data['payment_status'] == 'Completed') {
            $order_id = Session::get('order_id');

            Order::where('id', $order_id)->update(['order_status' => 'Paid' ]);

            $message = "Dear Customer, Your order ". $order_id . "has been successfully placed with e-commerce website. we will intimate you once your order is shipped";
            $mobile = Auth::user()->mobile;

            Sms::sendSms($message,$mobile);

            $orders_details = Order::with('orders_products')->where('id', $order_id)->first()->toArray();

            foreach ($orders_details['orders_products'] as $order) {
                $getProductStock = ProductsAttribute::where(['product_id'=> $order['product_id'], 'size' => $order['size']])->first()->toarray();
                $newStock = $getProductStock['stock'] - $order['quantity'];

                ProductsAttribute::where(['product_id'=> $order['product_id'], 'size' => $order['size']])->update(['stock' => $newStock]);
            }


            $email = Auth::user()->email;
            $user = Auth::user()->name;
            $messageData = [
                'name' => $user,
                'email' => $email,
                'order_id' => $order_id,
                'orders_details' => $orders_details,
            ];
            Mail::send('emails.order', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Order Placed E-commerce website');
            });

        }

        return view();
    }

}
