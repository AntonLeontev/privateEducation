@extends('layouts.app.app')

@section('title', '')

@section('content')
    <main class="main main--copyright">
        <div class="buy-content">
            <div class="content-block">
                <div class="container">
                    <ul class="buys no-style">
                        <li tabindex="0" class="buy-item">
                            <div class="buy-item-wrapper">
                                <div class="number">#75642</div>
                                <div class="desc">
                                    <img class="buy-item__img" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="audio-icon">
                                    <span class="name">Фрагмент № 4</span>
                                </div>
                                <div class="buy-btn-wrapper">
                                    <button>Воспроизвести</button>
                                </div>
                                <div class="date">15.03.2021</div>
                            </div>
                        </li>
                        <li tabindex="0" class="buy-item">
                            <div class="buy-item-wrapper">
                                <div class="number">#75641</div>
                                <div class="desc">
                                    <img class="buy-item__img" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="audio-icon">
                                    <span class="name">Фрагмент № 3</span>
                                </div>
                                <div class="buy-btn-wrapper">
                                    <button>Воспроизвести</button>
                                </div>
                                <div class="date">10.03.2021</div>
                            </div>
                        </li>
                        <li tabindex="0" class="buy-item">
                            <div class="buy-item-wrapper">
                                <div class="number">#75639</div>
                                <div class="desc">
                                    <img class="buy-item__img" src="{{ Vite::asset('resources/images/icon2.png') }}" alt="audio-icon">
                                    <span class="name">Фрагмент № 1</span>
                                </div>
                                <div class="buy-btn-wrapper">
                                    <button onclick="location.href='index.php';">Воспроизвести</button>
                                </div>
                                <div class="date">02.03.2021</div>
                            </div>
                        </li>
                        <li tabindex="0" class="buy-item">
                            <div class="buy-item-wrapper">
                                <div class="number">#75638</div>
                                <div class="desc">
                                    <img class="buy-item__img" src="{{ Vite::asset('resources/images/icon3.png') }}" alt="video-icon">
                                    <span class="name">Фрагмент № 2</span>
                                </div>
                                <div class="buy-btn-wrapper">
                                    <button onclick="location.href='index.php';">Воспроизвести</button>
                                </div>
                                <div class="date">03.03.2021</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </main>
@endsection
