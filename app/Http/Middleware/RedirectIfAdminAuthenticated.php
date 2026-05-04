<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! admin()->check()) {
            return $next($request);
        }

        if (admin()->user()->isAdmin()) {
            return to_route('admin.fragments');
        }

        if (admin()->user()->isSeo()) {
            return to_route('admin.seo.index');
        }

        return $next($request);
    }
}
