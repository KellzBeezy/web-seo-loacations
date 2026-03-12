<?php

namespace App\Models\Tenant;

use App\Models\Tenant\User;

use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permission');
    }
}
