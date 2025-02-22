<?php

namespace Database\Seeders;

use Database\Factories\VideoFactory;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 17) as $value) {
            VideoFactory::new()
                ->create([
                    'fragment_id' => $value,
                ]);
        }
    }
}
