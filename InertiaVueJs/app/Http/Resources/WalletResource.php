<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'number' => $this->number,
            'balance' => $this->balance,
            'account_number' => $this->account_number,
            'is_blocked' => $this->is_blocked,
            'crypted_account_number' => $this->crypted_account_number,
        ];

        if ($request->user()->interactsWithApp()) {
            unset($data['id']);
            unset($data['account_number']);
        }

        return $data;
    }
}
