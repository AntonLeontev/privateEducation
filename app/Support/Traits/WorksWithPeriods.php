<?php

namespace App\Support\Traits;

use Illuminate\Support\Carbon;

trait WorksWithPeriods
{
    public function getPeriodDates(): array
    {
        return match (request()->period) {
            'today' => [now(), now()],
            'yesterday' => [now()->subDay(), now()->subDay()],
            'week' => [now()->startOfWeek(), now()->endOfWeek()],
            'month' => [now()->startOfMonth(), now()->endOfMonth()],
            'quarter' => [now()->startOfQuarter(), now()->endOfQuarter()],
            'year' => [now()->startOfYear(), now()->endOfYear()],
            'custom' => [Carbon::parse(request()->get('start')), Carbon::parse(request()->get('end'))],
            default => [null, null],
        };
    }
}
