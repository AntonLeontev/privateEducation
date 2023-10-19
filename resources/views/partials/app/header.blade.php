<header class="header" x-data="header">
    <div class="container container-header">
        <nav class="header__nav">
            <ul class="header__list__nav">
                @if (Route::has('home'))
                    <li class="header__nav__list-item"><a href="{{ route('home') }}">{{ __('header.menu.home') }}</a>
                    </li>
                @endif
                @if (Route::has('about'))
                    <li class="header__nav__list-item"><a href="{{ route('about') }}">{{ __('header.menu.about') }}</a></li>
                @endif
                @if (Route::has('copyright'))
                    <li class="header__nav__list-item"><a href="{{ route('copyright') }}">{{ __('header.menu.copyright') }}</a></li>
                @endif
                @if (Route::has('commercial'))
                    <li class="header__nav__list-item"><a href="{{ route('commercial') }}">{{ __('header.menu.commercial') }}</a></li>
                @endif
                @if (Route::has('privacy'))
                    <li class="header__nav__list-item"><a href="{{ route('privacy') }}">{{ __('header.menu.privacy') }}</a></li>
                @endif
                @if (Route::has('contacts'))
                    <li class="header__nav__list-item"><a href="{{ route('contacts') }}">{{ __('header.menu.contacts') }}</a></li>
                @endif
            </ul>
        </nav>
        <button class="user_link" @click="openAuthModal">
            <img src="{{ Vite::asset('resources/images/user.png') }}" alt="Иконка личного кабинета">
            <div class="lk">
                {{ __('header.personal') }}
            </div>
        </button>
        <div class="burger menu" @click="menuModal=true">
            <div class="menu-text">{{ __('header.menuBtn') }}</div>
            <span></span>
        </div>
    </div>

	<div class="auth-modal--cover" x-show="authModal" x-cloak >
		<div 
			class="auth-modal auth-modal--main auth-modal--on-text-pages auth-modal--continue js-restore-success-modal" 
			@modal-auth.window="section = 'login'"
			x-data="authModal"
		>
			<div class="modal-header">
				<span class="modal-header-text">Личный кабинет</span>
				<button class="myBtn modal-close-btn" @click="authModal = false"></button>
	
			</div>
			<div class="modal-step">
				<!--  Шаг 3 из 5 --> &nbsp;
			</div>
			<div x-show="section === 'login' || section === 'registration'">
				<div class="modal-title">
					Авторизация
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
		
				<form class="modal-auth-form" x-show="section === 'login'" x-cloak>
					<div style="width: 100%">
						<div class="modal-email-label">
							Адрес электронной почты:
						</div>
					</div>
					<input class="modal-input" type="email" name="email" placeholder="* * * * * * * * * * * * * * * * * * * *">
		
					<div class="modal-password-wrapper">
						<span class="modal-email-label">
							Пароль:
						</span>
						<button type="button" class="modal-password-forgotten" @click.prevent="section = 'restore'">Забыли пароль?</button>
					</div>
					<input class="modal-input modal-input--password" type="password" name="password"
						placeholder="* * * * * * * * * * * * * * * * * * * *">
					<div class="login-error-message">
						Не удалось войти в аккаунт, введенные e-mail или пароль неверны
					</div>
					<button class="myBtn action-btn auth-modal__login-btn">ВХОД</button>
				</form>
		
				<form class="modal-auth-form" x-show="section === 'registration'" x-cloak>
					<div style="width: 100%">
						<div class="modal-email-label" for="modal-email">
							Адрес электронной почты:
						</div>
					</div>
					<input id="modal-email" class="modal-input" type="email" name="email"
						placeholder="* * * * * * * * * * * * * * * * * * * *">
		
					<button class="myBtn action-btn auth-modal__reg-btn">ПРОДОЛЖИТЬ</button>
				</form>
			</div>
			<div x-show="section === 'restore'" x-cloak>
				<div class="modal-title modal-title--restore"> Восстановить пароль </div>
				<form class="modal-auth-form modal-auth-form--restore">
					<div class="modal-email-label"> Адрес электронной почты: </div> <input class="modal-input modal-input--restore"
						type="email" name="email" placeholder="* * * * * * * * * * * * * * * * * * * *"> <button
						class="myBtn action-btn auth-modal__reg-btn auth-modal__restore-btn js-restore-button">ВОССТАНОВИТЬ</button>
				</form>
			</div>
			<div class="continue" x-show="section === 'restore-next'">
				<div class="continue-reg"> 
					На вашу почту отправлен новый пароль для входа на сервис 
				</div>
				<button class="myBtn action-btn auth-modal__reg-btn" @click="section = 'login'">АВТОРИЗАЦИЯ</button>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('authModal', () => ({
				section: 'login'
			}))
		})
	</script>

	@include('partials.app.menu')
</header>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('header', () => ({
			authModal: false,
			menuModal: false,

			openAuthModal() {
				this.authModal = true
				this.$dispatch('modal-auth')
			},
		}))
	})
</script>


