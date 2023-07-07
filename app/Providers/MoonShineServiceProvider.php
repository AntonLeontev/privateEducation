<?php

namespace App\Providers;

use App\Models\Presentation;
use App\MoonShine\Resources\AudioReportResource;
use App\MoonShine\Resources\AudioResource;
use App\MoonShine\Resources\FragmentResource;
use App\MoonShine\Resources\MediaResource;
use App\MoonShine\Resources\PresentationResource;
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
            MenuGroup::make('moonshine::ui.resource.system', [
                MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
                    ->translatable()
                    ->icon('users'),
                MenuItem::make('moonshine::ui.resource.role_title', new MoonShineUserRoleResource())
                    ->translatable()
                    ->icon('bookmark'),
            ])->translatable(),

            MenuItem::make('Фрагменты', new FragmentResource()),
            MenuItem::make('Презентации', new PresentationResource()),
            MenuItem::make('Аудио', new AudioResource()),
            MenuItem::make('Видео', new VideoResource()),
            MenuItem::make('Файлы', new MediaResource()),
			
			MenuDivider::make(),

			MenuGroup::make('Отчеты', [
				MenuItem::make('Сводный отчет', '/admin'),
				MenuItem::make('Продажи аудио', new AudioReportResource()),
				MenuItem::make('Продажи видео', new VideoReportResource()),
			]),
			

			MenuDivider::make(),

			MenuItem::make('На сайт', '/'),
        ]);
    }
}
