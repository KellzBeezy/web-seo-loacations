<?php

namespace App\Observers;

use App\Models\AppTenant;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class TenantObserver
{
    /**
     * Handle the Tenant "created" event.
     */

    public function created(AppTenant $tenant): void
    {
        Activity::create([
            'log_name' => 'tenant_lifecycle',
            'description' => "New tenant \"{$tenant->name}\" was provisioned successfully.",
            'level' => 'info',
            'user_id' => Auth::id(),
            'tenant_id' => $tenant->id,
        ]);
    }

    public function updated(AppTenant $tenant): void
    {
        // Only log if the status actually changed
        if ($tenant->isDirty('is_active')) {
            $status = $tenant->is_active ? 'Activated' : 'Deactivated';
            Activity::create([
                'log_name' => 'tenant_lifecycle',
                'description' => "Tenant \"{$tenant->name}\" was {$status}.",
                'level' => $tenant->is_active ? 'info' : 'warning',
                'user_id' => Auth::id(),
                'tenant_id' => $tenant->id,
            ]);
        }
    }

    public function deleted(AppTenant $tenant): void
    {
        Activity::create([
            'log_name' => 'tenant_lifecycle',
            'description' => "Tenant \"{$tenant->name}\" was removed from the system.",
            'level' => 'error',
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Handle the Tenant "restored" event.
     */
    public function restored(AppTenant $tenant): void
    {
        //
    }

    /**
     * Handle the Tenant "force deleted" event.
     */
    public function forceDeleted(AppTenant $tenant): void
    {
        //
    }
}
