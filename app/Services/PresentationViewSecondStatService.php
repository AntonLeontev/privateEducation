<?php

namespace App\Services;

use App\Models\Presentation;
use App\Models\PresentationViewSecondStat;
use App\Models\Visit;
use Throwable;

class PresentationViewSecondStatService
{
    private const DEBUG_BUCKET_SAMPLE = 5;

    public function __construct(private readonly PlaytimeParser $playtimeParser) {}

    /**
     * @param  array<int, array{s: int, c: int}>  $buckets
     */
    public function mergeBuckets(Visit $visit, int $presentationId, bool $isPassive, array $buckets): void
    {
        $presentation = Presentation::query()->find($presentationId);

        if (! $presentation) {
            return;
        }

        $durationSeconds = $this->playtimeParser->durationForPresentation($presentation);

        $trimmedCount = 0;
        $sampleLogged = 0;

        foreach ($buckets as $bucket) {
            $secondIndex = (int) ($bucket['s'] ?? -1);
            $hitCount = (int) ($bucket['c'] ?? 0);

            if ($hitCount < 1) {
                continue;
            }

            if ($durationSeconds > 0 && $secondIndex >= $durationSeconds) {
                $trimmedCount++;

                continue;
            }

            if ($sampleLogged < self::DEBUG_BUCKET_SAMPLE) {
                $sampleLogged++;
            }

            try {
                $existing = PresentationViewSecondStat::query()
                    ->where('visit_id', '=', $visit->id, 'and')
                    ->where('presentation_id', '=', $presentationId, 'and')
                    ->where('second_index', '=', $secondIndex, 'and')
                    ->where('is_passive', '=', $isPassive, 'and')
                    ->first();

                if ($existing) {
                    $existing->increment('hit_count', $hitCount);
                } else {
                    PresentationViewSecondStat::create([
                        'visit_id' => $visit->id,
                        'presentation_id' => $presentationId,
                        'second_index' => $secondIndex,
                        'is_passive' => $isPassive,
                        'hit_count' => $hitCount,
                    ]);
                }
            } catch (Throwable $exception) {
                throw $exception;
            }
        }

    }
}
