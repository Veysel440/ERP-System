<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Purchase::class            => \App\Policies\PurchasePolicy::class,
        \App\Models\Employee::class            => \App\Policies\EmployeePolicy::class,
        \App\Models\Project::class             => \App\Policies\ProjectPolicy::class,
        \App\Models\FinanceTransaction::class  => \App\Policies\FinanceTransactionPolicy::class,
        \App\Models\Task::class                => \App\Policies\TaskPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        // Gerekirse Gate tanımları ekleyebilirsin.
    }
}
