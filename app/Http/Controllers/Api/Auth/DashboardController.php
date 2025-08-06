<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\FinanceTransaction;
use App\Models\Employee;
use App\Models\Project;

class DashboardController extends Controller
{
    public function summary()
    {
        return [
            'income'         => FinanceTransaction::where('type', 'income')->sum('amount'),
            'expense'        => FinanceTransaction::where('type', 'expense')->sum('amount'),
            'employee_count' => Employee::count(),
            'project_count'  => Project::count(),
        ];
    }
}
