<?php

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository
{
    public function all(int $paginate = 15)
    {
        return Department::paginate($paginate);
    }

    public function find(int $id): Department
    {
        return Department::findOrFail($id);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data): Department
    {
        $department->update($data);
        return $department;
    }

    public function delete(Department $department): bool
    {
        return $department->delete();
    }

}
