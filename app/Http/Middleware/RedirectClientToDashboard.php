<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectClientToDashboard
{
    /**
     * Block client users from accessing the admin area.
     * Redirect them to their portal dashboard instead.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->hasRole('Cliente')) {
            // Allow the impersonate stop action through (POST to /app/impersonate/stop)
            if ($request->is('app/impersonate/stop')) {
                return $next($request);
            }

            // If they try to access any /app/* route, redirect to portal
            if ($request->is('app/*') || $request->is('app')) {
                return redirect()->route('portal.dashboard');
            }
        }

        return $next($request);
    }
}
