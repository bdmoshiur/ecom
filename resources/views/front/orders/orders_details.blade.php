<?php
    use App\Product;
    use App\Order;

    $getOrderStatus = Order::getOrderStatus($orders_details['id']);
 ?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('index')}}">Home</a> <span class="divider">/</span></li>
            <li class="active"><a href="{{ route('front.orders')}}">Orders</a></li>
        </ul>
        <h3>
            Orders #{{ $orders_details['id']}} Details
            @if ($getOrderStatus == 'New')
                <!-- Button trigger modal -->
                <button style="float: right" type="button" class="btn btn-primary" data-toggle="modal" data-target="#cancelModal">
                    Cancel Order
                </button>
            @endif

            @if ($getOrderStatus == 'Delivered')
                <!-- Button trigger modal -->
                <button style="float: right" type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnModal">
                    Return / Exchange Order
                </button>
            @endif
        </h3>

                @if (Session::has('success_message'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php Session::forget('success_message'); ?>
                @endif
                @if (Session::has('error_message'))
                    <div class="alert alert-danger" role="alert">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php Session::forget('error_message'); ?>
                @endif
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
                    @if (!empty($orders_details['courier_name']))
                    <tr>
                        <td>Courier Name</td>
                        <td>{{$orders_details['courier_name'] }}</td>
                    </tr>
                    @endif

                    @if (!empty($orders_details['tracking_number']))
                    <tr>
                        <td>Tracking Number</td>
                        <td>{{$orders_details['tracking_number'] }}</td>
                    </tr>
                    @endif
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
                        <td>Item Status</td>
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
                        <td>{{ $product['item_status'] }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

   <!-- Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <form method="post" action="{{ route('front.orders.cancel',$orders_details['id'] ) }}">
            @csrf
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Reason for Cancellation</h5>
                </div>
                <div class="modal-body">
                    <select name="reason" id="cancelReason">
                        <option value="">Select Reason</option>
                        <option value="Order Created by Mistake">Order Created by Mistake</option>
                        <option value="Item not Arrive on Time">Item not Arrive on Time</option>
                        <option value="Shipping Cost too High">Shipping Cost too High</option>
                        <option value="Found Cheaper Somewhere Else">Found Cheaper Somewhere Else</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnCancelOrder">Cancel Order</button>
                </div>
            </div>
            </div>
        </form>
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true" style="width: 380px">
        <form method="post" action="{{ route('front.orders.return',$orders_details['id'] ) }}">
            @csrf
            <div class="modal-dialog" role="document" align="center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Reason for Return / Exchange</h5>
                </div>
                <div class="modal-body">
                    <select name="return_exchange" id="returnExchange">
                        <option value="">Select Return/Exchange</option>
                        <option value="Return">Return</option>
                        <option value="Exchange">Exchange</option>
                    </select>
                </div>
                <div class="modal-body">
                    <select name="product_info" id="returnProduct">
                        <option value="">Select Product</option>
                        @foreach ($orders_details['orders_products'] as $product)
                            @if ($product['item_status'] != 'Return Initiated')
                                <option value="{{ $product['product_code'] }}-{{ $product['product_size'] }}">{{ $product['product_code'] }}-{{ $product['product_size'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="modal-body">
                    <select name="return_reason" id="returnReason">
                        <option value="">Select Reason</option>
                        <option value="Performance or Auality not Adequate">Performance or Auality not Adequate</option>
                        <option value="Product Damaged but Shipping Box ok">Product Damaged but Shipping Box ok</option>
                        <option value="Item Arrived too Late">Item Arrived too Late</option>
                        <option value="Wrong Item was Sent">Wrong Item was Sent</option>
                        <option value="Item Defective or doesn't Work">Item Defective or doesn't Work</option>
                        <option value="Require Smaller Size">Require Smaller Size</option>
                        <option value="Require Larger Size">Require Larger Size</option>
                    </select>
                </div>
                <div class="modal-body productSize">
                    <select name="required_size" id="productSize">
                        <option value="">Select Required Size</option>
                    </select>
                </div>
                <div class="modal-body">
                    <textarea name="comment" id="" placeholder="Comment"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnReturnOrder">Return Order</button>
                </div>
            </div>
            </div>
        </form>
    </div>

  @endsection
