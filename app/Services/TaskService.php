<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Exception;

class TaskService
{
    public function __construct(protected TaskRepository $repository) {}

    public function list(array $filters = [], int $paginate = 15)
    {
        try {
            return $this->repository->filtered($filters, $paginate);
        } catch (Exception $e) {
            Log::error('TaskService::list error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show(int $id): Task
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            Log::error('TaskService::show error: ' . $e->getMessage(), ['task_id' => $id]);
            throw $e;
        }
    }

    public function create(array $data): Task
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            Log::error('TaskService::create error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Task $task, array $data): Task
    {
        try {
            return $this->repository->update($task, $data);
        } catch (Exception $e) {
            Log::error('TaskService::update error: ' . $e->getMessage(), ['task_id' => $task->id]);
            throw $e;
        }
    }

    public function delete(Task $task): bool
    {
        try {
            return $this->repository->delete($task);
        } catch (Exception $e) {
            Log::error('TaskService::delete error: ' . $e->getMessage(), ['task_id' => $task->id]);
            throw $e;
        }
    }
}
