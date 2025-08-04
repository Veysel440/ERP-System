<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'project_id'   => $this->project_id,
            'title'        => $this->title,
            'description'  => $this->description,
            'status'       => $this->status,
            'assigned_to'  => $this->assigned_to,
            'project'      => new ProjectResource($this->whenLoaded('project')),
            'assigned_user'=> new UserResource($this->whenLoaded('assignedUser')),
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
