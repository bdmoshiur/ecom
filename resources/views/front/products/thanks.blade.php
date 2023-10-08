
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}">Home</a> <span class="divider">/</span></li>
            <li class="active">Thanks</li>
        </ul>
        <h3> Thanks</h3>
        <hr class="soft" />
        <div align="center">
            <h3>YOUR ORDER HAS BEEN PLACED SUCCESSFULLY</h3>
            <p>Your Order number is {{ Session::get('order_id') }} and Grand total is INR {{ Session::get('grand_total') }}</p>
        </div>
    </div>
@endsection

<?php
Session::forget('order_id');
Session::forget('grand_total');
Session::forget('coponCode');
Session::forget('couponAmount');
?>
