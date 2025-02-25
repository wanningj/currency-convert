<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清空資料
        Currency::truncate();

        Currency::create([
            'base_currency' => 'USD',
            'convert_currency' => 'USD',
            'rate' => 1.0000
        ]);

        Currency::create([
            'base_currency' => 'USD',
            'convert_currency' => 'TWD',
            'rate' => 31.5000
        ]);

        Currency::create([
            'base_currency' => 'USD',
            'convert_currency' => 'JPY',
            'rate' => 148.5000
        ]);

        Currency::create([
            'base_currency' => 'TWD',
            'convert_currency' => 'USD',
            'rate' => 0.0317
        ]);

        Currency::create([
            'base_currency' => 'TWD',
            'convert_currency' => 'TWD',
            'rate' => 1.0000
        ]);

        Currency::create([
            'base_currency' => 'TWD',
            'convert_currency' => 'JPY',
            'rate' => 4.7143
        ]);

        Currency::create([
            'base_currency' => 'JPY',
            'convert_currency' => 'USD',
            'rate' => 0.00673
        ]);

        Currency::create([
            'base_currency' => 'JPY',
            'convert_currency' => 'TWD',
            'rate' => 0.2121
        ]);

        Currency::create([
            'base_currency' => 'JPY',
            'convert_currency' => 'JPY',
            'rate' => 1.0000
        ]);
    }
}
