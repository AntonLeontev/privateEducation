<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seo;

use MoonShine\Resources\Resource;
use MoonShine\Fields\Text;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Textarea;

class SeoResource extends Resource
{
	public static string $model = Seo::class;

	public static string $title = 'SEO';

	public static array $activeActions = ['edit'];

	public function fields(): array
	{
		return [
		    Text::make('Title'),
		    Text::make('H1'),
		    Textarea::make('Description'),
		    Textarea::make('Keywords'),
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
