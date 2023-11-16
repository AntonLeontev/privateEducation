<?php

namespace App\Listeners;

use App\Events\ViewCreated;
use App\Models\ActionLog;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogView implements ShouldQueue
{
    public function handle(ViewCreated $event): void
    {
        $action = $event->view->viewable_type === 'App\Models\Audio'
            ? 'Прослушивание аудио фрагмента №'.$event->view->viewable_id
            : 'Просмотр видео фрагмента №'.$event->view->viewable_id;

        ActionLog::create([
            'user_id' => $event->view->user_id,
            'action' => $action,
            'created_at' => $event->view->created_at,
        ]);
    }
}
