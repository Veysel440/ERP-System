<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\SupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Services\SupplierService;

class SupplierController extends Controller
{
    public function __construct(protected SupplierService $service) {}

    public function index()
    {
        return SupplierResource::collection($this->service->list());
    }

    public function store(SupplierRequest $request)
    {
        $supplier = $this->service->create($request->validated());
        return new SupplierResource($supplier);
    }

    public function show(int $id)
    {
        $supplier = $this->service->show($id);
        return new SupplierResource($supplier);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier = $this->service->update($supplier, $request->validated());
        return new SupplierResource($supplier);
    }

    public function destroy(Supplier $supplier)
    {
        $this->service->delete($supplier);
        return response()->json(['message' => 'Supplier deleted.']);
    }
}
