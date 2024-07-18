@extends('layouts.admin.index')

@section('title', 'Журнал действий')

@section('content')
    <div class="w-full" x-data="actions">
		<header class="my-3 header">
			<div class="container container-header">
				<span class="!mb-0 mr-10 player__title__bg">
					Журнал действий
				</span>
				<form class="flex p-1 gap-x-3">
					<select 
						class="bg-transparent border cursor-pointer rounded-none px-1 py-2 text-[16px] font-bold focus:outline-none" 
						name="period"
						x-model="period"
						@change="update" 
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
							@change="update"
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
							@change="update"
						>
					</label>
				</form>
				<x-admin.menu-button />
			</div>
		</header>
		<div class="container">
			<div class="grid grid-rows-[0fr] transition-[grid-template-rows]" :class="showFilter && '!grid-rows-[1fr]'">
				<div class="flex overflow-hidden gap-x-3 player__title">
					
					
				</div>
			</div>
			
			<div class="relative w-full max-h-screen text-md">
				<div class="text-lg text-black max-h-[calc(100vh-91px-58px)] overflow-y-auto">
					<template x-for="action in actions">
						<div
							class="flex items-center justify-between px-2 py-3 mb-2 transition gap-x-1 rounded-xl opacity-60 hover:opacity-100 bg-white/20"
						>
							<div class="flex w-full">
								<div class="w-[25%] overflow-hidden truncate text-secondary" x-text="action.user.email"></div>
								<div class="w-[50%]" :class="actionStyleClass(action)" x-text="action.action"></div>
								<div class="w-[25%] text-secondary" x-text="action.created_at"></div>
							</div>
						</div>
					</template>
					<div class="h-[200px] flex justify-center items-center text-white" x-show="actions.length == 0">Активности за выбранный период не было</div>
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
			Alpine.data('actions', () => ({
				actions: [],
				paginatorMeta: null,
				period: 'today',
				page: 1,
				showFilter: false,
				loadingPagination: false,
				loadingFilter: false,

				init() {
					this.$watch('page', value => this.update());
					this.update();
				},
				update() {
					axios
						.get(route('admin.actions.index'), {
							params: {
								page: this.page,
								period: this.period,
								start: this.$refs.start.value,
								end: this.$refs.end.value,
							}
						})
						.then(response => {
							this.actions = response.data.data
							this.paginatorMeta = {
								next_cursor: response.data.next_page_url,
								prev_cursor: response.data.prev_page_url,
							}
						})
						.catch(error => alert(error.response.data.message ?? 'Ошибка получения данных'))
						.finally(() => {
							this.loadingPagination = false
						})
				},
				prevPage() {
					this.loadingPagination = true
					this.page = this.page - 1
				},
				nextPage() {
					this.loadingPagination = true
					this.page = this.page + 1
				},
				actionStyleClass(action) {
					return {
						'text-[#28568c]': action.type === 'subscription',
						'text-[#ffd92a]': action.type === 'view video',
						'text-[#f8fe58]': action.type === 'view presentation',
						'text-[#ffcab2]': action.type === 'passive view',
						'text-[#fefefe]': action.type === 'listen',
						'text-[rgb(61,223,238)]': action.type === 'reading',
					}
				},
			}))
		})
	</script>

@endsection

@section('modals')

    @include('partials.admin.menu')

@endsection

@section('body-scripts')

@endsection
