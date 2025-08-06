<?php

namespace App\Services;

use App\Repositories\FinanceTransactionRepository;
use App\Models\FinanceTransaction;
use Illuminate\Support\Facades\Log;
use Exception;

class FinanceTransactionService
{
    public function __construct(protected FinanceTransactionRepository $repository) {}

    public function list(int $paginate = 15)
    {
        try {
            return $this->repository->all($paginate);
        } catch (Exception $e) {
            Log::error('FinanceTransactionService::list error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show(int $id): FinanceTransaction
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            Log::error('FinanceTransactionService::show error: ' . $e->getMessage(), ['finance_transaction_id' => $id]);
            throw $e;
        }
    }

    public function create(array $data): FinanceTransaction
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            Log::error('FinanceTransactionService::create error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(FinanceTransaction $financeTransaction, array $data): FinanceTransaction
    {
        try {
            return $this->repository->update($financeTransaction, $data);
        } catch (Exception $e) {
            Log::error('FinanceTransactionService::update error: ' . $e->getMessage(), ['finance_transaction_id' => $financeTransaction->id]);
            throw $e;
        }
    }

    public function delete(FinanceTransaction $financeTransaction): bool
    {
        try {
            return $this->repository->delete($financeTransaction);
        } catch (Exception $e) {
            Log::error('FinanceTransactionService::delete error: ' . $e->getMessage(), ['finance_transaction_id' => $financeTransaction->id]);
            throw $e;
        }
    }
}
