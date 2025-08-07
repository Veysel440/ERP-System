<?php

namespace App\Observers;

use App\Models\Employee;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        AuditLog::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($employee),
            'model_id'   => $employee->id,
            'action'     => 'create',
            'changes'    => json_encode($employee->getAttributes()),
            'ip'         => request()->ip(),
        ]);
    }

    public function updated(Employee $employee)
    {
        $changes = $employee->getChanges();
        AuditLog::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($employee),
            'model_id'   => $employee->id,
            'action'     => 'update',
            'changes'    => json_encode($changes),
            'ip'         => request()->ip(),
        ]);
    }

    public function deleted(Employee $employee)
    {
        AuditLog::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($employee),
            'model_id'   => $employee->id,
            'action'     => 'delete',
            'changes'    => null,
            'ip'         => request()->ip(),
        ]);
    }

    public function restored(Employee $employee)
    {
        AuditLog::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($employee),
            'model_id'   => $employee->id,
            'action'     => 'restore',
            'changes'    => null,
            'ip'         => request()->ip(),
        ]);
    }

    public function forceDeleted(Employee $employee)
    {
        AuditLog::create([
            'user_id'    => Auth::id(),
            'model_type' => get_class($employee),
            'model_id'   => $employee->id,
            'action'     => 'forceDelete',
            'changes'    => null,
            'ip'         => request()->ip(),
        ]);
    }
}
