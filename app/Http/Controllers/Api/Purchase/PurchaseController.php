<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;

class PurchaseController extends Controller
{
    public function __construct(
        protected PurchaseService $service
    ) {}

    public function index()
    {
        return PurchaseResource::collection($this->service->list());
    }

    public function store(PurchaseRequest $request)
    {
        $purchase = $this->service->create($request->validated());
        return new PurchaseResource($purchase);
    }

    public function show(int $id)
    {
        $purchase = $this->service->show($id);
        return new PurchaseResource($purchase);
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        $purchase = $this->service->update($purchase, $request->validated());
        return new PurchaseResource($purchase);
    }

    public function destroy(Purchase $purchase)
    {
        $this->service->delete($purchase);
        return response()->json(['message' => 'Purchase deleted.']);
    }
}
