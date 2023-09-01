<?php

namespace App\MoonShine\Resources;

use App\Models\Presentation;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\ID;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\Resource;

class PresentationResource extends Resource
{
    public static string $model = Presentation::class;

    public static string $title = 'Презентации';

    public static string $orderType = 'ASC';

    public static array $activeActions = ['edit'];

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Grid::make([
                Column::make([
                    Block::make([
                        Heading::make('Русский'),
                        // Text::make('Заголовок', 'title_ru'),
                        TinyMce::make('Текст', 'text_ru')
                            ->hideOnIndex(),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        Heading::make('Английский'),
                        // Text::make('Title', 'title_en'),
                        TinyMce::make('Текст', 'text_en')
                            ->hideOnIndex(),
                    ]),
                ])->columnSpan(6),
            ]),
            Grid::make([
                Column::make([
                    Block::make([
                        NoInput::make('', '', fn (Presentation $presentation) => view('admin.media-video', ['media' => $presentation->load('media')->media])->render()
                        )->hideOnIndex(),
                    ]),
                ])->columnSpan(6),
                Column::make([
                    Block::make([
                        NoInput::make('', '', fn (Presentation $presentation) => view('admin.media-video', ['media' => $presentation->load('media')->media])->render()
                        )->hideOnIndex(),
                    ]),
                ])->columnSpan(6),
            ]),

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
