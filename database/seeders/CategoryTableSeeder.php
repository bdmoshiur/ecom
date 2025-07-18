<?php
namespace Database\Seeders;
use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords = [
            [
                'id' => 1, 'parent_id' => 0, 'section_id' => 1, 'category_name' => 'T-Shirts', 'category_image' => '', 'category_discount' => 0,
                'description' => '', 'url' => 't-shirts', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1
            ],

            [
                'id' => 2, 'parent_id' => 0, 'section_id' => 2, 'category_name' => 'Casual T-Shirts', 'category_image' => '', 'category_discount' => 0,
                'description' => '', 'url' => 'casul-t-shirts', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '', 'status' => 1
            ]
        ];
        Category::insert($categoryRecords);
    }
}
