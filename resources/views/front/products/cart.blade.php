
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active"> SHOPPING CART</li>
        </ul>
        <h3> SHOPPING CART [ <small><span class="totalCartItems"> {{ totalCartItems() }} Item(s) </span> </small>]<a href="{{ route('index') }}" class="btn btn-large pull-right"><i
                    class="icon-arrow-left"></i> Continue Shopping </a></h3>
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
       <div id="appendCartItems">
        @include('front.products.cart_items')
       </div>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <form class="form-horizontal" id="ApplyCoupon" action="javascript:void(0)" @if (Auth::check()) user="1"
                        @endif method="post">
                            @csrf
                            <div class="control-group">
                                <label class="control-label"><strong> COUPON CODE: </strong> </label>
                                <div class="controls">
                                    <input type="text" class="input-medium" name="code" id="code" placeholder="Enter coupon code" required="">
                                    <button type="submit" class="btn"> ADD </button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>

            </tbody>
        </table>

        <!-- <table class="table table-bordered">
                                   <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
                                   <tr>
                                   <td>
                                    <form class="form-horizontal">
                                    <div class="control-group">
                                     <label class="control-label" for="inputCountry">Country </label>
                                     <div class="controls">
                                     <input type="text" id="inputCountry" placeholder="Country">
                                     </div>
                                    </div>
                                    <div class="control-group">
                                     <label class="control-label" for="inputPost">Post Code/ Zipcode </label>
                                     <div class="controls">
                                     <input type="text" id="inputPost" placeholder="Postcode">
                                     </div>
                                    </div>
                                    <div class="control-group">
                                     <div class="controls">
                                     <button type="submit" class="btn">ESTIMATE </button>
                                     </div>
                                    </div>
                                    </form>
                                   </td>
                                   </tr>
                                            </table> -->
        <a href="{{ route('index') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
        <a href="{{ route('front.checkout')}}" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

    </div>
@endsection
