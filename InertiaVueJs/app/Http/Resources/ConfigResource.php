<?php

namespace App\Http\Resources;

use App\DTO\ConfigDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConfigResource extends JsonResource
{
    protected $model = ConfigDTO::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tax_rate' => $this->tax_rate,
        ];
        // return parent::toArray($request);
    }
}
