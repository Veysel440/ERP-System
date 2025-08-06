<?php

namespace App\Services;

use App\Repositories\PurchaseRepository;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;
use Exception;

class PurchaseService
{
    public function __construct(protected PurchaseRepository $repository) {}

    public function list(int $paginate = 15)
    {
        try {
            return $this->repository->all($paginate);
        } catch (Exception $e) {
            Log::error('PurchaseService::list error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show(int $id): Purchase
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            Log::error('PurchaseService::show error: ' . $e->getMessage(), ['purchase_id' => $id]);
            throw $e;
        }
    }

    public function create(array $data): Purchase
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            Log::error('PurchaseService::create error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Purchase $purchase, array $data): Purchase
    {
        try {
            return $this->repository->update($purchase, $data);
        } catch (Exception $e) {
            Log::error('PurchaseService::update error: ' . $e->getMessage(), ['purchase_id' => $purchase->id]);
            throw $e;
        }
    }

    public function delete(Purchase $purchase): bool
    {
        try {
            return $this->repository->delete($purchase);
        } catch (Exception $e) {
            Log::error('PurchaseService::delete error: ' . $e->getMessage(), ['purchase_id' => $purchase->id]);
            throw $e;
        }
    }
}
