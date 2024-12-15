<?php

namespace App\Support\Traits;

use App\Models\Audio;
use App\Models\Presentation;
use App\Models\Video;

trait DeterminesModel
{
    public function getModel(string $content): ?string
    {
        return match ($content) {
            // 'video' => Video::class,
            // 'audio' => Audio::class,
            'video' => 'video',
            'audio' => 'audio',
            'presentation' => Presentation::class,
            default => null,
        };
    }
}
