@extends('layouts.admin.index')

@section('title', 'Администраторы')

@section('content')
    <div class="w-full" x-data="admins">
		<header class="my-3 header">
			<div class="container container-header">
				<span class="!mb-0 mr-10 player__title__bg">
					Администраторы
				</span>
				<button class="px-3 py-2 ml-10 transition border rounded-xl hover:bg-primary hover:border-primary" @click="showForm = !showForm">Добавить администратора</button>
				<x-admin.menu-button />
			</div>
		</header>
		<div class="container">
			<div class="grid grid-rows-[0fr] transition-[grid-template-rows]" :class="showForm && '!grid-rows-[1fr]'">
				<div class="flex overflow-hidden gap-x-3 player__title">
					
					<form class="flex p-1 mb-5 gap-x-2" @submit.prevent="createAdmin">
						<input 
							type="text" 
							placeholder="Логин" 
							name="email"
							class="w-full max-w-[250px] input input-bordered input-primary text-black rounded-xl"
						/>
						<input 
							type="password" 
							placeholder="Пароль" 
							name="password"
							class="w-full max-w-[250px] input input-bordered input-primary text-black rounded-xl"
						/>
						<input 
							type="password" 
							placeholder="Повторите пароль" 
							name="password_confirmation"
							class="w-full max-w-[250px] input input-bordered input-primary text-black rounded-xl"
						/>

						<select class="w-full max-w-[200px] select select-primary bg-primary rounded-xl" name="role">
							<option value="seo" selected>SEO</option>
						</select>

						<button class="px-3 py-2 ml-10 transition border rounded-xl hover:bg-primary hover:border-primary">Создать</button>
					</form>
				</div>
			</div>
			
			<div class="relative w-full max-h-screen text-md">
				<div class="text-lg text-black max-h-[calc(100vh-91px-58px)] overflow-y-auto">
					<template x-for="admin in admins">
						<div
							class="flex items-center justify-between px-2 py-3 mb-2 transition gap-x-1 rounded-xl opacity-60 hover:opacity-100 bg-white/20"
						>
							<div class="flex w-full">
								<div class="w-[15%] overflow-hidden truncate text-secondary" x-text="admin.email"></div>
								<div class="w-[15%] text-secondary" x-text="'Роль: ' + admin.role"></div>
								<div class="w-[30%] text-secondary" x-text="'Создан: ' + admin.created_at"></div>
								<div class="w-[40%] text-secondary" x-text="'Последняя активность: ' + (admin.last_activity ?? 'еще не было')"></div>
							</div>
							<button @click="deleteAdmin(admin)">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 hover:fill-red-600">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>
							</button>
						</div>
					</template>
				</div>
			</div>
		</div>

    </div>   

	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('admins', () => ({
				admins: @json($admins),
				showForm: false,

				createAdmin() {
					axios
						.post(route('admin.admins.store'), new FormData(this.$event.target))
						.then(response => this.admins.push(response.data))
						.catch(error => {
							alert(error.response.data.message ?? 'Ошибка создания администратора');
						})
				},
				deleteAdmin(admin) {
					if (!confirm(`Действительно удалить администратора ${admin.email}?`)) return
					
					axios
						.delete(route('admin.admins.destroy', admin.id))
						.then(response => {
							let index = this.admins.indexOf(admin)
							this.admins.splice(index, 1)
						})
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

@section('body-scripts')

@endsection
