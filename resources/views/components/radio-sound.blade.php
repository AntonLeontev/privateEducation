@props([
	'hasText' => false
])

<div class="dialog__checkbox">
	<input id="volume1" type="radio" name="sound" value="mono" x-model="sound" />
	<label class="dialog__input-label" class="dialog__input-label" for="volume1">
		{{ __('home.windows.radio-inputs.volume.mono1') }}
		<span>{{ __('home.windows.radio-inputs.volume.mono2') }}</span></label><br />
</div>
<div class="dialog__checkbox">
	<input id="volume2" type="radio" name="sound" value="stereo" x-model="sound" />
	<label class="dialog__input-label" for="volume2">
		{{ __('home.windows.radio-inputs.volume.stereo1') }} 
		<span>{{ __('home.windows.radio-inputs.volume.stereo2') }}</span>
	</label>
	<br />
</div>

@if ($hasText)
	<div class="dialog__checkbox">
		<input id="volume3" type="radio" name="sound" value="text" x-model="sound" />
		<label class="dialog__input-label" for="volume3">{{ __('home.windows.radio-inputs.volume.text') }}</label><br />
	</div>
@endif
