<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(protected DepartmentService $service) {}

    public function index()
    {
        return DepartmentResource::collection($this->service->list());
    }

    public function store(DepartmentRequest $request)
    {
        $department = $this->service->create($request->validated());
        return new DepartmentResource($department);
    }

    public function show(int $id)
    {
        $department = $this->service->show($id);
        return new DepartmentResource($department);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department = $this->service->update($department, $request->validated());
        return new DepartmentResource($department);
    }

    public function destroy(Department $department)
    {
        $this->service->delete($department);
        return response()->json(['message' => 'Supplier deleted.']);
    }
}
