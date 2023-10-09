<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery_address extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function deliveryAddress() {

        $user_id = Auth::user()->id;
        $deliveryAddress = Delivery_address::where('user_id',$user_id)->get()->toArray();

        return $deliveryAddress;
    }

}
