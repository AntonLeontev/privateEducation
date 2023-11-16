<?php

namespace App\Http\Requests;

use App\Support\Traits\WorksWithPeriods;
use Illuminate\Foundation\Http\FormRequest;

class PaymentsIndexRequest extends FormRequest
{
    use WorksWithPeriods;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return admin()->user()->isAdmin();
    }
}
