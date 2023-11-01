@extends('layouts.app.app')

@section('title', 'Личный кабинет')

@section('content')
	<div class="auth-modal--cover" x-show="modal">
		<div 
			class="auth-modal auth-modal--continue js-restore-success-modal" 
			x-data="authModal"
			x-show="modal"
		>
			<div class="modal-header">
				<span class="modal-header-text">Личный кабинет</span>
				<button class="myBtn modal-close-btn" @click="modal = false"></button>
	
			</div>
			<div class="modal-body">
				<div class="modal-step">
					<!--  Шаг 3 из 5 --> &nbsp;
				</div>
				<div x-show="section === 'login' || section === 'registration'">
					<div class="modal-title" x-text="section === 'login' ? 'Авторизация' : 'Регистрация'">
						Регистрация
					</div>
					<div class="modal-reg-buttons-wrapper">
			
						<div 
							class="modal-auth-btn modal-auth-btn--user"
							:class="section === 'login' ? 'active' : 'disable'"
							@click="section = 'login'"
						>
							<img src="{{ Vite::asset('resources/images/user-active.png') }}" alt="login button" x-show="section === 'login'"> 
							<img src="{{ Vite::asset('resources/images/user-disabled.png') }}" alt="login button" x-show="section === 'registration'"> 
							<span class="modal-regbtn-text">Я пользователь</span>
						</div>
						<div 
							class="modal-auth-btn modal-auth-btn--reg"
							:class="section === 'registration' ? 'active' : 'disable'"
							@click="section = 'registration'"
						>
							<img src="{{ Vite::asset('resources/images/user-active.png') }}" alt="registration button" x-show="section === 'registration'">
							<img src="{{ Vite::asset('resources/images/user-disabled.png') }}" alt="registration button" x-show="section === 'login'">
							<span class="modal-regbtn-text modal-regbtn-text--reg">Регистрация</span>
						</div>
					</div>
			
					<form class="modal-auth-form" x-show="section === 'login'" x-cloak @submit.prevent="login">
						<div class="modal-email-label">
							Адрес электронной почты:
						</div>
						<input class="modal-input" type="email" name="email" placeholder="* * * * * * * * * * * * * * * * * * * *">
			
						<div class="modal-password-wrapper">
							<span style="width: auto" class="modal-email-label">
								Пароль:
							</span>
							<button type="button" class="modal-password-forgotten" @click.prevent="section = 'restore'">Забыли пароль?</button>
						</div>
						<input class="modal-input modal-input--password" type="password" name="password"
							placeholder="* * * * * * * * * * * * * * * * * * * *">
						<div class="login-error-message" x-show='loginError' x-cloak>
							Не удалось войти в аккаунт, введенные e-mail или пароль неверны
						</div>
						<button class="myBtn action-btn auth-modal__login-btn">ВХОД</button>
					</form>
			
					<form class="modal-auth-form" x-show="section === 'registration'" x-cloak @submit.prevent="register">
						<div>
							<div class="modal-email-label" for="modal-email">
								Адрес электронной почты:
							</div>
						</div>
						<input id="modal-email" class="modal-input" type="email" name="email"
							placeholder="* * * * * * * * * * * * * * * * * * * *">
			
						<button class="myBtn action-btn auth-modal__reg-btn" style="margin-top: 2.8vw;">ПРОДОЛЖИТЬ</button>
					</form>
				</div>
				<div x-show="section === 'restore'" x-cloak>
					<div class="modal-title modal-title--restore"> Восстановить пароль </div>
					<form class="modal-auth-form modal-auth-form--restore" @submit.prevent="reset">
						<div class="modal-email-label"> Адрес электронной почты: </div> <input class="modal-input modal-input--restore"
							type="email" name="email" placeholder="* * * * * * * * * * * * * * * * * * * *"> 
							<button
							class="myBtn action-btn auth-modal__reg-btn auth-modal__restore-btn js-restore-button">ВОССТАНОВИТЬ</button>
					</form>
				</div>
				<div class="continue" x-show="section === 'restore-next'">
					<div class="continue-reg" style="margin-top: 6vw;"> 
						На вашу почту отправлен новый пароль для входа на сервис 
					</div>
					<button class="myBtn action-btn auth-modal__reg-btn" style="display: block; margin: 0 auto;" @click="section = 'login'">АВТОРИЗАЦИЯ</button>
				</div>
				<div class="continue" x-show="section === 'register-next'">
					<div class="continue-reg"> 
						Для продолжения регистрации перейдите по ссылке в письме и подтвердите e-mail
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('authModal', () => ({
				section: 'login',
				loginError: false,
				modal: true,

				login() {
					let data = new FormData(this.$event.target)
					this.loginError = false
					
					axios
						.post('/login', data)
						.then(response => window.location.href = route('my.media'))
						.catch(error => this.loginError = true)
				},
				register() {
					let data = new FormData(this.$event.target)
					if (data.get('email') === '') return 
					axios
						.post(route('register'), data)
						.then(response => this.section = 'register-next')
						.catch(error => console.log(error))
				},
				reset() {
					let data = new FormData(this.$event.target)
					if (data.get('email') === '') return 
					axios
						.post(route('password.reset'), data)
						.then(response => this.section = 'restore-next')
						.catch(error => console.log(error))
				},
			}))
		})
	</script>

@endsection
