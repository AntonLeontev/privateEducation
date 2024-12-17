<ul class="right-menu h-[100vh] !bg-[#7e90a5] pt-1 z-50 overflow-y-auto" 
:class="!active && 'hidden'"
x-cloak
@menu-toggle.window="open"
@click.outside="close"
x-data="{
	active: false,
	opened: false,

	close() {
		if (!this.opened) {
			return;
		}

		this.active = false
		this.opened = false
	},
	open() {
		this.active = true

		this.$nextTick(() => {
			this.opened = true
		})
	},
}">

	@if (admin()->user()->isAdmin())
		@if (Route::has('admin.fragments'))
			<li class="transition duration-300 right-menu__item border border-x-0 @if (Route::is('admin.fragments')) !bg-[#50657c] @endif">
				<a class="right-menu__link" href="{{ route('admin.fragments') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text @if (Route::is('admin.fragments')) !text-primary @endif">Фрагменты</span>
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
						<span class="right-menu-link__text @if (Route::is('admin.files')) !text-primary @endif">Контент</span>
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

		@if (Route::has('admin.prices'))
			<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.deactivation')) !bg-[#50657c] @endif">
				<a class="right-menu__link" href="{{ route('admin.deactivation') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text @if (Route::is('admin.deactivation')) !text-primary @endif">Просмотр и деактивация фрагментов</span>
					</span>
				</a>
			</li>
		@endif

		@if (Route::has('admin.actions.page'))
			<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.actions.page')) !bg-[#50657c] @endif">
				<a class="right-menu__link" href="{{ route('admin.actions.page') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text @if (Route::is('admin.actions.page')) !text-primary @endif">Журнал действий</span>
					</span>
				</a>
			</li>
		@endif

		@if (Route::has('admin.payments.page'))
			<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.payments.page')) !bg-[#50657c] @endif">
				<a class="right-menu__link" href="{{ route('admin.payments.page') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text @if (Route::is('admin.payments.page')) !text-primary @endif">Транзакции</span>
					</span>
				</a>
			</li>
		@endif

		{{-- @if (Route::has('admin.admins'))
			<li class="transition duration-300 right-menu__item border border-t-0 border-x-0 @if (Route::is('admin.admins')) !bg-[#50657c] @endif">
				<a class="right-menu__link" href="{{ route('admin.admins') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text @if (Route::is('admin.admins')) !text-primary @endif">Администраторы</span>
					</span>
				</a>
			</li>
		@endif --}}
	@endif

	{{-- @if (admin()->user()->isAdmin() || admin()->user()->isSeo())
		@if (Route::has('admin.seo.index'))
			<li class="transition duration-300 border border-t-0 right-menu__item border-x-0 @if (Route::is('admin.seo.index')) !bg-[#50657c] @endif">
				<a class="right-menu__link" href="{{ route('admin.seo.index') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text">SEO</span>
					</span>
				</a>
			</li>
		@endif
	@endif --}}

	@if (Route::has('home'))
		<li class="transition duration-300 border border-t-0 right-menu__item border-x-0">
			<a class="right-menu__link" href="{{ route('home') }}" target="_blank">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">На сайт</span>
				</span>
			</a>
		</li>
	@endif

	@if (Route::has('admin.logout'))
		<li class="transition duration-300 border border-t-0 right-menu__item border-x-0">
			<form action="{{ route('admin.logout') }}" method="post">
				@csrf
				<button class="right-menu__link" href="{{ route('admin.logout') }}">
					<span class="right-menu-link__wrapper">
						<span class="right-menu-link__text">Выйти</span>
					</span>
				</button>
			</form>
		</li>
	@endif
</ul>
