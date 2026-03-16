<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AppTenant; // Your Central DB Model (app_tenants)
use Illuminate\Support\Facades\Config;

class IdentifyTenant
{
    public function handle($request, Closure $next)
    {
        // 1. Identify tenant by domain (e.g., client1.localhost)
        $host = $request->getHost();
        $tenant = AppTenant::where('domain', $host)->first();

        if ($tenant) {
            // 2. Store the ID in config so our Trait can find it
            Config::set('tenant.id', $tenant->id);
            Config::set('tenant.name', $tenant->name);
            Config::set('tenant.domain', $tenant->domain);

            // 3. (Optional) Switch database connection here if needed
        }

        return $next($request);
    }
}