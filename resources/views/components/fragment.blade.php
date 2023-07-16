@props([
	'number',
	'isPurple' => false,
])

<div class="item" x-data="fragment{{ $number }}" :class="activeFragment === number && 'is-active'">
    <div class="item__title @if ($isPurple) item__title--purple @endif">
		<span class="fragment">Фрагмент</span>
		<br>
		<span class="span-number">№ {{ $number }}</span>
	</div>
    <ul>
        <li>
            <button type="button" data-type="total"
				:class="active === `total` + number && 'is-active'"
				@click="activate"
			>
				<img src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="music"
				:class="active === `music` + number && 'is-active'"
				@click="activate"
			>
				<img src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="video"
				:class="active === `video` + number && 'is-active'"
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
			activate() {
				this.active = this.$el.dataset.type + this.number;
				this.activeFragment = this.number;
				this.activeType = this.$el.dataset.type;
			},
		}))
	})
</script>
