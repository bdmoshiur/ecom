<?php

namespace Database\Seeders;

use App\ProductsImage;
use Illuminate\Database\Seeder;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImageRecoreds = [
            [
                'id' => 1,
                'product_id' => 1,
                'image' => 'product-1.jpg',
                'status' => 1,
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'image' => 'product-2.jpg',
                'status' => 1,
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'image' => 'product-3.jpg',
                'status' => 1,
            ],
        ];


        ProductsImage::insert($productImageRecoreds);
    }
}
