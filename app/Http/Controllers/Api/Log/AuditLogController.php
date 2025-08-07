<?php

namespace App\Http\Controllers\Api\Log;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogResource;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate($request->get('per_page', 15));

        return AuditLogResource::collection($logs);
    }

    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);
        return new AuditLogResource($log);
    }
}
