<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 4 random users and assign 3 tasks each
        User::factory()->count(4)->create()->each(function ($user) {
            Task::factory()->count(3)->create([
                'user_id' => $user->id,
            ]);
        });

        // Create a known demo user
        $demoUser = User::create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign 3 tasks to the demo user
        Task::factory()->count(10)->create([
            'user_id' => $demoUser->id,
        ]);
    }
}
