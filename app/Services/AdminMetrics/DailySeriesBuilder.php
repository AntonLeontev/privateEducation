<?php

namespace App\Services\AdminMetrics;

use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Log;

class DailySeriesBuilder
{
    /**
     * Build a continuous daily series, filling missing days with zeros.
     *
     * @param  array<string, array{sum?: int|float, ru?: int|float, en?: int|float}>  $byDate
     * @return list<array{date: string, sum: int|float, ru: int|float, en: int|float}>
     */
    public function build(array $byDate, CarbonInterface $start, CarbonInterface $end): array
    {
        foreach (array_keys($byDate) as $key) {
            if (! is_string($key) || $key === '' || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
                Log::warning('[DailySeriesBuilder.build] unexpected day key', ['date' => $key]);
            }
        }

        $series = [];
        $cursor = $start->copy()->startOfDay();
        $last = $end->copy()->startOfDay();

        while ($cursor->lte($last)) {
            $key = $cursor->format('Y-m-d');
            $point = $byDate[$key] ?? null;

            if ($point !== null && ! is_array($point)) {
                Log::warning('[DailySeriesBuilder.build] unexpected day value', ['date' => $key]);
                $point = null;
            }

            $series[] = [
                'date' => $key,
                'sum' => $point['sum'] ?? 0,
                'ru' => $point['ru'] ?? 0,
                'en' => $point['en'] ?? 0,
            ];

            $cursor->addDay();
        }

        return $series;
    }
}
