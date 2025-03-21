@extends('layouts.admin.index')

@section('title', 'Деактивация фрагментов')

@section('head')
	@vite('node_modules/video.js/dist/video-js.min.css')
	@vite('resources/scss/vjs-admin.scss')
	<script src="/js/perfectScroll/perfect-scrollbar.js"></script>
@endsection

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
					:checked="lang === 'ru'" @click="lang = 'ru'; $dispatch('change-lang')" />
					<input class="bg-transparent !px-2 border-none join-item btn text-white checked:!bg-white checked:!text-black hover:!text-black" type="radio" aria-label="English"
					:checked="lang === 'en'" @click="lang = 'en'; $dispatch('change-lang')" />
				</div>
			</div>
			<x-admin.menu-button />
		</div>
	</header>

	<div class="container">
        <div 
			class="relative content hidden-md" 
		>
            <div class="flex gap-x-[2vw] shrink-0 grow-0 mb-3">
                <div class="player basis-[27vw] !ml-0 max-w-[27vw]">
                    <div class="flex flex-col h-full gap-y-[0.26042vw]">
                        <div class="flex justify-between player__title align-center">
							<div class="flex items-center gap-x-2 bg-[rgba(146,140,141,0.7)] pr-2 w-[90%]">
								<div class="flex flex-col justify-center w-full h-[calc(1.3vw*1.15*2+0.96vw)] text-[1.2vw] leading-none pl-1">
									<div class="flex w-full flex-col justify-center h-[calc(1.3vw*1.15*2+0.96vw)] text-[1.2vw] leading-none pl-1 overflow-hidden">
										<div x-text="title">Видео</div>
										<div x-text="lang === 'ru' ? 'Фрагмент №' + playingFragment?.id : 'Fragment №' + playingFragment?.id">Фрагмент №1</div>
										<div 
											class="relative w-full" 
											x-data="runningLine" 
											x-ref="lineWrap"
											@play-media.window="reset"
											@change-lang.window="reset"
										>
											<div class="relative right-0 transition ease-linear whitespace-nowrap w-max" x-text="text()" x-ref="line"></div>
										</div>
										<script>
											document.addEventListener('alpine:init', () => {
												Alpine.data('runningLine', () => ({
													shift: null,
													timerId: null,
													isStart: true,
													init() {
														this.$nextTick(() => {
															this.shift = this.calcShift()
															this.timerId = setTimeout(() => this.moveLeft(), 500)
														})
													},
													text() {
														return this.lang === 'ru' ? this.playingFragment?.title_ru : this.playingFragment?.title_en
													},
													reset() {
														clearTimeout(this.timerId);

														this.$refs.line.classList.remove('transition')
														this.$refs.line.classList.remove('ease-linear')
														this.$refs.line.style.transitionDuration = '0s'
														this.$refs.line.style.transform = `translateX(0px)`
														this.isStart = true
														
														
														this.$nextTick(() => {
															this.$refs.line.classList.add('transition')
															this.$refs.line.classList.add('ease-linear')
															this.shift = this.calcShift()
															this.moveLeft()
														})
														
													},
													moveLeft() {
														this.timerId = setTimeout(() => {
															if (this.$refs.lineWrap.offsetWidth - this.$refs.line.offsetWidth >= 0) return

															if (this.isStart) {
																this.$refs.line.style.transitionDuration = Math.abs(this.$refs.line.offsetWidth) * 10 + 'ms'
																this.isStart = false
															} else {
																this.$refs.line.style.transitionDuration = 
																	Math.abs(this.$refs.line.offsetWidth + this.$refs.lineWrap.offsetWidth) * 10 + 'ms'
															}
															this.$refs.line.style.transform = `translateX(${-this.shift}px)`

															this.$refs.line.ontransitionend = () => {
																this.moveRight()
															}
														}, 500)
													},
													moveRight() {
														this.$refs.line.style.transitionDuration = 0 + 'ms';
														this.$refs.line.style.transform = `translateX(${this.$refs.lineWrap.offsetWidth}px)`;

														this.moveLeft()
													},
													calcShift() {
														return this.$refs.line.offsetWidth + 10;
													},
												}))
											})
										</script>
									</div>
								</div>
							</div>
                        </div>

						<div class="w-full h-full player__content">
                            <div 
								class="relative z-50 !rounded-none player__frame !overflow-hidden" 
								x-data="player" 
								@play-media.window="play"
								@play-text.window="pause"
							>
								<video 
									id="player" 
									class="vjs-admin video-js vjs-fill vjs-duration" 
									poster="/player.png"
								>
								</video>
                            </div>

							<script>
								document.addEventListener('alpine:init', () => {
									Alpine.data('player', () => ({
										player: null,

										init() {
											this.$nextTick(() => {
												this.player = videojs('player', {controls: true})
												this.player.volume(0.5)
											})
										},
										play() {
											let media = this.playingFragment[this.playingMedia].media.find(el => {
												if (el.lang !== this.lang) return false
												if (el.sound !== this.sound) return false
												if (el.device !== this.device) return false

												return true
											})
											
											if (!media) {
												alert('Ошибка! Файл не загружен')
												return
											}

											this.modal = false

											this.player.src({
												type: media.format, 
												src: `/media/${this.playingMedia}/${this.playingFragment.id}/${this.lang}/${this.sound}/${this.device}` 
											})
											this.player.play()
										},
										pause() {
											this.player.pause()
										},
									}))
								})
							</script>
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

			<div class="fixed top-0 bottom-0 left-0 right-0" x-show="modal || modalPresentationText" x-cloak>
			</div>

			<div 
				class="z-50 auth-modal modal-content modal-content_audio" 
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
				class="z-50 modal-content modal-content_presentation" 
				style="display: none"
				x-show="modal && page === 'presentation'"
				x-cloak
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Презентация фрагмента ${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<form class="modal-content__body" @submit.prevent="play">
					<div class="modal-content__title">Презентация части фрагмента</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="presentation-sound" value="mono" text="В моно" italic="(обработанный объемный голос)" checked />
							<x-radio-group.item name="presentation-sound" value="stereo" text="В стерео" italic="(живой голос)" />
							<x-radio-group.item name="presentation-sound" value="text" text="В виде текста" italic="" />
						</x-radio-group>
					</div>
					<div class="modal__duration" x-text="'Продолжительность записи в минутах: ' + (selectedFragment?.presentation.media[0]?.playtime ?? '00:00')"></div>

					<div class="modal__delimiter modal__delimiter_presentation"></div>

					<div class="modal-content__title">Устройство воспроизведения:</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="presentation-device" value="mobile" text="Мобильная версия" italic="(apple, android)" />
							<x-radio-group.item name="presentation-device" value="tablet" text="Планшет" italic="" />
							<x-radio-group.item name="presentation-device" value="notebook" text="Ноутбук" italic="" checked />
						</x-radio-group>
					</div>
					<div class="access access_granted">Доступ активирован</div>
					<button class="play-button"></button>
					<div class="" style="height: 25px"></div>
				</form>
			</div>

			<div 
				class="z-50 modal-content modal-content_presentation" 
				style="display: none"
				:class="wide && '!top-0 !bottom-0 !left-0 !right-0 !w-auto !h-auto'"
				x-show="modalPresentationText"
				x-data="{
					wide: false,
					mode: 'presentation',
				}"
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Текст презентации фрагмента ${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modalPresentationText = false; wide = false"></button>
				</div>
				<div class="!px-10 modal-content__body !pb-2 !pr-2">
					<button class="absolute right-[2.5vw] w-[28px] z-50" @click="wide = !wide">
						<img src="{{ Vite::asset('resources/images/text-expand-out.png') }}" x-show="!wide">
						<img src="{{ Vite::asset('resources/images/text-expand-in.png') }}" x-show="wide">
					</button>
					<div class="relative overflow-auto presentation-text pr-[4.4vw]">
						<div class="flex justify-center gap-3 mb-2">
							<button class="p-1 rounded" :class="mode === 'presentation' && 'bg-[#ffaa74]'" @click="mode = 'presentation'">Текст презентации</button>
							<button class="p-1 rounded" :class="mode === 'full' && 'bg-[#ffaa74]'" @click="mode = 'full'">Полный текст</button>
						</div>
						
						<div class="mb-4 modal-content__title">
							<span class="px-4" x-text="lang === 'ru' ? selectedFragment?.title_ru : selectedFragment?.title_en"></span>
						</div>
						<style>
							.presentation-text p {
								min-height: 1rem;
								text-indent: 25px;
								text-align: justify;
							}
						</style>
						<div class="whitespace-pre-line text-[20px] presentation-text" x-html="lang === 'ru' ? selectedFragment?.presentation.text_ru : selectedFragment?.presentation.text_en" x-show="mode === 'presentation'"></div>
						<div class="whitespace-pre-line text-[20px] presentation-text" x-html="lang === 'ru' ? selectedFragment?.audio.text_ru : selectedFragment?.audio.text_en" x-show="mode === 'full'"></div>
					</div>
				</div>
			</div>

			<div 
				class="z-50 modal-content modal-content_audio" 
				style="display: none"
				x-show="modal && page === 'audio'"
				x-cloak
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Полное содержание. Фрагмент ${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<form class="modal-content__body" @submit.prevent="play">
					<div class="modal-content__title">Аудио формат для прослушивания на сайте</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="audio-sound" value="mono" text="В моно" italic="(обработанный объемный голос)" checked />
							<x-radio-group.item name="audio-sound" value="stereo" text="В стерео" italic="(живой голос)" />
						</x-radio-group>
					</div>
					<div class="modal__duration" x-text="'Продолжительность записи в минутах: ' + (selectedFragment?.audio.media[0]?.playtime ?? '00:00')"></div>

					<div class="modal__delimiter modal__delimiter_audio"></div>

					<div class="modal-content__title">Устройство воспроизведения:</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="audio-device" value="mobile" text="Мобильная версия" italic="(apple, android)" />
							<x-radio-group.item name="audio-device" value="tablet" text="Планшет" italic="" />
							<x-radio-group.item name="audio-device" value="notebook" text="Ноутбук" italic="" checked />
						</x-radio-group>
					</div>
					<div class="access access_granted">Доступ активирован</div>
					<button class="play-button"></button>
					<div class="" style="height: 25px"></div>
				</form>
			</div>

			<div 
				class="z-50 modal-content modal-content_video" 
				style="display: none"
				x-show="modal && page === 'video'"
			>
				<div class="modal-content__header">
					<span class="modal-header-text" x-text="`Полное содержание. Фрагмент ${selectedFragment?.id}`"></span>
					<button class="myBtn modal-content__close-btn" @click="modal = false"></button>
				</div>
				<form class="modal-content__body" @submit.prevent="play">
					<div class="modal-content__title">Видео формат для просмотра и прослушивания на сайте</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="video-sound" value="mono" text="В моно" italic="(обработанный объемный голос)" checked />
							<x-radio-group.item name="video-sound" value="stereo" text="В стерео" italic="(живой голос)" />
						</x-radio-group>
					</div>
					<div class="modal__duration" x-text="'Продолжительность записи в минутах: ' + (selectedFragment?.video.media[0]?.playtime ?? '00:00')"></div>

					<div class="modal__delimiter modal__delimiter_video"></div>

					<div class="modal-content__title">Устройство воспроизведения:</div>
					<div class="radio-container">
						<x-radio-group>
							<x-radio-group.item name="video-device" value="mobile" text="Мобильная версия" italic="(apple, android)" />
							<x-radio-group.item name="video-device" value="tablet" text="Планшет" italic="" />
							<x-radio-group.item name="video-device" value="notebook" text="Ноутбук" italic="" checked />
						</x-radio-group>
					</div>
					<div class="access access_granted">Доступ активирован</div>
					<button class="play-button"></button>
					<div class="" style="height: 25px"></div>
				</form>
			</div>

    </div>

	


</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('fragments', () => ({
			fragments: @json($fragments),
			lang: 'ru',
			device: '',
			sound: '',
			modal: false,
			modalPresentationText: false,
			selectedFragment: null,
			playingFragment: null,
			playingMedia: 'presentation',
			page: 'presentation',
			title: 'Презентация',

			init() {
				this.playingFragment = this.fragments[0]

				this.$nextTick(() => {
					let scroll = new PerfectScrollbar(".presentation-text", {
						wheelSpeed: 1.2,
						wheelPropagation: true,
						minScrollbarLength: 100,
					});
				})

			},
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
			play() {
				let data = new FormData(this.$event.target)
				
				if (data.get(`${this.page}-sound`) === 'text') {
					this.modal = false
					this.modalPresentationText = true
					this.$dispatch('play-text')
					return
				}
				
				this.sound = data.get(`${this.page}-sound`)
				this.device = data.get(`${this.page}-device`)
				this.playingFragment = this.selectedFragment
				this.playingMedia = this.page
				this.title = this.makeTitle()
				this.$dispatch('play-media')
			},
			makeTitle() {
				if (this.lang === 'ru') {
					if (this.page === 'audio') return 'Аудио'
					if (this.page === 'video') return 'Видео'
					if (this.page === 'presentation') return 'Презентация'
				} else {
					if (this.page === 'audio') return 'Audio'
					if (this.page === 'video') return 'Video'
					if (this.page === 'presentation') return 'Presentation'
				}
			},
		}))
	})
</script>

@endsection

@section('modals')
    @include('partials.admin.menu')

@endsection

@section('body-scripts')
@endsection
