<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function subscriptions()
	{
		return view('admin.subscriptions');
	}

	public function subscriptionsSearch(Request $request): JsonResponse
	{
		$users = User::query()
			->with('activeSubscriptions')
			->where('email', 'LIKE', "%{$request->get('search')}%")
			->orWhere('name', 'LIKE', "%{$request->get('search')}%")
			->when(is_numeric($request->get('search')), function(Builder $query) {
				return $query->orWhere('id', (int) request()->get('search'));
			})
			->take(25)
			->get();

		return response()->json($users);
	}
}
