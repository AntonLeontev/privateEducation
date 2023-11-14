<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Support\Enums\AdminRole;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'superuser',
            'email' => 'admin',
            'password' => bcrypt('12345678'),
            'role' => AdminRole::admin,
        ]);
    }
}
