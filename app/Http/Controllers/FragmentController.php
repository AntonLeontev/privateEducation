<?php

namespace App\Http\Controllers;

use App\Http\Requests\FragmentUpdateRequest;
use App\Models\Fragment;

class FragmentController extends Controller
{
    public function update(Fragment $fragment, FragmentUpdateRequest $request)
    {
        $fragment->update($request->validated());
    }
}
