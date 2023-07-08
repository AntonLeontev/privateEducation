<?php

namespace App\Providers;

use App\Models\Presentation;
use App\MoonShine\Resources\AudioReportResource;
use App\MoonShine\Resources\AudioResource;
use App\MoonShine\Resources\FragmentResource;
use App\MoonShine\Resources\MediaResource;
use App\MoonShine\Resources\PresentationResource;
use App\MoonShine\Resources\SeoResource;
use App\MoonShine\Resources\VideoReportResource;
use App\MoonShine\Resources\VideoResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Decorations\Divider;
use MoonShine\Menu\MenuDivider;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\MoonShine;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            // MenuGroup::make('moonshine::ui.resource.system', [
            //     MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
            //         ->translatable()
            //         ->icon('users'),
            //     MenuItem::make('moonshine::ui.resource.role_title', new MoonShineUserRoleResource())
            //         ->translatable()
            //         ->icon('bookmark'),
            // ])->translatable(),

            MenuItem::make('Сводный отчет', '/admin')->icon('heroicons.chart-pie'),
			MenuItem::make('Продажи аудио', new AudioReportResource())->icon('heroicons.musical-note'),
			MenuItem::make('Продажи видео', new VideoReportResource())->icon('heroicons.film'),
			

			MenuItem::make('Презентации', new PresentationResource())->canSee(fn() => false),
			MenuItem::make('Аудио', new AudioResource())->canSee(fn() => false),
			MenuItem::make('Видео', new VideoResource())->canSee(fn() => false),
            // MenuItem::make('Файлы', new MediaResource()),
			
			MenuDivider::make(),

			MenuItem::make('Фрагменты', new FragmentResource())
				->icon('heroicons.squares-2x2'),

			MenuDivider::make(),

			MenuItem::make('SEO', new SeoResource())->icon('heroicons.presentation-chart-line'), 

			MenuDivider::make(),

			MenuItem::make('На сайт', '/')->icon('heroicons.globe-alt'),
        ]);
    }
}
