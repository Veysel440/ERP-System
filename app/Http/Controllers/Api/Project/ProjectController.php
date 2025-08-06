<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $service) {}

    public function index()
    {
        $this->authorize('viewAny', Project::class);
        try {
            return ProjectResource::collection($this->service->list());
        } catch (\Throwable $e) {
            \Log::error('ProjectController::index error: ' . $e->getMessage());
            return response()->json(['message' => 'List error'], 500);
        }
    }

    public function store(ProjectRequest $request)
    {
        $this->authorize('create', Project::class);
        try {
            $project = $this->service->create($request->validated());
            $project->load('tasks');
            return new ProjectResource($project);
        } catch (\Throwable $e) {
            \Log::error('ProjectController::store error: ' . $e->getMessage());
            return response()->json(['message' => 'Create error'], 500);
        }
    }

    public function show(int $id)
    {
        $project = $this->service->show($id);
        $this->authorize('view', $project);
        $project->load('tasks');
        return new ProjectResource($project);
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        try {
            $project = $this->service->update($project, $request->validated());
            $project->load('tasks');
            return new ProjectResource($project);
        } catch (\Throwable $e) {
            \Log::error('ProjectController::update error: ' . $e->getMessage(), ['project_id' => $project->id]);
            return response()->json(['message' => 'Update error'], 500);
        }
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        try {
            $this->service->delete($project);
            return response()->json(['message' => 'Project deleted.']);
        } catch (\Throwable $e) {
            \Log::error('ProjectController::destroy error: ' . $e->getMessage(), ['project_id' => $project->id]);
            return response()->json(['message' => 'Delete error'], 500);
        }
    }
}
