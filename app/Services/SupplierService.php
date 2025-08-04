<?php

namespace App\Services;

use App\Repositories\SupplierRepository;
use App\Models\Supplier;

class SupplierService
{
    public function __construct(protected SupplierRepository $repository) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): Supplier
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Supplier
    {
        return $this->repository->create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        return $this->repository->update($supplier, $data);
    }

    public function delete(Supplier $supplier): bool
    {
        return $this->repository->delete($supplier);
    }
}
