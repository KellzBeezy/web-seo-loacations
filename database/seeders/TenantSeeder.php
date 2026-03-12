<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\AppTenant::create([
            'name' => 'Client One',
            'domain' => 'client1.localhost',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_name' => 'client1_db',
            'db_username' => 'root',
            'db_password' => 'password',
            // 'db_password' => encrypt('password'),
        ]);

        \App\Models\AppTenant::create([
            'name' => 'Client Two',
            'domain' => 'client2.localhost',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_name' => 'client2_db',
            'db_username' => 'root',
            'db_password' => 'password',
            // 'db_password' => encrypt('password'),
        ]);
    }
}
