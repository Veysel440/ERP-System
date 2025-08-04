<?php

namespace App\Repositories;

use App\Models\FinanceTransaction;

class FinanceTransactionRepository
{
    public function all(int $paginate = 15)
    {
        return FinanceTransaction::with('user')->paginate($paginate);
    }

    public function find(int $id): FinanceTransaction
    {
        return FinanceTransaction::with('user')->findOrFail($id);
    }

    public function create(array $data): FinanceTransaction
    {
        return FinanceTransaction::create($data);
    }

    public function update(FinanceTransaction $transaction, array $data): FinanceTransaction
    {
        $transaction->update($data);
        return $transaction;
    }

    public function delete(FinanceTransaction $transaction): bool
    {
        return $transaction->delete();
    }
}
