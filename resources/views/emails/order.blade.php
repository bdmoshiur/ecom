<html lang="en">
    <body>
        <table style="width: 70px">
            <tr><td>&nbsp;</td></tr>
            <tr><td><img src="{{ asset('images/front_images/logo1.png')}}" alt="logo"></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Hello {{ $name }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thank you for shipping with us. Your order details are as below.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Order No: {{ $order_id }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table style="width: 95%" csllpadding="5" cellspacing="5" bgcolor="#f7f4f4" >
                        <tr bgcolor="#cccccc">
                            <td>Product Name</td>
                            <td>Product Code</td>
                            <td>Product Size</td>@auth
                                
                            @endauth
                            <td>Product Color</td>
                            <td>Product Quantity</td>
                            <td>Product Price</td>
                        </tr>
                        @foreach ($orders_details['orders_products'] as $order )
                        <tr>
                            <td>{{ $order['product_name'] }}</td>
                            <td>{{ $order['product_code'] }}</td>
                            <td>{{ $order['product_size'] }}</td>
                            <td>{{ $order['product_color'] }}</td>
                            <td>{{ $order['product_quantity'] }}</td>
                            <td>INR {{ $order['product_price'] }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right">Shipping Charges</td>
                            <td>INR {{ $orders_details['shipping_charges'] }} </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Coupon Discount</td>
                            <td>INR {{ $orders_details['coupon_amount'] }} </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Grand Total</td>
                            <td>INR {{ $orders_details['grand_total'] }} </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><strong>Delivery Address:-</strong></td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['name'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['address'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['city'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['state'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['country'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['pincode'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ $orders_details['mobile'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>For any enquiries.You can contact us at <a href="mailto:moshiurcse888@gmail.com">moshiurcse888@gmail.com</a> </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Regards, <br>Team e-commerce website.</td></tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </body>
</html>