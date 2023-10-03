<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\CodPincode;

class CodpincodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CodpincodeRecords =[
            ['id' => 1, 'pincode' => '515631', 'status' => 1],
            ['id' => 2, 'pincode' => '515581', 'status' => 1],
            ['id' => 3, 'pincode' => '515581', 'status' => 1],
            ['id' => 4, 'pincode' => '515581', 'status' => 1],
            ['id' => 5, 'pincode' => '515581', 'status' => 1],
            ['id' => 6, 'pincode' => '515571', 'status' => 1],
            ['id' => 7, 'pincode' => '515631', 'status' => 1],
            ['id' => 8, 'pincode' => '515631', 'status' => 1],
            ['id' => 9, 'pincode' => '515581', 'status' => 1],
            ['id' => 10, 'pincode' => '515581', 'status' => 1],
            ['id' => 11, 'pincode' => '515581', 'status' => 1],
            ['id' => 12, 'pincode' => '515581', 'status' => 1],
            ['id' => 13, 'pincode' => '515571', 'status' => 1],
            ['id' => 14, 'pincode' => '515571', 'status' => 1],
        ];
        CodPincode::insert($CodpincodeRecords);
    }
}
