@extends('layouts.app.app')

@section('title', __('copyright.h1'))

@section('css')
    @vite('resources/css/impression.css')
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')
                <div class="main__center main__desk">
                    <div class="impression-content">
                        <h1 class="impression-content__title title">
                            <span class="impression-content__title-text">{{ __('copyright.h1') }}</span>
                        </h1>
                        <div class="impression-content__outer outer">
                            <div class="impression-content__inner inner">
                                <h2 class="inner__subtitle"> {{ __('copyright.1') }}</h2>
                                <span class="inner__desclaimer">
                                    {{ __('copyright.2') }}
                                </span>
                                <span class="inner__preamble"> {{ __('copyright.3') }}</span>

                                <dl class="inner__descr-list descr-list">
                                    <dt class="descr-list__theme">
                                        {{ __('copyright.4') }}
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        {{ __('copyright.5') }}
                                    </dd>

                                    <dt class="descr-list__theme">
                                        {{ __('copyright.6') }}
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        {{ __('copyright.7') }} <br />
                                        Reg.Nr 40008127911
                                    </dd>

                                    <dt class="descr-list__theme">
                                        {{ __('copyright.8') }}
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        {{ __('copyright.9') }}
                                    </dd>

                                    <dt class="descr-list__theme">
                                        {{ __('copyright.10') }}
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        {{ __('copyright.11') }} <br />
                                        Latvija, Daugavpils, Cietokšņa 68-51, LV-5401
                                    </dd>

                                    <dt class="descr-list__theme">
                                        {{ __('copyright.12') }}
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        <i><a
                                                href="https://private-new-education.de">private-new-education.com</a></i>
												<br />
                                        {{ __('copyright.13') }}<i><a
                                                href="mailto:info@private-new-education.de">info@private-new-education.de</a></i>
												<br />
                                        {{ __('copyright.14') }}<a href="tel:+4915221942007">(+4915221942007)</a><br />
                                    </dd>

                                </dl>
                                <div class="inner__text text">
                                    <p class="text__pharagraph">
                                        {!! __('copyright.15') !!}
                                    </p>
                                    <p class="text__pharagraph">
                                        {!! __('copyright.16') !!}
                                    </p>
                                    <p class="text__pharagraph">
                                        {!! __('copyright.17') !!}
                                    </p>
                                    <p class="text__pharagraph">
                                        {!! __('copyright.18') !!}
                                    </p>
                                    <p class="text__pharagraph">
                                        {!! __('copyright.19') !!}
                                    </p>
                                    <p class="text__pharagraph">
                                        {!! __('copyright.20') !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.app.sidebar')
            </div>
        </div>
    </main>
@endsection
