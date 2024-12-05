@extends('layouts.app.app')

@section('title', __('privacy.h1'))

@section('css')
    @vite('resources/css/datenschutz.css')
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')
                <div class="main__center main__desk">
                    <div class="datenschutz-content">
                        <h1 class="datenschutz-content__title title">
                            <span class="datenschutz-content__title-text"> {{ __('privacy.h1') }} </span>
                        </h1>
                        <div class="datenschutz-content__outer outer">
                            <div class="datenschutz-content__inner inner">
                                <h2 class="inner__subtitle"> {!! __('privacy.1') !!} </h2>
                                <time class="inner__date" datetime="2021-03-25">
                                    {!! __('privacy.2') !!}
                                </time>
                                <section class="inner__section section">
                                    <h3 class="section__title">
                                        {!! __('privacy.3') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item">
                                            {!! __('privacy.4') !!}
                                            <b>{!! __('privacy.5') !!}</b> {!! __('privacy.6') !!}
                                            <br />
                                            <p class="section__item-extra-pharagraph">
                                                {!! __('privacy.7') !!}
                                            </p>
                                        </li>
                                    </ul>
                                </section>
                                <section class="inner__section section">
                                    <h3 class="section__title">
                                        {!! __('privacy.8') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item">
                                            {!! __('privacy.9') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.10') !!}
                                            <ul>
                                                <li>
                                                    {!! __('privacy.11') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.12') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.13') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.14') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.15') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.16') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.17') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.18') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.19') !!}
                                                </li>
                                                <li>
                                                    {!! __('privacy.20') !!}
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.21') !!}<br />
                                            <span class="section__dot-decor"></span>{!! __('privacy.22') !!}<br />
                                            <span class="section__dot-decor"></span>{!! __('privacy.23') !!}<br />
                                            <span class="section__dot-decor"></span>{!! __('privacy.24') !!}<br />
                                            <span class="section__dot-decor"></span>{!! __('privacy.25') !!}<br />
                                            <span class="section__dot-decor"></span>{!! __('privacy.26') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.27') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.28') !!} <i><a
                                                    href="https://private-new-education.com">www.private-new-education.com</a></i>,
                                            {!! __('privacy.29') !!} <i><a
                                                    href="https://private-new-education.com">www.private-new-education.com</a></i>
                                            {!! __('privacy.30') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.31') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.32') !!}<br />
                                            {!! __('privacy.33') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.34') !!}<br />
                                            {!! __('privacy.35') !!}<br />
                                            {!! __('privacy.36') !!}<br />
                                            {!! __('privacy.37') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.38') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.39') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.40') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.41') !!}<br />
                                            {!! __('privacy.42') !!}<br />
                                            {!! __('privacy.43') !!}<br />
                                            {!! __('privacy.44') !!}<br />
                                            {!! __('privacy.45') !!}<br />
                                            {!! __('privacy.46') !!}<br />
                                            {!! __('privacy.47') !!}<br />
                                            {!! __('privacy.48') !!}<br />
                                            {!! __('privacy.49') !!}<br />
                                            {!! __('privacy.50') !!}<br />
                                            {!! __('privacy.51') !!}<br />
                                            {!! __('privacy.52') !!}<br />
                                            {!! __('privacy.53') !!}<br />
                                            {!! __('privacy.54') !!}<br />
                                            {!! __('privacy.55') !!}<br />

                                        </li>
                                    </ul>
                                </section>
                                <section class="inner__section section">
                                    <h3 class="section__title">
                                        {!! __('privacy.56') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item">
											{!! __('privacy.57') !!}<br />
                                            {!! __('privacy.58') !!}<br />
                                            {!! __('privacy.59') !!}<br />
                                            {!! __('privacy.60') !!}<br />
                                            {!! __('privacy.61') !!}<br />
                                        </li>
                                    </ul>
                                </section>
                                <section class="inner__section section">
                                    <h3 class="section__title">
                                        {!! __('privacy.62') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item">
                                            {!! __('privacy.63') !!}
                                            <b>{!! __('privacy.64') !!}</b><br />
                                            {!! __('privacy.65') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.66') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.67') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.68') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.69') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.70') !!}
                                        </li>

                                    </ul>
                                </section>
                                <section class="inner__section section">
                                    <h3 class="section__title">
                                        {!! __('privacy.71') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item">
                                            {!! __('privacy.72') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.73') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.74') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.75') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.76') !!}
                                        </li>
										@if (loc() === 'ru')
											<li class="section__item">
												{!! __('privacy.77') !!}
											</li>
											<li class="section__item">
												{!! __('privacy.78') !!}
											</li>
										@endif
                                    </ul>
                                </section>
                                <section class="inner__section section">
                                    <h3 class="section__title">
                                        {!! __('privacy.79') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item">
                                            {!! __('privacy.80') !!}
                                        </li>
                                        <li class="section__item">
                                            {!! __('privacy.81') !!} <i><a
                                                    href="mailto:voldemar606060@gmail.com">voldemar606060@gmail.com</a></i>
                                        </li>
                                    </ul>
                                </section>

                                <section class="inner__section section--last">
                                    <h3 class="section__title">
                                        {!! __('privacy.82') !!}
                                    </h3>
                                    <ul class="section__list">
                                        <li class="section__item section__item--heavy">
                                            {!! __('privacy.83') !!}
                                        </li>
                                        <li class="section__item">
                                            <dl class="inner__descr-list descr-list">
                                                <dt class="descr-list__theme">
                                                    {!! __('privacy.84') !!}
                                                </dt>
                                                <dd class="descr-list__descrption">
                                                    {!! __('privacy.85') !!}
                                                </dd>

                                                <dt class="descr-list__theme">
                                                    {!! __('privacy.86') !!}
                                                </dt>
                                                <dd class="descr-list__descrption">
                                                    {!! __('privacy.87') !!} <br />
                                                    Reg.Nr 40008127911
                                                </dd>

                                                <dt class="descr-list__theme">
                                                    {!! __('privacy.88') !!}
                                                </dt>
                                                <dd class="descr-list__descrption">
                                                   {!! __('privacy.89') !!}
                                                </dd>

                                                <dt class="descr-list__theme">
                                                    {!! __('privacy.90') !!}
                                                </dt>
                                                <dd class="descr-list__descrption">
                                                    {!! __('privacy.91') !!} <br />
                                                    Latvija, Daugavpils, Cietokšņa 68-51, LV-5401
                                                </dd>

                                                <dt class="descr-list__theme">
                                                    {!! __('privacy.92') !!}
                                                </dt>
                                                <dd class="descr-list__descrption">
                                                    <i><a
                                                            href="https://private-new-education.com">private-new-education.com</a></i><br />
                                                    e-mail:<i><a
                                                            href="mailto:voldemar606060@gmail.com">voldemar606060@gmail.com</a></i><br />
                                                    {!! __('privacy.93') !!}<a href="tel:+4915221942007">(+4915221942007)</a><br />
                                                </dd>

                                            </dl>
                                        </li>

                                    </ul>
                                </section>
                                <!-- Должно быть кнопкой ? -->
                                <a href="#" class="inner__button">
                                    {!! __('privacy.94') !!}
                                </a>
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
