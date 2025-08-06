<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    public function all(int $paginate = 15)
    {
        return Project::with('tasks')->paginate($paginate);
    }

    public function find(int $id): Project
    {
        return Project::with('tasks')->findOrFail($id);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): Project
    {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project): bool
    {
        return $project->delete();
    }
}
