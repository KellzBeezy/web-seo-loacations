<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {


        // If user isn't logged in or lacks permission, trigger your custom 403 page
        if (!$request->user() || !$request->user()->hasPermission($permission)) {
            abort(403, "Access Denied: You need the '{$permission}' permission.");
        }

        return $next($request);
    }
}