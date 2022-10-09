@php
use App\Product;
@endphp
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active"> SHOPPING CART</li>
        </ul>
        <h3> SHOPPING CART [ <small>3 Item(s) </small>]<a href="products.html" class="btn btn-large pull-right"><i
                    class="icon-arrow-left"></i> Continue Shopping </a></h3>
        <hr class="soft" />
        <table class="table table-bordered">
            <tr>
                <th> I AM ALREADY REGISTERED </th>
            </tr>
            <tr>
                <td>
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="inputUsername">Username</label>
                            <div class="controls">
                                <input type="text" id="inputUsername" placeholder="Username">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">Password</label>
                            <div class="controls">
                                <input type="password" id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">Sign in</button> OR <a href="register.html"
                                    class="btn">Register Now!</a>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <a href="forgetpass.html" style="text-decoration:underline">Forgot password ?</a>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>

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
            <thead>
                <tr>
                    <th>Product</th>
                    <th colspan="2">Description</th>
                    <th>Quantity/Update</th>
                    <th>MRP</th>
                    <th> Category / Product <br> Discount</th>
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
                            <img width="60"
                                src="{{ asset('images/product_images/small/' . $item['product']['main_image']) }}"
                                alt="" />
                        </td>
                        <td colspan="2">
                            {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})
                            <br />
                            Color : {{ $item['product']['product_color'] }}
                            <br />
                            Size : {{ $item['size'] }}
                        </td>
                        <td>
                            <div class="input-append"><input class="span1" style="max-width:34px"
                                    value="{{ $item['quantity'] }}" id="appendedInputButtons" size="16"
                                    type="text"><button class="btn" type="button"><i
                                        class="icon-minus"></i></button><button class="btn" type="button"><i
                                        class="icon-plus"></i></button><button class="btn btn-danger" type="button"><i
                                        class="icon-remove icon-white"></i></button> </div>
                        </td>
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
                    <td colspan="6" style="text-align:right">Voucher Discount: </td>
                    <td> Tk.0.00</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (Tk.{{ $total_price }} - Tk.0 )
                            =</strong></td>
                    <td class="label label-important" style="display:block"> <strong> Tk.{{ $total_price }} </strong></td>
                </tr>

            </tbody>
        </table>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <form class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
                                <div class="controls">
                                    <input type="text" class="input-medium" placeholder="CODE">
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
        <a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
        <a href="login.html" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

    </div>
@endsection
