@extends('layouts.app.app')

@section('title', '')

@section('content')
    <main class="main main--copyright">
        <div class="restore-pass-content">
            <div class="container">
                <div class="content-block-wrapper">
                    <div
                        class="content-block content-block--no-scroll content-block--copyright main-form-content main-form-content-change">
                        <form method="POST" action="/user/password" class="main-form change_password-form">
							@csrf
							@method('PUT')
                            <input class="modal-input" type="password" name="current_password" placeholder="Текущий пароль">
                            <input class="modal-input modal-input--password" type="password" name="password"
                                placeholder="Новый пароль">
                            <input class="modal-input modal-input--password" type="password" name="password_confirmation"
                                placeholder="Новый пароль (повторить)">
							
							@error('password')
								<div style="color: white" class="login-error-message">{{ $errors->first('password') }}</div>
							@enderror
							@error('current_password')
								<div style="color: white" class="login-error-message">
									{{ $errors->first('current_password') }}
								</div>
							@enderror

                            <button class="myBtn action-btn auth-modal__login-btn">Сохранить пароль</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
