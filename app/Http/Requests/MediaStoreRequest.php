<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MediaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'audio' => ['sometimes', 'file'],
            'video' => ['sometimes', 'file'],
            'lang' => ['required', 'in:ru,en'],
            'sound' => ['required', 'in:mono,stereo'],
            'device' => ['required', 'in:notebook,tablet,mobile'],
            'type' => ['required', 'in:audio,video,presentation'],
            'fragment_id' => ['required', 'exists:fragments,id'],
        ];
    }
}
