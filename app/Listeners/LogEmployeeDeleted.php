<?php

namespace App\Listeners;

use App\Events\EmployeeDeleted;
use Illuminate\Support\Facades\Log;

class LogEmployeeDeleted
{
    public function handle(EmployeeDeleted $event)
    {
        Log::warning('Çalışan silindi.', [
            'employee_id' => $event->employee->id,
            'name'        => $event->employee->name,
            'deleted_by'  => auth()->id(),
            'deleted_at'  => now(),
        ]);
    }
}
