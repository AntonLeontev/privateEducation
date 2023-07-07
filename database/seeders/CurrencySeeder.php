<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::create(['alpha_code' => 'RUB', 'numeric_code' => '643', 'sign' => '₽']);
        Currency::create(['alpha_code' => 'USD', 'numeric_code' => '840', 'sign' => '$']);
        Currency::create(['alpha_code' => 'EUR', 'numeric_code' => '978', 'sign' => '€']);
    }
}
