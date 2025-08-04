<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Models\Project;

class ProjectService
{
    public function __construct(
        protected ProjectRepository $repository
    ) {}

    public function list(int $paginate = 15)
    {
        return $this->repository->all($paginate);
    }

    public function show(int $id): Project
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Project
    {
        return $this->repository->create($data);
    }

    public function update(Project $project, array $data): Project
    {
        return $this->repository->update($project, $data);
    }

    public function delete(Project $project): bool
    {
        return $this->repository->delete($project);
    }
}
