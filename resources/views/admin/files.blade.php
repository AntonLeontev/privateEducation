@extends('layouts.admin.index')

@section('title', 'Управление медиа файлами')

@section('content')
    <div class="w-full" x-data="container">
		<header class="my-3 header">
			<div class="container container-header">
				<span class="!mb-0 mr-10 player__title__bg">
					Контент
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
				class="content hidden-md visible-sm" 
				x-data="fragments" 
                @click-fragment="fragmentClick"
			>
                <div class="grid grid-cols-11 grid-rows-1 mb-2">
                    <div class="col-span-5 player">
                        <div class="h-full">
                            <div class="flex justify-between player__title align-center">
                                <div class="flex items-center gap-x-2 bg-[rgba(146,140,141,0.7)] pr-2 w-full">
                                    <img class="h-[45px]" :src="image" alt="">
                                    <div class="flex w-full flex-col justify-center h-[calc(1.3vw*1.15*2+0.96vw)] text-[1.2vw] leading-none pl-1 overflow-hidden">
										<div x-text="title">Видео</div>
										<div x-text="lang === 'ru' ? 'Фрагмент №' + selectedFragment?.id : 'Fragment №' + selectedFragment?.id">Фрагмент №1</div>
										<div 
											class="relative w-full" 
											x-data="runningLine" 
											x-ref="lineWrap"
											@click-fragment.window="reset"
											@change-lang.window="reset"
										>
											<div class="relative right-0 transition ease-linear whitespace-nowrap w-max" x-text="lang === 'ru' ? selectedFragment?.title_ru : selectedFragment?.title_en" x-ref="line"></div>
										</div>
										<script>
											document.addEventListener('alpine:init', () => {
												Alpine.data('runningLine', () => ({
													shift: null,
													timerId: null,

													init() {
														this.$nextTick(() => {
															this.shift = this.$refs.lineWrap.offsetWidth - this.$refs.line.offsetWidth
															this.timerId = setTimeout(() => this.moveLeft(), 500)
														})
													},
													reset() {
														clearTimeout(this.timerId);

														this.$refs.line.classList.remove('transition')
														this.$refs.line.classList.remove('ease-linear')
														this.$refs.line.style.transitionDuration = '0s'
														this.$refs.line.style.transform = `translateX(0px)`
														
														
														this.$nextTick(() => {
															this.$refs.line.classList.add('transition')
															this.$refs.line.classList.add('ease-linear')
															this.shift = this.$refs.lineWrap.offsetWidth - this.$refs.line.offsetWidth
															this.moveLeft()
														})
														
													},
													moveLeft() {
														this.timerId = setTimeout(() => {
															if (this.shift >= 0) return

															this.$refs.line.style.transitionDuration = Math.abs(this.shift) * 10 + 'ms'
															this.$refs.line.style.transform = `translateX(${this.shift}px)`

															this.$refs.line.ontransitionend = () => {
																this.moveRight()
															}
														}, 500)
													},
													moveRight() {
														this.timerId = setTimeout(() => {
															if (this.shift >= 0) return

															this.$refs.line.style.transform = `translateX(1px)`

															this.$refs.line.ontransitionend = () => {
																this.moveLeft()
															}
														}, 500)
													},
												}))
											})
										</script>
									</div>
                                </div>
                            </div>

							@include('admin.media-video')

                        </div>
                    </div>
                    <div class="grid grid-cols-6 col-span-6 justify-items-center">
                        @foreach (range(1, 6) as $number)
                            <x-admin.fragment-files :$number />
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-11 grid-rows-1 justify-items-center">
                    @foreach (range(7, 17) as $number)
                        <x-admin.fragment-files :$number isPurple />
                    @endforeach
                </div>

				<div class="fixed top-0 bottom-0 left-0 right-0" x-show="modalText"></div>
				<div 
					class="z-50 auth-modal modal-content modal-content_audio" 
					x-show="modalText"
					@keydown.esc.window="modalText = false"
					style="display: none"
				>
					<div class="modal-content__header">
						<span class="modal-header-text" x-text="`Текст презентации фрагмента №${selectedFragment?.id}`"></span>
						<button class="myBtn modal-content__close-btn" @click="modalText = false"></button>
					</div>
					<div class="justify-center modal-content__body">
						<div class="w-full h-full pb-5">
							<form class="flex flex-col h-full active:outline-none gap-y-2" @submit.prevent="updatePresentationText">
								<textarea 
									class="h-full p-1 text-black resize-none rounded-xl" 
									:name="lang === 'ru' ? 'text_ru' : 'text_en'" 
									:value="lang === 'ru' ? selectedFragment.presentation.text_ru : selectedFragment.presentation.text_en"
								></textarea>
								<button class="myBtn action-btn auth-modal__login-btn">СОХРАНИТЬ</button>
							</form>
						</div>
					</div>
				</div>

            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('fragments', () => ({
						fragments: @json($fragments),
                        page: 'audio', // ['audio', 'video', 'presentation']
                        selectedFragment: null,
                        title: 'Загрузка аудио файлов',
						progressbar: false,
						progress: 0,
						modalText: false,

						init() {
							this.selectedFragment = this.fragments[0]
						},
                        image() {
                            if (this.page === 'presentation') {
                                return "{{ Vite::asset('resources/images/icon4.png') }}";
                            }
                            if (this.page === 'audio') {
                                return "{{ Vite::asset('resources/images/icon2.png') }}";
                            }
                            if (this.page === 'text') {
                                return "{{ Vite::asset('resources/images/icon1.png') }}";
                            }
                            if (this.page === 'video') {
                                return "{{ Vite::asset('resources/images/icon3.png') }}";
                            }
                        },
                        fragmentClick() {
							if (this.$event.detail === 'text') return;
							
                            this.title = this.makeTitle();
                        },
						makeTitle() {
							if (this.lang === 'ru') {
								if (this.page === 'audio') return 'Загрузка аудио файлов'
								if (this.page === 'video') return 'Загрузка видео файлов'
								if (this.page === 'presentation') return 'Загрузка файлов презентаций'
							} else {
								if (this.page === 'audio') return 'Upload audio files'
								if (this.page === 'video') return 'Upload video files'
								if (this.page === 'presentation') return 'Upload presentation files'
							}
						},
						updatePresentationText() {
							axios
								.postForm(
									route('admin.presentations.update', this.selectedFragment.id),
									this.$event.target
								)
								.then(response => {
									this.selectedFragment.presentation = response.data
								})
								.catch(error => alert('Ошибка сохранения'))
								.finally(() => {
									this.modalText = false
								})
								
						},
					}))
                })
            </script>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('container', () => ({
				lang: 'ru',
            }))
        })
    </script>

@endsection

@section('modals')
    @include('partials.admin.modal')

    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection

@section('body-scripts')

@endsection
