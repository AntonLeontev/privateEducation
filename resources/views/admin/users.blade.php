@extends('layouts.admin.index')

@section('title', 'Пользователи')

@section('content')
	<header class="my-4 header" x-data>
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">
				Пользователи
			</span>
			<div class="flex items-center gap-5 border rounded-lg">
				<div class="flex p-2 gap-x-5">
					<div class="">Всего: {{ $total }}</div>
					<div class="">Покупателей: {{ $buyers }}</div>
					<div class="">С активной сейчас подпиской: {{ $active }}</div>
				</div>
			</div>
			<button class="px-3 py-2 ml-10 transition border rounded-xl hover:bg-primary hover:border-primary" @click="$dispatch('toggleFilter')">Фильтр</button>
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

    <div class="container" x-data="users" @toggle-filter.camel.document="showFilter = !showFilter">
		<div class="grid grid-rows-[0fr] transition-[grid-template-rows]" :class="showFilter && '!grid-rows-[1fr]'">
			<div class="flex overflow-hidden gap-x-3 player__title">
				
				<form class="flex p-1 mb-5 gap-x-2">
					<input type="text" placeholder="Поиск по email" class="w-full max-w-[250px] input input-bordered input-primary text-black rounded-xl" />
					<select class="w-full max-w-[200px] select select-primary bg-primary rounded-xl">
						<option selected>Страна</option>
						<option>Россия</option>
						<option>США</option>
					</select>
					<select class="w-full max-w-[200px] select select-primary bg-primary rounded-xl">
						<option selected>Город</option>
						<option>Москва</option>
						<option>Волгоград</option>
					</select>
					<select class="w-full max-w-[400px] select select-primary bg-primary rounded-xl">
						<option selected>Тип медиа</option>
						<option>Любой</option>
						<option>Аудио</option>
						<option>Видео</option>
					</select>
					<select class="w-full max-w-[400px] select select-primary bg-primary rounded-xl">
						<option selected>Номер фрагмента</option>
						@foreach (range(1, 17) as $number)
							<option value="{{ $number }}">Фрагмент {{ $number }}</option>
						@endforeach
					</select>
				</form>
			</div>
		</div>
        <div class="relative w-full max-h-screen text-md">
            <div class="text-lg text-black max-h-[calc(100vh-91px-58px)] overflow-y-auto">
				<template x-for="user in users">
					<x-user />
				</template>
            </div>
        </div>

		<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-start pt-3 pb-4 gap-x-5">
			<span class="text-gray-400" x-show="paginatorMeta?.prev_cursor === null">
				{!! __('pagination.previous') !!}
			</span>
			<button class="" x-show="paginatorMeta?.prev_cursor" @click="prevPage">
				{!! __('pagination.previous') !!}
			</button>

			<div x-text="page"></div>

			<button class="" x-show="paginatorMeta?.next_cursor" @click="nextPage">
				{!! __('pagination.next') !!}
			</button>
			<span class="text-gray-400" x-show="paginatorMeta?.next_cursor === null">
				{!! __('pagination.next') !!}
			</span>
		</nav>
    </div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('users', () => ({
				showFilter: false,
				users: [],
				paginatorMeta: null,
				cursor: null,
				page: 1,

				init() {
					this.$watch('cursor', value => this.update());
					this.update()
				},
				update() {
					axios
						.get(route('admin.users'), {params: {cursor: this.cursor}})
						.then(response => {
							this.users = response.data.data
							this.paginatorMeta = response.data.meta
						})
				},
				prevPage() {
					this.cursor = this.paginatorMeta.prev_cursor
					this.paginatorMeta.prev_cursor = null
					this.page--
				},
				nextPage() {
					this.cursor = this.paginatorMeta.next_cursor
					this.paginatorMeta.next_cursor = null
					this.page++
				},
			}))
		})
	</script>
@endsection

@section('modals')
    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection
