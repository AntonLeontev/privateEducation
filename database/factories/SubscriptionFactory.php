<?php

namespace Database\Factories;

use App\Models\Audio;
use App\Models\User;
use App\Models\Video;
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
            'en' => ['США', 'Канада', 'Мексика'],
            'ru' => ['Россия', 'Беларусь', 'Казахстан'],
        ];

        $location = $this->faker->randomElement($countries[$locale]);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'subscribable_id' => $this->faker->randomElement(range(1, 17)),
            'subscribable_type' => $this->faker->randomElement([Video::class, Audio::class]),
            'lang' => $locale,
            'price' => $this->faker->numberBetween(3, 10),
            'location' => $location,
            'created_at' => $this->faker->dateTimeBetween('-6 months'),
        ];
    }
}
