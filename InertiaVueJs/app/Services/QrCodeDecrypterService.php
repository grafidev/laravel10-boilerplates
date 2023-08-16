<?php

namespace App\Services;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Resources\PurchaseOrderResource;
use App\Http\Resources\UserResource;
use App\Models\PurchaseOrder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class QrCodeDecrypterService
{
    use ApiResponse;

    public static function make(): self
    {
        return new self();
    }

    public function handle(string $decryptedQrCodeValue): JsonResponse
    {
        [$model, $code] = explode('|', $decryptedQrCodeValue);

        if ($model === 'user.wallet.account_number') {
            $user = User::query()
                ->whereRelation('wallet', 'account_number', $code)
                ->first();

            if ($user) {
                return $this->sendResponse("User's details found successfully :)", UserResource::make($user));
            }
        }

        if ($model === 'purchase_order.number') {
            $purchaseOrder = PurchaseOrder::query()
                ->available()
                ->where('number', $code)
                ->first();

            if ($purchaseOrder) {
                return $this->sendResponse('Purchase Order details found successfully :)', PurchaseOrderResource::make($purchaseOrder));
            }
        }

        if ($model === 'card_holder.card.number') {
            $user = User::query()
                ->role(Role::PORTEUR_CARTE)
                ->whereRelation('card', 'number', $code)
                ->first();

            if ($user) {
                return $this->sendResponse("Card holder's details found successfully :)", UserResource::make($user));
            }
        }

        return $this->sendResponse(':( no details found');
    }
}
