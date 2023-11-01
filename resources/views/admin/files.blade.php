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
				class="content hidden-md visible-sm" 
				x-data="fragments" 
                @click-fragment="fragmentClick"
			>
                <div class="grid grid-cols-11 grid-rows-1 mb-2">
                    <div class="col-span-5 player">
                        <div class="h-full">
                            <div class="flex justify-between player__title align-center">
                                <div class="flex items-center gap-x-2 bg-[rgba(146,140,141,0.7)] pr-2">
                                    <img class="h-[45px]" :src="image" alt="">
                                    <span class="text-[150%]" x-text="title">
                                        Title
                                    </span>
                                </div>
                            </div>

							<div x-show="page === 'video'">
								@include('admin.media-video')
							</div>
							<div x-show="page === 'audio'">
								@include('admin.media-audio')
							</div>
							<div x-show="page === 'presentation'">
								@include('admin.media-video')
							</div>

                        </div>
                    </div>
                    <div class="grid grid-cols-6 col-span-6 justify-items-center">
                        @foreach (range(1, 6) as $number)
                            <x-admin.fragment :$number />
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-11 grid-rows-1 justify-items-center">
                    @foreach (range(7, 17) as $number)
                        <x-admin.fragment :$number isPurple />
                    @endforeach
                </div>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('fragments', () => ({
                        stats: 'files', // ['files']
                        page: 'audio', // ['sum', 'audio', 'video', 'pres']
                        fragment: '1', // ['all', 'fragment id']
                        title: 'Аудио файлы фрагмента №1',
						popularFragments: false,

                        image() {
                            if (this.page === 'presentation') {
                                return "{{ Vite::asset('resources/images/icon4.png') }}";
                            }
                            if (this.page === 'audio') {
                                return "{{ Vite::asset('resources/images/icon2.png') }}";
                            }
                            if (this.page === 'sum') {
                                return "{{ Vite::asset('resources/images/icon1.png') }}";
                            }
                            if (this.page === 'video') {
                                return "{{ Vite::asset('resources/images/icon3.png') }}";
                            }
                        },
                        fragmentClick() {
							if (this.$event.detail.icon === 'sum') return;
							
                            this.fragment = this.$event.detail.fragment ?? this.fragment;
                            this.page = this.$event.detail.icon ?? this.page;
                            this.title = this.makeTitle() + ` фрагмента №${this.fragment}`;

                        },
						makeTitle() {
							if (this.stats === 'files') {
								if (this.page === 'sum') return this.title
								if (this.page === 'audio') return 'Аудио файлы'
								if (this.page === 'video') return 'Видео файлы'
								if (this.page === 'presentation') return 'Файлы презентаций'
							} else {
								return '';
							}
						},
					}))
                })
            </script>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('container', () => ({
                modal: false,
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
