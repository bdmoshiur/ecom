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
        $brandsRecords =[
            ['id' => 1, 'name' => 'arrow', 'status' => 1],
            ['id' => 2, 'name' => 'lee', 'status' => 1],
            ['id' => 3, 'name' => 'easy', 'status' => 1],
            ['id' => 4, 'name' => 'gap', 'status' => 1],
        ];
        Brand::insert($brandsRecords);
    }
}
