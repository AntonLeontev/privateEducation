<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Support\Enums\AdminRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создаёт администратора, запрашивая email и пароль';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->ask('Email');
        $password = $this->secret('Пароль');

        $validator = Validator::make(
            [
                'email' => $email,
                'password' => $password,
            ],
            [
                'email' => ['required', 'string', 'max:50', 'unique:admins,email'],
                'password' => ['required', 'string', 'min:8', 'max:50'],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        Admin::create([
            'email' => $email,
            'password' => bcrypt($password),
            'role' => AdminRole::admin,
        ]);

        $this->info("Администратор {$email} создан.");

        return self::SUCCESS;
    }
}
