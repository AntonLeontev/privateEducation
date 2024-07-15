<header>
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">{{ __('header.menu.home') }}</a></li>
            <li><a href="{{ route('about') }}">{{ __('header.menu.about') }}</a></li>
            <li><a href="{{ route('copyright') }}">{{ __('header.menu.copyright') }}</a></li>
            <li><a href="{{ route('commercial') }}">{{ __('header.menu.commercial') }}</a></li>
            <li><a href="{{ route('privacy') }}">{{ __('header.menu.privacy') }}</a></li>
            <li><a href="{{ route('contacts') }}">{{ __('header.menu.contacts') }}</a></li>
            <li>
				@auth
					<a href="{{ route('personal') }}" class="lk">
						<img src="/img/user.png" alt="user">
						<span>{{ auth()->user()->email }}</span>
					</a>
				@else
					<a href="{{ route('login') }}" class="lk" style="max-width: 245px">
						<img src="/img/user.png" alt="user">
						<span>{{ __('header.personal') }}</span>
					</a>
				@endauth
            </li>
            <li>
                <button class="menu">
                    <span>{{ __('header.menuBtn') }}</span>
                    <div class="menu__burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </li>
        </ul>
    </nav>
</header>
