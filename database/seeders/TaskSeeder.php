<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the test user
        $user = User::where('email', 'test@example.com')->first();
        
        if ($user) {
            // Create sample tasks for the test user
            $tasks = [
                [
                    'title' => 'Complete Laravel Project Setup',
                    'description' => 'Set up the initial Laravel project structure and configure the environment.',
                    'status' => 'completed',
                    'due_date' => Carbon::now()->subDays(5),
                    'user_id' => $user->id,
                ],
                [
                    'title' => 'Implement User Authentication',
                    'description' => 'Add user registration, login, and authentication features using Laravel Breeze.',
                    'status' => 'completed',
                    'due_date' => Carbon::now()->subDays(3),
                    'user_id' => $user->id,
                ],
                [
                    'title' => 'Create Task Management Features',
                    'description' => 'Implement CRUD operations for tasks including controllers, models, and views.',
                    'status' => 'in-progress',
                    'due_date' => Carbon::now()->addDays(2),
                    'user_id' => $user->id,
                ],
                [
                    'title' => 'Add Task Filtering and Sorting',
                    'description' => 'Implement features to filter tasks by status and sort by due date.',
                    'status' => 'pending',
                    'due_date' => Carbon::now()->addDays(7),
                    'user_id' => $user->id,
                ],
                [
                    'title' => 'Write Unit Tests',
                    'description' => 'Create comprehensive unit tests for all task management features.',
                    'status' => 'pending',
                    'due_date' => Carbon::now()->addDays(10),
                    'user_id' => $user->id,
                ],
            ];
            
            foreach ($tasks as $task) {
                Task::create($task);
            }
        }
    }
}
