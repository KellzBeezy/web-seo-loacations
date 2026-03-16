<?php
namespace App\Models\Tenant;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{

    use LogsActivity;
    protected $connection = 'dynamic';

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password', 'tenant_id'];

    protected $hidden = ['password'];


    public function tenant()
    {
        // Explicitly point to the central connection and the Tenant model
        return $this->belongsTo(\App\Models\AppTenant::class, 'tenant_id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roleSlug)
    {
        return $this->roles->contains('slug', $roleSlug);
    }

    public function hasPermission($permissionSlug)
    {
        // flatMap merges all permissions from all roles into one collection
        return $this->roles->flatMap->permissions->contains('slug', $permissionSlug);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // 3. Now this model has the logToCentral() method!
            $user->logToCentral("New User '{$user->name} ({$user->email})' was created by user " . Auth::user()->name . " (" . Auth::user()->email . ") in tenant name " . config('tenant.name') . "(" . config('tenant.domain') . ").");
        });

        static::updated(function ($user) {
            $user->logToCentral("User '{$user->name} ({$user->email})' was updated by user " . Auth::user()->name . " (" . Auth::user()->email . ") in tenant name " . config('tenant.name') . "(" . config('tenant.domain') . ").");
        });

        static::deleted(function ($user) {
            $user->logToCentral("User '{$user->name} ({$user->email})' was deleted by user " . Auth::user()->name . " (" . Auth::user()->email . ") in tenant name " . config('tenant.name') . "(" . config('tenant.domain') . ").");
        });
    }
}