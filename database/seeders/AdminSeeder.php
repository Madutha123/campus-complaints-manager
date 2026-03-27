<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@campus.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}
