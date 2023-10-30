@extends('layouts.admin.index')

@section('title', 'Деактивация фрагментов')

@section('content')
<div class="w-full" x-data="fragments" @keydown.esc="modal = false">
	<header class="my-3 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">
				Просмотр и деактивация фрагментов
			</span>
			<div class="flex items-center gap-5 border rounded-xl">
				<div class="!bg-transparent join">
					<input class="bg-transparent !px-2 border-none join-item btn text-white checked:!bg-white checked:!text-black hover:!text-black" type="radio" aria-label="Русский" 
					:checked="lang === 'ru'" @click="lang = 'ru'" />
					<input class="bg-transparent !px-2 border-none join-item btn text-white checked:!bg-white checked:!text-black hover:!text-black" type="radio" aria-label="English"
					:checked="lang === 'en'" @click="lang = 'en'" />
				</div>
			</div>
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

	<div class="container">
        <div 
			class="relative content hidden-md" 
		>
            <div class="flex gap-x-[2.34vw] shrink-0 mb-5">
                <div class="player basis-[27vw] !ml-0">
                    <div class="flex flex-col h-full gap-y-[0.26042vw]">
                        <div class="flex justify-between player__title align-center">
							<div class="flex items-center gap-x-2 bg-[rgba(146,140,141,0.7)] pr-2 w-[90%]">
								<div class="flex flex-col justify-center h-[calc(1.3vw*1.15*2+0.96vw)] text-[1.2vw] leading-none pl-1">
									<div>Видео</div>
									<div>Презентация. Фрагмент №1</div>
									<div>Заглавие</div>
								</div>
							</div>
                        </div>
						<div class="w-full h-full player__content">
                            <div class="player__frame">
                            </div>
                        </div>

						
                    </div>
                </div>
				<div class="flex justify-between w-full">
					@foreach (range(1, 6) as $number)
						<x-admin.fragment-deactivation :$number />
					@endforeach
				</div>
            </div>
            <div class="flex justify-between">
				@foreach (range(7, 17) as $number)
					<x-admin.fragment-deactivation :$number isPurple />
				@endforeach
            </div>

			<div class="fixed top-0 bottom-0 left-0 right-0" x-show="modal" x-cloak>
			</div>

			<div 
				class="auth-modal modal-content modal-content_audio" 
				style="display: none"
				x-show="modal && page === 'deactivation'"
				x-cloak
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="selectedFragment?.is_active ? `Деактивация фрагмента №${selectedFragment?.id}` : `Активация фрагмента №${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<div class="justify-center modal-content__body">
					<div>
						<div class="modal-content__title" x-text="selectedFragment?.is_active ? `Уверены что хотите деактивировать фрагмент&nbsp№${selectedFragment?.id}?` : `Уверены что хотите активировать фрагмент&nbsp№${selectedFragment?.id}?`"></div>
						<div class="modal-reg-buttons-wrapper gap-x-2">
							<button class="myBtn action-btn auth-modal__login-btn" @click="changeActivation">ПОДТВЕРДИТЬ</button>
						</div>
					</div>
				</div>
			</div>

			<div 
				class="modal-content modal-content_presentation" 
				style="display: none"
				x-show="modal && page === 'presentation'"
				x-cloak
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Презентация фрагмента ${selectedFragment?.id}. Заглавие`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<div class="modal-content__body">
					<div class="modal-content__title">Презентация части фрагмента</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="pres-type" text="В моно" italic="(обработанный объемный голос)" checked />
							<x-radio-group.item name="pres-type" text="В стерео" italic="(живой голос)" />
							<x-radio-group.item name="pres-type" text="В виде текста" italic="" />
						</x-radio-group>
					</div>
					<div class="modal__duration">Продолжительность записи в минутах: 00:00</div>

					<div class="modal__delimiter modal__delimiter_presentation"></div>

					<div class="modal-content__title">Устройство воспроизведения:</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="pres-device" text="Мобильная версия" italic="(apple, android)" />
							<x-radio-group.item name="pres-device" text="Планшет" italic="" />
							<x-radio-group.item name="pres-device" text="Ноутбук" italic="" checked />
						</x-radio-group>
					</div>
					<div class="access access_granted">Доступ активирован</div>
					<button class="play-button"></button>
					<div class="" style="height: 25px"></div>
				</div>
			</div>

			<div 
				class="modal-content modal-content_audio" 
				style="display: none"
				x-show="modal && page === 'audio'"
				x-cloak
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Полное содержание. Фрагмент ${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<div class="modal-content__body">
					<div class="modal-content__title">Аудио формат для прослушивания на сайте</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="audio-type" text="В моно" italic="(обработанный объемный голос)" checked />
							<x-radio-group.item name="audio-type" text="В стерео" italic="(живой голос)" />
						</x-radio-group>
					</div>
					<div class="modal__duration">Продолжительность записи в минутах: 00:00</div>

					<div class="modal__delimiter modal__delimiter_audio"></div>

					<div class="modal-content__title">Устройство воспроизведения:</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="audio-device" text="Мобильная версия" italic="(apple, android)" />
							<x-radio-group.item name="audio-device" text="Планшет" italic="" />
							<x-radio-group.item name="audio-device" text="Ноутбук" italic="" checked />
						</x-radio-group>
					</div>
					<div class="access access_granted">Доступ активирован</div>
					<button class="play-button"></button>
					<div class="" style="height: 25px"></div>
				</div>
			</div>

			<div 
				class="modal-content modal-content_video" 
				style="display: none"
				x-show="modal && page === 'video'"
				x-cloak
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Полное содержание. Фрагмент ${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<div class="modal-content__body">
					<div class="modal-content__title">Видео формат для просмотра и прослушивания на сайте</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="video-type" text="В моно" italic="(обработанный объемный голос)" checked />
							<x-radio-group.item name="video-type" text="В стерео" italic="(живой голос)" />
						</x-radio-group>
					</div>
					<div class="modal__duration">Продолжительность записи в минутах: 00:00</div>

					<div class="modal__delimiter modal__delimiter_video"></div>

					<div class="modal-content__title">Устройство воспроизведения:</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="video-device" text="Мобильная версия" italic="(apple, android)" />
							<x-radio-group.item name="video-device" text="Планшет" italic="" />
							<x-radio-group.item name="video-device" text="Ноутбук" italic="" checked />
						</x-radio-group>
					</div>
					<div class="access access_granted">Доступ активирован</div>
					<button class="play-button"></button>
					<div class="" style="height: 25px"></div>
				</div>
			</div>

    </div>

	


</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('fragments', () => ({
			fragments: @json($fragments),
			lang: 'ru',
			modal: false,
			selectedFragment: null,
			plaingFragment: null,
			page: 'presentation',
			
			title: 'Суммарные продажи',

			changeActivation() {
				axios
					.post(route('admin.fragments.update', this.selectedFragment.id), {
						'is_active': !this.selectedFragment.is_active,
					})
					.then(response => {
						let fragment = this.getFragment(this.selectedFragment.id)
						fragment.is_active = !fragment.is_active
					})
					.catch(error => alert('Ошибка'))
					.finally(() => this.modal = false)
			},
			getFragment(id) {
				return this.fragments.find(el => el.id === id)
			},
		}))
	})
</script>

@endsection

@section('modals')
    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection
