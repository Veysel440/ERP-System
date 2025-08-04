<?php

namespace App\Http\Controllers\Api\Employee;


use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $service
    ) {}

    public function index()
    {
        return EmployeeResource::collection($this->service->list());
    }

    public function store(EmployeeRequest $request)
    {
        $employee = $this->service->create($request->validated());
        return new EmployeeResource($employee);
    }

    public function show(int $id)
    {
        $employee = $this->service->show($id);
        return new EmployeeResource($employee);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee = $this->service->update($employee, $request->validated());
        return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee)
    {
        $this->service->delete($employee);
        return response()->json(['message' => 'Employee deleted.']);
    }
}
