<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        //TODO users auth for media
        if (Auth::guard('admin')->check()) {
            return true;
        }

        return false;
    }

    protected function failedAuthorization()
    {
        if (app()->isProduction()) {
            throw new NotFoundHttpException;
        }

        throw new AuthorizationException;
    }
}
