<div class="container">
	<ul class="tabs-own no-style">
		<li class="own-page-item"><a class="own-page-link" href="#">Личный кабинет</a></li>
		@if (Route::has('my.media'))
			<li><a @if (Route::is('my.media')) class="active" @endif href="{{ route('my.media') }}">Мои покупки</a></li>
		@endif
		@if (Route::has('my.account'))
			<li><a @if (Route::is('my.account')) class="active" @endif href="{{ route('my.account') }}">Настройки</a></li>
		@endif
		@if (Route::has('my.password'))
			<li><a @if (Route::is('my.password')) class="active" @endif class="change-link" href="{{ route('my.password') }}">Сменить пароль</a></li>
		@endif

		<li class="exit-item">
			<form method="POST" action="{{ route('logout') }}">
				@csrf
				<button class="exit-link">Выход</button>
			</form>
		</li>
	</ul>
</div>
