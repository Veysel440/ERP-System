<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FinanceTransaction;

class FinanceTransactionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'finance', 'manager']);
    }

    public function view(User $user, FinanceTransaction $financeTransaction): bool
    {
        return $user->hasRole(['admin', 'finance', 'manager']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'finance']);
    }

    public function update(User $user, FinanceTransaction $financeTransaction): bool
    {
        return $user->hasRole(['admin', 'finance']);
    }

    public function delete(User $user, FinanceTransaction $financeTransaction): bool
    {
        return $user->hasRole('admin');
    }
}
