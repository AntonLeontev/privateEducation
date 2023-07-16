@props([
	'user',
])

<div class="mb-2" x-data="user{{ $user->id }}">
	<div
		class="flex px-2 py-3 transition cursor-pointer rounded-xl opacity-60 hover:opacity-100 bg-white/20"
		:class="show && 'opacity-100'"
		@click="show = !show"
	>
		<div class="w-[15%] text-center">{{ $user->email }}</div>
		<div class="w-[10%] text-center">Россия</div>
		<div class="w-[10%] text-center">Москва</div>
		<div class="w-[20%] text-center">{{ random_int(1, 22) }}</div>
		<div class="w-[20%] text-center">{{ random_int(20, 50) }}</div>
		<div class="w-[20%] text-center">{{ random_int(30, 1200) }} €</div>
		<div class="w-[5%] text-center cursor-pointer">
			<svg :class="show && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
			</svg>
		</div>
	</div>
	<div x-cloak x-show="show" x-transition>
		<div class="px-5">
			@foreach (range(1, 17) as $item)
				<div class="flex justify-between py-1 transition gap-x-10 hover:bg-slate-100/10">
					<div class="flex items-center min-w-[150px] pl-2">Фрагмент №{{ $item }}</div>
					<div class="flex items-center gap-3 w-[10%]">
						<img class="w-[45px] h-[35px]" src="{{ Vite::asset('resources/images/icon4.png') }}" alt="Презентация">
						<div class="flex items-center gap-1" title="Количество просмотров пользователем">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							</svg>
							{{ random_int(1, 12) }}
						</div>
					</div>
					<div class="grid auto-cols-max grid-flow-col items-center gap-3 w-[30%]">
						<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="Аудио">
						<div class="flex items-center gap-1 min-w-[70px]" title="Количество прослушиваний пользователем">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							</svg>
							{{ random_int(1, 12) }}
						</div>
						<div class="flex items-center gap-1 min-w-[100px]" title="Сумма покупок">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
							</svg>
							{{ random_int(10, 120) }} €
						</div>
	
						@php($isActive = random_int(0, 1))
	
						<input type="checkbox" class="toggle toggle-primary" @if ($isActive) checked @endif />
						<div>
							@if ($isActive)
								до {{ now()->addDays(random_int(1, 30))->format('d.m.Y') }}
							@endif
						</div>
					</div>
					<div class="flex items-center gap-3 w-[30%]">
						<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="Видео">
						<div class="flex items-center gap-1 min-w-[70px]" title="Количество просмотров пользователем">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							</svg>
							{{ random_int(1, 12) }}
						</div>
						<div class="flex items-center gap-1 min-w-[100px]" title="Сумма покупок">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
								<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
							</svg>
							{{ random_int(10, 120) }} €
						</div>
	
						@php($isActive = random_int(0, 1))
	
						<input type="checkbox" class="toggle toggle-primary" @if ($isActive) checked @endif />
						<div>
							@if ($isActive)
								до {{ now()->addDays(random_int(1, 30))->format('d.m.Y') }}
							@endif
						</div>
					</div>
				</div>
				@endforeach
		</div>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('user{{ $user->id }}', () => ({
			show: false,
		}))
	})
</script>
