<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Tenant 1
        DB::connection('dynamic')->table('roles')->insert([
            'tenant_id' => 1,
            'name' => 'Admin',
            'slug' => 'admin',
        ]);

        DB::connection('dynamic')->table('roles')->insert([
            'tenant_id' => 1,
            'name' => 'Manager',
            'slug' => 'manager',
        ]);

        // Tenant 2
        DB::connection('dynamic')->table('roles')->insert([
            'tenant_id' => 2,
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
    }
}
