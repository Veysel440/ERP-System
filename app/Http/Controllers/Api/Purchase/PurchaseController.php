<?php

namespace App\Http\Controllers\Api\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseRequest;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct(protected PurchaseService $service) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Purchase::class);
        try {
            return PurchaseResource::collection($this->service->list());
        } catch (\Throwable $e) {
            \Log::error('PurchaseController::index error: ' . $e->getMessage());
            return response()->json(['message' => 'List error'], 500);
        }
    }

    public function store(PurchaseRequest $request)
    {
        $this->authorize('create', Purchase::class);
        try {
            $purchase = $this->service->create($request->validated());
            $purchase->load(['supplier', 'product']);
            return new PurchaseResource($purchase);
        } catch (\Throwable $e) {
            \Log::error('PurchaseController::store error: ' . $e->getMessage());
            return response()->json(['message' => 'Create error'], 500);
        }
    }

    public function show(int $id)
    {
        $purchase = $this->service->show($id);
        $this->authorize('view', $purchase);
        $purchase->load(['supplier', 'product']);
        return new PurchaseResource($purchase);
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        $this->authorize('update', $purchase);
        try {
            $purchase = $this->service->update($purchase, $request->validated());
            $purchase->load(['supplier', 'product']);
            return new PurchaseResource($purchase);
        } catch (\Throwable $e) {
            \Log::error('PurchaseController::update error: ' . $e->getMessage(), ['purchase_id' => $purchase->id]);
            return response()->json(['message' => 'Update error'], 500);
        }
    }

    public function destroy(Purchase $purchase)
    {
        $this->authorize('delete', $purchase);
        try {
            $this->service->delete($purchase);
            return response()->json(['message' => 'Purchase deleted.']);
        } catch (\Throwable $e) {
            \Log::error('PurchaseController::destroy error: ' . $e->getMessage(), ['purchase_id' => $purchase->id]);
            return response()->json(['message' => 'Delete error'], 500);
        }
    }
}
