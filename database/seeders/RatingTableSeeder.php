<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rating;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ratingsRecords =[
            ['id' => 1, 'user_id' => 1, 'product_id'=> 1, 'review'=> 'good product', 'rating' => 2,'status' => 1],
            ['id' => 2, 'user_id' => 1, 'product_id'=> 2, 'review'=> 'well product', 'rating' => 5,'status' => 1],
            ['id' => 3, 'user_id' => 2, 'product_id'=> 1, 'review'=> 'nice product', 'rating' => 3,'status' => 1],

        ];
        Rating::insert($ratingsRecords);
    }
}
