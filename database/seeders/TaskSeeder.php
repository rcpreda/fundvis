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
        ]);

        $task->subtasks()->createMany([
            ['name' => 'Subtask 1', 'description' => 'Sutask 1', 'status' => 'pending'],
            ['name' => 'Subtask 2', 'description' => 'Subtask 1', 'status' => 'done'],
        ]);
    }
}
