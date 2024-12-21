<?php

namespace App\Http\Controllers;

use App\Models\Fragment;

class HomeController extends Controller
{
    public function __invoke()
    {
        $fragments = Fragment::all(['id', 'title_'.loc(), 'is_active']);

        $fragments->load([
            'presentation' => fn ($q) => $q->select(['id', 'text_'.loc(), 'fragment_id']),
            'audio' => fn ($q) => $q->select(['id', 'price', 'fragment_id'])->with('subscription'),
            'video' => fn ($q) => $q->select(['id', 'price', 'fragment_id'])->with('subscription'),
        ]);

        return response()->view('home', compact('fragments'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
