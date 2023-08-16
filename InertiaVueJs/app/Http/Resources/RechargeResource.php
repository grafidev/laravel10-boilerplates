<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RechargeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['user'] = $this->user;

        $data['rechargeStatus'] = $this->rechargeStatus;

        $data['validationHistories'] = $this->validationHistories()->with('user', 'fromStatus', 'toStatus')->latest()->get();

        return $data;
    }
}
