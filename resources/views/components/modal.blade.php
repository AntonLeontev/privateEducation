<div class="modal">
	<div class="modal__header">
		<span class="header__text">Личный кабинет</span>
		<button class="myBtn modal__close-btn" @click="authModal = false"></button>
	</div>

	<div class="modal__body">
		{{ $slot }}
	</div>
</div>
