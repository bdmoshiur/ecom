<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Media;


class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mediaRecords =[
            ['id' => 1, 'name' => 'facebook', 'link' =>'www.facebook.com', 'image' => '', 'status' => 1],
            ['id' => 2, 'name' => 'youtube', 'link' =>'www.youtube.com', 'image' => '', 'status' => 1],
            ['id' => 3, 'name' => 'linkedin', 'link' =>'www.linkedin.com', 'image' => '', 'status' => 1],
            ['id' => 4, 'name' => 'twitter', 'link' =>'www.twitter.com', 'image' => '', 'status' => 1],

        ];
        Media::insert($mediaRecords);
    }
}
