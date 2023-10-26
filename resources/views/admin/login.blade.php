@extends('layouts.app.app')

@section('title', 'Вход в админ панель')

@section('content')
	<div class="auth-modal--cover">
		<div 
			class="auth-modal" 
			x-data="authModal"
			x-show="show"
		>
			<div class="modal-header">
				<span class="modal-header-text">Вход в админ панель</span>
				<button class="myBtn modal-close-btn" @click="show = false"></button>
	
			</div>
			<div class="modal-body" style="display: flex; justify-content:center; align-items:center; height: 100%">
				<form class="modal-auth-form" x-show="section === 'login'" x-cloak @submit.prevent="login">
					<div class="modal-email-label">
						Логин администратора:
					</div>
					<input class="modal-input" type="text" name="email" placeholder="* * * * * * * * * * * * * * * * * * * *">
		
					<div class="modal-password-wrapper">
						<span style="width: auto" class="modal-email-label">
							Пароль:
						</span>
					</div>
					<input class="modal-input modal-input--password" type="password" name="password"
						placeholder="* * * * * * * * * * * * * * * * * * * *">
					<div class="login-error-message" x-ref="loginError"></div>
					<button class="myBtn action-btn auth-modal__login-btn">ВХОД</button>
				</form>
		
				
				<div x-show="section === '2factor'" x-cloak>
					<form class="modal-auth-form modal-auth-form--restore" @submit.prevent="checkCode">
						<input type="hidden" name="email" x-ref="email">
						<div class="modal-email-label"> Код для входа: </div> 
						<input class="modal-input"
							type="text" name="code" placeholder="* * * * * * * * * * * * * * * * * * * *"> 
						<div class="login-error-message" x-ref="codeError"></div>
						<button class="myBtn action-btn auth-modal__login-btn">ВХОД</button>
						<div x-ref="code" style="margin-top: 25px"></div>
					</form>
				</div>
			</div>
		</div>
	</div>

    <script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('authModal', () => ({
				section: 'login', 
				show: true,
				
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
							location.href = route('admin.fragments');
						})
						.catch(error => {
							this.$refs.codeError.innerText = error.response.data.message
						})
				},
			}))
		})
	</script>

@endsection
