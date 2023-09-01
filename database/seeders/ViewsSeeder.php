<?php

namespace Database\Seeders;

use Database\Factories\ViewFactory;
use Illuminate\Database\Seeder;

class ViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ViewFactory::new()->count(1000)->create();
    }
}
