<header>
    <nav>
        <ul>
            <li>
                <x-lang-nav />
            </li>
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
						<span title="{{ auth()->user()->email }}">{{ auth()->user()->email }}</span>
					</a>
				@else
					<a href="{{ route('personal') }}" class="lk" 
						x-data="{
							text: '{{ __('header.personal') }}',
						}"
						@login.window="text = $event.detail.email"
					>
						<img src="/img/user.png" alt="user">
						<span x-text="text" :title="text"></span>
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
