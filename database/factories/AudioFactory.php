<?php

namespace Database\Factories;

use App\Models\Audio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Audio>
 */
class AudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price' => fake()->numberBetween(1, 8),
            'fragment_id' => fake()->numberBetween(1, 17),
        ];
    }
}
