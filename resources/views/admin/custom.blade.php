@extends('layouts.admin.index')

@section('title', 'Admin panel')

@section('content')
<div class="w-full" x-data="container">
	<header class="my-4 header">
		<div class="container container-header">
			<nav class="header__nav">
				<ul class="header__list__nav">
					<li class="flex items-center gap-x-1 header__nav__list-item" @click="$dispatch('all-stats', 'all')">
						<img width="25px" src="{{ Vite::asset('resources/images/icon1.png') }}" alt="">
						<span>Все продажи</span>
					</li>
					<li class="flex items-center gap-x-1 header__nav__list-item" @click="$dispatch('all-stats', 'all-audio')">
						<img width="25px" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="">
						<span>Только аудио</span>
					</li>
					<li class="flex items-center gap-x-1 header__nav__list-item" @click="$dispatch('all-stats', 'all-video')">
						<img width="25px" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="">
						<span>Только видео</span>
					</li>
					<li class="flex items-center gap-x-1 header__nav__list-item" @click="modal = true">
						Сводная информация
					</li>
				</ul>
			</nav>
			<div class="burger">
				<div class="">Меню</div>
				<span></span>
			</div>
		</div>
	</header>

    <div class="container">
        <div 
			class="content hidden-md visible-sm" 
			x-data="fragments"
			@all-stats.window="allStats"
		>
            <div class="grid grid-cols-11 grid-rows-1 mb-5">
                <div class="col-span-5 player">
                    <div class="">
                        <div class="flex justify-between player__title align-center">
							<div class="flex items-center gap-x-2 bg-[rgba(146,140,141,0.7)] pr-2">
								<img class="h-[45px]" :src="image" alt="">
								<span class="text-[150%]" x-text="getTitle">
									Презентация. Фрагмент №1
								</span>
							</div>
                        </div>
                        <div class="player__content">
                            <div class="player__frame ">
								<table class="w-full stats-table">
									<thead>
										<tr>
											<th></th>
											<th class="px-3 py-2">EN</th>
											<th class="px-3 py-2">RU</th>
											<th class="py-2">Всего</th>
										</tr>
									</thead>
									<tbody class="[&>*]:text-lg [&>*:nth-child(even)]:bg-black/10">
										<tr class="[&>*]:py-1 [&>*:nth-child(1)]:pl-1">
											<td class="">Просмотров за все время</td>
											<td class="text-center">2</td>
											<td class="text-center">5</td>
											<td class="text-center">7</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType != 'presentation'">
											<td>Купивших пользователей</td>
											<td class="text-center">2</td>
											<td class="text-center">5</td>
											<td class="text-center">7</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType != 'presentation'">
											<td>Продажи сегодня</td>
											<td class="text-center">2 €</td>
											<td class="text-center">5 €</td>
											<td class="text-center">7 €</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType != 'presentation'">
											<td class="flex gap-1">
												<div class="title">Продажи за неделю</div>
												<div class="text-slate-300">(с {{ now()->startOfWeek()->translatedFormat('j.m.y') }})</div>
											</td>
											<td class="text-center">2 €</td>
											<td class="text-center">5 €</td>
											<td class="text-center">7 €</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType != 'presentation'">
											<td class="flex gap-1">
												<div class="title">Продажи за месяц</div>
												<div class="text-slate-300">(с {{ now()->startOfMonth()->translatedFormat('j.m.y') }})</div>
											</td>
											<td class="text-center">2 €</td>
											<td class="text-center">5 €</td>
											<td class="text-center">7 €</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType != 'presentation'">
											<td class="flex gap-1">
												<div class="title">Продажи за квартал</div>
												<div class="text-slate-300">(с {{ now()->startOfQuarter()->translatedFormat('j.m.y') }})</div>
											</td>
											<td class="text-center">2 €</td>
											<td class="text-center">5 €</td>
											<td class="text-center">7 €</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType != 'presentation'">
											<td class="flex gap-1">
												<div class="title">Продажи за год</div>
												<div class="text-slate-300">(с {{ now()->startOfYear()->translatedFormat('j.m.y') }})</div>
											</td>
											<td class="text-center">1234 €</td>
											<td class="text-center">1136 €</td>
											<td class="text-center">2347 €</td>
										</tr>
										<tr class="[&>*:nth-child(n)]:py-1 [&>*:nth-child(1)]:pl-1" x-show="activeType === 'presentation'">
											<td class="">Просмотров текста за все время</td>
											<td class="text-center">2</td>
											<td class="text-center">5</td>
											<td class="text-center">7</td>
										</tr>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="grid grid-cols-6 col-span-6 justify-items-center">
					@foreach (range(1, 6) as $number)
						<x-fragment :$number />
					@endforeach
				</div>
            </div>
            <div class="grid grid-cols-11 grid-rows-1 justify-items-center">
				@foreach (range(7, 17) as $number)
					<x-fragment :$number isPurple />
				@endforeach
            </div>
        </div>

		<script>
			document.addEventListener('alpine:init', () => {
				Alpine.data('fragments', () => ({
					active: '',
					activeType: 'all',
					activeFragment: '',

					getTitle() {
						if (! this.activeType) return;

						if (this.activeType === 'all-audio') {
							return "Все аудио";
						} 

						if (this.activeType === 'all-video') {
							return "Все видео";
						} 

						if (this.activeType === 'all') {
							return "Все продажи";
						} 
						
						let type;
						if (this.activeType === 'presentation') {
							type = 'Презентация';
						} 
						if (this.activeType === 'music') {
							type = 'Аудио';
						} 
						if (this.activeType === 'video') {
							type = 'Видео';
						} 
						if (this.activeType === 'total') {
							type = 'Суммарно';
						} 
						return type + '. Фрагмент №' + this.activeFragment
					},
					image() {
						if (this.activeType === 'presentation') {
							return "{{ Vite::asset('resources/images/icon4.png') }}";
						} 
						if (this.activeType === 'music') {
							return "{{ Vite::asset('resources/images/icon2.png') }}";
						} 
						if (this.activeType === 'all-audio') {
							return "{{ Vite::asset('resources/images/icon2.png') }}";
						} 
						if (this.activeType === 'all') {
							return "{{ Vite::asset('resources/images/icon1.png') }}";
						} 
						if (this.activeType === 'video') {
							return "{{ Vite::asset('resources/images/icon3.png') }}";
						} 
						if (this.activeType === 'all-video') {
							return "{{ Vite::asset('resources/images/icon3.png') }}";
						} 
						if (this.activeType === 'total') {
							return "{{ Vite::asset('resources/images/icon1.png') }}";
						} 
					},
					allStats() {
						this.active = null;
						this.activeType = this.$event.detail;
						this.activeFragment = null;
					},
				}))
			})
		</script>

        {{-- <div class="content visible-md hidden-sm hidden-bg">
            <div class="row player_row">
                <div class="player">
                    <div class="player__fixed">
                        <div class="player__title">
                            <span class="player__title__bg">
                                Презентация. Фрагмент №1<br>
                                <!--<span class="player__title__name"><div class="scroll-text"><span>Наиминование.</span></div></span>-->
                            </span>
                        </div>
                        <div class="player__content">
                            <div class="player__frame">
                                <video class="player__frame__video" controls muted playsinline></video>
                                <audio class="player__frame__audio" controls playsinline></audio>
                                <button class="player__frame__prev" type="button"></button>
                                <button class="player__frame__next" type="button"></button>
                                <button class="player__frame__link" type="button"></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="items-md">
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                1</span>
                        </div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="6"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="6"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button class="is-active" type="button" data-type="video" data-id="6"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="6"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                2</span>
                        </div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="7"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="7"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="7"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="7"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item new-string"></div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                3</span>
                        </div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                4</span>
                        </div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                5</span>
                        </div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                6</span>
                        </div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 7</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 8</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 9</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 10</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 11</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 12</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 13</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 14</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 15</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 16</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 17</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="1" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" class="ico1"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" class="ico2"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}" alt=""></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}

		<div class="absolute max-h-[80vh] rounded-xl top-0 left-0 right-0 overflow-hidden shadow-[0_1px_3px_#757252]"
			x-cloak
			x-show='modal'
			x-transition
			x-data="modal"
		>
			<div class="flex align-center justify-between bg-gradient-to-b from-[#fff] to-[#ef8d31] text-black text-[2vw] pt-[0.4vw] pr-[0.5vw] pb-[0.7vw] pl-[1.3vw]">
				<div class="flex items-center gap-x-2">
					<span>
						Сводная статистика:
						<span x-text="title()"></span>
					</span>
					<img class="h-[35px]" :src="image()" alt="">
				</div>
				<button class="w-[2.4vw] h-[2.4vw] opacity-70 hover:opacity-100" @click="modal = false">
					<img src="{{ Vite::asset('resources/images/close-modal.png') }}" alt="">
				</button>
			</div>
			<div class="bg-[rgba(220,246,210,0.77)] p-5 text-black overflow-y-auto max-h-[calc(80vh-40px)]">
				<div class="flex justify-start mb-4 align-center gap-x-10">
					<img 
						class="w-[45px] h-[45px] opacity-50 hover:opacity-70 cursor-pointer" 
						src="{{ Vite::asset('resources/images/icon2.png') }}" 
						alt="Аудио" 
						:class="section === 'audio' && '!opacity-100'"
						data-section="audio"
						@click="setSection"
					>
					<img 
						class="w-[50px] h-[45px] opacity-50 hover:opacity-70 cursor-pointer" 
						src="{{ Vite::asset('resources/images/icon3.png') }}" 
						alt="Видео"
						:class="section === 'video' && '!opacity-100'"
						data-section="video"
						@click="setSection"
					>
					<img 
						class="w-[55px] h-[45px] opacity-50 hover:opacity-70 cursor-pointer" 
						src="{{ Vite::asset('resources/images/icon4.png') }}" 
						alt="Презентация"
						:class="section === 'presentation' && '!opacity-100'"
						data-section="presentation"
						@click="setSection"
					>
				</div>
				<table class="w-full">
					<thead>
						<tr class="[&>*]:px-2 text-[14px]">
							<th></th>
							<th>
								<div 
									class="relative flex items-center justify-center cursor-pointer gap-x-2" 
									:class="{'bg-[#50657c] text-white': sort === 'view-ru' && direction !== null}"
									@click="changeSort('view-ru')" 
								>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
									<span class="">RU</span> 
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 transition" x-show="sort === 'view-ru' && direction != null" :class="direction === 'desc' && 'rotate-180'">
										<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
									</svg>
								</div>
							</th>
							<th x-show="section == 'presentation'">
								<div class="flex items-center justify-center gap-1" title="Количество просмотров текста">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
									</svg>
									RU
								</div>
							</th>
							<th>
								<div 
									class="relative flex items-center justify-center cursor-pointer gap-x-2" 
									:class="{'bg-[#50657c] text-white': sort === 'view-en' && direction !== null}"
									@click="changeSort('view-en')" 
								>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
										<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									</svg>
									<span>EN</span> 
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 transition" x-show="sort === 'view-en' && direction != null" :class="direction === 'desc' && 'rotate-180'">
										<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25L12 21m0 0l-3.75-3.75M12 21V3" />
									</svg>
								</div>
							</th>
							<th x-show="section == 'presentation'">
								<div class="flex items-center justify-center gap-1" title="Количество просмотров текста">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
										<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
									</svg>
									EN
								</div>
							</th>
							<th x-show="section != 'presentation'">
								RU сегодня
							</th>
							<th x-show="section != 'presentation'">
								RU неделя
							</th>
							<th x-show="section != 'presentation'">
								RU месяц
							</th>
							<th x-show="section != 'presentation'">
								RU квартал
							</th>
							<th x-show="section != 'presentation'">
								RU год
							</th>
							<th x-show="section != 'presentation'">
								EN сегодня
							</th>
							<th x-show="section != 'presentation'">
								EN неделя
							</th>
							<th x-show="section != 'presentation'">
								EN месяц
							</th>
							<th x-show="section != 'presentation'">
								EN квартал
							</th>
							<th x-show="section != 'presentation'">
								EN год
							</th>
						</tr>
					</thead>
					<tbody class="text-[14px]">
						<template x-for="fragment in fragments">
							<tr class="[&>*]:py-1 hover:bg-primary transition delay-100 duration-300 even:bg-[rgba(205,253,187,0.5)]">
								<td class="text-left" x-text="fragment.title"></td>
								<td class="text-center" x-text="fragment['view-ru']"></td>
								<td class="text-center" x-text="fragment['view-en']"></td>
								<td class="text-center" x-text="fragment[3]" x-show="section == 'presentation'"></td>
								<td class="text-center" x-text="fragment[4]" x-show="section == 'presentation'"></td>
								<td class="text-center" x-text="fragment[5] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[6] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[7] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[8] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[9] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[10] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[11] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[12] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[13] + ' €'" x-show="section != 'presentation'"></td>
								<td class="text-center" x-text="fragment[14] + ' €'" x-show="section != 'presentation'"></td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>

		@php
			$fragments = [];
			foreach (range(1, 17) as $item) {
				$fragments[] = [
					'position' => $item,
					'title' => "Фрагмент $item",
					'view-ru' => random_int(0,15),
					'view-en' => random_int(0,15),
					3 => random_int(0,15),
					4 => random_int(0,15),
					5 => random_int(0,15),
					6 => random_int(0,15),
					7 => random_int(0,15),
					8 => random_int(0,15),
					9 => random_int(0,15),
					10 => random_int(0,15),
					11 => random_int(0,15),
					12 => random_int(0,15),
					13 => random_int(0,15),
					14 => random_int(0,15),
				];
			}
		@endphp

		<script>
			document.addEventListener('alpine:init', () => {
				Alpine.data('modal', () => ({
					fragments: @json($fragments),
					section: 'audio',
					sort: null,
					direction: null,

					setSection() {
						this.section = this.$el.dataset.section;
					},
					title() {
						if (this.section === 'audio') {
							return 'Аудио';
						}
						if (this.section === 'video') {
							return 'Видео';
						}
						if (this.section === 'presentation') {
							return 'Презентация';
						}
					},
					image() {
						if (this.section === 'audio') {
							return "{{ Vite::asset('resources/images/icon2.png') }}";
						}
						if (this.section === 'video') {
							return "{{ Vite::asset('resources/images/icon3.png') }}";
						}
						if (this.section === 'presentation') {
							return "{{ Vite::asset('resources/images/icon4.png') }}";
						}
					},
					changeSort(column) {
						if (this.sort === column) {
							this.changeDirection();
							this.sortFragments();
							return;
						}

						this.sort = column;
						this.direction = 'asc';
						this.sortFragments();
					},
					changeDirection() {
						this.direction === 'asc'
							? this.direction = 'desc'
							: this.direction === 'desc' 
								? this.direction = null
								: this.direction = 'asc';
					},
					sortFragments() {
						this.fragments.sort((a, b) => {
							if (this.direction === 'desc') {
								return a[this.sort] - b[this.sort];
							}

							if (this.direction === 'asc') {
								return b[this.sort] - a[this.sort];
							}

							return a.position - b.position;
						});
					},
				}))
			})
		</script>

    </div>
</div>

<script>
	document.addEventListener('alpine:init', () => {
		Alpine.data('container', () => ({
			modal: false,
		}))
	})
</script>

@endsection

@section('modals')
    @include('partials.admin.modal')

    @include('partials.admin.menu')

    <!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
    <script src="/js/script1.js"></script>
@endsection

@section('body-scripts')
   
@endsection
