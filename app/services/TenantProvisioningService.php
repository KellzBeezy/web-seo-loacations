<?php
namespace App\Services;

use App\Models\AppTenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class TenantProvisioningService
{
    public function createTenant(array $data)
    {
        $dbName = 'tenant_' . Str::random(8);

        // 1️⃣ Create database
        DB::statement("CREATE DATABASE `$dbName`");

        // 2️⃣ Store tenant in central DB
        $tenant = AppTenant::create([
            'name' => $data['name'],
            'domain' => $data['domain'],
            'db_host' => env('DB_HOST'),
            'db_port' => env('DB_PORT'),
            'db_name' => $dbName,
            'db_username' => env('DB_USERNAME'),
            'db_password' => encrypt(env('DB_PASSWORD')),
        ]);

        // 3️⃣ Run tenant migrations
        $this->runMigrations($tenant);

        return $tenant;
    }

    protected function runMigrations($tenant)
    {
        Config::set('database.connections.dynamic.database', $tenant->db_name);
        Config::set('database.connections.dynamic.username', env('DB_USERNAME'));
        Config::set('database.connections.dynamic.password', env('DB_PASSWORD'));

        DB::purge('dynamic');
        DB::reconnect('dynamic');

        \Artisan::call('migrate', [
            '--database' => 'dynamic',
            '--path' => 'database/migrations/tenant',
            '--force' => true
        ]);
    }
}