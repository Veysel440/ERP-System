<?php

namespace App\Services;


use App\Repositories\PurchaseRepository;
use App\Models\Purchase;

class PurchaseService
{
    public function __construct(
        protected PurchaseRepository $repository
    ) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): Purchase
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Purchase
    {
        return $this->repository->create($data);
    }

    public function update(Purchase $purchase, array $data): Purchase
    {
        return $this->repository->update($purchase, $data);
    }

    public function delete(Purchase $purchase): bool
    {
        return $this->repository->delete($purchase);
    }
}
