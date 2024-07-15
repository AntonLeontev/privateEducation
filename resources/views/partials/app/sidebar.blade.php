<div id="menu" class="drawer drawer__close">
    <div class="drawer__top">
        <button class="close">
            <img src="/img/close.png" alt="close" />
        </button>
    </div>
    <button class="drawer__element">
        <span><a href="{{ route('home') }}">{{ __('header.menu.home') }}</a></span>
    </button>
    <button class="drawer__element">
        <span><a href="{{ route('about') }}">{{ __('header.menu.about') }}</a></span>
    </button>
    <button class="drawer__element">
        <span><a href="{{ route('copyright') }}">{{ __('header.menu.copyright_side') }}</a></span>
    </button>
    <button class="drawer__element">
        <span>
            <a href="{{ route('commercial') }}">{{ __('header.menu.commercial_side') }}</a>
		</span>
    </button>
    <button class="drawer__element">
        <span><a href="{{ route('privacy') }}">{{ __('header.menu.privacy_side') }}</a></span>
    </button>
    <button class="drawer__element">
        <span><a href="{{ route('contacts') }}">{{ __('header.menu.contacts') }}</a></span>
    </button>
    <div class="drawer__element"></div>
    <div class="drawer__element"></div>
    <div class="drawer__element"></div>
    <div class="drawer__element"></div>
</div>
