<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Occasion;


class OccasionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occasionsRecords =[
            ['id' => 1, 'name' => 'Casual', 'status' => 1],
            ['id' => 2, 'name' => 'Formal', 'status' => 1],
        ];
        Occasion::insert($occasionsRecords);
    }
}
