<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DbRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshing database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('migrate:fresh');

        Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        Artisan::call('db:seed', ['--class' => 'CurrencySeeder']);

        Artisan::call('db:seed', ['--class' => 'FragmentSeeder']);
        Artisan::call('db:seed', ['--class' => 'AudioSeeder']);
        Artisan::call('db:seed', ['--class' => 'VideoSeeder']);
        Artisan::call('db:seed', ['--class' => 'PresentationSeeder']);
        Artisan::call('db:seed', ['--class' => 'MediaSeeder']);
        Artisan::call('db:seed', ['--class' => 'SubscriptionSeeder']);
        Artisan::call('db:seed', ['--class' => 'ViewsSeeder']);
        Artisan::call('db:seed', ['--class' => 'PresentationViewSeeder']);

        Artisan::call('db:seed', ['--class' => 'SeoSeeder']);

        $this->info('ok');
    }
}
