<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $service
    ) {}

    public function index()
    {
        return TaskResource::collection($this->service->list());
    }

    public function store(TaskRequest $request)
    {
        $task = $this->service->create($request->validated());
        return new TaskResource($task);
    }

    public function show(int $id)
    {
        $task = $this->service->show($id);
        return new TaskResource($task);
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task = $this->service->update($task, $request->validated());
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        $this->service->delete($task);
        return response()->json(['message' => 'Task deleted.']);
    }
}
