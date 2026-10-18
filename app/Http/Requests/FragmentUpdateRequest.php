<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FragmentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return admin()->user()->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        $titles = [];

        foreach (['title_ru', 'title_en'] as $field) {
            if (! $this->exists($field)) {
                continue;
            }

            $value = $this->input($field);

            if (is_string($value)) {
                $titles[$field] = trim($value);
            }
        }

        if ($titles !== []) {
            $this->merge($titles);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'is_active' => ['sometimes', 'boolean'],
            'title_ru' => ['sometimes', 'filled', 'string', 'max:255'],
            'title_en' => ['sometimes', 'filled', 'string', 'max:255'],
        ];
    }
}
