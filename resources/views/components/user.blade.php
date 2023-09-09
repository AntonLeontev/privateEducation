@props([
	'user',
])

<div class="mb-2" x-data="user{{ $user->id }}">
	<div
		class="flex px-2 py-3 transition cursor-pointer gap-x-1 rounded-xl opacity-60 hover:opacity-100 bg-white/20"
		:class="show && '!opacity-100'"
		@click="show = !show"
	>
		<div class="w-[5%] text-center">{{ $user->id }}</div>
		<div class="w-[25%] text-center">{{ $user->email }}</div>
		<div class="w-[10%] text-center">Россия</div>
		<div class="w-[10%] text-center">Москва</div>
		<div class="w-[10%] text-center">{{ $user->active_subscriptions_count }}</div>
		<div class="w-[10%] text-center">{{ $user->subscriptions_count }}</div>
		<div class="w-[10%] text-center">{{ $user->subscriptions_sum_price }} €</div>
		<div class="w-[15%] text-center">{{ $user->last_sub->format('d.m.Y') }}</div>
		<div class="w-[15%] text-center">{{ $user->created_at->format('d.m.Y') }}</div>
		<div class="w-[5%] text-center cursor-pointer flex justify-center">
			<svg class="w-6 h-6 transition duration-500" :class="show && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
			</svg>
		</div>
	</div>
	<div class="grid grid-rows-[0fr] overflow-hidden transition-[grid-template-rows] duration-500" :class="show && 'grid-rows-[1fr]'">
		<div class="w-full overflow-hidden">
			<div class="mx-5 mt-8 mb-2 overflow-hidden rounded-xl bg-white/20">
				@foreach ($user->fragments as $id => $fragment)
					<div class="flex justify-start py-1 transition gap-x-1 hover:bg-slate-100/10">
						<div class="flex items-center min-w-[150px] pl-2">Фрагмент №{{ $id }}</div>
						<div class="flex items-center gap-3 min-w-[180px]">
							<img class="w-[45px] h-[35px]" src="{{ Vite::asset('resources/images/icon4.png') }}" alt="Презентация">
							<div class="flex items-center gap-1 min-w-[50px]" title="Количество просмотров видео презентации фрагмента №{{ $id }}">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
									<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
								</svg>
								{{ $fragment['presentation']['views'] }}
							</div>
							<div class="flex items-center gap-1" title="Количество прочтений текста презентации фрагмента  №{{ $id }}">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
									<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
								</svg>
								{{ $fragment['presentation']['readings'] }}
							</div>
						</div>
						<div class="grid items-center grid-flow-col gap-1 auto-cols-max min-w-[400px]">
							@if ($fragment['audio'] ?? false)
								<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="Аудио">
								<div class="flex items-center gap-1 min-w-[70px]" title="Количество прослушиваний аудио фрагмента  №{{ $id }}">
									<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" width="24px">
										<title/><g data-name="Layer 2" id="Layer_2"><path d="M16,4A14,14,0,0,0,2,18v9a1,1,0,0,0,1,1H9a1,1,0,0,0,1-1V19a1,1,0,0,0-1-1H4a12,12,0,0,1,24,0H23a1,1,0,0,0-1,1v8a1,1,0,0,0,1,1h6a1,1,0,0,0,1-1V18A14,14,0,0,0,16,4Z"/></g>
									</svg>
									{{ $fragment['audio']['views'] }}
								</div>
								<div class="flex items-center gap-1 min-w-[100px]" title="Сумма покупок аудио фрагмента  №{{ $id }}">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									{{ $fragment['audio']['sum_price'] }} €
								</div>
			
								@php
									$isActive = $fragment['audio']['ends_at'] > now();
								@endphp
			
								<input type="checkbox" class="toggle toggle-primary" @if ($isActive) checked title="Подписка на аудио активна до {{ $fragment['audio']['ends_at']->translatedFormat('d F Y') }}" @else title="Подписка на аудио не активна" @endif />
								<div>
									@if ($isActive)
										до {{ $fragment['audio']['ends_at']->format('d.m.Y') }}
									@endif
								</div>
							@endif
						</div>
						<div class="flex items-center gap-1 min-w-[400px]">
							@if ($fragment['video'] ?? false)
								<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="Видео">
								<div class="flex items-center gap-1 min-w-[70px]" title="Количество просмотров видео фрагмента  №{{ $id }}">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
									{{ $fragment['video']['views'] }}
								</div>
								<div class="flex items-center gap-1 min-w-[100px]" title="Сумма покупок видео фрагмента  №{{ $id }}">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M14.25 7.756a4.5 4.5 0 100 8.488M7.5 10.5h5.25m-5.25 3h5.25M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									{{ $fragment['video']['sum_price'] }} €
								</div>
			
								@php
									$isActive = $fragment['video']['ends_at'] > now();
								@endphp
			
								<input type="checkbox" class="toggle toggle-primary" @if ($isActive) checked title="Подписка на видео активна до {{ $fragment['video']['ends_at']->translatedFormat('d F Y') }}" @else title="Подписка на видео не активна" @endif />
								<div>
									@if ($isActive)
										до {{ $fragment['video']['ends_at']->format('d.m.Y') }}
									@endif
								</div>
							@endif
						</div>
					</div>
				@endforeach
			</div>
			
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
