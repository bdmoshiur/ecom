<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\OrdersLog;
use App\Sms;
use App\OrderStatus;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

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
        $orders_log = OrdersLog::where('order_id',$id)->orderBy('id','DESC')->get()->toArray();

        return view('admin.orders.orders_details', [
            'orders_details' => $orders_details,
            'users_details' => $users_details,
            'order_statues' => $order_statues,
            'orders_log' => $orders_log,
        ]);
    }
    public function updateOrdersStaus(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            Order::where('id',$data['order_id'])->update(['order_status' => $data['order_status']]);
            Session::put('success_message','Order status has been updated successfully');

            // update courier name and tracking number

            if (!empty($data['courier_name']) && !empty($data['tracking_number']) ) {
                Order::where('id',$data['order_id'])->update(['courier_name' => $data['courier_name'], 'tracking_number' => $data['tracking_number'] ]);
            }

            //get delivery details
            $deliveryDetails = Order::select('mobile','email', 'name')->where('id',$data['order_id'])->first()->toArray();

            //Send order status SMS
            $message = "Dear Customer, Your order #". $data['order_id'] . "status has been updated to '" . $data['order_status'] . " ' shipped placed with e-commerce website";
            $mobile = $deliveryDetails['mobile'];
            Sms::sendSms($message,$mobile);

            //Send order status Mail
            $orders_details = Order::with('orders_products')->where('id', $data['order_id'])->first()->toArray();

            $email = $deliveryDetails['email'];
            $user = $deliveryDetails['name'];
            $messageData = [
                'name' => $user,
                'email' => $email,
                'order_id' => $data['order_id'],
                'order_status' => $data['order_status'],
                'courier_name' => $data['courier_name'],
                'tracking_number' => $data['tracking_number'],
                'orders_details' => $orders_details,
            ];
            Mail::send('emails.order_status', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Order Status Update E-commerce website');
            });

            //Order Status logs

            $log = new OrdersLog();
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            return redirect()->back();
        }
    }

}
