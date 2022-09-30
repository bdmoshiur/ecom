<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $catProduct)
            <li class="span3">
                <div class="thumbnail">
                    <a href="product_details.html">
                        @php
                            $product_image_path = 'images/product_images/small/' . $catProduct['main_image'];
                        @endphp
                        @if (!empty($catProduct['main_image']) && file_exists($product_image_path))
                            <img style="width: 250px; height:250px" src="{{ asset($product_image_path) }}"
                                alt="">
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
                        <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i
                                    class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i
                                    class="icon-shopping-cart"></i></a> <a class="btn btn-primary"
                                href="#">Tk.{{ $catProduct['product_price'] }}</a></h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft" />
</div>
