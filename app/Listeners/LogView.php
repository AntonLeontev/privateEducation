<?php

namespace App\Listeners;

use App\Events\ViewCreated;
use App\Models\ActionLog;
use App\Support\Enums\ActionLogType;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogView implements ShouldQueue
{
    public function handle(ViewCreated $event): void
    {
        if ($event->view->viewable_type === 'audio') {
            $action = 'Прослушивание аудио фрагмента №'.$event->view->viewable_id;
            $type = ActionLogType::listen;
        } else {
            $action = 'Просмотр видео фрагмента №'.$event->view->viewable_id;
            $type = ActionLogType::viewVideo;
        }

        ActionLog::create([
            'user_id' => $event->view->user_id,
            'action' => $action,
            'type' => $type,
            'created_at' => $event->view->created_at,
        ]);
    }
}
