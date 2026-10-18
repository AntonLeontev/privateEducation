<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MediaUploadInitRequest extends FormRequest
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
            'lang' => ['required', 'in:ru,en'],
            'sound' => ['required', 'in:mono,stereo'],
            'device' => ['required', 'in:notebook,tablet,mobile'],
            'type' => ['required', 'in:audio,video,presentation'],
            'fragment_id' => ['required', 'exists:fragments,id'],
            'size' => ['required', 'integer', 'min:1'],
        ];
    }
}
