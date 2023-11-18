<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Database\Seeders\AmdinsTableSeeder;
use Database\Seeders\BrandsTableSeeder;
use Database\Seeders\CategoryTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\SectionsTableSeeder;
use Database\Seeders\ProductsImagesTableSeeder;
use Database\Seeders\ProductsAttributesTableSeeder;
use Database\Seeders\OrderStatusTableSeeder;
use Database\Seeders\CmsPagesTableSeeder;
use Database\Seeders\CurrencyTableSeeder;
use Database\Seeders\NewsletterSubscriberTableSeeder;
use Database\Seeders\RatingTableSeeder;
use Database\Seeders\WishlistsTableSeeder;
use Database\Seeders\ExchangeRequestTableSeeder;
use Database\Seeders\ReturnRequestTableSeeder;
use Database\Seeders\CodpincodeTableSeeder;
use Database\Seeders\PrepaidpincodeTableSeeder;
use Database\Seeders\MediaTableSeeder;


use Database\Seeders\FabricsTableSeeder;
use Database\Seeders\SleevesTableSeeder;
use Database\Seeders\FitsTableSeeder;
use Database\Seeders\PatternsTableSeeder;
use Database\Seeders\OccasionsTableSeeder;





class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AmdinsTableSeeder::class);
         $this->call(SectionsTableSeeder::class);
         $this->call(CategoryTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         $this->call(ProductsAttributesTableSeeder::class);
         $this->call(ProductsImagesTableSeeder::class);
         $this->call(BrandsTableSeeder::class);
         $this->call(BannerTableSeeder::class);
         $this->call(CouponTableSeeder::class);
         $this->call(DeliveryAddressTableSeeder::class);
         $this->call(OrderStatusTableSeeder::class);
         $this->call(CmsPagesTableSeeder::class);
         $this->call(CurrencyTableSeeder::class);
        $this->call(RatingTableSeeder::class);
        $this->call(WishlistsTableSeeder::class);
        $this->call(ReturnRequestTableSeeder::class);
        $this->call(ExchangeRequestTableSeeder::class);
        $this->call(NewsletterSubscriberTableSeeder::class);
        $this->call(FabricsTableSeeder::class);
        $this->call(SleevesTableSeeder::class);
        $this->call(FitsTableSeeder::class);
        $this->call(PatternsTableSeeder::class);
        $this->call(OccasionsTableSeeder::class);
        $this->call(CodpincodeTableSeeder::class);
        $this->call(PrepaidpincodeTableSeeder::class);
        $this->call(MediaTableSeeder::class);




    }
}
