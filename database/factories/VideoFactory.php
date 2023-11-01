<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->numberBetween(5, 15);

        return [
            'price' => $price,
            'price_rub' => $price * 100,
            'price_usd' => $price * 1.06,
            'fragment_id' => fake()->numberBetween(1, 17),
        ];
    }
}
