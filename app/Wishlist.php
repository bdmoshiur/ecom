<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Wishlist extends Model
{
    use HasFactory;

    public static function countWishList($product_id) {
        $countWishList =  Wishlist::where(['user_id' => Auth::user()->id,'product_id' => $product_id ] )->count();

        return $countWishList;
    }
}
