<nav class="header__nav">
    <ul class="header__list__nav">

		<x-admin.menu.item title="Продажи">
			<x-admin.menu.subitem>
				<img class="block" width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="w-[250px]">
					Суммарные продажи
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
				<div>
					Аудио
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Видео
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Графики продаж
				</div>
			</x-admin.menu.subitem>
		</x-admin.menu.item>

		<x-admin.menu.item title="Просмотры в личном кабинете">
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="w-[420px]">
					Суммарные просмотры и прослушивания
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
				<div>
					Прослушивания аудио
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Просмотры видео
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem>
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Графики просмотров
				</div>
			</x-admin.menu.subitem>
		</x-admin.menu.item>

        <li class="flex items-center header__nav__list-item gap-x-1" @click="$dispatch('all-stats', 'all-audio')">
            <img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
            <span>Только аудио</span>
        </li>
    </ul>
</nav>
