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
            <div class="content hidden-md visible-sm" x-data="fragments" @state-change.window="stateChange"
                @period-change="periodChange">
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

                            <div class="">
                                <div class="mb-1 text-lg">Стерео звук</div>

                                <div class="flex justify-around gap-x-10">
                                    <div class="">
                                        <div class="">Для десктопа</div>


                                        <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                                            @click="$refs.file.click()">
                                            <input type="file" name="" class="hidden" x-ref="file"
                                                accept="video/*">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900"
                                                width="40">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <button>
                                                Сменить
                                            </button>
                                        </div>
                                    </div>

                                    <div class="">
                                        <div class="">Для планшета</div>

                                        <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                                            @click="$refs.file.click()">
                                            <input type="file" name="" class="hidden" x-ref="file"
                                                accept="video/*">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#bb0000"
                                                width="40">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <button>
                                                Загрузить
                                            </button>
                                        </div>

                                    </div>

                                    <div class="">
                                        <div class="">Для телефона</div>

                                        <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                                            @click="$refs.file.click()">
                                            <input type="file" name="" class="hidden" x-ref="file"
                                                accept="video/*">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900"
                                                width="40">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <button>
                                                Сменить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2">
                                <div class="mb-1 text-lg">Моно звук</div>

                                <div class="flex justify-around gap-x-10">
                                    <div class="">
                                        <div class="">Для десктопа</div>


                                        <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                                            @click="$refs.file.click()">
                                            <input type="file" name="" class="hidden" x-ref="file"
                                                accept="video/*">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900"
                                                width="40">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <button>
                                                Сменить
                                            </button>
                                        </div>
                                    </div>

                                    <div class="">
                                        <div class="">Для планшета</div>

                                        <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                                            @click="$refs.file.click()">
                                            <input type="file" name="" class="hidden" x-ref="file"
                                                accept="video/*">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#bb0000"
                                                width="40">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <button>
                                                Загрузить
                                            </button>
                                        </div>

                                    </div>

                                    <div class="">
                                        <div class="">Для телефона</div>

                                        <div class="flex flex-col items-center cursor-pointer" x-data="{}"
                                            @click="$refs.file.click()">
                                            <input type="file" name="" class="hidden" x-ref="file"
                                                accept="video/*">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#009900"
                                                width="40">
                                                <path fill-rule="evenodd"
                                                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <button>
                                                Сменить
                                            </button>
                                        </div>
                                    </div>
                                </div>

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
                        page: 'sum', // ['sum', 'audio', 'video', 'pres']
                        fragment: 'all', // ['all', 'fragment id']
                        title: 'Аудио фрагмента 1',
                        period: 'today',
                        start: null,
                        end: null,
                        popularFragments: @json($fragments),

                        init() {
                            this.$watch('stats', value => this.updatePopularFragments());
                            this.$watch('page', value => this.updatePopularFragments());
                        },
                        image() {
                            if (this.stats === 'metrics-pres' || this.stats === 'pres') {
                                return "{{ Vite::asset('resources/images/icon4.png') }}";
                            }
                            if (this.stats === 'geo') {
                                return "{{ Vite::asset('resources/images/icon6.png') }}";
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
                        stateChange() {
                            this.page = this.$event.detail.page ?? this.page;
                            this.fragment = this.$event.detail.fragment ?? this.fragment;
                            this.title = this.makeTitle();

                            this.$nextTick(() => {
                                if (this.$event.detail.stats === 'geo') {
                                    this.$dispatch('geo-full');
                                }
                            })

                        },
                        updatePopularFragments() {
                            if (this.fragment != 'all') {
                                this.popularFragments = null;
                                return;
                            }

                            if (this.stats !== 'views' && this.stats !== 'sails' && this.stats !== 'pres') {
                                this.popularFragments = null;
                                return
                            }

                            let url;
                            if (this.stats === 'sails') url = route('admin.sales.popular-fragments');
                            if (this.stats === 'views') url = route('admin.views.popular-fragments');
                            if (this.stats === 'pres') url = route('admin.pres.popular-fragments');

                            axios
                                .get(url, {
                                    params: {
                                        period: this.period,
                                        start: this.start,
                                        end: this.end,
                                        content: this.page,
                                    },
                                })
                                .then(response => {
                                    this.popularFragments = response.data;
                                })
                        },
						makeTitle() {
							if (this.stats === 'files') {
								if (this.page === 'sum') return 'Суммарные продажи'
								if (this.page === 'audio') return 'Медиа файлы аудио'
								if (this.page === 'video') return 'Медиа файлы видео'
								if (this.page === 'pres') return 'Медиа файлы презентаций'
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
