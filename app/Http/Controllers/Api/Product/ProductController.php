<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return ProductResource::collection($this->service->list());
    }

    public function store(ProductRequest $request)
    {
        $product = $this->service->create($request->validated());
        return new ProductResource($product);
    }

    public function show($id)
    {
        $product = $this->service->show($id);
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = $this->service->update($product, $request->validated());
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return response()->json(['message' => 'Ürün silindi.']);
    }
}
