<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator',
            ],
            [
                'name' => 'manager',
                'description' => 'Manager',
            ],
            [
                'name' => 'employee',
                'description' => 'Employee',
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name'        => $role['name'],
                'description' => $role['description'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
