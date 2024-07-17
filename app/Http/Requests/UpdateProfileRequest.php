<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:50'],
            'apartment' => ['nullable', 'string', 'max:50'],
            'zip' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('validation.attributes.name'),
            'surname' => __('validation.attributes.surname'),
            'phone' => __('validation.attributes.phone'),
            'country' => __('validation.attributes.country'),
            'city' => __('validation.attributes.city'),
            'street' => __('validation.attributes.street'),
            'building' => __('validation.attributes.building'),
            'apartment' => __('validation.attributes.apartment'),
            'zip' => __('validation.attributes.zip'),
        ];
    }
}
