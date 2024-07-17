@extends('layouts.app.app')

@section('title', 'Личный кабинет')

@section('css')
    <link rel="stylesheet" href="/css/account.css" />
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')

                @include('partials.app.sidebar')

				<div id="account-main-wrapper" class="main__center main__desk" style="display: block">
                    <div class="account-content">
                        <div class="account-content__top">
                            <h1 class="account-content__title title">
                                <span class="account-content__title-text">{{ __('personal.personal') }}</span>
                            </h1>
                            <div class="account-content__action-button-bar action-button-bar">
                                <button id="account-purchases-btn"
                                    class="action-button-bar__action-button tabs__button _active" data-tab="tab_1">
                                    {{ __('personal.purchases') }}
                                </button>
                                <button id="account-settings-btn" class="action-button-bar__action-button tabs__button"
                                    data-tab="tab_2">
                                    {{ __('personal.settings') }}
                                </button>
                                <button id="account-password-btn" class="action-button-bar__action-button tabs__button"
                                    data-tab="tab_3">
                                    {{ __('personal.password') }}
                                </button>
                            </div>
							<form action="{{ route('logout') }}" method="POST">
								@csrf
								<button id="account-exit-btn" class="account-content__exit-button">
									{{ __('personal.exit') }}
								</button>
							</form>
                        </div>

                        <!-- по нажатии мои покупки -->
                        <div id="tab_1" class="account-content__outer outer purchases-outer tabs__item _active">
                            <div class="account-content__inner inner purchases-inner">
                                <div class="purchases purchases__wrapper">
                                    <div class="purchase-item">
                                        <span class="purchase-item__number">
                                            #75642
                                        </span>
                                        <div class="purchase-item__box">
                                            <img src="/img/audio.png" alt="shop" class="purchase-item__img">
                                            <span class="purchase-item__name">
                                                {{ __('personal.fragment') }} &#8470;&nbsp;4
                                            </span>
                                        </div>
                                        <button class="purchase-item__btn-action">
                                            {{ __('personal.play') }}
                                        </button>
                                        <span class="purchase-item__date">
                                            15.03.2021
                                        </span>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- по нажатии мои настройки -->
						<style>
							.error-message {
								text-align: center;
								font-weight: 600;
								font-size: 33.5px;
								color: #000;
							}
						</style>
                        <div id="tab_2" class="account-content__outer outer-settings outer tabs__item" x-data="{
							error: '',
							processing: false,

							save(e) {
								this.error = '';
								this.processing = true;
								
								axios
									.post(route('personal.update'), new FormData(e.target))
									.catch(err => this.error = err.response.data.message)
									.finally(() => this.processing = false)
							},
						}">
                            <div class="account-content__inner inner-settings inner">
                                <div class="settings settings__wrapper">
                                    <h3 class="settings__title">
                                        {{ __('personal.edit') }}
                                    </h3>
                                    <form class="settings__form" @submit.prevent="save">
                                        <div class="settings__section">
                                            <h4 class="settings__subtitle">
                                                {{ __('personal.data') }}
                                            </h4>
                                            <ul class="settings__data-list">
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.email') }}
                                                    </span>
                                                    <input id="settings-email" type="email" class="settings__input"
                                                        value="{{ auth()->user()->email }}" disabled>
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.number') }}
                                                    </span>
                                                    <input id="settings-tel" type="text" class="settings__input"
                                                        placeholder="{{ __('personal.phone_placeholder') }}" name="phone" value="{{ auth()->user()->phone }}">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.name') }}
                                                    </span>
                                                    <input id="settings-name" type="text" class="settings__input"
                                                        placeholder="{{ __('personal.name_placeholder') }}" name="name" value="{{ auth()->user()->name }}">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.surname') }}
                                                    </span>
                                                    <input id="settings-surname" type="text" class="settings__input"
                                                        placeholder="{{ __('personal.surname_placeholder') }}" name="surname" value="{{ auth()->user()->surname }}">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="settings__section">
                                            <h4 class="settings__subtitle settings__subtitle--address">
                                                {{ __('personal.address') }}
                                            </h4>
                                            <ul class="settings__adress-list">
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.country') }}
                                                    </span>
                                                    <input id="settings-country" type="text" class="settings__input"
                                                        placeholder="{{ __('personal.country') }}" name="country" value="{{ auth()->user()->country }}">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.city') }}
                                                    </span>
                                                    <input id="settings-city" type="text" class="settings__input"
                                                        placeholder="{{ __('personal.city') }}" name="city" value="{{ auth()->user()->city }}">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        {{ __('personal.street') }}
                                                    </span>
                                                    <input id="settings-street" type="text" class="settings__input"
                                                        placeholder="{{ __('personal.street') }}" name="street" value="{{ auth()->user()->street }}">
                                                </li>
                                                <li id="settings-housing" class="settings__item">
                                                    <ul class="housing__list">
                                                        <li class="settings__item">
                                                            <span class="settings__label">
                                                                {{ __('personal.house') }}
                                                            </span>
                                                            <input id="settings-building" type="text"
                                                                class="settings__input" placeholder="10" name="building" value="{{ auth()->user()->building }}">
                                                        </li>
                                                        <li class="settings__item">
                                                            <span class="settings__label">
                                                                {{ __('personal.apartment') }}
                                                            </span>
                                                            <input id="settings-apartment" type="text"
                                                                class="settings__input" placeholder="100" name="apartment" value="{{ auth()->user()->apartment }}">
                                                        </li>
                                                        <!--id = 'settings-index-box' для стилизации в мобилке -->
                                                        <li id="settings-index-box" class="settings__item">
                                                            <span class="settings__label">
                                                                {{ __('personal.zip') }}
                                                            </span>
                                                            <input id="settings-post-index" type="text"
                                                                class="settings__input" placeholder="123456" name="zip" value="{{ auth()->user()->zip }}">
                                                        </li>
                                                    </ul>

                                                </li>
                                            </ul>
                                        </div>
										<div class="error-message" x-text="error"></div>
                                        <button class="settings__submit-btn" :disabled="processing">
                                            {{ __('personal.save') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Если по нажатии сменить пароль -->
                        <div id="tab_3" class="account-content__outer outer-password-change outer tabs__item" x-data="{
							error: '',
							processing: false,

							save(e) {
								this.error = '';
								this.processing = true;
								
								axios
									.post(route('account.password'), new FormData(e.target))
									.then(e.target.reset())
									.catch(err => {
										this.error = err.response.data.message
									})
									.finally(() => this.processing = false)
							},
						}">
                            <div class="account-content__inner inner-password-change inner">
                                <div class="password-change password-change__wrapper">
                                    <form class="password-change__form" @submit.prevent="save">
                                        <input type="password" class="password-change__input"
                                            placeholder="{{ __('personal.current_password') }}" name="password">
                                        <input type="password" class="password-change__input" placeholder="{{ __('personal.new_password') }}"
											name="new_password">
                                        <input type="password" class="password-change__input"
                                            placeholder="{{ __('personal.repeat_password') }}" name="new_password_confirmation">
										<div class="error-message" x-text="error"></div>
                                        <button type="submit" class="password-change__submit-btn" :disabled="processing">
                                            {{ __('personal.save_password') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script src="/js/app.bundle.js"></script>

@endsection
