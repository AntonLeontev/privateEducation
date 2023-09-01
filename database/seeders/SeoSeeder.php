<?php

namespace Database\Seeders;

use App\Models\Seo;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seo::create([
            'title' => 'Заголовок главной страницы',
            'h1' => 'Заголовок главной страницы',
            'description' => 'Описание главной страницы',
            'keywords' => 'Ключевые слова главной страницы',
        ]);
    }
}
