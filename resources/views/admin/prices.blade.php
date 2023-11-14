@extends('layouts.admin.index')

@section('title', 'Цены')

@section('content')
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">
				Цены
			</span>
			<div class="flex gap-8">
				<div class="font-bold">Курс валюты:</div>
				<div class="flex gap-1" title="Данные за {{ $usd->date->format('d.m.Y') }}. Обновлено {{ $usd->updated_at->diffForHumans() }}">
					<span class="text-secondary">EUR 1 = </span>USD {{ $usd->rate }}
				</div>
				<div class="flex gap-1" title="Данные за {{ $rub->date->format('d.m.Y') }}. Обновлено {{ $rub->updated_at->diffForHumans() }}">
					<span class="text-secondary">EUR 1 = </span>RUB {{ $rub->rate }}
				</div>
			</div>
			<x-admin.menu-button />
		</div>
	</header>

	<div class="container">
		<div class="w-full" x-data="prices">
			<div class="text-lg text-black max-h-[calc(100vh-82px)] overflow-y-auto pb-2 flex flex-col gap-1">
				<template x-for="fragment in fragments">
					<div class="flex items-center justify-between px-2 py-3 transition gap-x-3 rounded-xl bg-white/20">
						<div class="w-28" :class="fragment.id < 7 ? 'text-[#8f6143]' : 'text-secondary'" x-text="'Фрагмент ' + fragment.id"></div>
						<div class="flex items-center gap-2 min-w-[450px]" x-data="{
							euro: fragment.audio.price,
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
							<img class="w-auto h-[35px] opacity-40" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="Аудио">
							<span class="text-secondary">€</span>
							<form>
								<input 
									class="w-16 p-1 text-center bg-transparent border border-t-0 text-secondary border-secondary border-x-0 focus:outline-none focus-visible:outline-none" 
									name="price" x-model="euro" 
									@input.debounce.750ms="saveAudio(fragment.id)"
								>
							</form>
							<div class="w-[32px] h-[32px]">
								<div class="p-1 transition bg-green-500 rounded-full" x-show="savedShow" x-transition.opacity.duration.600ms>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
								</div>
							</div>
							<div class="flex w-[250px] overflow-hidden bg-white text-primary rounded-xl">
								<span class="w-[44%] py-1 pl-5" x-text="'$ ' + format(euro * usd.rate)"></span>
								<span 
									class="w-[56%] py-1 pr-5 text-right text-white bg-primary" 
									style="clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%);"
									x-text="'₽ ' + format(euro * rub.rate)"
								></span>
							</div>
						</div>

						<div class="flex items-center gap-2 min-w-[450px]" x-data="{
							euro: fragment.video.price,
							savedShow: false,

							saveVideo(id) {
								if (this.$event.target.value == '') {
									return;
								}
								
								let data = new FormData(this.$event.target.closest('form')); 
								
								axios
									.post(route('admin.video.update', id), data)
									.then(response => {
										this.savedShow = true;
										setTimeout(() => this.savedShow = false, 600)
									})
							},
						}">
							<img class="w-auto h-[35px] opacity-40" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="Видео">
							<span class="text-secondary">€</span>
							<form>
								<input 
									class="w-16 p-1 text-center bg-transparent border border-t-0 text-secondary border-secondary border-x-0 focus:outline-none focus-visible:outline-none" 
									name="price" 
									x-model="euro" 
									@input.debounce.750ms="saveVideo(fragment.id)"
								>
							</form>
							<div class="w-[32px] h-[32px]">
								<div class="p-1 transition bg-green-500 rounded-full" x-show="savedShow" x-transition.opacity.duration.600ms>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
								</div>
							</div>
							<div class="flex w-[250px] overflow-hidden bg-white text-primary rounded-xl">
								<span class="w-[44%] py-1 pl-5" x-text="'$ ' + format(euro * usd.rate)"></span>
								<span 
									class="w-[56%] py-1 pr-5 text-right text-white bg-primary" 
									style="clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%);"
									x-text="'₽ ' + format(euro * rub.rate)"
								></span>
							</div>
						</div>

					</div>
				</template>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('prices', () => ({
				fragments: @json($fragments),
				usd: @json($usd),
				rub: @json($rub),

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
