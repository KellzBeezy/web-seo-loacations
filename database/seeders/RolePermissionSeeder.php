<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = \App\Models\Tenant\Role::where('slug', 'admin')
            ->where('tenant_id', 1)
            ->first();

        $permissions = \App\Models\Tenant\Permission::pluck('id');

        foreach ($permissions as $permissionId) {
            DB::table('role_permission')->insert([
                'role_id' => $adminRole->id,
                'permission_id' => $permissionId,
            ]);
        }
    }
}