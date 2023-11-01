<?php

namespace Database\Seeders;

use Database\Factories\AudioFactory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sequense = [];

        foreach (range(1, 17) as $value) {
            $sequense[] = ['fragment_id' => $value];
        }

        foreach (range(1, 17) as $value) {
            AudioFactory::new()
                ->count(17)
                ->state(new Sequence(...$sequense))
                ->create();
        }
    }
}
