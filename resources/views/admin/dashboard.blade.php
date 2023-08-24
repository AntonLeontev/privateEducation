@extends('layouts.admin.index')

@section('title', 'Dashboard')

@section('content')
	@vite(['resources/js/metrics.js'])

	<header class="my-4 header">
		<div class="container container-header">
			<nav class="header__nav">
				<ul class="header__list__nav">
					{{-- <li class="header__nav__list-item">Все продажи</li> --}}
				</ul>
			</nav>
			<div class="ml-auto burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

	<div>
		Metrics
	</div>

	<x-admin.dashboard.date-chart />

	
@endsection

@section('modals')
    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection


