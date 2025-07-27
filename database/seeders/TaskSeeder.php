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
            'name' => 'Main Task',
            'description' => 'Parent task',
            'status' => 'pending',
            'user_id' => 1,
        ]);

        $task->subtasks()->createMany([
            ['name' => 'Subtask 1', 'description' => 'Sutask 1', 'status' => 'pending'],
            ['name' => 'Subtask 2', 'description' => 'Subtask 1', 'status' => 'done'],
        ]);

        $task1 = Task::create([
            'name' => 'Sec Task',
            'description' => 'Parent task',
            'status' => 'pending',
            'user_id' => 2,
        ]);

        $task1->subtasks()->createMany([
            ['name' => 'Test 1', 'description' => 'Sutask 1', 'status' => 'pending'],
        ]);
    }
}
