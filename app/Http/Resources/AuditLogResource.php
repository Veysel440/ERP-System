<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user'       => new UserResource($this->whenLoaded('user')),
            'model_type' => $this->model_type,
            'model_id'   => $this->model_id,
            'action'     => $this->action,
            'changes'    => $this->changes,
            'ip'         => $this->ip,
            'created_at' => $this->created_at,
        ];
    }
}
