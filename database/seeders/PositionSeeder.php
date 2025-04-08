<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            'Junior Software Developer',
            'Senior Software Developer',
            'Software Developer',
            'Software Architect',
            'Frontend Developer',
            'Backend Developer',
            'Full Stack Developer',
            'Mobile App Developer (Android)',
            'Mobile App Developer (ios)',
            'DevOps Engineer',
            'QA Engineer / Test Engineer',
            'Automation Test Engineer',
            'UI/UX Designer',
            'Product Designer',
        ];

        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'name' => $position,
            ]);
        }
    }
}
