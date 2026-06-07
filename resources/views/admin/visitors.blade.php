@extends('layouts.admin.index')

@section('title', 'Посетители')

@section('content')
<div class="w-full" x-data="visitors">
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">Посетители</span>
			<form class="flex gap-x-2 justify-between p-1 mb-2" x-ref="form">
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
			</form>
			<div class="text-sm ms-2">
				Количество посещений c просмотрами презентаций: <span x-text="totalVisits"></span>
			</div>
			<x-admin.menu-button />
		</div>
	</header>

	<div class="container">
		<div class="relative w-full text-md">
			<div class="text-lg text-black">
				<template x-for="visit in visits">
					<x-visitor />
				</template>
			</div>
		</div>

		<div class="flex gap-x-3 justify-start items-center pt-3 pb-4" x-show="paginatorMeta?.next_cursor || loadingPagination" x-cloak>
			<button
				type="button"
				class="px-3 py-2 text-[16px] font-bold border transition hover:bg-primary hover:border-primary disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-transparent"
				x-show="paginatorMeta?.next_cursor"
				:disabled="loadingPagination"
				@click="loadMore"
			>
				Загрузить ещё
			</button>
			<span class="loading loading-dots loading-sm" x-show="loadingPagination" x-cloak></span>
		</div>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('visitors', () => ({
			visits: [],
			totalVisits: 0,
			period: 'today',
			paginatorMeta: null,
			loadingPagination: false,
			loadingFilter: false,

			init() {
				this.reloadFromStart();
			},
			changePeriod() {
				this.period = this.$refs.select.value;

				if (this.period === 'custom' && (this.$refs.start.value === '' || this.$refs.end.value === '')) {
					return;
				}

				this.reloadFromStart();
			},
			reloadFromStart() {
				this.fetchVisitors({ append: false });
			},
			loadMore() {
				if (!this.paginatorMeta?.next_cursor || this.loadingPagination) {
					return;
				}
				this.fetchVisitors({ append: true });
			},
			fetchVisitors({ append }) {
				if (append) {
					this.loadingPagination = true;
				} else {
					this.loadingFilter = true;
				}

				const cursor = append ? this.paginatorMeta.next_cursor : null;

				axios
					.get(route('admin.visitors'), {
						params: {
							cursor,
							period: this.period,
							start: this.$refs.start.value,
							end: this.$refs.end.value,
						}
					})
					.then(response => {
						const chunk = response.data.data;
						this.visits = append ? [...this.visits, ...chunk] : chunk;
						this.paginatorMeta = response.data.meta;

						if (!append) {
							this.totalVisits = response.data.total_visits ?? 0;
						}
					})
					.catch(error => {
						alert('Ошибка. Перезагрузите страницу');
					})
					.finally(() => {
						this.loadingPagination = false;
						this.loadingFilter = false;
						this.$dispatch('visitors-update');
					});
			},
		}))
	})
</script>
@endsection

@section('modals')
	@include('partials.admin.menu')
@endsection
