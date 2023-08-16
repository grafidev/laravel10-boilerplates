<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CancellationRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['transaction'] = TransactionResource::make($this->transaction);
        $data['country'] = CountryResource::make($this->country);
        $data['company'] = CompanyResource::make($this->company);
        $data['user'] = UserResource::make($this->user);
        $data['cancellation_request_status'] = CancellationRequestStatusResource::make($this->cancellation_request_status);

        return $data;
    }
}
