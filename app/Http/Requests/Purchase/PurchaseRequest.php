<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id'   => 'required|exists:suppliers,id',
            'product_id'    => 'required|exists:products,id',
            'quantity'      => 'required|integer|min:1',
            'total_price'   => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
        ];
    }
}
