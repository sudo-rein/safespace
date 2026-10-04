<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CounselorSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'counselor@ecis.edu.ph'],
            [
                'name' => 'Guidance Counselor',
                'password' => 'GuidanceEcis2026!',
                'role' => 'counselor',
                'is_active' => true,
                'registered_at' => now(),
            ]
        );
    }
}