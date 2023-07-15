@php
use App\Product;
@endphp
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th colspan="2">Description</th>
            <th>Quantity/Update</th>
            <th>Unit Price</th>
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
                <td>
                    <div class="input-append">
                        <input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}"
                            id="appendedInputButtons" size="16" type="text">
                        <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $item['id'] }}"><i
                                class="icon-minus "></i></button>
                        <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{ $item['id'] }}"><i
                                class="icon-plus "></i></button>
                        <button class="btn btn-danger cartItemDelete" type="button" data-cartid="{{ $item['id'] }}"><i class="icon-remove icon-white"></i></button>
                    </div>
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
