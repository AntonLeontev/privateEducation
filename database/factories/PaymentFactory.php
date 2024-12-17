<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'external_id' => (string) Str::uuid(),
            'fragment_id' => $this->faker->numberBetween(1, 17),
            'media_type' => $this->faker->randomElement(['video', 'audio']),
            'amount' => $this->faker->numberBetween(100, 25000),
            'currency' => $this->faker->randomElement(['usd', 'eur', 'rub']),
            'status' => $this->faker->randomElement(['init', 'success', 'declined', 'canceled']),
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
        ];
    }
}
