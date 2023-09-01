<?php

namespace App\MoonShine\Resources;

use App\Models\Media;
use App\Support\Enums\MediaLang;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Enum;
use MoonShine\Fields\NoInput;
use MoonShine\Resources\Resource;

class MediaResource extends Resource
{
    public static string $model = Media::class;

    public static string $title = 'Медиа файлы';

    public static array $with = ['mediable'];

    public static string $orderType = 'ASC';

    public static array $activeActions = ['show', 'edit', 'delete'];

    public function fields(): array
    {
        return [
            NoInput::make('Фрагмент', '', fn ($item) => $item->mediable->id)
                ->sortable(),
            Enum::make('Lang', 'lang')->attach(MediaLang::class)
                ->sortable(),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return [];
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
