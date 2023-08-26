@extends('layouts.admin.index')

@section('title', 'Admin panel')

@section('content')
<div class="w-full" x-data="container">
	<header class="relative z-10 my-4 header">
		<div class="container container-header">
			
			<x-admin.menu />

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
			@submenu.window="submenu"
			@period-change="periodChange"
		>
            <div class="grid grid-cols-11 grid-rows-1 mb-5">
                <div class="col-span-5 player">
                    <div class="h-full">
                        <div class="flex justify-between player__title align-center">
							<div class="flex items-center gap-x-2 bg-[rgba(146,140,141,0.7)] pr-2">
								<img class="h-[45px]" :src="image" alt="">
								<span class="text-[150%]" x-text="title">
									Презентация. Фрагмент №1
								</span>
							</div>
                        </div>
						
						<div class="h-[calc(100%-45px)]" x-show="stats === 'sails'">
							@include('partials.admin.stats.sails')
						</div>

						<div class="h-[calc(100%-45px)]" x-show="stats === 'views'">
							@include('partials.admin.stats.views')
						</div>

						<div class="h-[calc(100%-45px)]" x-show="stats === 'metrics-sails'">
							@include('partials.admin.stats.metrics-sails')
						</div>

						<div class="h-[calc(100%-45px)]" x-show="stats === 'metrics-views'">
							@include('partials.admin.stats.metrics-views')
						</div>

						<div class="h-[calc(100%-45px)]" x-show="stats === 'geo'">
							@include('partials.admin.stats.geo')
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
					stats: 'geo', // ['sails', 'views', 'metrics-sails', 'metrics-views', 'geo']
					page: 'sum', // ['sum', 'audio', 'video', 'presentation']
					fragment: 'all', // ['all', 'fragment id']
					title: 'Суммарные продажи',
					period: 'today',
					start: null,
					end: null,
					popularFragments: @json($fragments),

					init() {
						this.$watch('page', value => this.changePage(value));
					},
					image() {
						if (this.page === 'metrics') {
							return "{{ Vite::asset('resources/images/icon5.png') }}";
						} 
						if (this.page === 'geo') {
							return "{{ Vite::asset('resources/images/icon5.png') }}";
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
					submenu() {
						this.stats = this.$event.detail.stats;
						this.page = this.$event.detail.page;
						this.fragment = this.$event.detail.fragment;
						this.title = this.$event.detail.title;
					},
					periodChange(options) {
						this.start = options.detail.start;
						this.end = options.detail.end;
						this.period = options.detail.period;

						this.updatePopularFragments();
					},
					changePage(page) {
						if (this.stats != 'sails') return;

						this.updatePopularFragments();
					},
					updatePopularFragments() {
						axios
							.get(route('admin.popular-fragments'), {
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
					}
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
