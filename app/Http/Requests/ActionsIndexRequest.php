<?php

namespace App\Http\Requests;

use App\Support\Traits\WorksWithPeriods;
use Illuminate\Foundation\Http\FormRequest;

class ActionsIndexRequest extends FormRequest
{
    use WorksWithPeriods;

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
            //
        ];
    }
}
