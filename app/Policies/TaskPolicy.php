<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'manager', 'employee']);
    }

    public function view(User $user, Task $task): bool
    {
        return $user->hasRole(['admin', 'manager', 'employee']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function update(User $user, Task $task): bool
    {
        return $user->hasRole(['admin', 'manager']) || $user->id === $task->assigned_to;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }
}
