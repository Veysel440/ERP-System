<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'supplier_id'  => $this->supplier_id,
            'product_id'   => $this->product_id,
            'quantity'     => $this->quantity,
            'total_price'  => $this->total_price,
            'purchase_date'=> $this->purchase_date,
            'supplier'     => new SupplierResource($this->whenLoaded('supplier')),
            'product'      => new ProductResource($this->whenLoaded('product')),
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
