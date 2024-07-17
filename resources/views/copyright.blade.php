@extends('layouts.app.app')

@section('title', 'Авторское право')

@section('css')
    <link rel="stylesheet" href="/css/impression.css" />
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')
                <div class="main__center main__desk">
                    <div class="impression-content">
                        <h1 class="impression-content__title title">
                            <span class="impression-content__title-text">Авторское право</span>
                        </h1>
                        <div class="impression-content__outer outer">
                            <div class="impression-content__inner inner">
                                <h2 class="inner__subtitle"> Интеллектуальная собственность</h2>
                                <span class="inner__desclaimer">
                                    Оператор веб-сайта и ответственный за продажи
                                </span>
                                <span class="inner__preamble"> Общие сведения об организации</span>

                                <dl class="inner__descr-list descr-list">
                                    <dt class="descr-list__theme">
                                        1. Полное наименование организации:
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        Даугавпилское Региональное Христианско Демократическое Правозащитное Движение,
                                        сокращённое наименование
                                        ДРХДПД
                                    </dd>

                                    <dt class="descr-list__theme">
                                        2. Организационно-правовой статус организации:
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        Латвийская общественная организация. <br />
                                        Reg.Nr 40008127911
                                    </dd>

                                    <dt class="descr-list__theme">
                                        3. Дата и место регистрации организации:
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        21.05.2008, город Рига, Латвия
                                    </dd>

                                    <dt class="descr-list__theme">
                                        4. Местонахождение организации (Страна, Регион, Город, точный почтовый адрес и адрес
                                        фактического
                                        нахождения
                                        организации):
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        Улица Циетокшня 68-51, Даугавпилс, LV-5401, Латгалия, Латвия. <br />
                                        Latvija, Daugavpils, Cietokšņa 68-51, LV-5401
                                    </dd>

                                    <dt class="descr-list__theme">
                                        5. Адрес сайта организации, ее электронный адрес, контакты:
                                    </dt>
                                    <dd class="descr-list__descrption">
                                        <i><a
                                                href="https://www.private-new-education.de">www.private-new-education.de</a></i><br />
                                        e-mail:<i><a
                                                href="mailto:voldemar606060@gmail.com">voldemar606060@gmail.com</a></i><br />
                                        телефон:<a href="tel:+4915221942007">(+4915221942007)</a><br />
                                    </dd>

                                </dl>
                                <div class="inner__text text">
                                    <p class="text__pharagraph">
                                        Все права на&nbsp;информацию, графические изображения, тексты и&nbsp;иные
                                        содержащиеся на&nbsp;Сайте
                                        Материалы
                                        и&nbsp;объекты, принадлежат Исполнителю, а&nbsp;также иным третьим лицам
                                        в&nbsp;соответствии
                                        с&nbsp;условиями договоров,
                                        заключенных между Исполнителем и&nbsp;соответствующими третьими лицами.
                                    </p>
                                    <p class="text__pharagraph">
                                        Никакие содержащиеся на&nbsp;Сайте Материалы или их&nbsp;часть не&nbsp;могут быть
                                        воспроизведены,
                                        использованы или
                                        переданы третьим лицам в&nbsp;целях извлечения прибыли без предварительного согласия
                                        Исполнителя
                                        в&nbsp;письменной
                                        форме.
                                    </p>
                                    <p class="text__pharagraph">
                                        Заказчик может просматривать Материалы, содержащиеся на&nbsp;Сайте, для целей
                                        исключительно личного
                                        использования.
                                    </p>
                                    <p class="text__pharagraph">
                                        Все товарные знаки, логотипы, фирменные наименования или обозначения (в&nbsp;том
                                        числе словесные,
                                        графические, объемные
                                        и&nbsp;другие обозначения или их&nbsp;комбинации), содержащиеся на&nbsp;Сайте,
                                        являются собственностью
                                        Исполнителя или
                                        принадлежат ему на&nbsp;праве пользования.
                                    </p>
                                    <p class="text__pharagraph">
                                        Размещение Материалов на&nbsp;Сайте не&nbsp;может рассматриваться как разрешение или
                                        предоставление прав
                                        на&nbsp;их&nbsp;использование без предварительного письменного согласия Исполнителя
                                        или
                                        их&nbsp;правообладателей.
                                    </p>
                                    <p class="text__pharagraph">
                                        Если содержимое Сайта нарушает правовые положения или сторонние права третьих лиц,
                                        Исполнитель требует
                                        извещать
                                        об&nbsp;этом без требований о&nbsp;возмещении. Исполнитель удалит соответствующие
                                        положения, если
                                        у&nbsp;Исполнителя
                                        есть на&nbsp;это право. Вмешательство адвоката не&nbsp;требуется. Если издержки
                                        возникнут из-за того,
                                        что Заказчик
                                        не&nbsp;обращался к&nbsp;Исполнителю заранее, Исполнитель имеет право полностью
                                        отклонить
                                        их&nbsp;и&nbsp;предъявить
                                        встречные требования.
                                    </p>
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
