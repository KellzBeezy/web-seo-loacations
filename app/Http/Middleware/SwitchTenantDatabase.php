<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TenantDatabaseService;

class SwitchTenantDatabase
{
    public function __construct(protected TenantDatabaseService $tenantService)
    {
    }

    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();

        $this->tenantService->connectByDomain($domain);

        return $next($request);
    }
}