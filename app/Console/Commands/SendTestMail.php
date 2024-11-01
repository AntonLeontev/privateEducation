<?php

namespace App\Console\Commands;

use App\Mail\Test;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Mail::to('aner-anton@yandex.ru')->send(new Test());
        Mail::to('aner.anton@gmail.com')->send(new Test());
    }
}
