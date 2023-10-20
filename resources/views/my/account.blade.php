@extends('layouts.app.app')

@section('title', '')

@section('content')
	<main class="main main--copyright">
        <div class="container">
            <div class="account-content">

                <div class="content-block-wrapper">
                    <div class="content-block content-block--account">

                        <h1>Редактирование аккаунта</h1>

                        <form class="main-form main-form--account" method="POST" action="/user/profile-information">
							@csrf
							@method('PUT')
                            <h2>Личные данные</h2>
                            <div class="flex-container">
                                <div class="form-flex-element">
                                    <label for="email">E-mail</label>
                                    <input id="email" class="modal-input" type="email" name="email"
                                        value="{{ auth()->user()->email }}" disabled>
                                </div>
                                <div class="form-flex-element">
                                    <label for="phone">Контактный номер</label>
                                    <input id="phone" class="modal-input" name="phone"
                                        placeholder="+7 (900) 999 95 95" value="{{ auth()->user()->phone }}">
                                </div>
                                <div class="form-flex-element">
                                    <label for="name">Имя</label>
                                    <input id="name" class="modal-input" type="text" placeholder="Иван" name="name" value="{{ auth()->user()->name }}">
                                </div>
                                <div class="form-flex-element">
                                    <label for="surname">Фамилия</label>
                                    <input id="surname" class="modal-input" type="text" placeholder="Иванов" name="surname" value="{{ auth()->user()->surname }}">
                                </div>
                            </div>

                            <h2>Адрес</h2>
                            <div class="flex-container">
                                <div class="form-flex-element">
                                    <label for="country">Страна</label>
                                    <input id="country" class="modal-input" name="country" value="{{ auth()->user()->country }}" placeholder="Россия">
                                </div>
                                <div class="form-flex-element">
                                    <label for="city">Город</label>
                                    <input id="city" class="modal-input" name="city" placeholder="Москва" value="{{ auth()->user()->city }}">
                                </div>
                                <div class="form-flex-element">
                                    <label for="street">Улица</label>
                                    <input id="street" class="modal-input" name="street"
                                        placeholder="пр. Ленина" value="{{ auth()->user()->street }}">
                                </div>
                                <div class="form-flex-element three-inputs">


                                    <div class="sub-flex-element">
                                        <label for="house">Дом</label>
                                        <input id="house" class="modal-input" name="building" value="{{ auth()->user()->building }}" placeholder="10">
                                    </div>

                                    <div class="sub-flex-element">
                                        <label for="appart">Квартира</label>
                                        <input id="appart" class="modal-input" name="apartment" value="{{ auth()->user()->apartment }}" placeholder="112">
                                    </div>

                                    <div class="sub-flex-element">
                                        <label for="code">Индекс</label>
                                        <input id="code" class="modal-input" name="zip"  value="{{ auth()->user()->zip }}"
                                            placeholder="603185">
                                    </div>


                                </div>
                            </div>

                            <button class="myBtn action-btn">Сохранить изменения</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
