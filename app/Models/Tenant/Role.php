<?php

namespace App\Models\Tenant;

class Role extends TenantModel
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'permission_role',
            'role_id',
            'permission_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'role_user',
            'role_id',
            'user_id'
        );
    }

    public function hasPermission($slug)
    {
        return $this->permissions()
            ->where('slug', $slug)
            ->exists();
    }
}