@extends('layouts.app.app')

@section('title')

@section('css')
    <link rel="stylesheet" href="/css/contacts.css" />
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')
                <div class="main__center main__desk">
                    <div class="contacts-content">
                        <h1 class="contacts-content__title title">
                            <span class="contacts-content__title-text"> Контакты </span>
                        </h1>
                        <div class="contacts-content__outer outer">
                            <div class="contacts-content__inner inner">
                                <div class="inner__wrapper wrapper">
                                    <h2 class="inner__subtitle visually-hidden">
                                        <!-- В макете нет. для читалок -->
                                        Контактная информация
                                    </h2>
                                    <ul class="wrapper__connections connections">
                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                Электронная почта
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <i><a
                                                        href="mailto:voldemar606060@gmail.com">voldemar606060@gmail.com</a></i>
                                            </div>
                                        </li>

                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                Телефон в&nbsp;Латвии
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <a href="tel:+37129892296">(+371)29892296</a>
                                            </div>
                                        </li>

                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                Телефон в&nbsp;Германии
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <a href="tel:+4915221942007">(+49)15221942007</a>
                                            </div>
                                        </li>

                                        <li class="connections__row">
                                            <div class="connections__column connections__column--title">
                                                Офис разработки
                                            </div>
                                            <div class="connections__column connections__column--data">
                                                <address>Grebensteiner str 2. Kassel . 34127. Germany</address>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="wrapper__bank-data bank-data">
                                        <h2 class="inner__subtitle">
                                            Банковские данные
                                        </h2>
                                        <p class="inner__descr">
                                            Даугавпилское Региональное Христианско Демократическое Правозащитное
                                            Движение, сокращённое наименование&nbsp;&mdash; ДРХДПД
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
                                    <form id="feedback-form" class="wrapper__feedback-form feedback-form">
                                        <h2 class="inner__subtitle feedback-form__subtitle">
                                            Обратная связь
                                        </h2>
                                        <div class="feedback-form__inputs-wrapper">
                                            <input id="feedback-form-input-name" type="text" placeholder="Ваше имя*"
                                                minlength="3" maxlength="20" required class="feedback-form__input">
                                            <input id="feedback-form-input-email" type="email" placeholder="Ваш e-mail*"
                                                minlength="3" maxlength="50" required class="feedback-form__input">
                                            <input id="feedback-form-input-tel" type="text" placeholder="Ваш телефон*"
                                                minlength="3" maxlength="12" required class="feedback-form__input">
                                            <input id="feedback-form-input-subject" type="text" placeholder="Тема"
                                                maxlength="50" class="feedback-form__input">
                                            <textarea id="feedback-form-input-message" name="feedback-form-input-message"
                                                class="feedback-form__input feedback-form__input--textarea" placeholder="Сообщение" maxlength="5000"></textarea>
                                        </div>
                                        <button id="feedback-form-button-submit" type="submit"
                                            class="feedback-form__button">
                                            Отправить
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
    <script src="/js/app.bundle.js"></script>
@endsection
