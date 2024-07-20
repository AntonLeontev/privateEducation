@extends('layouts.app.app')

@section('title', __('about.h1'))

@section('css')
    <link rel="stylesheet" href="/css/about.css" />
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')

                <div class="main__center main__desk">
                    <div class="about-content">
                        <h1 class="about-content__title title">
                            <span class="about-content__title-text"> {{ __('about.h1') }} </span>
                        </h1>
                        <div class="about-content__outer outer">
                            <div class="about-content__inner inner">
                                <h2 class="inner__subtitle"> {{ __('about.1') }} </h2>
                                <span class="inner__desclaimer">
                                    {{ __('about.2') }}
                                </span>
                                <span class="inner__preamble"> {{ __('about.3') }} </span>
                                <span class="inner__descr">
                                    {{ __('about.4') }}
                                </span>

                                <ul class="inner__list">
                                    <li class="inner__item">
                                        {{ __('about.5') }}
                                    </li>
                                    <li class="inner__item">
                                        {{ __('about.6') }}
                                    </li>
                                    <li class="inner__item">
                                        {{ __('about.7') }}
                                    </li>
                                    <li class="inner__item">
                                        {{ __('about.8') }}
                                    </li>
                                    <li class="inner__item">
                                        {{ __('about.9') }}
                                    </li>
                                    <li class="inner__item">
                                        {{ __('about.10') }}
                                    </li>
                                    <li class="inner__item additional">
                                        {{ __('about.11') }}
                                        <ul class="additional__list">
                                            <li class="additional__item">{{ __('about.12') }}</li>
                                            <li class="additional__item">
                                                {{ __('about.13') }}
                                            </li>
                                            <li class="additional__item">
                                                {{ __('about.14') }}
                                            </li>
                                            <li class="additional__item">
                                                {{ __('about.15') }}
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="inner__target-list target-list">
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            {{ __('about.16') }}
                                        </p>
                                    </li>
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            {{ __('about.17') }}
                                        </p>
                                    </li>
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            {{ __('about.18') }}
                                        </p>
                                        <p class="target-list__descr">
                                            {{ __('about.19') }}
                                            <i>
                                                <a href="https://www.private-new-education.com" rel="nofollow">{{ __('about.20') }}
                                                </a></i>
                                        </p>
                                    </li>
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            {{ __('about.21') }}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.app.sidebar')
            </div>
        </div>
    </main>
    <script src="/js/app.bundle.js"></script>

@endsection
