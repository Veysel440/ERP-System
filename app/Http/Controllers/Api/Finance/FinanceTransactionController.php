<?php

namespace App\Http\Controllers\Api\Finance;

use App\Events\FinanceTransactionCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\FinanceTransactionRequest;
use App\Http\Resources\FinanceTransactionResource;
use App\Models\FinanceTransaction;
use App\Services\FinanceTransactionService;
use Illuminate\Http\Request;

class FinanceTransactionController extends Controller
{
    public function __construct(protected FinanceTransactionService $service) {}

    public function index()
    {
        $this->authorize('viewAny', FinanceTransaction::class);
        try {
            return FinanceTransactionResource::collection($this->service->list());
        } catch (\Throwable $e) {
            \Log::error('FinanceTransactionController::index error: ' . $e->getMessage());
            return response()->json(['message' => 'List error'], 500);
        }
    }

    public function store(FinanceTransactionRequest $request)
    {
        $this->authorize('create', FinanceTransaction::class);
        try {
            $financeTransaction = $this->service->create($request->validated());
            $financeTransaction->load('user');
            event(new FinanceTransactionCreated($financeTransaction));
            return new FinanceTransactionResource($financeTransaction);
        } catch (\Throwable $e) {
            \Log::error('FinanceTransactionController::store error: ' . $e->getMessage());
            return response()->json(['message' => 'Create error'], 500);
        }
    }

    public function show(int $id)
    {
        $financeTransaction = $this->service->show($id);
        $this->authorize('view', $financeTransaction);
        $financeTransaction->load('user');
        return new FinanceTransactionResource($financeTransaction);
    }

    public function update(FinanceTransactionRequest $request, FinanceTransaction $financeTransaction)
    {
        $this->authorize('update', $financeTransaction);
        try {
            $financeTransaction = $this->service->update($financeTransaction, $request->validated());
            $financeTransaction->load('user');
            return new FinanceTransactionResource($financeTransaction);
        } catch (\Throwable $e) {
            \Log::error('FinanceTransactionController::update error: ' . $e->getMessage(), ['finance_transaction_id' => $financeTransaction->id]);
            return response()->json(['message' => 'Update error'], 500);
        }
    }

    public function destroy(FinanceTransaction $financeTransaction)
    {
        $this->authorize('delete', $financeTransaction);
        try {
            $this->service->delete($financeTransaction);
            return response()->json(['message' => 'Finance transaction deleted.']);
        } catch (\Throwable $e) {
            \Log::error('FinanceTransactionController::destroy error: ' . $e->getMessage(), ['finance_transaction_id' => $financeTransaction->id]);
            return response()->json(['message' => 'Delete error'], 500);
        }
    }
}
