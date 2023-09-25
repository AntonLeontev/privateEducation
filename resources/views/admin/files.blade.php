@extends('layouts.admin.index')

@section('title', 'Управление медиа файлами')

@section('content')
    <div class="w-full" x-data="container">
        <header class="relative z-10 my-4 header">
            <div class="container container-header">

                <div class="">Управление файлами</div>

                <div class="burger">
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
                <div class="grid grid-cols-11 grid-rows-1 mb-5">
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
                            <x-fragment :$number />
                        @endforeach
                    </div>
                </div>
                <div class="grid grid-cols-11 grid-rows-1 justify-items-center">
                    @foreach (range(7, 17) as $number)
                        <x-fragment :$number isPurple />
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
