<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\NewsletterSubscriber;

class NewsletterSubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newslette_subscriber = [
            ['id' =>1, 'email'=> 'moshiurcse888@gmail.com', 'status'=>1],
            ['id' =>2, 'email'=> 'homefour100@gmail.com', 'status'=>1],
        ];

        NewsletterSubscriber::insert($newslette_subscriber);
    }
}
