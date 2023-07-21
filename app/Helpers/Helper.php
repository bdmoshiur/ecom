<?php
use App\Cart;

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
