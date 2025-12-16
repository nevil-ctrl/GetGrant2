<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DevCsp
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (app()->environment('local')) {
            $csp = "default-src 'self'; script-src 'self' 'unsafe-eval' http://localhost:5173; connect-src 'self' ws://localhost:5173 http://localhost:5173; style-src 'self' 'unsafe-inline' http://localhost:5173";
            $response->headers->set('Content-Security-Policy', $csp);
        }

        return $response;
    }
}
