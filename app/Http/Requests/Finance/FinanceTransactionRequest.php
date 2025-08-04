<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class FinanceTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'            => 'required|in:income,expense',
            'amount'          => 'required|numeric|min:0',
            'description'     => 'nullable|string|max:255',
            'transaction_date'=> 'required|date',
            'user_id'         => 'required|exists:users,id',
        ];
    }
}
