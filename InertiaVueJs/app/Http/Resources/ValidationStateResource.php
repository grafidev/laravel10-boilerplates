<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidationStateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'notice' => $this->notice,
            'comment' => $this->comment,
            'order_request_status' => OrderRequestStatusResource::make($this->order_request_status),
            'user' => UserResource::make($this->user),
            'validation_state_files' => ValidationStateFileResource::collection($this->validation_state_files),
            'created_at' => $this->created_at,
        ];
    }
}
