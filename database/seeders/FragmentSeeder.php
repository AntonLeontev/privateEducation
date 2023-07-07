<?php

namespace Database\Seeders;

use App\Models\Fragment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FragmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		foreach (range(1, 17) as $value) {
			Fragment::create([
				'title_ru' => 'Фрагмент ' . $value,
				'title_en' => 'Fragment ' . $value,
			]);
		}
    }
}
