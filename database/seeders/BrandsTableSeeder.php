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
<<<<<<< HEAD
        $brands = [
            ['id'=>1,'name'=>'arrow','status'=>1],
            ['id'=>2,'name'=>'Easy','status'=>1],
            ['id'=>3,'name'=>'Yowllo','status'=>1],
            ['id'=>4,'name'=>'Lee','status'=>1],
            ['id'=>5,'name'=>'Peter','status'=>1],
        ];

        Brand::insert($brands);
=======
        $brandsRecords =[
            ['id' => 1, 'name' => 'arrow', 'status' => 1],
            ['id' => 2, 'name' => 'lee', 'status' => 1],
            ['id' => 3, 'name' => 'easy', 'status' => 1],
            ['id' => 4, 'name' => 'gap', 'status' => 1],
        ];
        Brand::insert($brandsRecords);
>>>>>>> 61183679f2b2a0026380ae560234fd821ab40917
    }
}
