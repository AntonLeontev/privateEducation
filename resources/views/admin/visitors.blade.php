@extends('layouts.admin.index')

@section('title', 'Посетители')

@section('content')
<div class="w-full" x-data="visitors">
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">Посетители</span>
			<form class="flex justify-between p-1 mb-2 gap-x-2" x-ref="form">
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
			<x-admin.menu-button />
		</div>
	</header>

	<div class="container">
		<div class="relative w-full max-h-screen text-md">
			<div class="text-lg text-black max-h-[calc(100vh-91px-58px)] overflow-y-auto">
				<template x-for="visitor in visitors">
					<x-visitor />
				</template>
			</div>
		</div>

		<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-start pt-3 pb-4 gap-x-5" x-show="paginatorMeta?.next_cursor || paginatorMeta?.prev_cursor" x-cloak>
			<span class="text-gray-400" x-show="paginatorMeta?.prev_cursor === null">
				{!! __('pagination.previous') !!}
			</span>
			<button class="" x-show="paginatorMeta?.prev_cursor" @click="prevPage">
				{!! __('pagination.previous') !!}
			</button>

			<button class="" x-show="paginatorMeta?.next_cursor" @click="nextPage">
				{!! __('pagination.next') !!}
			</button>
			<span class="text-gray-400" x-show="paginatorMeta?.next_cursor === null">
				{!! __('pagination.next') !!}
			</span>
			<span class="ml-1 loading loading-dots loading-sm" x-show="loadingPagination" x-cloak></span>
		</nav>
	</div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('visitors', () => ({
			visitors: [],
			period: 'today',
			paginatorMeta: null,
			cursor: null,
			loadingPagination: false,
			loadingFilter: false,

			init() {
				this.$watch('cursor', () => this.update());
				this.update()
			},
			changePeriod() {
				this.period = this.$refs.select.value;
				this.cursor = null;

				if (this.period === 'custom' && (this.$refs.start.value === '' || this.$refs.end.value === '')) {
					return;
				}

				this.update();
			},
			update() {
				this.loadingFilter = true

				axios
					.get(route('admin.visitors'), {
						params: {
							cursor: this.cursor,
							period: this.period,
							start: this.$refs.start.value,
							end: this.$refs.end.value,
						}
					})
					.then(response => {
						this.visitors = response.data.data
						this.paginatorMeta = response.data.meta
					})
					.catch(error => {
						alert('Ошибка. Перезагрузите страницу');
					})
					.finally(() => {
						this.loadingPagination = false
						this.loadingFilter = false
						this.$dispatch('visitors-update')
					})
			},
			prevPage() {
				this.loadingPagination = true
				this.cursor = this.paginatorMeta.prev_cursor
			},
			nextPage() {
				this.loadingPagination = true
				this.cursor = this.paginatorMeta.next_cursor
			},
		}))
	})
</script>
@endsection

@section('modals')
	@include('partials.admin.menu')
@endsection
