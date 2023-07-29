<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # {{ $orders_details['id'] }}</h3>
                <br>
                <span class="pull-right">
                    <?php echo DNS1D::getBarcodeHTML($orders_details['id'], 'C39'); ?>
                </span><br>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
                    @if ($users_details['name'])
                        {{ $users_details['name'] }} <br>
                    @endif
                    @if ($users_details['address'])
                        {{ $users_details['address'] }} <br>
                    @endif
                    @if ($users_details['city'])
                        {{ $users_details['city'] }} <br>
                    @endif
                    @if ($users_details['state'])
                        {{ $users_details['state'] }} <br>
                    @endif
                    @if ($users_details['country'])
                        {{ $users_details['country'] }} <br>
                    @endif
                    @if ($users_details['pincode'])
                        {{ $users_details['pincode'] }} <br>
                    @endif
                    @if ($users_details['mobile'])
                        {{ $users_details['mobile'] }} <br>
                    @endif
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
                    {{ $orders_details['name'] }}<br>
                    {{ $orders_details['address'] }} , {{ $orders_details['city'] }}<br>
                    {{ $orders_details['state'] }}<br>
                    {{ $orders_details['country'] }} , {{ $orders_details['pincode'] }}<br>
                    {{ $orders_details['mobile'] }}<br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $orders_details['payment_method'] }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ date('d-m-Y', strtotime($orders_details['created_at'] ) ) }}
    				</address>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
        							<td class="text-center"><strong>Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                @php
                                    $sub_total = 0;
                                @endphp
    							@foreach ($orders_details['orders_products'] as $product)
                                <tr>
    								<td>
                                        Name : {{ $product['product_name'] }} <br>
                                        Code : {{ $product['product_code'] }} <br>
                                        Size : {{ $product['product_size'] }} <br>
                                        Color : {{ $product['product_color'] }} <br>
                                        <?php echo DNS1D::getBarcodeHTML($product['product_code'], 'C39'); ?>
                                    </td>
    								<td class="text-center">INR {{ $product['product_price'] }}</td>
    								<td class="text-center">{{ $product['product_quantity'] }}</td>
    								<td class="text-right">INR {{ $product['product_price']  * $product['product_quantity'] }}</td>
    							</tr>
                                @php
                                    $sub_total += ($product['product_price']  * $product['product_quantity']);
                                @endphp
                                @endforeach
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Sub Total</strong></td>
    								<td class="thick-line text-right">INR {{ $sub_total }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Shipping</strong></td>
    								<td class="no-line text-right">INR 0</td>
    							</tr>
                                @if ($orders_details['coupon_amount'] > 0)
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-center"><strong>Discount</strong></td>
                                        <td class="no-line text-right">INR {{ $orders_details['coupon_amount'] }}</td>
                                    </tr>
                                @endif
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Grand Total</strong></td>
    								<td class="no-line text-right">INR {{ $orders_details['grand_total'] }}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
