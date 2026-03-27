<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categoriesByDepartment = [
            'IT Support' => [
                ['name' => 'Internet/WiFi', 'sla_hours' => 24],
                ['name' => 'Computer Lab', 'sla_hours' => 48],
            ],
            'Maintenance' => [
                ['name' => 'Electrical', 'sla_hours' => 24],
                ['name' => 'Plumbing', 'sla_hours' => 48],
                ['name' => 'Furniture', 'sla_hours' => 72],
            ],
            'Hostel Office' => [
                ['name' => 'Hostel Issue', 'sla_hours' => 48],
            ],
            'Security' => [
                ['name' => 'Security Concern', 'sla_hours' => 12],
            ],
            'Housekeeping' => [
                ['name' => 'Cleaning Request', 'sla_hours' => 12],
            ],
        ];

        foreach ($categoriesByDepartment as $departmentName => $categories) {
            $departmentId = DB::table('departments')
                ->where('name', $departmentName)
                ->value('id');

            if (! $departmentId) {
                continue;
            }

            foreach ($categories as $category) {
                DB::table('categories')->updateOrInsert(
                    [
                        'name' => $category['name'],
                        'department_id' => $departmentId,
                    ],
                    [
                        'sla_hours' => $category['sla_hours'],
                        'description' => null,
                        'is_active' => true,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        }
    }
}
