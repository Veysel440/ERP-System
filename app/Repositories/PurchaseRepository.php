<?php

namespace App\Repositories;

use App\Models\Purchase;

class PurchaseRepository
{
    public function all(int $paginate = 15)
    {
        return Purchase::with(['supplier', 'product'])->paginate($paginate);
    }

    public function find(int $id): Purchase
    {
        return Purchase::with(['supplier', 'product'])->findOrFail($id);
    }

    public function create(array $data): Purchase
    {
        return Purchase::create($data);
    }

    public function update(Purchase $purchase, array $data): Purchase
    {
        $purchase->update($data);
        return $purchase;
    }

    public function delete(Purchase $purchase): bool
    {
        return $purchase->delete();
    }
}
