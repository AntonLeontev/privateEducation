@extends('layouts.admin.index')

@section('title', 'Пользователи')

@section('content')
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
        <div class="w-full text-lg border-separate border-spacing-y-3">
			<div class="flex">
				<div class="w-[15%] text-center">email</div>
				<div class="w-[10%] text-center">Страна</div>
				<div class="w-[10%] text-center">Город</div>
				<div class="w-[20%] text-center">Количество активных подписок</div>
				<div class="w-[20%] text-center">Всего куплено подписок</div>
				<div class="w-[20%] text-center">Сумма покупок</div>
				<div class="w-[5%] text-center"></div>
			</div>
            <div class="text-lg text-black">
				@foreach ($resource->items() as $item)
					<x-user :user="$item->getItem()" />
				@endforeach
            </div>
        </div>
    </div>
@endsection
