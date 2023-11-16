<?php

namespace Database\Factories;

use App\Models\Presentation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PresentationView>
 */
class PresentationViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::all('id')->pluck('id');

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'presentation_id' => Presentation::inRandomOrder()->first()->id,
            'lang' => $this->faker->randomElement(['en', 'ru']),
            'is_reading' => $this->faker->boolean(25),
            'is_passive' => $this->faker->boolean(75),
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
        ];
    }
}
