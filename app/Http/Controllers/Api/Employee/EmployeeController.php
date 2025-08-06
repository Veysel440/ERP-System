<?php

namespace App\Http\Controllers\Api\Employee;

use App\Events\EmployeeCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $service) {}

    public function index()
    {
        $this->authorize('viewAny', Employee::class);
        try {
            return EmployeeResource::collection($this->service->list());
        } catch (\Throwable $e) {
            \Log::error('EmployeeController::index error: ' . $e->getMessage());
            return response()->json(['message' => 'List error'], 500);
        }
    }

    public function store(EmployeeRequest $request)
    {
        $this->authorize('create', Employee::class);
        try {
            $employee = $this->service->create($request->validated());
            $employee->load('department');
            event(new EmployeeCreated($employee));
            return new EmployeeResource($employee);
        } catch (\Throwable $e) {
            \Log::error('EmployeeController::store error: ' . $e->getMessage());
            return response()->json(['message' => 'Create error'], 500);
        }
    }

    public function show(int $id)
    {
        $employee = $this->service->show($id);
        $this->authorize('view', $employee);
        $employee->load('department');
        return new EmployeeResource($employee);
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $this->authorize('update', $employee);
        try {
            $employee = $this->service->update($employee, $request->validated());
            $employee->load('department');
            return new EmployeeResource($employee);
        } catch (\Throwable $e) {
            \Log::error('EmployeeController::update error: ' . $e->getMessage(), ['employee_id' => $employee->id]);
            return response()->json(['message' => 'Update error'], 500);
        }
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);
        try {
            $this->service->delete($employee);
            return response()->json(['message' => 'Employee deleted.']);
        } catch (\Throwable $e) {
            \Log::error('EmployeeController::destroy error: ' . $e->getMessage(), ['employee_id' => $employee->id]);
            return response()->json(['message' => 'Delete error'], 500);
        }
    }
}
