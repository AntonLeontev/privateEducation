<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePresentationViewSecondStatsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $buckets = $this->input('buckets');

        if (is_string($buckets)) {
            $decoded = json_decode($buckets, true);

            if (is_array($decoded)) {
                $this->merge(['buckets' => $decoded]);
            }
        }
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'presentation_id' => ['required', 'integer', 'exists:presentations,id'],
            'is_passive' => ['required', 'boolean'],
            'buckets' => ['required', 'array', 'min:1'],
            'buckets.*.s' => ['required', 'integer', 'min:0'],
            'buckets.*.c' => ['required', 'integer', 'min:1'],
        ];
    }
}
