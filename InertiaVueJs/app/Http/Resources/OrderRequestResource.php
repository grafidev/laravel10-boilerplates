<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'user' => UserResource::make($this->user),
            'order_request_status' => OrderRequestStatusResource::make($this->order_request_status),
            'validation_states' => ValidationStateResource::collection($this->validation_states),
            'physical_articles' => PhysicalArticleResource::collection($this->physical_articles),
            'epins' => EpinResource::collection($this->epins),
            'free_moneys' => FreeMoneyResource::collection($this->free_moneys),
            'purchase_orders' => PurchaseOrderResource::collection($this->purchase_orders),
            'payment_supporting_documents' => PaymentSupportingDocumentResource::collection($this->payment_supporting_documents),
        ];
    }
}
