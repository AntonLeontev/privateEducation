<?php

namespace Database\Seeders;

use App\Models\Presentation;
use Illuminate\Database\Seeder;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 17) as $val) {
            Presentation::create([
                'title_ru' => 'Презентация '.$val,
                'title_en' => 'Presentation '.$val,
                'text_ru' => 'Текст в презентации '.$val,
                'text_en' => 'Text in presentation '.$val,
                'fragment_id' => $val,
            ]);
        }
    }
}
