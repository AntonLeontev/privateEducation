<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AudioUpdateRequest extends FormRequest
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
            'price' => ['sometimes', 'numeric', 'min:0', 'max:42949671'],
            'text_ru' => ['sometimes', 'string', 'max:10000'],
            'text_en' => ['sometimes', 'string', 'max:10000'],
        ];
    }
}
