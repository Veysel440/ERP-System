<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'  => 'required|string|max:255',
            'sku'   => 'required|string|max:100|unique:products,sku,' . $this->route('product'),
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }
}
