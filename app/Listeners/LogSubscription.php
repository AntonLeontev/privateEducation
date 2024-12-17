<?php

namespace App\Listeners;

use App\Events\SubscriptionCreated;
use App\Models\ActionLog;
use App\Support\Enums\ActionLogType;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogSubscription implements ShouldQueue
{
    public function handle(SubscriptionCreated $event): void
    {
        $action = $event->subscription->subscribable_type === 'audio'
            ? 'Оформлена подписка на аудио фрагмента №'
            : 'Оформлена подписка на видео фрагмента №';

        ActionLog::create([
            'user_id' => $event->subscription->user_id,
            'action' => $action.$event->subscription->subscribable_id,
            'type' => ActionLogType::subscribtion,
            'created_at' => $event->subscription->created_at,
        ]);
    }
}
