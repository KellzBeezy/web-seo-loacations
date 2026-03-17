<?php

namespace App\Services;

use App\Models\AppTenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantDatabaseService
{
    public function connectByDomain($domain)
    {
        $tenant = AppTenant::where('domain', $domain)->firstOrFail();

        Config::set('database.connections.dynamic.host', $tenant->db_host);
        Config::set('database.connections.dynamic.port', env('DB_PORT') ?? 3306);
        Config::set('database.connections.dynamic.database', $tenant->db_name);
        Config::set('database.connections.dynamic.username', $tenant->db_username);
        Config::set('database.connections.dynamic.password', decrypt($tenant->db_password));

        // dd(Config::get('database.connections.dynamic'));

        DB::purge('dynamic');
        DB::reconnect('dynamic');

        DB::setDefaultConnection('dynamic');
    }
}