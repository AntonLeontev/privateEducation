@extends('layouts.app.app')

@section('title', 'О компании')

@section('css')
    <link rel="stylesheet" href="/css/about.css" />
@endsection

@section('content')
    <main>
        <div class="main">
            <div class="container">
                @include('partials.app.header')

                <div class="main__center main__desk">
                    <div class="about-content">
                        <h1 class="about-content__title title">
                            <span class="about-content__title-text"> О проекте </span>
                        </h1>
                        <div class="about-content__outer outer">
                            <div class="about-content__inner inner">
                                <h2 class="inner__subtitle"> Проект Частное образование </h2>
                                <span class="inner__desclaimer">
                                    Представлен в электронной книге, в аудиокниге и в видеокниге
                                </span>
                                <span class="inner__preamble"> Преамбула </span>
                                <span class="inner__descr">
                                    Суть инновационного образования, заключается в квалифицированном
                                    содействии, <br />Развитии у ребёнка
                                </span>

                                <ul class="inner__list">
                                    <li class="inner__item">
                                        I. Искусства сохранения, психического и физического здоровья.
                                    </li>
                                    <li class="inner__item">
                                        II. Профилактика юридических конфликтов – уберечь ребенка от
                                        совершения уголовно – наказуемых правонарушений и попадания в
                                        детскую колонию или тюрьму.
                                    </li>
                                    <li class="inner__item">
                                        III. Адекватного психического и физического Роста.
                                    </li>
                                    <li class="inner__item">
                                        IV. Религиозно – Духовной Самоиндефикации.
                                    </li>
                                    <li class="inner__item">
                                        V. Адекватной сексуальной самоиндефикации.
                                    </li>
                                    <li class="inner__item">
                                        VI. Политической и Профессионально – технологической
                                        Самоиндефикации.
                                    </li>
                                    <li class="inner__item additional">
                                        VII. Бытовой культуры.
                                        <ul class="additional__list">
                                            <li class="additional__item">a. Качество питания.</li>
                                            <li class="additional__item">
                                                b. Качество белья, одежды, и обуви.
                                            </li>
                                            <li class="additional__item">
                                                c. Качество и комфорт жилищного пространства.
                                            </li>
                                            <li class="additional__item">
                                                d. Качество Экологии Окружающей среды.
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <ul class="inner__target-list target-list">
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            Стратегическая Цель данного Образовательного проекта –
                                            Сохранение, Укрепление и Развитие бесценного
                                            Трансцендентального Дара как возможность и способность быть
                                            Человеком.
                                        </p>
                                    </li>
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            А Стратегические Задачи определить как – Развитие Свободы
                                            Личности и Индивидуальности, через адекватное познание и опыт
                                            позитивного переживания Реальности.
                                        </p>
                                    </li>
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            Интеллектуальный продукт представлен в цифровом формате и
                                            использует современные информационные технологии для
                                            популяризации и оптимизации восприятия этого продукта конечным
                                            потребителем.
                                        </p>
                                        <p class="target-list__descr">
                                            При активации интернет-страницы:
                                            <i>
                                                <a href="https://www.private-new-education.de">www.private-new-education.de
                                                </a></i>
                                        </p>
                                    </li>
                                    <li class="target-list__item">
                                        <p class="target-list__descr">
                                            Появляется возможность бесплатного доступа к видеофайлам всех
                                            17 – фрагментов для краткого ознакомления в качестве
                                            Презентации.
                                        </p>
                                    </li>
                                </ul>
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
