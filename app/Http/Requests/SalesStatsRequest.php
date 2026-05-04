<?php

namespace App\Http\Requests;

use App\Support\Traits\DeterminesModel;
use App\Support\Traits\WorksWithPeriods;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SalesStatsRequest extends FormRequest
{
    use DeterminesModel;
    use WorksWithPeriods;

    public function authorize(): bool
    {
        return admin()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
