<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purchase;

class PurchasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'finance', 'manager']);
    }

    public function view(User $user, Purchase $purchase): bool
    {
        return $user->hasRole(['admin', 'finance', 'manager']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'finance']);
    }

    public function update(User $user, Purchase $purchase): bool
    {
        return $user->hasRole(['admin', 'finance']);
    }

    public function delete(User $user, Purchase $purchase): bool
    {
        return $user->hasRole('admin');
    }
}
