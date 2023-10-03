<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Sleeve;


class SleevesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sleevesRecords =[
            ['id' => 1, 'name' => 'Full Sleeve', 'status' => 1],
            ['id' => 2, 'name' => 'Half Sleeve', 'status' => 1],
            ['id' => 3, 'name' => 'Short Sleeve', 'status' => 1],
            ['id' => 4, 'name' => 'Sleeveless', 'status' => 1],
        ];
        Sleeve::insert($sleevesRecords);
    }
}
