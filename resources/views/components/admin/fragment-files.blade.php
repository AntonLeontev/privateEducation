@props([
	'number',
	'isPurple' => false,
])

<div 
	class="item" 
	x-data="fragment{{ $number }}" 
	:class="{
		'is-active': selectedFragment?.id == number
	}"
>
    <div class="item__title @if ($isPurple) item__title--purple @endif">
		<span class="fragment">Фрагмент</span>
		<br>
		<span class="span-number">№ {{ $number }}</span>
	</div>

	
    <ul class="relative">
        <li class="">
			<button type="button" data-type="total"
				@click="activate('text')"
			>
				<img src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="music"
				:class="{
					'is-active': page === `audio` && selectedFragment?.id == number,
				}"
				@click="activate('audio')"
			>
				<img src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="video"
				:class="{
					'is-active': page === `video` && selectedFragment?.id == number,
				}"
				@click="activate('video')"
			>
				<img src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="presentation"
				:class="{
					'is-active': page === `presentation` && selectedFragment?.id == number,
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
				let fragment = this.fragments.find(el => el.id === this.number)
				this.selectedFragment = fragment

				if (icon === 'text') {
					this.modalText = true;
					return
				}
				
				this.page = icon
				this.$dispatch('click-fragment')
			},
			
		}))
	})
</script>
