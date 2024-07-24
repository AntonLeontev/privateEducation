<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function __invoke(Request $request)
    {
        Mail::to(config('auth.two_factor_email'))->send(new FeedbackRequest($request->all()));
    }
}
