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
            'audio' => fn ($q) => $q->select(['id', 'price', 'fragment_id']),
            'video' => fn ($q) => $q->select(['id', 'price', 'fragment_id']),
        ]);

        return view('home', compact('fragments'));
    }
}
