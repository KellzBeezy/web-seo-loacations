<?php

namespace App\Models\Tenant;

class Permission extends TenantModel
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permission',
            'permission_id',
            'role_id'
        );
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_permission',
            'permission_id',
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    public static function findBySlug(string $slug)
    {
        return static::where('slug', $slug)->first();
    }

}
