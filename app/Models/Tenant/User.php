<?php
namespace App\Models\Tenant;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
}