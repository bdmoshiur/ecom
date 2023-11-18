<?php
use App\Cart;
use App\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


function totalCartItems() {
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $totalcartItems = Cart::where('user_id',$user_id)->sum('quantity');

    } else{
        $session_id = Session::get('session_id');
        $totalcartItems = Cart::where('session_id',$session_id)->sum('quantity');
    }
    return $totalcartItems;
}



function totalWishlistItems() {
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $totalWishlistItems = Wishlist::where('user_id',$user_id)->count();

    }
    return $totalWishlistItems;
}
