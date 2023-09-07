<?php

namespace Database\Seeders;

use App\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencyRecords = [
            ['id' => 1, 'currency_code' => 'USD', 'exchange_rate' => '110', 'status' => '1' ],
            ['id' => 2, 'currency_code' => 'EUR', 'exchange_rate' => '103', 'status' => '1'],
            ['id' => 3, 'currency_code' => 'AUD', 'exchange_rate' => '90', 'status' => '1' ],
            ['id' => 4, 'currency_code' => 'CAD', 'exchange_rate' => '80', 'status' => '1'],
        ];

        Currency::insert($currencyRecords);
    }
}
