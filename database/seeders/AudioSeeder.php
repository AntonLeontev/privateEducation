<?php

namespace Database\Seeders;

use App\Models\Audio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 17) as $val) {
			Audio::create([
				'title_ru' => 'Аудио ' . $val,
				'title_en' => 'Audio ' . $val,
				'price_ru' => fake()->numberBetween(100, 1000),
				'price_en' => fake()->numberBetween(1, 20),
				'currency_ru' => 1,
				'currency_en' => 2,
				'fragment_id' => $val,
			]);
		}
    }
}
