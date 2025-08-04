<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FinanceTransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'type'            => $this->type,
            'amount'          => $this->amount,
            'description'     => $this->description,
            'transaction_date'=> $this->transaction_date,
            'user'            => new UserResource($this->whenLoaded('user')),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
        ];
    }
}
