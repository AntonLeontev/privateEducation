<?php

namespace Database\Factories;

use App\Models\Audio;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\View>
 */
class ViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $model = $this->faker->randomElement([
            Video::class,
            Audio::class,
        ]);

        return [
            'user_id' => User::inRandomOrder()->first(['id'])->id,
            'viewable_id' => $this->faker->numberBetween(1, 17),
            'viewable_type' => $model,
            'lang' => $this->faker->randomElement(['ru', 'en']),
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
        ];
    }
}
