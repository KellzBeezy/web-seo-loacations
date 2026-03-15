<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant\Role;
use App\Models\Tenant\Permission;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\Hash;

class TenantRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Create Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [
            ['name' => 'Create Location', 'slug' => 'create_location'],
            ['name' => 'View Location', 'slug' => 'view_location'],
            ['name' => 'View Users', 'slug' => 'view-users'],
            ['name' => 'Update Location', 'slug' => 'update_location'],
            ['name' => 'Delete Location', 'slug' => 'delete_location'],
            ['name' => 'View Locations', 'slug' => 'view_locations'],
            ['name' => 'Add Location', 'slug' => 'add_location'],
        ];

        foreach ($permissions as $perm) {
            Permission::create($perm);
        }

        /*
        |--------------------------------------------------------------------------
        | Create Roles
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin'
        ]);

        $viewerRole = Role::create([
            'name' => 'Viewer',
            'slug' => 'viewer'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        // Admin gets ALL permissions
        $adminRole->permissions()->attach(Permission::all());

        // Viewer gets only view
        $viewerRole->permissions()->attach(
            Permission::where('slug', 'view_location')->first()
        );

        /*
        |--------------------------------------------------------------------------
        | Create First Tenant User (Admin)
        |--------------------------------------------------------------------------
        */

        // $user = User::create([
        //     'name' => 'Tenant Admin',
        //     'email' => 'admin@tenant.com',
        //     'password' => Hash::make('password')
        // ]);

        // /*
        // |--------------------------------------------------------------------------
        // | Assign Admin Role
        // |--------------------------------------------------------------------------
        // */

        // $user->roles()->attach($adminRole->id);
    }
}