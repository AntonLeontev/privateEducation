@extends('layouts.app.app')

@section('title', __('home.title'))

@section('css')
    {{-- <link rel="stylesheet" href="/css/main.css" /> --}}
    @vite(['resources/css/index.css', 'node_modules/video.js/dist/video-js.min.css', 'resources/js/index.js'])

    {{-- Video --}}
    <style>
        .video-player {
            position: absolute;
            top: 187px;
            width: 522px;
            aspect-ratio: 16/9;
            z-index: 999;
        }

        .video-player.video_expanded {
            top: 110px;
            left: 381px;
            right: 302px;
            bottom: 270px;
            width: auto;
        }

        .video-player .video-js {
            width: 100%;
            height: 100%;
            /* max-height: 294px; */
        }

        .video-player .resize-buttons {
            position: absolute;
            right: 13px;
            top: 15px;
            height: 47px;
            width: 47px;
            opacity: 0.74;
        }

        @media screen and (max-width: 680px) and (orientation: portrait) {
            .video-player {
                top: calc(3vw + 3.8vw + 2vw + 4.5vw + 1.2vw + 5.3vw);
                width: 100%;
            }

            .video-player .video-js {
                max-height: unset;
            }

            .video-player .resize-buttons {
                display: none;
            }
        }

        @media screen and (max-width: 1024px) and (orientation: landscape) {
            .video-player {
                top: calc(0.7vw + 4px + 4.173vw + 0.79vw + 0.42vw + 4vw + 0.54vw);
                width: 48.3962vw;
            }

            .video-player .resize-buttons {
                display: none;
            }
        }

        @media screen and (max-width: 1024px) and (orientation: landscape) and (max-width: 800px) and (min-width: 701px) {
            .video-player {
                width: calc(100vw - 3.661vw - 3.031vw - 4.055vw - 37.98vw);
            }
        }

        @media screen and (max-width: 1024px) and (orientation: landscape) and (max-width: 700px) {
            .video-player {
                width: 59.0293vw;
            }
        }
    </style>
@endsection

@section('content')
    <main>
        <script>
            let fragments = @json($fragments);
        </script>
        <div id="fragments" class="main" x-data="{
            player: null,
            fragments: fragments,
            modal: null,
            selectedFragment: null,
			mediaForBuy: 'audio',
            playingFragment: null,
            playingMedia: 'presentation',
			sound: 'stereo',
			device: 'notebook',
        
            init() {
                this.playingFragment = this.fragments[0];

				const queryString = window.location.search;
				const urlParams = new URLSearchParams(queryString);

				if (urlParams.has('fragment_id')) {
					this.activateFragment(urlParams.get('fragment_id'));
				}

				if (urlParams.has('media_type')) {
					this.mediaForBuy = urlParams.get('media_type');
				}

				if (urlParams.has('step')) {
					this.modal = urlParams.get('step');
				}

				history.pushState({}, '', location.pathname);
        
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
                        src: `/media/${this.playingMedia}/${this.playingFragment.id}/{{ loc() }}/${this.sound}/${this.device}` 
                    })
                    this.player.play()
                })
            },
            activateFragment(id) {
                this.selectedFragment = this.fragments
                    .find(el => el.id == id)
            },
			deactivateFragment() {
				this.selectedFragment = null
				this.modal = null
			},
            activateVideo(id) {
                this.activateFragment(id)
                this.modal = 'video'

				if (this.sound = 'text') {
					this.sound = 'stereo'
				}
            },
            activateAudio(id) {
                this.activateFragment(id)
                this.modal = 'audio'

				if (this.sound = 'text') {
					this.sound = 'stereo'
				}
            },
            activatePresentation(id) {
                this.activateFragment(id)
                this.modal = 'presentation'
            },
            activateStep1(id) {
                this.activateFragment(id)
				this.mediaForBuy = this.modal ?? 'audio'
                this.modal = 'step1'
            },
			isSelected(id, type = null) {
				if (type === null) {
					return this.selectedFragment?.id === id
				}
				return this.selectedFragment?.id === id && this.modal === type
			},
			isPlaying(id, type = null) {
				if (type === null) {
					return this.playingFragment?.id === id
				}
				return this.playingFragment?.id === id && this.playingMedia === type
			},
			play(mediaType) {
				if (mediaType === 'presentation' && this.sound === 'text') {
					this.modal = 'text'
				} 
			},
			audioPrice() {
				if (this.selectedFragment === null) {
					return {amount: 0}
				}

				return this.selectedFragment.audio.price
			},
			videoPrice() {
				if (this.selectedFragment === null) {
					return {amount: 0}
				}

				return this.selectedFragment.video.price
			},
			startPayment() {
				axios
					.post(route('payment.create'), {
						'fragment_id': this.selectedFragment.id,
						'media_type': this.mediaForBuy,
					})
					.then(response => {
						window.location.href = response.data.redirect
					})
					.catch(error => {
						console.log(error.data.response?.message ?? error.data?.message)
					})
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
				<img class="resize" src="{{ Vite::asset('resources/img/resize.png') }}" alt="resize"> --}}
                </div>
                <div class="main__center main__desk">
                    <div class="main__row row_first">

                        <div class="main__player player">
                            <div class="player__top">
                                <span x-show="playingMedia === 'audio'" x-cloak>{{ __('home.audio') }}</span>
                                <span x-show="playingMedia === 'video'" x-cloak>{{ __('home.video') }}</span>
                                <span x-show="playingMedia === 'presentation'" x-cloak>{{ __('home.presentation') }}</span>
                                <span style="margin-top: 4px">
                                    <span class="frag">{{ __('home.fragment') }}</span>
                                    <span class="number">№</span>
									<span x-text="playingFragment?.id">1</span>
                                </span>
                                <div class="runningline-wrap" x-data="runningLine" x-ref="lineWrap"
                                    @play-media-start.window="reset">
                                    <span class="runningline" x-text="playingFragment?.title_{{ loc() }}"
                                        x-ref="line">Заглавие</span>
                                </div>
                            </div>
                        </div>
                        @foreach (range(1, 6) as $number)
                            <div id="fragment{{ $number }}" class="main__column column" x-data="{ id: {{ $number }} }">
                                <div class="column__top"
									:class="{ 'column__top_active_1': isSelected(id) || isPlaying(id) }"
								>
                                    <span>
										<span class="frag">{{ __('home.fragment') }}</span>
										<br />
										<span class="number">№{{ $number }}</span>
									</span>
                                </div>
                                <div class="polygon">
                                    <button class="column__button column__shop"
                                        :class="{ 'column__active': isSelected(id, 'buy') }"
                                        @click="activateStep1(id)">
                                        <img src="{{ Vite::asset('resources/img/korzina.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__audio"
                                        :class="{ 'column__active': isSelected(id, 'audio') || isPlaying(id, 'audio') }"
                                        @click="activateAudio(id)">
                                        <img src="{{ Vite::asset('resources/img/audio.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__video" 
										:class="{ 'column__active': isSelected(id, 'video') || isPlaying(id, 'video') }"
										@click="activateVideo(id)"
									>
                                        <img src="{{ Vite::asset('resources/img/video.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__search" 
										:class="{ 'column__active': isSelected(id, 'presentation') || isPlaying(id, 'presentation') }" 
										@click="activatePresentation(id)"
									>
                                        <img src="{{ Vite::asset('resources/img/present.png') }}" alt="shop">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="main__row row_second">
                        @foreach (range(7, 17) as $number)
                            <div id="fragment{{ $number }}" class="main__column column" x-data="{ id: {{ $number }} }">
                                <div class="column__top"
									:class="{ 'column__top_active_2': isSelected(id) || isPlaying(id) }"
								>
                                    <span>
                                        <span class="frag">{{ __('home.fragment') }}</span>
                                        <br />
                                        <span class="number @if ($number >= 10) number__br @endif">
                                            №{{ $number }}
                                        </span>
                                    </span>
                                </div>
                                <div class="polygon">
                                    <button class="column__button column__shop"
                                        :class="{ 'column__active': isSelected(id, 'buy') }"
                                        @click="activateStep1(id)">
                                        <img src="{{ Vite::asset('resources/img/korzina.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__audio"
                                        :class="{ 'column__active': isSelected(id, 'audio') || isPlaying(id, 'audio') }"
                                        @click="activateAudio(id)">
                                        <img src="{{ Vite::asset('resources/img/audio.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__video" 
										:class="{ 'column__active': isSelected(id, 'video') || isPlaying(id, 'video') }"
										@click="activateVideo(id)"
									>
                                        <img src="{{ Vite::asset('resources/img/video.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__search" 
										:class="{ 'column__active': isSelected(id, 'presentation') || isPlaying(id, 'presentation') }" 
										@click="activatePresentation(id)"
									>
                                        <img src="{{ Vite::asset('resources/img/present.png') }}" alt="shop">
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
                    </div>

                    <div class="main__row">
                        @foreach (range(1, 17) as $number)
                            <div id="fragment-mobile{{ $number }}" class="main__column column"
                                x-data="{ id: {{ $number }} }">
                                <button class="column__top"
									:class="selectedFragment?.id === id && 'column__top_active_2'"
								>
                                    <span><span class="frag">{{ __('home.fragment') }}</span><br /><span
                                            class="number">№</span>{{ $number }}</span>
                                </button>
                                <div class="polygon">
                                    <button class="column__button column__shop"
                                        :class="{ 'column__active': isSelected(id, 'buy') }"
                                        @click="activateStep1(id)">
                                        <img src="{{ Vite::asset('resources/img/korzina.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__audio"
                                        :class="{ 'column__active': isSelected(id, 'audio') || isPlaying(id, 'audio') }"
                                        @click="activateAudio(id)">
                                        <img src="{{ Vite::asset('resources/img/audio.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__video" 
										:class="{ 'column__active': isSelected(id, 'video') || isPlaying(id, 'video') }"
										@click="activateVideo(id)"
									>
                                        <img src="{{ Vite::asset('resources/img/video.png') }}" alt="shop">
                                    </button>
                                    <button class="column__button column__search" 
										:class="{ 'column__active': isSelected(id, 'presentation') || isPlaying(id, 'presentation') }" 
										@click="activatePresentation(id)"
									>
                                        <img src="{{ Vite::asset('resources/img/present.png') }}" alt="shop">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @include('partials.app.sidebar')


                <div class="video-player" :class="isExpanded && 'video_expanded'" x-data="{
                    isExpanded: false,
                }">
                    <video id="player" class="video-js" poster="/img/player.png">
                        Your browser does not support the video tag.
                    </video>
                    <div class="resize-buttons" @click="isExpanded = !isExpanded">
                        <button x-show="!isExpanded">
                            <img class="" src="{{ Vite::asset('resources/img/resize.png') }}" alt="resize">
                        </button>
                        <button x-show="isExpanded" x-cloak>
                            <img class="" src="{{ Vite::asset('resources/img/expand-in.png') }}" alt="expand in">
                        </button>
                    </div>
                </div>


				<div class="audio popup-dialog" x-show="modal === 'audio'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.audio.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>
                    <div class="dialog__center dialog__center-top">
                        <h5 class="dialog__h5-top dialog__player-h5">
                            {{ __('home.windows.audio.1') }}<br />
                            {{ __('home.windows.audio.2') }}
                        </h5>
                        <form>
                            <x-radio-sound />

                            <div class="dialog__sub">
                                {{ __('home.windows.audio.duration') }}
								<span x-text="selectedFragment?.audio?.media[0]?.playtime ?? '0:00'"></span>
                            </div>
                            <div class="dialog__sep"></div>

                            <x-radio-device />

                            <h3 x-show="selectedFragment?.audio?.subscription">{{ __('home.windows.audio.access_granted') }}</h3>
							<button class="dialog__not-btn dialog__not-btn-yellow" 
								type="button"
								x-show="!selectedFragment?.audio?.subscription"
								@click="activateStep1(selectedFragment?.id)"
							>
								{{ __('home.windows.audio.access_denied') }}
							</button>
                        </form>
                        <button class="dialog__play" @click="play('audio')" x-show="selectedFragment?.audio?.subscription">
                            <img src="{{ Vite::asset('resources/img/play.png') }}" alt="play">
                        </button>
                    </div>
                </div>

				<div class="video popup-dialog" x-show="modal === 'video'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.video.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>
                    <div class="dialog__center dialog__center-top">
                        <h5 class="dialog__h5-top dialog__player-h5">
                            {{ __('home.windows.video.1') }}<br />
                            {{ __('home.windows.video.2') }}
                        </h5>
                        <form>
                            <x-radio-sound />
							
                            <div class="dialog__sub">
                                {{ __('home.windows.video.duration') }}
								<span x-text="selectedFragment?.video?.media[0]?.playtime ?? '0:00'"></span>
                            </div>
                            <div class="dialog__sep dialog__sep-blue"></div>

                            <x-radio-device />

                            <h3 x-show="selectedFragment?.video?.subscription">{{ __('home.windows.video.access_granted') }}</h3>
							<button class="dialog__not-btn dialog__not-btn-blue" 
								type="button"
								x-show="!selectedFragment?.video?.subscription"
								@click="activateStep1(selectedFragment?.id)"
							>
                                {{ __('home.windows.video.access_denied') }}
                            </button>
                        </form>
                        <button class="dialog__play" @click="play('video')" x-show="selectedFragment?.video?.subscription">
                            <img src="{{ Vite::asset('resources/img/play.png') }}" alt="play" />
                        </button>
                    </div>
                </div>

				<div class="presentation popup-dialog" x-show="modal === 'presentation'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.presentation.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>
                    <div class="dialog__center dialog__center-top">
                        <h5 class="dialog__h5-top">{{ __('home.windows.presentation.1') }}</h5>

                        <form>
                            <x-radio-sound :hasText="true" />

                            <div class="dialog__sub">
                                {{ __('home.windows.presentation.duration') }} 
								<span x-text="selectedFragment?.presentation?.media[0]?.playtime ?? '0:00'"></span>
                            </div>
                            <div class="dialog__sep dialog__sep-pink"></div>
							
                            <x-radio-device />

                            <h3>{{ __('home.windows.video.access_granted') }}</h3>
                        </form>
                        <button class="dialog__play" @click="play('presentation')">
                            <img src="{{ Vite::asset('resources/img/play.png') }}" alt="play" />
                        </button>
                    </div>
                </div>

                {{-- <div id="dialog-login" class="dialog-login popup-dialog-hidden green">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>
                    <div class="dialog__center">
                        <div id="account-autorization" class="dialog__autorization autorization">
                            <h3 class="autorization__title">Авторизация</h3>
                            <div class="autorization__button-box">
                                <button id="autorization-mode-btn-autorization"
                                    class="autorization__btn autorization__btn--autorization">
                                    <img src="img/user.png" alt="user" class="autorization__img" />
                                    <span class="autorization__btn-text">Я&nbsp;пользователь</span>
                                </button>
                                <button id="autorization-mode-btn-registration"
                                    class="autorization__btn autorization__btn--registration">
                                    <img src="img/user.png" alt="user"
                                        class="autorization__img autorization__img--grey" />
                                    <span class="autorization__btn-text">Регистрация</span>
                                </button>
                            </div>
                            <form id="autorization-form" class="autorization__form">
                                <span class="autorization__label">
                                    Адрес электронной почты:
                                </span>
                                <input id="autorization-email-input" type="email" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" />
                                <div class="autorization__wrapper">
                                    <span class="autorization__label"> Пароль: </span>
                                    <button id="autorization-password-recall-btn" class="autorization__link">
                                        Забыли пароль?
                                    </button>
                                </div>
                                <input id="autorization-password-input" type="password" class="autorization__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" />
                                <span id="autorization-error-msg" class="autorization__error-msg">Не удалось войти в
                                    аккаунт,
                                    введенные e-mail или
                                    пароль неверны</span>
                                <button id="autorization-submit-btn" class="autorization__submit-btn">
                                    ВХОД
                                </button>
                            </form>
                        </div>
                        <div id="account-registration" class="dialog__registration registration">
                            <h3 class="registration__title">Регистрация</h3>
                            <div class="registration__button-box">
                                <button id="registration-mode-btn-aurorization"
                                    class="registration__btn registration__btn--autorization">
                                    <img src="img/user.png" alt="user"
                                        class="registration__img registration__img--grey" />
                                    <span class="registration__btn-text">Авторизация</span>
                                </button>
                                <button id="registration-mode-btn-registration"
                                    class="registration__btn registration__btn--registration">
                                    <img src="img/user.png" alt="user" class="registration__img" />
                                    <span class="registration__btn-text">Регистрация</span>
                                </button>
                            </div>
                            <form id="registration-form" class="registration__form">
                                <span class="registration__label">
                                    Адрес электронной почты:
                                </span>
                                <input id="registration-email-input" type="email" class="registration__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" />
                                <button id="registration-submit-btn" class="registration__submit-btn">
                                    ПРОДОЛЖИТЬ
                                </button>
                            </form>
                        </div>
                        <div id="account-password-recall" class="dialog__password-recall password-reacll">
                            <h3 class="password-reacll__title">Восстановить пароль</h3>

                            <form id="password-reacll-form" class="password-reacll__form">
                                <span class="password-reacll__label">
                                    Адрес электронной почты:
                                </span>
                                <input id="password-reacall-input" type="email" class="password-reacll__input"
                                    placeholder="* * * * * * * * * * * * * * * * *" />
                                <button id="password-reacll-submit-btn" class="password-reacll__submit-btn">
                                    ВОССТАНОВИТЬ
                                </button>
                            </form>
                        </div>
                        <div id="account-password-info-msg" class="dialog__password-info-msg password-info-msg">
                            <div class="password-info-msg__wrapper">
                                <p class="password-info-msg__text">
                                    Для продолжения покупки перейдите по&nbsp;ссылке
                                    в&nbsp;письме и&nbsp;подтвердите e-mail
                                </p>
                            </div>
                        </div>
                        <div id="account-password-new-info-msg"
                            class="dialog__password-new-info-msg password-new-info-msg">
                            <div class="password-new-info-msg__wrapper">
                                <p class="password-new-info-msg__text">
                                    На&nbsp;вашу почту отправлен новый пароль для входа
                                    на&nbsp;сервис
                                </p>
                            </div>
                            <button id="password-new-info-msg-btn" class="password-new-info-msg__btn">
                                АВТОРИЗАЦИЯ
                            </button>
                        </div>
                    </div>
                </div> --}}

                {{-- <div id="dialog1" class="continue">
					<div class="dialog__top">
						<h4>Полное содержание. Фрагмент №8</h4>
						<button class="dialog__close">

						</button>
					</div>
					<div class="dialog__center">

						<div class="dialog__center-wrapper">
							<div class="dialog__bg">
								<h5>Для продолжения покупки перейдите<br/> по ссылке в письме и подтвердите e-mail</h5>
							</div>
							

						</div>
					</div>
				</div> --}}

                <div class="continue popup-dialog" x-show="modal === 'step1'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.step1.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div class="dialog__step">{{ __('home.windows.step1.step') }}</div>

                    <div class="dialog__center dialog__center-small">
                        <div class="dialog__center-wrapper">
                            <form class="variant-form">
                                <h5 class="dialog__h5-top">{{ __('home.windows.step1.1') }}</h5>

                                <div class="dialog__products">
                                    <label class="dialog__product-option">
                                        <div class="dialog__product-option-left">
                                            <input type="radio" name="product" value="video" x-model="mediaForBuy" />
                                            <div class="dialog__price-label">
                                                {{ __('home.windows.step1.2') }}<br />
                                                {{ __('home.windows.step1.3') }}<br />
                                                {{ __('home.windows.step1.4') }}
                                            </div>
                                        </div>
                                        <div class="dialog__price-wrapper">
                                            <p x-text="videoPrice().amount"></p>
                                            <img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="videoPrice().currency === 'EUR'" />
                                            <img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="videoPrice().currency === 'USD'" />
                                            <img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="videoPrice().currency === 'RUB'" />
                                        </div>
                                    </label>

                                    <label class="dialog__product-option">
                                        <div class="dialog__product-option-left">
                                            <input type="radio" name="product" value="audio" x-model="mediaForBuy" />
                                            <div class="dialog__price-label">
                                                {{ __('home.windows.step1.5') }}<br />
                                                {{ __('home.windows.step1.6') }}<br />
                                                {{ __('home.windows.step1.7') }}
                                            </div>
                                        </div>
                                        <div class="dialog__price-wrapper">
                                            <p x-text="audioPrice().amount"></p>
                                            <img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="audioPrice().currency === 'EUR'" />
                                            <img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="audioPrice().currency === 'USD'" />
                                            <img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="audioPrice().currency === 'RUB'" />
                                        </div>
                                    </label>
                                </div>

                                <button type="button" class="dialog__submit-btn dialog__submit-btn-first" @click="modal = 'step2'">
                                    {{ __('home.windows.step1.button') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="continue popup-dialog" x-show="modal === 'step2'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.step2.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div class="dialog__step absolut">{{ __('home.windows.step2.step') }}</div>

                    <div class="dialog__center dialog__center-cart">
                        <div class="dialog__center-wrapper">
                            <h5>{{ __('home.windows.step2.1') }}</h5>

                            <div class="dialog__cart-info">
                                <p>{{ __('home.windows.step2.2') }}</p>
                                <p>{{ __('home.windows.step2.3') }}</p>
                            </div>
                            <div class="dialog__bg dialog__bg-small">
                                <div class="dialog__cart">
                                    <div class="dialog__description" x-show="mediaForBuy === 'video'">
                                        {{ __('home.windows.step2.4') }}
                                    </div>
                                    <div class="dialog__description" x-show="mediaForBuy === 'audio'">
                                        {{ __('home.windows.step2.5') }}
                                    </div>
                                    <div class="dialog__price-wrapper" x-show="mediaForBuy === 'video'">
                                        <p x-text="videoPrice().amount"></p>
                                        <img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="videoPrice().currency === 'EUR'" />
										<img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="videoPrice().currency === 'USD'" />
										<img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="videoPrice().currency === 'RUB'" />
                                    </div>
                                    <div class="dialog__price-wrapper" x-show="mediaForBuy === 'audio'">
                                        <p x-text="audioPrice().amount"></p>
                                        <img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="audioPrice().currency === 'EUR'" />
										<img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="audioPrice().currency === 'USD'" />
										<img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="audioPrice().currency === 'RUB'" />
                                    </div>
                                </div>

                                <div class="dialog__sub">
                                    {{ __('home.windows.step2.6') }}
									<span x-text="selectedFragment?.audio?.media[0]?.playtime ?? '0:00'" x-show="mediaForBuy === 'audio'"></span>
									<span x-text="selectedFragment?.video?.media[0]?.playtime ?? '0:00'" x-show="mediaForBuy === 'video'"></span>
                                </div>
                                <div class="dialog__sep dialog__sep-white"></div>

                                <div class="dialog__total">
                                    <p class="dialog__total-p">{{ __('home.windows.step2.7') }}</p>

                                    <div class="dialog__price-wrapper" x-show="mediaForBuy === 'video'">
                                        <p x-text="videoPrice().amount"></p>
                                        <img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="videoPrice().currency === 'EUR'" />
										<img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="videoPrice().currency === 'USD'" />
										<img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="videoPrice().currency === 'RUB'" />
                                    </div>
                                    <div class="dialog__price-wrapper" x-show="mediaForBuy === 'audio'">
                                        <p x-text="audioPrice().amount"></p>
                                        <img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="audioPrice().currency === 'EUR'" />
										<img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="audioPrice().currency === 'USD'" />
										<img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="audioPrice().currency === 'RUB'" />
                                    </div>
                                </div>
                            </div>

                            <div class="dialog__btns">
                                <button id="back-1" class="dialog__back-btn" @click="modal = 'step1'">
                                    {{ __('home.windows.step2.back1') }}<br />
                                    {{ __('home.windows.step2.back2') }}
                                </button>

                                <button id="next-2" class="dialog__submit-btn" @click="modal = 'step3'">
                                    {{ __('home.windows.step2.next') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="dialog-login green dialog-inline" x-show="modal === 'step3'" x-cloak
					x-data="{window: 'login'}"
				>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.step3.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div id="login-step" class="dialog__step">{{ __('home.windows.step3.step') }}</div>

                    <div class="dialog__center" x-data="{isAuthorized: {{ Auth::check() ? 'true' : 'false' }}}">
                        <div class="dialog__autorization autorization dialog__autorization-popup" x-show="window === 'login'">
                            <h3 class="autorization__title dialog__h3-without">
                                {{ __('home.windows.step3.login.title') }}
                            </h3>
                            <div class="autorization__button-box">
                                <button id="autorization-mode-btn-autorization"
                                    class="autorization__btn autorization__btn--autorization">
                                    <img src="img/user.png" alt="user" class="autorization__img" />
                                    <span class="autorization__btn-text">{{ __('home.windows.step3.login.1') }}</span>
                                </button>
                                <button id="autorization-mode-btn-registration" @click="window = 'register'"
                                    class="autorization__btn autorization__btn--registration">
                                    <img src="img/user.png" alt="user"
                                        class="autorization__img autorization__img--grey" />
                                    <span class="autorization__btn-text">{{ __('home.windows.step3.login.2') }}</span>
                                </button>
                            </div>
                            <form id="autorization-form" class="autorization__form" @submit.prevent="login"
								x-data="{
									error: false,
									processing: false,
									login() {
										if (this.isAuthorized) {
											this.modal = 'step4';
											return;
										}

										this.processing = true;
										this.error = false;

										let data = new FormData(this.$event.target);
										
										axios
											.post(route('login'), data)
											.then(res => {
												this.$dispatch('login', {email: data.get('email')})
												this.modal = 'step4';
											})
											.catch(err => {
												if (err.response.status === 422) {
													this.error = true;
													return;
												}

												console.log(err);
											})
											.finally(() => this.processing = false)
									}
								}"
							>
                                <span class="autorization__label">
                                    {{ __('home.windows.step3.login.3') }}
                                </span>
                                <input id="autorization-email-input" type="email" class="autorization__input" name="email"
                                    placeholder="* * * * * * * * * * * * * * * * *" />
                                <div class="autorization__wrapper">
                                    <span class="autorization__label"> {{ __('home.windows.step3.login.4') }} </span>
                                    <button type="button" class="autorization__link" @click="window = 'remind'">
                                        {{ __('home.windows.step3.login.5') }}
                                    </button>
                                </div>
                                <input id="autorization-password-input" type="password" class="autorization__input" name="password"
                                    placeholder="* * * * * * * * * * * * * * * * *" />
                                <span id="autorization-error-msg" class="autorization__error-msg" x-show="error">
									{{ __('home.windows.step3.login.6') }}
								</span>
                                <button class="autorization__submit-btn dialog__submit-btn-without" :disabled="processing">
                                    {{ __('home.windows.step3.login.7') }}
                                </button>
                            </form>
                        </div>
                        <div class="dialog__registration registration dialog__autorization-popup" x-show="window === 'register'">
                            <h3 class="registration__title">{{ __('home.windows.step3.register.title') }}</h3>
                            <div class="registration__button-box">
                                <button id="registration-mode-btn-aurorization" @click="window = 'login'"
                                    class="registration__btn registration__btn--autorization">
                                    <img src="img/user.png" alt="user"
                                        class="registration__img registration__img--grey" />
                                    <span class="registration__btn-text">{{ __('home.windows.step3.register.1') }}</span>
                                </button>
                                <button id="registration-mode-btn-registration"
                                    class="registration__btn registration__btn--registration">
                                    <img src="img/user.png" alt="user" class="registration__img" />
                                    <span class="registration__btn-text">{{ __('home.windows.step3.register.2') }}</span>
                                </button>
                            </div>
                            <form id="registration-form" class="registration__form" style="position: relative"
								@submit.prevent="submit"
								x-data="{
									error: false,
									errorText: '',
									processing: false,
									submit(event) {
										if (this.isAuthorized) {
											this.modal = 'step4';
											return;
										}

										this.processing = true;
										this.error = false;
										axios
											.post(route('register-and-buy'), new FormData(event.target))
											.then(res => {
												this.window = 'register-success';
											})
											.catch(err => {
												if (err.response.status === 422) {
													this.error = true;
													this.errorText = err.response.data.message;
													return;
												}
											})
											.finally(() => this.processing = false)
									}
								}"
							>
                                <span class="registration__label">
                                    {{ __('home.windows.step3.register.3') }}
                                </span>
                                <input type="email" class="registration__input" name="email"
                                    placeholder="* * * * * * * * * * * * * * * * *" />

								<input type="hidden" name="fragment_id" :value="selectedFragment?.id">
								<input type="hidden" name="media_type" :value="mediaForBuy">
								
								<span class="registration__error-msg" 
									x-show="error"
									x-text="errorText"
								></span>
                                <button class="registration__submit-btn" :disabled="processing">
                                    {{ __('home.windows.step3.register.4') }}
                                </button>
                            </form>
                        </div>
                        <div class="dialog__password-recall password-reacll" x-show="window === 'remind'">
                            <h3 class="password-reacll__title">{{ __('home.windows.step3.remind.title') }}</h3>

                            <form id="password-reacll-form" class="password-reacll__form"
								@submit.prevent="submit"
								x-data="{
									processing: false,
									submit(event) {
										this.processing = true;

										axios
											.post(route('password.reset'), new FormData(event.target))
											.then(resp => this.window = 'password-sent')
											.finally(() => this.processing = false)
									}
								}"
							>
                                <span class="password-reacll__label">
                                    {{ __('home.windows.step3.remind.1') }}
                                </span>
                                <input type="email" class="password-reacll__input" name="email" placeholder="* * * * * * * * * * * * * * * * *" />
                                <button class="password-reacll__submit-btn" :disabled="processing">
                                    {{ __('home.windows.step3.remind.2') }}
                                </button>
                            </form>
                        </div>
                        <div class="dialog__password-info-msg password-info-msg" x-show="window === 'register-success'">
                            <div class="password-info-msg__wrapper">
                                <p class="password-info-msg__text">
                                    {{ __('home.windows.step3.register-success') }}
                                </p>
                            </div>
                        </div>
                        <div class="dialog__password-new-info-msg password-new-info-msg" x-show="window === 'password-sent'">
                            <div class="password-new-info-msg__wrapper">
                                <p class="password-new-info-msg__text">
                                    {{ __('home.windows.step3.password-sent.1') }}
                                </p>
                            </div>
                            <button class="password-new-info-msg__btn" @click="window = 'login'">
                                {{ __('home.windows.step3.password-sent.2') }}
                            </button>
                        </div>
                    </div>
                </div>

				<div class="continue popup-dialog" x-show="modal === 'step4'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.step4.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div class="dialog__step">{{ __('home.windows.step4.step') }}</div>

                    <div class="dialog__center dialog__center_without">
                        <form class="method-form">
                            <h5>{{ __('home.windows.step4.1') }}</h5>

                            <div class="methods">
                                <label class="cars">
                                    <div class="imgs">
                                        <img class="mastercard" src="{{ Vite::asset('resources/img/MasterCard.png') }}" alt="mastercard" />
                                        <img class="visa" src="{{ Vite::asset('resources/img/VISA.png') }}" alt="visa" />
                                    </div>

                                    <div class="rado-wrap">
                                        <input type="radio" name="method" checked />
                                        <label class="dialog__input-label">{{ __('home.windows.step4.2') }}</label>
                                    </div>
                                </label>
                            </div>

                            <div class="btns">
                                <button class="dialog__back-btn dialog__submit-btn-big" type="button" @click="modal = 'step2'">
                                    {{ __('home.windows.step4.3') }} <br />
                                    {{ __('home.windows.step4.4') }}
                                </button>
                                <button class="dialog__submit-btn" type="button" @click="modal = 'step5'">
                                    {{ __('home.windows.step4.5') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="continue popup-dialog" x-show="modal === 'step5'" x-cloak>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.step5.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div class="dialog__step absolut">{{ __('home.windows.step5.step') }}</div>

                    <div class="dialog__center dialog__center-confirm">
                        <div class="dialog__center-wrapper">
                            <h5 class="dialog__confirm-h5">{{ __('home.windows.step5.1') }}</h5>

                            <form class="complete" x-data="{agree: true}">
                                <div class="dialog__variant">{{ __('home.windows.step5.2') }}</div>

                                <div class="dialog__confirm">
                                    <label class="dialog__confirm-product" for="sss">
                                        <div class="dialog__product-option-left">
                                            <input id="sss" type="radio" name="product" checked />
                                            <label x-show="mediaForBuy === 'video'">{{ __('home.windows.step5.3') }}</label>
                                            <label x-show="mediaForBuy === 'audio'">{{ __('home.windows.step5.4') }}</label>
                                        </div>
                                        <div class="dialog__price-wrapper" x-show="mediaForBuy === 'video'">
											<p x-text="videoPrice().amount"></p>
											<img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="videoPrice().currency === 'EUR'" />
											<img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="videoPrice().currency === 'USD'" />
											<img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="videoPrice().currency === 'RUB'" />
										</div>
										<div class="dialog__price-wrapper" x-show="mediaForBuy === 'audio'">
											<p x-text="audioPrice().amount"></p>
											<img src="{{ Vite::asset('resources/img/euro.png') }}"  alt="euro" x-show="audioPrice().currency === 'EUR'" />
											<img src="{{ Vite::asset('resources/img/usd.png') }}" alt="usd" x-show="audioPrice().currency === 'USD'" />
											<img src="{{ Vite::asset('resources/img/rub.png') }}" alt="rub" x-show="audioPrice().currency === 'RUB'" />
										</div>
                                    </label>
                                </div>

                                <div class="dialog__sub">
                                    {{ __('home.windows.step5.5') }}
									<span x-text="selectedFragment?.audio?.media[0]?.playtime ?? '0:00'" x-show="mediaForBuy === 'audio'"></span>
									<span x-text="selectedFragment?.video?.media[0]?.playtime ?? '0:00'" x-show="mediaForBuy === 'video'"></span>
                                </div>
                                <div class="dialog__sep dialog__sep-white dialog__sep-visible"></div>

                                <div class="dialog__payment-type">
                                    <p>{{ __('home.windows.step5.6') }}</p> <span>{{ __('home.windows.step5.7') }}</span>
                                </div>

                                <div class="dialog__policy">
                                    <div class="dialog__policy-wrap">
                                        <input id="policy" type="checkbox" name="policy" x-model="agree" />
                                        <p>
                                            <label for="policy">{{ __('home.windows.step5.8') }}</label>
                                            <a 
												:href="route('commercial', {
													'fragment_id': selectedFragment?.id ?? '',
													'media_type': mediaForBuy ?? '',
													'step': 'step5',
												})"
											>
												{{ __('home.windows.step5.9') }}
											</a>
                                        </p>


                                    </div>
                                    <a 
										:href="route('privacy', {
											'fragment_id': selectedFragment?.id ?? '',
											'media_type': mediaForBuy ?? '',
											'step': 'step5',
										})"
									>
										{{ __('home.windows.step5.10') }}
									</a>
                                </div>

                                <div class="dialog__btns">
                                    <button class="dialog__back-btn" type="button" @click="modal = 'step2'">
                                        {{ __('home.windows.step5.11') }}<br />
                                        {{ __('home.windows.step5.12') }}
                                    </button>

                                    <button class="dialog__submit-btn" type="button" 
										@click="startPayment" 
										:style="!agree ? 'visibility: hidden;' : ''"
										:disabled="!agree"
									>
                                        {{ __('home.windows.step5.13') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="presentation popup-dialog" x-show="modal === 'text'" x-cloak 
					x-data="{full: false}"
					:class="full && 'full-page'"
				>
                    <div class="dialog__top">
                        <h4 x-text="'{{ __('home.windows.text.title1') }}' + selectedFragment?.id + '{{ __('home.windows.text.title2') }}'"></h4>
                        <button class="dialog__close" @click="deactivateFragment(); full = false"></button>
                    </div>

                    <div class="dialog__center dialog__center-margin">
                        <button class="dialog__icon" @click="full = !full">
                            <img width="62" height="62" src="{{ Vite::asset('resources/img/link.png') }}" alt="" x-show="!full" />
                            <img width="62" height="62" src="{{ Vite::asset('resources/img/29.png') }}" alt="" x-show="full" />
                        </button>

                        <div class="dialog__texter">
                            <h3 class="title" x-text="selectedFragment?.title_{{ loc() }}"></h3>

							<div x-html="selectedFragment?.presentation?.text_{{ loc() }}"></div>
                            
                        </div>
                    </div>
                </div>

                <div class="cool-silver popup-dialog" x-show="modal === 'fail'" x-cloak
					x-data="{
						activate() {
							this.mediaForBuy === 'audio' 
								? this.activateAudio(this.selectedFragment?.id) 
								: this.activateVideo(this.selectedFragment?.id)
						},
					}"
				>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.fail.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div class="dialog__center">
                        <div class="payment-failed">
                            <h3 class="epic-font-red">
                                {{ __('home.windows.fail.1') }}<br />
                                {{ __('home.windows.fail.2') }}
                            </h3>

                            <div class="img-wrapper">
                                <svg width="323" height="322" viewBox="0 0 323 322" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M49 322L0.5 273.5L115 162L1 48L49 0L162 113L275 0L323 48L209 162L320.5 273.5L272 322L160.5 210.5L49 322Z"
                                        fill="black" />
                                </svg>
                            </div>

                            <ul class="list">
                                <li class="item">
                                    <p>
                                        {{ __('home.windows.fail.3') }}
                                    </p>
                                </li>
                                <li class="item">
                                    <p>
                                        {{ __('home.windows.fail.4') }}
                                    </p>
                                </li>
                                <li class="item">
                                    <p>{{ __('home.windows.fail.5') }}</p>
                                </li>
                                <li class="item">
                                    <p>
                                        {{ __('home.windows.fail.6') }}
                                    </p>
                                </li>
                            </ul>

                            <button @click="activate">{{ __('home.windows.fail.7') }} <br />{{ __('home.windows.fail.8') }}</button>
                        </div>
                    </div>
                </div>

                <div class="done popup-dialog" x-show="modal === 'success'" x-cloak
					x-data="{
						activate() {
							this.mediaForBuy === 'audio' 
								? this.activateAudio(this.selectedFragment?.id) 
								: this.activateVideo(this.selectedFragment?.id)
						},
					}"
				>
                    <div class="dialog__top">
                        <h4>{{ __('home.windows.success.title') }}<span x-text="selectedFragment?.id"></span></h4>
                        <button class="dialog__close" @click="deactivateFragment"></button>
                    </div>

                    <div class="dialog__center">
                        <div class="payment-success">
                            <h3 class="epic-font-green">{{ __('home.windows.success.1') }}</h3>

                            <div class="img-wrapper">
                                <img src="{{ Vite::asset('resources/img/mark.png') }}" alt="" />
                            </div>

                            <button id="next-5" class="p-button" 
								@click="activate"
							>
                                {{ __('home.windows.success.2') }}<br />
                                {{ __('home.windows.success.3') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('runningLine', () => ({
                shift: null,
                timerId: null,

                init() {
                    this.$nextTick(() => {
                        this.shift = this.$refs.lineWrap.offsetWidth - this.$refs.line
                            .offsetWidth
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
                        this.shift = this.$refs.lineWrap.offsetWidth - this.$refs.line
                            .offsetWidth
                        this.moveLeft()
                    })

                },
                moveLeft() {
                    this.timerId = setTimeout(() => {
                        if (this.shift >= 0) return

                        this.$refs.line.style.transitionDuration = Math.abs(this.shift) * 10 +
                            'ms'
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

    {{-- <script>
        const videoButton = document.querySelector('.column__video');
        if (videoButton) {
            videoButton.addEventListener('click', (e) => {
                document.getElementById('dialog2').classList.remove('popup-dialog-hidden');
            });
        }

        const searchButton = document.querySelector('.column__search');
        if (searchButton) {
            searchButton.addEventListener('click', (e) => {
                document.getElementById('dialog3').classList.remove('popup-dialog-hidden');
            });
        }


        const openTextButton = document.querySelector('#openText');
        if (openTextButton) {
            openTextButton.addEventListener('click', (e) => {
                const dialog = document.getElementById('dialog11');
                if (dialog.classList.contains('full-page')) {
                    dialog.classList.remove('full-page');
                    dialog.querySelector('img').src = "{{ Vite::asset('resources/img/link.png') }}"
                } else {
                    dialog.classList.add('full-page');
                    dialog.querySelector('img').src = "{{ Vite::asset('resources/img/29.png') }}"
                }
            });
        }




        const buyButton = document.querySelectorAll('.column__shop');
        let i = 1;
        buyButton.forEach(button => {
            let dialog = document.getElementById(`dialog${i}`);
            if (dialog) {
                button.addEventListener('click', (e) => {
                    dialog.classList.remove('popup-dialog-hidden');

                    if (i === 6) {
                        dialog.querySelector("#login-step").classList.remove('popup-dialog-hidden');
                    }


                });
            }
            if (i === 15) {
                button.addEventListener('click', (e) => {
                    dialog = document.getElementById('dialog6');
                    dialog.classList.remove('popup-dialog-hidden');
                    let authorizationWindow = dialog.querySelector('#account-autorization');
                    let passwordRecallWindow = dialog.querySelector('#account-password-info-msg');
                    let newPasswordMsgWindow = dialog.querySelector('#account-password-new-info-msg');
                    let passwordRecal = dialog.querySelector('#account-password-recall');
                    passwordRecal.style.display = "none"
                    newPasswordMsgWindow.style.display = "none"
                    authorizationWindow.style.display = "none"
                    passwordRecallWindow.style.display = "flex"
                    dialog.querySelector("#login-step").classList.add('popup-dialog-hidden');
                });
            } else if (i === 16) {
                button.addEventListener('click', (e) => {
                    dialog = document.getElementById('dialog6');
                    dialog.classList.remove('popup-dialog-hidden');
                    let authorizationWindow = dialog.querySelector('#account-autorization');
                    let newPasswordMsgWindow = dialog.querySelector('#account-password-new-info-msg');
                    let passwordRecallWindow = dialog.querySelector('#account-password-info-msg');
                    passwordRecallWindow.style.display = "none"
                    authorizationWindow.style.display = "none"
                    newPasswordMsgWindow.style.display = "flex"
                    dialog.querySelector("#login-step").classList.add('popup-dialog-hidden');
                });
            }
            i++;
            if (i === 18) {
                i = 1;
            }
        });

        const audioButton = document.querySelector('.column__audio');
        if (audioButton) {
            audioButton.addEventListener('click', (e) => {
                document.getElementById('dialog1').classList.remove('popup-dialog-hidden');
            });
        }



        const buttons = document.querySelectorAll('.main__row .column .polygon button');
        buttons.forEach(column => {
            column.addEventListener('click', (e) => {
                const button = e.target.closest('button')
                const top = e.target.closest('.column').querySelector('.column__top')
                const color = getComputedStyle(top).backgroundColor;

                button.classList.remove('column__hover')
                button.classList.add('column__active')

                if (color.includes('233, 117, 44, 0.3')) {
                    top.classList.add('column__top_active_1');
                }
                if (color.includes('125, 97, 155')) {
                    top.classList.add('column__top_active_2');
                }
                top.classList.remove('column__st3-active', 'column__st2-active');
            })
            column.addEventListener('mouseout', (e) => {
                const button = e.target.closest('button')
                const top = e.target.closest('.column').querySelector('.column__top')

                button.classList.remove('column__active', 'column__hover')
                top.classList.remove('column__top_active_2', 'column__top_active_1')
            })
            column.addEventListener('mouseover', (e) => {
                const button = e.target.closest('button')
                const top = e.target.closest('.column').querySelector('.column__top')

                button.classList.add('column__hover')
            })
        })


        const polygons = document.querySelectorAll('.polygon');
        polygons.forEach(polygon => {
            polygon.addEventListener('mouseover', e => {
                const top = e.target.closest('.column').querySelector('.column__top');
                const color = getComputedStyle(top).backgroundColor;
                if (color === 'rgba(233, 117, 44, 0.3)') {
                    top.classList.add('column__st2-active');
                }
                if (color === 'rgba(125, 97, 155, 0.3)') {
                    top.classList.add('column__st3-active');
                }
            });
            polygon.addEventListener('mouseout', e => {
                const top = e.target.closest('.column').querySelector('.column__top');
                top.classList.remove('column__st3-active', 'column__st2-active', 'column__st2-2-active',
                    'column__st3-2-active', 'column__st2-3-active', 'column__st3-3-active');
            });
        });
    </script> --}}
@endsection
