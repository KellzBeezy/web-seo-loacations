<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $user = \App\Models\User::first();
        $role = \App\Models\Tenant\Role::where('tenant_id', 1)
            ->where('slug', 'admin')
            ->first();

        DB::table('user_role')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }
}
