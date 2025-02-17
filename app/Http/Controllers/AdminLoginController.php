<?php

namespace App\Http\Controllers;

use App\Events\TwoFactorRequested;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\TwoFactorCheckCodeRequest;
use App\Models\Admin;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function create()
    {
        return view('admin.login');
    }

    public function store(AdminLoginRequest $request)
    {
        abort_unless(Auth::guard('admin')->validate($request->validated()), Response::HTTP_UNPROCESSABLE_ENTITY);

        $admin = Admin::where(['email' => $request->get('email')])->first();

        $admin->update([
            'two_factor_code' => str()->random(10),
            'two_factor_code_expires' => now()->addSeconds(config('auth.two_factor_code_timeout')),
            'two_factor_code_is_used' => false,
        ]);

        event(new TwoFactorRequested($admin));
    }

    public function twoFactorCheckCode(TwoFactorCheckCodeRequest $request)
    {
        $admin = Admin::where(['email' => $request->get('email')])->first();

        if (
            $admin->two_factor_code !== $request->get('code') ||
            $admin->two_factor_code_expires < now() ||
            $admin->two_factor_code_is_used
        ) {
            throw ValidationException::withMessages(['code' => 'Неверный код']);
        }

        Auth::guard('admin')->login($admin, true);
        $request->session()->regenerate();
        $admin->update(['two_factor_code_is_used' => true]);

        $redirect = match (true) {
            $admin->isAdmin() => route('admin.fragments'),
            $admin->isSeo() => route('admin.seo.index'),
        };

        return response()->json(['redirect' => $redirect]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return to_route('home');
    }
}
