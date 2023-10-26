<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);

        Artisan::call('db:seed', ['--class' => 'FragmentSeeder']);
        Artisan::call('db:seed', ['--class' => 'AudioSeeder']);
        Artisan::call('db:seed', ['--class' => 'VideoSeeder']);
        Artisan::call('db:seed', ['--class' => 'PresentationSeeder']);
        Artisan::call('db:seed', ['--class' => 'MediaSeeder']);
        Artisan::call('db:seed', ['--class' => 'SubscriptionSeeder']);

        Artisan::call('db:seed', ['--class' => 'SeoSeeder']);
    }
}
