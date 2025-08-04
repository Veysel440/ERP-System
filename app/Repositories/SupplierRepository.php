<?php

namespace App\Repositories;

use App\Models\Supplier;

class SupplierRepository
{
    public function all(int $paginate = 15)
    {
        return Supplier::paginate($paginate);
    }

    public function find(int $id): Supplier
    {
        return Supplier::findOrFail($id);
    }

    public function create(array $data): Supplier
    {
        return Supplier::create($data);
    }

    public function update(Supplier $supplier, array $data): Supplier
    {
        $supplier->update($data);
        return $supplier;
    }

    public function delete(Supplier $supplier): bool
    {
        return $supplier->delete();
    }
}
