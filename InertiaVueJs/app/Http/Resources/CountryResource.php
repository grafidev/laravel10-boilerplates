<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->user()?->interactsWithApp()) {
            return [
                'code' => $this->code,
                'name' => $this->name,
                'dialing_code' => $this->dialing_code,
            ];
        }

        $data = parent::toArray($request);

        $data['companies_list'] = $this->companies_list;

        return $data;
    }
}
