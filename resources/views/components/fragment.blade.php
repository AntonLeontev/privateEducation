@props([
	'number',
	'isPurple' => false,
])

<div 
	class="item" 
	x-data="fragment{{ $number }}" 
	:class="{
		'is-active': activeFragment === number 
			|| activeType === 'all'
			|| activeType === 'all-video'
			|| activeType === 'all-audio',
	}"
	:class="activeFragment === number && 'is-active'"
>
    <div class="item__title @if ($isPurple) item__title--purple @endif">
		<span class="fragment">Фрагмент</span>
		<br>
		<span class="span-number">№ {{ $number }}</span>
	</div>
    <ul>
        <li>
            <button type="button" data-type="total"
				:class="{
					'is-active': active === `total` + number ||
						activeType === 'all',
				}"
				@click="activate"
			>
				<img src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="music"
				:class="{
					'is-active': active === `music` + number ||
						activeType === 'all-audio',
				}"
				@click="activate"
			>
				<img src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="video"
				:class="{
					'is-active': active === `video` + number ||
						activeType === 'all-video',
				}"
				@click="activate"
			>
				<img src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="presentation"
				:class="active === `presentation` + number && 'is-active'"
				@click="activate"
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
			activate() {
				this.active = this.$el.dataset.type + this.number;
				this.activeFragment = this.number;
				this.activeType = this.$el.dataset.type;
			},
		}))
	})
</script>
