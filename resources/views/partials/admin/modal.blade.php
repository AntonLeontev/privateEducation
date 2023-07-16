<div class="hidden auth-modal fragment-modal--main modal-fragment-main">
    <div class="modal-header">
        <span class="modal-header-text">Фрагмент #1</span>


        <button class="myBtn modal-close-btn"></button>

    </div>
    <div class="modal-step step modal-step-under">
        Шаг 3 из 5
    </div>
    <div class="modal-title">
        Авторизация
    </div>
    <div class="modal-reg-buttons-wrapper">

        <div class="modal-auth-btn modal-auth-btn--user-fragment active">
            <img src="/img/Im-user.png" alt="I'm user button"> <span class="modal-regbtn-text">Я пользователь</span>
        </div>
        <div  class="modal-auth-btn modal-auth-btn--reg-fragment disable" >
            <img src="/img/reg.png" alt="registration button"><span class="modal-regbtn-text modal-regbtn-text--reg">Регистрация</span>
        </div>
    </div>
    <form class="modal-auth-form">
        <div class="modal-email-label">
            Адрес электронной почты:
        </div>
        <input class="modal-input" type="email" name="email"
               placeholder="* * * * * * * * * * * * * * * * * * * *">

        <div class="modal-password-wrapper">
      <span class="modal-email-label">
        Пароль:
      </span>
            <a class="modal-password-forgotten-fragments" href="#">Забыли пароль?</a>
        </div>
        <input class="modal-input modal-input--password" type="password" name="password" placeholder="* * * * * * * * * * * * * * * * * * * *">
        <div class="login-error-message-fragment">
            Не удалось войти в аккаунт, введенные e-mail или пароль неверны
        </div>
        <button class="myBtn action-btn auth-modal__login-btn-fragment">ВХОД</button>
    </form>
</div>
