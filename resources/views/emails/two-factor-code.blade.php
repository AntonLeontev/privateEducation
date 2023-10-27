<div>Вход администратора с логином <span style="font-weight: bold">{{ $admin->email }}</span></div>

<div style="margin-top: 15px">Одноразовый код для входа в админ панель на сайте Частного образования:</div>
<div style="font-weight: bold">{{ $admin->two_factor_code }}</div>

<div style="margin-top: 15px">Срок действия кода {{ config('auth.two_factor_code_timeout') / 60 }} минут</div>
