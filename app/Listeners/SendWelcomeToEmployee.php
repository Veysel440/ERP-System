<?php

namespace App\Listeners;

use App\Events\EmployeeCreated;
use App\Notifications\WelcomeEmployeeNotification;

class SendWelcomeToEmployee
{
    public function handle(EmployeeCreated $event): void
    {
        $event->employee->notify(new WelcomeEmployeeNotification());
    }
}
