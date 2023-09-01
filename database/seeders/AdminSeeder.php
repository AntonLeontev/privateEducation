<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MoonShine\Models\MoonshineUser;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MoonshineUser::create([
            'moonshine_user_role_id' => 1,
            'email' => 'admin',
            'password' => bcrypt('12345678'),
            'name' => 'Администратор',
        ]);
    }
}
