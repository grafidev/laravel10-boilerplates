<?php

namespace App\Http\Resources;

use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
{
    protected $model = Station::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'region' => $this->region,
            'company' => $this->company,
            'company_id' => $this->company?->id,
            'manager' => $this->manager?->load('country', 'wallet', 'recharges'),
            'terminals' => TerminalResource::collection($this->terminals),
            'total_sales' => $this->totalSales(),
        ];
    }
}
