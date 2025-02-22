@extends('layouts.app.app')

@section('title', __('contacts.h1'))

@section('css')
	<script async src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @vite('resources/css/contacts.css')
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')
                <div class="main__center main__desk">
                    <div class="contacts-content">
                        <h1 class="contacts-content__title title">
                            <span class="contacts-content__title-text"> {{ __('contacts.h1') }} </span>
                        </h1>
                        <div class="contacts-content__outer outer">
                            <div class="contacts-content__inner inner">
                                <div class="inner__wrapper wrapper">
                                    <h2 class="inner__subtitle ">
                                        <!-- В макете нет. для читалок -->
                                        {!! __('contacts.1') !!}
                                    </h2>
                                    <ul class="wrapper__connections connections">
                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                {!! __('contacts.2') !!}
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <i><a
                                                        href="mailto:info@private-new-education.de">info@private-new-education.de</a></i>
                                            </div>
                                        </li>

                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                {!! __('contacts.3') !!}
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <a href="tel:+37129892296">(+371)29892296</a>
                                            </div>
                                        </li>

                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                {!! __('contacts.4') !!}
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <a href="tel:+4915221942007">(+49)15221942007</a>
                                            </div>
                                        </li>

                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                {!! __('contacts.5') !!}
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <address>Grebensteiner str 2. Kassel . 34127. Germany</address>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="wrapper__bank-data bank-data">
                                        <h2 class="inner__subtitle">
                                            {!! __('contacts.6') !!}
                                        </h2>
                                        <p class="inner__descr">
                                            {!! __('contacts.7') !!}
                                        </p>
                                        <ul class="bank-data__list">
                                            <li class="bank-data__item">
                                                <div class="bank-data__column bank-data__column--title">
                                                    Bank
                                                </div>
                                                <div class="bank-data__column bank-data__column--title">
                                                    Swedbank
                                                </div>
                                            </li>
                                            <li class="bank-data__item">
                                                <div class="bank-data__column bank-data__column--data">
                                                    IBAN EUR
                                                </div>
                                                <div class="bank-data__column bank-data__column--data">
                                                    LV57HABA0551055237872
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="bank-data__decor"></div>
                                    </div>
                                    <!-- JS для этой формы находится в html внизудокумента -->
                                    <form id="feedback-form" class="wrapper__feedback-form feedback-form"
										@submit.prevent="submit"
										x-data="{
											submit(e) {
												let data = new FormData(e.target);

												grecaptcha.ready(() => {
													grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'submit'}).then((token) => {
														data.append('recaptcha_token', token)
														
														axios
															.post(route('feedback'), data)
															.then(resp => e.target.reset())
															.catch(() => alert('Error!'))
													});
												});
											},
										}"
									>
                                        <h2 class="inner__subtitle feedback-form__subtitle">
                                            {{ __('contacts.8') }}
                                        </h2>
                                        <div class="feedback-form__inputs-wrapper">
                                            <input id="feedback-form-input-name" type="text" placeholder="{{ __('contacts.9') }}*"
                                                minlength="3" maxlength="50" required class="feedback-form__input" name="name">
                                            <input id="feedback-form-input-email" type="email" placeholder="{{ __('contacts.10') }}*"
                                                minlength="3" maxlength="50" required class="feedback-form__input" name="email">
                                            <input id="feedback-form-input-tel" type="text" placeholder="{{ __('contacts.11') }}*"
                                                required class="feedback-form__input" name="phone">
                                            <input id="feedback-form-input-subject" type="text" placeholder="{{ __('contacts.12') }}"
                                                maxlength="50" class="feedback-form__input" name="subject">
                                            <textarea id="feedback-form-input-message" name="message"
                                                class="feedback-form__input feedback-form__input--textarea" placeholder="{{ __('contacts.13') }}" maxlength="1000"></textarea>
                                        </div>
                                        <button id="feedback-form-button-submit" type="submit"
                                            class="feedback-form__button">
                                            {{ __('contacts.14') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('partials.app.sidebar')
            </div>
        </div>
    </main>
@endsection
