@php
use App\Product;
@endphp
@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="span9">
        <h4>Latest Products </h4>
        <ul class="thumbnails">
            @foreach ($newProducts as $newProduct)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="{{ route('product', $newProduct['id']) }}">
                            @if (isset($newProduct['main_image']))
                                @php
                                    $product_image_path = 'images/product_images/small/' . $newProduct['main_image'];
                                @endphp
                            @else
                                @php
                                    $product_image_path = '';
                                @endphp
                            @endif
                            @if (!empty($newProduct['main_image']) && file_exists($product_image_path))
                                <img style="width: 150px" src="{{ asset($product_image_path) }}" alt="">
                            @else
                                <img style="width: 150px" src="{{ asset('images/product_images') }}/small/no_image.png"
                                    alt="">
                            @endif
                        </a>
                        <div class="caption">
                            <h5>{{ $newProduct['product_name'] }}</h5>
                            <p>
                                {{ $newProduct['product_code'] }} {{ $newProduct['product_color'] }}
                            </p>
                            @php
                                $discounted_price = Product::getDiscountPrice($newProduct['id']);
                            @endphp
                            <h4 style="text-align:center">
                                {{--  <a class="btn"
                                    href="{{ route('product', $newProduct['id']) }}"> <i class="icon-zoom-in"></i></a>  --}}
                                <a class="btn" href="javascript:void(0)">Add to <i class="icon-shopping-cart"></i></a> <a
                                    class="btn btn-secondary" href="javascript:void(0)">
                                    @if ($discounted_price > 0)
                                        <del>Tk.{{ $newProduct['product_price'] }}</del>
                                        <font color='red'>Tk. {{ $discounted_price }}</font>
                                    @else
                                        Tk.{{ $newProduct['product_price'] }}
                                    @endif
                                </a>
                            </h4>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
