<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectAdminActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! admin()->check()) {
            return $next($request);
        }

        if (admin()->user()->isAdmin()) {
            return $next($request);
        }

        admin()->user()->update(['last_activity' => now()]);

        return $next($request);
    }
}
