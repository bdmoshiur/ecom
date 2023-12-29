@php
use App\Product;
@endphp
@extends('layouts.front_layout.front_layout')

@section('content')
    <div class="span9">
        <div class="well well-small">
            <h4>Featured Products <small class="pull-right">{{ $featuredItemCount }} featured products</small></h4>
            <div class="row-fluid">
                <div id="myCarousel" @if ($featuredItemCount > 4) class="carousel slide" @endif>
                    <div class="carousel-inner">
                        @foreach ($featuredItemsChunk as $key => $featuredItem)
                            <div class="item @if ($key == 1) active @endif">
                                <ul class="thumbnails">
                                    @foreach ($featuredItem as $key => $item)
                                        <li class="span3">
                                            <div class="thumbnail">
                                                <i class="tag"></i>
                                                <a href="{{ route('product', $item['id']) }}">
                                                    @if (isset($item['main_image']))
                                                        @php
                                                            $product_image_path = 'images/product_images/small/' . $item['main_image'];
                                                        @endphp
                                                    @else
                                                        @php
                                                            $product_image_path = '';
                                                        @endphp
                                                    @endif
                                                    @if (!empty($item['main_image']) && file_exists($product_image_path))
                                                        <img src="{{ asset($product_image_path) }}" alt="">
                                                    @else
                                                        <img src="{{ asset('images/product_images') }}/small/no_image.png"
                                                            alt="">
                                                    @endif
                                                </a>

                                                <div class="caption">
                                                    <h5>{{ $item['product_name'] }}</h5>
                                                    @php
                                                        $discounted_price = Product::getDiscountPrice($item['id']);
                                                    @endphp
                                                    <h4><a class="btn" href="{{ route('product', $item['id']) }}">VIEW</a>
                                                        <span class="pull-right" style="font-size: 13px">
                                                            @if ($discounted_price > 0)
                                                                <del>Tk.{{ $item['product_price'] }}</del>
                                                                <font color='red'>Tk. {{ $discounted_price }}</font>
                                                            @else
                                                                Tk.{{ $item['product_price'] }}
                                                            @endif
                                                        </span>
                                                    </h4>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                    @if ($featuredItemCount > 4)
                    <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#featured" data-slide="next">›</a>
                    @endif
                </div>
            </div>
        </div>
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