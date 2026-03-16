<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Tenant\User::create([
            'tenant_id' => 1,
            'name' => 'Tenant1 Admin',
            'email' => 'admin@client1.com',
            'password' => bcrypt('password'),
        ]);
    }
}
