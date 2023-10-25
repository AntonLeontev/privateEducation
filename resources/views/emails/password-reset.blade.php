@extends('emails.layouts.notification')

@section('content')
	<div>{{ __('emails/password-reset.greetings') }}!</div>
	<div>{{ __('emails/password-reset.thanks') }} <span style="font-weight: bold; color: #e9752c">{{ __('emails/password-reset.site') }}</span></div>
	<br>
	<br>
	<div>
		<span style="font-weight: bold; margin-right: 2px">{{ __('emails/password-reset.password') }}</span>
		<span>{{ $password }}</span>
	</div>
	<br>
	<br>
	<div>{{ __('emails/password-reset.finish') }}</div>
@endsection

