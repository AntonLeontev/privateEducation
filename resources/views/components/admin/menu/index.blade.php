<nav class="header__nav">
    <ul class="header__list__nav">

		<x-admin.menu.item title="Продажи">
			<x-admin.menu.subitem stats="sails" page="sum" title="Суммарные продажи">
				<img class="block" width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="">
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
			<x-admin.menu.submenu title="Графики продаж" img="{{ Vite::asset('resources/images/icon5.png') }}">
				<x-admin.menu.subitem stats="metrics-sails" page="sum" title="Суммарный график продаж">
					<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
					<div>
						Суммарный график продаж
					</div>
				</x-admin.menu.subitem>
				<x-admin.menu.subitem stats="metrics-sails" page="audio" title="График продаж аудио">
					<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
					<div>
						График продаж аудио
					</div>
				</x-admin.menu.subitem>
				<x-admin.menu.subitem stats="metrics-sails" page="video" title="График продаж видео">
					<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
					<div>
						График продаж видео
					</div>
				</x-admin.menu.subitem>
			</x-admin.menu.submenu>
			<x-admin.menu.subitem stats="geo" page="sum" title="Геолокация продаж">
				<img width="25px" src="{{ Vite::asset('resources/images/icon6.png') }}" alt="">
				<div>
					Геолокация продаж
				</div>
			</x-admin.menu.subitem>
		</x-admin.menu.item>

		<x-admin.menu.item title="Просмотры в личном кабинете">
			<x-admin.menu.subitem stats="views" page="sum" title="Суммарные просмотры и прослушивания">
				<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="">
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

			<x-admin.menu.submenu title="Графики просмотров и прослушиваний" img="{{ Vite::asset('resources/images/icon5.png') }}">
				<x-admin.menu.subitem stats="metrics-views" page="sum" title="Суммарный график просмотров и прослушиваний">
					<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
					<div>
						Суммарный график просмотров и прослушиваний
					</div>
				</x-admin.menu.subitem>

				<x-admin.menu.subitem stats="metrics-views" page="audio" title="График прослушивания аудио">
					<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
					<div>
						График прослушивания аудио
					</div>
				</x-admin.menu.subitem>
				
				<x-admin.menu.subitem stats="metrics-views" page="video" title="График просмотров видео">
					<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
					<div>
						График просмотров видео
					</div>
				</x-admin.menu.subitem>
			</x-admin.menu.submenu>
		</x-admin.menu.item>

		<x-admin.menu.item title="Просмотры презентаций">
			<x-admin.menu.subitem stats="pres" page="sum" title="Суммарные просмотры и чтение презентаций">
				<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
				<div class="">
					Суммарные просмотры и чтение
				</div>
			</x-admin.menu.subitem>

			<x-admin.menu.subitem stats="pres" page="video" title="Суммарные просмотры презентаций">
				<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
				<div>
					Суммарные просмотры
				</div>
			</x-admin.menu.subitem>

			<x-admin.menu.subitem stats="pres" page="audio" title="Суммарное чтение презентаций">
				<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
				<div>
					Суммарное чтение
				</div>
			</x-admin.menu.subitem>

			<x-admin.menu.submenu title="Графики просмотров и чтения" img="{{ Vite::asset('resources/images/icon5.png') }}">
				<x-admin.menu.subitem stats="metrics-pres" page="sum" title="Суммарный график просмотров и чтения презентаций">
					<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
					<div>
						Суммарный график просмотров и чтения
					</div>
				</x-admin.menu.subitem>

				<x-admin.menu.subitem stats="metrics-pres" page="audio" title="График чтения презентаций">
					<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
					<div>
						График чтения презентаций
					</div>
				</x-admin.menu.subitem>

				<x-admin.menu.subitem stats="metrics-pres" page="video" title="График просмотров презентаций">
					<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
					<div>
						График просмотров презентаций
					</div>
				</x-admin.menu.subitem>
			</x-admin.menu.submenu>
		</x-admin.menu.item>

    </ul>
</nav>
