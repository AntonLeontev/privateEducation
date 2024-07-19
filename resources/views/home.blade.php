@extends('layouts.app.app')

@section('title', 'main')

@section('css')
    <link rel="stylesheet" href="/css/main.css" />
    <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
@endsection

@section('content')
    <main>
		<script>
			let fragments = @json($fragments);
		</script>
        <div class="main" id="fragments" x-data="{
			fragments: fragments,
			activeFragment: null,
		}">
            <div class="container">
                @include('partials.app.header')
				
                <div class="player-mobile">
                    <div class="player-mobile__top">
                        <span>Видео.</span>
                        <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1.</span>
                        <span>Заглавие</span>
                    </div>
                    <div class="video-js" style="background-color: transparent"></div>
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
                                <span>Презентация: <span class="frag">Фрагмент</span> <span
                                        class="number">№</span>1</span>
                                <span>Заглавие</span>
                            </div>
                            {{-- <video poster="img/player.png" 
							class="video-js"
							controls
							preload="auto"
							data-setup="{}" >
							Your browser does not support the video tag.
						</video>
						<img class="resize" src="/img/resize.png" alt="resize"> --}}
                        </div>
                        @foreach (range(1, 7) as $number)
                            <div class="main__column column" id="fragment{{ $number }}">
                                <button class="column__top">
                                    <span><span class="frag">{{ __('home.fragment') }}</span><br /><span
                                            class="number"><span>№</span>{{ $number }}</span></span>
                                </button>
                                <div class="polygon">
                                    <button class="column__shop">
                                        <img src="/img/korzina.png" alt="shop">
                                    </button>
                                    <button class="column__audio">
                                        <img src="/img/audio.png" alt="shop">
                                    </button>
                                    <button class="column__video">
                                        <img src="/img/video.png" alt="shop">
                                    </button>
                                    <button class="column__search">
                                        <img src="/img/present.png" alt="shop">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="main__row">
                        @foreach (range(7, 17) as $number)
                            <div class="main__column column" id="fragment{{ $number }}">
                                <button class="column__top">
                                    <span>
                                        <span class="frag">{{ __('home.fragment') }}</span>
                                        <br />
                                        <span class="number @if ($number >= 10) number__br @endif">
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
                                        <img src="/img/korzina.png" alt="shop">
                                    </button>
                                    <button class="column__audio">
                                        <img src="/img/audio.png" alt="shop">
                                    </button>
                                    <button class="column__video">
                                        <img src="/img/video.png" alt="shop">
                                    </button>
                                    <button class="column__search">
                                        <img src="/img/present.png" alt="shop">
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
                            <span>Презентация: <span class="frag">Фрагмент</span> <span class="number">№</span>1<span
                                    class="table-only">.</span></span>
                            <span>Заглавие</span>
                        </div>
                        {{-- <video  poster="img/player.png" class="video-js"
							controls
							preload="auto"
							data-setup="{}">
						Your browser does not support the video tag.
					</video>
					<img class="resize" src="/img/resize.png" alt="resize"> --}}
                    </div>
                    <div class="main__row">
                        @foreach (range(1, 17) as $number)
                            <div class="main__column column">
                                <button class="column__top">
                                    <span><span class="frag">{{ __('home.fragment') }}</span><br /><span
                                            class="number">№</span>{{ $number }}</span>
                                </button>
                                <div class="polygon">
                                    <button class="column__shop">
                                        <img src="/img/korzina.png" alt="shop">
                                    </button>
                                    <button class="column__audio">
                                        <img src="/img/audio.png" alt="shop">
                                    </button>
                                    <button class="column__video">
                                        <img src="/img/video.png" alt="shop">
                                    </button>
                                    <button class="column__search">
                                        <img src="/img/present.png" alt="shop">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @include('partials.app.sidebar')

                <style>
                    .video {
                        position: absolute;
                        top: 187px;
                        width: 522px;
                        aspect-ratio: 16/9;
                        z-index: 999;
                    }

                    .video.video_expanded {
                        top: 110px;
                        left: 381px;
                        right: 302px;
                        bottom: 270px;
                        width: auto;
                    }

                    .video .video-js {
                        width: 100%;
                        height: 100%;
                        /* max-height: 294px; */
                    }

                    .video .resize-buttons {
                        position: absolute;
                        right: 13px;
                        top: 15px;
                        height: 47px;
                        width: 47px;
                        opacity: 0.74;
                    }

                    @media screen and (max-width: 680px) and (orientation: portrait) {
                        .video {
                            top: calc(3vw + 3.8vw + 2vw + 4.5vw + 1.2vw + 5.3vw);
                            width: 100%;
                        }

                        .video .video-js {
                            max-height: unset;
                        }

                        .video .resize-buttons {
                            display: none;
                        }
                    }

                    @media screen and (max-width: 1024px) and (orientation: landscape) {
                        .video {
                            top: calc(0.7vw + 4px + 4.173vw + 0.79vw + 0.42vw + 4vw + 0.54vw);
                            width: 48.3962vw;
                        }

                        .video .resize-buttons {
                            display: none;
                        }
                    }

                    @media screen and (max-width: 1024px) and (orientation: landscape) and (max-width: 800px) and (min-width: 701px) {
                        .video {
                            /* top: calc(0.7vw + 4px + 4.173vw + 0.79vw + 0.42vw + 4vw + 0.54vw); */
                            width: calc(100vw - 3.661vw - 3.031vw - 4.055vw - 37.98vw);
                        }
                    }

                    @media screen and (max-width: 1024px) and (orientation: landscape) and (max-width: 700px) {
                        .video {
                            width: 59.0293vw;
                        }
                    }
                </style>
                <div class="video" :class="isExpanded && 'video_expanded'" x-data="{
                    isExpanded: false,
                }">
                    <video class="video-js" controls data-setup="{}" poster="/img/player.png">
                        Your browser does not support the video tag.
                    </video>
                    <div class="resize-buttons" @click="isExpanded = !isExpanded">
                        <button x-show="!isExpanded">
                            <img class="" src="/img/resize.png" alt="resize">
                        </button>
                        <button x-show="isExpanded" x-cloak>
                            <img class="" src="/img/expand-in.png" alt="expand in">
                        </button>
                    </div>
                </div>


                <div id="dialog1">
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.audio.title') }}8</h4>
                        <button class="dialog__close">

                        </button>
                    </div>
                    <div class="dialog__center">
                        <h5>{{ __('home.windows.audio.1') }}<br />
                            {{ __('home.windows.audio.2') }}</h5>
                        <form>
                            <div class="dialog__checkbox">
                                <input id="vehicle1" type="radio" name="vehicle1" value="Bike">
                                <label for="vehicle1">{{ __('home.windows.audio.mono1') }} <span>{{ __('home.windows.audio.mono2') }}</span></label><br>
                            </div>
                            <div class="dialog__checkbox">
                                <input id="vehicle2" type="radio" name="vehicle1" value="Bikew">
                                <label for="vehicle2">{{ __('home.windows.audio.stereo1') }} <span>{{ __('home.windows.audio.stereo2') }}</span></label><br>
                            </div>
                            <div class="sub">
                                {{ __('home.windows.audio.duration') }}25:02
                            </div>
                            <div class="sep">

                            </div>
                            <h5>{{ __('home.windows.audio.device') }}</h5>
                            <div class="dialog__checkbox">
                                <input id="vehicle3" type="radio" name="vehicle2" value="Bike">
                                <label for="vehicle3">{{ __('home.windows.audio.mobile1') }} <span>{{ __('home.windows.audio.mobile2') }}</span></label><br>
                            </div>
                            <div class="dialog__checkbox">
                                <input id="vehicle4" type="radio" name="vehicle2" value="Bike2">
                                <label for="vehicle4">{{ __('home.windows.audio.tablet') }}</label><br>
                            </div>
                            <div class="dialog__checkbox">
                                <input id="vehicle5" type="radio" name="vehicle2" value="Bike3">
                                <label for="vehicle5">{{ __('home.windows.audio.notebook') }}</label><br>
                            </div>
                            <img class="dialog__dostup" src="/img/dostup.png" alt="">

                            <h3>{{ __('home.windows.audio.access_granted') }}</h3>
                        </form>
                        <button>
                            <img src="/img/play.png" alt="play">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>
    <script src="/js/index.bundle.js"></script>
@endsection
