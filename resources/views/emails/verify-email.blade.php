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
@if (is_null($purchaseParams))
<div>{{ __('emails/verify-email.finish') }}</div>
@else
<div>{{ __('emails/verify-email.finish_and_buy') }}</div>	
@endif
<br>
@php
	is_null($purchaseParams)
		? $link = route('verify-email', [$user->email, 'password' => $user->password])
		: $link = route('verify-email', [
			$user->email, 
			'password' => $user->password, 
			'fragment_id' => $purchaseParams->fragmentId, 
			'media_type' => $purchaseParams->mediaType, 
			'step' => $purchaseParams->step
		]);
@endphp
<div><a style="color: #e9752c; font-style: italic" href="{{ $link }}">{{ $link }}</a></div>
@endsection


