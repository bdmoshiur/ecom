<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('index')}}">Home</a> <span class="divider">/</span></li>
            <li class="active"><a href="{{ route('front.orders')}}">Orders</a></li>
        </ul>
        <h3> Orders #{{ $orders_details['id']}} Details</h3>
        <hr class="soft" />

        <div class="row">
            <div class="span4">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td colspan="2"><strong>Order Details</strong></td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td>{{ date('d-m-Y', strtotime($orders_details['created_at'])) }}</td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td>{{$orders_details['order_status'] }}</td>
                    </tr>
                    <tr>
                        <td>Order Total</td>
                        <td>INR {{ $orders_details['grand_total'] }}</td>
                    </tr>
                    <tr>
                        <td>Shipping Charges</td>
                        <td>INR {{ $orders_details['shipping_charges'] }}</td>
                    </tr>
                    <tr>
                        <td>Coupon Code</td>
                        <td>{{ $orders_details['coupon_code'] }}</td>
                    </tr>
                    <tr>
                        <td>Coupon Amount</td>
                        <td>{{ $orders_details['coupon_amount'] }}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td>{{ $orders_details['payment_method'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="span4">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td colspan="2"><strong>Delivery Address</strong></td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $orders_details['name'] }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $orders_details['address'] }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{ $orders_details['city'] }}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>{{ $orders_details['state'] }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>{{ $orders_details['country'] }}</td>
                    </tr>
                    <tr>
                        <td>Pincode</td>
                        <td>{{ $orders_details['pincode'] }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $orders_details['mobile'] }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="span8">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Product Image</td>
                        <td>Product Code</td>
                        <td>Product Name</td>
                        <td>Product Size</td>
                        <td>Product Color</td>
                        <td>Product Qty</td>
                    </tr>
                    @foreach ($orders_details['orders_products'] as $product)
                    <tr>
                        <td>
                            <?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                           <a href="{{ route('product',$product['product_id'])}}" target="_blank" rel="noopener noreferrer"> <img style="width: 80px" src="{{ asset('/images/product_images/small/'.$getProductImage) }}" alt="Product Image"></a>
                        </td>
                        <td>{{ $product['product_code'] }}</td>
                        <td>{{ $product['product_name'] }}</td>
                        <td>{{ $product['product_size'] }}</td>
                        <td>{{ $product['product_color'] }}</td>
                        <td>{{ $product['product_quantity'] }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
