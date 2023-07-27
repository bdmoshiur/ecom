<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\OrderProduct;

class Order extends Model
{
    use HasFactory;

    public function orders_products() {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
