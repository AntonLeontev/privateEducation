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
            <div class="text-lg text-black max-h-[calc(100vh-91px-58px)] overflow-y-auto">
				@foreach ($users as $user)
					<x-user :user="$user" />
				@endforeach
            </div>
        </div>

		<div class="px-8 py-4 mb-2">
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
