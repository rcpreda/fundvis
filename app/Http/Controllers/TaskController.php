<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::whereNull('taskable_id')
            ->with('subtasks')
            ->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        foreach ($validated['subtasks'] ?? [] as $subtaskData) {
            if (!empty($subtaskData['name'])) {
                $task->subtasks()->create([
                    'name' => $subtaskData['name'],
                    'status' => $subtaskData['status'] ?? 'pending',
                    'description' => $subtaskData['description'] ?? null,
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $task->load('subtasks');
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        $task->subtasks()->delete();

        foreach ($validated['subtasks'] ?? [] as $subtaskData) {
            if (!empty($subtaskData['name'])) {
                $task->subtasks()->create([
                    'name' => $subtaskData['name'],
                    'status' => $subtaskData['status'] ?? 'pending',
                    'description' => $subtaskData['description'] ?? null,
                ]);
            }
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted (soft).');
    }
}
