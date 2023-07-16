<!DOCTYPE html>
<html lang="ru">
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="robots" content="index, follow">
  <title>@yield('title')</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width">
  <style>@import url('https://fonts.googleapis.com/css2?family=Tinos:wght@400;700&display=swap');</style>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css'])
</head>
<body class="page page--index">
<div id="panel"></div>
<div class="main main--index">
  
	@include('partials.admin.header')

  <div class="container">
    <div class="row player_row">
      <div class="player player-mob">
        <div class="player__fixed">
          <div class="player__title">
                        <span class="player__title__bg">
                           Презентация. Фрагмент №1<br>
                          <!--										<span class="player__title__name"><div class="scroll-text"><span>Наиминование.</span></div></span>-->
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
        <div class="item items">
          <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 1</span></div>
          <ul>
            <li>
              <button class="js-fragment-cart" type="button" data-type="text" data-int="1" data-id="6"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="6"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                       alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button class="" type="button" data-type="video" data-id="6"><img src="{{ Vite::asset('resources/images/icon3.png') }}"></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="6" class="is-active"><img src="{{ Vite::asset('resources/images/icon4.png') }}"></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 2</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="2" data-id="7"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="7"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                       alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="7"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                       alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="7"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                       alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item new-string"></div>
        <div class="item">
          <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 3</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="3" data-id="8"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="8"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                       alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="8"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
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
          <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 4</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="4" data-id="9"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="9"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                       alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="9"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                       alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="9"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                       alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 5</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="5" data-id="10"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="10"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="10"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="10"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 6</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="6" data-id="11"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="11"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="11"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="11"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
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
              <button type="button" data-type="text" data-int="7" data-id="13"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="13"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="13"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="13"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 8</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="8" data-id="14"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="14"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="14"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="14"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 9</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="9" data-id="15"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="15"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="15"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="15"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 10</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="10" data-id="16"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="16"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="16"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="16"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 11</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="11" data-id="18"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="18"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="18"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="18"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 12</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="12" data-id="96"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 13</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="13" data-id="96"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 14</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="14" data-id="96"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 15</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="15" data-id="96"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 16</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="16" data-id="96"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                        alt=""></button>
            </li>
          </ul>
        </div>
        <div class="item">
          <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
              class="span-number">№ 17</span></div>
          <ul>
            <li>
              <button type="button" data-type="text" data-int="17" data-id="96"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                  alt=""></button>
            </li>
            <li>
              <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
              <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                        alt=""></button>
            </li>
            <li>
              <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
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
            <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 1</span>
            </div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="6"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="6"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                         class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button class="is-active" type="button" data-type="video" data-id="6"><img
                    src="{{ Vite::asset('resources/images/icon3.png') }}"></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="6"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                         alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 2</span>
            </div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="7"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="7"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                         class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="7"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                         alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="7"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                         alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item new-string"></div>
          <div class="item">
            <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 3</span>
            </div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="8"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="8"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                         class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="8"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                         alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="8"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                         alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 4</span>
            </div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="9"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="9"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                         class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="9"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                         alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="9"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                         alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 5</span>
            </div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="10"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="10"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="10"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="10"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title"><span class="fragment">Фрагмент</span><br><span class="span-number">№ 6</span>
            </div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="11"><img src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="11"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="11"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="11"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 7</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="13"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="13"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="13"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="13"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 8</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="14"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="14"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="14"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="14"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 9</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="15"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="15"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="15"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="15"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 10</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="16"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="16"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="16"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="16"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 11</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="18"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="18"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="18"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="18"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 12</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="96"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 13</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="96"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 14</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="96"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 15</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="96"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 16</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="96"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
          <div class="item">
            <div class="item__title item__title--purple"><span class="fragment">Фрагмент</span><br><span
                class="span-number">№ 17</span></div>
            <ul>
              <li>
                <button type="button" data-type="text" data-int="1" data-id="96"><img
                    src="{{ Vite::asset('resources/images/icon1.png') }}"
                    class="ico1" alt=""></button>
              </li>
              <li>
                <button type="button" data-type="music" data-id="96"><img src="{{ Vite::asset('resources/images/icon2.png') }}"
                                                                          class="ico2" alt=""></button>
              </li>
              <li>
                <!--<button class="is-active" type="button" class="is-active" data-type="video" data-id="3"><img src="/local/templates/lola/images/icon3.png" alt=""></button>-->
                <button type="button" data-type="video" data-id="96"><img src="{{ Vite::asset('resources/images/icon3.png') }}"
                                                                          alt=""></button>
              </li>
              <li>
                <button type="button" data-type="photo" data-id="96"><img src="{{ Vite::asset('resources/images/icon4.png') }}"
                                                                          alt=""></button>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@include('partials.admin.modal')


@include('partials.admin.menu')
<!--script1.js -  скрипт для открытия-закрытия серого меню справа-->
<script src="/js/script1.js"></script>

<script>
  const mainModal = document.querySelector('.auth-modal--main');
  const lkBtn = document.querySelector('.user_link');
  const page = document.querySelector('.page');
  const fragmentModal = document.querySelector('.fragment-modal--main');
  const fragmentItem = document.querySelectorAll('[data-type="text"]');

  let ps;

  fragmentItem.forEach(fragmentItem => {
    fragmentItem.addEventListener('click', (e) => {
      const otherBlock = document.querySelector('.fragment-modal--main');
      otherBlock.classList.toggle('hidden');
      const containermain = document.querySelector('.modal-fragment-main .modal-header-text');
      const containerreg = document.querySelector('.modal-fragment-reg .modal-header-text');
      const containerRestore = document.querySelector('.auth-modal--restore-fragment .modal-header-text');
      const containerRestoreFragment = document.querySelector('.js-restore-success-modal-fragment .modal-header-text');
      const containerContinueFragment = document.querySelector('.auth-modal--continue-fragment .modal-header-text');


      const data_int = e.currentTarget.getAttribute('data-int');
      containermain.innerHTML = `Фрагмент ${data_int}`;
    //   containerreg.innerHTML = `Фрагмент ${data_int}`;
    //   containerRestore.innerHTML = `Фрагмент ${data_int}`;
    //   containerRestoreFragment.innerHTML = `Фрагмент ${data_int}`;
    //   containerContinueFragment.innerHTML = `Фрагмент ${data_int}`;

      // получаем значение атрибутов data-*
      // использование полученных атрибутов

    });
  });


  const scrollInit = () => {
    if (document.querySelector('.content-block')) {  // чтобы не вылетал в ошибку, если нет блока
      ps = new PerfectScrollbar('.content-block', {
        wheelSpeed: 2,
        wheelPropagation: true,
        minScrollbarLength: 100,
      });
    }
    // if (!mainModal.classList.contains('hidden')) {
    //   ps.destroy();  // это для страничек статичных с окнами
    //   ps = null;
    // }
  }
  scrollInit();

  // открытие/закрытие модалок
  //
  lkBtn.addEventListener('click', (e) => {
    e.preventDefault();

    if (document.querySelector('.content-block')) { // т.е. для всех страниц, кроме index.html
      ps.destroy();
      ps = null;
    }

    const escHandler = (e) => {
      if (e.keyCode === 27) mainModal.classList.add('hidden');
      page.removeEventListener('keydown', escHandler);
      if (!ps) scrollInit();
    }

    mainModal.classList.remove('hidden');

    const closeBtnForMain = mainModal.querySelector('.modal-close-btn');
    closeBtnForMain.addEventListener('click', () => {
      mainModal.classList.add('hidden');
      if (!ps) scrollInit();
    })
    page.addEventListener('keydown', escHandler);
  })

//   const passForgotten = document.querySelector('.modal-password-forgotten');
//   const restoreModal = document.querySelector('.auth-modal--restore');
//   const closeBtnForRestore = restoreModal.querySelector('.modal-close-btn');

//   const passForgottenFragments = document.querySelector('.modal-password-forgotten-fragments');
//   const restoreModalFragment = document.querySelector('.auth-modal--restore-fragment');
//   const closeBtnForRestoreFragment = restoreModalFragment.querySelector('.modal-close-btn');


//   passForgotten.addEventListener('click', (e) => {
//     e.preventDefault();

//     const escHandler = (e) => {
//       if (e.keyCode === 27) restoreModal.classList.add('hidden');
//       page.removeEventListener('keydown', escHandler);
//       if (!ps) scrollInit();
//     }

//     mainModal.classList.add('hidden');
//     restoreModal.classList.remove('hidden');

//     closeBtnForRestore.addEventListener('click', () => {
//       restoreModal.classList.add('hidden');
//       if (!ps) scrollInit();
//     })
//     page.addEventListener('keydown', escHandler);

//     if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
//       ps.destroy();
//       ps = null;
//     }


//   })


//   passForgottenFragments.addEventListener('click', (e) => {
//     e.preventDefault();

//     const escHandler = (e) => {
//       if (e.keyCode === 27) restoreModalFragment.classList.add('hidden');
//       page.removeEventListener('keydown', escHandler);
//       if (!ps) scrollInit();
//     }

//     fragmentModal.classList.add('hidden');
//     restoreModalFragment.classList.remove('hidden');

//     closeBtnForRestoreFragment.addEventListener('click', () => {
//       restoreModalFragment.classList.add('hidden');
//       if (!ps) scrollInit();
//     })
//     page.addEventListener('keydown', escHandler);

//     if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
//       ps.destroy();
//       ps = null;
//     }


//   })


//   const regBtn = [...document.querySelectorAll('.modal-auth-btn--reg')];
//   const loginButton = [...document.querySelectorAll('.modal-auth-btn--user')];
//   const regModal = document.querySelector('.auth-modal--reg');
//   const closeBtnForReg = regModal.querySelector('.modal-close-btn');
//   const continueRegBtn = regModal.querySelector('.auth-modal__reg-btn-one');


//   const regBtnFragment = [...document.querySelectorAll('.modal-auth-btn--reg-fragment')];
//   const loginButtonFragment = [...document.querySelectorAll('.modal-auth-btn--user-fragment')];
//   const regModalFragment = document.querySelector('.auth-modal--reg-fragment');
//   const closeBtnForRegFragment = regModalFragment.querySelector('.modal-close-btn');
//   const continueRegBtnFragment = regModalFragment.querySelector('.auth-modal__reg-btn-fragment');

//   regBtnFragment.forEach((button, i) => {
//     button.addEventListener('click', () => {
//       const escHandler = (e) => {
//         if (e.keyCode === 27) regModalFragment.classList.add('hidden');
//         page.removeEventListener('keydown', escHandler);
//         if (!ps) scrollInit();
//       }

//       fragmentModal.classList.add('hidden');
//       regModalFragment.classList.remove('hidden');

//       closeBtnForRegFragment.addEventListener('click', () => {
//         regModal.classList.add('hidden');
//         if (!ps) scrollInit();
//       })
//       page.addEventListener('keydown', escHandler);

//       if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
//         ps.destroy();
//         ps = null;
//       }

//       // кнопка Продолжить:

//       continueRegBtnFragment.addEventListener('click', (e) => {
//         e.preventDefault();
//         const continueModal = document.querySelector('.auth-modal--continue-fragment');
//         const closeBtnForContinue = continueModal.querySelector('.modal-close-btn');

//         const escHandler = (e) => {
//           if (e.keyCode === 27) continueModal.classList.add('hidden');
//           page.removeEventListener('keydown', escHandler);
//           if (!ps) scrollInit();
//         }
//         regModalFragment.classList.add('hidden');
//         continueModal.classList.remove('hidden');


//         closeBtnForContinue.addEventListener('click', () => {
//           continueModal.classList.add('hidden');
//           if (!ps) scrollInit();
//         })
//         page.addEventListener('keydown', escHandler);

//         if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
//           ps.destroy();
//           ps = null;
//         }

//       })
//     })
//   })
//   loginButtonFragment.forEach((e, i) => {
//     e.addEventListener('click', () => {
//       fragmentModal.classList.remove('hidden');
//       regModalFragment.classList.add('hidden');
//     })
//   })


//   regBtn.forEach((button, i) => {
//     button.addEventListener('click', () => {
//       const escHandler = (e) => {
//         if (e.keyCode === 27) regModal.classList.add('hidden');
//         page.removeEventListener('keydown', escHandler);
//         if (!ps) scrollInit();
//       }

//       mainModal.classList.add('hidden');
//       regModal.classList.remove('hidden');

//       closeBtnForReg.addEventListener('click', () => {
//         regModal.classList.add('hidden');
//         if (!ps) scrollInit();
//       })
//       page.addEventListener('keydown', escHandler);

//       if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
//         ps.destroy();
//         ps = null;
//       }

//       // кнопка Продолжить:

//       continueRegBtn.addEventListener('click', (e) => {
//         e.preventDefault();
//         const continueModalOne = document.querySelector('.auth-modal--continue-one');
//         const closeBtnForContinueModal = document.querySelector('.modal-close-btn-continue');
//         const escHandler = (e) => {
//           if (e.keyCode === 27) continueModalOne.classList.add('hidden');
//           page.removeEventListener('keydown', escHandler);
//           if (!ps) scrollInit();
//         }
//         regModal.classList.add('hidden');
//         continueModalOne.classList.remove('hidden');


//         closeBtnForContinueModal.addEventListener('click', () => {
//           continueModalOne.classList.add('hidden');
//           if (!ps) scrollInit();
//         })
//         page.addEventListener('keydown', escHandler);

//         if (document.querySelector('.content-block') && ps) { // т.е. для всех страниц, кроме index.html
//           ps.destroy();
//           ps = null;
//         }

//       })
//     })
//   })
//   loginButton.forEach((e, i) => {
//     e.addEventListener('click', () => {
//       mainModal.classList.remove('hidden');
//       regModal.classList.add('hidden');
//     })
//   })

//   // Появление надписи "неправильный пароль или имейл" по кнопке Вход

//   const loginBtn = document.querySelector('.auth-modal__login-btn');
//   const loginErrorMessage = document.querySelector('.login-error-message');

//   if (loginBtn) {
//     loginBtn.addEventListener('click', (e) => {
//       e.preventDefault();
//       loginErrorMessage.classList.toggle('show');
//     })
//   }


//   const loginBtnFragment = document.querySelector('.auth-modal__login-btn-fragment');
//   const loginErrorMessageFragment = document.querySelector('.login-error-message-fragment');

//   if (loginBtnFragment) {
//     loginBtnFragment.addEventListener('click', (e) => {
//       e.preventDefault();
//       loginErrorMessageFragment.classList.toggle('show');
//     })
//   }

//   // скрипт убирает звезду, когда в инпуте появляется текст (и возвращает обратно, когда текст убирается)
//   const inputWithStarsAll = document.querySelectorAll('.feedback-input--with-star');
//   inputWithStarsAll.forEach((input) => {
//     const starInputLabel = input.closest('.form-placeholder-wrapper').querySelector('.star-input-label');
//     input.addEventListener('input', (e) => {
//       if (e.target.value !== '') starInputLabel.classList.add('hidden');
//       if (e.target.value === '') starInputLabel.classList.remove('hidden');
//     })
//   })


//   const restoreButton = [...document.querySelectorAll('.js-restore-button')];
//   const resoreSuccessModal = document.querySelector('.js-restore-success-modal');
//   restoreButton.forEach((element, index) => {
//     element.addEventListener('click', function (event) {
//       restoreModal.classList.add('hidden');
//       resoreSuccessModal.classList.remove('hidden');
//       event.preventDefault();
//     })
//   })


//   const restoreButtonFragment = [...document.querySelectorAll('.js-restore-button-fragment')];
//   const resoreSuccessModalFragment = document.querySelector('.js-restore-success-modal-fragment');
//   restoreButtonFragment.forEach((element, index) => {
//     element.addEventListener('click', function (event) {
//       restoreModalFragment.classList.add('hidden');
//       resoreSuccessModalFragment.classList.remove('hidden');
//       event.preventDefault();
//     })
//   })

  const closeModalBtn = [...document.querySelectorAll('.modal-close-btn')]
  closeModalBtn.forEach((el) => {
    el.addEventListener('click', () => {
      let m = el.closest('.auth-modal');
      m.classList.add('hidden');
    })
  });


  // let fragmentCart = [...document.querySelectorAll('.js-fragment-cart')],
  //     fragmentCartModal = document.querySelector('.js-modal-lk-nr-1');
  // fragmentCart.forEach((element) => {
  //   element.addEventListener('click', function () {
  //     fragmentCartModal.classList.remove('hidden');
  //   })
  // })

</script>
<!--<script src="js/script.js"></script>-->





<script src="/js/vendorb164.js?v=1674558313"></script>
<script src="/js/mainb164.js?v=1674558313"></script>
</body>

</html>
