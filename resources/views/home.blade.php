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
            playingFragment: null,
            playingMedia: 'presentation',
			sound: 'stereo',
			device: 'notebook',
        
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
                        src: `/media/${this.playingMedia}/${this.playingFragment.id}/{{ loc() }}/${this.sound}/${this.device}` 
                    })
                    this.player.play()
        
                    {{-- this.player.removeChild('BigPlayButton'); --}}
                })
            },
            activateFragment(id) {
                this.selectedFragment = this.fragments
                    .find(el => el.id === id)
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
            activateBuySteps(id) {
                this.activateFragment(id)
                this.modal = 'buy'
            },
			isSelected(id, type) {
				return this.selectedFragment?.id === id && this.modal === type
			},
			isPlaying(id, type) {
				return this.playingFragment?.id === id && this.playingMedia === type
			},
            buyClasses(id) {
                return { 'column__active': this.selectedFragment === id }
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
                                    :class="selectedFragment?.id === id && 'column__top_active_1'"
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
                                        @click="activateBuySteps(id)">
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
									:class="selectedFragment?.id === id && 'column__top_active_2'"
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
                                        @click="activateBuySteps(id)">
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
                                        @click="activateBuySteps(id)">
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


				<div id="dialog1" class="audio popup-dialog" x-show="modal === 'audio'" x-cloak>
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

                            <h3>{{ __('home.windows.audio.access_granted') }}</h3>
							{{-- <button class="dialog__not-btn dialog__not-btn-yellow">
								{{ __('home.windows.audio.access_denied') }}
							</button> --}}
                        </form>
                        <button class="dialog__play">
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

                            <h3>{{ __('home.windows.video.access_granted') }}</h3>
							{{-- <button id="autorization-submit-btn" class="dialog__not-btn dialog__not-btn-blue">
                                {{ __('home.windows.video.access_denied') }}
                            </button> --}}
                        </form>
                        <button class="dialog__play">
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
                        <button class="dialog__play">
                            <img src="{{ Vite::asset('resources/img/play.png') }}" alt="play" />
                        </button>
                    </div>
                </div>

                <div id="dialog-login" class="dialog-login popup-dialog-hidden green">
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
                </div>

                <div id="dialog6" class="dialog-login popup-dialog-hidden green dialog-inline">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div id="login-step" class="dialog__step">Шаг 3 из 5</div>

                    <div class="dialog__center">
                        <div id="account-autorization"
                            class="dialog__autorization autorization dialog__autorization-popup">
                            <h3 class="autorization__title dialog__h3-without">
                                Авторизация
                            </h3>
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
                                <button id="autorization-submit-btn"
                                    class="autorization__submit-btn dialog__submit-btn-without">
                                    ВХОД
                                </button>
                            </form>
                        </div>
                        <div id="account-registration"
                            class="dialog__registration registration dialog__autorization-popup">
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
                </div>

                <!-- <div id="dialog1" class="continue">
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
				</div> -->

                <div id="dialog4" class="continue popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__step">Шаг 1 из 5</div>

                    <div class="dialog__center dialog__center-small">
                        <div class="dialog__center-wrapper">
                            <form class="variant-form">
                                <h5 class="dialog__h5-top">Выбор варианта покупки:</h5>

                                <div class="dialog__products">
                                    <label class="dialog__product-option">
                                        <div class="dialog__product-option-left">
                                            <input id="" type="radio" name="product" />
                                            <div class="dialog__price-label">
                                                Купить доступ к видеофайлу<br />
                                                для просмотра и прослушивания<br />
                                                на сайте
                                            </div>
                                        </div>
                                        <div class="dialog__price-wrapper">
                                            <p>3,00</p>
                                            <img src="{{ Vite::asset('resources/img/euro.png') }}" alt="" />
                                        </div>
                                    </label>

                                    <label class="dialog__product-option">
                                        <div class="dialog__product-option-left">
                                            <input id="" type="radio" name="product" />
                                            <div class="dialog__price-label">
                                                Купить доступ к аудиофайлу<br />
                                                для прослушивания<br />
                                                на сайте
                                            </div>
                                        </div>
                                        <div class="dialog__price-wrapper">
                                            <p>2,00</p>
                                            <img src="{{ Vite::asset('resources/img/euro.png') }}" alt="" />
                                        </div>
                                    </label>
                                </div>

                                <button id="next-1" class="dialog__submit-btn dialog__submit-btn-first">
                                    Перейти к оформлению
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="dialog5" class="continue popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__step absolut">Шаг 2 из 5</div>

                    <div class="dialog__center dialog__center-cart">
                        <div class="dialog__center-wrapper">
                            <h5>Ваша корзина</h5>

                            <div class="dialog__cart-info">
                                <p>Медиаконтент</p>
                                <p>Стоимость</p>
                            </div>
                            <div class="dialog__bg dialog__bg-small">
                                <div class="dialog__cart">
                                    <div class="dialog__description">
                                        Доступ к видеофайлу
                                        для просмотра и прослушивания
                                        на сайте
                                    </div>
                                    <div class="dialog__price-wrapper">
                                        <p>3,00</p>
                                        <img src="{{ Vite::asset('resources/img/euro.png') }}" alt="" />
                                    </div>
                                </div>

                                <div class="dialog__sub">
                                    Продолжительность записи в минутах - 25:02
                                </div>
                                <div class="dialog__sep dialog__sep-white"></div>

                                <div class="dialog__total">
                                    <p class="dialog__total-p">Итоговая стоимость:</p>

                                    <div class="dialog__price-wrapper">
                                        <p>3,00</p>
                                        <img src="{{ Vite::asset('resources/img/euro.png') }}" alt="" />
                                    </div>
                                </div>
                            </div>

                            <div class="dialog__btns">
                                <button id="back-1" class="dialog__back-btn">
                                    Вернуться<br />
                                    назад
                                </button>

                                <button id="next-2" class="dialog__submit-btn">
                                    Продолжить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="dialog8" class="continue popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__step absolut">Шаг 5 из 5</div>

                    <div class="dialog__center dialog__center-confirm">
                        <div class="dialog__center-wrapper">
                            <h5 class="dialog__confirm-h5">Подтверждение покупки</h5>

                            <form class="complete">
                                <div class="dialog__variant">Вариант покупки:</div>

                                <div class="dialog__confirm">
                                    <label class="dialog__confirm-product" for="sss">
                                        <div class="dialog__product-option-left">
                                            <input id="sss" type="radio" name="product" checked />
                                            <label for="">Доступ к видеофайлу для
                                                просмотра и прослушивания
                                                на сайте</label>
                                        </div>
                                        <div class="dialog__price-wrapper">
                                            <p>3,00</p>
                                            <img src="{{ Vite::asset('resources/img/euro.png') }}" alt="" />
                                        </div>
                                    </label>
                                </div>

                                <div class="dialog__sub">
                                    Продолжительность записи в минутах - 25:02
                                </div>
                                <div class="dialog__sep dialog__sep-white dialog__sep-visible"></div>

                                <div class="dialog__payment-type">
                                    <p>Способ платежа:</p> <span>онлайн карты</span>
                                </div>

                                <div class="dialog__policy">
                                    <div class="dialog__policy-wrap">
                                        <input id="policy" type="checkbox" name="policy" />
                                        <p>
                                            <label for="policy">Я согласен
                                            </label>
                                            <a>с условиями продажи доступа к
                                                медиаконтенту</a>
                                        </p>


                                    </div>
                                    <a>и Политикой приватности</a>
                                </div>

                                <div class="dialog__btns">
                                    <button id="back-3" class="dialog__back-btn">
                                        Вернуться<br />
                                        в корзину
                                    </button>

                                    <button id="next-4" class="dialog__submit-btn">
                                        Продолжить
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="dialog11" class="presentation popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Текст. Краткое содержание Фрагмента №8. Заглавие</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__center dialog__center-margin">
                        <div class="dialog__icon">
                            <img id="openText" width="62" height="62" src="{{ Vite::asset('resources/img/link.png') }}" alt="" />
                        </div>

                        <div class="dialog__texter">
                            <h3 class="title">
                                Общество в постсоветском пространстве,
                                психически мутировано,
                                то есть процесс эволюции сознания
                                и самосознания находится на животном уровне.
                            </h3>

                            <p class="par">
                                Этот тезис полностью аргументируется и подкрепляется
                                Книгой Бытия, которая для большевиков была
                                Марксисто-Ленинская философия и Диалектический
                                Материализм. Основополагающие постулаты, которые
                                формировали мысли, чувства, стереотипы сознания и
                                поведения, всего образа жизни, отношения к окружающему
                                миру и к самому себе.
                            </p>
                            <p class="par">
                                Первый Постулат - первичность материи, вторичность
                                сознания смещал сознание советского человека на
                                физиологические плотские нужды, поэтому
                                физиологически-животные инстинкты гипертрофировались.
                                Смыслом и целью советского человека являлось бесконечное
                                бытовое накопление и потребление.
                            </p>
                            <p class="par">
                                Первый Постулат - первичность материи, вторичность
                                сознания смещал сознание советского человека на
                                физиологические плотские нужды, поэтому
                                физиологически-животные инстинкты гипертрофировались.
                                Смыслом и целью советского человека являлось бесконечное
                                бытовое накопление и потребление.
                            </p>
                            <p class="par">
                                Первый Постулат - первичность материи, вторичность
                                сознания смещал сознание советского человека на
                                физиологические плотские нужды, поэтому
                                физиологически-животные инстинкты гипертрофировались.
                                Смыслом и целью советского человека являлось бесконечное
                                бытовое накопление и потребление.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="dialog7" class="continue popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__step">Шаг 4 из 5</div>

                    <div class="dialog__center dialog__center_without">
                        <form class="method-form">
                            <h5>Выбор платежной системы:</h5>

                            <div class="methods">
                                <label class="cars">
                                    <div class="imgs">
                                        <img class="mastercard" src="{{ Vite::asset('resources/img/MasterCard.png') }}" alt="mastercard" />
                                        <img class="visa" src="{{ Vite::asset('resources/img/VISA.png') }}" alt="visa" />
                                    </div>

                                    <div class="rado-wrap">
                                        <input type="radio" name="method" checked />
                                        <label class="dialog__input-label">Онлайн карты</label>
                                    </div>
                                </label>
                            </div>

                            <div class="btns">
                                <button id="back-2" class="dialog__back-btn dialog__submit-btn-big">
                                    Вернуться <br />
                                    назад
                                </button>
                                <button id="next-3" class="dialog__submit-btn">
                                    Продолжить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="dialog10" class="cool-silver popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__center">
                        <div class="payment-failed">
                            <h3 class="epic-font-red">
                                К сожалению, <br />
                                транзакция отклонена
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
                                        Пожалуйста, вернитесь в корзину и повторите
                                        вновь оформление заказа.
                                    </p>
                                </li>
                                <li class="item">
                                    <p>
                                        Проверьте, пожалуйста, достаточно ли средств на счету Вашей карты.
                                    </p>
                                </li>
                                <li class="item">
                                    <p>Правильно ли Вы ввели данные своей карты.</p>
                                </li>
                                <li class="item">
                                    <p>
                                        Обратитесь, пожалуйста, в свой банк в случае
                                        технического сбоя процесинга оплаты
                                    </p>
                                </li>
                            </ul>

                            <!-- <div class="list">
                            <div class="item">
                                <input id="1" type="radio" name="1">
                                <label for="1">Пожалуйста, вернитесь в корзину и повторите вновь оформление
                                    заказа.</label>
                            </div>
                            <div class="item"> <input id="2" type="radio" name="1">
                                <label for="2">Пожалуйста, вернитесь в корзину и повторите вновь оформление
                                    заказа.</label>
                                </div>
                            <div class="item"> <input id="3" type="radio" name="1"><label for="3">Правильно ли Вы ввели данные своей карты.</label></div>
                            <div class="item"> <input id="4" type="radio" name="1"><label for="4">Обратитесь, пожалуйста, в свой банк в случае технического сбоя процесинга
                                оплаты</label>
                                </div>
                        </div> -->

                            <button id="next-6">Вернуться <br />в корзину</button>
                        </div>
                    </div>
                </div>

                <div id="dialog9" class="done popup-dialog popup-dialog-hidden">
                    <div class="dialog__top">
                        <h4>Полное содержание. Фрагмент №8</h4>
                        <button class="dialog__close"></button>
                    </div>

                    <div class="dialog__center">
                        <div class="payment-success">
                            <h3 class="epic-font-green">Ваш заказ успешно оплачен!</h3>

                            <div class="img-wrapper">
                                <img src="{{ Vite::asset('resources/img/mark.png') }}" alt="" />
                            </div>

                            <button id="next-5" class="p-button">
                                Активируйте доступ <br />
                                к медиаконтенту
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
