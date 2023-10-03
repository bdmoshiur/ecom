<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Fabric;


class FabricsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fabricsRecords =[
            ['id' => 1, 'name' => 'Coton', 'status' => 1],
            ['id' => 2, 'name' => 'Polyester', 'status' => 1],
            ['id' => 3, 'name' => 'Wool', 'status' => 1],
            ['id' => 4, 'name' => 'Pure Cotton', 'status' => 1],
        ];
        Fabric::insert($fabricsRecords);
    }
}
