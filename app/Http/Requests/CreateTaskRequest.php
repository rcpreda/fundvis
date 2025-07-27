<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
}
