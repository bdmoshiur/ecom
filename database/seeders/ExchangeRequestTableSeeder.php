<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\ExchangeRequest;

class ExchangeRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exchangeRequest =[
            ['id' => 1, 'order_id' => 1, 'user_id' => 1, 'product_size'=> 'small', 'required_size' => 'large',
             'product_code'=>'B-43537','exchange_reason'=> 'Item not Arrive on Time', 'exchange_status' => 'Pending','comment' => 'nice product'],

            ['id' => 2, 'order_id' => 2, 'user_id' => 3, 'product_size'=> 'medium', 'required_size' => 'large',
             'product_code'=>'B-46537','exchange_reason'=> 'Item not Arrive on Time', 'exchange_status' => 'Pending','comment' => 'good product'],

        ];
        ExchangeRequest::insert($exchangeRequest);
    }
}
