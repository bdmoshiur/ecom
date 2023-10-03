<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Pattern;

class PatternsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patternsRecords =[
            ['id' => 1, 'name' => 'Checked', 'status' => 1],
            ['id' => 2, 'name' => 'Plain', 'status' => 1],
            ['id' => 3, 'name' => 'Printed', 'status' => 1],
            ['id' => 4, 'name' => 'Self', 'status' => 1],
            ['id' => 5, 'name' => 'Solid', 'status' => 1],
        ];
        Pattern::insert($patternsRecords);
    }
}
