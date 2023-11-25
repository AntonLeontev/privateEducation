<?php

namespace App\Listeners;

use App\Events\PresentationViewCreated;
use App\Models\ActionLog;
use App\Support\Enums\ActionLogType;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogPresentationView implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PresentationViewCreated $event): void
    {
        if ($event->presentationView->is_reading) {
            $action = 'Чтение презентации фрагмента №';
            $type = ActionLogType::reading;
        } elseif ($event->presentationView->is_passive) {
            $action = 'Пассивный просмотр видео презентации фрагмента №';
            $type = ActionLogType::passiveView;
        } else {
            $action = 'Просмотр видео презентации фрагмента №';
            $type = ActionLogType::viewPresentation;
        }

        $action .= $event->presentationView->presentation_id;

        ActionLog::create([
            'user_id' => $event->presentationView->user_id,
            'action' => $action,
            'type' => $type,
            'created_at' => $event->presentationView->created_at,
        ]);
    }
}
