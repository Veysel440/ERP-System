<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\DepartmentRepository;

class DepartmentService
{
    public function __construct(protected DepartmentRepository $repository) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): Department
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Department
    {
        return $this->repository->create($data);
    }

    public function update(Department $supplier, array $data): Department
    {
        return $this->repository->update($department, $data);
    }

    public function delete(Department $department): bool
    {
        return $this->repository->delete($department);
    }

}
