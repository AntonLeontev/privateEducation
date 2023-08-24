<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Audio;
use App\MoonShine\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function custom()
	{
		$fragments = DB::table('subscriptions')
			->select([
				'subscribable_id',
				DB::raw('SUM(price) AS sum_price')
			])
			->where('created_at', '>=', now()->startOfDay())
			->where('created_at', '<=', now()->endOfDay())
			->groupBy('subscribable_id')
			->orderByDesc('sum_price')
			->take(4)
			->get()
			->map(function($el, int $key) {
				return [
					'id' => $el->subscribable_id,
					'sum' => $el->sum_price / 100,
					'position' => $key + 1,
				];
			});

		return view('admin.custom', compact('fragments'));
	}

    public function users()
	{
		return view('admin.users', ['resource' => (new UserResource())]);
	}

	public function dashboard()
	{
		return view('admin.dashboard');
	}

	public function salesMetrics(Request $request)
	{
		$sales = [];

		$model = match ($request->content) {
			'video' => Video::class,
			'audio' => Audio::class,
			default => null,
		};
		
		foreach (range(180, 0, -1) as $day) {
			$date = now()->subDays($day);

			$sum = DB::table('subscriptions')
				->where('created_at', '>=', $date->startOfDay())
				->where('created_at', '<=', now()->subDays($day)->endOfDay())
				->when(!empty($model), function(Builder $query) use ($model){
					return $query->where('subscribable_type', $model);
				})
				->sum('price');

			$ru = DB::table('subscriptions')
				->where('created_at', '>=', $date->startOfDay())
				->where('created_at', '<=', now()->subDays($day)->endOfDay())
				->where('lang', 'ru')
				->when(!empty($model), function(Builder $query) use ($model){
					return $query->where('subscribable_type', $model);
				})
				->sum('price');

			$en = DB::table('subscriptions')
				->where('created_at', '>=', $date->startOfDay())
				->where('created_at', '<=', now()->subDays($day)->endOfDay())
				->where('lang', 'en')
				->when(!empty($model), function(Builder $query) use ($model){
					return $query->where('subscribable_type', $model);
				})
				->sum('price');

			$sales[] = [
				'date' => $date->format('Y-m-d'), 
				'sum' => (int) $sum / 100,
				'ru' => (int) $ru / 100,
				'en' => (int) $en / 100,
			];
		}

		return response()->json($sales);
	}

	public function sales(Request $request)
	{
		[$start, $end] = $this->getPeriodDates();

		$model = $this->getModel();

		$en = DB::table('subscriptions')
			->where('created_at', '>=', $start->startOfDay())
			->where('created_at', '<=', $end->endOfDay())
			->where('lang', 'en')
			->when(!empty($model), function(Builder $query) use ($model){
				return $query->where('subscribable_type', $model);
			})
			->sum('price');

		$ru = DB::table('subscriptions')
			->where('created_at', '>=', $start->startOfDay())
			->where('created_at', '<=', $end->endOfDay())
			->where('lang', 'ru')
			->when(!empty($model), function(Builder $query) use ($model){
				return $query->where('subscribable_type', $model);
			})
			->sum('price');
		
		return response()->json(['ru' => $ru / 100, 'en' => $en / 100]);
	}

	public function popularFragments(Request $request)
	{
		[$start, $end] = $this->getPeriodDates();

		$model = $this->getModel();

		$fragments = DB::table('subscriptions')
			->select([
				'subscribable_id',
				DB::raw('SUM(price) AS sum_price')
			])
			->where('created_at', '>=', $start->startOfDay())
			->where('created_at', '<=', $end->endOfDay())
			->when(!empty($model), function(Builder $query) use ($model){
				return $query->where('subscribable_type', $model);
			})
			->groupBy('subscribable_id')
			->orderByDesc('sum_price')
			->take(4)
			->get()
			->map(function($el, int $key) {
				return [
					'id' => $el->subscribable_id,
					'sum' => $el->sum_price / 100,
					'position' => $key + 1,
				];
			});
		
		return response()->json($fragments);
	}

	private function getPeriodDates(): array
	{
		return match (request()->period) {
			'today' => [now(), now()],
			'yesterday' => [now()->subDay(), now()->subDay()],
			'week' => [now()->startOfWeek(), now()->endOfWeek()],
			'month' => [now()->startOfMonth(), now()->endOfMonth()],
			'quarter' => [now()->startOfQuarter(), now()->endOfQuarter()],
			'year' => [now()->startOfYear(), now()->endOfYear()],
			'custom' => [Carbon::parse(request()->get('start')), Carbon::parse(request()->get('end'))],
			default => [null, null],
		};
	}

	private function getModel()
	{
		return match (request()->content) {
			'video' => Video::class,
			'audio' => Audio::class,
			default => null,
		};
	}
}
