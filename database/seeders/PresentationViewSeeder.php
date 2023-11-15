<?php

namespace Database\Seeders;

use Database\Factories\PresentationViewFactory;
use Illuminate\Database\Seeder;

class PresentationViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PresentationViewFactory::new()->count(590)->create();
    }
}
