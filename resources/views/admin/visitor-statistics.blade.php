@extends('layouts.admin.index')

@section('title', 'Статистика посетителей')

@section('content')
<div class="w-full" x-data="visitorStatistics">
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">Статистика посетителей</span>
			<form class="flex flex-wrap justify-between p-1 mb-2 gap-x-2 gap-y-2" x-ref="form">
				<select
					class="bg-transparent border cursor-pointer rounded-none px-1 py-2 text-[16px] font-bold focus:outline-none"
					name="period"
					x-model="period"
					@change="changePeriod"
					x-ref="select"
				>
					<option class="text-black" value="today">За сегодня на {{ now()->format('H:i') }}</option>
					<option class="text-black" value="yesterday">За вчера</option>
					<option class="text-black" value="week">За эту неделю</option>
					<option class="text-black" value="month">За этот месяц</option>
					<option class="text-black" value="quarter">За этот квартал</option>
					<option class="text-black" value="year">За этот год</option>
					<option class="text-black" value="custom">За произвольный период</option>
				</select>

				<label class="w-min text-[14px] flex gap-x-1 items-center">
					<input
						name="start"
						type="date"
						class="px-2 py-1 bg-transparent border border-t-0 rounded-none border-x-0 focus:outline-none disabled:text-[#bbb] disabled:border-[#bbb]"
						:disabled="period !== 'custom'"
						x-ref="start"
						@change="changePeriod"
					>
				</label>

				<span class="flex items-center" :class="period !== 'custom' && 'text-[#bbb]'">-</span>

				<label class="w-min text-[14px] flex gap-x-1 items-center">
					<input
						name="end"
						type="date"
						class="px-2 py-1 bg-transparent border border-t-0 rounded-none border-x-0 focus:outline-none disabled:text-[#bbb] disabled:border-[#bbb]"
						:disabled="period !== 'custom'"
						x-ref="end"
						@change="changePeriod"
					>
				</label>

				<select
					class="bg-transparent border cursor-pointer rounded-none px-1 py-2 text-[16px] font-bold focus:outline-none min-w-[12rem]"
					name="utm_source"
					x-model="utmSource"
					@change="changeUtm"
					x-ref="utmSelect"
				>
					<option class="text-black" value="">Все источники</option>
					<template x-for="opt in utmOptions" :key="opt.value">
						<option class="text-black" :value="opt.value" x-text="opt.label"></option>
					</template>
				</select>
			</form>
			<x-admin.menu-button />
		</div>
	</header>

	<div class="container">
		<span class="ml-1 loading loading-dots loading-sm" x-show="loadingFilter" x-cloak></span>

		<div class="relative w-full max-h-screen text-md mt-2">
			<h2 class="text-lg font-bold mb-2">Время по фрагментам</h2>
			<div class="text-lg text-black max-h-[40vh] overflow-y-auto border border-gray-300">
				<table class="w-full text-left border-collapse">
					<thead>
						<tr class="border-b bg-gray-100">
							<th class="p-2">Фрагмент</th>
							<th class="p-2">Активно</th>
							<th class="p-2">Пассивно</th>
						</tr>
					</thead>
					<tbody>
						<template x-if="fragments.length === 0">
							<tr><td class="p-2 text-gray-500" colspan="3">Нет данных за выбранный период</td></tr>
						</template>
						<template x-for="row in fragments" :key="row.fragment_id">
							<tr class="border-b">
								<td class="p-2" x-text="row.fragment_id"></td>
								<td class="p-2" x-text="formatDuration(row.active_seconds)"></td>
								<td class="p-2" x-text="formatDuration(row.passive_seconds)"></td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>

			<h2 class="text-lg font-bold mb-2 mt-6">Визиты по UTM source</h2>
			<div class="text-lg text-black max-h-[40vh] overflow-y-auto border border-gray-300">
				<table class="w-full text-left border-collapse">
					<thead>
						<tr class="border-b bg-gray-100">
							<th class="p-2">Источник</th>
							<th class="p-2">Визитов</th>
						</tr>
					</thead>
					<tbody>
						<template x-if="utmBreakdown.length === 0">
							<tr><td class="p-2 text-gray-500" colspan="2">Нет данных за выбранный период</td></tr>
						</template>
						<template x-for="row in utmBreakdown" :key="row.value">
							<tr class="border-b">
								<td class="p-2" x-text="row.label"></td>
								<td class="p-2" x-text="row.visits_count"></td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('visitorStatistics', () => ({
			fragments: [],
			utmBreakdown: [],
			utmOptions: [],
			period: 'today',
			utmSource: '',
			loadingFilter: false,

			formatDuration(totalSeconds) {
				const s = Math.max(0, parseInt(totalSeconds, 10) || 0);
				const h = Math.floor(s / 3600);
				const m = Math.floor((s % 3600) / 60);
				const sec = s % 60;
				const pad = (n) => String(n).padStart(2, '0');
				return `${h}:${pad(m)}:${pad(sec)}`;
			},

			init() {
				this.update();
			},

			changePeriod() {
				this.period = this.$refs.select.value;

				if (this.period === 'custom' && (this.$refs.start.value === '' || this.$refs.end.value === '')) {
					return;
				}

				this.update();
			},

			changeUtm() {
				this.utmSource = this.$refs.utmSelect.value;
				this.update();
			},

			update() {
				this.loadingFilter = true;

				const params = {
					period: this.period,
					start: this.$refs.start.value,
					end: this.$refs.end.value,
				};
				if (this.utmSource !== '') {
					params.utm_source = this.utmSource;
				}

				axios
					.get(route('admin.visitor-statistics'), { params })
					.then(response => {
						this.fragments = response.data.fragments || [];
						this.utmBreakdown = response.data.utm_breakdown || [];
						this.utmOptions = response.data.utm_options || [];
						const applied = response.data.filters_applied?.utm_source;
						this.utmSource = applied == null ? '' : applied;
					})
					.catch(() => {
						alert('Ошибка. Перезагрузите страницу');
					})
					.finally(() => {
						this.loadingFilter = false;
					});
			},
		}));
	});
</script>
@endsection

@section('modals')
	@include('partials.admin.menu')
@endsection
