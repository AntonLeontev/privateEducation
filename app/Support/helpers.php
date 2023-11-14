<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('admin')) {
    function admin()
    {
        return Auth::guard('admin');
    }
}
