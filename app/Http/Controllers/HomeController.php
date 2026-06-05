<?php

namespace App\Http\Controllers;

use App\Models\Fragment;
use App\Services\PlaytimeParser;

class HomeController extends Controller
{
    public function __invoke(PlaytimeParser $playtimeParser)
    {
        $fragments = Fragment::all(['id', 'title_'.loc(), 'is_active']);

        $fragments->load([
            'presentation' => fn ($q) => $q->select(['id', 'text_'.loc(), 'fragment_id']),
            'audio' => fn ($q) => $q->select(['id', 'price', 'fragment_id'])->with('subscription'),
            'video' => fn ($q) => $q->select(['id', 'price', 'fragment_id'])->with('subscription'),
        ]);

        $fragments->each(function (Fragment $fragment) use ($playtimeParser) {
            if ($fragment->presentation) {
                $fragment->presentation->setAttribute(
                    'duration_seconds',
                    $playtimeParser->durationForPresentation($fragment->presentation)
                );
            }
        });

        return response()->view('home', compact('fragments'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
