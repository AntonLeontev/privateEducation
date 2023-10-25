@extends('emails.layouts.notification')

@section('content')
<div>{{ __('emails/verify-email.greetings') }}!</div>
<div>{{ __('emails/verify-email.thanks') }} <span style="font-weight: bold; color: #e9752c">{{ __('emails/verify-email.site') }}</span></div>
<br>
<br>
<div>
	<span style="font-weight: bold; margin-right: 2px">{{ __('emails/verify-email.password') }}</span>
	<span>{{ $password }}</span>
</div>
<br>
<br>
<div>{{ __('emails/verify-email.finish') }}</div>
<br>
<div><a style="color: #e9752c; font-style: italic" href="{{ route('verify-email', [$user->email, 'password' => $user->password]) }}">{{ route('verify-email', [$user->email, 'password' => $user->password]) }}</a></div>
@endsection


