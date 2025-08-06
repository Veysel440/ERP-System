<?php

namespace App\Policies;


use App\Models\User;
use App\Models\Project;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'manager', 'employee']);
    }

    public function view(User $user, Project $project): bool
    {
        return $user->hasRole(['admin', 'manager', 'employee']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function update(User $user, Project $project): bool
    {
        return $user->hasRole(['admin', 'manager']);
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->hasRole('admin');
    }
}
