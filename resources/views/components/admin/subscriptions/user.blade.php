<div class="mb-2" x-data="{show: false}">
	<div
		class="flex px-2 py-3 transition cursor-pointer gap-x-1 rounded-xl opacity-60 hover:opacity-100 bg-white/20"
		:class="show && '!opacity-100'"
		@click="show = !show"
	>
		<div class="w-[5%] text-center" x-text="user.id" title="Порядковый номер"></div>
		<div class="w-[45%] text-center grow-0 shrink-0 overflow-hidden truncate" x-text="user.email"></div>
		<div class="w-[45%] text-center" x-text="user.name"></div>
		<div class="w-[5%] text-center cursor-pointer flex justify-center">
			<svg class="w-6 h-6 transition duration-500" :class="show && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
			</svg>
		</div>
	</div>
	<div class="grid grid-rows-[0fr] overflow-hidden transition-[grid-template-rows] duration-500" :class="show && 'grid-rows-[1fr]'">
		<div class="w-full overflow-hidden">
			<div class="mx-5 mt-2 mb-8 overflow-hidden rounded-xl bg-white/20">
				@foreach (range(1, 17) as $id)
					<div class="flex justify-start py-1 transition gap-x-1 hover:bg-slate-100/10">
						<div class="flex items-center min-w-[150px] pl-2">Фрагмент №{{ $id }}</div>
						<div class="grid items-center grid-flow-col gap-1 auto-cols-max min-w-[400px]">
							<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="Аудио">
		
							<div class="flex items-center gap-x-1">
								<template x-if="getSubscription(user, {{ $id }}, 'audio')">
									<div class="flex items-center gap-x-1">
										<input type="checkbox" class="toggle toggle-primary" checked />
										<span>до <span x-text="formatDate(getSubscription(user, {{ $id }}, 'audio').ends_at)"></span></span>
									</div>
								</template>
								<template x-if="!getSubscription(user, {{ $id }}, 'audio')">
									<input type="checkbox" class="toggle toggle-primary" />
								</template>
							</div>
						</div>
						<div class="flex items-center gap-1 min-w-[400px]">
							<img class="w-[35px] h-[35px]" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="Видео">
							<div class="flex items-center gap-x-1">
								<template x-if="getSubscription(user, {{ $id }}, 'video')">
									<div class="flex items-center gap-x-1">
										<input type="checkbox" class="toggle toggle-primary" checked />
										<span>до <span x-text="formatDate(getSubscription(user, {{ $id }}, 'video').ends_at)"></span></span>
									</div>
								</template>
								<template x-if="!getSubscription(user, {{ $id }}, 'video')">
									<input type="checkbox" class="toggle toggle-primary" />
								</template>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			
		</div>
	</div>
</div>
