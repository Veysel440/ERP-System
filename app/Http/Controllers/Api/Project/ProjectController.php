<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $service
    ) {}

    public function index()
    {
        return ProjectResource::collection($this->service->list());
    }

    public function store(ProjectRequest $request)
    {
        $project = $this->service->create($request->validated());
        return new ProjectResource($project);
    }

    public function show(int $id)
    {
        $project = $this->service->show($id);
        return new ProjectResource($project);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $project = $this->service->update($project, $request->validated());
        return new ProjectResource($project);
    }

    public function destroy(Project $project)
    {
        $this->service->delete($project);
        return response()->json(['message' => 'Project deleted.']);
    }
}
