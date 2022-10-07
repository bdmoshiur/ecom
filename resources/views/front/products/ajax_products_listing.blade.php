@php
use App\Product;
@endphp
<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $catProduct)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{ route('product', $catProduct['id']) }}">
                        @php
                            $product_image_path = 'images/product_images/small/' . $catProduct['main_image'];
                        @endphp
                        @if (!empty($catProduct['main_image']) && file_exists($product_image_path))
                            <img style="width: 250px; height:250px" src="{{ asset($product_image_path) }}" alt="">
                        @else
                            <img style="width: 250px; height:250px"
                                src="{{ asset('images/product_images') }}/small/no_image.png" alt="">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{ $catProduct['product_name'] }}</h5>
                        <p>
                            {{ $catProduct['brand']['name'] }}
                        </p>
                        @php
                            $discounted_Price = Product::getDiscountPrice($catProduct['id']);
                        @endphp
                        <h4 style="text-align:center"><a class="btn" href="{{ route('product', $catProduct['id']) }}">
                                <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i
                                    class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">
                                @if ($discounted_Price > 0)
                                    <del>Tk.{{ $catProduct['product_price'] }}</del>
                                @else
                                    Tk.{{ $catProduct['product_price'] }}
                                @endif

                            </a></h4>
                        @if ($discounted_Price > 0)
                            <h4>
                                <font color='red'>Discounted Price : {{ $discounted_Price }}</font>
                            </h4>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft" />
</div>
