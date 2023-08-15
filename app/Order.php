<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\OrderProduct;

class Order extends Model
{
    use HasFactory;

    public function orders_products() {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function order_items() {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public static function pushOrder($order_id) {
        $orderDetails =  Order::with('order_items')->where('id', $order_id)->first()->toArray();

        $orderDetails['order_id'] = $orderDetails['id'];
        $orderDetails['order_date'] = $orderDetails['created_at'];
        $orderDetails['pickup_location'] = 'Test';
        $orderDetails['channel_id'] = '115211';
        $orderDetails['comment'] = 'Test order';
        $orderDetails['billing_customer_name'] = $orderDetails['name'];
        $orderDetails['billing_last_name'] = '';
        $orderDetails['billing_address'] = $orderDetails['address'];
        $orderDetails['billing_address_2'] = '';
        $orderDetails['billing_city'] = $orderDetails['city'];
        $orderDetails['billing_pincode'] = $orderDetails['pincode'];
        $orderDetails['billing_state'] = $orderDetails['state'];
        $orderDetails['billing_country'] = $orderDetails['country'];
        $orderDetails['billing_email'] = $orderDetails['email'];
        $orderDetails['billing_phone'] = $orderDetails['mobile'];
        $orderDetails['shipping_is_billing'] = true;
        $orderDetails['shipping_customer_name'] = $orderDetails['name'];
        $orderDetails['shipping_last_name'] = '';
        $orderDetails['shipping_address'] = $orderDetails['address'];
        $orderDetails['shipping_address_2'] = '';
        $orderDetails['shipping_city'] = $orderDetails['city'];
        $orderDetails['shipping_pincode'] = $orderDetails['pincode'];
        $orderDetails['shipping_state'] = $orderDetails['state'];
        $orderDetails['shipping_country'] = $orderDetails['country'];
        $orderDetails['shipping_email'] = $orderDetails['email'];
        $orderDetails['shipping_phone'] = $orderDetails['mobile'];

        foreach ($orderDetails['order_items'] as $key => $item) {
            $orderDetails['order_items'][$key]['name'] = $item['product_name'];
            $orderDetails['order_items'][$key]['sku'] = $item['product_code'];
            $orderDetails['order_items'][$key]['units'] = $item['product_quantity'];
            $orderDetails['order_items'][$key]['selling_price'] = $item['product_price'];
            $orderDetails['order_items'][$key]['discount'] = '';
            $orderDetails['order_items'][$key]['tax'] = '';
            $orderDetails['order_items'][$key]['hsn'] = '';
        }
        $orderDetails['shipping_charges'] = 0;
        $orderDetails['giftwrap_charges'] = 0;
        $orderDetails['transaction_charges'] = 0;
        $orderDetails['total_discount'] = 0;
        $orderDetails['sub_total'] = $orderDetails['grand_total'];        ;
        $orderDetails['length'] = 1;
        $orderDetails['breadth'] = 1;
        $orderDetails['height'] = 1;
        $orderDetails['weight'] = 1;

        echo "<pre>"; print_r(json_encode($orderDetails)); die;

        // return response()->json(['orderDetails' => $orderDetails]);

    }
}
