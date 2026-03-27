<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departments = [
            'IT Support',
            'Maintenance',
            'Hostel Office',
            'Security',
            'Housekeeping',
        ];

        foreach ($departments as $department) {
            DB::table('departments')->updateOrInsert(
                ['name' => $department],
                [
                    'description' => null,
                    'is_active' => true,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
