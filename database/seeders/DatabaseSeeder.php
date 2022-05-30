<?php


use Illuminate\Database\Seeder;
use Database\Seeders\AmdinsTableSeeder;
use Database\Seeders\SectionsTableSeeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\ProductsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // // $this->call(UsersTableSeeder::class);
        //  $this->call(AmdinsTableSeeder::class);
        //  $this->call(SectionsTableSeeder::class);
        //  $this->call(CategoryTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
    }
}
