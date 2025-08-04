<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function all(int $paginate = 15)
    {
        return Task::with(['project', 'assignedUser'])->paginate($paginate);
    }

    public function find(int $id): Task
    {
        return Task::with(['project', 'assignedUser'])->findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }
}
