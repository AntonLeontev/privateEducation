<?php

namespace App\MoonShine\Resources;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Decorations\Heading;
use MoonShine\Fields\ID;
use MoonShine\Fields\Number;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;

class VideoResource extends Resource
{
	public static string $model = Video::class;

	public static string $title = 'Видео';

	public static array $with = ['currency',];

	public static string $orderType = 'ASC';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
			Grid::make([
				Column::make([
					Block::make([
						Heading::make('Русский'),
						Text::make('Заголовок', 'title_ru'),
						Number::make('Цена', 'price')
							->hideOnForm(),
						Number::make('Цена', 'price', fn($item) => $item->price->amount())
							->hideOnIndex(),
						Select::make('Валюта ', 'currency')
							->options([
								'1' => 'Рубль РФ',
								'2' => 'Доллар США'
							])
							->hideOnIndex(),
					]),
					])->columnSpan(6),
				Column::make([
					Block::make([
						Heading::make('Английский'),
						Text::make('Title', 'title_en'),
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
