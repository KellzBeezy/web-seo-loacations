<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AppTenant;
use App\Services\TenantDatabaseService;
use Illuminate\Support\Facades\Artisan;

class MigrateTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:migrate-tenants';

    protected $signature = 'tenants:migrate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for all tenants';

    /**
     * Execute the console command.
     */


    public function handle()
    {
        $tenants = AppTenant::all();
        $tenantService = app(TenantDatabaseService::class);

        foreach ($tenants as $tenant) {

            $this->info("Migrating {$tenant->name}");

            $tenantService->connectByDomain($tenant->domain);

            Artisan::call('migrate', [
                '--database' => 'dynamic',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);

            $this->info(Artisan::output());
        }
    }
}

