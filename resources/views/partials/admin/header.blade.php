<header class="my-4 header">
  <div class="container container-header">
    <nav class="header__nav">
      <ul class="header__list__nav">
		  <li class="header__nav__list-item"><a href="{{ route('admin.custom') }}">Фрагменты</a></li>
        <li style="margin-left:3.9vw;" class="header__nav__list-item"><a href="{{ route('admin.users') }}">Пользователи</a></li>
        {{-- <li class="header__nav__list-item">
          <a href="about.php">
            О компании
          </a>
        </li>
        <li class="header__nav__list-item"><a href="copyright.php">Impression</a></li>
        <li class="header__nav__list-item"><a href="commercial.php">AGB</a></li>
        <li class="header__nav__list-item"><a href="privacy.php">Datenschutz</a></li>
        <li class="header__nav__list-item"><a href="contacts.php">Контакты</a></li> --}}
      </ul>
    </nav>
    <a class="user_link" href="">
      <img src="{{ Vite::asset('resources/images/user.png') }}" alt="">
      <div class="lk">
        Личный кабинет
      </div>
    </a>
    <div class="burger">
      <div class="">Меню</div>
      <span></span>
    </div>
  </div>
</header>
