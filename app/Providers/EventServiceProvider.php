<?php

namespace App\Providers;

use App\Events\PresentationViewCreated;
use App\Events\SubscriptionCreated;
use App\Events\SubscriptionCreating;
use App\Events\TwoFactorRequested;
use App\Events\UserRegistered;
use App\Events\ViewCreated;
use App\Listeners\LogPresentationView;
use App\Listeners\LogSubscription;
use App\Listeners\LogView;
use App\Listeners\SendAuthorizationCode;
use App\Listeners\SendRegisterEmail;
use App\Listeners\SetEndsAtField;
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

        SubscriptionCreating::class => [
            SetEndsAtField::class,
        ],

        SubscriptionCreated::class => [
            SyncCreatingDateInUsersTable::class,
            LogSubscription::class,
        ],

        TwoFactorRequested::class => [
            SendAuthorizationCode::class,
        ],

        PresentationViewCreated::class => [
            LogPresentationView::class,
        ],

        ViewCreated::class => [
            LogView::class,
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
