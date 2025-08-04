<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use App\Models\Task;

class TaskService
{
    public function __construct(
        protected TaskRepository $repository
    ) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): Task
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Task
    {
        return $this->repository->create($data);
    }

    public function update(Task $task, array $data): Task
    {
        return $this->repository->update($task, $data);
    }

    public function delete(Task $task): bool
    {
        return $this->repository->delete($task);
    }
}
