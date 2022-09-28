<?php
use App\Banner;
$getBanners = Banner::getBanners();
?>
@if (isset($index_page) && $index_page == 'index')
    <div id="carouselBlk">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                @foreach ($getBanners as $key => $getBanner)
                    <div class="item @if ($key == 0) active @endif">
                        <div class="container">
                            <a @if (!empty($getBanner['link'])) href="{{ url($getBanner['link']) }}" @else href="javascript:void(0)"  @endif><img
                                    style="width:100%" src="{{ asset('images/banner_images/' . $getBanner['image']) }}"
                                    alt="{{ $getBanner['alt'] }}" title="{{ $getBanner['title'] }}" /></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
    </div>
@endif
