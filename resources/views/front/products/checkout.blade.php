<?php
    use  App\Product;
?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">CHECKOUT</li>
        </ul>
        <h3> CHECKOUT [ <small><span class="totalCartItems"> {{ totalCartItems() }} Item(s) </span> </small>]<a href="{{ route('cart') }}" class="btn btn-large pull-right"><i
                    class="icon-arrow-left"></i> Back to Cart </a></h3>
        <hr class="soft" />

        @if (Session::has('success_message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (Session::has('error_message'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <table class="table table-bordered">
            <tr>
                <th> DELIVERY ADDRESS </th>
            </tr>
            @foreach ($deliveryAddress as $address)
                <tr>
                    <td>
                        <div class="control-group" style="float: left; margin-top: -2px; margin-right:5px">
                            <input type="radio" id="address{{ $address['id']}}" name="address_id" value="{{ $address['id']}}">
                        </div>
                        <div class="control-group">
                            <label class="control-label"> {{ $address['name'] }}, {{ $address['address'] }}, {{ $address['city'] }}, {{ $address['state'] }}, {{ $address['country'] }}</label>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>



        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th colspan="2">Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Category / Product <br> Discount</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_price = 0;
                @endphp
                @foreach ($userCartItems as $item)
                    @php
                        $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']);
                    @endphp
                    <tr>
                        <td>
                            <img width="60" src="{{ asset('images/product_images/small/' . $item['product']['main_image']) }}"
                                alt="" />
                        </td>
                        <td colspan="2">
                            {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})
                            <br />
                            Color : {{ $item['product']['product_color'] }}
                            <br />
                            Size : {{ $item['size'] }}
                        </td>
                        <td>{{ $item['quantity'] }} </td>
                        <td>Tk.{{ $attrPrice['product_price'] }}</td>
                        <td>Tk.{{ $attrPrice['discount'] }}</td>
                        <td>Tk.{{ $attrPrice['final_price'] * $item['quantity'] }}</td>
                    </tr>
                    @php
                        $total_price = $total_price + $attrPrice['final_price'] * $item['quantity'];
                    @endphp
                @endforeach
                <tr>
                    <td colspan="6" style="text-align:right">Sub Total: </td>
                    <td>Tk.{{ $total_price }}</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:right">Coupon Discount: </td>
                    <td class="couponAmount">
                        @if (Session::has('couponAmount'))
                            - Tk. {{ Session::get('couponAmount') }}
                        @else
                            Tk. 0
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (Tk.{{ $total_price }} - <span class="couponAmount">Tk.0</span> )
                            =</strong></td>
                    <td class="label label-important" style="display:block"> <strong class="grand_total"> Tk.{{ $total_price - Session::get('couponAmount') }} </strong></td>
                </tr>

            </tbody>
        </table>

        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <form class="form-horizontal" id="ApplyCoupon" action="javascript:void(0)" @if (Auth::check()) user="1"
                        @endif method="post">
                            @csrf
                            <div class="control-group">
                                <label class="control-label"><strong> PAYMENT METHODS: </strong> </label>
                                <div class="controls">

                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('cart') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to Cart </a>
        <a href="{{ route('front.checkout')}}" class="btn btn-large pull-right">Place Order <i class="icon-arrow-right"></i></a>

    </div>
@endsection
