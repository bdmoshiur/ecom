
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ route('index') }}">Home</a> <span class="divider">/</span></li>
            <li class="active"> Wishlist</li>
        </ul>
        <h3> Wishlist [ <small><span class="totalWishlistItems"> {{ (totalWishlistItems()) }} Item(s) </span> </small>]<a href="{{ route('index') }}" class="btn btn-large pull-right"><i
                    class="icon-arrow-left"></i> Continue Shopping </a></h3>
        <hr class="soft" />

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
       <div id="AppendWishlishItems">
            @include('front.products.wishlist_items')
       </div>
        <a href="{{ route('index') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
    </div>
@endsection
