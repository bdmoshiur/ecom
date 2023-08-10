<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\CmsPage;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsPagesRecords = [
            ['id' => 1, 'title' => 'About Us', 'description' => 'Content is coming soon ', 'url' => 'about-us' , 'meta_title' => 'About Us' , 'meta_description' => 'About E-commerce Website' , 'meta_keywords' => 'About us, about Ecommerce' , 'status' => 1 ],
            ['id' => 2, 'title' => 'Privacy policy', 'description' => 'Content is coming soon ', 'url' => 'privacy-policy' , 'meta_title' => 'Privacy policy' , 'meta_description' => 'About Privacy policy of E-commerce Website' , 'meta_keywords' => 'Privacy policy' , 'status' => 1 ],
        ];

        CmsPage::insert($cmsPagesRecords);

    }
}
