<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Product;

class Wishlist extends Model
{
    use HasFactory;

    public static function countWishList($product_id) {
        $countWishList =  Wishlist::where(['user_id' => Auth::user()->id,'product_id' => $product_id ] )->count();

        return $countWishList;
    }

    public static function userWishListItems() {
        $userWishListItems =  Wishlist::with(['product' => function ($query) {
            $query->select('id', 'product_name', 'product_code', 'product_color','product_price', 'main_image');
        }])->where('user_id',Auth::user()->id)->orderBy('id','desc')->get()->toArray();

        return $userWishListItems;
    }

    public function product() {

        return $this->belongsTo(Product::class, 'product_id');
    }
}
