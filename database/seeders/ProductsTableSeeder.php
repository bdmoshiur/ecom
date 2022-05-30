<?php

namespace Database\Seeders;

use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
            [
                'id' => 1,
                'category_id' => 6,
                'section_id' => 1,
                'product_name' => 'Blue T-Sharts',
                'product_code' => 'BT001',
                'product_color' => 'Blue',
                'product_price' => '1250',
                'product_discount' => '500',
                'product_weight' => '1.5',
                'product_video' => 'https://www.youtube.com/embed/JgHfx2v9s5g',
                'main_image' => 'https://res.cloudinary.com/sivadass/image/upload/v1587240554/products/product-1_zvjyqp.jpg',
                'description' => 'Printed chiffon dress with tank straps',
                'wash_care' => 'Hand Wash, Tumble Dry',
                'fabric' => 'Cotton',
                'pattern' => 'Printed',
                'sleeve' => 'Short',
                'fit' => 'Regular',
                'occasion' => 'Casual',
                'meta_title' => 'Printed Chiffon Dress',
                'meta_description' => 'Printed chiffon dress with tank straps',
                'meta_keywords' => 'Printed Chiffon Dress, Printed Dress, Chiffon Dress',
                'is_featured' => 'No',
                'status' => 1,
            ],
            [
                'id' => 2,
                'category_id' => 6,
                'section_id' => 1,
                'product_name' => 'Printed Chiffon Dress',
                'product_code' => 'BT002',
                'product_color' => 'Red',
                'product_price' => '1250',
                'product_discount' => '500',
                'product_weight' => '1.5',
                'product_video' => 'https://www.youtube.com/embed/JgHfx2v9s5g',
                'main_image' => 'https://res.cloudinary.com/sivadass/image/upload/v1587240554/products/product-2_xqzqjq.jpg',
                'description' => 'Printed chiffon dress with tank straps',
                'wash_care' => 'Hand Wash, Tumble Dry',
                'fabric' => 'Cotton',
                'pattern' => 'Printed',
                'sleeve' => 'Short',
                'fit' => 'Regular',
                'occasion' => 'Casual',
                'meta_title' => 'Printed Chiffon Dress',
                'meta_description' => 'Printed chiffon dress with tank straps',
                'meta_keywords' => 'Printed Chiffon Dress, Printed Dress, Chiffon Dress',
                'is_featured' => 'No',
                'status' => 1,
            ],
        ];

        Product::insert($productRecords);
    }
}
