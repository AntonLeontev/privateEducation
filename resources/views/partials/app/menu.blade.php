<ul 
	class="right-menu no-style" 
	x-show="menuModal" 
	@click.outside="menuModal = false"
	x-transition
	x-cloak 
>
    <li class="right-menu__item right-menu__item--btn">
        <button class="right-menu__close-btn" @click="menuModal = false"><img src="/img/right-menu-close.png" alt="close-button"></button>
    </li>
	@if (Route::has('home'))
		<li class="right-menu__item">
			<a class="right-menu__link" href="{{ route('home') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">{{ __('header.menu.home') }}</span>
				</span>
			</a>
		</li>
	@endif
	@if (Route::has('about'))
		<li class="right-menu__item">
			<a class="right-menu__link" href="{{ route('about') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">{{ __('header.menu.about') }}</span>
				</span>
			</a>
		</li>
	@endif
	@if (Route::has('commercial'))
		<li class="right-menu__item">
			<a class="right-menu__link" href="{{ route('commercial') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">{{ __('header.menu.commercial') }}</span>
				</span>
			</a>
		</li>
	@endif
	@if (Route::has('copyright'))
		<li class="right-menu__item">
			<a class="right-menu__link" href="{{ route('copyright') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">{{ __('header.menu.copyright') }}</span>
				</span>
			</a>
		</li>
	@endif
	@if (Route::has('privacy'))
		<li class="right-menu__item">
			<a class="right-menu__link" href="{{ route('privacy') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">{{ __('header.menu.privacy') }}</span>
				</span>
			</a>
		</li>
	@endif
	@if (Route::has('contacts'))
		<li class="right-menu__item">
			<a class="right-menu__link" href="{{ route('contacts') }}">
				<span class="right-menu-link__wrapper">
					<span class="right-menu-link__text">{{ __('header.menu.contacts') }}</span>
				</span>
			</a>
		</li>
	@endif

</ul>
