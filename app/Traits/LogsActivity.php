<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Helper to log events back to the Central DB
     */
    public function logToCentral(string $message, string $level = 'info', array $extra = []): void
    {
        Activity::create([
            'log_name' => 'tenant_event',
            'description' => $message,
            'level' => $level,
            'user_id' => Auth::id(), // ID of the user inside the tenant app
            'tenant_id' => config('tenant.id'), // Set by Middleware
            'properties' => array_merge([
                'ip' => request()->ip(),
                'url' => request()->fullUrl(),
            ], $extra),
        ]);
    }
}