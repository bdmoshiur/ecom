<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Seeder;
use App\Delivery_address;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords =[
           [
            'id' => 1,
            'user_id'=> 1,
            'name' => 'moshiur rahan',
            'address' =>'test 123',
            'city' =>'dhaka',
            'state' => 'faridpur',
            'country' => 'bangladesh',
            'pincode' => '123456',
            'mobile' => '01749302454',
            'status' => 1
            ],
            [
                'id' => 2,
                'user_id'=> 1,
                'name' => 'afnan adib',
                'address' =>'test abc',
                'city' =>'dhaka',
                'state' => 'faridpur',
                'country' => 'bangladesh',
                'pincode' => '123457',
                'mobile' => '01745940304',
                'status' => 1,
            ]
        ];

        Delivery_address::insert($deliveryRecords);
    }
}
