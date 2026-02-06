@extends('layouts.app.app')

@section('title', 'Вход')

@section('css')
    @vite(['resources/css/account.css'])
	<script async src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')

                @include('partials.app.sidebar')

                <div id="dialog1" class="dialog-login" style="visibility: visible" x-data="{
					window: 'login',
				}">
                    <div class="dialog__top" style="align-items: center">
                        <h4>{{ __('login.title') }}</h4>
                        <a class="dialog__close" href="{{ route('home') }}" style="margin-top: 0">

                        </a>
                    </div>
                    <div class="dialog__center">
                        <!-- для авторизации -->
                        <div id="account-autorization" class="dialog__autorization autorization" x-show="window === 'login'" x-data="{
							login(event) {
								let data = new FormData(event.target);
								this.$refs.err.style.display = 'none'
								grecaptcha.ready(() => {
									grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'submit'}).then((token) => {
										data.append('recaptcha_token', token)
										
										axios
											.post(route('auth'), data)
											.then(res => location.replace(route('personal')))
											.catch(err => {
												console.log(err)
												this.$refs.err.style.display = 'block'
											})
									});
								});
							},
						}">
                            <h3 class="autorization__title">
                                {{ __('login.auth') }}
                            </h3>
                            <div class="autorization__button-box">
                                <button id="autorization-mode-btn-autorization"
                                    class="autorization__btn autorization__btn_active autorization__btn--autorization">
                                    <img src="/img/user.png" alt="user" class="autorization__img" />
                                    <span class="autorization__btn-text">{!! __('login.user') !!}</span></button>
                                <button id="autorization-mode-btn-registration"
                                    class="autorization__btn autorization__btn--registration" @click="window = 'register'">
                                    <img src="/img/user.png" alt="user"
                                        class="autorization__img autorization__img--grey" />
                                    <span class="autorization__btn-text">{{ __('login.register') }}</span></button>
                            </div>
                            <form id="autorization-form" class="autorization__form" @submit.prevent="login">
                                <span class="autorization__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="autorization-email-input" type="email" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="email">
                                <div class="autorization__wrapper">
                                    <span class="autorization__label">
                                        {{ __('login.password') }}:
                                    </span>
                                    <button type="button" id="autorization-password-recall-btn" class="autorization__link" @click="window = 'forget'">
                                        {{ __('login.forget') }}
                                    </button>

                                </div>
                                <input id="autorization-password-input" type="password" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="password">
                                <span id="autorization-error-msg" class="autorization__error-msg" x-ref="err">
									{{ __('login.error_message') }}
								</span>
                                <button type="submit" id="autorization-submit-btn" class="autorization__submit-btn">
                                    {{ __('login.login_btn') }}
                                </button>
                            </form>
                        </div>
                        <!-- для регистрации -->
						<style>
							.dialog__center .registration {
								display: flex;
								position: relative;
							}
							.dialog__center .registration .registration__error-msg {
								position: absolute;
								top: 485px;
								font-weight: 600;
								font-size: 33.5px;
								color: #e9752c;
							}
							@media screen and (max-width: 500px) {
								.dialog__center .registration .registration__error-msg	{
									top: 240px;
									font-size: 2.57vw;
								}
							}
						</style>
                        <div id="account-registration" class="dialog__registration registration" x-show="window === 'register'" x-data="{
							processing: false, 
							
							register() {
								this.processing = true;
								this.$refs.err.innerText = ''

								let data = new FormData(this.$event.target);
								grecaptcha.ready(() => {
									grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'submit'}).then((token) => {
										data.append('recaptcha_token', token)
										
										axios
											.post(route('register'), data)
											.then(() => window = 'register-msg')
											.catch(err => {
												this.$refs.err.innerText = err.response.data.message
												console.log(err)
											})
											.finally(() => this.processing = false)
									});
								});
							},
						}">
                            <h3 class="registration__title">
                                {{ __('login.register') }}
                            </h3>
                            <div class="registration__button-box">
                                <button id="registration-mode-btn-aurorization"
                                    class="registration__btn registration__btn--autorization" @click="window = 'login'">
                                    <img src="/img/user.png" alt="user"
                                        class="registration__img registration__img--grey" />
                                    <span class="registration__btn-text">{{ __('login.auth') }}</span></button>
                                <button id="registration-mode-btn-registration"
                                    class="registration__btn registration__btn_active registration__btn--registration">
                                    <img src="/img/user.png" alt="user" class="registration__img" />
                                    <span class="registration__btn-text">{{ __('login.register') }}</span></button>
                            </div>
                            <form id="registration-form" class="registration__form" @submit.prevent="register">
                                <span class="registration__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="registration-email-input" type="email" class="registration__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="email" required>
                                <button id="registration-submit-btn" class="registration__submit-btn" :disabled="processing">
                                    {{ __('login.register_btn') }}
                                </button>
                            </form>
							<span id="registration-error-msg" class="registration__error-msg" x-show="true" x-ref="err">
								
							</span>
                        </div>
                        <!-- напомнить пароль -->
						<style>
							.dialog__center .password-reacll {
								display: flex;
							}
						</style>
                        <div id="account-password-recall" class="dialog__password-recall password-reacll" x-show="window === 'forget'" x-data="{
							processing: false,

							submit(e) {
								this.processing = true;

								axios
									.post(route('password.reset'), new FormData(e.target))
									.then(resp => this.window = 'forget-msg')
									.finally(() => this.processing = false)
							}
						}">
                            <h3 class="password-reacll__title">
                                {{ __('login.restore') }}
                            </h3>

                            <form id="password-reacll-form" class="password-reacll__form" @submit.prevent="submit">
                                <span class="password-reacll__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="password-reacall-input" type="email" class="password-reacll__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="email" required>
                                <button id="password-reacll-submit-btn" class="password-reacll__submit-btn" :disabled="processing">
                                    {{ __('login.restore_btn') }}
                                </button>
                            </form>

                        </div>
                        <!--для продолжения регистрации пройдите в почту ... -->
						<style>
							.dialog__center .password-info-msg {
								display: flex;
							}
						</style>
                        <div id="account-password-info-msg" class="dialog__password-info-msg password-info-msg" style="display: flex" x-show="window === 'register-msg'">
                            <div class="password-info-msg__wrapper">
                                <p class="password-info-msg__text">
                                    {{ __('login.register_message') }}
                                </p>
                            </div>
                        </div>
                        <!--на вашу почту отправлен пароль ... -->
						<style>
							.dialog__center .password-new-info-msg {
								display: flex;
							}
						</style>
                        <div id="account-password-new-info-msg"
                            class="dialog__password-new-info-msg password-new-info-msg" style="display: flex" x-show="window === 'forget-msg'">
                            <div class="password-new-info-msg__wrapper">
                                <p class="password-new-info-msg__text">
                                    {{ __('login.new_password_message') }}
                                </p>
                            </div>
                            <button id="password-new-info-msg-btn" class="password-new-info-msg__btn" @click="window = 'login'">
                                {{ __('login.new_password_btn') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- <script src="/js/app.bundle.js"></script> --}}

@endsection
