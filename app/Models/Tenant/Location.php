<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\ChangeFrequency;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class Location extends TenantModel
{
    use HasFactory;
    use LogsActivity;

    /**
     * No tenant_id needed here as per your architecture.
     * The 'dynamic' connection handles the data isolation.
     */
    protected $fillable = [
        'city',
        'suburb',
    ];

    protected $casts = [
        'change_frequency' => ChangeFrequency::class,
    ];

    protected static function booted()
    {
        static::created(function ($location) {
            $user = Auth::user() ? Auth::user()->name . " (" . Auth::user()->email . ")" : "SYSTEM";
            $tenantInfo = config('tenant.name') . " (" . config('tenant.domain') . ")";

            $location->logToCentral("New Location '{$location->city} {$location->suburb}' was created by {$user} in tenant {$tenantInfo}.", 'success');
        });

        static::updated(function ($location) {
            $user = Auth::user() ? Auth::user()->name . " (" . Auth::user()->email . ")" : "SYSTEM";
            $tenantInfo = config('tenant.name') . " (" . config('tenant.domain') . ")";

            $location->logToCentral("Location '{$location->city} {$location->suburb}' was updated by {$user} in tenant {$tenantInfo}.", 'warning', [
                'changes' => $location->getChanges(),
                'original' => $location->getOriginal()
            ]);
        });

        static::deleted(function ($location) {
            $user = Auth::user() ? Auth::user()->name . " (" . Auth::user()->email . ")" : "SYSTEM";
            $tenantInfo = config('tenant.name') . " (" . config('tenant.domain') . ")";

            $location->logToCentral("Location '{$location->city} {$location->suburb}' was deleted by {$user} in tenant {$tenantInfo}.", 'error');
        });
    }
}