<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountriesForRegistrationResource extends JsonResource
{
    protected $model = Country::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'dialing_code' => $this->dialing_code,
            'name' => $this->name,
        ];
    }
}
