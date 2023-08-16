<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PurchaseOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        $data['corporate_client'] = CorporateClientResource::make($this->corporate_client);

        $data['qrcode'] = QrCode::size(300)->generate($this->number);

        $data['purchase_order_status'] = $this->purchase_order_status;

        return $data;
    }
}
