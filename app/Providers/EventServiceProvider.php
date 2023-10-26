<?php

namespace App\Providers;

use App\Events\SubscriptionCreated;
use App\Events\TwoFactorRequested;
use App\Events\UserRegistered;
use App\Listeners\SendAuthorizationCode;
use App\Listeners\SendRegisterEmail;
use App\Listeners\SyncCreatingDateInUsersTable;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendRegisterEmail::class,
        ],

        SubscriptionCreated::class => [
            SyncCreatingDateInUsersTable::class,
        ],

        TwoFactorRequested::class => [
            SendAuthorizationCode::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
