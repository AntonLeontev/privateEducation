@props([
	'number',
	'isPurple' => false,
])

<div 
	class="item" 
	x-data="fragment{{ $number }}" 
	:class="{
		'is-active': plaingFragment?.id == number
	}"
>
    <div class="item__title @if ($isPurple) item__title--purple @endif">
		<span class="fragment">Фрагмент</span>
		<br>
		<span class="span-number">№ {{ $number }}</span>
	</div>

	
    <ul class="relative">
        <li class="py-2">
			<button type="button" data-type="total"
				:class="{
					'is-active': page === `deactivation` && plaingFragment?.id == number,
				}"
				@click="activate('deactivation')"
			>
				<label class="swap" :class="fragments[{{ $number - 1 }}].is_active && 'swap-active'">
					<div class="swap-on">
						<svg class="swap-on" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-toggle-on" viewBox="0 0 16 16">
							<path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
							<circle cx="11" cy="8" r="4" fill="#E9742B"/>
						</svg>
					</div>
					<div class="swap-off">
						<svg class="rotate-180 swap-off" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="rotate-180" viewBox="0 0 16 16">
							<path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
							<circle cx="11" cy="8" r="4" fill="#7e6a96"/>
						</svg>
					</div>
				</label>
			</button>
        </li>
        <li>
            <button type="button" data-type="music"
				:class="{
					'is-active': page === `audio` && plaingFragment?.id == number,
				}"
				@click="activate('audio')"
			>
				<img src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="video"
				:class="{
					'is-active': page === `video` && plaingFragment?.id == number,
				}"
				@click="activate('video')"
			>
				<img src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
			</button>
        </li>
        <li>
            <button type="button" data-type="presentation"
				:class="{
					'is-active': page === `presentation` && plaingFragment?.id == number,
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
				
				if (!fragment.is_active && icon != 'deactivation') {
					return
				}

				this.selectedFragment = fragment
				this.modal = true
				this.page = icon
			},
			
		}))
	})
</script>
