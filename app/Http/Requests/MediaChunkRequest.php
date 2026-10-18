<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MediaChunkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return admin()->user()->isAdmin();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'index' => ['required', 'integer', 'min:0'],
            'chunk' => ['required', 'file'],
        ];
    }
}
