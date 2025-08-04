<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all($paginate = 15)
    {
        return Product::paginate($paginate);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }
}
