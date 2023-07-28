<?php use App\Product; ?>
@extends('layouts.admin_layout.admin_layout')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    @if (Session::has('success_message'))
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                        {{ Session::forget('success_message') }}
                    @endif
                    <div class="col-sm-6">
                        <h1>Catelogues</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Orders #{{ $orders_details['id'] }} Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
            <div class="row">
            <div class="col-md-6">
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Order Details</h3>
            </div>

            <div class="card-body">
            <table class="table table-bordered">
            <tbody>
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
            </tbody>
            </table>
            </div>
            </div>

            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Delivery Address</h3>
            </div>

            <div class="card-body p-0">
            <table class="table table-bordered">
            <tbody>
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
            </tbody>
            </table>
            </div>

            </div>

            </div>

            <div class="col-md-6">
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Customer Details</h3>
            </div>

            <div class="card-body p-0">
            <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{ $users_details['name'] }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $users_details['email'] }}</td>
                </tr>
            </tbody>
            </table>
            </div>

            </div>

            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Billing Address</h3>
            </div>

            <div class="card-body p-0">
            <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{ $users_details['name'] }}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{ $users_details['address'] }}</td>
                </tr>
                <tr>
                    <td>City</td>
                    <td>{{ $users_details['city'] }}</td>
                </tr>
                <tr>
                    <td>State</td>
                    <td>{{ $users_details['state'] }}</td>
                </tr>
                <tr>
                    <td>Country</td>
                    <td>{{ $users_details['country'] }}</td>
                </tr>
                <tr>
                    <td>Pincode</td>
                    <td>{{ $users_details['pincode'] }}</td>
                </tr>
                <tr>
                    <td>Mobile</td>
                    <td>{{ $users_details['mobile'] }}</td>
                </tr>

            </tbody>
            </table>
            </div>

            </div>




            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Update Order Status</h3>
                </div>

                <div class="card-body p-0">
                <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <form action="{{ route('admin.update.orderstatus') }}" method="post">
                                @csrf
                            <input type="hidden" name="order_id" value="{{$orders_details['id'] }}">
                            <select name="order_status">
                                <option value="">Select Status</option>
                                @foreach ($order_statues as $status)
                                    <option value="{{ $status['name'] }}" @if (isset($orders_details['order_status']) && $orders_details['order_status'] == $status['name'])
                                        selected=""
                                    @endif>{{ $status['name'] }}</option>
                                @endforeach
                            </select>&nbsp;&nbsp;
                            <button type="submit">Update</button>
                        </form>
                        </td>
                    </tr>
                </tbody>
                </table>
                </div>

                </div>



            </div>

            </div>

            <div class="row">
            <div class="col-12">
            <div class="card">
            <div class="card-header">
            <h3 class="card-title">Product Details</h3>
            <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
            <div class="input-group-append">
            <button type="submit" class="btn btn-default">
            <i class="fas fa-search"></i>
            </button>
            </div>
            </div>
            </div>
            </div>

            <div class="card-body table-responsive p-0">
             <table class="table table-hover text-nowrap">
            <thead>
            <tr>
                <tr>
                    <td>Product Image</td>
                    <td>Product Code</td>
                    <td>Product Name</td>
                    <td>Product Size</td>
                    <td>Product Color</td>
                    <td>Product Qty</td>
                </tr>
            </tr>
            </thead>
            <tbody>
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

            </tbody>
            </table>
            </div>
            </div>
            </div>
            </div>


            </div>
            </section>
    </div>
@endsection
