@props([
	'name',
	'text' => '',
	'italic' => '',
	'checked' => false,
])

<label class="radio-group__item radio-input">
	<input type="radio" name="{{ $name }}" @if($checked) checked @endif>
	<div class="radio-input__text">{{ $text }} <span class="radio-input__text_italic">{{ $italic }}</span></div>
</label>
