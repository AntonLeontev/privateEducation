<h5>{{ __('home.windows.radio-inputs.device.title') }}</h5>
<div class="dialog__checkbox">
	<input id="vehicle3" type="radio" name="device" value="mobile" x-model="device" />
	<label class="dialog__input-label" for="vehicle3">
		{{ __('home.windows.radio-inputs.device.mobile1') }}
		<span>{{ __('home.windows.radio-inputs.device.mobile2') }}</span>
	</label><br />
</div>
<div class="dialog__checkbox">
	<input id="vehicle4" type="radio" name="device" value="tablet" x-model="device" />
	<label class="dialog__input-label" for="vehicle4">{{ __('home.windows.radio-inputs.device.tablet') }}</label><br />
</div>
<div class="dialog__checkbox">
	<input id="vehicle5" type="radio" name="device" value="notebook" x-model="device" />
	<label class="dialog__input-label" for="vehicle5">{{ __('home.windows.radio-inputs.device.notebook') }}</label><br />
</div>
