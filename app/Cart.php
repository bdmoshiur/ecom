<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    public static function userCartItrms()
    {
        if(Auth::check()){
            $userCartItems = Cart::with(['product' => function($query){
                $query->select('id','category_id','product_name','product_code','product_color','product_weight','main_image');
            }])->where('user_id', Auth::user()->id)->orderBy('id','desc')->get()->toArray();
        } else {
            $userCartItems = Cart::with(['product' => function($query){
                $query->select('id','category_id','product_name','product_code','product_color','product_weight','main_image');
            }])->where('session_id', Session::get('session_id'))->orderBy('id','desc')->get()->toArray();
        }

        return $userCartItems;
    }
    //
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public static function getProductAttrPrice( $product_id, $size)
    {
        $attrPrice = ProductsAttribute::select('price')->where(['product_id'=>$product_id, 'size'=> $size])->first()->toarray();
        return $attrPrice['price'];
    }
}
