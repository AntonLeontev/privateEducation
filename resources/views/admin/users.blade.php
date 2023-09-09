@extends('layouts.admin.index')

@section('title', 'Пользователи')

@section('content')
	<header class="my-4 header">
		<div class="container container-header">
			{{-- <nav class="header__nav">
				<ul class="header__list__nav">
					<li class="header__nav__list-item">Все продажи</li>
					<li class="header__nav__list-item">Только аудио</li>
					<li class="header__nav__list-item">Только видео</li>
					<li class="header__nav__list-item">Сводная информация</li>
				</ul>
			</nav> --}}
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

    <div class="container">
		<div class="flex mb-5 gap-x-3 player__title">
			<span class="mr-10 player__title__bg">
				Пользователи
			</span>
			<input type="text" placeholder="Поиск по email" class="w-full max-w-[150px] input input-bordered input-primary text-black rounded-none" />
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
        <div class="relative w-full max-h-screen text-md">
			<div class="flex py-1 gap-x-1">
				<div class="w-[5%] flex items-center justify-center text-center">№</div>
				<div class="w-[25%] flex items-center justify-center text-center">email</div>
				<div class="w-[10%] flex items-center justify-center text-center">Страна</div>
				<div class="w-[10%] flex items-center justify-center text-center">Город</div>
				<div class="w-[10%] flex items-center justify-center text-center">Количество активных подписок</div>
				<div class="w-[10%] flex items-center justify-center text-center">Всего куплено подписок</div>
				<div class="w-[10%] flex items-center justify-center text-center">Сумма покупок</div>
				<div class="w-[15%] flex items-center justify-center text-center">Дата последней покупки</div>
				<div class="w-[15%] flex items-center justify-center text-center">Дата регистрации</div>
				<div class="w-[5%] flex items-center justify-center text-center"></div>
			</div>
            <div class="text-lg text-black max-h-[calc(100vh-64px)] overflow-y-auto">
				@foreach ($users as $user)
					<x-user :user="$user" />
				@endforeach
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection
