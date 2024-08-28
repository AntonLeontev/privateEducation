@extends('layouts.app.app')

@section('title', __('home.title'))

@section('css')
    <link rel="stylesheet" href="/css/main.css" />
    {{-- <link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" /> --}}
	@vite(['node_modules/video.js/dist/video-js.min.css'])
	<style>
		.opacity-100 {
			opacity: 1 !important;
		}
	</style>
@endsection

@section('content')
    <main>
		<script>
			let fragments = @json($fragments);
		</script>
        <div class="main" id="fragments" x-data="{
			player: null,
			fragments: fragments,
			modal: null,
			selectedFragment: null,
			playingFragment: null,
			playingMedia: 'presentation',

			init() {
				this.playingFragment = this.fragments[0];

				this.$nextTick(() => {
					this.player = videojs('player', {
						controls: true,
						muted: true,
					});

					this.player.on('ended', () => {
						this.playingFragment = this.fragments[this.playingFragment.id === 17 ? 0 : this.playingFragment.id]
						this.player.src({
							type: this.playingFragment[this.playingMedia].media[0].format, 
							src: `/media/${this.playingMedia}/${this.playingFragment.id}/{{ loc() }}/stereo/notebook` 
						})
						this.$dispatch('play-media-start')
						this.player.play()
					});

					this.player.src({
						type: this.playingFragment[this.playingMedia].media[0].format, 
						{{-- src: `/media/${this.playingMedia}/${this.playingFragment.id}/{{ loc() }}/${this.sound}/${this.device}`  --}}
						src: `/media/${this.playingMedia}/${this.playingFragment.id}/{{ loc() }}/stereo/notebook` 
					})
					this.player.play()
					
					{{-- this.player.removeChild('BigPlayButton'); --}}
				})
			},
			activateFragment(id) {
				this.selectedFragment = this.fragments
					.find(el => el.id === id)
			},
			activateVideo(id) {
				this.activateFragment(id)
				this.modal = 'video'
			},
			activateAudio(id) {
				this.activateFragment(id)
				this.modal = 'audio'
			},
			activatePresentation(id) {
				this.activateFragment(id)
				this.modal = 'presentation'
			},
			activateBuySteps(id) {
				this.activateFragment(id)
				this.modal = 'buy'
			},
			buyClasses(id) {
				return {'opacity-100': this.selectedFragment === id}
			},
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
                                <span x-show="playingMedia === 'audio'" x-cloak>{{ __('home.audio') }}</span>
                                <span x-show="playingMedia === 'video'" x-cloak>{{ __('home.video') }}</span>
                                <span x-show="playingMedia === 'presentation'" x-cloak>{{ __('home.presentation') }}</span>
                                <span style="margin-top: 4px">
									<span class="frag">{{ __('home.fragment') }}</span> 
									<span class="number">№</span><!--
									--><span x-text="playingFragment?.id">1</span>
								</span>
								<style>
									.runningline-wrap {
										position: relative;
										width: 100%;
										overflow: hidden;
										padding-bottom: 3px;
									}
									.runningline {
										display: block;
										position: relative;
										right: 0;
										transition-timing-function: linear;
										transition-property: all;
										white-space: nowrap;
										width: max-content;
										overflow: visible !important;
									}
								</style>
								<div 
									class="runningline-wrap" 
									x-data="runningLine" 
									x-ref="lineWrap"
									@play-media-start.window="reset"
								>
									<span 
										class="runningline" 
										x-text="playingFragment?.title_{{ loc() }}" x-ref="line"
									>Заглавие</span>
								</div>
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
                        @foreach (range(1, 6) as $number)
                            <div class="main__column column" id="fragment{{ $number }}" x-data="{id: {{ $number }}}">
                                <div class="column__top"
									:style="selectedFragment?.id === id && modal === 'buy' && {background: 'rgba(233, 117, 44, 1)'}"
								>
                                    <span><span class="frag">{{ __('home.fragment') }}</span><br /><span
                                            class="number"><span>№</span>{{ $number }}</span></span>
                                </div>
                                <div class="polygon">
                                    <button class="column__shop" 
										@click="activateBuySteps(id)" 
										:class="{'opacity-100': selectedFragment?.id === id && modal === 'buy'}"
									>
                                        <img src="/img/korzina.png" alt="shop">
                                    </button>
                                    <button class="column__audio" 
										@click="activateAudio(id)"
										:class="{'opacity-100': selectedFragment?.id === id && modal === 'audio'}"
									>
                                        <img src="/img/audio.png" alt="shop">
                                    </button>
                                    <button class="column__video" @click="activateVideo(id)">
                                        <img src="/img/video.png" alt="shop">
                                    </button>
                                    <button class="column__search" @click="activatePresentation(id)">
                                        <img src="/img/present.png" alt="shop">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="main__row">
                        @foreach (range(7, 17) as $number)
                            <div class="main__column column" id="fragment{{ $number }}" x-data="{id: {{ $number }}}">
                                <div class="column__top">
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
                                </div>
                                <div class="polygon">
                                    <button class="column__shop" @click="activateBuySteps(id)">
                                        <img src="/img/korzina.png" alt="shop">
                                    </button>
                                    <button class="column__audio" @click="activateAudio(id)">
                                        <img src="/img/audio.png" alt="shop">
                                    </button>
                                    <button class="column__video" @click="activateVideo(id)">
                                        <img src="/img/video.png" alt="shop">
                                    </button>
                                    <button class="column__search" @click="activatePresentation(id)">
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
                            <span>
								<span class="frag">{{ __('home.fragment') }}</span> 
								<span class="number">№</span>
								<span x-text="playingFragment?.id">1</span>
								<span class="table-only">.</span>
							</span>
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
                            <div class="main__column column" id="fragment-mobile{{ $number }}" x-data="{id: {{ $number }}}">
                                <button class="column__top">
                                    <span><span class="frag">{{ __('home.fragment') }}</span><br /><span
                                            class="number">№</span>{{ $number }}</span>
                                </button>
                                <div class="polygon">
                                    <button class="column__shop" @click="activateBuySteps(id)">
                                        <img src="/img/korzina.png" alt="shop">
                                    </button>
                                    <button class="column__audio" @click="activateAudio(id)">
                                        <img src="/img/audio.png" alt="shop">
                                    </button>
                                    <button class="column__video" @click="activateVideo(id)">
                                        <img src="/img/video.png" alt="shop">
                                    </button>
                                    <button class="column__search" @click="activatePresentation(id)">
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
					<video id="player" class="video-js" poster="/img/player.png">
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

				<style>
					#dialog1 {
						visibility: visible;
					}
				</style>
                <div id="dialog1" x-show="modal === 'audio'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.audio.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="modal = null">

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

    {{-- <script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script> --}}
	<script>
		document.addEventListener('alpine:init', () => {
			Alpine.data('runningLine', () => ({
				shift: null,
				timerId: null,

				init() {
					this.$nextTick(() => {
						this.shift = this.$refs.lineWrap.offsetWidth - this.$refs.line.offsetWidth
						this.timerId = setTimeout(() => this.moveLeft(), 500)
					})
				},
				reset() {
					clearTimeout(this.timerId);

					this.$refs.line.classList.remove('transition')
					this.$refs.line.classList.remove('ease-linear')
					this.$refs.line.style.transitionDuration = '0s'
					this.$refs.line.style.transform = `translateX(0px)`
					
					
					this.$nextTick(() => {
						this.$refs.line.classList.add('transition')
						this.$refs.line.classList.add('ease-linear')
						this.shift = this.$refs.lineWrap.offsetWidth - this.$refs.line.offsetWidth
						this.moveLeft()
					})
					
				},
				moveLeft() {
					this.timerId = setTimeout(() => {
						if (this.shift >= 0) return

						this.$refs.line.style.transitionDuration = Math.abs(this.shift) * 10 + 'ms'
						this.$refs.line.style.transform = `translateX(${this.shift}px)`

						this.$refs.line.ontransitionend = () => {
							this.moveRight()
						}
					}, 500)
				},
				moveRight() {
					this.timerId = setTimeout(() => {
						if (this.shift >= 0) return

						this.$refs.line.style.transform = `translateX(1px)`

						this.$refs.line.ontransitionend = () => {
							this.moveLeft()
						}
					}, 500)
				},
			}))
		})
	</script>
	@vite(['resources/js/index.js'])
@endsection
