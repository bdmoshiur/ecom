@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('index')}}">Home</a> <span class="divider">/</span></li>
            <li class="active">Orders</li>
        </ul>
        <h3> Orders </h3>
        <hr class="soft" />
        <div class="row">
            <div class="span8">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Order ID</td>
                        <td>Order Products</td>
                        <td>Payment Method</td>
                        <td>Grand Total</td>
                        <td>Created One</td>
                        <td></td>
                    </tr>
                    @foreach ($orders as $order)
                    <tr>
                        <td><a style="text-decoration: underline" href="{{ route('front.orders.details',$order['id'])}}">#{{ $order['id'] }}</a></td>
                        <td>
                            @foreach ($order['orders_products'] as $pro)
                                {{ $pro['product_code'] }}<br>
                            @endforeach
                        </td>
                        <td>{{ $order['payment_method'] }}</td>
                        <td>INR {{ $order['grand_total'] }}</td>
                        <td>{{ date('d-m-Y', strtotime($order['created_at'] ) ) }}</td>
                        <td><a href="{{ route('front.orders.details',$order['id'])}}">View More</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
