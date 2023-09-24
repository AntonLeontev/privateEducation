@extends('layouts.admin.index')

@section('title', 'Пользователи')

@section('content')
	<header class="my-4 header" x-data>
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">
				Пользователи
			</span>
			<div class="flex gap-x-5">
				<div class="">Всего: {{ $total }}</div>
				<div class="">Активных: {{ $active }}</div>
				<div class="">Неактивных: {{ $inactive }}</div>
				<button class="ml-10" @click="$dispatch('toggleFilter')">Фильтр</button>
			</div>
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

    <div class="container" x-data="users" @toggle-filter.camel.document="showFilter = !showFilter">
		<div class="grid grid-rows-[0fr] overflow-hidden transition-[grid-template-rows]" :class="showFilter && '!grid-rows-[1fr]'">
			<div class="flex overflow-hidden gap-x-3 player__title">
				
				<div class="flex mb-5 gap-x-2">
					<input type="text" placeholder="Поиск по email" class="w-full max-w-[250px] input input-bordered input-primary text-black rounded-none" />
					<select class="w-full max-w-[200px] select select-primary bg-primary rounded-none">
						<option selected>Страна</option>
						<option>Россия</option>
						<option>США</option>
					</select>
					<select class="w-full max-w-[200px] select select-primary bg-primary rounded-none">
						<option selected>Город</option>
						<option>Москва</option>
						<option>Волгоград</option>
					</select>
				</div>
			</div>
		</div>
        <div class="relative w-full max-h-screen text-md">
			{{-- 64px --}}
			{{-- <div class="flex py-1 gap-x-1">
				<div class="w-[5%] flex items-center justify-center text-center">№</div>
				<div class="w-[18%] flex items-center justify-center text-center shrink-0 grow-0">email</div>
				<div class="w-[10%] flex items-center justify-center text-center">Страна</div>
				<div class="w-[10%] flex items-center justify-center text-center">Город</div>
				<div class="w-[10%] flex items-center justify-center text-center">Количество активных подписок</div>
				<div class="w-[10%] flex items-center justify-center text-center">Всего куплено подписок</div>
				<div class="w-[10%] flex items-center justify-center text-center">Сумма покупок</div>
				<div class="w-[15%] flex items-center justify-center text-center">Дата последней покупки</div>
				<div class="w-[15%] flex items-center justify-center text-center">Дата регистрации</div>
				<div class="w-[5%] flex items-center justify-center text-center"></div>
			</div> --}}
            <div class="text-lg text-black max-h-[calc(100vh-91px-79px)] overflow-y-auto">
				@foreach ($users as $user)
					<x-user :user="$user" />
				@endforeach
            </div>
        </div>

		<div class="px-8 py-4 mb-10">
			{{ $paginator->links() }}
		</div>
    </div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('users', () => ({
				showFilter: false,

			}))
		})
	</script>
@endsection

@section('modals')
    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection
