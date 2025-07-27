<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Task;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('create', Task::class);
    }

    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_fr' => 'nullable|string|max:255',
            'name_ge' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,done',
            'subtasks.*.name' => 'nullable|string|max:255',
            'subtasks.*.status' => 'nullable|in:pending,done',
            'subtasks.*.description' => 'nullable|string',
        ];
    }

    protected function failedAuthorization()
    {
        throw new AuthorizationException('You are not authorized to create tasks.');
    }
}
