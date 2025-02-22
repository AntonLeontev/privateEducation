<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackRequest;
use App\Services\Grecaptcha\GrecaptchaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function __invoke(Request $request, GrecaptchaService $grecaptcha)
    {
        $grecaptcha->check($request->get('recaptcha_token'));

        Mail::to(config('auth.two_factor_email'))->send(new FeedbackRequest($request->all()));
    }
}
