<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Notifications\TaskAssignedNotification;

class SendTaskAssignedNotification
{
    public function handle(TaskAssigned $event)
    {
        $assignedUser = $event->task->assignedUser;
        if ($assignedUser) {
            $assignedUser->notify(new TaskAssignedNotification($event->task));
        }
    }
}
