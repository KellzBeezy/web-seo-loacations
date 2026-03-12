<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'Create Customer', 'slug' => 'create_customer'],
            ['name' => 'Update Customer', 'slug' => 'update_customer'],
            ['name' => 'Delete Customer', 'slug' => 'delete_customer'],
            ['name' => 'View Customer', 'slug' => 'view_customer'],
        ];

        foreach ($permissions as $permission) {
            \App\Models\Tenant\Permission::create($permission);
        }
    }
}
