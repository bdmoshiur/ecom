<?php
namespace Database\Seeders;
use App\Section;
use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords = [
            ['id' => 1, 'name' => 'Men', 'status' => 1],
            ['id' => 2, 'name' => 'Women', 'status' => 1],
            ['id' => 3, 'name' => 'Kids', 'status' => 1],
            ['id' => 4, 'name' => 'Education', 'status' => 1],
            ['id' => 5, 'name' => 'Electronics', 'status' => 1],
            ['id' => 6, 'name' => 'Others', 'status' => 1],
        ];

        Section::insert($sectionRecords);
    }
}
