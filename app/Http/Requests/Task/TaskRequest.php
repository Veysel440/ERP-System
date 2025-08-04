<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'  => 'required|exists:projects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:open,in_progress,completed,cancelled',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}
