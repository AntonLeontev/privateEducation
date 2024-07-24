<div>Заполнена форма обратной связи:</div>

<div style="margin-top: 15px">Имя: {{ $request['name'] }}</div>
<div>Email: {{ $request['email'] }}</div>
<div>Телефон: {{ $request['phone'] }}</div>
<div>Тема: {{ $request['subject'] }}</div>
<div>Сообщение:<br> {!! nl2br($request['message']) !!}</div>

