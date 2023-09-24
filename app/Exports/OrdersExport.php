<?php

namespace App\Exports;

use App\Order;
use App\OrderProduct;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements WithHeadings, FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $ordersData = Order::select('id','user_id', 'name', 'address', 'city', 'state','country',
         'mobile', 'email', 'order_status','payment_method','payment_gateway', 'grand_total')->orderBy('id','DESC')->get();

        foreach ($ordersData as $key => $value) {
            $orderItems = OrderProduct::select('id','product_code','product_name', 'product_color',
             'product_size', 'product_price','product_quantity')->where('order_id', $value['id'])->get();

            $product_codes = '';
            $product_names = '';
            $product_colors = '';
            $product_sizes= '';
            $product_prices = '';
            $product_quantites = '';
            foreach ($orderItems as $key => $item) {
                $product_codes .= $item['product_code'] . ',';
                $product_names .= $item['product_name'] . ',';
                $product_colors .= $item['product_color'] . ',';
                $product_sizes .= $item['product_size'] . ',';
                $product_prices .= $item['product_price'] . ',';
                $product_quantites .= $item['product_quantity'] . ',';
            }
            $ordersData[$key]['product_codes'] = $product_codes;
            $ordersData[$key]['product_names'] = $product_names;
            $ordersData[$key]['product_colors'] = $product_colors;
            $ordersData[$key]['product_sizes'] = $product_sizes;
            $ordersData[$key]['product_prices'] = $product_prices;
            $ordersData[$key]['product_quantites'] = $product_quantites;



        }

        return $ordersData;
    }

    public function headings(): array
    {
        return [
            'Id',
            'User Id',
            'Name',
            'Address',
            'City',
            'State',
            'Country',
            'Mobile',
            'Email',
            'Order Status',
            'Payment Method',
            'Payment Gateway',
            'Grand Total',
            'Product Codes',
            'Product Names',
            'Product Colors',
            'Product Sizes',
            'Product Prices',
            'Product Quantites',
        ];
    }
}
