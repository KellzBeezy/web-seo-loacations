<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $tenant = app('currentTenant');

        $subscription = $tenant->subscription()
            ->where('active', true)
            ->whereDate('ends_at', '>=', now())
            ->first();

        if (!$subscription) {
            return response("Subscription expired", 403);
        }

        return $next($request);
    }
}
