<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Стартовый шаблон</title>
    <link rel="stylesheet" href="/css/main.css"/>
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet"/>

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
                    <li>{{ __('header.menu.home') }}</li>
                    <li>{{ __('header.menu.about') }}</li>
                    <li>{{ __('header.menu.copyright') }}</li>
                    <li>{{ __('header.menu.commercial') }}</li>
                    <li>{{ __('header.menu.privacy') }}</li>
                    <li>{{ __('header.menu.contacts') }}</li>
                    <li>
                        <button class="lk">
                            <img src="img/user.png" alt="user">
                            <span>{{ __('header.personal') }}</span>
                        </button>
                    </li>
                    <li>
                        <button class="menu">
                            <span>{{ __('header.menuBtn') }}</span>
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
			<div class="video-js"></div>
            {{-- <video  class="video-js"
                    controls
                    data-setup="{}"  poster="/img/player.png">
                Your browser does not support the video tag.
            </video>
            <img class="resize" src="/img/resize.png" alt="resize"> --}}
        </div>
        <div class="main__center main__desk">
            <div class="main__row">
                <div class="main__player player">
                    <div class="player__top">
                        <span>Видео</span>
                        <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1</span>
                        <span>Заглавие</span>
                    </div>
                    {{-- <video poster="img/player.png" 
						class="video-js"
                           controls
                           preload="auto"
                           data-setup="{}" >
                        Your browser does not support the video tag.
                    </video>
                    <img class="resize" src="img/resize.png" alt="resize"> --}}
                </div>
				@foreach (range(1, 7) as $number)
					<div class="main__column column ">
						<button class="column__top">
							<span><span class="frag">{{ __('home.fragment') }}</span><br/><span class="number"><span>№</span>{{ $number }}</span></span>
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
				@endforeach
            </div>
            <div class="main__row">
				@foreach (range(7, 17) as $number)
					<div class="main__column column ">
						<button class="column__top">
							<span>
								<span class="frag">{{ __('home.fragment') }}</span>
								<br/>
								<span class="number @if ($number >= 10)number__br @endif">
									<span>№</span>
									@if ($number <= 9)
										{{ $number }}
									@else
										<span>{{ $number }}</span>
									@endif
								</span>
							</span>
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
				@endforeach
            </div>
        </div>

        <div class="main__center main__tablet">
            <div class="main__player player">
                <div class="player__top">
                    <span>Видео<span class="table-only">.</span></span>
                    <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1<span class="table-only">.</span></span>
                    <span>Заглавие</span>
                </div>
                {{-- <video  poster="img/player.png" class="video-js"
                        controls
                        preload="auto"
                        data-setup="{}">
                    Your browser does not support the video tag.
                </video>
                <img class="resize" src="img/resize.png" alt="resize"> --}}
            </div>
            <div class="main__row">
				@foreach (range(1, 17) as $number)
					<div class="main__column column ">
						<button class="column__top">
							<span><span class="frag">{{ __('home.fragment') }}</span><br/><span class="number">№</span>{{ $number }}</span>
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
				@endforeach
            </div>
        </div>
		
        <div class="drawer drawer__close" id="menu">
            <div class="drawer__top">
                <button class="close"><img src="../img/close.png" alt="close"></button>
            </div>
            <button class="drawer__element">
                <span>{{ __('header.menu.home') }}</span>
            </button>
            <button class="drawer__element">
                <span>{{ __('header.menu.about') }}</span>
            </button>
            <button class="drawer__element">
                <span>{{ __('header.menu.copyright_side') }}</span>
            </button>
            <button class="drawer__element">
                <span>{{ __('header.menu.commercial_side') }}</span>
            </button>
            <button class="drawer__element">
                <span>{{ __('header.menu.privacy_side') }}</span>
            </button>
            <button class="drawer__element">
                <span>{{ __('header.menu.contacts') }}</span>
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
