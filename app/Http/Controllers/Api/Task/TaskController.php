<?php

namespace App\Http\Controllers\Api\Task;

use App\Events\TaskAssigned;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Task::class);
        try {
            $filters = $request->only(['status', 'assigned_to', 'project_id', 'from_date', 'to_date']);
            return TaskResource::collection($this->service->list($filters));
        } catch (\Throwable $e) {
            \Log::error('TaskController::index error: ' . $e->getMessage());
            return response()->json(['message' => 'List error'], 500);
        }
    }

    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);
        try {
            $task = $this->service->create($request->validated());
            $task->load(['project', 'assignedUser']);

            if ($task->assigned_to) {
                event(new TaskAssigned($task));
            }

            return new TaskResource($task);
        } catch (\Throwable $e) {
            \Log::error('TaskController::store error: ' . $e->getMessage());
            return response()->json(['message' => 'Create error'], 500);
        }
    }

    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        try {
            $previousAssigned = $task->assigned_to;

            $task = $this->service->update($task, $request->validated());
            $task->load(['project', 'assignedUser']);

            if ($task->assigned_to && $task->assigned_to !== $previousAssigned) {
                event(new TaskAssigned($task));
            }

            return new TaskResource($task);
        } catch (\Throwable $e) {
            \Log::error('TaskController::update error: ' . $e->getMessage(), ['task_id' => $task->id]);
            return response()->json(['message' => 'Update error'], 500);
        }
    }

    public function show(int $id)
    {
        $task = $this->service->show($id);
        $this->authorize('view', $task);
        $task->load(['project', 'assignedUser']);
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        try {
            $this->service->delete($task);
            return response()->json(['message' => 'Task deleted.']);
        } catch (\Throwable $e) {
            \Log::error('TaskController::destroy error: ' . $e->getMessage(), ['task_id' => $task->id]);
            return response()->json(['message' => 'Delete error'], 500);
        }
    }
}
