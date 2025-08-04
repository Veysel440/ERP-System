<?php

namespace App\Services;


use App\Repositories\FinanceTransactionRepository;
use App\Models\FinanceTransaction;

class FinanceTransactionService
{
    public function __construct(
        protected FinanceTransactionRepository $repository
    ) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): FinanceTransaction
    {
        return $this->repository->find($id);
    }

    public function create(array $data): FinanceTransaction
    {
        return $this->repository->create($data);
    }

    public function update(FinanceTransaction $transaction, array $data): FinanceTransaction
    {
        return $this->repository->update($transaction, $data);
    }

    public function delete(FinanceTransaction $transaction): bool
    {
        return $this->repository->delete($transaction);
    }
}
