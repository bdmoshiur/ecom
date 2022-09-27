<?php

namespace Database\Seeders;

use App\Banner;
use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id' => 1, 'image'=>'banner1.png', 'title' => 'Black Jacket', 'link' =>'', 'alt'=> 'Black Jacket', 'status' =>1],
            ['id' => 2, 'image'=>'banner2.png', 'title' => 'Red Jacket', 'link' =>'', 'alt'=> 'Red Jacket', 'status' =>1],
            ['id' => 3, 'image'=>'banner3.png', 'title' => 'Blue Jacket', 'link' =>'', 'alt'=> 'Blue Jacket', 'status' =>1],
        ];
        Banner::insert($bannerRecords);
    }
}
