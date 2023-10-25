@extends('layouts.admin.index')

@section('title', 'Деактивация фрагментов')

@section('content')
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">
				Деактивация фрагментов
			</span>
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

	<div class="container">
		<div class="w-full" x-data="fragments">
			<div class="text-lg text-black max-h-[calc(100vh-82px)] overflow-y-auto pb-2 flex flex-col gap-1">
				<template x-for="fragment in fragments">
					<div class="flex items-center justify-between px-2 py-3 transition gap-x-3 rounded-xl bg-white/20">
						<div class="w-28" x-text="fragment.title_ru"></div>
						<div class="flex items-center gap-2 min-w-[450px]" x-data="{
							active: fragment.audio.is_active,
							savedShow: false,

							saveAudio(id) {
								if (this.$event.target.value == '') {
									return;
								}
								
								let data = new FormData(this.$event.target.closest('form')); 
								
								axios
									.post(route('admin.audio.update', id), data)
									.then(response => {
										this.savedShow = true;
										setTimeout(() => this.savedShow = false, 600)
									})
							},
						}">
							<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="Аудио">
							<form class="flex items-center">
								<label class="swap">
  
									<!-- this hidden checkbox controls the state -->
									<input type="checkbox" :checked="active" @change="saveAudio(fragment.id)" />
									
									<!-- volume on icon -->
									<svg class="swap-on" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
										<path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
										<circle cx="11" cy="8" r="4" fill="#E9742B"/>
									</svg>
									
									<!-- volume off icon -->
									<svg class="rotate-180 swap-off" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="rotate-180" viewBox="0 0 16 16">
										<path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
										<circle cx="11" cy="8" r="4" fill="#7e6a96"/>
									</svg>
									
								</label>
							</form>
							<div class="w-[32px] h-[32px]">
								<div class="p-1 transition bg-green-500 rounded-full" x-show="savedShow" x-transition.opacity.duration.600ms>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
								</div>
							</div>
						</div>

						<div class="flex items-center gap-2 min-w-[450px]" x-data="{
							active: fragment.video.is_active,
							savedShow: false,

							saveVideo(id) {
								if (this.$event.target.value == '') {
									return;
								}
								
								let data = new FormData(this.$event.target.closest('form')); 
								
								axios
									.post(route('admin.video.update.price', id), data)
									.then(response => {
										this.savedShow = true;
										setTimeout(() => this.savedShow = false, 600)
									})
							},
						}">
							<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="Видео">
							<span>€</span>
							<form>
								<input 
									class="w-16 p-1 text-center bg-transparent border border-t-0 border-black border-x-0 focus:outline-none focus-visible:outline-none" 
									name="price" 
									x-model="euro" 
									@input.debounce.750ms="saveVideo(fragment.id)"
								>
								<input type="hidden" name="usd" :value="roundNumber(euro * rates.usd)">
								<input type="hidden" name="rub" :value="roundNumber(euro * rates.rub)">
							</form>
							<div class="w-[32px] h-[32px]">
								<div class="p-1 transition bg-green-500 rounded-full" x-show="savedShow" x-transition.opacity.duration.600ms>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
								</div>
							</div>
							<span class="w-32" x-text="'$ ' + format(euro * rates.usd)"></span>
							<span class="w-32" x-text="'₽ ' + format(euro * rates.rub)"></span>
						</div>

					</div>
				</template>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('fragments', () => ({
				fragments: @json($fragments),

				format(number) {
					return number.toLocaleString(
						undefined, 
						{ maximumFractionDigits: 2 }
					)
				},
				roundNumber(number) {
					let multiple = Math.pow(10, 2);
					return Math.round(number * multiple) / multiple;
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
