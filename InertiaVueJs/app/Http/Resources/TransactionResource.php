<?php

namespace App\Http\Resources;

use App\Models\TransactionStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (
            $request->user()->interactsWithApp()
        ) {
            return [
                'transaction_reference' => $this->transaction_reference,
                'amount' => $this->amount,
                'status' => $this->status,
                'failure_reason' => $this->failure_reason,
                'quantity' => $this->quantity,
                'created_at' => $this->created_at,
                'sender' => [
                    'name' => $this->sender->name,
                    'phone_number' => $this->sender->phone_number,
                ],
                'receiver' => [
                    'name' => $this->receiver->name,
                    'phone_number' => $this->receiver->phone_number,
                ],
                'transaction_type' => [
                    'name' => $this->transaction_type->name,
                ],
                'station' => [
                    'name' => $this->station?->name,
                    'region' => $this->station?->region,
                ],
                'product' => $this->product !== null ? [
                    'name' => $this->product->name,
                    'slug' => $this->product->slug,
                ] : null,
            ];
        }

        return [
            ...parent::toArray($request),
            'sender' => $this->sender->loadMissing('country', 'station', 'wallet', 'roles'),
            'receiver' => $this->receiver?->loadMissing('country', 'station', 'wallet', 'roles'),
            'transaction_type' => $this->transaction_type,
            'corporate_client' => $this->corporate_client,
            'station' => $this->station,
            'product' => $this->product,
            'status_label' => TransactionStatus::label($this->status),
            'status' => $this->status,
            'cancelled' => $this->isCancelled(),
        ];
    }
}
