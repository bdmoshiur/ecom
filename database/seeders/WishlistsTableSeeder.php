<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Wishlist;

class WishlistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wishlistsRecords = [
            ['id' => 1, 'user_id' => '1', 'product_id' => 1],
            ['id' => 2, 'user_id' => '2', 'product_id' => 2],
            ['id' => 3, 'user_id' => '3', 'product_id' => 3],
        ];

        Wishlist::insert($wishlistsRecords);
    }
}
