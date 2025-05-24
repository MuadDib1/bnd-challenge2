<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 users, each with 10 tasks
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                Task::factory()->count(10)->for($user)->create();
            });
    }
}
