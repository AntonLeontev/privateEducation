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
                                <span class="account-content__title-text">Личная&nbsp;страница</span>
                            </h1>
                            <div class="account-content__action-button-bar action-button-bar">
                                <button id="account-purchases-btn"
                                    class="action-button-bar__action-button tabs__button _active" data-tab="tab_1">
                                    Мои&nbsp;покупки
                                </button>
                                <button id="account-settings-btn" class="action-button-bar__action-button tabs__button"
                                    data-tab="tab_2">
                                    Настройки
                                </button>
                                <button id="account-password-btn" class="action-button-bar__action-button tabs__button"
                                    data-tab="tab_3">
                                    Сменить&nbsp;пароль
                                </button>
                            </div>
                            <button id="account-exit-btn" class="account-content__exit-button">
                                Выход
                            </button>
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
                                                Фрагмент &#8470;&nbsp;4
                                            </span>
                                        </div>
                                        <button class="purchase-item__btn-action">
                                            Воспроизвести
                                        </button>
                                        <span class="purchase-item__date">
                                            15.03.2021
                                        </span>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- по нажатии мои настройки -->
                        <div id="tab_2" class="account-content__outer outer-settings outer tabs__item">
                            <div class="account-content__inner inner-settings inner">
                                <div class="settings settings__wrapper">
                                    <h3 class="settings__title">
                                        Редактирование аккаунта
                                    </h3>
                                    <form class="settings__form">
                                        <div class="settings__section">
                                            <h4 class="settings__subtitle">
                                                Личные данные
                                            </h4>
                                            <ul class="settings__data-list">
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        E-mail
                                                    </span>
                                                    <input id="settings-email" type="email" class="settings__input"
                                                        placeholder="ivanov@gmail.com" disabled>
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        Контактный номер
                                                    </span>
                                                    <input id="settings-tel" type="email" class="settings__input"
                                                        placeholder="+7 (900) 000 00 00">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        Имя
                                                    </span>
                                                    <input id="settings-name" type="email" class="settings__input"
                                                        placeholder="Иван">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        Фамилия
                                                    </span>
                                                    <input id="settings-surname" type="email" class="settings__input"
                                                        placeholder="Иванов">
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="settings__section">
                                            <h4 class="settings__subtitle settings__subtitle--address">
                                                Адрес
                                            </h4>
                                            <ul class="settings__adress-list">
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        Страна
                                                    </span>
                                                    <input id="settings-country" type="email" class="settings__input"
                                                        placeholder="Страна">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        Город
                                                    </span>
                                                    <input id="settings-city" type="email" class="settings__input"
                                                        placeholder="Город">
                                                </li>
                                                <li class="settings__item">
                                                    <span class="settings__label">
                                                        Улица
                                                    </span>
                                                    <input id="settings-street" type="email" class="settings__input"
                                                        placeholder="Улица">
                                                </li>
                                                <li id="settings-housing" class="settings__item">
                                                    <ul class="housing__list">
                                                        <li class="settings__item">
                                                            <span class="settings__label">
                                                                Дом
                                                            </span>
                                                            <input id="settings-building" type="email"
                                                                class="settings__input" placeholder="10">
                                                        </li>
                                                        <li class="settings__item">
                                                            <span class="settings__label">
                                                                Квартира
                                                            </span>
                                                            <input id="settings-apartment" type="email"
                                                                class="settings__input" placeholder="100">
                                                        </li>
                                                        <!--id = 'settings-index-box' для стилизации в мобилке -->
                                                        <li id="settings-index-box" class="settings__item">
                                                            <span class="settings__label">
                                                                Индекс
                                                            </span>
                                                            <input id="settings-post-index" type="email"
                                                                class="settings__input" placeholder="123456">
                                                        </li>
                                                    </ul>

                                                </li>
                                            </ul>
                                        </div>
                                        <button class="settings__submit-btn">
                                            Сохранить&nbsp;изменения
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Если по нажатии сменить пароль -->
                        <div id="tab_3" class="account-content__outer outer-password-change outer tabs__item">
                            <div class="account-content__inner inner-password-change inner">
                                <div class="password-change password-change__wrapper">
                                    <form class="password-change__form">
                                        <input type="text" class="password-change__input"
                                            placeholder="Текущий пароль">
                                        <input type="text" class="password-change__input" placeholder="Новый пароль">
                                        <input type="text" class="password-change__input"
                                            placeholder="Новый пароль (повторить)">
                                        <button type="submit" class="password-change__submit-btn">
                                            Сохранить&nbsp;пароль
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
