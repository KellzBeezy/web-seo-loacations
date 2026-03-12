<?php
namespace App\Services;

use App\Models\AppTenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\Tenant\User;

class TenantProvisioningService
{
    // public function createTenant(array $data)
    // {
    //     $dbName = $data['db_name'] ?? 'tenant_' . Str::random(8);

    //     // 1️⃣ Create database
    //     DB::statement("CREATE DATABASE `$dbName`");

    //     // 2️⃣ Store tenant in central DB
    //     $tenant = AppTenant::create([
    //         'name' => $data['name'],
    //         'domain' => $data['domain'],
    //         'db_host' => env('DB_HOST'),
    //         'db_port' => env('DB_PORT'),
    //         'db_name' => $dbName,
    //         'db_username' => env('DB_USERNAME'),
    //         'db_password' => encrypt(env('DB_PASSWORD')),
    //     ]);

    //     // 3️⃣ Run tenant migrations
    //     $this->runMigrations($tenant);

    //     return $tenant;
    // }

    public function createTenant(array $data)
    {
        $dbName = $data['db_name'] ?? 'tenant_' . Str::random(8);
        $owner = null;
        $tenant = null;

        // // --- PHASE 1: Central DB (No Transaction) ---
        // $owner = User::create([
        //     'name' => $data['owner_name'],
        //     'email' => $data['owner_email'],
        //     'password' => bcrypt($data['owner_password']),
        // ]);

        $tenant = AppTenant::create([
            'name' => $data['name'],
            'domain' => $data['domain'],
            'db_name' => $dbName,
            'db_host' => env('DB_HOST'),
            'db_username' => env('DB_USERNAME'),
            'db_password' => encrypt(env('DB_PASSWORD')),
        ]);

        // --- PHASE 2: Physical DB & Migrations ---
        try {
            // CREATE DATABASE triggers an implicit commit in MySQL. 
            // This is why a transaction would fail here.
            DB::statement("CREATE DATABASE `$dbName`");

            $this->runMigrations($tenant);

            $owner = User::create([
                'name' => $data['owner_name'],
                'tenant_id' => $tenant->id, // Assuming you have a tenant_id field in users table
                'email' => $data['owner_email'],
                'password' => bcrypt($data['owner_password']),
            ]);

            return $tenant;

        } catch (\Exception $e) {
            // --- PHASE 3: Manual Cleanup on Failure ---
            // Since we aren't in a transaction, we delete the records manually
            if ($tenant)
                $tenant->delete();
            if ($owner)
                $owner->delete();

            dd($e->getMessage());
            // Drop the half-baked database if it exists
            DB::statement("DROP DATABASE IF EXISTS `$dbName`");

            throw new \Exception("Provisioning Failed: " . $e->getMessage());
        }
    }

    protected function runMigrations($tenant)
    {
        try {
            Config::set('database.connections.dynamic.database', $tenant->db_name);
            Config::set('database.connections.dynamic.username', env('DB_USERNAME'));
            Config::set('database.connections.dynamic.password', env('DB_PASSWORD'));

            DB::purge('dynamic');
            DB::reconnect('dynamic');

            // Capture the output of the migration
            $exitCode = \Artisan::call('migrate', [
                '--database' => 'dynamic',
                '--path' => 'database/migrations/tenant',
                '--force' => true
            ]);

            // If exitCode is not 0, it failed. 
            if ($exitCode !== 0) {
                throw new \Exception("Migration failed with exit code: $exitCode. Check logs for details.");
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}