<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\OrdersLog;
use App\AdminRole;
use Illuminate\Support\Facades\Auth;
use App\Sms;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\ReturnRequest;
use App\ExchangeRequest;
use App\OrderProduct;
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

        $orderModuleCount = AdminRole::where(['admin_id'=> Auth::guard('admin')->user()->id, 'module' => 'orders'])->count();

        if(Auth::guard('admin')->user()->type == 'superadmin'){
            $orderModule['view_access'] = 1;
            $orderModule['edit_access'] = 1;
            $orderModule['full_access'] = 1;
        }else if ($orderModuleCount == 0) {
            $message =  "This feature is restrected for you!";
            Session::flash('error_message', $message);
            return redirect()->route('admin.dashboard');
        }else{
            $orderModule = AdminRole::where(['admin_id'=> Auth::guard('admin')->user()->id, 'module' => 'orders'])->first()->toArray();
        }

        return  view('admin.orders.orders',[
            'orders' => $orders,
            'orderModule' => $orderModule
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

    public function viewOrdersInvoice($id) {
        $orders_details = Order::with('orders_products')->where('id', $id)->first()->toArray();
        $users_details = User::where('id',$orders_details['user_id'])->first()->toArray();

        return view('admin.orders.orders_invoice', [
            'orders_details' => $orders_details,
            'users_details' => $users_details,
        ]);
    }

    public function printPdfInvoice($id) {
        $orders_details = Order::with('orders_products')->where('id', $id)->first()->toArray();
        $users_details = User::where('id',$orders_details['user_id'])->first()->toArray();

        $output = '<!DOCTYPE html>
        <html lang="en">
          <head>
            <meta charset="utf-8">
            <title>Example 2</title>
            <style>
            @font-face {
                font-family: SourceSansPro;
                src: url(SourceSansPro-Regular.ttf);
              }

              .clearfix:after {
                content: "";
                display: table;
                clear: both;
              }

              a {
                color: #0087C3;
                text-decoration: none;
              }

              body {
                position: relative;
                width: 21cm;
                height: 29.7cm;
                margin: 0 auto;
                color: #555555;
                background: #FFFFFF;
                font-family: Arial, sans-serif;
                font-size: 14px;
                font-family: SourceSansPro;
              }

              header {
                padding: 10px 0;
                margin-bottom: 20px;
                border-bottom: 1px solid #AAAAAA;
              }

              #logo {
                float: left;
                margin-top: 8px;
              }

              #logo img {
                height: 70px;
              }

              #company {
                float: right;
                text-align: right;
              }


              #details {
                margin-bottom: 50px;
              }

              #client {
                padding-left: 6px;
                border-left: 6px solid #0087C3;
                float: left;
              }

              #client .to {
                color: #777777;
              }

              h2.name {
                font-size: 1.4em;
                font-weight: normal;
                margin: 0;
              }

              #invoice {
                float: right;
                text-align: right;
              }

              #invoice h1 {
                color: #0087C3;
                font-size: 2.4em;
                line-height: 1em;
                font-weight: normal;
                margin: 0  0 10px 0;
              }

              #invoice .date {
                font-size: 1.1em;
                color: #777777;
              }

              table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px;
              }

              table th,
              table td {
                padding: 20px;
                background: #EEEEEE;
                text-align: center;
                border-bottom: 1px solid #FFFFFF;
              }

              table th {
                white-space: nowrap;
                font-weight: normal;
              }

              table td {
                text-align: right;
              }

              table td h3{
                color: #57B223;
                font-size: 1.2em;
                font-weight: normal;
                margin: 0 0 0.2em 0;
              }

              table .no {
                color: #FFFFFF;
                font-size: 1.6em;
                background: #57B223;
              }

              table .desc {
                text-align: left;
              }

              table .unit {
                background: #DDDDDD;
              }

              table .qty {
              }

              table .total {
                background: #57B223;
                color: #FFFFFF;
              }

              table td.unit,
              table td.qty,
              table td.total {
                font-size: 1.2em;
              }

              table tbody tr:last-child td {
                border: none;
              }

              table tfoot td {
                padding: 10px 20px;
                background: #FFFFFF;
                border-bottom: none;
                font-size: 1.2em;
                white-space: nowrap;
                border-top: 1px solid #AAAAAA;
              }

              table tfoot tr:first-child td {
                border-top: none;
              }

              table tfoot tr:last-child td {
                color: #57B223;
                font-size: 1.4em;
                border-top: 1px solid #57B223;

              }

              table tfoot tr td:first-child {
                border: none;
              }

              #thanks{
                font-size: 2em;
                margin-bottom: 50px;
              }

              #notices{
                padding-left: 6px;
                border-left: 6px solid #0087C3;
              }

              #notices .notice {
                font-size: 1.2em;
              }

              footer {
                color: #777777;
                width: 100%;
                height: 30px;
                position: absolute;
                bottom: 0;
                border-top: 1px solid #AAAAAA;
                padding: 8px 0;
                text-align: center;
              }

            </style>
          </head>
          <body>
            <header class="clearfix">
              <div id="logo">
                <h1>ORDER INVOICE</h1>
              </div>
            </header>
            <main>
              <div id="details" class="clearfix">
                <div id="client">
                  <div class="to">INVOICE TO:</div>
                  <h2 class="name">'.$orders_details['name'].'</h2>
                  <div class="address">'.$orders_details['address'].','.$orders_details['city'].','.$orders_details['state'].'</div>
                  <div class="address">'.$orders_details['country'].','.$orders_details['pincode'].'</div>
                  <div class="email"><a href="mailto:'.$orders_details['email'].'">'.$orders_details['email'].'</a></div>
                </div>
                <div style="float:right">
                  <h1>Order ID '.$orders_details['id'].'</h1>
                  <div class="date">Order Date: '.date('d-m-Y', strtotime($orders_details['created_at'] ) ).'</div>
                  <div class="date">Order Amount: INR '.$orders_details['grand_total'].' </div>
                  <div class="date">Order Status:'.$orders_details['order_status'].' </div>
                  <div class="date">Payment Method:'.$orders_details['payment_method'].' </div>
                </div>
              </div>
              <table border="0" cellspacing="0" cellpadding="0">
                <thead>
                  <tr>
                    <th class="unit">Product Code</th>
                    <th class="desc">Size</th>
                    <th class="unit">Color</th>
                    <th class="qty">Price</th>
                    <th class="unit">Qty</th>
                    <th class="total">Totals</th>
                  </tr>
                </thead>
                <tbody>';
                  $subtotal = 0;
                  foreach ($orders_details['orders_products'] as $product){
                    $output .= '<tr>
                    <td class="unit">'.$product['product_code'].'</td>
                    <td class="desc">'.$product['product_size'].'</td>
                    <td class="unit">'.$product['product_color'].'</td>
                    <td class="qty">INR '.$product['product_price'].'</td>
                    <td class="unit">'.$product['product_quantity'].'</td>
                    <td class="total">INR '.$product['product_price'] * $product['product_quantity'].'</td>
                  </tr>';
                  $subtotal =  $subtotal + ($product['product_price'] * $product['product_quantity']) ;
                }
                $output .= '</tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">SUBTOTAL</td>
                    <td>INR '.$subtotal.'</td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">Shipping Charges</td>
                    <td>INR 0</td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">Coupon Discount</td>';
                    if($orders_details['coupon_amount']){
                      $output .= ' <td>INR '.$orders_details['coupon_amount'].'</td>';
                    }else{
                      $output .= ' <td>INR 0</td>';
                    }
                    $output .= ' </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td colspan="2">GRAND TOTAL</td>
                    <td>INR '.$orders_details['grand_total'].'</td>
                  </tr>
                </tfoot>
              </table>
            </main>
            <footer>
              Invoice was created on a computer and is valid without the signature and seal.
            </footer>
          </body>
        </html>';
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($output);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();


        return view('admin.orders.orders_invoice', [
            'orders_details' => $orders_details,
            'users_details' => $users_details,
        ]);
    }

    public function viewOrdersCharts() {

        $current_month_orders = Order::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();

        $before_1_month_orders = Order::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(1))
        ->count();

        $before_2_month_orders = Order::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(2))
        ->count();

        $before_3_month_orders = Order::whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonth(3))
        ->count();

        $ordersCount = [
          $current_month_orders,
           $before_1_month_orders,
           $before_2_month_orders,
           $before_3_month_orders,
        ];

        return view('admin.orders.view_orders_charts', [
            'ordersCount' => $ordersCount,
        ]);
    }

    public function returnRequest() {
        Session::put('page', "return_requests");
        $return_requests = ReturnRequest::orderBy('created_at','DESC')->get()->toArray();

        return view('admin.orders.return_requests',[
            'return_requests' => $return_requests,
        ]);
    }

    public function exchangeRequest() {
        Session::put('page', "exchange_requests");
        $exchange_requests = ExchangeRequest::orderBy('created_at','DESC')->get()->toArray();

        return view('admin.orders.exchange_requests',[
            'exchange_requests' => $exchange_requests,
        ]);
    }


    public function returnRequestUpdate(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();

            //get return details
            $returnDetails = ReturnRequest::where('id',$data['return_id'])->first()->toArray();

            // update return status in return_requests table
            ReturnRequest::where('id',$data['return_id'])->update(['return_status' => $data['return_status']]);

            // Update return_staus in orders_products table
            OrderProduct::where([
                'order_id'     => $returnDetails['order_id'],
                'product_code' => $returnDetails['product_code'],
                'product_size' => $returnDetails['product_size']
            ])->update([
                'item_status' => 'Return '.$data['return_status']
            ]);

            // User Deatails
            $userDetails = User::select('name','email')->where('id', $returnDetails['user_id'])->first()->toArray();


            //Send return status email
            $email       = $userDetails['email'];
            $return_status = $data['return_status'];
            $messageData = [
                'userDetails' => $userDetails,
                'returnDetails' => $returnDetails,
                'return_status' => $return_status,
            ];

            Mail::send('emails.return_requests', $messageData, function ($message) use ($email, $return_status ) {
                $message->to($email)->subject('Return Request ' .$return_status);
            });

            $message = 'Return request has been '.$return_status. ' and email send to user';
            Session::put('success_message', $message);
            return redirect()->route('admin.return.requests');
        }

    }

        public function exchangeRequestUpdate(Request $request) {
            if ($request->isMethod('post')) {
                $data = $request->all();

                //get exchange details
                $exchangeDetails = ExchangeRequest::where('id',$data['exchange_id'])->first()->toArray();

                // update exchange status in exchange_requests table
                ExchangeRequest::where('id',$data['exchange_id'])->update(['exchange_status' => $data['exchange_status']]);

                // Update exchange_staus in orders_products table
                OrderProduct::where([
                    'order_id'     => $exchangeDetails['order_id'],
                    'product_code' => $exchangeDetails['product_code'],
                    'product_size' => $exchangeDetails['product_size']
                ])->update([
                    'item_status' => 'Exchange '.$data['exchange_status']
                ]);

                // User Deatails
                $userDetails = User::select('name','email')->where('id', $exchangeDetails['user_id'])->first()->toArray();


                //Send exchange status email
                $email       = $userDetails['email'];
                $exchange_status = $data['exchange_status'];
                $messageData = [
                    'userDetails' => $userDetails,
                    'exchangeDetails' => $exchangeDetails,
                    'exchange_status' => $exchange_status,
                ];

                Mail::send('emails.exchange_requests', $messageData, function ($message) use ($email, $exchange_status ) {
                    $message->to($email)->subject('Exchange Request ' .$exchange_status);
                });

                $message = 'Exchange request has been '.$exchange_status. ' and email send to user';
                Session::put('success_message', $message);
                return redirect()->route('admin.exchange.requests');
            }
        }



}
