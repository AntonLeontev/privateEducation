<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locale = $this->faker->randomElement(['en', 'ru']);

        $countries = [
            'en' => ['US', 'FR', 'IT', 'DE'],
            'ru' => ['RU', 'UA', 'KZ'],
        ];

        $countryCode = $this->faker->randomElement($countries[$locale]);

        if ($countryCode === 'RU') {
            $regionCode = $this->faker->randomElement(['RU-IRK', 'RU-LEN', 'RU-MOS']);
        }
        if ($countryCode === 'US') {
            $regionCode = $this->faker->randomElement(['US-CA', 'US-WA']);
        }

        $userIds = User::all('id')->pluck('id');

        $createdAt = $this->faker->dateTimeBetween('-6 months');
        $endsAt = clone $createdAt;

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'subscribable_id' => $this->faker->randomElement(range(1, 17)),
            'subscribable_type' => $this->faker->randomElement(['video', 'audio']),
            'lang' => $locale,
            'price' => $this->faker->numberBetween(300, 1000),
            'country_code' => $countryCode,
            'region_code' => $regionCode ?? null,
            'created_at' => $createdAt,
            'ends_at' => $endsAt,
        ];
    }
}
