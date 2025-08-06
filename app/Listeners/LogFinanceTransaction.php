<?php

namespace App\Listeners;

use App\Events\FinanceTransactionCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFinanceTransaction
{
    public function handle(FinanceTransactionCreated $event)
    {
        \Log::info('Finance transaction created.', [
            'transaction_id' => $event->transaction->id,
            'user_id' => $event->transaction->user_id,
            'amount' => $event->transaction->amount,
            'type' => $event->transaction->type
        ]);
    }
}
