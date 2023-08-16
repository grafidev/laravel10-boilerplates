<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhysicalCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->user()->interactsWithApp()) {
            return [
                'id' => $this->id,
                'serial_number' => $this->serial_number,
                'crypted_token' => $this->crypted_token,
            ];
        }

        return [
            ...parent::toArray($request),
            'user' => $this->user?->loadMissing('country', 'station', 'wallet', 'roles'),
            'requesting_user' => $this->requesting_user?->loadMissing('country', 'station', 'wallet', 'roles'),
            'deactivated_by_user' => $this->deactivated_by_user?->loadMissing('country', 'station', 'wallet', 'roles'),
        ];
    }
}
