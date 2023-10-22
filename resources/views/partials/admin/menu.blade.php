<ul class="right-menu hidden h-[100vh] !bg-[#7e90a5] pt-8 z-50">
    {{-- <button class="absolute right-menu__close-btn top-2 right-2">
		<img src="/img/right-menu-close.png" alt="close-button">
	</button> --}}

	@if (Route::has('admin.custom'))
		<li class="transition duration-300 right-menu__item border border-x-0 @if (Route::is('admin.custom')) !bg-[#50657c] @endif">
			<a class="right-menu__link" href="{{ route('admin.custom') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text @if (Route::is('admin.custom')) !text-primary @endif">Фрагменты</span>
				</span>
			</a>
		</li>
	@endif

	@if (Route::has('admin.users'))
		<li class="transition duration-300 border border-t-0 border-x-0 right-menu__item border-b-1 @if (Route::is('admin.users')) !bg-[#50657c] @endif">
			<a class="right-menu__link" href="{{ route('admin.users') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text @if (Route::is('admin.users')) !text-primary @endif">Пользователи</span>
				</span>
			</a>
		</li>
	@endif

	@if (Route::has('admin.users.subscriptions'))
		<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.users.subscriptions')) !bg-[#50657c] @endif">
			<a class="right-menu__link" href="{{ route('admin.users.subscriptions') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text @if (Route::is('admin.users.subscriptions')) !text-primary @endif">Управление подписками</span>
				</span>
			</a>
		</li>
	@endif

	@if (Route::has('admin.files'))
		<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.files')) !bg-[#50657c] @endif">
			<a class="right-menu__link" href="{{ route('admin.files') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text @if (Route::is('admin.files')) !text-primary @endif">Управление файлами</span>
				</span>
			</a>
		</li>
	@endif

	@if (Route::has('admin.prices'))
		<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.prices')) !bg-[#50657c] @endif">
			<a class="right-menu__link" href="{{ route('admin.prices') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text @if (Route::is('admin.prices')) !text-primary @endif">Цены</span>
				</span>
			</a>
		</li>
	@endif

	@if (Route::has('home'))
		<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('home')) !bg-[#50657c] @endif">
			<a class="right-menu__link" href="{{ route('home') }}" target="_blank">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text @if (Route::is('homes')) !text-primary @endif">На сайт</span>
				</span>
			</a>
		</li>
	@endif
</ul>
