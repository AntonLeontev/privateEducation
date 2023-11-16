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
            'amount' => $this->faker->numberBetween(1, 250),
            'currency' => $this->faker->randomElement(['$', 'руб']),
            'status' => $this->faker->randomElement(['init', 'success', 'declined', 'canceled']),
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
        ];
    }
}
