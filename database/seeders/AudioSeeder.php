<?php

namespace Database\Seeders;

use Database\Factories\AudioFactory;
use Illuminate\Database\Seeder;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 17) as $value) {
            AudioFactory::new()
                ->create([
                    'fragment_id' => $value,
                ]);
        }
    }
}
