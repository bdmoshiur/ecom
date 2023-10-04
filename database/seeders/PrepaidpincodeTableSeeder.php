<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\PrepaidPincode;

class PrepaidpincodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prepaidpincodesRecords =[
            ['id' => 1, 'pincode' => '1234', 'status' => 1],
            ['id' => 2, 'pincode' => '5155814', 'status' => 1],
            ['id' => 3, 'pincode' => '5155816', 'status' => 1],
            ['id' => 4, 'pincode' => '5155841', 'status' => 1],
            ['id' => 5, 'pincode' => '5155831', 'status' => 1],
            ['id' => 6, 'pincode' => '5155271', 'status' => 1],
            ['id' => 7, 'pincode' => '5156371', 'status' => 1],
            ['id' => 8, 'pincode' => '5156131', 'status' => 1],
            ['id' => 9, 'pincode' => '5155381', 'status' => 1],
            ['id' => 10, 'pincode' => '51554381', 'status' => 1],
            ['id' => 11, 'pincode' => '51558331', 'status' => 1],
            ['id' => 12, 'pincode' => '515582321', 'status' => 1],
            ['id' => 13, 'pincode' => '5155712', 'status' => 1],
            ['id' => 14, 'pincode' => '5155712', 'status' => 1],
        ];
        PrepaidPincode::insert($prepaidpincodesRecords);
    }
}
