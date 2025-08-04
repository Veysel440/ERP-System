<?php

namespace App\Http\Controllers\Api\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\FinanceTransactionRequest;
use App\Http\Resources\FinanceTransactionResource;
use App\Models\FinanceTransaction;
use App\Services\FinanceTransactionService;

class FinanceTransactionController extends Controller
{
    public function __construct(
        protected FinanceTransactionService $service
    ) {}

    public function index()
    {
        return FinanceTransactionResource::collection($this->service->list());
    }

    public function store(FinanceTransactionRequest $request)
    {
        $transaction = $this->service->create($request->validated());
        return new FinanceTransactionResource($transaction);
    }

    public function show(int $id)
    {
        $transaction = $this->service->show($id);
        return new FinanceTransactionResource($transaction);
    }

    public function update(FinanceTransactionRequest $request, FinanceTransaction $financeTransaction)
    {
        $transaction = $this->service->update($financeTransaction, $request->validated());
        return new FinanceTransactionResource($transaction);
    }

    public function destroy(FinanceTransaction $financeTransaction)
    {
        $this->service->delete($financeTransaction);
        return response()->json(['message' => 'Finance transaction deleted.']);
    }
}
