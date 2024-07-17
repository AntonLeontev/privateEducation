<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'password' => ['required', 'string', 'max:255', 'current_password'],
            'new_password' => ['required', 'string', 'max:255', 'confirmed', 'min:8'],
            'new_password_confirmation' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => __('validation.attributes.password'),
            'new_password' => __('validation.attributes.new_password'),
        ];
    }

    public function messages(): array
    {
        return [];
    }
}
