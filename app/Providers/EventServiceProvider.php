<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \App\Events\EmployeeCreated::class => [
            \App\Listeners\SendWelcomeToEmployee::class,
        ],
        \App\Events\FinanceTransactionCreated::class => [
            \App\Listeners\LogFinanceTransaction::class,
        ],
        \App\Events\TaskAssigned::class => [
            \App\Listeners\SendTaskAssignedNotification::class,
        ],
        \App\Events\EmployeeDeleted::class => [
            \App\Listeners\LogEmployeeDeleted::class,
        ],
        \App\Events\UserRegistered::class => [
            \App\Listeners\LogUserRegistration::class,
        ],
        \App\Events\ProductOutOfStock::class => [
            \App\Listeners\NotifyAdminsProductOutOfStock::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
