<?php

namespace Database\Seeders;

use App\ProductsAttribute;
use Illuminate\Database\Seeder;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productAttributesRecords = [
            ['id' => 1 , 'product_id' => 1, 'size' => 'small', 'price' => 1200, 'stock' => 10, 'sku'=> 'BTSC-1', 'status' => 1 ],
            ['id' => 2 , 'product_id' => 1, 'size' => 'medium', 'price' => 1500, 'stock' => 10, 'sku'=> 'BTSC-2', 'status' => 1 ],
            ['id' => 3 , 'product_id' => 1, 'size' => 'large', 'price' => 1800, 'stock' => 10, 'sku'=> 'BTSC-3', 'status' => 1 ],
        ];
        ProductsAttribute::insert($productAttributesRecords);
    }
}