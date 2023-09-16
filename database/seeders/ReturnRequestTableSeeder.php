<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\ReturnRequest;

class ReturnRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $returnRequest =[
            ['id' => 1, 'order_id' => 1, 'user_id' => 1, 'product_size'=> 'large', 'product_code' => 'B-2344',
             'return_reason'=> 'Item not Arrive on Time', 'return_status' => 'Pending','comment' => 'nice product'],
             ['id' => 2, 'order_id' => 1, 'user_id' => 1, 'product_size'=> 'small', 'product_code' => 'B-1344',
             'return_reason'=> 'Order Created by Mistake', 'return_status' => 'Pending','comment' => 'nice product'],

        ];
        ReturnRequest::insert($returnRequest);
    }
}
