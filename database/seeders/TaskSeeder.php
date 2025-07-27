<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $task = Task::create([
            'name' => 'Test Task',
            'description' => 'This is a test task used for seeding the database.',
            'status' => 'pending',
        ]);

        $task->subtasks()->createMany([
            ['name' => 'First subtask', 'status' => 'pending'],
            ['name' => 'Second subtask', 'status' => 'done'],
        ]);
    }
}
