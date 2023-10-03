<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Fit;

class FitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fitsRecords =[
            ['id' => 1, 'name' => 'Regular', 'status' => 1],
            ['id' => 2, 'name' => 'Slim', 'status' => 1],
        ];
        Fit::insert($fitsRecords);
    }
}
