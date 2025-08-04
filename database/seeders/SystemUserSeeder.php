<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SystemUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('system_users')->insert([
            'name' => 'Internal Service',
            'email' => 'internal@yourcompany.com',
            'password' => Hash::make('supersecurepassword'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
