<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use App\Models\Employee;

class EmployeeService
{
    public function __construct(
        protected EmployeeRepository $repository
    ) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): Employee
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Employee
    {
        return $this->repository->create($data);
    }

    public function update(Employee $employee, array $data): Employee
    {
        return $this->repository->update($employee, $data);
    }

    public function delete(Employee $employee): bool
    {
        return $this->repository->delete($employee);
    }
}
