<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Exception;

class EmployeeService
{
    public function __construct(protected EmployeeRepository $repository) {}

    public function list(int $paginate = 15)
    {
        try {
            return $this->repository->all($paginate);
        } catch (Exception $e) {
            Log::error('EmployeeService::list error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show(int $id): Employee
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            Log::error('EmployeeService::show error: ' . $e->getMessage(), ['employee_id' => $id]);
            throw $e;
        }
    }

    public function create(array $data): Employee
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            Log::error('EmployeeService::create error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Employee $employee, array $data): Employee
    {
        try {
            return $this->repository->update($employee, $data);
        } catch (Exception $e) {
            Log::error('EmployeeService::update error: ' . $e->getMessage(), ['employee_id' => $employee->id]);
            throw $e;
        }
    }

    public function delete(Employee $employee): bool
    {
        try {
            return $this->repository->delete($employee);
        } catch (Exception $e) {
            Log::error('EmployeeService::delete error: ' . $e->getMessage(), ['employee_id' => $employee->id]);
            throw $e;
        }
    }
}
