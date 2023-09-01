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
		<div class="absolute bottom-0 flex items-end w-full h-full bg-transparent">
			<div class="w-full h-full bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 1"></div>
			<div class="w-full h-[70%] bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 2"></div>
			<div class="w-full h-[45%] bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 3"></div>
			<div class="w-full h-1/4 bg-[#34476050]" x-show="popularFragments?.find(el => el.id === number)?.position === 4"></div>
		</div>

        <li>
            <button type="button" data-type="total"
				:class="{
					'is-active': (page === `sum` && fragment === 'all') ||
					(page === `sum` && fragment == number),
				}"
				@click="activate('sum')"
			>
				<img src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="music"
				:class="{
					'is-active': (page === `audio` && fragment === 'all') ||
					(page === `audio` && fragment == number),
				}"
				@click="activate('audio')"
			>
				<img src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="video"
				:class="{
					'is-active': (page === `video` && fragment === 'all') ||
					(page === `video` && fragment == number),
				}"
				@click="activate('video')"
			>
				<img src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="presentation"
				:class="{
					'is-active': (page === `presentation` && fragment === 'all') ||
					(page === `presentation` && fragment == number),
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
			totalClass: {
				'is-active': this.active === `total` + this.number ||
					this.activeType === 'all',
			},
			activate(page) {
				this.active = this.$el.dataset.type + this.number;
				this.activeFragment = this.number;
				this.activeType = this.$el.dataset.type;


				this.$dispatch(
					'state-change', 
					{
						page: page,
						fragment: '{{ $number }}',
						title: this.makeTitle(page) + ' фрагмента №{{ $number }}',
					}
				)
			},
			makeTitle(page) {
				if (this.stats === 'sails') {
					if (page === 'sum') return 'Суммарные продажи'
					if (page === 'audio') return 'Продажи аудио'
					if (page === 'video') return 'Продажи видео'
				} else if (this.stats === 'views') {
					if (page === 'sum') return 'Просмотры и прослушивания'
					if (page === 'audio') return 'Прослушивания аудио'
					if (page === 'video') return 'Просмотры видео'
				} else if (this.stats === 'metrics-sails') {
					if (page === 'sum') return 'График продаж'
					if (page === 'audio') return 'График продаж аудио'
					if (page === 'video') return 'График продаж видео'
				} else if (this.stats === 'metrics-views') {
					if (page === 'sum') return 'График просмотров и прослушиваний'
					if (page === 'audio') return 'График прослушиваний аудио'
					if (page === 'video') return 'График просмотров видео'
				} else {
					return '';
				}
			},
		}))
	})
</script>
