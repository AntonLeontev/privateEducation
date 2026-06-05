<?php

namespace App\Services;

use App\Models\Presentation;
use Illuminate\Support\Facades\Log;

class PlaytimeParser
{
    /**
     * Parse getID3 playtime string (e.g. "0:55", "3:42", "1:02:03") to total seconds.
     */
    public function parse(?string $raw): int
    {
        if ($raw === null || trim($raw) === '') {
            return 0;
        }

        $normalized = trim($raw);
        if (! preg_match('/^\d+(:\d{1,2}){0,2}$/', $normalized)) {
            Log::warning('[PlaytimeParser.parse] unrecognized format', ['raw' => $raw]);

            return 0;
        }

        $parts = array_map('intval', explode(':', $normalized));

        $seconds = match (count($parts)) {
            1 => $parts[0],
            2 => ($parts[0] * 60) + $parts[1],
            3 => ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2],
            default => 0,
        };

        if ($seconds === 0 && $normalized !== '0' && $normalized !== '0:00') {
            Log::warning('[PlaytimeParser.parse] unrecognized format', ['raw' => $raw]);
        }

        return max(0, $seconds);
    }

    /**
     * Resolve duration in seconds from presentation's first media playtime.
     */
    public function durationForPresentation(Presentation $presentation): int
    {
        $presentation->loadMissing('media');

        $playtime = $presentation->media->first()?->playtime;

        return $this->parse($playtime);
    }
}
