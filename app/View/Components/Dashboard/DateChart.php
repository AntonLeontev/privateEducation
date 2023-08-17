<?php

namespace App\View\Components\Dashboard;

use App\Models\Subscription;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class DateChart extends Component
{
	public $sales = [];

    public function __construct()
    {
		foreach (range(180, 0, -1) as $day) {
			$date = now()->subDays($day);

			$sum = DB::table('subscriptions')
				->where('created_at', '>=', $date->startOfDay())
				->where('created_at', '<=', now()->subDays($day)->endOfDay())
				->sum('price');

			$ru = DB::table('subscriptions')
				->where('created_at', '>=', $date->startOfDay())
				->where('created_at', '<=', now()->subDays($day)->endOfDay())
				->where('lang', 'ru')
				->sum('price');

			$en = DB::table('subscriptions')
				->where('created_at', '>=', $date->startOfDay())
				->where('created_at', '<=', now()->subDays($day)->endOfDay())
				->where('lang', 'en')
				->sum('price');

			$this->sales[] = [
				'date' => $date->format('Y-m-d'), 
				'sum' => (int) $sum / 100,
				'ru' => (int) $ru / 100,
				'en' => (int) $en / 100,
			];
		}

    }

    public function render(): View|Closure|string
    {
        return view('components.dashboard.date-chart');
    }
}
