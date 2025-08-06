<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectService
{
    public function __construct(protected ProjectRepository $repository) {}

    public function list(int $paginate = 15)
    {
        try {
            return $this->repository->all($paginate);
        } catch (Exception $e) {
            Log::error('ProjectService::list error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show(int $id): Project
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            Log::error('ProjectService::show error: ' . $e->getMessage(), ['project_id' => $id]);
            throw $e;
        }
    }

    public function create(array $data): Project
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $e) {
            Log::error('ProjectService::create error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Project $project, array $data): Project
    {
        try {
            return $this->repository->update($project, $data);
        } catch (Exception $e) {
            Log::error('ProjectService::update error: ' . $e->getMessage(), ['project_id' => $project->id]);
            throw $e;
        }
    }

    public function delete(Project $project): bool
    {
        try {
            return $this->repository->delete($project);
        } catch (Exception $e) {
            Log::error('ProjectService::delete error: ' . $e->getMessage(), ['project_id' => $project->id]);
            throw $e;
        }
    }
}
