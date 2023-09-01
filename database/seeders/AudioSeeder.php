<?php

namespace Database\Seeders;

use App\Models\Audio;
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
                'title_ru' => 'Аудио '.$val,
                'title_en' => 'Audio '.$val,
                'price' => fake()->numberBetween(5, 10),
                'currency_id' => 3,
                'fragment_id' => $val,
            ]);
        }
    }
}
