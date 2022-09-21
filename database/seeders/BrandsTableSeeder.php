<?php

namespace Database\Seeders;

use App\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['id'=>1,'name'=>'arrow','status'=>1],
            ['id'=>2,'name'=>'Easy','status'=>1],
            ['id'=>3,'name'=>'Yowllo','status'=>1],
            ['id'=>4,'name'=>'Lee','status'=>1],
            ['id'=>5,'name'=>'Peter','status'=>1],
        ];

        Brand::insert($brands);
    }
}
