<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentsIndexRequest;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function page()
    {
        return view('admin.payments');
    }

    public function index(PaymentsIndexRequest $request)
    {
        [$start, $end] = $request->getPeriodDates();

        $actions = Payment::query()
            ->where('created_at', '>=', $start->startOfDay())
            ->where('created_at', '<=', $end->endOfDay())
            ->orderByDesc('created_at')
            ->with('user')
            ->simplePaginate(25);

        return response()->json($actions);
    }
}
