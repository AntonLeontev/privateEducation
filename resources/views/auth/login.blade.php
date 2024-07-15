@extends('layouts.app.app')

@section('title', 'Вход')

@section('css')
    <link rel="stylesheet" href="/css/account.css" />
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')

                @include('partials.app.sidebar')

                <div id="dialog1" class="" style="visibility: visible">
                    <div class="dialog__top">
                        <h4>{{ __('login.title') }}</h4>
                        <a class="dialog__close" href="{{ route('home') }}">

                        </a>
                    </div>
                    <div class="dialog__center">
                        <!-- для авторизации -->
                        <div id="account-autorization" class="dialog__autorization autorization">
                            <h3 class="autorization__title">
                                {{ __('login.auth') }}
                            </h3>
                            <div class="autorization__button-box">
                                <button id="autorization-mode-btn-autorization"
                                    class="autorization__btn autorization__btn--autorization">
                                    <img src="/img/user.png" alt="user" class="autorization__img" />
                                    <span class="autorization__btn-text">{!! __('login.user') !!}</span></button>
                                <button id="autorization-mode-btn-registration"
                                    class="autorization__btn autorization__btn--registration">
                                    <img src="/img/user.png" alt="user"
                                        class="autorization__img autorization__img--grey" />
                                    <span class="autorization__btn-text">{{ __('login.register') }}</span></button>
                            </div>
                            <form id="autorization-form" class="autorization__form">
                                <span class="autorization__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="autorization-email-input" type="email" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *">
                                <div class="autorization__wrapper">
                                    <span class="autorization__label">
                                        {{ __('login.password') }}:
                                    </span>
                                    <button type="button" id="autorization-password-recall-btn" class="autorization__link">
                                        {{ __('login.forget') }}
                                    </button>

                                </div>
                                <input id="autorization-password-input" type="password" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *">
                                <span id="autorization-error-msg" class="autorization__error-msg">
									{{ __('login.error_message') }}
								</span>
                                <button type="submit" id="autorization-submit-btn" class="autorization__submit-btn">
                                    {{ __('login.login_btn') }}
                                </button>
                            </form>
                        </div>
                        <!-- для регистрации -->
                        <div id="account-registration" class="dialog__registration registration">
                            <h3 class="registration__title">
                                {{ __('login.register') }}
                            </h3>
                            <div class="registration__button-box">
                                <button id="registration-mode-btn-aurorization"
                                    class="registration__btn registration__btn--autorization">
                                    <img src="/img/user.png" alt="user"
                                        class="registration__img registration__img--grey" />
                                    <span class="registration__btn-text">{{ __('login.auth') }}</span></button>
                                <button id="registration-mode-btn-registration"
                                    class="registration__btn registration__btn--registration">
                                    <img src="/img/user.png" alt="user" class="registration__img" />
                                    <span class="registration__btn-text">{{ __('login.register') }}</span></button>
                            </div>
                            <form id="registration-form" class="registration__form">
                                <span class="registration__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="registration-email-input" type="email" class="registration__input"
                                    placeholder="* * * * * * * * * * * * * * * * *">
                                <button id="registration-submit-btn" class="registration__submit-btn">
                                    {{ __('login.register_btn') }}
                                </button>
                            </form>
                        </div>
                        <!-- напомнить пароль -->
                        <div id="account-password-recall" class="dialog__password-recall password-reacll">
                            <h3 class="password-reacll__title">
                                {{ __('login.restore') }}
                            </h3>

                            <form id="password-reacll-form" class="password-reacll__form">
                                <span class="password-reacll__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="password-reacall-input" type="email" class="password-reacll__input"
                                    placeholder="* * * * * * * * * * * * * * * * *">
                                <button id="password-reacll-submit-btn" class="password-reacll__submit-btn">
                                    {{ __('login.restore_btn') }}
                                </button>
                            </form>

                        </div>
                        <!--для продолжения регистрации пройдите в почту ... -->
                        <div id="account-password-info-msg" class="dialog__password-info-msg password-info-msg">
                            <div class="password-info-msg__wrapper">
                                <p class="password-info-msg__text">
                                    {{ __('login.register_message') }}
                                </p>
                            </div>
                        </div>
                        <!--на вашу почту отправлен пароль ... -->
                        <div id="account-password-new-info-msg"
                            class="dialog__password-new-info-msg password-new-info-msg">
                            <div class="password-new-info-msg__wrapper">
                                <p class="password-new-info-msg__text">
                                    {{ __('login.new_password_message') }}
                                </p>
                            </div>
                            <div id="password-new-info-msg-btn" class="password-new-info-msg__btn">
                                {{ __('login.new_password_btn') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/app.bundle.js"></script>

@endsection
