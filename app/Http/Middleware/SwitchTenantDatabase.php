<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TenantDatabaseService;
use Illuminate\Support\Facades\DB;

class SwitchTenantDatabase
{
    public function __construct(protected TenantDatabaseService $tenantService)
    {
    }

    public function handle($request, Closure $next)
    {
        $domain = $request->getHost();

        $this->tenantService->connectByDomain($domain);

        // dd(DB::connection()->getDatabaseName());

        return $next($request);
    }
}