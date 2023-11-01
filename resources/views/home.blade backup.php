@extends('layouts.app.app')

@section('title', 'Home')

@section('content')
	<div id="panel"></div>
    <div class="main main--index">

        <div class="container">
            <div class="row player_row">
                <div class="player player-mob">
                    <div class="player__fixed">
                        <div class="player__title">
                            <span class="player__title__bg">
                                Презентация. Фрагмент №1<br>
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
            </div>
            <div class="content hidden-md visible-sm">
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
                    <div class="item items is-active">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                1</span></div>
                        <ul>
                            <li>
                                <button class="js-fragment-cart" type="button" data-type="text" data-int="1"
                                    data-id="6"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="6"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button class="" type="button" data-type="video" data-id="6"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="6" class="is-active"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№
                                2</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="2" data-id="7"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="7"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" alt=""></button>
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
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 3</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="3" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}" alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}" alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="8"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 4</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="4" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="9"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 5</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="5" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="10"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 6</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="6" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="11"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 7</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="7" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="13"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 8</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="8" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="14"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 9</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="9" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="15"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 10</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="10" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="16"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 11</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="11" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="18"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 12</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="12" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 13</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="13" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 14</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="14" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 15</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="15" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 16</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="16" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                    <div class="item">
                        <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                                class="span-number">№ 17</span></div>
                        <ul>
                            <li>
                                <button type="button" data-type="text" data-int="17" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon1.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="music" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon2.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                                <button type="button" data-type="video" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon3.png') }}"
                                        alt=""></button>
                            </li>
                            <li>
                                <button type="button" data-type="photo" data-id="96"><img
                                        src="{{ Vite::asset('resources/images/icon4.png') }}"
                                        alt=""></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="content visible-md hidden-sm hidden-bg">
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
                            <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                    class="span-number">№ 1</span>
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
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                    class="span-number">№ 2</span>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="7"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item new-string"></div>
                        <div class="item">
                            <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                    class="span-number">№ 3</span>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="8"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                    class="span-number">№ 4</span>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="9"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                    class="span-number">№ 5</span>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="10"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title"><span class="fragment">Фрагмент</span><br><span
                                    class="span-number">№ 6</span>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="11"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 7</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="13"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 8</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="14"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 9</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="15"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 10</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="16"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 11</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="18"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 12</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="96"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 13</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="96"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 14</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="96"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 15</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="96"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 16</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="96"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <div class="item__title item__title--purple"><span
                                    class="fragment">Фрагмент</span><br><span class="span-number">№ 17</span></div>
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
                                            src="{{ Vite::asset('resources/images/icon3.png') }}"
                                            alt=""></button>
                                </li>
                                <li>
                                    <button type="button" data-type="photo" data-id="96"><img
                                            src="{{ Vite::asset('resources/images/icon4.png') }}"
                                            alt=""></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @include('partials.app.modal')


    

@endsection
