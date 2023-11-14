<?php

namespace App\Http\Requests;

use App\Support\Enums\AdminRole;
use Illuminate\Foundation\Http\FormRequest;

class AdminCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return admin()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'unique:admins,email', 'string', 'max:50'],
            'password' => ['required', 'confirmed', 'min:8', 'max:50'],
            'role' => ['required', 'string', 'in:'.implode(',', AdminRole::values())],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }
}
