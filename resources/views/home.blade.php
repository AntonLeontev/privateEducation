<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Стартовый шаблон</title>
    <link rel="stylesheet" href="/css/main.css"/>
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet"/>
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP&display=swap" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script> --}}

	<style>
        [x-cloak] {display: none; !important}
    </style>

	@routes
    @vite(['resources/js/app.js'])
</head>
<body>
<main>
    <div class="main">
    <div class="container">
        <header>
            <nav>
                <ul>
                    <li>Главная</li>
                    <li>О компании</li>
                    <li>Impression</li>
                    <li>AGB</li>
                    <li>Datenschutz</li>
                    <li>Контакты</li>
                    <li>
                        <button class="lk">
                            <img src="img/user.png" alt="user">
                            <span>Личный кабинет</span>
                        </button>
                    </li>
                    <li>
                        <button class="menu">
                            <span>Меню</span>
                            <div class="menu__burger">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>
                    </li>
                </ul>
            </nav>
        </header>
        <div class="player-mobile">
            <div class="player-mobile__top">
                <span>Видео.</span>
                <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1.</span>
                <span>Заглавие</span>
            </div>
            <video  class="video-js"
                    controls
                    data-setup="{}"  poster="img/player.png">
                Your browser does not support the video tag.
            </video>
            <img class="resize" src="img/resize.png" alt="resize">
        </div>
        <div class="main__center main__desk">
            <div class="main__row">
                <div class="main__player player">
                    <div class="player__top">
                        <span>Видео</span>
                        <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1</span>
                        <span>Заглавие</span>
                    </div>
                    <video poster="img/player.png" class="video-js"
                           controls
                           preload="auto"
                           data-setup="{}" >
                        Your browser does not support the video tag.
                    </video>
                    <img class="resize" src="img/resize.png" alt="resize">
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>1</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>2</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>3</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>4</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>5</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>6</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
            </div>
            <div class="main__row">
                <div class="main__column column ">
                    <div class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>7</span></span>
                    </div>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>8</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number"><span>№</span>9</span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>10</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 1 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>11</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 2 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>12</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 3 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>13</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 4 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>14</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 5 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>15</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 6 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>16</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 7 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number number__br"><span>№</span><span>17</span></span></span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="main__center main__tablet">
            <div class="main__player player">
                <div class="player__top">
                    <span>Видео<span class="table-only">.</span></span>
                    <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1<span class="table-only">.</span></span>
                    <span>Заглавие</span>
                </div>
                <video  poster="img/player.png" class="video-js"
                        controls
                        preload="auto"
                        data-setup="{}">
                    Your browser does not support the video tag.
                </video>
                <img class="resize" src="img/resize.png" alt="resize">
            </div>
            <div class="main__row">
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 1</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 2</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 3</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 4</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 5</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 6</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <div class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 7</span>
                    </div>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 8</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 9</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 0 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 10</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 1 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 11</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 2 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 12</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 3 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 13</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 4 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 14</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 5 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 15</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 6 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 16</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
                <div class="main__column column 7 ">
                    <button class="column__top">
                        <span><span class="frag">Фрагмент</span><br/><span class="number">№</span> 17</span>
                    </button>
                    <div class="polygon">
                        <button class="column__shop">
                            <img src="img/korzina.png" alt="shop">
                        </button>
                        <button class="column__audio">
                            <img src="img/audio.png" alt="shop">
                        </button>
                        <button class="column__video">
                            <img src="img/video.png" alt="shop">
                        </button>
                        <button class="column__search">
                            <img src="img/present.png" alt="shop">
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="drawer drawer__close" id="menu">
            <div class="drawer__top">
                <button class="close"><img src="../img/close.png" alt="close"></button>
            </div>
            <button class="drawer__element">
                <span>Главная</span>
            </button>
            <button class="drawer__element">
                <span>О компании</span>
            </button>
            <button class="drawer__element">
                <span>Авторское право</span>
            </button>
            <button class="drawer__element">
                <span>Общие<br/> коммерческие условия</span>
            </button>
            <button class="drawer__element">
                <span>Политика конфеденциальности</span>
            </button>
            <button class="drawer__element">
                <span>Контакты</span>
            </button>
            <div class="drawer__element">
            </div>
            <div class="drawer__element">
            </div>
            <div class="drawer__element">
            </div>
            <div class="drawer__element">
            </div>
        </div>
        <div id="dialog1" >
            <div class="dialog__top">
                <h4>Полное содержание. Фрагмент №8</h4>
                <button class="dialog__close">

                </button>
            </div>
            <div class="dialog__center">
                <h5>Аудио формат для прослушивания<br/>
                    на сайте</h5>
                <form>
                    <div class="dialog__checkbox">
                        <input type="radio" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">В моно <span>(обработанный объемный голос)</span></label><br>
                    </div>
                    <div class="dialog__checkbox">
                        <input type="radio" id="vehicle2" name="vehicle1" value="Bikew">
                        <label for="vehicle2">В стерео <span>(живой голос)</span></label><br>
                    </div>
                    <div class="sub">
                        Продолжительность записи в минутах - 25:02
                    </div>
                    <div class="sep">

                    </div>
                    <h5>Устройство воспроизведения:</h5>
                    <div class="dialog__checkbox">
                        <input type="radio" id="vehicle3" name="vehicle2" value="Bike">
                        <label for="vehicle3">Мобильная версия <span>(apple, android)</span></label><br>
                    </div>
                    <div class="dialog__checkbox">
                        <input type="radio" id="vehicle4" name="vehicle2" value="Bike2">
                        <label for="vehicle4">Планшет</label><br>
                    </div>
                    <div class="dialog__checkbox">
                        <input type="radio" id="vehicle5" name="vehicle2" value="Bike3">
                        <label for="vehicle5">Ноутбук</label><br>
                    </div>
                    <img class="dialog__dostup" src="../img/dostup.png" alt="">

                    <h3>ДОСТУП АКТИВИРОВАН</h3>
                </form>
                <button>
                    <img src="../img/play.png" alt="play">
                </button>
            </div>
        </div>
    </div>
</div>
</main>
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
<script src="/js/index.bundle.js"></script>
</body>
</html>
