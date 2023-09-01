<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 17) as $val) {
            Video::create([
                'title_ru' => 'Аудио '.$val,
                'title_en' => 'Audio '.$val,
                'price' => fake()->numberBetween(4, 10),
                'currency_id' => 3,
                'fragment_id' => $val,
            ]);
        }
    }
}
