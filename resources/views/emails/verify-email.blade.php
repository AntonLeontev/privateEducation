<div>{{ __('emails/verify-email.greetings') }}!</div>
<div>{{ __('emails/verify-email.thanks') }} <span style="font-weight: bold; color: #e9752c">{{ __('emails/verify-email.site') }}</span></div>
<br>
<br>
<div><span style="font-weight: bold">{{ __('emails/verify-email.password') }}</span></div>
<div>{{ $password }}</div>
<br>
<br>
<div>{{ __('emails/verify-email.finish') }}</div>
<br>
<div><a style="color: #e9752c; font-style: italic" href="{{ route('verify-email', [$user->email, 'password' => $user->password]) }}">{{ route('verify-email', [$user->email, 'password' => $user->password]) }}</a></div>
<br>
<br>
<hr>
<br>
<h3>{{ __('emails/verify-email.contacts') }}</h3>
<table>
	<tbody>
		<tr>
			<th width="40%" align="left">{{ __('emails/verify-email.email') }}</th>
			<td>voldemar606060@gmail.com </td>
		</tr>
		<tr>
			<th width="40%" align="left">{{ __('emails/verify-email.lat_phone') }}</th>
			<td>(+371)29892296 </td>
		</tr>
		<tr>
			<th width="40%" align="left">{{ __('emails/verify-email.ger_phone') }}</th>
			<td>(+49)15221942007</td>
		</tr>
		<tr>
			<th width="40%" align="left">{{ __('emails/verify-email.office') }}</th>
			<td>Grebensteiner str 2. Kassel . 34127. Germany</td>
		</tr>
	</tbody>
</table>

