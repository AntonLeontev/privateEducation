<?php

namespace App\MoonShine\Resources;

use App\Models\Fragment;
use App\Support\Enums\MediaLang;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\ID;
use MoonShine\Fields\NoInput;
use MoonShine\Resources\Resource;

class VideoReportResource extends Resource
{
    public static string $model = Fragment::class;

    public static string $title = 'Продажи видео по фрагментам';

    public static string $orderType = 'ASC'; // Тип сортировки по умолчанию

    public static array $with = ['video'];

    public static array $activeActions = [];

    public function fields(): array
    {
        return [
            ID::make('№', 'id'),

            NoInput::make(
                'RU сегодня',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::ru)
                    ->where('created_at', '>', now()->startOfDay())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'RU неделя',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::ru)
                    ->where('created_at', '>', now()->startOfWeek())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'RU месяц',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::ru)
                    ->where('created_at', '>', now()->startOfMonth())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'RU квартал',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::ru)
                    ->where('created_at', '>', now()->startOfQuarter())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'RU год',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::ru)
                    ->where('created_at', '>', now()->startOfYear())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'US сегодня',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::en)
                    ->where('created_at', '>', now()->startOfDay())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'US неделя',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::en)
                    ->where('created_at', '>', now()->startOfWeek())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'US месяц',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::en)
                    ->where('created_at', '>', now()->startOfMonth())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'US квартал',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::en)
                    ->where('created_at', '>', now()->startOfQuarter())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
            NoInput::make(
                'US год',
                '',
                fn ($item) => ($item->video
                    ->load('subscriptions')
                    ->subscriptions
                    ->where('lang', MediaLang::en)
                    ->where('created_at', '>', now()->startOfYear())
                    ->sum('price.amount') / 100).' €'
            )->sortable(),
        ];
    }

    public function tdStyles(Model $item, int $index, int $cell): string
    {
        if ($cell > 1 && $cell < 7) {
            return 'background: rgba(128, 253, 163, .3); text-align:center;';
        }

        if ($cell >= 7 && $cell < 12) {
            return 'background: rgba(200, 112, 215, .3); text-align:center;';
        }

        return parent::tdStyles($item, $index, $cell);
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
