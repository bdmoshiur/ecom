
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Thanks</li>
        </ul>
        <h3> Thanks</h3>
        <hr class="soft" />
        <div align="center">
            <h3>YOUR ORDER HAS BEEN PLACED</h3>
            <p>Your Order number is {{ Session::get('order_id') }} and total payable amount is INR {{ Session::get('grand_total') }}</p>
            <p>Please make payment by clicking on below payment button</p>
            <form action="https://sandbox.paypal.com" method="post">
                <input type="hidden" name="cart" value="_cart">
                <input type="hidden" name="business" value="sb-svwtb26939016@business.example.com">
                <input type="hidden" name="currency_code" value="INR">
                <input type="hidden" name="item_name" value="{{ Session::get('order_id') }}">
                <input type="hidden" name="amount" value="{{ round(Session::get('grand_total'),2) }}">
                <input type="hidden" name="first_name" value="{{ $nameArr[0] }}">
                <input type="hidden" name="last_name" value="{{ $nameArr[1] }}">
                <input type="hidden" name="address1" value="{{ $orderDetails['address'] }}">
                <input type="hidden" name="address2" value="">
                <input type="hidden" name="city" value="{{ $orderDetails['city'] }}">
                <input type="hidden" name="state" value="{{ $orderDetails['state'] }}">
                <input type="hidden" name="zip" value="{{ $orderDetails['pincode'] }}">
                <input type="hidden" name="email" value="{{ $orderDetails['email'] }}">
                <input type="hidden" name="country" value="{{ $orderDetails['country'] }}">
                <input type="hidden" name="return" value="{{ route('front.paypal.success') }}">
                <input type="hidden" name="cancel_return" value="{{route('front.paypal.fail') }}">
                <input type="hidden" name="notify_url" value="{{route('front.paypal.ipn') }}">
                <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-large.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            </form>
        </div>
    </div>
@endsection

<?php
Session::forget('coponCode');
Session::forget('couponAmount');
?>
