<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FidelityPointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->user()->hasRole(Role::CLIENT)) {
            return [
                'id' => $this->id,
                'points_required' => $this->points_required,
                'fidelity_value' => $this->fidelity_value,
                'active' => $this->active,
            ];
        }

        return parent::toArray($request);
    }
}
