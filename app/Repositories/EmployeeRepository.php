<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function all(int $paginate = 15)
    {
        return Employee::with('department')->paginate($paginate);
    }

    public function find(int $id): Employee
    {
        return Employee::with('department')->findOrFail($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(Employee $employee, array $data): Employee
    {
        $employee->update($data);
        return $employee;
    }

    public function delete(Employee $employee): bool
    {
        return $employee->delete();
    }
}
