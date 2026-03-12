<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AppTenant;
use Illuminate\Support\Facades\Config;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Identify Tenant (Example: by subdomain)
        $host = $request->getHost(); // e.g., 'tenant1.myapp.com'
        $tenant = AppTenant::where('domain', $host)->first();

        if (!$tenant) {
            // Redirect to main landing page if tenant doesn't exist
            return redirect('https://your-main-site.com');
        }

        // 2. Set Tenant Context 
        // If you are using a single database with a 'tenant_id' column:
        session(['tenant_id' => $tenant->id]);

        // 3. (Optional) Switch Database Connection if using multi-db
        // Config::set('database.connections.tenant.database', $tenant->db_name);
        // DB::purge('tenant');

        return $next($request);
    }
}