@extends('layouts.admin.index')

@section('title', 'Управление подписками')

@section('content')
	<div class="w-full" x-data="users">

		<header class="my-4 header">
			<div class="container container-header">
				<span class="!mb-0 mr-10 player__title__bg">
					Управление подписками
				</span>
	
				<input 
					class="px-3 py-2 text-black rounded focus:ring-none" 
					type="text" 
					placeholder="Поиск пользователя"
					@input.debounce="search"
				>
				
				<x-admin.menu-button />
			</div>
		</header>
	
		<div class="container">
			<div class="relative w-full max-h-screen text-md">
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
				<div class="text-lg text-black max-h-[calc(100vh-80px)] overflow-y-auto" x-show='users != null'>
					<template x-for="user in users">
						<x-admin.subscriptions.user />
					</template>
				</div>
				<div class="mt-10 text-center" x-show="users === null" x-cloak>Воспользуйтесь поиском для получения списка пользователей</div>
				<div class="mt-10 text-center" x-show="users?.length === 0" x-cloak>Ничего не найдено</div>
			</div>
	
			{{-- <div class="px-8 py-4 mb-10">
				{{ $users->links() }}
			</div> --}}
		</div>
	</div>

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('users', () => ({
				showFilter: false,
				users: null,

				search() {
					const search = this.$event.target.value;
					if (search == '') return;
					
					axios
						.post(
							route('admin.users.subscriptions.search'), 
							{search: search},
						)
						.then(response => this.users = response.data)
				},
				getSubscription(user, fragmentId, type) {
					let sub = user.active_subscriptions?.find(sub => {
						return sub.subscribable_id == fragmentId && sub.subscribable_type === type;
					});
					return sub;	
				},
			}))
		})
	</script>
@endsection

@section('modals')
    @include('partials.admin.menu')

@endsection
