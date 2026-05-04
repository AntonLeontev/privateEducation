<?php

namespace Database\Factories;

use App\Models\Fragment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fragment>
 */
class FragmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ru' => 'Фрагмент',
            'title_en' => 'Fragment',
        ];
    }
}
