<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            PositionSeeder::class,
        ]);

        User::factory()->create([
            'name'      => 'Test User',
            'role_id'   => '1',
            'email'     => 'jas123@gmail.com',
            'password' => Hash::make('Jas@1234'),
        ]);
    }
}
