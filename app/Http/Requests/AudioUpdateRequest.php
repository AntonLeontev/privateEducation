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
        //TODO
        return true;
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
        ];
    }
}
