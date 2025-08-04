<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'department_id' => $this->department_id,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'address'       => $this->address,
            'department'    => new DepartmentResource($this->whenLoaded('department')),
        ];
    }
}
