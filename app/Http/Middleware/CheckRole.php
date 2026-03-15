<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, string $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // This triggers your custom 403 error page we just created!
            abort(403, "You do not have the $role role required to perform this action.");
        }

        return $next($request);
    }
}
