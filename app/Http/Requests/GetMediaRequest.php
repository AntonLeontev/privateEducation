<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        if ($this->route('type') === 'presentation') {
            return true;
        }

        if (admin()->user()?->isAdmin()) {
            return true;
        }

        if (! auth()->check()) {
            return false;
        }

        $subscription = auth()->user()->activeSubscriptions
            ->where('type', $this->route('type'))
            ->where('fragment_id', $this->route('fragmentId'))
            ->first();
        if ($subscription !== null) {
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
