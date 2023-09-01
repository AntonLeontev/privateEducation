<?php

namespace App\MoonShine;

use App\Models\Subscription;
use App\Support\Enums\MediaLang;
use Carbon\Carbon;
use MoonShine\Dashboard\DashboardBlock;
use MoonShine\Dashboard\DashboardScreen;
use MoonShine\Dashboard\TextBlock;
use MoonShine\Metrics\DonutChartMetric;
use MoonShine\Metrics\LineChartMetric;
use MoonShine\Metrics\ValueMetric;

class Dashboard extends DashboardScreen
{
    public function blocks(): array
    {
        return [
            DashboardBlock::make([
                TextBlock::make(
                    'Динамика продаж за последние 30 дней',
                    ''
                ),
            ]),

            DashboardBlock::make([
                LineChartMetric::make('Сумма продаж')
                    ->line([
                        'Сумма продаж РФ' => Subscription::query()
                            ->selectRaw('SUM(price / 100) as sum, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                            ->where('lang', MediaLang::ru)
                            ->where('created_at', '>', now()->subMonth()->startOfDay())
                            ->groupBy('date')
                            ->pluck('sum', 'date')
                            ->sortBy(function ($sum, $date) {
                                return Carbon::parse($date);
                            })
                            ->toArray(),
                    ], '#ff0000')
                    ->line([
                        'Сумма продаж US' => Subscription::query()
                            ->selectRaw('SUM(price / 100) as sum, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                            ->where('lang', MediaLang::en)
                            ->where('created_at', '>', now()->subMonth()->startOfDay())
                            ->groupBy('date')
                            ->pluck('sum', 'date')
                            ->sortBy(function ($sum, $date) {
                                return Carbon::parse($date);
                            })
                            ->toArray(),
                    ], '#0000ff')
                    ->columnSpan(6),

                LineChartMetric::make('Количество продаж')
                    ->line([
                        'Количество продаж РФ' => Subscription::query()
                            ->selectRaw('COUNT(price) as count, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                            ->where('lang', MediaLang::ru)
                            ->where('created_at', '>', now()->subMonth()->startOfDay())
                            ->groupBy('date')
                            ->pluck('count', 'date')
                            ->sortBy(function ($sum, $date) {
                                return Carbon::parse($date);
                            })
                            ->toArray(),
                    ], '#ff0000')
                    ->line([
                        'Количество продаж US' => Subscription::query()
                            ->selectRaw('COUNT(price) as count, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                            ->where('lang', MediaLang::en)
                            ->where('created_at', '>', now()->subMonth()->startOfDay())
                            ->groupBy('date')
                            ->pluck('count', 'date')
                            ->sortBy(function ($sum, $date) {
                                return Carbon::parse($date);
                            })
                            ->toArray(),
                    ], '#0000ff')
                    ->columnSpan(6),
            ]),

            DashboardBlock::make([
                TextBlock::make(
                    'Продажи РФ',
                    ''
                ),
            ]),
            DashboardBlock::make([
                ValueMetric::make('Сегодня')
                    ->value(Subscription::query()
                        ->where('created_at', '>=', now()->startOfDay())
                        ->where('lang', MediaLang::ru)
                        ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(8)
                    ->columnSpan(2),
                ValueMetric::make('Неделя. C '.now()->startOfWeek()->translatedFormat('j F'))
                    ->value(Subscription::query()
                        ->where('created_at', '>=', now()->startOfWeek())
                        ->where('lang', MediaLang::ru)
                        ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(20)
                    ->columnSpan(2),
                ValueMetric::make('Месяц. C '.now()->startOfMonth()->translatedFormat('j F'))
                    ->value(Subscription::query()
                        ->where('created_at', '>=', now()->startOfMonth())
                        ->where('lang', MediaLang::ru)
                        ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(100)
                    ->columnSpan(2),
                ValueMetric::make('Квартал. C '.now()->startOfQuarter()->translatedFormat('j F'))
                    ->value(Subscription::query()
                        ->where('created_at', '>=', now()->startOfQuarter())
                        ->where('lang', MediaLang::ru)
                        ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(250)
                    ->columnSpan(3),
                ValueMetric::make('Год. C '.now()->startOfYear()->translatedFormat('j F'))
                    ->value(Subscription::query()
                        ->where('created_at', '>=', now()->startOfYear())
                        ->where('lang', MediaLang::ru)
                        ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(1000)
                    ->columnSpan(3),
            ]),

            DashboardBlock::make([
                TextBlock::make(
                    'Продажи US',
                    ''
                ),
            ]),

            DashboardBlock::make([
                ValueMetric::make('Сегодня')
                    ->value(Subscription::query()
                        ->where('created_at', '>=', now()->startOfDay())
                        ->where('lang', MediaLang::en)
                        ->sum('price') / 100
                    )
                    ->valueFormat('{value} €')
                    ->progress(10)
                    ->columnSpan(2),
                ValueMetric::make('Неделя. C '.now()->startOfWeek()->translatedFormat('j F'))
                    ->value(Subscription::query()
                    ->where('created_at', '>=', now()->startOfWeek())
                    ->where('lang', MediaLang::en)
                    ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(20)
                    ->columnSpan(2),
                ValueMetric::make('Месяц. C '.now()->startOfMonth()->translatedFormat('j F'))
                    ->value(Subscription::query()
                    ->where('created_at', '>=', now()->startOfMonth())
                    ->where('lang', MediaLang::en)
                    ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(80)
                    ->columnSpan(2),
                ValueMetric::make('Квартал. C '.now()->startOfQuarter()->translatedFormat('j F'))
                    ->value(Subscription::query()
                    ->where('created_at', '>=', now()->startOfQuarter())
                    ->where('lang', MediaLang::en)
                    ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(250)
                    ->columnSpan(3),
                ValueMetric::make('Год. C '.now()->startOfYear()->translatedFormat('j F'))
                    ->value(Subscription::query()
                    ->where('created_at', '>=', now()->startOfYear())
                    ->where('lang', MediaLang::en)
                    ->sum('price') / 100)
                    ->valueFormat('{value} €')
                    ->progress(1000)
                    ->columnSpan(3),
            ]),

            DashboardBlock::make([
                TextBlock::make(
                    'География продаж за год',
                    ''
                ),
            ]),

            DashboardBlock::make([
                DonutChartMetric::make('Сумма покупок RU')
                    ->values(
                        Subscription::query()
                            ->selectRaw('SUM(price / 100) as sum, location')
                            ->where('lang', MediaLang::ru)
                            ->where('created_at', '>=', now()->subYear())
                            ->groupBy('location')
                            ->pluck('sum', 'location')
                            ->map(fn ($item) => $item = (int) $item)
                            ->toArray()
                    )->columnSpan(6),
                DonutChartMetric::make('Количество покупок RU')
                    ->values(
                        Subscription::query()
                            ->selectRaw('COUNT(price) as count, location')
                            ->where('lang', MediaLang::ru)
                            ->where('created_at', '>=', now()->subYear())
                            ->groupBy('location')
                            ->pluck('count', 'location')
                            ->toArray()
                    )->columnSpan(6),
            ]),
            DashboardBlock::make([
                    DonutChartMetric::make('Сумма покупок US')
                        ->values(
                            Subscription::query()
                                ->selectRaw('SUM(price / 100) as sum, location')
                                ->where('lang', MediaLang::en)
                                ->where('created_at', '>=', now()->subYear())
                                ->groupBy('location')
                                ->pluck('sum', 'location')
                                ->map(fn ($item) => $item = (int) $item)
                                ->toArray()
                        )->columnSpan(6),
                    DonutChartMetric::make('Количество покупок US')
                        ->values(
                            Subscription::query()
                                ->selectRaw('COUNT(price) as count, location')
                                ->where('lang', MediaLang::en)
                                ->where('created_at', '>=', now()->subYear())
                                ->groupBy('location')
                                ->pluck('count', 'location')
                                ->toArray()
                        )->columnSpan(6),
            ]),
        ];
    }
}
