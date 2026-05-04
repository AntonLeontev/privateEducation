@extends('layouts.app.app')

@section('title', __('about.title'))
@section('description', __('about.description'))

@section('css')
    @vite(['resources/css/about.css'])
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

								<div class="content">
									<p class="text highlight" >{{ __('about.22') }}</p>
									<p class="text highlight">{{ __('about.23') }}</p>
									@php
										$highlights = [39];
										$paddingBottom = [32];
									@endphp

									@foreach (range(24, 44) as $i)
										@if ($i === 70 && app()->getLocale() === 'ru')
											@continue
										@endif


										<p @class([
											'text', 
											'highlight' => in_array($i, $highlights),
											'pb' => in_array($i, $paddingBottom),
										])>{!! __('about.'.$i) !!}</p>
									@endforeach

                                    <p class="text">{!! __('about.45') !!}</p>
                                    <ol class="!mt-0 text ms-4 md:ms-12 list-disc">
                                        <li class="">{{ __('about.46') }}</li>
                                        <li class="">{{ __('about.47') }}</li>
                                        <li class="">{{ __('about.48') }}</li>
                                        <li class="">{{ __('about.49') }}</li>
                                        <li class="">{{ __('about.50') }}</li>
                                        <li class="">{{ __('about.51') }}</li>
                                        <li class="">{{ __('about.52') }}</li>
                                    </ol>

                                    <p class="text">{!! __('about.53') !!}</p>
                                    <ul class="!mt-0 text ms-4 md:ms-12">
                                        <li class="list-disc">{{ __('about.54') }}</li>
                                        <li class="list-disc">{{ __('about.55') }}</li>
                                        <li class="list-disc">{{ __('about.56') }}</li>
                                        <li class="list-disc">{{ __('about.57') }}</li>
                                        <li class="list-disc">{{ __('about.58') }}</li>
                                        <li class="list-disc">{{ __('about.59') }}</li>
                                    </ul>

                                    <p class="text">{!! __('about.60') !!}</p>
                                    <ol class="!mt-0 text ms-4 md:ms-12 list-disc">
                                        <li class="">{{ __('about.61') }}</li>
                                        <li class="">{{ __('about.62') }}</li>
                                        <li class="">{{ __('about.63') }}</li>
                                        <li class="">{{ __('about.64') }}</li>
                                        <li class="">{{ __('about.65') }}</li>
                                        <li class="">{{ __('about.66') }}</li>
                                        <li class="">{{ __('about.67') }}</li>
                                    </ol>
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
