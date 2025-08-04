<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'department_id' => 'required|exists:departments,id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email,' . $this->route('employee'),
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:255',
        ];
    }
}
