<?php
namespace Database\Seeders;
<<<<<<< HEAD
=======

>>>>>>> 61183679f2b2a0026380ae560234fd821ab40917
use Illuminate\Database\Seeder;
use Database\Seeders\AmdinsTableSeeder;
use Database\Seeders\BrandsTableSeeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\SectionsTableSeeder;
use Database\Seeders\ProductsImagesTableSeeder;
use Database\Seeders\ProductsAttributesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //  $this->call(AmdinsTableSeeder::class);
        //  $this->call(SectionsTableSeeder::class);
        //  $this->call(CategoryTableSeeder::class);
        //  $this->call(ProductsTableSeeder::class);
        //  $this->call(ProductsAttributesTableSeeder::class);
<<<<<<< HEAD
=======
        //  $this->call(ProductsImagesTableSeeder::class);
>>>>>>> 61183679f2b2a0026380ae560234fd821ab40917
         $this->call(BrandsTableSeeder::class);
    }
}
