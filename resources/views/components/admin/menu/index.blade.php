<nav class="header__nav">
    <ul class="header__list__nav">

		<x-admin.menu.item title="Продажи">
			<x-admin.menu.subitem stats="sails" page="sum" title="Суммарные продажи">
				<img class="block" width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="w-[250px]">
					Суммарные продажи
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="sails" page="audio" title="Продажи аудио">
				<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
				<div>
					Продажи аудио
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="sails" page="video" title="Продажи видео">
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Продажи видео
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="metrics-sails" page="sum" title="Суммарный график продаж">
				<img width="25px" src="{{ Vite::asset('resources/images/icon5.png') }}" alt="">
				<div>
					Суммарный график продаж
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="metrics-sails" page="audio" title="График продаж аудио">
				<img width="25px" src="{{ Vite::asset('resources/images/icon5.png') }}" alt="">
				<div>
					График продаж аудио
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="metrics-sails" page="video" title="График продаж видео">
				<img width="25px" src="{{ Vite::asset('resources/images/icon5.png') }}" alt="">
				<div>
					График продаж видео
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="geo" page="sum" title="Геолокация продаж">
				<img width="25px" src="{{ Vite::asset('resources/images/icon5.png') }}" alt="">
				<div>
					Геолокация продаж
				</div>
			</x-admin.menu.subitem>
		</x-admin.menu.item>

		<x-admin.menu.item title="Просмотры в личном кабинете">
			<x-admin.menu.subitem stats="views" page="sum" title="Суммарные просмотры и прослушивания">
				<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="w-[450px] 2xl:w-[500px]">
					Суммарные просмотры и прослушивания
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="views" page="audio" title="Прослушивания аудио">
				<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
				<div>
					Прослушивания аудио
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="views" page="video" title="Просмотры видео">
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Просмотры видео
				</div>
			</x-admin.menu.subitem>
			<x-admin.menu.subitem stats="views" page="metrics" title="Графики просмотров и прослушиваний">
				<img width="25px" src="{{ Vite::asset('resources/images/icon5.png') }}" alt="">
				<div>
					Графики просмотров и прослушиваний
				</div>
			</x-admin.menu.subitem>
		</x-admin.menu.item>

        <li class="flex items-center header__nav__list-item gap-x-1" @click="$dispatch('all-stats', 'all-audio')">
            <img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
            <span>Только аудио</span>
        </li>
    </ul>
</nav>
