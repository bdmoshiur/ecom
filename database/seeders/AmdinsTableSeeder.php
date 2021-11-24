<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AmdinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $adminsRecord = [
            [
                'id' =>1,
                'name' =>'admin',
                'type' =>'admin',
                'mobile' => '01749302454',
                'email' =>'admin@gmail.com',
                'password'=> Hash::make('admin@gmail.com'),
                'image'=>'',
                'status'=>1,
            ],
            [
                'id' =>2,
                'name' =>'subadmin',
                'type' =>'subadmin',
                'mobile' => '01749302454',
                'email' =>'subadmin@gmail.com',
                'password'=> Hash::make('subadmin@gmail.com'),
                'image'=>'',
                'status'=>1,
            ],
            [
                'id' =>3,
                'name' =>'multiadmin',
                'type' =>'multiadmin',
                'mobile' => '01749302454',
                'email' =>'multiadmin@gmail.com',
                'password'=> Hash::make('multiadmin@gmail.com'),
                'image'=>'',
                'status'=>1,
            ],
            [
                'id' =>4,
                'name' =>'fouradmin',
                'type' =>'fouradmin',
                'mobile' => '01749302454',
                'email' =>'fouradmin@gmail.com',
                'password'=> Hash::make('fouradmin@gmail.com'),
                'image'=>'',
                'status'=>1,
            ],
        ];

        DB::table('admins')->insert($adminsRecord);

        // foreach($adminsRecord as $key => $record){
        //     \App\Admin::create($record);
        // }

    }
}
