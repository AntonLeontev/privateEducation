@extends('layouts.app.app')

@section('title', 'Вход в админ панель')

@section('css')
    <link rel="stylesheet" href="/css/account.css" />
@endsection

@section('content')
    <script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('authModal', () => ({
				section: 'login', 
				
				login() {
					let data = new FormData(this.$event.target)

					axios
						.post(route('admin.login.store'), data)
						.then(response => {
							this.$refs.email.value = data.get('email')
							this.section = '2factor'
							this.$refs.code.innerText = response.data.code
						})
						.catch(error => {
							this.$refs.loginError.innerText = 'Не удалось войти в аккаунт, введенные логин или пароль неверны'
						})
				},
				checkCode() {
					let data = new FormData(this.$event.target)

					axios
						.post(route('admin.two-factor.check'), data)
						.then(response => {
							location.href = response.data.redirect;
						})
						.catch(error => {
							this.$refs.codeError.innerText = error.response.data.message
						})
				},
			}))
		})
	</script>

	<main>
        <div class="main">
            <div class="container">
                {{-- @include('partials.app.header')

                @include('partials.app.sidebar') --}}

                <div id="dialog1" class="" style="visibility: visible" x-data="authModal">
                    <div class="dialog__top" style="align-items: center">
                        <h4>Вход в административную панель</h4>
                        <a class="dialog__close" href="{{ route('home') }}" style="margin-top: 0">

                        </a>
                    </div>
                    <div class="dialog__center" x-show="section === 'login'">
                        <!-- для авторизации -->
                        <div id="account-autorization" class="dialog__autorization autorization" x-show="section === 'login'">
                            <h3 class="autorization__title">
                                {{ __('login.auth') }}
                            </h3>
                            <form id="autorization-form" class="autorization__form" @submit.prevent="login">
                                <span class="autorization__label">
                                    {{ __('login.email') }}:
                                </span>
                                <input id="autorization-email-input" type="text" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" name="email">
                                <div class="autorization__wrapper">
                                    <span class="autorization__label">
                                        {{ __('login.password') }}:
                                    </span>

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
                    </div>
                    <div class="dialog__center">
                        <!-- для кода из почты -->
                        <div id="account-autorization" class="dialog__autorization autorization" x-show="section === '2factor'">
                            <h3 class="autorization__title">
                                Введите код из почты
                            </h3>
                            <form id="autorization-form" class="autorization__form" @submit.prevent="checkCode">
								<input type="hidden" name="email" x-ref="email">
                                <span class="autorization__label">
                                    Код для входа:
                                </span>
                                <input id="autorization-email-input" type="text" class="autorization__input"
                                    name="code">
								<div class="login-error-message" x-ref="codeError"></div>
                                <button type="submit" id="autorization-submit-btn" class="autorization__submit-btn">
                                    {{ __('login.login_btn') }}
                                </button>
								<div x-ref="code" style="margin-top: 25px"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/js/app.bundle.js"></script>

@endsection
