@extends('layouts.admin.index')

@section('title', 'Деактивация фрагментов')

@section('content')
	<header class="my-4 header">
		<div class="container container-header">
			<span class="!mb-0 mr-10 player__title__bg">
				Деактивация фрагментов
			</span>
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

	<div class="container" x-data="fragments">
		<div class="w-full">
			<div class="text-lg text-black h-[calc(100vh-82px)] overflow-y-auto pb-2 flex justify-between items-center gap-1">
				<template x-for="fragment in fragments">
					<div class="flex flex-col items-center justify-center w-full px-2 py-3 transition gap-x-3 rounded-xl bg-white/20">
						<div class="" x-text="'№' + fragment.id"></div>
						<label class="swap" :class="fragment.is_active && 'swap-active'" @click="confirm(fragment)">
							<div class="swap-on">
								<svg class="swap-on" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-toggle-on" viewBox="0 0 16 16">
									<path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
									<circle cx="11" cy="8" r="4" fill="#E9742B"/>
								</svg>
							</div>
							<div class="swap-off">
								<svg class="rotate-180 swap-off" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="rotate-180" viewBox="0 0 16 16">
									<path d="M5 3a5 5 0 0 0 0 10h6a5 5 0 0 0 0-10H5zm6 9a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/>
									<circle cx="11" cy="8" r="4" fill="#7e6a96"/>
								</svg>
							</div>
						</label>

					</div>
				</template>
			</div>
		</div>
		<div class="fixed top-0 bottom-0 left-0 right-0 flex items-center justify-center" style="display: none" x-show="changingFragment">

			<div class="auth-modal modal-fragment-main !static">
				<div class="modal-header">
					<span class="modal-header-text" x-text="changingFragment?.is_active ? `Деактивация фрагмента №${changingFragment?.id}` : 'Активация фрагмента №' + changingFragment?.id"></span>
		
		
					<button class="myBtn modal-close-btn" @click="changingFragment = null"></button>
		
				</div>
				<div class="flex flex-col items-center justify-center h-[calc(100%-47px)] px-10">
					<div class="text-3xl text-center text-black" x-text="changingFragment?.is_active ? `Действительно хотите деактивировать фрагмент&nbsp№${changingFragment?.id}?` : `Действительно хотите активировать фрагмент&nbsp№${changingFragment?.id}?`"></div>
					<div class="flex items-center gap-2 mt-10">
						<span class="loading loading-dots loading-lg" x-show="loading"></span>
						<button class="!mt-0 myBtn action-btn auth-modal__login-btn-fragment" @click="update">ДА</button>
						<button class="!mt-0 myBtn action-btn auth-modal__login-btn-fragment" @click="changingFragment = null">ОТМЕНА</button>
					</div>
				</div>
				
			</div>
		</div>
	</div>


	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('fragments', () => ({
				fragments: @json($fragments),
				changingFragment: null,
				loading: false,

				update() {
					this.loading = true

					axios
						.post(route('admin.fragments.update', this.changingFragment.id), {
							'is_active': !this.changingFragment.is_active
						})
						.then(response => {
							let fragment = this.fragments.find(el => {
								return el.id === this.changingFragment.id
							})
							fragment.is_active = !fragment.is_active
						})
						.catch(error => {
							console.log(error)
							alert('Ошибка сохранения!')
						})
						.finally(() => {
							this.changingFragment = null
							this.loading = false
						})
				},
				confirm(fragment) {
					this.changingFragment = fragment
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
