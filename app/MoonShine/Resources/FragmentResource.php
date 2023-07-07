<?php

namespace App\MoonShine\Resources;

use App\Models\Fragment;
use App\MoonShine\Resources\AudioResource;

use App\MoonShine\Resources\PresentationResource;
use App\MoonShine\Resources\VideoResource;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Flex;
use MoonShine\Decorations\Grid;
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

	public static array $activeActions = ['show', 'edit', 'delete'];

	protected bool $editInModal = false;

	public function fields(): array
	{
		return [
			ID::make()->sortable(),
			Tabs::make([
				Tab::make('Основное', [
					Text::make('Заголовок', 'title_ru'),
					Text::make('Title', 'title_en'),
				]),
				Tab::make('Презентация', [
					HasOne::make('Презентация', 'presentation', new PresentationResource)				
					->fields([
						Text::make('Заголовок', 'title_ru'),
						TinyMce::make('Текст', 'text_ru')
							->hideOnIndex(),
						Text::make('Title', 'title_en'),
						TinyMce::make('Текст', 'text_en')
							->hideOnIndex(),
					])
					->fullPage()
					->hideOnIndex(),
				]),
				Tab::make('Аудио', [
					HasOne::make('Аудио', 'audio', new AudioResource)				
					->hideOnIndex()
					->fields([
						Text::make('Заголовок', 'title_ru'),
						Number::make('Цена', 'price_ru', fn($item) => $item->price_ru->amount())
							->expansion($this->getItem()?->audio->currencyRu->sign ?? ''),
						Select::make('Валюта ', 'currency_ru')
							->options([
								'1' => 'Рубль РФ',
								'2' => 'Доллар США'
							]),
						
						Text::make('Title', 'title_en'),
						Number::make('Цена', 'price_en', fn($item) => $item->price_en->amount())
							->expansion($this->getItem()?->audio->currencyEn->sign ?? ''),
						Select::make('Валюта ', 'currency_en')
							->options([
								'1' => 'Рубль РФ',
								'2' => 'Доллар США'
							]),
					])
					->fullPage(),
				]),
				Tab::make('Видео', [
					HasOne::make('Видео', 'video', new VideoResource)				
					->hideOnIndex()
					->fields([
						Text::make('Заголовок', 'title_ru'),
						Number::make('Цена', 'price_ru')
							->hideOnForm(),
						Number::make('Цена', 'price_ru', fn($item) => $item->price_ru->amount())
							->hideOnIndex(),
						Select::make('Валюта ', 'currency_ru')
							->options([
								'1' => 'Рубль РФ',
								'2' => 'Доллар США'
							])
							->hideOnIndex(),
					])
					->fullPage(),
				]),
			]),
			

			NoInput::make('Цена аудио', '', function($item) {
				return $item->audio->price_ru . ' | ' . $item->audio->price_en;
			})->hideOnForm(),
			NoInput::make('Цена видео', '', function($item) {
				return $item->video->price_ru . ' | ' . $item->video->price_en;
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
