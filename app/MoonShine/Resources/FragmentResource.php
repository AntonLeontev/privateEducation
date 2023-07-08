<?php

namespace App\MoonShine\Resources;

use App\Models\Fragment;
use App\MoonShine\Resources\AudioResource;

use App\MoonShine\Resources\PresentationResource;
use App\MoonShine\Resources\VideoResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\HasOne;
use MoonShine\Fields\ID;
use MoonShine\Fields\NoInput;
use MoonShine\Fields\Number;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Fields\TinyMce;
use MoonShine\Resources\Resource;

class FragmentResource extends Resource
{
	public static string $model = Fragment::class;

	public static string $title = 'Фрагменты';

	public static string $orderType = 'ASC'; // Тип сортировки по умолчанию

	public static array $with = ['audio', 'video', 'presentation'];

	public static array $activeActions = ['edit'];

	protected bool $editInModal = false;

	public function fields(): array
	{
		return [
			ID::make()->sortable(),
			Flex::make([
				Text::make('Заголовок', 'title_ru'),
				Text::make('Title', 'title_en'),
			]),

			HasOne::make('Презентация', 'presentation', new PresentationResource)				
					// ->fields([
					// 	// Text::make('Заголовок', 'title_ru'),
					// 	TinyMce::make('Текст на русском', 'text_ru')
					// 		->hideOnIndex(),
					// 	// Text::make('Title', 'title_en'),
					// 	TinyMce::make('Текст на английском', 'text_en')
					// 		->hideOnIndex(),
					// ])
					->resourceMode()
					->hideOnIndex(),


					HasOne::make('Аудио', 'audio', new AudioResource)				
					->hideOnIndex()
					->fields([
						// Text::make('Заголовок', 'title_ru'),
						Number::make('Цена', 'price', fn($item) => $item->price->amount())
							->expansion($this->getItem()?->audio->currency->sign ?? ''),
						// Select::make('Валюта ', 'currency')
						// 	->options([
						// 		'1' => 'Рубль РФ',
						// 		'2' => 'Доллар США'
						// 	]),
						
						// Text::make('Title', 'title_en'),
						// Number::make('Цена', 'price', fn($item) => $item->price->amount())
							// ->expansion($this->getItem()?->audio->currency->sign ?? ''),
						// Select::make('Валюта ', 'currency')
						// 	->options([
						// 		'1' => 'Рубль РФ',
						// 		'2' => 'Доллар США'
						// 	]),
					])
					->resourceMode(),

					HasOne::make('Видео', 'video', new VideoResource)				
					->hideOnIndex()
					->fields([
						// Text::make('Заголовок', 'title_ru'),
						// Number::make('Цена', 'price')
						// 	->hideOnForm(),
						Number::make('Цена', 'price', fn($item) => $item->price->amount())
							->expansion($this->getItem()?->audio->currency->sign ?? ''),
						// Select::make('Валюта ', 'currency')
						// 	->options([
						// 		'1' => 'Рубль РФ',
						// 		'2' => 'Доллар США'
						// 	])
						// 	->hideOnIndex(),
					])
					->resourceMode(),



			NoInput::make('Цена аудио', '', function($item) {
				return $item->audio->price;
			})->hideOnForm(),
			NoInput::make('Цена видео', '', function($item) {
				return $item->video->price;
			})->hideOnForm(),

			


			
			
			
			
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
