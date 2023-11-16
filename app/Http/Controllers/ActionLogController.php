<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionsIndexRequest;
use App\Models\ActionLog;

class ActionLogController extends Controller
{
    public function page()
    {
        return view('admin.action-logs');
    }

    public function index(ActionsIndexRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $actions = ActionLog::query()
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->orderByDesc('created_at')
            ->with('user')
            ->simplePaginate(100);

        return response()->json($actions);
    }
}
