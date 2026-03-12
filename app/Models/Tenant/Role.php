<?php

namespace App\Models\Tenant;

use App\Models\Tenant\User;

class Role extends TenantModel
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Permissions attached to this role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Users assigned to this role
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if role has a specific permission
     */
    public function hasPermission($permissionSlug)
    {
        return $this->permissions()
            ->where('slug', $permissionSlug)
            ->exists();
    }
}