<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        $task = $this->route('task');

        return auth()->check() && $task && auth()->user()->can('update', $task);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,done',
            'subtasks.*.name' => 'nullable|string|max:255',
            'subtasks.*.status' => 'nullable|in:pending,done',
            'subtasks.*.description' => 'nullable|string',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You are not authorized to update this task.');
    }
}
