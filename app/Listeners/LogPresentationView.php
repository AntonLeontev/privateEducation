<?php

namespace App\Listeners;

use App\Events\PresentationViewCreated;
use App\Models\ActionLog;
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
        } else {
            $action = $event->presentationView->is_passive
                ? 'Пассивный просмотр видео презентации фрагмента №'
                : 'Просмотр видео презентации фрагмента №';
        }

        $action .= $event->presentationView->presentation_id;

        ActionLog::create([
            'user_id' => $event->presentationView->user_id,
            'action' => $action,
            'created_at' => $event->presentationView->created_at,
        ]);
    }
}
