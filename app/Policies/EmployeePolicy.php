<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'hr', 'manager']);
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->hasRole(['admin', 'hr', 'manager']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'hr']);
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->hasRole(['admin', 'hr']);
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->hasRole('admin');
    }
}
