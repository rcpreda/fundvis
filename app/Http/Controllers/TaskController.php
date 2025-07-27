<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::whereNull('taskable_id')
            ->with('subtasks')
            ->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $locales = ['en', 'fr', 'ge'];
        return view('tasks.create', compact('locales'));
    }

    public function store(CreateTaskRequest $request)
    {
        $validated = $request->validated();
        $locales = ['en', 'fr', 'ge'];

        $task = new Task();
        $task->status = $validated['status'];
        $task->user_id = auth()->id();

        foreach ($locales as $locale) {
            $task->setTranslation('name', $locale, $validated['name_' . $locale] ?? null);
            $task->setTranslation('description', $locale, $validated['description_' . $locale] ?? null);
        }

        $task->save();

        foreach ($validated['subtasks'] ?? [] as $subtaskData) {
            $subtask = $task->subtasks()->make([
                'status' => $subtaskData['status'] ?? 'pending',
            ]);

            foreach ($locales as $locale) {
                $subtask->setTranslation('name', $locale, $subtaskData['name_' . $locale] ?? null);
            }

            $subtask->save();
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Task $task)
    {
        $task->load('subtasks');
        $locales = ['en', 'fr', 'ge'];
        return view('tasks.edit', compact('task', 'locales'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $locales = ['en', 'fr', 'ge'];

        $task->status = $validated['status'];

        foreach ($locales as $locale) {
            $task->setTranslation('name', $locale, $validated['name_' . $locale] ?? null);
            $task->setTranslation('description', $locale, $validated['description_' . $locale] ?? null);
        }

        $task->save();

        $task->subtasks()->delete();

        foreach ($validated['subtasks'] ?? [] as $subtaskData) {
            $subtask = $task->subtasks()->make([
                'status' => $subtaskData['status'] ?? 'pending',
            ]);

            foreach ($locales as $locale) {
                $subtask->setTranslation('name', $locale, $subtaskData['name_' . $locale] ?? null);
            }

            $subtask->save();
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted (soft).');
    }
}
