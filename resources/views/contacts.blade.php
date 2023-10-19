@extends('layouts.app.app')

@section('title')

@section('content')
    <main class="main main--contacts">
        <div class="container">
            <div class="title-block title-block--contacts">Контакты</div>
            <div class="content-block-wrapper">
                <div class="content-block content-block--no-scroll content-block--contacts">

                    <div class="address-data-block">
                        <div class="address-data-title">
                            Электронная почта
                        </div>
                        <div class="address-data-text">
                            <span class="ref-underlined">voldemar606060@gmail.com</span>
                        </div>
                        <div class="address-data-title">
                            Телефон в Латвии
                        </div>
                        <div class="address-data-text">
                            (+371)29892296
                        </div>

                        <div class="address-data-title">
                            Телефон в Германии
                        </div>
                        <div class="address-data-text">
                            (+49)15221942007
                        </div>

                        <div class="address-data-title">
                            Офис разработки
                        </div>
                        <div class="address-data-text">
                            Grebensteiner str 2. Kassel . 34127. Germany
                        </div>
                    </div>

                    <div class="bank-data-block">

                        <h2>Банковские данные</h2>
                        <p>
                            Даугавпилское Региональное Христианско Демократическое Правозащитное
                            Движение, сокращённое наименование – ДРХДПД
                        </p>
                        <div class="bank-req-wrapper">

                            <div class="bank-data-title">
                                Bank
                            </div>
                            <div class="bank-data-text">
                                AS&nbsp;&nbsp;Citadele banka
                            </div>

                            <div class="bank-data-title">
                                BIC/Swift
                            </div>
                            <div class="bank-data-text">
                                PARXLV22XXX
                            </div>

                            <div class="bank-data-title bank-data-title--slim">
                                IBAN EUR
                            </div>
                            <div class="bank-data-text bank-data-text--slim">
                                LV93PARX0006035975124
                            </div>

                        </div>

                    </div>

                    <div class="divider-line"></div>

                    <div class="feedback-form-block">
                        <h2 class="feedback-header">Обратная связь</h2>
                        <form action="" class="contacts__feedback-form">
                            <div class="form-placeholder-wrapper">
                                <input id="name" type="text" required
                                    class="feedback-input feedback-input--with-star" placeholder="Ваше имя">
                                <label for="name" class="star-input-label star-input-label--name">*</label>
                            </div>

                            <div class="form-placeholder-wrapper">
                                <input id="email" type="text" required
                                    class="feedback-input feedback-input--with-star" placeholder="Ваш e-mail">
                                <label for="email" class="star-input-label star-input-label--email">*</label>
                            </div>

                            <div class="form-placeholder-wrapper">
                                <input id="phone" type="text" required
                                    class="feedback-input feedback-input--with-star" placeholder="Ваш телефон">
                                <label for="phone" class="star-input-label star-input-label--phone">*</label>
                            </div>

                            <input type="text" class="feedback-input" placeholder="Тема">
                            <textarea class="feedback-input feedback-input--message" placeholder="Сообщение"></textarea>
                        </form>
                    </div>


                    <div class="btn-wrapper">
                        <button class="action-btn back-to-purchase--contacts">
                            Отправить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
