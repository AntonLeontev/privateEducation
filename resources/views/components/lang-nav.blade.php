@php
    $supportedLocales = LaravelLocalization::getSupportedLocales();
    $currentLocale = app()->getLocale();
@endphp

<div class="lang-nav" role="navigation" x-data="{ open: false }" @click.outside="open = false">
    <button class="lang-nav__current" :class="open && 'lang-nav__current_active'" @click="open = !open">
        <img src="{{ Vite::asset('resources/images/flags/' . $supportedLocales[$currentLocale]['flag'] . '.svg') }}"
            width="32" height="32" alt="">
        <span class="lang-nav__name">
            {{ $supportedLocales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>
    <div class="accordion-animation lang-nav__list-animation" :class="{ 'accordion-animation_active': open }">
        <div class="accordion-wrapper">
            <ul class="lang-nav__list">
                @foreach ($supportedLocales as $localeCode => $properties)
                    @if ($localeCode !== $currentLocale)
                        <li class="lang-nav__item">
                            <a class="lang-nav__link" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{ Vite::asset('resources/images/flags/' . $properties['flag'] . '.svg') }}"
                                    alt="" width="32" height="32">
                                <span class="lang-nav__name">{{ $properties['native'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
