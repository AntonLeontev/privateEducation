<?php

namespace App\MoonShine\Resources;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\ID;
use MoonShine\Resources\Resource;

class SubscriptionResource extends Resource
{
    public static string $model = Subscription::class;

    public static string $title = 'Subscriptions';

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
        ];
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
