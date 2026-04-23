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
        // Create a test user
        $user = User::firstOrCreate(
            ['email' => 'utkarsh.it.20062@recb.ac.in'],
            [
                'name' => 'Utkarsh',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Set the user ID for other seeders to use
        $this->callWith(GoalSeeder::class, ['userId' => $user->id]);
        $this->callWith(TaskSeeder::class, ['userId' => $user->id]);
        $this->call(QuoteSeeder::class);
        $this->call(DiarySeeder::class);
        $this->call(UserStatsSeeder::class);
    }
}
