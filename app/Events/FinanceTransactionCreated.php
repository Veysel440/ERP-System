<?php

namespace App\Events;

use App\Models\FinanceTransaction;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FinanceTransactionCreated
{
    use Dispatchable, SerializesModels;

    public $transaction;
    public function __construct(FinanceTransaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
