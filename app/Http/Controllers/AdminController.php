<?php

namespace App\Http\Controllers;

use App\MoonShine\Resources\UserResource;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function custom()
	{
		return view('admin.custom');
	}

    public function users()
	{
		return view('admin.users', ['resource' => (new UserResource())]);
	}

	public function dashboard()
	{
		return view('admin.dashboard');
	}
}
