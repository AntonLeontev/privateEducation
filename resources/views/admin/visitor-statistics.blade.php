@extends('layouts.admin.index')

@section('title', 'Статистика посетителей')

@section('content')
<div class="w-full" x-data="visitorStatistics">
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">Статистика посетителей</span>
			<form class="flex justify-between p-1 mb-2 gap-x-2 flex-wrap gap-y-2" x-ref="form">
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
		<div class="relative w-full max-h-screen text-md">
			<div class="text-lg text-black max-h-[calc(100vh-91px-58px)] overflow-y-auto space-y-6">
				<section>
					<div class="text-sm opacity-60 mb-2">Просмотры по секундам</div>
					<div class="overflow-hidden rounded-xl bg-white/20 mb-6">
						<div class="p-4 text-secondary">
							<div class="flex flex-wrap gap-3 items-center mb-2">
								<select
									class="bg-transparent border cursor-pointer rounded-none px-1 py-1 text-sm font-bold focus:outline-none"
									x-model.number="timelineFragmentId"
									@change="update"
								>
									<template x-for="n in 17" :key="n">
										<option class="text-black" :value="n" x-text="'Фрагмент ' + n"></option>
									</template>
								</select>
								<span class="loading loading-dots loading-sm" x-show="loadingFilter" x-cloak></span>
							</div>
							<template x-if="timeline">
								<div class="grid gap-2">
									<div class="flex flex-row flex-wrap gap-y-2 gap-x-4 items-center px-3 py-2 rounded-lg bg-white/10 lg:flex-nowrap">
										<div class="text-sm font-bold shrink-0" x-text="'Фрагмент №' + timelineFragmentId"></div>
										<div class="text-sm shrink-0">Пассивный просмотр:</div>
										<div id="stats-chart-passive" class="flex-1 min-w-[120px] h-[4.5rem] rounded bg-black/20 overflow-visible"></div>
										<div class="text-sm shrink-0">Активный просмотр:</div>
										<div id="stats-chart-active" class="flex-1 min-w-[120px] h-[4.5rem] rounded bg-black/20 overflow-visible"></div>
									</div>
								</div>
							</template>
							<template x-if="!timeline">
								<div class="px-3 py-2 rounded-lg bg-white/10 text-sm">Нет данных за выбранный период</div>
							</template>
						</div>
					</div>
				</section>

				<section>
					<div class="flex gap-2 items-center mb-2">
						<span class="text-sm opacity-60">Время по фрагментам</span>
						<span class="loading loading-dots loading-sm" x-show="loadingFilter" x-cloak></span>
					</div>
					<div class="overflow-hidden rounded-xl bg-white/20">
						<div class="p-4 text-secondary">
							<template x-if="fragments.length === 0">
								<div class="px-3 py-2 rounded-lg bg-white/10 text-sm">Нет данных за выбранный период</div>
							</template>
							<template x-if="fragments.length > 0">
								<div class="grid gap-2">
									<div class="flex flex-wrap gap-x-6 gap-y-1 px-3 py-2 rounded-lg bg-white/10 text-sm font-bold">
										<div class="min-w-[6rem] flex-1">Фрагмент</div>
										<div class="min-w-[5rem]">Активно</div>
										<div class="min-w-[5rem]">Пассивно</div>
									</div>
									<template x-for="row in fragments" :key="row.fragment_id">
										<div class="flex flex-wrap gap-x-6 gap-y-1 px-3 py-2 rounded-lg bg-white/10 text-sm">
											<div class="min-w-[6rem] flex-1 font-bold" x-text="row.fragment_id"></div>
											<div class="min-w-[5rem]" x-text="formatDuration(row.active_seconds)"></div>
											<div class="min-w-[5rem]" x-text="formatDuration(row.passive_seconds)"></div>
										</div>
									</template>
								</div>
							</template>
						</div>
					</div>
				</section>

				<section>
					<div class="text-sm opacity-60 mb-2">Визиты по UTM source</div>
					<div class="overflow-hidden rounded-xl bg-white/20">
						<div class="p-4 text-secondary">
							<template x-if="utmBreakdown.length === 0">
								<div class="px-3 py-2 rounded-lg bg-white/10 text-sm">Нет данных за выбранный период</div>
							</template>
							<template x-if="utmBreakdown.length > 0">
								<div class="grid gap-2">
									<div class="flex flex-wrap gap-x-6 gap-y-1 px-3 py-2 rounded-lg bg-white/10 text-sm font-bold">
										<div class="min-w-[8rem] flex-1">Источник</div>
										<div class="min-w-[5rem]">Визитов</div>
									</div>
									<template x-for="row in utmBreakdown" :key="row.value">
										<div class="flex flex-wrap gap-x-6 gap-y-1 px-3 py-2 rounded-lg bg-white/10 text-sm">
											<div class="min-w-[8rem] flex-1 break-all" x-text="row.label"></div>
											<div class="min-w-[5rem] font-bold" x-text="row.visits_count"></div>
										</div>
									</template>
								</div>
							</template>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('visitorStatistics', () => ({
			fragments: [],
			timeline: null,
			timelineFragmentId: 1,
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
					fragment_id: this.timelineFragmentId,
				};
				if (this.utmSource !== '') {
					params.utm_source = this.utmSource;
				}

				axios
					.get(route('admin.visitor-statistics'), { params })
					.then(response => {
						this.fragments = response.data.fragments || [];
						this.timeline = response.data.timeline || null;
						this.utmBreakdown = response.data.utm_breakdown || [];
						this.utmOptions = response.data.utm_options || [];
						const applied = response.data.filters_applied?.utm_source;
						this.utmSource = applied == null ? '' : applied;
						this.$nextTick(() => this.renderTimelineCharts());
					})
					.catch(() => {
						alert('Ошибка. Перезагрузите страницу');
					})
					.finally(() => {
						this.loadingFilter = false;
					});
			},
			timelineToChartPoints(rows) {
				return (rows ?? []).map((row) => ({
					second_index: row.second_index,
					hit_count: row.total_hits,
				}));
			},
			renderTimelineCharts() {
				if (typeof window.disposeSecondTimelineChart === 'function') {
					window.disposeSecondTimelineChart('stats-chart-active');
					window.disposeSecondTimelineChart('stats-chart-passive');
				}
				if (!this.timeline || typeof window.renderSecondTimelineChart !== 'function') {
					return;
				}
				const chartOptions = {
					variant: 'compact',
					durationSeconds: this.timeline.duration_seconds ?? 0,
				};
				window.renderSecondTimelineChart(
					'stats-chart-passive',
					this.timelineToChartPoints(this.timeline.passive),
					chartOptions
				);
				window.renderSecondTimelineChart(
					'stats-chart-active',
					this.timelineToChartPoints(this.timeline.active),
					chartOptions
				);
			},
		}));
	});
</script>
@endsection

@section('modals')
	@include('partials.admin.menu')
@endsection
