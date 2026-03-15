<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\AppTenant;
use App\Services\TenantDatabaseService;

class TenantsRollback extends Command
{
    protected $signature = 'tenants:migrate:rollback';
    protected $description = 'Rollback last migration batch for all tenants';

    public function handle()
    {
        $tenants = AppTenant::all();
        $tenantService = app(TenantDatabaseService::class);

        foreach ($tenants as $tenant) {

            $this->info("Rolling back tenant: {$tenant->name}");

            $tenantService->connectByDomain($tenant->domain);

            \Artisan::call('migrate:rollback', [
                '--database' => 'dynamic',
                '--path' => 'database/migrations/tenant',
                '--force' => true
            ]);

            $this->info("Rolled back tenant: {$tenant->name}");
        }

        $this->info('All tenant migrations rolled back successfully.');
    }
}