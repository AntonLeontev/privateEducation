@props([
	'number',
	'isPurple' => false,
])

<div 
	class="item" 
	x-data="fragment{{ $number }}" 
	:class="{
		'is-active': fragment == number 
			|| fragment === 'all'
	}"
>
    <div class="item__title @if ($isPurple) item__title--purple @endif">
		<span class="fragment">Фрагмент</span>
		<br>
		<span class="span-number">№ {{ $number }}</span>
	</div>

	
    <ul class="relative">
		<template x-if="popularFragments">
			<div class="absolute bottom-0 flex items-end w-full h-full bg-transparent">
				<div class="w-full h-full bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 1"></div>
				<div class="w-full h-[70%] bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 2"></div>
				<div class="w-full h-[45%] bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 3"></div>
				<div class="w-full h-1/4 bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 4"></div>
			</div>
		</template>

        <li>
            <button type="button" data-type="total"
				:class="{
					'is-active': (page === `sum` && fragment === 'all' && stats != 'pres' && stats != `metrics-pres`) ||
					(page === `sum` && fragment == number && stats != 'pres' && stats != `metrics-pres`),
				}"
				@click="activate('sum')"
			>
				<img src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="music"
				:class="{
					'is-active': (page === `audio` && fragment === 'all' && stats != 'pres' && stats != `metrics-pres`) ||
					(page === `audio` && fragment == number && stats != 'pres' && stats != `metrics-pres`),
				}"
				@click="activate('audio')"
			>
				<img src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="video"
				:class="{
					'is-active': (page === `video` && fragment === 'all' && stats != 'pres' && stats != `metrics-pres`) ||
					(page === `video` && fragment == number && stats != 'pres' && stats != `metrics-pres`),
				}"
				@click="activate('video')"
			>
				<img src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="presentation"
				:class="{
					'is-active': (stats === `pres` && fragment === 'all') ||
					(stats === `pres` && fragment == number) || 
					(stats === `metrics-pres` && fragment === 'all') || 
					(stats === `metrics-pres` && fragment == number),
				}"
				@click="activate('presentation')"
			>
				<img src="{{ Vite::asset('resources/images/icon4.png') }}" alt="">
			</button>
        </li>

		
    </ul>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('fragment{{ $number }}', () => ({
			number: {{ $number }},
			activate(icon) {
				this.$dispatch(
					'click-fragment', 
					{
						icon: icon,
						fragment: '{{ $number }}',
					}
				)
			},
			
		}))
	})
</script>
