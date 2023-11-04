@props([
	'name',
	'text' => '',
	'italic' => '',
	'value' => '',
	'checked' => false,
])

<label class="radio-group__item radio-input">
	<input type="radio" name="{{ $name }}" value={{ $value }} @if($checked) checked @endif>
	<div class="radio-input__text">{{ $text }} <span class="radio-input__text_italic">{{ $italic }}</span></div>
</label>
